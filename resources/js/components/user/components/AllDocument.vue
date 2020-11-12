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
        <!-- <template v-slot:body.append>
            <tr>
                <td></td>
                <td>
                    <v-text-field
                    v-model="calories"
                    type="number"
                    label="Less than"
                    ></v-text-field>
                </td>
                <td colspan="4"></td>
            </tr>
        </template> -->
        </v-data-table>
    </v-card-text>
</v-card>
</template>

<script>
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
        ...mapGetters(['documents'])
    },
    methods: {
        ...mapActions(['getDocuments', 'unsetLoader']),
        getAllDocuments() {
            this.getDocuments();
        }
    },
    mounted() {
        this.unsetLoader();
        this.getDocuments();
    }
}
</script>