<template>
    <div class="panel release-list-item">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <img class="img-responsive" :src="release.thumbnail">
                </div>
                <div class="col-sm-8">
                    <strong>{{ release.title }}</strong> <br/>
                    {{ artistDisplay }}
                    <div v-if="enableActions">
                        <hr/>
                        <button class="btn btn-default" type="button"><i class="fa fa-plus-circle"></i> On Deck</button>
                        <button class="btn btn-primary" type="button" @click="spin(release)"><i class="fa fa-thumbs-o-up"></i> Spin Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions } from 'vuex'

    export default {
        props: ['release', 'enableActions'],
        computed: {
            artistDisplay() {
                return this.release.artists.map(a => a.name).join(', ')
            }
        },
        methods: {
            ...mapActions([
                'spin'
            ])
        }
    }
</script>