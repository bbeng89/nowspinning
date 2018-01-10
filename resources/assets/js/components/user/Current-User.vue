<template>
    <div id="current-user" class="text-center">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <img :src="user.avatar" class="img-responsive img-circle user-avatar">
            </div>
        </div>
        <div>
            <router-link class="btn btn-default" :to="{ name: 'shelves', params: { username: user.username }}">My Shelves</router-link>
            <router-link class="btn btn-default" :to="{ name: 'edit-profile' }">Edit Profile</router-link>
        </div>
        <div class="text-center">
            <button type="button" @click="sync" class="btn btn-default" :disabled="syncing"><i class="fa fa-refresh" :class="{ 'fa-spin': syncing }"></i> Sync Collection</button>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import users from '../../api/users';

    export default {
        data() {
            return {
                syncing: false
            }
        },
        methods: {
            sync() {
                this.syncing = true;
                users.sync(response => this.syncing = false);
            }
        },
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