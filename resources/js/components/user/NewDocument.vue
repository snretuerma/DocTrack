<template>
<v-card flat>
    <v-card-title primary-title>
        New Document
    </v-card-title>
    <v-card-subtitle>
        <v-breadcrumbs :items="breadcrumbs">
        <template v-slot:divider>
            <v-icon>mdi-arrow-right-thick</v-icon>
        </template>
        </v-breadcrumbs>
    </v-card-subtitle>
    <v-card-text>
        <v-form>
            <v-row>
                <v-col cols="12" xl="8" lg="8" md="12">
                    <v-text-field
                        v-model="form.document_title"
                        label="Document Title"
                        prepend-inner-icon="mdi-format-title"
                        outlined
                        required
                    ></v-text-field>
                </v-col>
                <v-col cols="12" xl="4" lg="4" md="12">
                    <v-select
                        v-model="form.document_type"
                        :items="document_types"
                        item-text="name"
                        item-value="id"
                        label="Document Type"
                        prepend-inner-icon="mdi-file-document-multiple-outline"
                        return-object
                        outlined
                        required
                    ></v-select>
                </v-col>
                <v-col cols="12" xl="4" lg="4" md="12">
                    <v-radio-group
                        v-model="form.is_external"
                        row
                        :mandatory="true"
                        label="Document Origin"
                        single-line
                        required
                    >
                        <v-radio
                            label="Internal"
                            value="false"
                        ></v-radio>
                        <v-radio
                            label="External"
                            value="true"
                        ></v-radio>
                    </v-radio-group>
                </v-col>
                <v-col cols="12" xl="8" lg="8" md="12">
                    <v-text-field
                        v-model="form.originating_office"
                        label="Originating Office"
                        prepend-inner-icon="mdi-office-building-marker-outline"
                        outlined
                        required
                    ></v-text-field>
                </v-col>
                <v-col cols="12" xl="6" lg="6" md="12">
                    <v-text-field
                        v-model="form.sender_name"
                        label="Sender Name"
                        prepend-inner-icon="mdi-account-arrow-right-outline"
                        outlined
                    ></v-text-field>
                </v-col>
                <v-col cols="12" xl="6" lg="6" md="12">
                    <v-menu
                        v-model="menu"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="form.date_filed"
                            label="Date Filed"
                            prepend-inner-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            outlined
                        ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="form.date_filed"
                            @input="menu = false"
                        ></v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12" xl="6" lg="6" md="12">
                    <v-text-field
                        v-model="form.page_count"
                        label="Page Count"
                        prepend-inner-icon="mdi-numeric"
                        outlined
                        required
                    ></v-text-field>
                </v-col>
                <v-col cols="12" xl="6" lg="6" md="12">
                    <v-text-field
                        v-model="form.attachment_page_count"
                        label="Attachment Page Count"
                        prepend-inner-icon="mdi-numeric"
                        outlined
                    ></v-text-field>
                </v-col>
                <v-col cols="12" xl="12" lg="12" md="12">
                    <v-textarea
                        clearable
                        outlined
                        auto-grow
                        clear-icon="mdi-close-circle"
                        prepend-inner-icon="mdi-comment-text-outline"
                        label="Remarks"
                        v-model="form.remarks"
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <div
                        class="my-2"
                        align="center"
                        justify="end"
                    >
                        <v-btn
                            color="primary"
                            dark
                        >
                            <v-icon
                                left
                                dark
                            >
                                mdi-send
                            </v-icon>
                            Submit
                        </v-btn>
                    </div>
                </v-col>
            </v-row>
        </v-form>
    </v-card-text>
</v-card>
</template>

<script>
export default {
    data() {
        return {
            breadcrumbs: [
                {
                    text: 'Document Records',
                    disabled: false,
                    to: 'document_records',
                },
                {
                    text: 'New Document',
                    disabled: true,
                    to: 'new_document',
                },
            ],
            document_types: [
                {id: 1, name: 'Document Type 1'},
                {id: 2, name: 'Document Type 2'},
                {id: 3, name: 'Document Type 3'},
                {id: 4, name: 'Document Type 4'},
                {id: 5, name: 'Document Type 5'},
            ],
            menu: false,
            form: {
                tracking_id: '',
                document_title: '',
                document_type: '',
                originating_office: '',
                sender_name: '',
                page_count: '',
                attachment_page_count: '',
                is_external: false,
                date_filed: new Date().toISOString().substr(0, 10),
            }

        }
    },
    methods: {
        generateTrackingCode() {

        },
        sanitizeInputs() {

        }
    }
}
</script>