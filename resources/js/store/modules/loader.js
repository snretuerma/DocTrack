const state = {
    page_loader: true,
}

const getters = {
    page_loader: state => state.page_loader,
}

const actions = {
    setLoader({ commit }) {
        commit('SET_PAGE_LOADER');
    },
    unsetLoader({ commit }) {
        commit('UNSET_PAGE_LOADER');
    }
}

const mutations = {
    SET_PAGE_LOADER(state) {
        state.page_loader = true;
    },
    UNSET_PAGE_LOADER(state) {
        state.page_loader = false;
    },
}

export default {
    state,
    getters,
    actions,
    mutations
};