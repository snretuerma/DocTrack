<template>
<v-card flat v-if="user">
    <v-card-title primary-title>
        Add New Document
    </v-card-title>
    <v-card-text>
            <v-scroll-x-transition>
                <v-alert
                    outlined
                    :type="alert_type"
                    icon="mdi-check-bold"
                    prominent
                    border="left"
                    text
                    v-if="alert"
                >
                    <v-row align="center">
                        <v-col class="grow">
                            <v-row>
                                <v-col>{{alert_message}}</v-col>
                            </v-row>
                            <v-row>
                                <v-col>{{alert_server_message}}</v-col>
                            </v-row>
                        </v-col>
                        <v-col class="shrink">
                            <v-btn
                                icon
                                :color="alert_type"
                                @click="closeAlert"
                            >
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-alert>
            </v-scroll-x-transition>
        <ValidationObserver ref="observer" v-slot="{ invalid }">
            <v-form ref="form" @submit.prevent="createNewDocument">
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
                                value=false
                            ></v-radio>
                            <v-radio
                                label="External"
                                value=true
                            ></v-radio>
                        </v-radio-group>
                    </v-col>
                    <v-col cols="12" xl="8" lg="8" md="12" v-if="external_trigger">
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
                    <v-col cols="12" xl="8" lg="8" md="12" v-else>
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
                        <v-dialog
                            ref="date_dialog"
                            v-model="datepicker_modal"
                            :return-value.sync="form.date_filed"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <ValidationProvider rules="required" v-slot="{ errors, valid }">
                                    <v-text-field
                                        v-model="form.date_filed"
                                        label="Date Filed"
                                        prepend-inner-icon="mdi-calendar"
                                        readonly
                                        outlined
                                        v-bind="attrs"
                                        v-on="on"
                                        :error-messages="errors"
                                        :success="valid"
                                    ></v-text-field>
                                </ValidationProvider>
                            </template>
                            <v-date-picker
                                v-model="form.date_filed"
                                scrollable
                            >
                                <v-spacer></v-spacer>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="datepicker_modal = false"
                                >
                                    Cancel
                                </v-btn>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="$refs.date_dialog.save(form.date_filed)"
                                >
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </v-col>

                    <v-col cols="12" xl="6" lg="6" md="12">
                        <v-dialog
                            ref="time_dialog"
                            v-model="timepicker_modal"
                            :return-value.sync="form.time_filed"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <ValidationProvider rules="required" v-slot="{ errors, valid }">
                                    <v-text-field
                                        v-model="form.time_filed"
                                        label="Time Filed"
                                        prepend-inner-icon="mdi-clock-time-four-outline"
                                        readonly
                                        outlined
                                        v-bind="attrs"
                                        v-on="on"
                                        :error-messages="errors"
                                        :success="valid"
                                    ></v-text-field>
                                </ValidationProvider>
                            </template>
                            <v-time-picker
                                v-if="timepicker_modal"
                                v-model="form.time_filed"
                                full-width
                            >
                                <v-spacer></v-spacer>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="timepicker_modal = false"
                                >
                                    Cancel
                                </v-btn>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="$refs.time_dialog.save(form.time_filed)"
                                >
                                    OK
                                </v-btn>
                            </v-time-picker>
                        </v-dialog>
                        </v-col>

                    <v-col cols="12" xl="3" lg="3" md="12">
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
                    <v-col cols="12" xl="3" lg="3" md="12">
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
                                    mdi-plus
                                </v-icon>
                                Create
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
            external_trigger: false,
            current_date: new Date().toISOString().substr(0, 10),
            datepicker_modal: false,
            timepicker_modal: false,
            alert: false,
            alert_type: '',
            alert_message: '',
            alert_server_message: '',
            alert_icon: '',
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
                date_filed: '',
                time_filed: '',
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
            var date_stripped = document_data.date_filed.split('-');
            tracking_number = tracking_number +
                origin + '-' +
                this.user.office.office_code + '-' +
                date_stripped[0]+date_stripped[1]+date_stripped[2] + '-' +
                salt + '-' +
                document_data.attachment_page_count;
            return tracking_number;
        },
        sanitizeInputs() {
            this.form.is_external = this.form.is_external == 'true' ? true : false;
            this.form.tracking_id = this.generateTrackingCode(this.form);
            this.form.document_title = this.form.document_title.toString();
            this.form.external_office_name = this.form.external_office_name != null &&
                typeof this.form.external_office_name != 'undefined' ?
                this.form.external_office_name.toString() : null;
            this.form.sender_name = this.form.sender_name.toString();
            this.form.remarks = this.form.remarks != null && typeof this.form.remarks != 'undefined' ?
                this.form.remarks.toString() : null;
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
        createNewDocument() {
            console.log("Submitting");
            this.sanitizeInputs();
            axios.post('add_new_document', this.form)
            .then((response) => {
                this.$refs.form.reset();
                this.$refs.observer.reset();

                this.form.is_external = false;
                this.external_trigger = false;
                this.alert = true;
                this.alert_type = 'success';
                this.alert_server_message = `Server Success Message : ${response.data}`;
                this.alert_message = "The document creation completed";
                setTimeout(()=>{
                    this.alert=false
                },5000);
            })
            .catch(error => {
                this.form.is_external = false;
                this.external_trigger = false;
                this.alert = true;
                this.alert_type = 'error';
                this.alert_server_message = `Server Error Message : ${error.message}`;
                this.alert_message = "The document creation failed. Please check your inputs. \
                    If error persists, contact the administrator";
                setTimeout(()=>{
                    this.alert=false
                },5000);
            });
        },
        createAndForward() {
            // TODO: Create new document then forward to office
        },
        closeAlert() {
            this.alert = false;
            this.alert_type = '';
            this.alert_message = '';
        },
    },
    mounted() {
        this.getDocumentTypes();
        this.getOffices();
    }
}
</script>