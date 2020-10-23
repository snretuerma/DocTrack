<template>
    <v-form v-if="user">
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
        }
    },
    methods: {

    }
}
</script>