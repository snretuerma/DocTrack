<template>
<div>VIEW ALL DOCUMENTS</div>
</template>

<script>
export default {
    data() {
        return {
            documents: [],
        }
    },
    methods: {
        getAllDocuments() {
            axios.get('office_list').then((response) => {
                this.documents = response.data;
                console.log(this.documents);
            });
        },
    },
    mounted() {
        this.getAllDocuments();
    }
}
</script>