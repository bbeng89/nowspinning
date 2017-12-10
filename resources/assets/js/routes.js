import App from './App.vue'
import NewsFeed from './components/news/News-Feed.vue';
import UserShelves from './components/shelf/User-Shelves.vue';
import Shelf from './components/shelf/Shelf.vue';

export default [
    {
        path: '/app', component: App, name: 'home', children: [
            { path: '/', component: NewsFeed, name: 'news-feed' },
            { path: ':username/shelves', component: UserShelves, name: 'shelves' },
            { path: ':username/shelves/:shelf', component: Shelf, name: 'shelf' }
        ]
    }
]