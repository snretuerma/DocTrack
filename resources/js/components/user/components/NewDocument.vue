<template>
<v-card flat v-if="user">
    <v-card-title primary-title>
        Add New Document
    </v-card-title>
    <v-card-text>
        <ValidationObserver ref="observer" v-slot="{ invalid }">
            <v-form ref="form" @submit.prevent="addNewDocument">
                <v-row>
                    <v-col cols="12" xl="8" lg="8" md="12">
                        <ValidationProvider rules="required" v-slot="{ errors, valid }">
                            <v-text-field
                                v-model="form.document_title"
                                label="Document Title"
                                prepend-inner-icon="mdi-format-title"
                                outlined
                                :error-messages="errors"
                                :success="valid"
                                required
                            ></v-text-field>
                        </ValidationProvider>
                    </v-col>
                    <v-col cols="12" xl="4" lg="4" md="12">
                        <ValidationProvider rules="required" v-slot="{ errors, valid }">
                            <v-select
                                v-model="form.document_type"
                                :items="document_types"
                                item-text="name"
                                item-value="id"
                                label="Document Type"
                                prepend-inner-icon="mdi-file-document-multiple-outline"
                                :menu-props="{ bottom: true, offsetY: true, transition: 'slide-y-transition'}"
                                outlined
                                required
                                :error-messages="errors"
                                :success="valid"
                            ></v-select>
                        </ValidationProvider>
                    </v-col>
                    <v-col cols="12" xl="4" lg="4" md="12">
                        <v-radio-group
                            v-model="form.is_external"
                            row
                            :mandatory="true"
                            label="Origin: "
                            single-line
                            required
                            @change="originOfficeHandler"
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
                    <v-col cols="12" xl="8" lg="8" md="12" v-if="external_trigger == true">
                        <ValidationProvider rules="required" v-slot="{ errors, valid }">
                            <v-text-field
                                v-model="form.external_office_name"
                                label="External Office"
                                prepend-inner-icon="mdi-office-building-marker-outline"
                                outlined
                                :error-messages="errors"
                                :success="valid"
                                required
                            ></v-text-field>
                        </ValidationProvider>
                    </v-col>
                    <v-col cols="12" xl="8" lg="8" md="12" v-else>
                        <ValidationProvider rules="required" v-slot="{ errors, valid }">
                            <v-select
                                    v-model="form.originating_office_id"
                                    :items="internal_originating_office"
                                    item-text="name"
                                    item-value="id"
                                    label="Originating Office"
                                    prepend-inner-icon="mdi-office-building-marker-outline"
                                    :menu-props="{ bottom: true, offsetY: true }"
                                    outlined
                                    :error-messages="errors"
                                    :success="valid"
                                    required
                            ></v-select>
                        </ValidationProvider>
                    </v-col>
                    <v-col cols="12" xl="6" lg="6" md="12">
                        <ValidationProvider rules="required" v-slot="{ errors, valid }">
                            <v-text-field
                                v-model="form.sender_name"
                                label="Sender Name"
                                prepend-inner-icon="mdi-account-arrow-right-outline"
                                outlined
                                :error-messages="errors"
                                :success="valid"
                            ></v-text-field>
                        </ValidationProvider>
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
                                :show-current="current_date"
                                @input="menu = false"
                            ></v-date-picker>
                        </v-menu>
                    </v-col>
                    <v-col cols="12" xl="6" lg="6" md="12">
                        <ValidationProvider rules="required|numeric|min:0" v-slot="{ errors, valid }">
                            <v-text-field
                                v-model="form.page_count"
                                label="Page Count"
                                prepend-inner-icon="mdi-numeric"
                                outlined
                                :error-messages="errors"
                                :success="valid"
                                required
                                type="number"
                                min="0"
                                onkeypress="return event.charCode >= 48"
                            ></v-text-field>
                        </ValidationProvider>
                    </v-col>
                    <v-col cols="12" xl="6" lg="6" md="12">
                        <ValidationProvider rules="required|numeric|min:0" v-slot="{ errors, valid }">
                            <v-text-field
                                v-model="form.attachment_page_count"
                                label="Attachment Page Count"
                                prepend-inner-icon="mdi-numeric"
                                outlined
                                :error-messages="errors"
                                :success="valid"
                                required
                                type="number"
                                min="0"
                                onkeypress="return event.charCode >= 48"
                            ></v-text-field>
                        </ValidationProvider>
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
                                :dark="!invalid"
                                :disabled="invalid"
                                type="submit"
                            >
                                <v-icon left dark>
                                    mdi-send-circle-outline
                                </v-icon>
                                Submit
                            </v-btn>
                        </div>
                    </v-col>
                </v-row>
            </v-form>
        </ValidationObserver>
    </v-card-text>
</v-card>
</template>

<script>
import { ValidationObserver, ValidationProvider, extend } from 'vee-validate';
export default {
    props: ['user'],
    components: {
        ValidationProvider,
        ValidationObserver
    },
    data() {
        return {
            document_types: [],
            internal_originating_office: [],
            external_trigger: true,
            menu: false,
            current_date: new Date().toISOString().substr(0, 10),
            form: {
                tracking_id: '',
                document_title: '',
                document_type: '',
                originating_office_id: '',
                external_office_name: '',
                sender_name: '',
                page_count: '',
                attachment_page_count: '',
                is_external: false,
                date_filed: new Date().toISOString().substr(0, 10),
                remarks: '',
            }
        }
    },
    methods: {
        generateTrackingCode(document_data) {
            var tracking_number = '';
            var origin = 'I';
            var salt = '';
            for(var iterator = 0; iterator < 5; iterator++) {
                salt = salt + (~~(Math.random() * 10)).toString();
            }
            if(document_data.is_external) {
                origin = 'E'
            }
            tracking_number = tracking_number +
                origin + '-' +
                this.user.office.office_code + '-' +
                document_data.date_filed.split('-')[0] + '-' +
                salt + '-' +
                document_data.attachment_page_count;
            return tracking_number;
        },
        sanitizeInputs() {
            this.form.tracking_id = this.generateTrackingCode(this.form);
            this.form.document_title = this.form.document_title.toString();
            this.form.external_office_name = this.form.external_office_name != null && typeof this.form.external_office_name != 'undefined' ?
                this.form.external_office_name.toString() : null;
            this.form.sender_name = this.form.sender_name.toString();
            this.form.remarks = this.form.remarks != null && typeof this.form.remarks != 'undefined' ?
                this.form.remarks.toString() : null;
            this.form.is_external = this.form.is_external == 'true' ? true : false;
        },
        getDocumentTypes() {
            axios.get('document_type_list').then((response) => {
                this.document_types = response.data;
            });
        },
        getOffices() {
            axios.get('office_list').then((response) => {
                this.internal_originating_office = response.data;
            });
        },
        originOfficeHandler() {
            this.external_trigger = !this.external_trigger;
            this.form.originating_office_id = '';
            this.form.external_office_name = '';

        },
        addNewDocument() {
            this.sanitizeInputs();
            axios.post('add_new_document', this.form).then((response) => {

            });
        },
    },
    mounted() {
        this.getDocumentTypes();
        this.getOffices();
    }
}
</script>