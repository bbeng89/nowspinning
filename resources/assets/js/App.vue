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
    import CurrentUser from './components/user/Current-User.vue';
    import FriendFeed from './components/friends/Friend-Feed.vue';
    import NowSpinning from "./components/user/Now-Spinning";

    export default {
        components: {
            NowSpinning,
            CurrentUser,
            FriendFeed,
            NowSpinning
        },
        created(){
            // todo: i don't really like initializing here because the other components rely on these store values and this is async
            this.initializeUser().then(response => {
                if(response.body.now_spinning_id != null) {
                    this.initializeNowSpinning(response.body.now_spinning_id)
                }
            });
        },
        methods: {
            initializeUser() {
                return this.$http.get('/api/user').then(response => {
                    this.$store.commit('user', response.body)
                    return response
                })
            },
            initializeNowSpinning(releaseId) {
                return this.$http.get('/api/collection/release/' + releaseId).then(response => {
                    this.$store.commit('spin', response.body)
                    return response
                })
            }
        }
    }
</script>