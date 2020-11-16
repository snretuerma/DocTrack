<template>
<v-card flat>
    <v-card-title primary-title>
        All Active Documents
    </v-card-title>
        <v-card-text>
            <v-data-table
            v-if="documents"
            :headers="headers"
            :items="documents"
            item-key="id"
            :items-per-page="10"
            :footer-props="footerProps"
            :loading="datatable_loader"
            loading-text="Loading... Please wait"
            class="elevation-1"
            :search="search"
            :single-expand="false"
            :expanded.sync="expanded"
            show-expand
        >
            <template v-slot:top>
                <v-text-field
                    v-model="search"
                    label="Search"
                    class="mx-4"
                />
            </template>
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
                <td v-if="item.is_external">
                    External
                </td>
                <td v-else>
                    Internal
                </td>
            </template>
            <template v-slot:[`item.document_type_id`] = "{ item }">
                <div v-if="item">
                    {{ findDocumentTypeName(item.document_type_id) }}
                </div>
            </template>
            <template v-slot:[`item.originating_office`] = "{ item }">
                <div v-if="item && checkIfID(item.originating_office)">
                    {{ findDocumentOriginatingOfficeName(item.originating_office) }}
                </div>
                <div v-else>
                    {{ item.originating_office }}
                </div>
            </template>
            <template v-slot:[`item.current_office_id`] = "{ item }">
                <div v-if="item">
                    {{ findDocumentCurrentOfficeName(item.current_office_id) }}
                </div>
            </template>
            <template v-slot:[`item.sender_name`] = "{ item }">
                <div v-if="item && checkIfID(item.sender_name)">
                    {{ findDocumentSenderName(item.sender_name) }}
                </div>
                <div v-else>
                    {{ item.sender_name }}
                </div>
            </template>
            <template v-slot:[`item.is_terminal`] = "{ item }">
                <td v-if="item.is_terminal">
                    Yes
                </td>
                <td v-else>
                    No
                </td>
            </template>
            <template v-slot:[`item.view_more`]="{ item }">
                <v-icon
                    small
                    class="mr-2"
                >
                    mdi-more
                </v-icon>
            </template>
            <template v-slot:expanded-item="{ headers, item }">
                <td :colspan="headers.length">
                    <v-row>
                        <v-col cols="12" sm="3">
                            <v-btn
                                text
                                color="#26A69A"
                                block
                            >
                                <v-icon left>
                                    mdi-pencil
                                </v-icon>
                                Edit
                            </v-btn>
                        </v-col>
                        <v-col cols="12" sm="3">
                            <v-btn
                                text
                                color="#FFCA28"
                                block
                            >
                                <v-icon left>
                                    mdi-email-send-outline
                                </v-icon>
                                Receive
                            </v-btn>
                        </v-col>
                        <v-col cols="12" sm="3">
                            <v-btn
                                text
                                color="#9575CD"
                                block
                            >
                                <v-icon left>
                                    mdi-email-receive-outline
                                </v-icon>
                                Forward
                            </v-btn>
                        </v-col>
                        <v-col cols="12" sm="3">
                            <v-btn
                                text
                                color="#F06292"
                                block
                            >
                                <v-icon left>
                                    mdi-email-off-outline
                                </v-icon>
                                Terminal
                            </v-btn>
                        </v-col>
                    </v-row>
                </td>
            </template>
        </v-data-table>
    </v-card-text>
</v-card>
</template>

<script>
/**
 * TODO:
 *  Add Modal for View more to reduce the data in the datatable
 *  Add actions for the buttons to redirect to another page
**/
import { colors } from '../../../constants';
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            search: '',
            expanded: [],
            footerProps: {'items-per-page-options': [10, 30, 50, 100, -1]},
            headers: [
                { text: 'Tracking ID', value: 'tracking_code' },
                { text: 'Title', value: 'title' },
                { text: 'Source', value: 'is_external' },
                { text: 'Type', value: 'document_type_id' },
                { text: 'Originating Office', value: 'originating_office' },
                { text: 'Current Office', value: 'current_office_id' },
                { text: 'Sender', value: 'sender_name' },
                { text: 'Page Count', value: 'page_count' },
                { text: 'Attachment Page Count', value: 'attachment_page_count' },
                { text: 'Terminal', value: 'is_terminal' },
                { text: 'Date Filed', value: 'date_filed' },
                { text: 'Remarks', value: 'remarks' },
                { text: 'View', value: 'view_more', sortable: false },
                { text: 'Actions', value: 'data-table-expand' },
            ],
        }
    },
    computed: {
        offices() {
            return this.$store.state.offices.offices;
        },
        document_types() {
            return this.$store.state.documents.document_types;
        },
        users() {
            return this.$store.state.users.all_users;
        },
        ...mapGetters(['documents', 'datatable_loader'])
    },
    methods: {
        checkIfID(string) {
            return /^-?\d+$/.test(string);
        },
        getTrackingCodeColor(document_type_id) {
            return colors[document_type_id];
        },
        findDocumentTypeName(document_type_id) {
            var document_type = this.document_types.find(element => element.id == document_type_id);
            if (document_type != null) {
                return document_type.name;
            }
        },
        findDocumentOriginatingOfficeName(originating_office) {
            var office = this.offices.find(element => element.id == originating_office);
            if (office != null) {
                return office.name;
            }
        },
        findDocumentCurrentOfficeName(current_office) {
            var office = this.offices.find(element => element.id == current_office);
            if (office != null) {
                return office.name;
            }
        },
        findDocumentSenderName(sender_id) {
            var sender = this.users.find(element => element.id == sender_id);
            if (sender != null) {
                return sender.full_name;
            }
        }
    },
    mounted() {
        this.$store.dispatch('unsetLoader');
        this.$store.dispatch('getActiveDocuments').then(() => {
            if (this.offices && this.document_types) {
                this.$store.dispatch('unsetDataTableLoader');
            }
        });
    }
}
</script>