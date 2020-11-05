<template>
    <div>
        <div v-if="auth_user">
            <div v-if="auth_user.role_id === 1">
                <!-- <admin-dashboard-component :user="user"></admin-dashboard-component> -->
            </div>
            <div v-if="auth_user.role_id === 2">
                <user-home-component></user-home-component>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import UserHomeComponent from './user/Home';
export default {
    name: "HomeContainer",
    components: {
        UserHomeComponent
    },
    computed: mapGetters(["auth_user"]),
    methods: mapActions(["getAuthUser"]),
    mounted() {
        this.getAuthUser();
    }
}
</script>