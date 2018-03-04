<template>
    <div class="panel panel-default release-list-item">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <img class="img-responsive" :src="release.thumbnail">
                </div>
                <div class="col-sm-8">
                    <strong>{{ release.title }}</strong>
                    <br/>
                    {{ release.artists_display }}
                    <hr/>
                    <p>
                        <span v-for="format in formats" class="label label-default" style="margin-right:5px">{{ format }}</span> |
                        Listens: {{ release.listen_count }}
                    </p>
                    <div v-if="enableActions">
                        <button class="btn btn-default" type="button" :disabled="isOnDeck" @click="putReleaseOnDeck()"><i class="fa fa-plus-circle" ref="onDeckIcon"></i> On Deck</button>
                        <button class="btn btn-primary" type="button" :disabled="isSpinning" @click="spinRelease()"><i class="fa fa-thumbs-o-up" ref="spinIcon"></i> Spin Now</button>
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
        methods: {
            putReleaseOnDeck() {
                this.putOnDeck(this.release);
                $(this.$refs.onDeckIcon).addClass('animated').addClass('flash');
            },
            spinRelease() {
                this.spin(this.release);
                $(this.$refs.spinIcon).addClass('animated').addClass('flash');
            },
            ...mapActions({
                spin: 'spin',
                putOnDeck: 'onDeck'
            })
        },
        computed: {
            ...mapState([
                'user',
                'onDeck',
                'nowSpinning'
            ]),
            formats() {
                return this.release.shelves.map(shelf => shelf.name);
            },
            isSpinning() {
                return this.nowSpinning && this.nowSpinning.id == this.release.id;
            },
            isOnDeck() {
                return this.onDeck.find(r => r.id == this.release.id) != null;
            }
        }
    }
</script>