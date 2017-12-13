import Vue from 'vue'

export default {
    getUser(success, error) {
        return Vue.http.get('/api/user').then(success, error);
    },
    getCounts(username, success, error) {
        return Vue.http.get('/api/collection/'+username+'/shelves/counts').then(success, error);
    },
    getReleases(username, shelfName, success, error) {
        return Vue.http.get('/api/collection/'+username+'/'+shelfName).then(success, error);
    },
    getRelease(releaseId, success, error) {
        return Vue.http.get('/api/collection/release/' + releaseId).then(success, error);
    }
}