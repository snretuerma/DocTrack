<template>
    <v-card
        class="mx-auto"
        flat
        v-if="user"
    >
        <v-card-title>
            <v-icon
            left
            >
                mdi-account-edit
            </v-icon>
            <span class="title">Edit Account Info</span>
        </v-card-title>

        <v-card-text class="headline font-weight-bold">
            <v-expansion-panels
                focusable
                flat
                v-model="panel"
                multiple
            >
                <v-expansion-panel>
                    <v-expansion-panel-header disable-icon-rotate>
                        Edit Account details
                        <template v-slot:actions>
                            <v-icon>
                                mdi-account-details
                            </v-icon>
                        </template>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <change-account-details-form
                            :user="user"
                            @update-details="updateAccountDetailView"
                        ></change-account-details-form>
                        <!-- <v-form id='account_details' method="put" @submit.prevent="editAccountDetails">
                            <v-row>
                                <v-col cols="12" xl="6" lg="6" md="12" sm="12">
                                    <ValidationProvider rules="required" v-slot="{ errors, valid }">
                                        <v-text-field
                                            outlined
                                            v-model="name_form.first_name"
                                            label="First Name"
                                            :error-messages="errors"
                                            :success="valid"
                                        ></v-text-field>
                                    </ValidationProvider>
                                </v-col>
                                <v-col cols="12" xl="6" lg="6" md="12" sm="12">
                                    <ValidationProvider rules="required" v-slot="{ errors, valid }">
                                        <v-text-field
                                            outlined
                                            v-model="name_form.middle_name"
                                            label="Middle Name"
                                            :error-messages="errors"
                                            :success="valid"
                                        ></v-text-field>
                                    </ValidationProvider>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" xl="9" lg="9" md="9" sm="12">
                                    <ValidationProvider rules="required" v-slot="{ errors, valid }">
                                        <v-text-field
                                            outlined
                                            v-model="name_form.last_name"
                                            label="Last Name"
                                            :error-messages="errors"
                                            :success="valid"
                                        ></v-text-field>
                                    </ValidationProvider>
                                </v-col>
                                <v-col cols="12" xl="3" lg="3" md="3" sm="12">
                                    <v-text-field
                                        outlined
                                        v-model="name_form.name_suffix"
                                        label="Suffix (Optional)"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    align="center"
                                    justify="end"
                                >
                                    <v-btn
                                        color="primary"
                                        dark
                                        type="submit"
                                        :loading="loading_edit_details"
                                        @click="loader = 'loading_edit_details'"
                                    >
                                        Submit
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-form> -->
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel>
                    <v-expansion-panel-header disable-icon-rotate>
                        Edit Username
                        <template v-slot:actions>
                            <v-icon>
                                mdi-form-textbox
                            </v-icon>
                        </template>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <change-username-form :user="user" @update-username="updateUsernameView"></change-username-form>
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel>
                    <v-expansion-panel-header disable-icon-rotate>
                        Edit Password
                        <template v-slot:actions>
                            <v-icon>
                                mdi-form-textbox-password
                            </v-icon>
                        </template>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-form id='account_password' method="put" @submit.prevent="editPassword">
                            <v-row>
                                <v-col
                                    cols="12"
                                >
                                    <ValidationProvider rules="required|min:6" v-slot="{ errors, valid }">
                                        <v-text-field
                                            outlined
                                            v-model="password_form.old_password"
                                            label="Old Password"
                                            :append-icon="show_old_password ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show_old_password ? 'text' : 'password'"
                                            @click:append="show_old_password = !show_old_password"
                                            :error-messages="errors"
                                            :success="valid"
                                        >
                                        </v-text-field>
                                    </ValidationProvider>
                                </v-col>
                            </v-row>
                            <ValidationObserver>
                                <v-row>
                                    <v-col
                                        cols="12"
                                    >
                                        <ValidationProvider
                                            name="confirm"
                                            rules="required|min:6"
                                            v-slot="{ errors, valid }"
                                        >
                                            <v-text-field
                                                outlined
                                                v-model="password_form.new_password"
                                                label="New Password"
                                                :append-icon="show_new_password ? 'mdi-eye' : 'mdi-eye-off'"
                                                :type="show_new_password ? 'text' : 'password'"
                                                @click:append="show_new_password = !show_new_password"
                                                :error-messages="errors"
                                                :success="valid"
                                            >
                                            </v-text-field>
                                        </ValidationProvider>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <ValidationProvider
                                            rules="required|min:6|password:@confirm"
                                            v-slot="{ errors, valid }"
                                        >
                                            <v-text-field
                                                outlined
                                                v-model="password_form.confirm_password"
                                                label="Confirm New Password"
                                                :append-icon="show_confirm_password ? 'mdi-eye' : 'mdi-eye-off'"
                                                :type="show_confirm_password ? 'text' : 'password'"
                                                @click:append="show_confirm_password = !show_confirm_password"
                                                :error-messages="errors"
                                                :success="valid"
                                            >
                                            </v-text-field>
                                        </ValidationProvider>
                                    </v-col>
                                </v-row>
                            </ValidationObserver>
                            <v-row>
                                <v-col
                                    align="center"
                                    justify="end"
                                >
                                    <v-btn
                                        color="primary"
                                        dark
                                        type="submit"
                                    >
                                        Submit
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-card-text>
        <v-snackbar
            v-model="snackbar"
            :timeout="snackbar_timeout"
            :multi-line="true"
            :color="snackbar_color"
        >
        {{ snackbar_text }}
        <template v-slot:action="{ attrs }">
            <v-btn
                color="black"
                text
                v-bind="attrs"
                @click="snackbar = false; snackbar_text=''"
            >
                Close
            </v-btn>
        </template>
        </v-snackbar>
    </v-card>
