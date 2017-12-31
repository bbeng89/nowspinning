<template>
    <div id="current-user" class="text-center">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <img :src="user.avatar" class="img-responsive img-circle user-avatar">
            </div>
        </div>
        <p>
            <router-link class="btn btn-default" :to="{ name: 'shelves', params: { username: user.username }}">My Shelves</router-link>
            <router-link class="btn btn-default" :to="{ name: 'edit-profile' }">Edit Profile</router-link>
        </p>
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
    .user-avatar {
        margin-top: 22px;
    }
</style>