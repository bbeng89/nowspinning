<template>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Now Spinning</span>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <img class="img-responsive" :src="release.thumbnail">
                </div>
                <div class="col-sm-8">
                    <strong>{{ release.title }}</strong> <br/>
                    {{ artistDisplay }}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState } from 'vuex'

    export default {
        props: ['release'],
        computed: {
            artistDisplay() {
                return this.release.artists.map(a => a.name).join(', ')
            },
            ...mapState({
                release: 'nowSpinning'
            })
        }
    }
</script>