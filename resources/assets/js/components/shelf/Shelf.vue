<template>
    <div class="shelf">
        <div class="text-center">
            <h1>{{ shelfNameDisplay }}</h1>
            <h2 v-if="loading"><i class="fa fa-spinner fa-spin"></i></h2>
            <h2 v-else class="text-muted"><em>{{ count }} Items</em></h2>
        </div>

        <release-list-item v-for="release in releases"
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
                loading: true
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
            }
        }
    }
</script>