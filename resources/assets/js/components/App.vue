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
                </div>
                <div id="navbar" class="collapse navbar-collapse navbar-right">
                    <p class="navbar-text" v-if="syncing"><i class="fa fa-refresh fa-spin"></i></p>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ user.username }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><router-link :to="{ name: 'edit-profile' }">Edit Profile</router-link></li>
                                <li><a href="javascript:void(0)" @click="sync" :disabled="syncing">Sync Collection</a></li>
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
                <div class="col-md-3">
                    <current-user></current-user>
                    <hr/>
                    <now-spinning :user="user" :release="nowSpinning"></now-spinning>
                    <hr/>
                    <on-deck></on-deck>
                </div>
                <div class="col-md-6">
                    <router-view></router-view>
                </div>
                <div class="col-md-3">
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
            OnDeck
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
                if(user.first_login)
                {
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
                else
                {
                    store.commit('spin', user.now_spinning);
                    collection.getReleases(user.username, 'on-deck', 1, null, 'date_added,asc', (response) => {
                        store.commit('onDeck', response.body.data);
                        next();
                    })
                }
            });
        },
        methods: {
            sync() {
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