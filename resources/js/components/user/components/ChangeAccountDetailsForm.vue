<template>
<v-form v-if="user" @submit.prevent="updateAccountDetails">
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
                    type="submit"
                    :dark="!invalid"
                    :disabled="invalid"
                    :loading="loading_edit_details"
                    @click="loader = 'loading_edit_details'"
                >
                    Submit
                </v-btn>
            </v-col>
        </v-row>
    </ValidationObserver>
</v-form>
</template>

<script>
import { ValidationObserver, ValidationProvider, extend } from 'vee-validate';
export default {
    props:['user'],
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
        // TODO: update database logic

        //     this[this.loader] = !this[this.loader];
        //     axios.put('/api/users/'  + this.$route.params.user.id, this.name_form)
        //     .then(response => {
        //         if(response.data.code == 'Success') {
        //             console.log('success_respose');
        //             this.snackbar = true;
        //             this.snackbar_text = response.data.message;
        //             this.snackbar_color = 'success';
        //             this[this.loader] = false
        //             this.loader = null;
        //         } else {
        //             console.log('error_respose');
        //             this.snackbar = true;
        //             this.snackbar_text = response.data.message;
        //             this.snackbar_color = 'error';
        //             this[this.loader] = false
        //             this.loader = null;
        //         }
        //     })
        //     .catch(error => {
        //         console.log('catch_error');
        //         this.snackbar = true;
        //         this.snackbar_text = response.error.message;
        //         this.snackbar_color = 'error';
        //         this[this.loader] = false
        //         this.loader = null;
        //     });
        //     this.$emit('update-details', this.name_form);
        // }
    }
}
</script>