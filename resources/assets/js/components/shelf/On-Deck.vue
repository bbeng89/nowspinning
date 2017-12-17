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
                    </div>
                    <div class="col-sm-8">
                        <strong>{{ release.title }}</strong> <br/>
                        {{ artistDisplay(release) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import api from '../../api'
    import { mapState } from 'vuex'

    export default {
        computed: {
            ...mapState({
                releases: 'onDeck'
            })
        },
        methods: {
            artistDisplay(release) {
                return release.artists.map(a => a.name).join(', ')
            },
        }
    }
</script>