</template>

<script>
import ChangeUsernameForm from './components/ChangeUsernameForm';
import ChangeAccountDetailsForm from './components/ChangeAccountDetailsForm';
import { ValidationObserver, ValidationProvider, extend } from 'vee-validate';
export default {
    props: ['user'],
    components: {
        ValidationProvider,
        ValidationObserver,
        ChangeUsernameForm,
        ChangeAccountDetailsForm
    },
    data () {
        return {
            panel: [0],
            name_form: {
                form_type: 'account_details',
                first_name: '',
                middle_name: '',
                last_name: '',
                name_suffix: '' ,
            },
            password_form: {
                form_type: 'account_password',
                old_password: '',
                new_password: '',
                confirm_password: '',
            },
            show_old_password: false,
            show_new_password: false,
            show_confirm_password: false,
            snackbar: false,
            snackbar_text: '',
            snackbar_timeout: 2000,
            snackbar_color: '',
            loader: null,
            loading_edit_details: false,
            loading_edit_password: false,
            clicked: '',
            new_username: '',
            new_first_name: '',
            new_middle_name: '',
            new_last_name: '',
            new_suffix: '',
        }
    },
    methods: {
        editAccountDetails() {
            this[this.loader] = !this[this.loader];
            axios.put('/api/users/'  + this.$route.params.user.id, this.name_form)
            .then(response => {
                if(response.data.code == 'Success') {
                    console.log('success_respose');
                    this.snackbar = true;
                    this.snackbar_text = response.data.message;
                    this.snackbar_color = 'success';
                    this[this.loader] = false
                    this.loader = null;
                } else {
                    console.log('error_respose');
                    this.snackbar = true;
                    this.snackbar_text = response.data.message;
                    this.snackbar_color = 'error';
                    this[this.loader] = false
                    this.loader = null;
                }
            })
            .catch(error => {
                console.log('catch_error');
                this.snackbar = true;
                this.snackbar_text = response.error.message;
                this.snackbar_color = 'error';
                this[this.loader] = false
                this.loader = null;
            });
        },
        updateAccountDetailView(response) {
            console.log(response);
        },
        updateUsernameView(response) {
            this.snackbar = response.snackbar;
            this.snackbar_text = response.snackbar_text;
            this.snackbar_color = response.snackbar_color;
            if(response.snackbar == 'success') {
                // TODO: Emit to parent component
            }
        },
        editPassword() {
            axios.put('/api/users/'  + this.$route.params.user.id, this.password_form)
            .then(response => {
                if(response.data.code == 'Success') {
                    this.snackbar = true;
                    this.snackbar_text = response.data.message;
                    this.snackbar_color = 'success';
                } else {
                    this.snackbar = true;
                    this.snackbar_text = response.data.message;
                    this.snackbar_color = 'error';
                }
            })
            .catch(error => {
                this.snackbar = true;
                this.snackbar_text = response.error.message;
                this.snackbar_color = 'error';
            });
        },
    },
    mounted() {

    }

}
</script>