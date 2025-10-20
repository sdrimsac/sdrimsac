<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible="showDialog"
        title="Productos por Vencer"
        width="60%"
    >
        <div v-if="records != 0" class="d-flex justify-content-end mt-2 mb-2">
            <el-button
                class="btn_excelsmall"
                type="success"
                size="small"
                @click="clickDownload"
            >
                <i class="icofont-file-excel"></i> Exportar
            </el-button>
            
            <el-button
                class="btn_whatsappsmall"
                type="success"
                size="small"
                @click="clickSendWhatsapp"
            >
                <i class="icofont-brand-whatsapp"></i> Enviar
            </el-button>
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <template v-if="records == 0">
                    <div class="alert alert-info text-center p-2">
                        No hay productos por vencer
                    </div>
                </template>
                <template v-else>
                    <table class="table table-striped">
                        <thead>
                            <tr style="background-color: #073f68; color: #fff;">
                                <th style="color: #fff;">#</th>
                                <th style="color: #fff;">Producto</th>
                                <th style="color: #fff;">Fecha de vencimiento</th>
                                <th style="color: #fff;">Cantidad</th>
                                <th style="color: #fff;">Lote Por Vencer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(record, index) in records" :key="record.id" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                                <td>{{ customIndex(index) }}</td>
                                <td>{{ record.item.description }}</td>
                                <td>{{ record.date_of_due }}</td>
                                <td>{{ record.quantity }}</td>
                                <td>
                                    <template>
                                        <div
                                            v-for="lot in record.item
                                                .lots_group"
                                            :key="lot.id"
                                        >
                                            {{ lot.code }} -
                                            {{ lot.date_of_due }}
                                        </div>
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </template>
            </div>
        </div>
        <div class="row">
            <el-pagination
                @current-change="getRecords"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="parseInt(pagination.per_page)"
            >
            </el-pagination>
        </div>
        <whatsapp-modal
            resource="/lotes/to_due/excel"
            :showWhatsappForm.sync="showDialogWhatsapp"
            message="Reporte de lotes vencidos a menos de 60 dias.xlsx"
        >
        </whatsapp-modal>
    </el-dialog>
</template>
<script>
const WhatsappModal = () =>
    import(
        "../../../../../../../../resources/js/components/WhatsappModalReports.vue"
    );
export default {
    components: { WhatsappModal },
    props: ["showDialog"],
    data() {
        return {
            showDialogWhatsapp: false,
            records: [],
            pagination: {}
        };
    },
    methods: {
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getRecords() {
            const response = await this.$http.get("/lotes/to_due");
            const { data, meta } = response.data;
            this.records = data;
            this.pagination = meta;
            console.log(response);
        },
        clickSendWhatsapp() {
            this.showDialogWhatsapp = true;
        },
        clickDownload() {
            window.open("/lotes/to_due/excel");
        },
        open() {
            this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
