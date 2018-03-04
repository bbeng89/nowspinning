<template>
    <div>
        <h4 class="text-center">Now Spinning</h4>
        <div v-if="release" class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <img class="img-responsive" :src="release.thumbnail">
                    </div>
                    <div class="col-sm-8">
                        <strong>{{ release.title }}</strong> <br/>
                        {{ release.artists_display }} <br/>
                        <span v-for="format in formats" class="label label-default" style="margin-right:5px;">{{ format }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState } from 'vuex'

    export default {
        props: ['user', 'release'],
        computed: {
            formats() {
                return this.release.shelves.map(shelf => shelf.name);
            }
        }
    }
</script>