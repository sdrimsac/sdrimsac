<template>
    <el-dialog
        title="Lista de guias"
        :visible="showDialog"
        @open="open"
        @close="close"
        v-loading="loading"
    >
        <div class="d-flex justify-content-end mt-2">
            <el-button type="primary" @click="showCreate = true">
                <i class="fas fa-plus"></i>
                Nuevo
            </el-button>
            <el-button @click="close">
                <i class="fas fa-times"></i>
                Cerrar
            </el-button>
        </div>
        <div class="row mt-2">
            <table
                class="table
            table-responsive table-striped table-bordered table-hover
            "
            >
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Numero</th>
                        <th>Cliente</th>
                        <th>Documento afectado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
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
                                @click="whatsapp(record)"
                            >
                                <i class="fab fa-whatsapp"></i>
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <el-dialog
            class="guide-dialog"
            width="90%"
            :visible.sync="showCreate"
            append-to-body
        >
            <dispatch-create
                @records="getRecords"
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

export default {
    props: ["showDialog", "configuration"],
    components: {
        DispatchCreate,
        WhatsappModal
    },
    data() {
        return {
            showCreate: false,
            loading: false,
            resource: "dispatches",
            records: [],
            linkResource: null,
            message: null,
            showWhatsappForm:false
        };
    },
    methods: {
        whatsapp(record) {
            let { external_id } = record;
            let formatoPdf = `/print/dispatch/${external_id}/ticket`;
            this.linkResource = formatoPdf;
            this.message =  "Su comprobante electrónico *" +
                        record.number +
                        "*, ha sido generado correctamente a través del facturador electrónico de " +
                        "*" +
                        this.$desarrollador +
                        "*"
            this.showWhatsappForm = true;
        },
        openPdf(record, format) {
            window.open(
                `/print/dispatch/${record.external_id}/${format}`,
                "_blank"
            );
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
