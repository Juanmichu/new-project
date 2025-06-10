function BlogPost({ title, content, author, date, readTime }) {
    return (
        <article className="bg-white rounded-lg shadow-md overflow-hidden">
            <div className="p-6">
                <div className="flex justify-between items-center mb-2">
                    <span className="text-gray-500 text-sm">{date}</span>
                    <span className="text-gray-500 text-sm">{readTime}</span>
                </div>
                <h2 className="text-2xl font-bold mb-3">{title}</h2>
                <p className="text-gray-700 mb-4">{content}</p>
                <div className="flex justify-between items-center">
                    <span className="text-gray-600">By {author}</span>
                    <button className="text-blue-600 hover:underline">Continue Reading →</button>
                </div>
            </div>
        </article>
    );
}

export default BlogPost;
