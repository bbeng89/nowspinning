<template>
    <div id="current-user" class="text-center">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h3>{{ user.username }}</h3>
                <img :src="user.avatar" class="img-responsive img-circle">
            </div>
        </div>
        <p><router-link class="btn btn-default" :to="{ name: 'shelves', params: { username: user.username }}">My Shelves</router-link></p>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        computed: {
            ...mapState({
                user: 'user'
            })
        }
    }
</script>

<style>
    #current-user .btn-default {
        margin-top:20px;
    }
</style>