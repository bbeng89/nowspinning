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
                        <li><p class="navbar-text">Welcome, {{ user.username }}</p></li>
                        <li><router-link :to="{ name: 'oauth-settings' }">Admin</router-link></li>
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container-fluid" id="admin-content">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <router-view></router-view>
                </div>
            </div>
        </div><!-- /.container -->
    </div>
</template>
<script>
    import { mapState } from 'vuex';
    import users from '../api/users';
    import store from '../store';

    export default {
        metaInfo: {
            titleTemplate: (titleChunk) => {
                return titleChunk ? `${titleChunk} :: NowSpinning Admin` : 'NowSpinning Admin';
            }
        },
        beforeRouteEnter(to, from, next){
            users.getUser(response => {
                store.commit('user', response.body);
                next();
            });
        },
        computed: {
            ...mapState([
                'user'
            ])
        }
    }
</script>

<style>
    #admin-content {
        margin-top: 20px;
    }
</style>