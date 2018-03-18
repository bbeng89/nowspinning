import Vue from 'vue'
import Vuex from 'vuex'
import users from '../api/users';
import collection from '../api/collection';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null,
        nowSpinning: null,
        onDeck: [],
        friends: []
    },
    mutations: {
        user(state, user) {
            state.user = user;
        },
        spin (state, release) {
            state.nowSpinning = release;
        },
        onDeck (state, releases) {
            state.onDeck = releases;
        },
        friends(state, friends) {
            state.friends = friends;
        },
        addFriend(state, friend) {
            state.friends.push(friend);
        },
        removeFriend(state, friend) {
            let index = state.friends.map(friend => friend.id).indexOf(friend.id);
            state.friends.splice(index, 1);
        }
    },
    actions: {
        spin ({ commit, state }, release) {
            return users.spin(release, response => {
                commit('spin', response.body);
            })
        },
        onDeck({ commit, state }, release) {
            return collection.addToShelf(release, 'on-deck', response => {
                let onDeck = state.onDeck;
                onDeck.push(release);
                commit('onDeck', onDeck);
            })
        },
        offDeck({ commit, state }, release) {
            return collection.removeFromShelf(release, 'on-deck', response => {
                let onDeck = state.onDeck.filter(r => r.id != release.id);
                commit('onDeck', onDeck);
            })
        }
    }
})