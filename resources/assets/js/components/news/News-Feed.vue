<template>
    <div id="news-feed">
        <Compose></Compose>
        <hr/>
        <div class="clearfix">
            <p class="pull-left" style="margin-right:10px;">Feed: </p>
            <div class="btn-group-xs pull-left" role="group" aria-label="...">
                <button type="button" @click="toggleFeed" class="btn btn-default btn-xs" :class="{ 'active': feed == 'friends' }"><i class="fa fa-users"></i> Friends</button>
                <button type="button" @click="toggleFeed" class="btn btn-default btn-xs" :class="{ 'active': feed == 'global' }"><i class="fa fa-globe"></i> Global</button>
            </div>
            <button type="button" @click="fetchPosts" class="btn btn-default btn-xs pull-right"><i class="fa fa-refresh"></i> Refresh</button>
        </div>
        <h2 v-if="loading" class="text-center"><i class="fa fa-spinner fa-spin"></i></h2>
        <Post v-else v-for="post in posts"
            :key="post.id"
            :username="post.user.username"
            :avatar="post.user.avatar"
            :content="post.content"
            :date-posted="post.created_at"
            :spinning="post.release"
            :images="post.images">
        </Post>
    </div>
</template>

<script>
    import Post from './Post.vue';
    import Compose from './Compose.vue';
    import posts from '../../api/posts';

    export default {
        components: { Compose, Post },
        metaInfo: {
            title: 'Feed'
        },
        data() {
            return {
                feed: 'friends',
                posts: [],
                loading: false
            }
        },
        mounted() {
            this.fetchPosts();
            EventBus.listen('postCreated', data => this.pushPost(data))
        },
        methods: {
            toggleFeed() {
                this.feed = this.feed == 'friends' ? 'global' : 'friends';
                this.fetchPosts();
            },
            fetchPosts() {
                this.loading = true;
                return posts.getNewsFeed(this.feed, response => {
                    this.posts = response.body.data;
                    this.loading = false;
                });
            },
            pushPost(post) {
                this.posts.unshift(post);
            }
        }
    }
</script>

<style>
    #news-feed {
        margin-top: 22px;
    }
</style>