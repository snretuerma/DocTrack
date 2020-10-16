<template>
    <v-card flat>
        <v-card-title primary-title>
        New Document
        </v-card-title>
        <v-card-subtitle>
            <v-breadcrumbs :items="breadcrumbs">
            <template v-slot:divider>
                <v-icon>mdi-arrow-right-thick</v-icon>
            </template>
            </v-breadcrumbs>
        </v-card-subtitle>
    </v-card>
</template>

<script>
export default {

}
</script>