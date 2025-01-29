<template>
    <el-dialog
        title="Documentos"
        :visible="showDialog"
        @close="close"
        @open="open"
    >
        <div v-loading="loading">
            <div class="row m-2">
                <div class="col-12">
                    <span class="text-muted h4">
                        DOCUMENTOS DE ADELANTO
                    </span>
                </div>
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Fecha de vencimiento</th>
                                <th>Pdf</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(document, idx) in documents" :key="idx">
                                <td>{{ document.number }}</td>
                                <td>{{ document.date_of_issue }}</td>
                                <td>{{ document.total }}</td>
                                <td class="text-danger">{{ document.due_date }}</td>
                                <td>

                                    <a
                                        :href="document.pdf"
                                        target="_blank"
                                        style="margin-right:5px;"
                                        type="button"
                                        class="btn btn-success btn-sm"
                                    >
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["rentId", "showDialog"],
    data() {
        return {
            documents: [],
            dialogVisible: false,
            loading: false
        };
    },
    methods: {
        getDocuments() {
            this.loading = true;
            this.$http.get(`/caja/rent/get-documents/${this.rentId}`)
                .then(response => {
                    console.log(response);
                    this.documents = response.data.documents;
                })
                .catch(error => {
                    this.$toast.error("Error al obtener los documentos");
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        open() {
            this.getDocuments();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
