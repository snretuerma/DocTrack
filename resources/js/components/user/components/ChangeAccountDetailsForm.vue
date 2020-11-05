<template>
    <v-form
        ref="form"
        @submit.prevent="updateAccountDetails"
    >
        <ValidationObserver ref="observer" v-slot="{ invalid }">
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
                    <ValidationProvider rules="alpha_spaces" v-slot="{ errors }">
                        <v-text-field
                            id="suffix_field"
                            outlined
                            v-model="name_form.name_suffix"
                            label="Suffix (Optional)"
                            :error-messages="errors"
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
                        type="submit"
                        :dark="!invalid"
                        :disabled="invalid"
                        :loading="loading_edit_details"
                        @click="loader = 'loading_edit_details'"
                    >
                        <v-icon left dark>
                            mdi-send-circle-outline
                        </v-icon>
                        Submit
                    </v-btn>
                </v-col>
            </v-row>
        </ValidationObserver>
    </v-form>
</template>

<script>
import { mapGetters } from "vuex";
import { ValidationObserver, ValidationProvider, extend } from 'vee-validate';
export default {
    computed: mapGetters(["auth_user"]),
    components: {
        ValidationProvider,
        ValidationObserver
    },
    data() {
        return {
            name_form: {
                form_type: 'account_details',
                first_name: '',
                middle_name: '',
                last_name: '',
                name_suffix: '' ,
            },
            loader: null,
            loading_edit_details: false,
        }
    },
    methods: {
        updateAccountDetails() {
            this[this.loader] = !this[this.loader];
            const isValid = this.$refs.observer.validate();
            if(isValid){
                var response_data = {
                    snackbar : false,
                    snackbar_text: null,
                    snackbar_color: null,
                    first_name: null,
                    middle_name: null,
                    last_name: null,
                    suffix: null
                }
                axios.put(`/api/users/${this.auth_user.id}`, this.name_form)
                .then(response => {
                    if(response.data.code == 'Success') {
                        response_data.snackbar = true;
                        response_data.snackbar_text = response.data.message;
                        response_data.snackbar_color = 'success';
                        response_data.first_name = this.name_form.first_name;
                        response_data.middle_name = this.name_form.middle_name;
                        response_data.last_name = this.name_form.last_name;
                        response_data.suffix = this.name_form.name_suffix;
                        this.$refs.form.reset();
                        this.$refs.observer.reset();
                        this[this.loader] = false
                        this.loader = null;
                    } else {
                        response_data.snackbar = true;
                        response_data.snackbar_text = response.data.message;
                        response_data.snackbar_color = 'error';
                        this[this.loader] = false
                        this.loader = null;
                    }
                    this.$emit('update-details', response_data);
                })
                .catch(error => {
                    response_data.snackbar = true;
                    response_data.snackbar_text = error.message;
                    response_data.snackbar_color = 'error';
                    this[this.loader] = false
                    this.loader = null;
                    this.$emit('update-details', response_data);
                });
            }
        }
    }
}
</script>