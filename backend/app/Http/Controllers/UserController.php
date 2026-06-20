<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkoutExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Coach-facing (admin only) management of client/coach accounts.
 *
 * Server-rendered Blade CRUD, mirroring {@see ExerciseController}. Access is
 * restricted to admins via the 'admin' middleware on the routes (see web.php).
 */
class UserController extends Controller
{
    /** Roles a user can be assigned. */
    private const ROLES = [User::USER_ROL, User::ADMIN_ROL];

    /**
     * List users with optional search / role / status filters.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        if ($request->filled('is_active') && $request->input('is_active') !== 'all') {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $roles = self::ROLES;

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the create-user form.
     */
    public function create()
    {
        $roles = self::ROLES;

        return view('users.create', compact('roles'));
    }

    /**
     * Persist a new user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:' . implode(',', self::ROLES),
            'is_active' => 'nullable|boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Show the edit-user form.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404, 'Usuario no encontrado');
        }

        $roles = self::ROLES;

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update an existing user. Password is only changed when provided.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404, 'Usuario no encontrado');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',_id',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:' . implode(',', self::ROLES),
            'is_active' => 'nullable|boolean',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->is_active = $request->boolean('is_active');

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Delete a user (and their workouts), preventing self-deletion.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404, 'Usuario no encontrado');
        }

        if ($user->_id === auth()->user()->_id) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta');
        }

        // Remove the user's workouts and their exercise rows.
        foreach ($user->workouts as $workout) {
            WorkoutExercise::where('workout_id', $workout->_id)->delete();
            $workout->delete();
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}
