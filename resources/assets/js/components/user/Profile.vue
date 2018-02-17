<template>
    <div id="profile">
        <div class="row" v-if="user">
            <div class="col-md-4">
                <div class="thumbnail">
                    <img :src="user.avatar">
                    <div class="caption">
                        <p><strong>{{ user.username }}</strong></p>
                        <button v-if="!following" @click="follow" type="button" class="btn btn-default btn-block" :disabled="followDisabled"><i class="fa fa-user-plus"></i> Follow</button>
                        <button v-else @click="unfollow" type="button" class="btn btn-default btn-block" :disabled="followDisabled"><i class="fa fa-user-times"></i> Unfollow</button>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <now-spinning :user="user" :release="user.now_spinning"></now-spinning>
                Profile stuff
            </div>
        </div>

    </div>
</template>
<script>
    import NowSpinning from './Now-Spinning';
    import users from '../../api/users';
    import { mapState, mapMutations } from 'vuex';

    export default {
        components: {'now-spinning': NowSpinning },
        props: ['username'],
        data() {
            return {
                uname: this.username,
                user: null
            }
        },
        mounted() {
            this.fetchUser();
        },
        beforeRouteUpdate(to, from, next) {
            // this is necessary because vue tries to reuse the same component since its the same route, just different params
            this.uname = to.params.username;
            this.fetchUser().then(response => next());
        },
        methods: {
            fetchUser() {
                return users.getUserByUsername(this.uname, response => this.user = response.body);
            },
            // todo - the bottom two method should probably be vuex actions
            follow() {
                users.follow(this.uname, response => this.addFriend(this.user));
            },
            unfollow() {
                users.unfollow(this.uname, response => this.removeFriend(this.user));
            },
            ...mapMutations([
                'addFriend',
                'removeFriend'
            ])
        },
        computed: {
            ...mapState({
                currentUser: 'user',
                friends: 'friends'
            }),
            followDisabled() {
                return this.user.username == this.currentUser.username;
            },
            following() {
                return this.friends.find(friend => friend.id == this.user.id) != null;
            }
        }
    }
</script>
<style>
    #profile {
        margin-top: 22px;
    }
</style>