import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        nowSpinning: null,
    },
    mutations: {
        spin (state, release) {
            state.nowSpinning = release
        }
    }
})