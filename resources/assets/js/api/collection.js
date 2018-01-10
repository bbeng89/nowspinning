import Vue from "vue";

const defaultErrorHandler = (response) => {
    console.log("API error");
    console.log(response); // do something else - display an error message?
}

export default {
    getShelfCounts(username, success, error) {
        return Vue.http.get('/api/collection/'+username+'/shelves/counts').then(success, error || defaultErrorHandler);
    },
    getReleases(username, shelfName, page, search, sort, success, error) {
        return Vue.http.get('/api/collection/'+username+'/'+shelfName, { params: { page: page, search: search, sort: sort } })
            .then(success, error || defaultErrorHandler);
    },
    getRelease(releaseId, success, error) {
        return Vue.http.get('/api/collection/release/' + releaseId).then(success, error || defaultErrorHandler);
    },
    addToShelf(release, shelfHandle, success, error) {
        return Vue.http.post('/api/collection/shelf/add-release', { releaseId: release.id, shelfHandle: shelfHandle })
            .then(success, error || defaultErrorHandler);
    },
    removeFromShelf(release, shelfHandle, success, error) {
        return Vue.http.post('/api/collection/shelf/remove-release', { releaseId: release.id, shelfHandle: shelfHandle })
            .then(success, error || defaultErrorHandler);
    }
}