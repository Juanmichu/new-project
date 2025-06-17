import UserCard from '../components/UserCard';

// Mock user data
const users = [
    { id: 1, name: 'John Doe', email: 'john@example.com', avatar: 'https://i.pravatar.cc/150?img=1', role: 'Developer' },
    { id: 2, name: 'Jane Smith', email: 'jane@example.com', avatar: 'https://i.pravatar.cc/150?img=2', role: 'Designer' },
    { id: 3, name: 'Bob Johnson', email: 'bob@example.com', avatar: 'https://i.pravatar.cc/150?img=3', role: 'Manager' },
    { id: 4, name: 'Alice Williams', email: 'alice@example.com', avatar: 'https://i.pravatar.cc/150?img=4', role: 'Content Writer' },
    { id: 5, name: 'Charlie Brown', email: 'charlie@example.com', avatar: 'https://i.pravatar.cc/150?img=5', role: 'Marketing' },
    { id: 6, name: 'Eve Davis', email: 'eve@example.com', avatar: 'https://i.pravatar.cc/150?img=6', role: 'Support' },
];

function Users() {
    return (
        <div className="container mx-auto px-4 py-8">
            <h1 className="text-3xl font-bold mb-8">Our Users</h1>

            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {users.map(user => (
                    <UserCard
                        key={user.id}
                        name={user.name}
                        email={user.email}
                        avatar={user.avatar}
                        role={user.role}
                    />
                ))}
            </div>
        </div>
    );
}

export default Users;
