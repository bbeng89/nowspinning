<template>
    <div>
        <h4 class="text-center">Now Spinning</h4>
        <div class="panel">
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
    </div>
</template>
<script>
    import { mapState } from 'vuex'

    export default {
        computed: {
            artistDisplay() {
                return this.release.artists.map(a => a.name).join(', ')
            },
            ...mapState({
                user: 'user',
                release: 'nowSpinning'
            })
        }
    }
</script>