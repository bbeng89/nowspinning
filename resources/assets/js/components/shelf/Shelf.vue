<template>
    <div class="shelf">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h1 class="panel-title clearfix">
                    <span class="pull-left">{{ shelfNameDisplay }}</span>
                    <span class="pull-right" v-if="loading"><i class="fa fa-spinner fa-spin"></i></span>
                    <span class="pull-right" v-else><em>{{ count }} Items</em></span>
                </h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9">
                        <form @submit.prevent="fetchReleases(true)">
                            <div class="form-group">
                                <input v-model="search" type="text" class="form-control" placeholder="What are you looking for?">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" v-model="sort">
                            <option value="artists_display,asc">Artist A-Z</option>
                            <option value="artists_display,desc">Artist Z-A</option>
                            <option value="date_added,desc">Newest</option>
                            <option value="date_added,asc">Oldest</option>
                            <option value="listen_count,desc">Most Listened</option>
                            <option value="listen_count,asc">Least Listened</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div v-infinite-scroll="loadMore" infinite-scroll-disabled="loading" infinite-scroll-distance="20">
            <release-list-item v-for="release in releases"
                               :key="release.id"
                               :release="release"
                               :enable-actions="true">
            </release-list-item>
        </div>
        <h2 class="text-center" v-if="loading"><i class="fa fa-spinner fa-spin"></i></h2>
    </div>
</template>

<script>
    import ReleaseListItem from './Release-List-Item.vue';
    import collection from '../../api/collection'

    export default {
        components: { 'release-list-item': ReleaseListItem },
        props: ['username', 'shelf', 'query'],
        metaInfo() {
            return {
                title: `${this.shelfNameDisplay} Shelf`
            }
        },
        data() {
            return {
                releases: [],
                loading: true,
                sort: 'date_added,desc',
                search: this.query,
                currentPage: 1,
                lastPage: null,
                count : 0
            }
        },
        mounted() {
            this.fetchReleases();
        },
        watch: {
            sort() {
                this.fetchReleases(true);
            },
            '$route.query.query'(newQuery, oldQuery) {
                this.search = newQuery;
                this.fetchReleases(true);
            },
            '$route.params.shelf'(newShelf, oldShelf) {
                this.shelf = newShelf;
                this.fetchReleases(true);
            }
        },
        methods: {
            loadMore() {
                if(this.currentPage == this.lastPage) return;
                this.currentPage++;
                this.fetchReleases();
            },
            fetchReleases(clear = false) {
                this.loading = true;
                collection.getReleases(this.username, this.shelf, this.currentPage, this.search, this.sort, null, response => {
                    if(clear){
                        this.releases = [];
                    }
                    this.count = response.body.total;
                    this.currentPage = response.body.current_page;
                    this.lastPage = response.body.last_page;

                    for(let release of response.body.data) {
                        this.releases.push(release);
                    }

                    this.loading = false;
                })
            }
        },
        computed: {
            shelfNameDisplay() {
                // todo refactor this
                if(this.shelf == 'vinyl') return 'Vinyl';
                else if(this.shelf == 'cassette') return 'Cassette';
                else if(this.shelf == 'cd') return 'Compact Disc';
                else if(this.shelf == 'all') return 'All';
                return this.shelf;
            }
        }
    }
</script>

<style>
    .shelf {
        margin-top:25px;
    }
</style>