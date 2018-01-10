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
    spin(release, success, error) {
        return Vue.http.post('/api/user/spin', { id: release.id }).then(success, error || defaultErrorHandler);
    },
    getProfile(userid, success, error) {
        return Vue.http.get('/api/user/profile/' + userid).then(success, error || defaultErrorHandler);
    },
    updateProfile(args, success, error) {
        return Vue.http.post('/api/user/profile/update', args).then(success, error || defaultErrorHandler);
    },
    sync(success, error) {
        return Vue.http.post('/api/user/sync').then(success, error || defaultErrorHandler);
    }
}