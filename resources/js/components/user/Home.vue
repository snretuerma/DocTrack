<template>
<div v-if="user">
    <v-navigation-drawer app color="#E1EBEE" v-model="drawer">
        <template v-slot:prepend>
            <v-list-item two-line>
                <v-list-item-avatar>
                    <img src="https://randomuser.me/api/portraits/women/81.jpg">
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>{{user.first_name + ' ' + user.last_name}}</v-list-item-title>
                    <v-list-item-subtitle>{{user.username}}</v-list-item-subtitle>
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

            <v-list-item link @click.prevent="getDocumentRecords">
                <v-list-item-icon>
                    <v-icon>mdi-file-document-multiple-outline</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Document Records</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item link @click.prevent="getReports">
                <v-list-item-icon>
                    <v-icon>mdi-timeline-check-outline</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Reports</v-list-item-title>
                </v-list-item-content>
            </v-list-item>


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
                <v-btn block tile @click.stop="drawer = !drawer" outlined color="primary">
                    <v-icon left>
                        mdi-window-close
                    </v-icon>
                    Close
                </v-btn>
            </div>
        </template>
    </v-navigation-drawer>

    <v-app-bar
        app
        color="blue darken-3"
        dark
    >
        <v-app-bar-nav-icon class="d.none .d-sm-flex" @click.stop="drawer = !drawer" >
            <v-icon>mdi-menu</v-icon>
        </v-app-bar-nav-icon>
        <v-toolbar-title>{{currentRouteName}}</v-toolbar-title>
    </v-app-bar>
    <v-main>
        <v-container fluid>
            <router-view></router-view>
        </v-container>
    </v-main>
</div>
</template>

<script>
export default {
    props: [
        'user'
    ],
    computed: {
        currentRouteName() {
            return this.$route.name;
        }
    },
    data() {
        return {
            drawer: true,
            group: null,
        }
    },
    methods: {
        logout(){
            axios.post('/api/logout').then(()=>{
                this.$router.push({ name: "Login"})
            })
        },
        getDashboard() {
            axios.get('/').then(()=>{
                if(this.$route.name !== 'Dashboard') {
                    this.$router.push({ name: "Dashboard"})
                }
            })
        },
        getDocumentRecords() {
            axios.get('document_records').then(()=>{
                if(this.$route.name !== 'Document Records') {
                    this.$router.push({ name: "Document Records"})
                }
            })
        },
        getReports() {
            axios.get('reports').then(()=>{
                if(this.$route.name !== 'Reports') {
                    this.$router.push({ name: "Reports"})
                }
            })
        },
        getAccountSettings() {
            axios.get('account_settings').then(()=>{
                if(this.$route.name !== 'Account Settings') {
                    this.$router.push({ name: "Account Settings"})
                }
            })
        }
    },
    mounted() {

    }
}
</script>