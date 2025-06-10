import NewsCard from '../components/NewsCard';

// Mock news data
const news = [
    {
        id: 1,
        title: 'Company Announces New Product Line',
        excerpt: 'Our company is excited to announce a new suite of products that will revolutionize the industry...',
        date: 'May 15, 2023',
        category: 'Company News'
    },
    {
        id: 2,
        title: 'Partnership with Tech Giant',
        excerpt: 'We are proud to announce our new partnership with a leading technology company to deliver...',
        date: 'April 28, 2023',
        category: 'Partnerships'
    },
    {
        id: 3,
        title: 'Quarterly Report Shows Strong Growth',
        excerpt: 'Our Q1 financial results show record growth and expansion into three new markets...',
        date: 'April 10, 2023',
        category: 'Financial'
    },
];

function News() {
    return (
        <div className="container mx-auto px-4 py-8">
            <h1 className="text-3xl font-bold mb-8">Latest News</h1>

            <div className="space-y-6">
                {news.map(item => (
                    <NewsCard
                        key={item.id}
                        title={item.title}
                        excerpt={item.excerpt}
                        date={item.date}
                        category={item.category}
                    />
                ))}
            </div>
        </div>
    );
}

export default News;
