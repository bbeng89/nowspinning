<template>
    <div class="friend-feed">
        <h3>Friends</h3>

        <autocomplete ref="userSearch"
                      @search="searchUsers"
                      @result-clicked="userSearchClicked"
                      placeholder="Search for friends"
                      min-characters="3"
                      :items="searchResults">
        </autocomplete>

        <div v-if="friends.length > 0" class="list-group">
            <router-link class="list-group-item"
                         :to="{ name: 'user-profile', params: { username: friend.username }}"
                         v-for="friend in friends"
                         :key="friend.id">
                <h4 class="list-group-item-heading"><img style="height:20px" class="img-circle" :src="friend.avatar"> {{ friend.username }}</h4>
                <small v-if="friend.now_spinning" class="list-group-item-text"><i class="fa fa-volume-up"></i> {{ friend.now_spinning.title }} by {{ friend.now_spinning.artists_display }}</small>
            </router-link>
        </div>

    </div>
</template>

<script>
    import Autocomplete from '../global/Autocomplete';
    import users from '../../api/users';
    import { mapState } from 'vuex';

    export default {
        components: {
            'autocomplete': Autocomplete
        },
        data() {
            return {
                searchResults: []
            }
        },
        methods: {
            searchUsers(query) {
                users.search(query, response => {
                    this.clearSearchResults();
                    for(let user of response.body.data) {
                        this.searchResults.push({
                            id: user.id,
                            username: user.username,
                            text: `@${user.username}`
                        });
                    }
                });
            },
            userSearchClicked(user) {
                this.$refs.userSearch.resolved();
                this.$router.push({ name: 'user-profile', params: { username: user.username }});
            },
            clearSearchResults() {
                this.searchResults.splice(0, this.searchResults.length);
            }
        },
        computed: {
            ...mapState(['friends'])
        }
    }
</script>