import BlogPost from '../components/BlogPost';

// Mock blog data
const posts = [
    {
        id: 1,
        title: 'Getting Started with React in 2023',
        content: 'React continues to be one of the most popular frontend frameworks. In this post, we cover the basics of getting started with React in the current year...',
        author: 'Jane Smith',
        date: 'May 5, 2023',
        readTime: '5 min read'
    },
    {
        id: 2,
        title: 'Best Practices for UI Design',
        content: 'Creating intuitive and beautiful user interfaces requires following certain best practices. Here are our top 10 tips for designing better UIs...',
        author: 'John Doe',
        date: 'April 22, 2023',
        readTime: '8 min read'
    },
    {
        id: 3,
        title: 'The Future of Web Development',
        content: 'As technology evolves, web development continues to change rapidly. We explore the emerging trends that will shape the future of building for the web...',
        author: 'Alice Johnson',
        date: 'April 10, 2023',
        readTime: '6 min read'
    },
];

function Blog() {
    return (
        <div className="container mx-auto px-4 py-8">
            <h1 className="text-3xl font-bold mb-8">Our Blog</h1>

            <div className="space-y-8">
                {posts.map(post => (
                    <BlogPost
                        key={post.id}
                        title={post.title}
                        content={post.content}
                        author={post.author}
                        date={post.date}
                        readTime={post.readTime}
                    />
                ))}
            </div>
        </div>
    );
}

export default Blog;
