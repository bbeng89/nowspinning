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
                    <ul class="nav navbar-nav">
                        <li><p class="navbar-text">Welcome, username</p></li>
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <current-user></current-user>
                    <hr/>
                    <now-spinning v-if="$store.state.nowSpinning"></now-spinning>
                    <hr/>
                    <on-deck></on-deck>
                </div>
                <div class="col-md-6">
                    <router-view></router-view>
                </div>
                <div class="col-md-3">
                    <friend-feed></friend-feed>
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
    import api from '../api';
    import store from '../store';

    export default {
        components: {
            NowSpinning,
            CurrentUser,
            FriendFeed,
            NowSpinning,
            OnDeck
        },
        beforeRouteEnter(to, from, next){
            api.getUser(response => {
                let user = response.body
                store.commit('user', user)
                store.commit('spin', user.now_spinning)
                api.getReleases(user.username, 'on-deck', (response) => {
                    store.commit('onDeck', response.body)
                    next()
                })
            });
        }
    }
</script>