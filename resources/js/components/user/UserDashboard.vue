<template>
    <div v-if="user">
        <v-navigation-drawer app v-model="drawer">
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
            <v-list-item link>
                <v-list-item-icon>
                    <v-icon>fas fa-home</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item link>
                <v-list-item-icon>
                    <v-icon>fas fa-sign-out-alt</i></v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>

        <template v-slot:append>
            <div class="pa-2">
                <v-btn block @click.stop="drawer = !drawer">
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
        <v-app-bar-nav-icon class="d.none .d-sm-flex" @click.stop="drawer = !drawer">
            <i class="fas fa-bars"/>
        </v-app-bar-nav-icon>
        <v-toolbar-title>Logo</v-toolbar-title>
    </v-app-bar>
</div>
</template>

<script>
export default {
    data() {
        return {
            user: null,
            drawer: true,
            group: null,
        }
    },
    computed: {

    },
    methods: {
        getUser() {
            axios.get('/api/user').then((response)=>{
                this.user = response.data;
            });
        },
        logout(){
            axios.post('/api/logout').then(()=>{
                this.$router.push({ name: "Login"})
            })
        }
    },
    mounted() {
        this.getUser();
    }
}
</script>