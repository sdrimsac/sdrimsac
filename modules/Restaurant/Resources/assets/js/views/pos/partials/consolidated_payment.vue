<template>
    <el-dialog
        :visible="showDialog"
        :title="title"
        @close="close"
        @open="open"
        append-to-body
        v-loading="loading"
    >
        <div class="row mt-2">
            <div
                class="col-12 mb-3 d-flex justify-content-between align-items-center"
            >
                <el-checkbox v-model="selectAll" @change="checkAll">
                    Seleccionar todos
                </el-checkbox>

                <el-button
                    type="success"
                    :disabled="!hasSelectedDocuments"
                    @click="paySelectedDocuments"
                >
                    Pago Global
                    <span v-if="selectedTotal > 0"
                        >(S/. {{ selectedTotal }})</span
                    >
                </el-button>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Documento</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Metodo de pago</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in documents" :key="index">
                            <td>
                                {{ index + 1 }}
                                <el-checkbox
                                    v-model="item.selected"
                                    @change="$forceUpdate()"
                                ></el-checkbox>
                            </td>
                            <td>{{ item.full_number }}</td>
                            <td>{{ item.customer_name }}</td>
                            <td>
                                {{ item.total }}
                            </td>
                            <td>
                                <el-select
                                    v-model="item.payment_method"
                                    filterable
                                    @change="changePaymentMethod($event, index)"
                                >
                                    <el-option
                                        v-for="(payment,
                                        index) in paymentsValue"
                                        :key="index"
                                        :value="payment"
                                        :label="payment"
                                    ></el-option>
                                </el-select>
                            </td>
                            <td>
                                <el-button
                                    type="primary"
                                    size="mini"
                                    @click="payDocument(item)"
                                    v-if="!item.paid"
                                >
                                    Pagar
                                </el-button>
                                <el-button
                                    type="secondary"
                                    size="mini"
                                    @click="editDocument(item)"
                                >
                                    Editar
                                </el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <consolidated-document-edit
                :showDialog.sync="showDialogEdit"
                :document="document"
            ></consolidated-document-edit>
        </div>
    </el-dialog>
</template>

<script>
import ConsolidatedDocumentEdit from "./consolidated_document_edit.vue";
export default {
    props: ["showDialog", "record"],
    components: {
        ConsolidatedDocumentEdit
    },
    data() {
        return {
            selectAll: false,
            loading: false,
            showDialogEdit: false,
            document: null,
            documents: [],
            title: "Liquidar consolidado",
            paymentsValue: [
                "Efectivo",
                "Culqui",
                "Yape",
                "PLIN",
                "TARJETA: IZYPAY",
                "TARJETA: NIUBIZ",
                "TARJETA: OPENPAY",
                "DIDI FOOD",
                "PEDIDOS YA",
                "RAPPI"
            ]
        };
    },
    computed: {
        hasSelectedDocuments() {
            return this.documents.some(doc => doc.selected);
        },
        selectedTotal() {
            return this.documents
                .filter(doc => doc.selected)
                .reduce((sum, doc) => sum + Number(doc.total), 0)
                .toFixed(2);
        }
    },
    methods: {
        editDocument(item) {
            this.loading = true;
            let { quotation_id } = item;
            this.$http
                .post(`/quotations/consolidateds/edit-document`, {
                    quotation_id
                })
                .then(response => {
                    let data = response.data;
                    let items = data.items;
                    console.log("🚀 ~ editDocument ~ items:", items);
                    let quotation_id = data.quotation_id;
                    let customer_number = data.customer_number;
                    let identifier = data.identifier;

                    items.forEach(item => {
                        this.$emit(
                            "insertOrdenQuotation",
                            quotation_id,
                            identifier,
                            item,
                            customer_number
                        );
                    });
                    this.close();
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        checkAll() {
            this.documents.forEach(item => {
                item.selected = this.selectAll;
            });
            this.documents = [...this.documents];
            this.$forceUpdate();
        },
        payDocument(item) {
            console.log("🚀 ~ payDocument ~ item:", item);
        },
        changePaymentMethod(event, index) {
            this.documents[index].payment_method = event;
            this.$forceUpdate();
        },
        getRecord() {
            this.loading = true;
            this.$http
                .get(`/quotations/consolidateds/${this.record.id}/liquidate`)
                .then(response => {
                    console.log("🚀 ~ getRecord ~ response:", response);
                    this.documents = response.data.documents;
                    this.documents.forEach(item => {
                        item.payment_method = this.paymentsValue[0];
                        item.selected = false;
                    });
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        open() {
            // this.selectAll = true;
            this.getRecord();
        },
        paySelectedDocuments() {
            const selectedDocs = this.documents.filter(doc => doc.selected);
            if (selectedDocs.length === 0) {
                this.$message.warning(
                    "Seleccione al menos un documento para pagar"
                );
                return;
            }

            console.log(
                "Documentos seleccionados para pago global:",
                selectedDocs
            );

            const payload = {
                documents: selectedDocs.map(doc => ({
                    id: doc.id,
                    total: doc.total,
                    payment_method: doc.payment_method
                }))
            };

            this.$confirm(
                "¿Está seguro de realizar el pago global?",
                "Advertencia",
                {
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                    type: "warning"
                }
            )
                .then(() => {
                    this.loading = true;
                    console.log("Enviando payload:", payload);
                    this.loading = false;
                })
                .catch(() => {});
        }
    }
};
</script>
