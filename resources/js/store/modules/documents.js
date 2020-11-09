const state = {
    documents: {},
    document_types: {},
}

const getters = {
    documents: state => state.documents,
}

const actions = {
    async getDocuments({ commit }) {
        const response = await axios.get(`/api/get_all_documents`);
        commit('GET_ALL_DOCUMENTS', response.data);
    },
}

const mutations = {
    GET_ALL_DOCUMENTS(state, response) {
        state.documents = response.data;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}