import { useState, useEffect } from 'react';
import { getUserWorkouts, addWorkout } from '../../api/workouts';
import WorkoutForm from '../../components/Workouts/Form';

export default function UserWorkouts() {
    const [workouts, setWorkouts] = useState([]);

    useEffect(() => {
        getUserWorkouts().then(res => setWorkouts(res.data));
    }, []);

    return (
        <div className="user-workouts">
            <h1>Your Workouts</h1>
            <WorkoutForm onSubmit={addWorkout} />
            <ul>
                {workouts.map(workout => (
                    <li key={workout.id}>
                        {workout.exercise.name} - {workout.sets}x{workout.reps}
                    </li>
                ))}
            </ul>
        </div>
    );
}
