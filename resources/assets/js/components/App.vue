<template>
    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">NowSpinning</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <router-link :to="{ name: 'news-feed' }" class="navbar-brand logo-text">NowSpinning</router-link>
                    <ul class="nav navbar-nav">
                        <li><router-link :to="{ name: 'news-feed' }">News Feed</router-link></li>
                        <li><router-link :to="{ name: 'shelves', params: { username: user.username }}">My Collection</router-link></li>
                    </ul>
                </div>
                <div id="navbar" class="collapse navbar-collapse navbar-right">
                    <main-search class="navbar-form navbar-left"></main-search>
                    <p class="navbar-text" v-if="syncing"><i class="fa fa-refresh fa-spin"></i></p>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ user.username }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><router-link :to="{ name: 'edit-profile' }">Edit Profile</router-link></li>
                                <li><a href="javascript:void(0)" @click="sync">{{ syncing ? 'Syncing...' : 'Sync Collection'}}</a></li>
                                <li><router-link :to="{ name: 'oauth-settings' }">Admin</router-link></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div id="col-left" class="col-lg-3" style="padding-top: 22px;">
                    <now-spinning :user="user" :release="nowSpinning"></now-spinning>
                    <hr/>
                    <on-deck></on-deck>
                </div>
                <div id="col-middle" class="col-lg-6 col-lg-offset-3">
                    <router-view></router-view>
                </div>
                <div id="col-right" class="col-lg-3 col-lg-offset-9">
                    <current-user></current-user>
                    <hr/>
                    <friend-feed></friend-feed>
                    <notifications position="bottom right"></notifications>
                </div>
            </div>
        </div><!-- /.container -->
    </div>
</template>
<script>
    import CurrentUser from './user/Current-User.vue';
    import FriendFeed from './friends/Friend-Feed.vue';
    import NowSpinning from "./user/Now-Spinning";
    import OnDeck from './shelf/On-Deck.vue';
    import MainSearch from './global/Main-Search';
    import users from '../api/users';
    import collection from '../api/collection';
    import store from '../store';
    import { mapState } from 'vuex';

    export default {
        components: {
            NowSpinning,
            CurrentUser,
            FriendFeed,
            NowSpinning,
            OnDeck,
            MainSearch
        },
        metaInfo: {
            titleTemplate: (titleChunk) => {
                return titleChunk ? `${titleChunk} :: NowSpinning` : 'NowSpinning';
            }
        },
        data() {
            return {
                syncing: false
            }
        },
        beforeRouteEnter(to, from, next){
            users.getUser(response => {
                let user = response.body;
                store.commit('user', user);
                if(user.first_login) {
                    next(vm => {
                        vm.$notify({
                            title: 'Syncing with Discogs',
                            text: 'Your collection is currently syncing with Discogs. Please fill out your profile while we build your collection',
                            duration: 6000
                        });
                        users.unsetFirstLogin();
                        vm.sync();
                        next({ name: 'edit-profile' });
                    });
                }
                else {
                    store.commit('spin', user.now_spinning);
                    collection.getReleases(user.username, 'on-deck', 1, null, 'date_added,asc', null, (response) => {
                        store.commit('onDeck', response.body.data);
                        next();
                    });
                    users.friends(user.username, response => store.commit('friends', response.body));
                }
            });
        },
        methods: {
            sync() {
                if(this.syncing) return;

                this.syncing = true;
                users.sync(response => {
                    this.syncing = false;
                    this.$notify({
                        title: 'Discogs Sync Complete',
                        text: 'Your collection is now synced with Discogs',
                        type: 'success'
                    });
                });
            }
        },
        computed: {
            ...mapState([
                'user',
                'nowSpinning'
            ])
        }
    }
</script>