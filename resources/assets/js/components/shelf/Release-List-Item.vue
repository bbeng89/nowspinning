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
                        <button class="btn btn-default" type="button" @click="putReleaseOnDeck(release)"><i class="fa fa-plus-circle" ref="onDeckIcon"></i> On Deck</button>
                        <button class="btn btn-primary" type="button" @click="spinRelease(release)"><i class="fa fa-thumbs-o-up" ref="spinIcon"></i> Spin Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        props: ['release', 'enableActions'],
        computed: {
            artistDisplay() {
                return this.release.artists.map(a => a.name).join(', ')
            }
        },
        methods: {
            putReleaseOnDeck(release) {
                this.onDeck(release);
                $(this.$refs.onDeckIcon).addClass('animated').addClass('flash');
            },
            spinRelease(release) {
                this.spin(release);
                $(this.$refs.spinIcon).addClass('animated').addClass('flash');
            },
            ...mapState([
                'user'
            ]),
            ...mapActions([
                'spin',
                'onDeck'
            ])
        }
    }
</script>