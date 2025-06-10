function Home() {
    return (
        <div className="container mx-auto px-4 py-8">
            <section className="mb-12">
                <div className="bg-gray-100 rounded-lg p-8 text-center">
                    <h1 className="text-4xl font-bold mb-4">Welcome to Our Website</h1>
                    <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                        Discover amazing features, connect with our community, and stay updated with the latest news.
                    </p>
                    <button className="mt-6 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        Get Started
                    </button>
                </div>
            </section>

            <section className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h2 className="text-2xl font-semibold mb-3">Our Users</h2>
                    <p className="text-gray-600 mb-4">Meet our diverse community of users from around the world.</p>
                    <a href="/frontend/src/pages/Users" className="text-blue-600 hover:underline">View Users →</a>
                </div>

                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h2 className="text-2xl font-semibold mb-3">Latest News</h2>
                    <p className="text-gray-600 mb-4">Stay updated with our company news and announcements.</p>
                    <a href="/news" className="text-blue-600 hover:underline">Read News →</a>
                </div>

                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h2 className="text-2xl font-semibold mb-3">Our Blog</h2>
                    <p className="text-gray-600 mb-4">Read interesting articles and insights from our team.</p>
                    <a href="/blog" className="text-blue-600 hover:underline">Visit Blog →</a>
                </div>
            </section>
        </div>
    );
}

export default Home;
