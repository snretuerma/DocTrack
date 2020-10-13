<template>
    <v-card
        class="mx-auto"
        max-width="90%"
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
                        <v-form>
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
                        <v-form>
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
                        Edit Password
                        <template v-slot:actions>
                            <v-icon>
                                mdi-form-textbox-password
                            </v-icon>
                        </template>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-form>
                            <v-row>
                                <v-col
                                    cols="12"
                                >
                                    <ValidationProvider rules="required|min:6" v-slot="{ errors, valid }">
                                        <v-text-field
                                            outlined
                                            v-model="password_form.old_passowrd"
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
    </v-card>
</template>

<script>
import { ValidationObserver, ValidationProvider, extend } from 'vee-validate';
extend('min_len', {
    validate: value => {
        return value % 2 !== 0;
    },
    message: 'This field must be an odd number'
});

export default {
    components: {
        ValidationProvider,
        ValidationObserver
    },
    data () {
        return {
            panel: [0],
            name_form: {
                first_name: '',
                middle_name: '',
                last_name: '',
                name_suffix: '' ,
            },
            username_form: {
                new_username: '',
                confirm_username: '',
            },
            password_form: {
                old_password: '',
                new_password: '',
                confirm_password: '',
            },
            show_old_password: false,
            show_new_password: false,
            show_confirm_password: false,
        }
    },
}
</script>