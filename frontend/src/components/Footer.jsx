function Footer() {
    return (
        <footer className="bg-gray-800 text-white py-8">
            <div className="container mx-auto px-4">
                <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 className="text-lg font-semibold mb-4">About Us</h3>
                        <p className="text-gray-400">We are a leading company in providing innovative solutions to our customers worldwide.</p>
                    </div>

                    <div>
                        <h3 className="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul className="space-y-2 text-gray-400">
                            <li><a href="#" className="hover:text-white">Home</a></li>
                            <li><a href="#" className="hover:text-white">Services</a></li>
                            <li><a href="#" className="hover:text-white">Products</a></li>
                            <li><a href="#" className="hover:text-white">Contact</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 className="text-lg font-semibold mb-4">Contact Info</h3>
                        <address className="text-gray-400 not-italic">
                            <p>123 Business Ave</p>
                            <p>New York, NY 10001</p>
                            <p>Phone: (555) 123-4567</p>
                            <p>Email: info@company.com</p>
                        </address>
                    </div>

                    <div>
                        <h3 className="text-lg font-semibold mb-4">Newsletter</h3>
                        <p className="text-gray-400 mb-2">Subscribe to our newsletter for updates.</p>
                        <div className="flex">
                            <input type="email" placeholder="Your email" className="px-3 py-2 text-gray-800 rounded-l flex-grow" />
                            <button className="bg-blue-600 px-4 py-2 rounded-r">Subscribe</button>
                        </div>
                    </div>
                </div>

                <div className="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                    <p>© {new Date().getFullYear()} CompanyName. All rights reserved.</p>
                </div>
            </div>
        </footer>
    );
}

export default Footer;
