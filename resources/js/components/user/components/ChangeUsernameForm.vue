<template>
    <v-form v-if="user">
        <ValidationObserver ref="observer" v-slot="{ invalid }">
            <v-row>
                <v-col cols="12">
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
                            required
                        ></v-text-field>
                    </ValidationProvider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
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
                            required
                        ></v-text-field>
                    </ValidationProvider>
                </v-col>
            </v-row>
            <v-row>
                <v-col
                    align="center"
                    justify="end"
                >
                    <v-btn
                        color="primary"
                        :dark="!invalid"
                        :disabled="invalid"
                        @click="dialog = true"
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
                                    @click.prevent="editUsername"
                                >
                                    Confirm
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                </v-dialog>
            </v-row>
        </ValidationObserver>
    </v-form>
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
            dialog: false,
            username_form: {
                form_type: 'account_username',
                new_username: '',
                confirm_username: '',
            },
            loader: null,
            loading_edit_username: false,
        }
    },
    methods: {
        async editUsername() {
            const isValid = await this.$refs.observer.validate();
            if(isValid) {
                var response_data = {
                    snackbar : false,
                    snackbar_text: null,
                    snackbar_color: null,
                    username: null,
                }
                axios.put('/api/users/'  + this.user.id, this.username_form)
                .then(response => {
                    if(response.data.code == 'Success') {
                        response_data.snackbar = true;
                        response_data.snackbar_text = response.data.message;
                        response_data.snackbar_color = 'success';
                        response_data.username = this.username_form.new_username;
                    } else {
                        response_data.snackbar = true;
                        response_data.snackbar_text = response.data.message;
                        response_data.snackbar_color = 'error';
                    }
                })
                .catch(error => {
                    response_data.snackbar = true;
                    response_data.snackbar_text = response.error.message;
                    response_data.snackbar_color = 'error';
                });
                this.$emit('update-username', response_data);
                this.dialog = false;
            }
        },
    }
}
</script>