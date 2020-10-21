<template>
     <v-card
        class="mx-auto"
        flat
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
                        <v-form id='account_details' method="put" @submit.prevent="editAccountDetails">
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
                                        :loading="loading"
                                        @click="loader = 'loading';loading=true"
                                    >
                                        Submit
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
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
                        <v-form id='account_username' method="put" @submit.prevent="editUsername">
                            <ValidationObserver>
                                <v-row>
                                    <v-col
                                        cols="12"
                                    >
                                        <ValidationProvider
                                            rules="required"
                                            v-slot="{ errors, valid }"
                                            vid="username"
                                            name="New Username"
                                        >
                                            <v-text-field
                                                outlined
                                                v-model="username_form.new_username"
                                                label="New Username"
                                                :error-messages="errors"
                                                :success="valid"
                                            ></v-text-field>
                                        </ValidationProvider>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                    >
                                        <ValidationProvider
                                            rules="required|confirmed:username"
                                            v-slot="{ errors, valid }"
                                            name="Confirm New Username"
                                        >
                                            <v-text-field
                                                outlined
                                                v-model="username_form.confirm_username"
                                                label="Confirm New Username"
                                                :error-messages="errors"
                                                :success="valid"
                                            ></v-text-field>
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
                            <v-row justify="center">
                            <v-dialog
                                v-model="dialog"
                                persistent
                                max-width="400px"
                            >
                                <v-card>
                                    <v-card-title class="headline light-blue lighten-5">
                                        Edit Username
                                    </v-card-title>
                                    <v-card-text>
                                        Are you sure you want to change your account username?
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="primary darken-1"
                                            text
                                            @click="dialog = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            color="primary darken-1"
                                            text
                                            type="submit"
                                            @click="dialog = false"
                                        >
                                            Confirm
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-row>
                        </v-form>
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
function myFunction() {
  alert("The form was submitted");
}
import { ValidationObserver, ValidationProvider, extend } from 'vee-validate';
export default {
    name: "AccountSettings",
    // props: {
    //     user: {
    //         type: Object,
    //         required: true
    //     }
    // },
    components: {
        ValidationProvider,
        ValidationObserver,
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
            username_form: {
                form_type: 'account_username',
                new_username: '',
                confirm_username: '',
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
            loading: false,
            dialog: false,
            clicked: '',
        }
    },
    methods: {
        editAccountDetails() {
            if(this.$route.params.user) {
                axios.put('/api/users/'  + this.$route.params.user.id, this.name_form)
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
                this.loading = false;
                this.loader = null;
            }
        },
        editUsername() {
            if(this.$route.params.user) {
                axios.put('/api/users/'  + this.$route.params.user.id, this.username_form)
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
            }
        },
        editPassword() {
            if(this.$route.params.user) {
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
            }
        },
    },
    mounted() {

    }

}
</script>