<template>
    <div id="user-shelves" class="text-center">
        <h1>Shelves</h1>
        <hr/>
        <div class="row">
            <div class="col-sm-12">
                <router-link :to="{ name: 'shelf', params: {username: username, shelf: 'vinyl'}}">
                    <div class="shelf-preview">
                        <img src="/img/shelves/vinyl.jpg" class="img-responsive">
                        <div class="overlay">
                            <div class="overlay-content">
                                <h2>Vinyl</h2>
                                <p v-if="loading"><i class="fa fa-spinner fa-spin"></i></p>
                                <p v-else>{{ label(vinylCount) }}</p>
                            </div>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <router-link :to="{ name: 'shelf', params: {username: username, shelf: 'cassette'}}">
                    <div class="shelf-preview">
                        <img src="/img/shelves/cassette.jpg" class="img-responsive">
                        <div class="overlay">
                            <div class="overlay-content">
                                <h2>Cassettes</h2>
                                <p v-if="loading"><i class="fa fa-spinner fa-spin"></i></p>
                                <p v-else>{{ label(cassetteCount) }}</p>
                            </div>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <router-link :to="{ name: 'shelf', params: {username: username, shelf: 'cd'}}">
                    <div class="shelf-preview">
                        <img src="/img/shelves/cd.jpg" class="img-responsive">
                        <div class="overlay">
                            <div class="overlay-content">
                                <h2>CDs</h2>
                                <p v-if="loading"><i class="fa fa-spinner fa-spin"></i></p>
                                <p v-else>{{ label(cdCount) }}</p>
                            </div>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import collection from '../../api/collection'

    export default {
        metaInfo: {
            title: 'My Shelves'
        },
        data() {
            return {
                username: '',
                vinylCount: 0,
                cassetteCount: 0,
                cdCount: 0,
                loading: true
            }
        },
        mounted() {
            this.username = this.$route.params.username;
            collection.getShelfCounts(this.username, response => {
                this.vinylCount = response.body.vinyl
                this.cassetteCount = response.body.cassette
                this.cdCount = response.body.cd
                this.loading = false
            })
        },
        methods: {
            label(count) {
                return count + ' ' + (count == 1 ? 'Release' : 'Releases');
            }
        }
    }
</script>

<style>
    .shelf-preview {
        position: relative !important;
        margin-bottom: 10px;
    }

    .shelf-preview > .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        transition: .5s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
    }

    .shelf-preview > .overlay:hover {
         background-color: rgba(0, 0, 0, 0.7);
     }

    .shelf-preview > .overlay > .overlay-content {
        color: white;
        text-align:center;
        display:flex;
        align-items: center;
        flex-direction: column;
        padding: 10px;
    }
</style>