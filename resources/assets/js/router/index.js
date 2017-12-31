import Vue from 'vue';
import VueRouter from "vue-router";
import App from '../components/App';
import Admin from '../components/Admin';
import NewsFeed from '../components/news/News-Feed';
import UserShelves from '../components/shelf/User-Shelves';
import Shelf from '../components/shelf/Shelf';
import EditProfile from '../components/user/Edit-Profile';
import OauthSettings from '../components/admin/oauth/Oauth-Settings';

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/app', component: App, children: [
                { path: '/', component: NewsFeed, name: 'news-feed' },
                { path: ':username/shelves', component: UserShelves, name: 'shelves' },
                { path: ':username/shelves/:shelf', component: Shelf, name: 'shelf' },
                { path: 'profile/edit', component: EditProfile, name: 'edit-profile' }
            ]
        },
        {
            path: '/admin', component: Admin, children: [
                { path: 'oauth', component: OauthSettings, name: 'oauth-settings' }
            ]
        }
    ]
})