<template>
    <el-dialog
        title="Lista de guias"
        :visible="showDialog"
        @open="open"
        @close="close"
        v-loading="loading"
        :close-on-click-modal="false"
        width="70%"
    >
        <div class="d-flex justify-content-end mt-2">
            <el-button type="primary" @click="createDispatch">
                <i class="fas fa-plus"></i>
                Nuevo
            </el-button>
        </div>
        <br>
        <div class="card bg-white">
            <div class="card-body">
                <table
                    class="table table-responsive table-striped table-bordered table-hover"
                >
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-white">Fecha</th>
                            <th class="text-white">Numero</th>
                            <th class="text-white">Cliente</th>
                            <th class="text-white">Documento afectado</th>
                            <th class="text-white">Estado</th>
                            <th class="text-white text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(record, idx) in records" :key="idx">
                            <td>
                                {{ record.date_of_issue }}
                            </td>
                            <td>
                                {{ record.number }}
                            </td>
                            <td>
                                {{ record.customer_name }}
                            </td>
                            <td>
                                {{
                                    record.documents.length > 0
                                        ? record.documents
                                              .map(r => r.description)
                                              .join(",")
                                        : ""
                                }}
                            </td>
                            <td>
                                {{ record.state_type_description }}
                            </td>
                            <td>
                                <el-button
                                    type="primary"
                                    size="mini"
                                    @click="openPdf(record, 'a4')"
                                >
                                    <i class="fas fa-file"></i>
                                    A4
                                </el-button>
                                <el-button
                                    type="success"
                                    size="mini"
                                    @click="openPdfGuides(record.id)"
                                >
                                    FORMATOS
                                </el-button>
                                <el-button
                                    type="success"
                                    size="mini"
                                    @click="whatsapp(record)"
                                >
                                    <i class="fab fa-whatsapp"></i>
                                </el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
            <el-button type="danger" round @click="close">
                <i class="fas fa-times"></i>
                Cerrar
            </el-button>
        </div>

        <el-dialog
            class="guide-dialog"
            width="90%"
            :visible.sync="showCreate"
            append-to-body
        >
            <dispatch-create
                @records="getRecords"
                ref="dispatchCreate"
                @closeDispatch="closeDispatch"
                :configuration="configuration"
                :pos="true"
            ></dispatch-create>
        </el-dialog>
        <whatsapp-modal
            :resource="linkResource"
            :message="message"
            :showWhatsappForm.sync="showWhatsappForm"
        >
        </whatsapp-modal>

        <dispatch-options
            :isUpdate="true"
            :recordId="recordId"
            :showClose="true"
            :showDialog.sync="showDialogOptions"
        ></dispatch-options>
    </el-dialog>
</template>
<style>
.guide-dialog .el-dialog__header {
    display: none;
}
.guide-dialog .el-dialog__body {
    padding: 0px !important;
}
</style>
<script>
const WhatsappModal = () =>
    import(
        "../../../../../../../../resources/js/components/WhatsappModalReports.vue"
    );
const DispatchCreate = () =>
    import("../../../../../../../../resources/js/views/dispatches/create.vue");

import DispatchOptions from "../../../../../../../../resources/js/views/dispatches/partials/options.vue";

export default {
    props: ["showDialog", "configuration"],
    components: {
        DispatchCreate,
        WhatsappModal,
        DispatchOptions
    },
    data() {
        return {
            showCreate: false,
            loading: false,
            resource: "dispatches",
            records: [],
            linkResource: null,
            message: null,
            showWhatsappForm: false,
            showDialogOptions: false,
            recordId: null
        };
    },
    methods: {
        createDispatch() {
            this.showCreate = true;
            setTimeout(() => {
                this.$refs.dispatchCreate.mountedMethod();
            }, 500);
        },
        whatsapp(record) {
            let { external_id } = record;
            let formatoPdf = `/print/dispatch/${external_id}/ticket`;
            this.linkResource = formatoPdf;
            this.message =
                "Su comprobante electrónico *" +
                record.number +
                "*, ha sido generado correctamente a través del facturador electrónico de " +
                "*" +
                this.$desarrollador +
                "*";
            this.showWhatsappForm = true;
        },
        openPdf(record, format) {
            window.open(
                `/print/dispatch/${record.external_id}/${format}`,
                "_blank"
            );
        },
        openPdfGuides(recordId) {
            this.recordId = recordId;
            this.showDialogOptions = true;
        },
        closeDispatch() {
            this.showCreate = false;
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(`/dispatches/records`);
                if (response.status == 200) {
                    const { data } = response.data;
                    this.records = data;
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        async open() {
            await this.getRecords();
        }
    }
};
</script>
