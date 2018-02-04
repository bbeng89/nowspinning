<template>
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="pull-left">
                <img style="height:20px" class="img-circle" :src="avatar">
                <strong>{{ username }}</strong>
            </div>
            <div v-if="canAdmin" class="pull-right">
                <!-- Single button -->
                <div class="dropdown">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Edit</a></li>
                        <li><a href="#">Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <slick v-if="hasImages" ref="slick" :options="slickOptions">
                <img v-for="image in images" :src="image.src" alt="">
            </slick>
            <div v-html="content"></div>
            <hr v-if="spinning"/>
            <p v-if="spinning"><small><em>Spinning: <a href="#">{{ spinningTitle }}</a></em></small></p>
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
    import { mapState } from 'vuex';
    import Slick from 'vue-slick';
    import 'slick-carousel/slick/slick.css';
    import 'slick-carousel/slick/slick-theme.css';
    export default {
        components: { Slick },
        props: ['username', 'avatar', 'content', 'datePosted', 'spinning', 'images'],
        data(){
            return {
                slickOptions: {
                    dots: true,
                    slidesToShow: 1,
                    //adaptiveHeight:true,
                    lazyLoad: 'ondemand'
                }
            }
        },
        computed: {
            dateDisplay() {
                return moment.utc(this.datePosted).fromNow();
            },
            spinningTitle() {
                if(!this.spinning) return null;
                return this.spinning.artists_display + ' - ' + this.spinning.title;
            },
            canAdmin() {
                return this.username == this.user.username;
            },
            hasImages() {
                return this.images && this.images.length > 0;
            },
            ...mapState({
                user: 'user'
            })
        }
    }
</script>
<style>
    .slick-next {
        right: 10px;
        z-index:99;
    }
    .slick-prev {
        left: 10px;
        z-index:99;
    }
</style>