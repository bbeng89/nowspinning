import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null,
        nowSpinning: null,
    },
    mutations: {
        user(state, user) {
            state.user = user
        },
        spin (state, release) {
            state.nowSpinning = release
        }
    },
    actions: {
        spin ({ commit }, release) {
            Vue.http.post('/api/user/spin', { id: release.id }).then(
                response => commit('spin', release), // success
                response => console.log('Error posting to /api/user/spin') // error
            )
        }
    }
})