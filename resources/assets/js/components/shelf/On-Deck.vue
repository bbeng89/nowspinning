<template>
    <div>
        <h4 class="text-center">On Deck</h4>
        <p v-if="releases.length == 0" class="text-center">
            <em>You don't have anything on deck!<br/> Browse your shelves and find something to spin.</em>
        </p>
        <div v-for="release in releases" class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <img class="img-responsive" :src="release.thumbnail">
                        <!-- Split button -->
                        <div class="btn-group on-deck-actions">
                            <button type="button" @click="spinRelease(release)" class="btn btn-xs btn-primary">Spin</button>
                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" @click="offDeck(release)">Remove</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <strong>{{ release.title }}</strong> <br/>
                        {{ release.artists_display }} <br/>
                        <span v-for="format in formats(release)" class="label label-default" style="margin-right: 5px">
                            {{ format }}
                        </span>
                        <span class="text-muted">Listens: {{ release.listen_count }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        computed: {
            ...mapState({
                releases: 'onDeck'
            })
        },
        methods: {
            spinRelease(release) {
                this.offDeck(release).then(() => this.spin(release));
            },
            formats(release) {
                return release.shelves
                    .filter(shelf => shelf.handle != 'on-deck')
                    .map(shelf => shelf.name);
            },
            ...mapActions([
                'offDeck',
                'spin'
            ])
        },
    }
</script>

<style>
    .on-deck-actions{
        margin-top: 10px
    }
</style>