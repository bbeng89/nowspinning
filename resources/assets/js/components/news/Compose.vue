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
            <div class="clearfix">
                <div class="checkbox pull-left">
                    <label>
                        <input type="checkbox" v-model="showSpinning"> Show what I'm spinning
                    </label>
                </div>
                <button @click="createPost" class="btn btn-primary btn-sm pull-right" :disabled="loading">Post</button>
            </div>
        </div>
    </div>
</template>

<script>
    import posts from '../../api/posts';

    export default {
        data() {
            return {
                content: '',
                showSpinning: true,
                loading: false
            }
        },
        methods: {
            createPost() {
                this.loading = true;
                posts.createPost(this.content, this.showSpinning, response => {
                    this.content = '';
                    this.loading = false;
                    EventBus.fire('postCreated', response.body);
                });
            }
        }
    }
</script>