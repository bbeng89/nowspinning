import Vue from 'vue'
import VueRouter from "vue-router"
import App from '../App.vue'
import NewsFeed from '../components/news/News-Feed.vue';
import UserShelves from '../components/shelf/User-Shelves.vue';
import Shelf from '../components/shelf/Shelf.vue';

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/app', component: App, children: [
                { path: '/', component: NewsFeed, name: 'news-feed' },
                { path: ':username/shelves', component: UserShelves, name: 'shelves' },
                { path: ':username/shelves/:shelf', component: Shelf, name: 'shelf' }
            ]
        }
    ]
})