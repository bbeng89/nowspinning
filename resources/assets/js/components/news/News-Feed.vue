<template>
    <div id="news-feed">
        <div class="text-center">
            <h2>News Feed</h2>
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" @click="toggleFeed" class="btn btn-default" :class="{ 'active': feed == 'friends' }"><i class="fa fa-users"></i> Friends</button>
                <button type="button" @click="toggleFeed" class="btn btn-default" :class="{ 'active': feed == 'global' }"><i class="fa fa-globe"></i> Global</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                feed: 'friends'
            }
        },
        methods: {
            toggleFeed() {
                this.feed = this.feed == 'friends' ? 'global' : 'friends';
            }
        }
    }
</script>