<template>
    <div id="current-user" class="text-center">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <img :src="user.avatar" class="img-responsive img-circle user-avatar">
            </div>
        </div>
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
    .user-avatar {
        margin-top: 22px;
    }
</style>