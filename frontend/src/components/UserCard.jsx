function UserCard({ name, email, avatar, role }) {
    return (
        <div className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <div className="p-6">
                <div className="flex items-center mb-4">
                    <img src={avatar} alt={name} className="w-16 h-16 rounded-full mr-4" />
                    <div>
                        <h3 className="font-semibold text-lg">{name}</h3>
                        <p className="text-gray-600 text-sm">{role}</p>
                    </div>
                </div>
                <p className="text-gray-700 mb-2"><span className="font-medium">Email:</span> {email}</p>
                <button className="mt-3 w-full bg-blue-100 text-blue-700 py-2 rounded hover:bg-blue-200 transition">
                    View Profile
                </button>
            </div>
        </div>
    );
}

export default UserCard;
