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
                        <div class="form-group">
                            <input v-model="search" type="text" class="form-control" placeholder="What are you looking for?">
                        </div>
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

        <h2 class="text-center" v-if="loading"><i class="fa fa-spinner fa-spin"></i></h2>

        <release-list-item v-for="release in releasesSorted"
                           :key="release.id"
                           :release="release"
                           :enable-actions="true">
        </release-list-item>
    </div>
</template>

<script>
    import ReleaseListItem from './Release-List-Item.vue';
    import api from '../../api'

    export default {
        components: { 'release-list-item': ReleaseListItem },
        data() {
            return {
                username: '',
                shelfName: '',
                releases: [],
                loading: true,
                sort: 'date_added,desc',
                search: ''
            }
        },
        mounted() {
            this.username = this.$route.params.username;
            this.shelfName = this.$route.params.shelf;
            api.getReleases(this.username, this.shelfName, response => {
                this.releases = response.body;
                this.loading = false;
            })
        },
        computed: {
            shelfNameDisplay() {
                if(this.shelfName == 'vinyl') return 'Vinyl';
                else if(this.shelfName == 'cassette') return 'Cassette';
                else if(this.shelfName == 'cd') return 'Compact Disc';
                return this.shelfName;
            },
            count() {
                return this.releases.length;
            },
            releasesSorted() {
                let [sort,dir] = this.sort.split(',')
                let filtered = _.orderBy(this.releases, r => r[sort], [dir]);
                if(this.search !== '' && this.search !== null && this.search.length > 2)
                {
                    filtered = _.filter(filtered, release => {
                        return release.artists_display.toLowerCase().includes(this.search.toLowerCase()) ||
                            release.title.toLowerCase().includes(this.search.toLowerCase());
                    })
                }
                return filtered;
            }
        }
    }
</script>

<style>
    .shelf {
        margin-top:25px;
    }
</style>