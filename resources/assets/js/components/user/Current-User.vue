<template>
    <div id="current-user" class="text-center">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h3>{{ username }}</h3>
                <img :src="avatar" class="img-responsive img-circle">
            </div>
        </div>
        <p><router-link :to="{ name: 'shelf', params: { username: username }}">My Shelf</router-link></p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                id: '',
                discogs_id: '',
                username: '',
                name: '',
                email: '',
                avatar: '',
            }
        },
        mounted() {
            this.fetchUser();
        },
        methods: {
            fetchUser() {
                return this.$http.get('/api/user').then(response => {
                    var user = response.body;
                    this.id = user.id;
                    this.discogs_id = user.discogs_id;
                    this.username = user.username;
                    this.name = user.name;
                    this.email = user.email;
                    this.avatar = user.avatar;
                });
            }
        }
    }
</script>