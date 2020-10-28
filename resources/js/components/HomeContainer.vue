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
import UserHomeComponent from './user/Home';
export default {
    components: {
        UserHomeComponent
    },
    data() {
        return {
            user: null,
            title: null,
            var_user: null,
        }
    },
    methods: {
        getUser() {
            axios.get('/api/users').then((response) => {
                this.user = response.data;
            });
        }
    },
    created() {

    },
    mounted() {
        this.getUser();
    }
}
</script>