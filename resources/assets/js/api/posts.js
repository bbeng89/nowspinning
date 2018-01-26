import Vue from "vue";

const defaultErrorHandler = (response) => {
    console.log("API error");
    console.log(response); // do something else - display an error message?
}

export default {
    getNewsFeed(success, error) {
        return Vue.http.get('/api/posts').then(success, error || defaultErrorHandler);
    }
}