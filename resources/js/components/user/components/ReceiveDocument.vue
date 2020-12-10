<template>
    <v-card flat>
        <v-card-title primary-title>
            Receive Document : {{ selected_document.tracking_code }}
        </v-card-title>
        <v-card-text>
            <v-form>

            </v-form>
        </v-card-text>
    </v-card>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    computed: {
        ...mapGetters(['selected_document']),
    },
    data() {
        return {

        }
    },
    mounted() {

    }
}
</script>