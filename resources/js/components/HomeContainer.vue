<template>
    <div>
        <div v-if="user">
            <div v-if="user.role_id === 1">
                <!-- <admin-dashboard-component :user="user"></admin-dashboard-component> -->
            </div>
            <div v-if="user.role_id === 2">
                <user-home-component :user="user"></user-home-component>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            user: null,
            title: null,
        }
    },
    methods: {
        getUser() {
            axios.get('/api/user').then((response)=>{
                this.user = response.data;
            });
        }
    },
    mounted() {
        this.getUser();
    }
}
</script>