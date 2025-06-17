function NewsCard({ title, excerpt, date, category }) {
    return (
        <div className="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div className="flex justify-between items-start mb-2">
                <span className="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{category}</span>
                <span className="text-gray-500 text-sm">{date}</span>
            </div>
            <h3 className="text-xl font-semibold mb-3">{title}</h3>
            <p className="text-gray-700 mb-4">{excerpt}</p>
            <button className="text-blue-600 hover:underline">Read More →</button>
        </div>
    );
}

export default NewsCard;
