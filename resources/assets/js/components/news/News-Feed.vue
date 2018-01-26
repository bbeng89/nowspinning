<template>
    <div id="news-feed">
        <Compose></Compose>
        <hr/>
        <!--<div class="text-center">-->
            <!--<div class="btn-group" role="group" aria-label="...">-->
                <!--<button type="button" @click="toggleFeed" class="btn btn-default" :class="{ 'active': feed == 'friends' }"><i class="fa fa-users"></i> Friends</button>-->
                <!--<button type="button" @click="toggleFeed" class="btn btn-default" :class="{ 'active': feed == 'global' }"><i class="fa fa-globe"></i> Global</button>-->
            <!--</div>-->
        <!--</div>-->
        <!--<hr/>-->
        <Post v-for="post in posts"
            :key="post.id"
            :username="post.user.username"
            :avatar="post.user.avatar"
            :content="post.content"
            :date-posted="post.created_at"
            :spinning="post.release">
        </Post>
        <h2 class="text-center" v-if="loading"><i class="fa fa-spinner fa-spin"></i></h2>
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
            this.loading = true;
            this.fetchPosts().then(response => this.loading = false);
            EventBus.listen('postCreated', data => this.pushPost(data))
        },
        methods: {
            toggleFeed() {
                this.feed = this.feed == 'friends' ? 'global' : 'friends';
            },
            fetchPosts() {
                return posts.getNewsFeed(response => this.posts = response.body.data)
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