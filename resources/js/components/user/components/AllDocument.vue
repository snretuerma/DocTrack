<template>
<v-card flat>
    <v-card-title primary-title>
        All Documents
    </v-card-title>
        <v-card-text>
            <v-data-table
            :headers="headers"
            :items="documents"
            item-key="id"
            class="elevation-1"
            :search="search"
        >
            <!-- <template v-slot:top>
                <v-text-field
                v-model="search"
                label="Search (UPPER CASE ONLY)"
                class="mx-4"
                ></v-text-field>
            </template> -->
            <template v-slot:[`header.page_count`] = "{  }">
                <v-icon>mdi-counter</v-icon>
            </template>
            <template v-slot:[`header.attachment_page_count`] = "{  }">
                <v-icon>mdi-attachment</v-icon>
            </template>
            <template v-slot:[`header.is_terminal`] = "{  }">
                <v-icon>mdi-ray-end</v-icon>
            </template>
            <template v-slot:[`item.tracking_code`] = "{ item }">
                        <v-chip
                            label
                            dark
                            :color="getTrackingCodeColor(item.document_type_id)"
                        >
                            {{ item.tracking_code }}
                        </v-chip>
            </template>
            <template v-slot:[`item.is_external`] = "{ item }">
                <span v-if="item.is_external">
                    External
                </span>
                <span v-else>
                    Internal
                </span>
            </template>
            <template v-slot:[`item.document_type_id`] = "{ item }">
                {{getDocumentTypeName(item.document_type_id)}}
            </template>
            <template v-slot:[`item.is_terminal`] = "{ item }">
                <span v-if="item.is_terminal">
                    Yes
                </span>
                <span v-else>
                    No
                </span>
            </template>
        </v-data-table>
    </v-card-text>
</v-card>
</template>

<script>
import { colors, document_types } from '../../../constants';
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            search: '',
            headers: [
                { text: 'Tracking ID', value: 'tracking_code' },
                { text: 'Title', value: 'title' },
                { text: 'Source', value: 'is_external' },
                { text: 'Document Type', value: 'document_type_id' },
                { text: 'Originating Office', value: 'originating_office' },
                { text: 'Current Office', value: 'current_office_id' },
                { text: 'Sender Name', value: 'sender_name' },
                { text: 'Page Count', value: 'page_count' },
                { text: 'Attachment Page Count', value: 'attachment_page_count' },
                { text: 'Date Filed', value: 'date_filed' },
                { text: 'Terminal', value: 'is_terminal' },
                { text: 'Remarks', value: 'remarks' },
            ],
        }
    },
    computed: {
        ...mapGetters(['documents', 'document_types'])
    },
    methods: {
        ...mapActions(['getDocuments', 'getDocumentTypes','unsetLoader']),
        getAllDocuments() {
            this.getDocuments();
        },
        getTrackingCodeColor(document_type_id) {
            return colors[document_type_id]
        },
        getDocumentTypeName(document_type_id) {
            var type = this.document_types.find(({ id }) => id === document_type_id);
            return type.name;
        },
        // TODO: Name Getters, Office Getters, Office Getters and Loading Indicators
    },
    mounted() {
        this.unsetLoader();
        this.getDocumentTypes();
        this.getDocuments();
    }
}
</script>