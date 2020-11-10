<template>
<div>VIEW ALL DOCUMENTS</div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    methods: {
        ...mapActions(['getDocuments', 'unsetLoader']),
    },
    mounted() {
        this.unsetLoader();
        this.getDocuments();
    }
}
</script>