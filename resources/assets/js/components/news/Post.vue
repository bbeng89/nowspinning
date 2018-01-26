<template>
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="pull-left">
                <img style="height:20px" class="img-circle" :src="avatar">
                <strong>{{ username }}</strong>
            </div>
            <div v-if="spinning" class="pull-right">
                <small><em><a href="#">{{ spinningTitle }}</a></em></small>
            </div>
        </div>
        <div class="panel-body" v-html="content">
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6">
                    <a href="#"><i class="fa fa-heart-o"></i></a>
                    <a href="#" style="margin-left:20px">Comment</a>
                </div>
                <div class="col-sm-6 text-right">
                    {{ dateDisplay }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['username', 'avatar', 'content', 'datePosted', 'spinning'],
        computed: {
            dateDisplay() {
                return moment(this.datePosted).fromNow();
            },
            spinningTitle() {
                if(!this.spinning) return null;
                return this.spinning.artists_display + ' - ' + this.spinning.title;
            }
        }
    }
</script>