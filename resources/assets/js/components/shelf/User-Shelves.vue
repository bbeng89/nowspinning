<template>
    <div id="user-shelves" class="text-center">
        <h1>Shelves</h1>
        <hr/>
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Vinyl</span>
                    </div>
                    <div class="panel-body">
                        <p>{{ vinylCount }} Releases</p>
                        <router-link class="btn btn-default" :to="{ name: 'shelf', params: {username: username, shelf: 'vinyl'}}">
                            View Shelf
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Cassette</span>
                    </div>
                    <div class="panel-body">
                        <p>{{ cassetteCount }} Releases</p>
                        <router-link class="btn btn-default" :to="{ name: 'shelf', params: {username: username, shelf: 'cassette'}}">
                            View Shelf
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Compact Disc</span>
                    </div>
                    <div class="panel-body">
                        <p>{{ cdCount }} Releases</p>
                        <router-link class="btn btn-default" :to="{ name: 'shelf', params: {username: username, shelf: 'cd'}}">
                            View Shelf
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import api from '../../api'
    export default {
        data() {
            return {
                username: '',
                vinylCount: 0,
                cassetteCount: 0,
                cdCount: 0
            }
        },
        mounted() {
            this.username = this.$route.params.username;
            api.getCounts(this.username, response => {
                this.vinylCount = response.body.vinyl
                this.cassetteCount = response.body.cassette
                this.cdCount = response.body.cd
            })
        }
    }
</script>