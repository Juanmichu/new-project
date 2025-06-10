import { Link } from 'react-router-dom';

function Header() {
    return (
        <header className="bg-blue-600 text-white shadow-md">
            <div className="container mx-auto px-4 py-4">
                <div className="flex justify-between items-center">
                    <h1 className="text-2xl font-bold">
                        <Link to="/">CompanyName</Link>
                    </h1>
                    <nav>
                        <ul className="flex space-x-6">
                            <li><Link to="/" className="hover:underline">Home</Link></li>
                            <li><Link to="/users" className="hover:underline">Users</Link></li>
                            <li><Link to="/news" className="hover:underline">News</Link></li>
                            <li><Link to="/blog" className="hover:underline">Blog</Link></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
    );
}

export default Header;
