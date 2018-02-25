<template>
    <form @submit.prevent="redirectToSearch" v-click-outside="clearResults">
        <div class="form-group autocomplete">
            <input type="text" v-model="query" @keyup.esc="clearResults()" @click="fetchResults()" class="form-control" placeholder="Search your collection" style="width:350px;">
            <ul v-if="results.length > 0" class="list-group autocomplete-results">
                <li v-for="release in results" class="list-group-item">
                    <div class="row">
                        <div class="col-sm-3">
                            <img class="img-responsive" :src="release.thumbnail">
                        </div>
                        <div class="col-sm-9">
                            <strong>{{ release.title }}</strong> <br/>
                            {{ release.artists_display }} <br/>
                            <button type="button" class="btn btn-xs btn-default" @click="putOnDeck(release)">
                                <i class="fa fa-plus-circle"></i> On Deck
                            </button>
                            <button type="button" class="btn btn-xs btn-primary" @click="spin(release)">
                                <i class="fa fa-thumbs-o-up"></i> Spin
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </form>
</template>
<script>
    import collection from '../../api/collection';
    import { mapState, mapActions } from 'vuex';
    import ClickOutside from 'vue-click-outside';

    export default {
        data() {
            return {
                query: '',
                results: [],
                minCharacters: 3,
                pageSize: 10
            }
        },
        watch: {
            query(newQuery, oldQuery) {
                this.fetchResults();
            }
        },
        methods: {
            resolved() {
                this.clearResults();
                this.query = '';
            },
            clearResults() {
                this.results.splice(0, this.results.length);
            },
            fetchResults() {
                if(this.query.length >= parseInt(this.minCharacters)) {
                    collection.getReleases(this.user.username, 'all', 1, this.query, 'artists_display,asc', this.pageSize, response => {
                        this.clearResults();
                        this.results = response.body.data;
                    });
                }
                else {
                    this.clearResults();
                }
            },
            redirectToSearch() {
                this.$router.push({
                    name: 'shelf',
                    params: { username: this.user.username, shelf: 'all' },
                    query: { query: this.query }
                });
                this.resolved();
            },
            ...mapActions({
                spin: 'spin',
                putOnDeck: 'onDeck'
            })
        },
        computed: {
            ...mapState(['user'])
        },
        directives: {
            ClickOutside
        }
    }
</script>