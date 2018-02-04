<template>
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <span class="pull-left">Post something interesting</span>
            <i class="fa fa-pencil-square-o pull-right"></i>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <textarea class="form-control" rows="2" v-model="content"></textarea>
            </div>
            <div class="row">
                <div class="col-sm-12 clearfix">
                    <div class="checkbox pull-left">
                        <label>
                            <input type="checkbox" v-model="showSpinning"> Show what I'm spinning
                        </label>
                    </div>
                    <button @click="createPost" class="btn btn-primary btn-sm pull-right" :disabled="loading">Post</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 clearfix">
                    <a class="pull-left" href="javascript:void(0)" @click="toggleImageUploader">Add images</a>
                    <span v-if="imgCount > 0" class="pull-right">{{ imgCount }} {{ imgCount == 1 ? 'image' : 'images' }} added</span>
                </div>
            </div>
            <vue-dropzone ref="composeVueDropzone" id="dropzone"
                :options="dropzoneOptions"
                @vdropzone-file-added="imgCount++"
                @vdropzone-removed-file="imgCount--"
                @vdropzone-success="fileUploaded"
                @vdropzone-queue-complete="uploadComplete">
            </vue-dropzone>
        </div>
    </div>
</template>

<script>
    import posts from '../../api/posts';
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.css'

    export default {
        components: { vueDropzone: vue2Dropzone },
        data() {
            return {
                content: '',
                showSpinning: true,
                loading: false,
                imgCount: 0,
                post: null,
                images: [],
                dropzoneOptions: {
                    url: '/api/posts/create/image',
                    autoProcessQueue: false,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
                    acceptedFiles: '.jpg,.jpeg,.png,.bmp,.gif',
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            }
        },
        mounted(){
        },
        methods: {
            createPost() {
                this.loading = true;
                posts.createPost(this.content, this.showSpinning, response => {
                    this.content = '';
                    this.loading = false;
                    let post = response.body;
                    this.post = post;
                    if(this.imgCount > 0)
                    {
                        this.$refs.composeVueDropzone.setOption('params', { post_id: post.id });
                        this.$refs.composeVueDropzone.processQueue();
                    }
                    else {
                        EventBus.fire('postCreated', this.post);
                        this.post = null;
                    }
                });
            },
            fileUploaded(file, response){
                this.images.push(response);
            },
            toggleImageUploader() {
                $('#dropzone').slideToggle()
            },
            uploadComplete() {
                this.$refs.composeVueDropzone.removeAllFiles();
                this.toggleImageUploader();
                this.post.images = this.images;
                EventBus.fire('postCreated', this.post);
                this.post = null;
                this.images = [];
            }
        }
    }
</script>
<style>
    #dropzone {
        display:none;
    }
</style>