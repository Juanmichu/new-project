import { getAllWorkouts } from '../../api/workouts';

export default function AdminDashboard() {
    const [workouts, setWorkouts] = useState([]);

    useEffect(() => {
        getAllWorkouts().then(res => setWorkouts(res.data));
    }, []);

    return (
        <div>
            <h1>All Users' Workouts</h1>
            <table>
                <thead>
                <tr>
                    <th>User</th>
                    <th>Exercise</th>
                    <th>Sets x Reps</th>
                </tr>
                </thead>
                <tbody>
                {workouts.map(workout => (
                    <tr key={workout.id}>
                        <td>{workout.user.name}</td>
                        <td>{workout.exercise.name}</td>
                        <td>{workout.sets}x{workout.reps}</td>
                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    );
}
