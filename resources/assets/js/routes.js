import App from './App.vue'
import NewsFeed from './components/news/News-Feed.vue';
import Shelf from './components/shelf/Shelf.vue';

export default [
    {
        path: '/app',
        component: App,
        children: [
            { path: '/', component: NewsFeed, name: 'news-feed' },
            { path: ':username/shelf', component: Shelf, name: 'shelf' }
        ]
    }
]