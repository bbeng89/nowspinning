import Vue from 'vue'

const defaultErrorHandler = (response) => {
    console.log("API error");
    console.log(response);
    // do something else - display an error message?
}
export default {
    getUser(success, error) {
        return Vue.http.get('/api/user').then(success, error || defaultErrorHandler);
    },
    getCounts(username, success, error) {
        return Vue.http.get('/api/collection/'+username+'/shelves/counts').then(success, error || defaultErrorHandler);
    },
    getReleases(username, shelfName, success, error) {
        return Vue.http.get('/api/collection/'+username+'/'+shelfName).then(success, error || defaultErrorHandler);
    },
    getRelease(releaseId, success, error) {
        return Vue.http.get('/api/collection/release/' + releaseId).then(success, error || defaultErrorHandler);
    },
    addToShelf(release, shelfHandle, success, error) {
        return Vue.http.post('/api/user/shelf/add-release', { releaseId: release.id, shelfHandle: shelfHandle })
            .then(success, error || defaultErrorHandler);
    },
    spin(release, success, error) {
        return Vue.http.post('/api/user/spin', { id: release.id }).then(success, error || defaultErrorHandler);
    }
}