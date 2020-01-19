import axios from 'axios';

export default {
    namespaced: true,

    state: {
        token: null,
        user: null
    },

    getters: {
        authenticated(state) {
            return state.token && state.user;
        },

        user(state) {
            console.log(state.user)
            return state.user;
        }
    },

    mutations: {
        SET_TOKEN(state, token) {
            state.token = token
        },

        SET_USER(state, data) {
            state.user = data
        }
    },

    actions: {
        async signIn({dispatch}, credentials) {
            let response = await axios.post('auth/signin', credentials)

            return dispatch('attempt', response.data.token);
        },

        signOut({commit}) {
            return axios.post('auth/signout').then(() => {
                commit('SET_TOKEN', null)
                commit('SET_USER', null)
                // this.$router.replace({
                //     name: 'signin'
                // })
            });
        },

        async attempt({commit, state}, token) {
            if (token) {
                commit('SET_TOKEN', token);
            }

            if (!state.token) {
                return
            }

            try {
                let response = await axios.get('auth/me')

                console.log(response.data);

                commit('SET_USER', response.data)

            } catch (e) {
                console.log(e);
                console.log('faile')
                commit('SET_TOKEN', null)
                commit('SET_USER', null)
            }
        }
    },
}