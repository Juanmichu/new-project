<?php

namespace App\Http\Controllers;

use App\Http\Constants\Exercises as ExerciseConstants;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use App\Models\WorkoutExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Coach-facing (admin only) workout management.
 *
 * A coach (admin) creates workouts from existing exercises and assigns each to
 * a single client. The coach is recorded as `coach_id`; the assigned client as
 * `user_id`. A coach only sees/edits/deletes the workouts they created.
 *
 * This is the server-rendered (Blade) counterpart to the client-facing
 * {@see \App\Http\Controllers\Api\WorkoutController}, which the React app uses.
 * Access is restricted to admins via the 'admin' middleware (see web.php).
 */
class WorkoutController extends Controller
{
    /**
     * List the workouts created by the current coach.
     */
    public function index(Request $request)
    {
        $workouts = Workout::where('coach_id', $request->user()->_id)
            ->with(['user', 'exercises.exercise'])
            ->orderBy('workout_date', 'desc')
            ->paginate(10);

        return view('workouts.index', compact('workouts'));
    }

    /**
     * Show the create-workout form.
     */
    public function create()
    {
        return view('workouts.create', $this->formData());
    }

    /**
     * Persist a new workout and its exercises.
     */
    public function store(Request $request)
    {
        $validated = $this->validateWorkout($request);

        $workout = Workout::create([
            'coach_id'          => $request->user()->_id,
            'user_id'           => $validated['user_id'],
            'name'              => $validated['name'],
            'description'       => $validated['description'] ?? '',
            'workout_date'      => $validated['workout_date'],
            'total_duration'    => $validated['total_duration'] ?? 0,
            'calories_burned'   => $validated['calories_burned'] ?? 0,
            'difficulty_level'  => $validated['difficulty_level'] ?? '',
            'notes'             => $validated['notes'] ?? '',
            'status'            => 'planned',
        ]);

        $this->syncExercises($workout, $validated['exercises']);

        return redirect()->route('workouts.index')
            ->with('success', 'Workout creado exitosamente');
    }

    /**
     * Show the edit-workout form (scoped to the current coach).
     */
    public function edit(Request $request, string $id)
    {
        $workout = $this->findOwnedWorkout($request, $id);

        return view('workouts.edit', array_merge($this->formData(), compact('workout')));
    }

    /**
     * Update a workout and replace its exercise list.
     */
    public function update(Request $request, string $id)
    {
        $workout                = $this->findOwnedWorkout($request, $id);
        $prevWorkoutExercises   = WorkoutExercise::where('workout_id', $workout->_id)->get();

        $validated = $this->validateWorkout($request);

        $workout->update([
            'user_id'           => $validated['user_id'],
            'name'              => $validated['name'],
            'description'       => $validated['description'] ?? '',
            'workout_date'      => $validated['workout_date'],
            'total_duration'    => $validated['total_duration'] ?? '',
            'calories_burned'   => $validated['calories_burned'] ?? '',
            'difficulty_level'  => $validated['difficulty_level'] ?? '',
            'notes'             => $validated['notes'] ?? '',
        ]);

        //Add to validated workout exercises previous fields for 'notes' and 'completed'
        foreach ($prevWorkoutExercises as $prevWorkoutExercise) {
            foreach($validated['exercises'] as $index => $validatedExercise) {
                $validated['exercises'][$index]['notes'] = $prevWorkoutExercise->notes;
                $validated['exercises'][$index]['completed'] = $prevWorkoutExercise->completed;
            }
        }

        // Replace the exercise list wholesale for this workout id.
        WorkoutExercise::where('workout_id', $workout->_id)->delete();
        $this->syncExercises($workout, $validated['exercises']);

        return redirect()->route('workouts.index')
            ->with('success', 'Workout actualizado exitosamente');
    }

