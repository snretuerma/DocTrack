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

                        <change-password-form :user="user" @update-password="updatePasswordView"></change-password-form>
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
import ChangePasswordForm from './components/ChangePasswordForm';
export default {
    props: ['user'],
    components: {
        ChangeUsernameForm,
        ChangeAccountDetailsForm,
        ChangePasswordForm
    },
    data () {
        return {
            panel: [0],
            snackbar: false,
            snackbar_text: '',
            snackbar_timeout: 2000,
            snackbar_color: '',
            loader: null,
            loading_edit_details: false,
            loading_edit_password: false,
            clicked: '',
        }
    },
    methods: {
        updateAccountDetailView(response) {
            this.snackbar = response.snackbar;
            this.snackbar_text = response.snackbar_text;
            this.snackbar_color = response.snackbar_color;
            if(response.snackbar) {
                this.$emit('update-parent-name', response);
            }
        },
        updateUsernameView(response) {
            this.snackbar = response.snackbar;
            this.snackbar_text = response.snackbar_text;
            this.snackbar_color = response.snackbar_color;
            if(response.snackbar) {
                this.$emit('update-parent-username', response.username);
            }
        },
        updatePasswordView() {
            this.snackbar = response.snackbar;
            this.snackbar_text = response.snackbar_text;
            this.snackbar_color = response.snackbar_color;
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
                this.snackbar_text = error.message;
                this.snackbar_color = 'error';
            });
        },
    },
    mounted() {

    }

}
</script>