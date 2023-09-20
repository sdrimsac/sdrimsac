<template>
    <el-dialog :visible="showDialog" append-to-body @close="close" @open="open"
    title="Emitir nota"
    width="80%"
    >
        <template v-if="!document_affected"></template>
        <template v-else>
            <note-form
                ref="noteForm"
                @success="success"
                :external="true"
                @close="close"
                :document_affected.sync="document_affected"
                :configuration="configuration"
            ></note-form>
        </template>
    </el-dialog>
</template>

<script>
import NoteForm from "../../../../../../../../resources/js/views/documents/note.vue";

export default {
    props: ["recordId", "configuration", "showDialog"],
    components: {
        NoteForm
    },
    data() {
        return {
            document_affected: null
        };
    },
    methods: {
        async getDocument() {
            const response = await this.$http.get(
                `/documents/get_record/${this.recordId}`
            );
            if (response.status == 200) {
                const { data } = response;
                this.document_affected = data;
                setTimeout(() => {
                    this.$refs.noteForm.initComponent();
                }, 50);
            }
        },
        success(){
            this.close();
            this.$emit("getRecords");
        },
        open() {
            this.getDocument();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
