<template>
    <div>
        <div v-if="user">
            <div v-if="user.role_id === 1">
                <admin-dashboard-component></admin-dashboard-component>
            </div>
            <div v-if="user.role_id === 2">
                <user-dashboard-component></user-dashboard-component>
            </div>
        </div>
        <button @click.prevent="logout">Logout</button>
    </div>
</template>

<script>

export default {
    data() {
        return {
            user: null,
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