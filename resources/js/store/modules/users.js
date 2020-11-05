import axios from 'axios';

const state = {
    user: {},
}

const getters = {
    auth_user: state => state.user,
    auth_user_full_name: state => {
        state.user.first_name,
        state.user.middle_name,
        state.user.last_name,
        state.user.suffix
    }
}

const actions = {
    async getAuthUser({ commit }) {
        const response = await axios.get('/api/users');
        commit('setAuthUser', response.data);
    },
    async editUserCompleteName({ commit }, updates) {
        const response = await axios.put(`/api/users/${updates.id}`, updates.form);
        commit('updateStateUserCompleteName', updates.form);
    }
}

const mutations = {
    setAuthUser: (state, user) => (state.user = user),
    updateStateUserCompleteName: (state, updates) => {
        state.first_name = updates.first_name;
        state.middle_name = updates.middle_name;
        state.last_name = updates.last_name;
        state.suffix = updates.suffix;
    }
}


export default {
    state,
    getters,
    actions,
    mutations
};