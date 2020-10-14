<template>
<v-row>
    <v-col cols="12" xl="6" lg="6" md="6">
        <v-card
            class="mx-auto document_record_card"
            color="#E1EBEE"
        >
            <v-card-title>
                <span class="title font-weight-bold">New Document</span>
            </v-card-title>

            <v-divider class="mx-4"></v-divider>

            <v-card-text class="font-weight-light document_record_card_text">
                <span class="subtitle font-weight-bold">Create a new document for routing</span>
            </v-card-text>
            <v-card-actions
                align="right"
                justify="end"
            >
                <v-list-item class="grow">
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-btn
                                class="ma-2"
                                fab
                                color="#0D47A1"
                                dark
                                link @click.prevent="getNewDocumentPage"
                            >
                                <v-icon>mdi-file-document-multiple-outline</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-list-item>
            </v-card-actions>
        </v-card>
    </v-col>
    <v-col cols="12" xl="6" lg="6" md="6">
        <v-card
            class="mx-auto"
            color="#E1EBEE"
        >
            <v-card-title>
                <span class="title font-weight-bold">Receive Document</span>
            </v-card-title>
            <v-divider class="mx-4"></v-divider>
            <v-card-text class="font-weight-light document_record_card_text">
                <span class="subtitle font-weight-bold">
                    Receive an existing document routed to your office by scanning or entering the document
                    routing number
                </span>
            </v-card-text>

            <v-card-actions
                align="right"
                justify="end"
            >
                <v-list-item class="grow">
                    <v-row no-gutters>
                        <v-col cols="9">
                            <v-form ref="form">
                                <v-text-field
                                    label="Routing Number"
                                    clearable
                                ></v-text-field>
                            </v-form>
                        </v-col>
                        <v-col cols="3">
                            <v-btn
                                class="ma-2"
                                fab
                                color="#0D47A1"
                                dark
                            >
                                <v-icon>mdi-email-open-outline</v-icon>
                            </v-btn>
                        </v-col>

                    </v-row>
                </v-list-item>
            </v-card-actions>
        </v-card>
    </v-col>
    <v-col cols="12" xl="6" lg="6" md="6">
        <v-card
            class="mx-auto"
            color="#E1EBEE"
            max-width="100%"
        >
            <v-card-title>
                <span class="title font-weight-bold">Forward Document</span>
            </v-card-title>
            <v-divider class="mx-4"></v-divider>
            <v-card-text class="font-weight-light document_record_card_text">
                <span class="subtitle font-weight-bold">Forward an existing document to another office</span>
            </v-card-text>

            <v-card-actions
                align="right"
                justify="end"
            >
                <v-list-item class="grow">
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-btn
                                class="ma-2"
                                fab
                                color="#0D47A1"
                                dark
                            >
                                <v-icon>mdi-email-send-outline</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-list-item>
            </v-card-actions>
        </v-card>
    </v-col>
    <v-col cols="12" xl="6" lg="6" md="6">
        <v-card
            class="mx-auto"
            color="#E1EBEE"
            max-width="100%"
        >
            <v-card-title>
                <span class="title font-weight-bold">Set Document to Terminal</span>
            </v-card-title>
            <v-divider class="mx-4"></v-divider>
            <v-card-text class="font-weight-light document_record_card_text">
                <span class="subtitle font-weight-bold">Set an existing document as terminal</span>
            </v-card-text>

            <v-card-actions
                align="right"
                justify="end"
            >
                <v-list-item class="grow">
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-btn
                                class="ma-2"
                                fab
                                color="#0D47A1"
                                dark
                            >
                                <v-icon>mdi-close-outline</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-list-item>
            </v-card-actions>
        </v-card>
    </v-col>
</v-row>
</template>

<script>
export default {
    methods: {
        getNewDocumentPage() {
            axios.get('new_document').then(()=>{
                this.$router.push({ name: "New Document"})
            })
        },
        getReceiveDocumentPage() {

        },
        getForwardDocumentPage() {

        },
        getSetTerminalDocumentPage() {

        }
    }
}
</script>

<style lang="css">
.document_record_card {
    min-height:150px;
}
.document_record_card_text {
    min-height:150px;
}
</style>