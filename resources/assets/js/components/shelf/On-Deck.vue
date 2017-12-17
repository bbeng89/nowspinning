<template>
    <div>
        <h4 class="text-center">On Deck</h4>
        <p v-if="releases.length == 0" class="text-center">
            <em>You don't have anything on deck!<br/> Browse your shelves and find something to spin.</em>
        </p>
        <div v-for="release in releases" class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <img class="img-responsive" :src="release.thumbnail">
                        <div class="btn-group on-deck-actions" role="group" aria-label="...">
                            <button type="button" @click="offDeck(release)" class="btn btn-xs btn-danger"><i class="fa fa-times-circle"></i></button>
                            <button type="button" @click="spinRelease(release)" class="btn btn-xs btn-primary"><i class="fa fa-thumbs-up"></i> Spin</button>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <strong>{{ release.title }}</strong> <br/>
                        {{ release.artists_display }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import api from '../../api'
    import { mapState, mapActions } from 'vuex'

    export default {
        computed: {
            ...mapState({
                releases: 'onDeck'
            })
        },
        methods: {
            spinRelease(release) {
                this.offDeck(release)
                this.spin(release)
            },
            ...mapActions([
                'offDeck',
                'spin'
            ])
        }
    }
</script>

<style>
    .on-deck-actions{
        margin-top: 10px
    }
</style>