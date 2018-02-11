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

    </div>
</template>

<script>
    import Autocomplete from '../global/Autocomplete';
    import users from '../../api/users';

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
        }
    }
</script>