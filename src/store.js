import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist'
import axios from 'axios'

Vue.use(Vuex);

const vuexPersist = new VuexPersist({
    key: 'slum',
    storage: window.localStorage
})

const store = new Vuex.Store({
    state: {
        authenticated: false,
        user: {},
        posts: []
    },
    mutations: {
        setAuthentication(state, status) {
            state.authenticated = status
        },
        setUser(state, user) {
            state.user = user
        },
        setPosts(state, posts) {
            state.posts = posts
        }
    },
    actions: {
        getUser({ commit }) {
            axios
            .get('/api/user/get')
            .then((response) => {
                commit('setUser', response.data)
            })
        },
        logout({ commit }) {
            axios
            .get('/api/user/logout')
            .then((response) => {
                window.console.log(response.data);
                commit('clearUser');
            })
        }
    },
    plugins: [vuexPersist.plugin]
})

export default store;