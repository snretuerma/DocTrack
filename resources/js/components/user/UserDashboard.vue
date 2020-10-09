<template>
    <div>
        <div v-if="user">
            Name: {{user.name}} <br>
            Username: {{user.username}}<br>
        </div>
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