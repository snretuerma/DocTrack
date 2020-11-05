<template>
<div v-if="auth_user">
    <v-navigation-drawer app v-model="drawer">
        <template v-slot:prepend>
            <v-list-item two-line>
                <v-list-item-avatar>
                    <img :src="placeholderImage">
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item-title
                                v-bind="attrs"
                                v-on="on"
                            >
                                {{auth_user_full_name}}
                            </v-list-item-title>
                        </template>
                        <span>{{auth_user_full_name}}</span>
                    </v-tooltip>
                    <v-list-item-subtitle>{{auth_user.username}}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </template>

        <v-divider></v-divider>

        <v-list>

            <v-list-item link @click.prevent="getDashboard">
            <v-list-item-icon>
                <v-icon>mdi-view-dashboard-outline</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
                <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item-content>
            </v-list-item>

            <v-list-group
                prepend-icon="mdi-file-document-multiple-outline"
                no-action
            >
                <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title>Document</v-list-item-title>
                    </v-list-item-content>
                </template>
                <v-list-item link @click.prevent="getAllDocuments" v-ripple="{ class: 'primary--text' }">
                    <v-list-item-icon>
                    <v-icon>mdi-book-search-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>View</v-list-item-title>
                </v-list-item>
                <v-list-item link @click.prevent="getNewDocumentRecordForm" v-ripple="{ class: 'primary--text' }">
                    <v-list-item-icon>
                    <v-icon>mdi-file-document-edit-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Create</v-list-item-title>
                </v-list-item>
                <v-list-item link @click.prevent="getMasterListReport" v-ripple="{ class: 'primary--text' }">
                    <v-list-item-icon>
                    <v-icon>mdi-email-receive-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Receive</v-list-item-title>
                </v-list-item>
                <v-list-item link @click.prevent="getMasterListReport" v-ripple="{ class: 'primary--text' }">
                    <v-list-item-icon>
                    <v-icon>mdi-email-send-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Forward</v-list-item-title>
                </v-list-item>
                <v-list-item link @click.prevent="getMasterListReport" v-ripple="{ class: 'primary--text' }">
                    <v-list-item-icon>
                    <v-icon>mdi-check-underline-circle-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Terminal</v-list-item-title>
                </v-list-item>
            </v-list-group>

            <v-list-group
                prepend-icon="mdi-timeline-check-outline"
                no-action
            >
                <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title>Reports</v-list-item-title>
                    </v-list-item-content>
                </template>
                <v-list-item link @click.prevent="getAgingReport" v-ripple="{ class: 'primary--text' }">
                    <v-list-item-icon>
                    <v-icon>mdi-timeline-clock-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Aging</v-list-item-title>
                </v-list-item>
                <v-list-item link @click.prevent="getMasterListReport" v-ripple="{ class: 'primary--text' }">
                    <v-list-item-icon>
                    <v-icon>mdi-timeline-text</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Master List</v-list-item-title>
                </v-list-item>
            </v-list-group>

            <v-list-item link @click.prevent="getAccountSettings">
                <v-list-item-icon>
                    <v-icon>mdi-account-cog-outline</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Account Settings</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item link @click.prevent="logout">
                <v-list-item-icon>
                    <v-icon>mdi-logout-variant</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>

        <template v-slot:append>
            <div class="pa-2">
                <v-btn block @click.stop="drawer = !drawer">
                    <v-icon left>
                        mdi-close-circle-outline
                    </v-icon>
                    Hide
                </v-btn>
            </div>
        </template>
    </v-navigation-drawer>

    <v-app-bar
        app
        color="blue darken-3"
        dark
    >
        <v-app-bar-nav-icon class=".d-none .d-sm-flex .d-md-none" @click.stop="drawer = !drawer">
            <v-icon>mdi-menu</v-icon>
        </v-app-bar-nav-icon>
        <v-toolbar-title>{{currentRouteName}}</v-toolbar-title>
    </v-app-bar>
    <v-main fluid>
        <v-container>
            <v-scroll-x-transition mode="out-in" :hide-on-leave="Boolean(true)">
                <router-view
                    :user="auth_user"
                    @update-parent-username="updateUsername"
                    @update-parent-name="updateName"
                ></router-view>
            </v-scroll-x-transition>
        </v-container>
    </v-main>
</div>
</template>

<script>
// TODO: Migrate to Vuex
import { mapGetters, mapActions } from "vuex";
export default {
    computed: {
        ...mapGetters(["auth_user", "auth_user_full_name"]),
        currentRouteName() {
            return this.$route.name;
        },
        placeholderImage() {
            return `${this.image_source+(this.getRandomInt(0,2) == 1 ? 'men':'women')}/${this.getRandomInt(1, 100)}.jpg`;
        }
    },
    data() {
        return {
            drawer: true,
            group: null,
            image_source: 'https://randomuser.me/api/portraits/'
        }
    },
    methods: {
        ...mapActions(["removeAuthUser"]),
        logout(){
            this.removeAuthUser();
            this.$router.push({ name: "Login"})
        },
        buildName(first_name, middle_name, last_name, suffix) {
            var name =  this.capitalize(this.user.first_name.trim()) + ' '
                + this.capitalize(this.user.middle_name.trim()) + ' '
                + this.capitalize(this.user.last_name.trim());
            this.user.suffix != null && typeof this.user.suffix !== 'undefined' ?
                name = name + ' ' + this.capitalize(this.user.suffix.trim()) : null;
            return name.trim();
        },
        getDashboard() {
            axios.get('/').then(()=>{
                if(this.$route.name !== 'Dashboard') {
                    this.$router.push({ name: "Dashboard"})
                }
            })
        },
        getNewDocumentRecordForm() {
            axios.get('new_document').then(() => {
                if(this.$route.name !== 'New Document') {
                    this.$router.push({ name: "New Document"});
                }
            });
        },

        getAllDocuments() {
            axios.get('all_documents').then(() => {
                if(this.$route.name !== 'All Documents') {
                    this.$router.push({ name: "All Documents"});
                }
            });
        },
        getAgingReport() {
            axios.get('reports/aging').then(()=>{
                if(this.$route.name !== 'Document Aging Report') {
                    this.$router.push({ name: "Document Aging Report"});
                }
            });
        },
        getMasterListReport() {
            axios.get('reports/master_list').then(()=>{
                if(this.$route.name !== 'Document Master List') {
                    this.$router.push({ name: "Document Master List"})
                }
            });
        },
        getAccountSettings() {
            axios.get('account_settings').then(()=>{
                if(this.$route.name !== 'Account Settings') {
                    this.$router.push({ name: "Account Settings",  params: { user: this.user }})
                }
            })
        },
        updateUsername(response) {
            this.username = response;
        },
        updateName(response) {
            this.fullName = response;
        },
        capitalize(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min) + min);
        }
    },
    mounted() {
    }
}
</script>