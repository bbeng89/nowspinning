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
                        <li v-if="!editing"><a href="javascript:void(0)" @click="toggleEditMode">Edit</a></li>
                        <li><a href="javascript:void(0)" @click="deletePost">Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div style="margin-bottom: 15px">
                <slick v-if="hasImages" ref="slick" :options="slickOptions">
                    <img v-for="image in images" :src="image.src" alt="">
                </slick>
            </div>
            <div v-if="editing">
                <textarea class="form-control" name="content" v-model="postContent" v-validate="'required'">{{ postContent }}</textarea>
                <br/>
                <button type="button" @click="cancelEdit" class="btn btn-xs btn-default">Cancel</button>
                <button type="button" @click="updatePost" :disabled="errors.has('content')" class="btn btn-xs btn-primary">Save</button>
            </div>
            <div v-else v-html="postContent"></div>
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
    // https://github.com/staskjs/vue-slick
    import Slick from 'vue-slick';
    import 'slick-carousel/slick/slick.css';
    import 'slick-carousel/slick/slick-theme.css';
    import posts from '../../api/posts';

    export default {
        components: { Slick },
        props: ['id', 'username', 'avatar', 'content', 'datePosted', 'spinning', 'images'],
        data(){
            return {
                editing: false,
                postContent: this.content || '',
                slickOptions: {
                    dots: true,
                    slidesToShow: 1,
                    //adaptiveHeight:true,
                    lazyLoad: 'ondemand'
                }
            }
        },
        methods: {
            deletePost() {
                if(confirm('Are you sure you want to delete this post?')) {
                    posts.deletePost(this.id, response => {
                        this.$emit('deleted', this.id);
                        this.$notify('Your post was successfully deleted.');
                    });
                }
            },
            toggleEditMode() {
                this.editing = !this.editing;
            },
            cancelEdit() {
                this.toggleEditMode();
                this.postContent = this.content;
            },
            updatePost() {
                posts.updatePost(this.id, this.postContent, response => {
                    this.editing = false;
                    this.$notify('Your post was successfully updated');
                });
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