import Vue from "vue";

const defaultErrorHandler = (response) => {
    console.log("API error");
    console.log(response); // do something else - display an error message?
}

export default {
    getNewsFeed(feed, page, success, error) {
        return Vue.http.get('/api/posts/'+feed, { params: { page: page }}).then(success, error || defaultErrorHandler);
    },
    createPost(content, showSpinning, success, error) {
        return Vue.http.post('/api/posts/create', { content: content, showSpinning: showSpinning })
            .then(success, error || defaultErrorHandler);
    },
    deletePost(id, success, error) {
        return Vue.http.delete(`/api/posts/delete/${id}`).then(success, error || defaultErrorHandler);
    }
}