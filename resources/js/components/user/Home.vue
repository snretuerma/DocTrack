<template>
<div v-if="user">
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
                                {{fullName}}
                            </v-list-item-title>
                        </template>
                        <span>{{fullName}}</span>
                    </v-tooltip>
                    <v-list-item-subtitle>{{username}}</v-list-item-subtitle>
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
    <v-main>
        <router-view
            :user="user"
            @update-parent-username="updateUsername"
            @update-parent-name="updateName"
        ></router-view>
    </v-main>
</div>
</template>

<script>
export default {
    props: [
        'user'
    ],
    computed: {
        username: {
            get () {
                return this.user.username;
            },
            set (new_username) {
                this.user.username = new_username;
            }
        },
        fullName: {
            get() {
                return this.buildName(
                    this.user.first_name,
                    this.user.middle_name,
                    this.user.last_name,
                    this.user.suffix
                );
            },
            set(new_value) {
                this.user.first_name = new_value.first_name;
                this.user.middle_name = new_value.middle_name;
                this.user.last_name = new_value.last_name;
                this.user.suffix = new_value.suffix;
            }
        },
        currentRouteName() {
            return this.$route.name;
        },
        placeholderImage() {
            return 'https://randomuser.me/api/portraits/' +
                (Math.floor(Math.random() * 2)+ 1 == 1 ? 'men' : 'women') + '/' +
                Math.floor(Math.random() * 10)+ 1 + '.jpg';
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
        buildName(first_name, middle_name, last_name, suffix) {
            var name =  this.user.first_name.trim() + ' '
                + this.user.middle_name.trim() + ' '
                + this.user.last_name.trim()
            if(this.user.suffix != null && typeof this.user.suffix !== 'undefined') {
                name = name + ' ' + this.user.suffix.trim();
            }
            return name.trim();
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
        }
    },
    mounted() {
    }
}
</script>