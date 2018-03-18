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
            <button type="button" @click="fetchPosts(true)" class="btn btn-default btn-xs pull-right"><i class="fa fa-refresh"></i> Refresh</button>
        </div>

        <div v-infinite-scroll="loadMore" infinite-scroll-disabled="loading" infinite-scroll-distance="20">
            <Post v-for="post in posts"
                  :key="post.id"
                  :id="post.id"
                  :username="post.user.username"
                  :avatar="post.user.avatar"
                  :content="post.content"
                  :date-posted="post.created_at"
                  :spinning="post.release"
                  :images="post.images"
                  @deleted="removePost">
            </Post>
        </div>

        <h2 v-if="loading" class="text-center"><i class="fa fa-spinner fa-spin"></i></h2>
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
                loading: false,
                currentPage: 1,
                lastPage: null,
                count : 0
            }
        },
        mounted() {
            this.fetchPosts();
            EventBus.listen('postCreated', data => this.posts.unshift(data))
        },
        methods: {
            toggleFeed() {
                this.feed = this.feed == 'friends' ? 'global' : 'friends';
                this.fetchPosts(true);
            },
            loadMore() {
                if(this.currentPage == this.lastPage) return;
                this.currentPage++;
                this.fetchPosts();
            },
            fetchPosts(reset = false) {
                this.loading = true;
                if(reset){
                    this.currentPage = 1;
                    this.posts = [];
                }
                return posts.getNewsFeed(this.feed, this.currentPage, response => {
                    this.count = response.body.total;
                    this.currentPage = response.body.current_page;
                    this.lastPage = response.body.last_page;

                    for(let post of response.body.data) {
                        this.posts.push(post);
                    }

                    this.loading = false;
                });
            },
            removePost(id) {
                this.posts.splice(this.posts.map(post => post.id).indexOf(id), 1);
            }
        }
    }
</script>

<style>
    #news-feed {
        margin-top: 22px;
    }
</style>