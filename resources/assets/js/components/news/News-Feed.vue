<template>
    <div id="news-feed">
        <div class="text-center">
            <h2>News Feed</h2>
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" @click="toggleFeed" class="btn btn-default" :class="{ 'active': feed == 'friends' }"><i class="fa fa-users"></i> Friends</button>
                <button type="button" @click="toggleFeed" class="btn btn-default" :class="{ 'active': feed == 'global' }"><i class="fa fa-globe"></i> Global</button>
            </div>
        </div>
        <hr/>
        <post v-for="post in posts"
            :key="post.id"
            :username="post.user.username"
            :avatar="post.user.avatar"
            :content="post.content"
            :date-posted="post.created_at"
            :spinning-id="releaseId(post.release)"
            :spinning-title="releaseTitle(post.release)">
        </post>
        <h2 class="text-center" v-if="loading"><i class="fa fa-spinner fa-spin"></i></h2>
    </div>
</template>

<script>
    import Post from './Post.vue';
    import posts from '../../api/posts';

    export default {
        components: { 'post': Post },
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
        },
        methods: {
            toggleFeed() {
                this.feed = this.feed == 'friends' ? 'global' : 'friends';
            },
            fetchPosts() {
                return posts.getNewsFeed(response => this.posts = response.body.data)
            },
            releaseId(release) {
                if(!release) return null;
                return release.id;
            },
            releaseTitle(release) {
                if(!release) return null;
                return release.title;
            }
        }
    }
</script>