    /**
     * Delete a workout and its exercises (scoped to the current coach).
     */
    public function destroy(Request $request, string $id)
    {
        $workout = $this->findOwnedWorkout($request, $id);

        WorkoutExercise::where('workout_id', $workout->_id)->delete();
        $workout->delete();

        return redirect()->route('workouts.index')
            ->with('success', 'Workout eliminado exitosamente');
    }

    /**
     * Fetch a workout owned by the current coach or abort with 404.
     */
    private function findOwnedWorkout(Request $request, string $id): Workout
    {
        $workout = Workout::where('coach_id', $request->user()->_id)
            ->where('_id', $id)
            ->with(['exercises'])
            ->first();

        if (!$workout) {
            abort(404, 'Workout no encontrado');
        }

        return $workout;
    }

    /**
     * Shared data for the create/edit forms: assignable clients, the exercise
     * library and the difficulty levels.
     */
    private function formData(): array
    {
        return [
            'clients' => User::where('role', User::USER_ROL)->orderBy('name')->get(),
            'exercises' => Exercise::orderBy('name')->get(),
            'difficulties' => ExerciseConstants::DIFFICULTY_LEVELS,
        ];
    }

    /**
     * Validate a workout request, including its nested exercises.
     *
     * Reference existence (assignee, exercises) is checked manually in an
     * `after` hook rather than via the `exists` rule, which is unreliable
     * against MongoDB ObjectId `_id` values.
     */
    private function validateWorkout(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'user_id'                   => 'required|string',
            'name'                      => 'required|string|max:255',
            'description'               => 'nullable|string',
            'workout_date'              => 'required|date',
            'total_duration'            => 'required|integer|min:0',
            'calories_burned'           => 'required|integer|min:0',
            'difficulty_level'          => 'required|in:' . implode(',', ExerciseConstants::DIFFICULTY_LEVELS),
            'notes'                     => 'nullable|string',
            'exercises'                 => 'required|array|min:1',
            'exercises.*.exercise_id'   => 'required|string',
            'exercises.*.sets'          => 'required|integer|min:1',
            'exercises.*.reps'          => 'required|integer|min:1',
            'exercises.*.rest_time'     => 'required|integer|min:0',
            'exercises.*.weight'        => 'nullable|numeric|min:0',
            'exercises.*.duration'      => 'nullable|integer|min:0',
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->filled('user_id')
                && User::where('_id', $request->input('user_id'))->where('role', User::USER_ROL)->doesntExist()) {
                $validator->errors()->add('user_id', 'The selected client is invalid.');
            }

            $ids = collect($request->input('exercises', []))
                ->pluck('exercise_id')->filter()->unique()->values()->all();
            if (!empty($ids)) {
                $found = Exercise::whereIn('_id', $ids)->count();
                if ($found < count($ids)) {
                    $validator->errors()->add('exercises', 'One or more selected exercises are invalid.');
                }
            }
        });

        return $validator->validate();
    }

    /**
     * Create WorkoutExercise rows for a workout from validated exercise data.
     * It is developed both for creation and editing existing workout.
     * In case there is an edition, take into account to delete previous workout exercise related rows
     */
    private function syncExercises(Workout $workout, array $exercises): void
    {
        foreach (array_values($exercises) as $index => $data) {

            $exerciseInstructions = Exercise::where('id', $data['exercise_id'])
                                        ->pluck('instructions')
                                        ->flatten()
                                        ->filter()
                                        ->unique()
                                        ->values()
                                        ->all();

            WorkoutExercise::create([
                'workout_id'    => $workout->_id,
                'exercise_id'   => $data['exercise_id'],
                'sets'          => $data['sets'],
                'reps'          => $data['reps'],
                'rest_time'     => $data['rest_time'] ?? 60,
                'weight'        => $data['weight'] ?? 0,
                'duration'      => $data['duration'] ?? 0,
                'order'         => $index + 1,
                'notes'         => !empty($exerciseInstructions) ? implode(', ', $exerciseInstructions) : '',
                'completed'     => $data['completed'] ?? false,
            ]);
        }
    }
}
