const state = {
    documents: [],
    document_types: [],
    form_requests : {
        request_form_type: '',
        request_status: '',
        status_message: '',
    },
    document_loading: false,
    document_type_loading: false,
}

const getters = {
    documents: state => state.documents,
    document_types: state => state.document_types,
    form_requests: state => state.form_requests,
}

const actions = {
    async getDocuments({ commit }) {
        const response = await axios.get(`/api/get_all_documents`);
        commit('GET_ALL_DOCUMENTS', response.data);
    },
    async getDocumentTypes({ commit }) {
        const response = await axios.get('document_type_list');
        commit('GET_ALL_DOCUMENT_TYPES', response.data);
    },
    async createNewDocument({ commit }, form) {
        await axios.post('add_new_document', form)
        .then(response => {
            const data = {
                form_type: form.form_type,
                code: 'SUCCESS',
                message: `Document ${form.tracking_id} created!`,
                response_data: response.data
            }
            commit('UPDATE_DOCUMENT_LIST', data);
        })
        .catch(error => {
            const error_data = {
                form_type: form.form_type,
                code: 'FAILED',
                message: `The server replied with an error! Please Contact your administrator\nException Type : ${error.response.data.exception}`,
            }
            commit('THROW_SERVER_ERROR', error_data)
        });
    }
}

const mutations = {
    GET_ALL_DOCUMENTS(state, response) {
        state.documents = response;
    },
    GET_ALL_DOCUMENT_TYPES(state, document_types) {
        state.document_types = document_types;
    },
    UPDATE_DOCUMENT_LIST(state, data) {
        // TODO: Update documents list and document tracking list
        state.form_requests.request_form_type = data.form_type;
        state.form_requests.request_status = data.code;
        state.form_requests.status_message = data.message;
    },
    THROW_SERVER_ERROR(state, error) {
        state.form_requests.request_form_type = error.form_type;
        state.form_requests.request_status = error.code;
        state.form_requests.status_message = error.message;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}