<template>
    <div>
        <div v-if="release" class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <img class="img-responsive" :src="release.thumbnail">
                    </div>
                    <div class="col-sm-8">
                        <strong>{{ release.title }}</strong> <br/>
                        {{ release.artists_display }}
                    </div>
                </div>
            </div>
            <div class="panel-footer clearfix">
                <div class="pull-left">
                    <i class="fa fa-volume-up"></i> Now Spinning
                </div>
                <div class="pull-right">
                    <span v-for="format in formats" class="label label-default" style="margin-right:5px;">{{ format }}</span>
                    <span class="label label-success"><i class="fa fa-headphones"></i> {{ release.listen_count }}</span>
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