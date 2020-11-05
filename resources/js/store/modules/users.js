import axios from 'axios';

function buildName(first_name, middle_name, last_name, suffix) {
    var f_name = '', m_name = '',l_name = '',s_name = '';
    f_name = (first_name.trim()).charAt(0).toUpperCase() + (first_name.trim()).slice(1);
    m_name = (middle_name.trim()).charAt(0).toUpperCase() + (middle_name.trim()).slice(1);
    l_name = (last_name.trim()).charAt(0).toUpperCase() + (last_name.trim()).slice(1);
    if(suffix != null && typeof suffix !== 'undefined') {
        s_name = (suffix.trim()).charAt(0).toUpperCase() + (suffix.trim()).slice(1);
    }
    return `${f_name} ${m_name} ${l_name} ${s_name}`;
}

const state = {
    user: {},
    user_full_name: '',
    request_status: '',
    status_message: '',
}

const getters = {
    auth_user: state => state.user,
    auth_user_full_name: state => state.user_full_name,
    request_status: state => state.request_status,
    status_message: state => state.status_message,
}

const actions = {
    async getAuthUser({ commit }) {
        const response = await axios.get('/api/users');
        commit('setAuthUser', response.data);
    },
    async removeAuthUser({ commit }) {
        await axios.post('/api/logout');
        commit('unsetAuthUser');
    },
    async editUserCompleteName({ commit }, updates) {
        const response = await axios.put(`/api/users/${updates.id}`, updates.form);
        commit('updateStateUserCompleteName', {response: response.data, form: updates.form});
    },
    async updateResponseMessage({ commit }) {
        // commit('');
    }
}

const mutations = {
    setAuthUser: (state, user) => {
        state.user = user
        state.user_full_name = buildName(user.first_name, user.middle_name, user.last_name, user.suffix);
    },
    unsetAuthUser: (state) => {
        state.user = {};
        state.user_full_name = '';
    },
    updateStateUserCompleteName: (state, data) => {
        if(data.response.code == "Success") {
            state.first_name = response.form.first_name;
            state.middle_name = response.form.middle_name;
            state.last_name = response.form.last_name;
            state.suffix = response.form.name_suffix;
            state.user_full_name = buildName(
                data.form.first_name,
                data.form.middle_name,
                data.form.last_name,
                data.form.name_suffix
            );
        }
        state.request_status = data.response.code;
        state.status_message = data.response.message;
    },
}

export default {
    state,
    getters,
    actions,
    mutations
};