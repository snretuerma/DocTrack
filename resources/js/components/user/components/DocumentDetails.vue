<template>
    <div>DOCUMENT DETAILS PAGE</div>
</template>

<script>
export default {
    name: "DocumentDetails",
    mounted() {
        this.$store.dispatch('unsetLoader');
    }
}
</script>