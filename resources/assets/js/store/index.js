import Vue from 'vue'
import Vuex from 'vuex'
import api from '../api';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null,
        nowSpinning: null,
        onDeck: []
    },
    mutations: {
        user(state, user) {
            state.user = user
        },
        spin (state, release) {
            state.nowSpinning = release
        },
        onDeck (state, releases) {
            state.onDeck = releases
        }
    },
    actions: {
        spin ({ commit, state }, release) {
            api.spin(release, response => {
                release.listen_count++
                commit('spin', release)
            })
        },
        onDeck({ commit, state }, release) {
            api.addToShelf(release, 'on-deck', response => {
                let onDeck = state.onDeck
                onDeck.push(release)
                commit('onDeck', onDeck)
            })
        },
        offDeck({ commit, state }, release) {
            api.removeFromShelf(release, 'on-deck', response => {
                let onDeck = state.onDeck.filter(r => r.id != release.id)
                commit('onDeck', onDeck)
            })
        }
    }
})