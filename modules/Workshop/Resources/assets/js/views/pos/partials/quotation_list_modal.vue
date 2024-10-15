<template>
    <el-dialog
        title="Cotización"
        :visible="showDialog"
        @open="open"
        @close="close"
        v-loading="loading"
    >
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Cotizacion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, index) in records" :key="index">
                        <td>{{ record.date_of_issue }}</td>
                        <td>{{ record.customer_name }}</td>
                        <td>{{ record.identifier }}</td>
                        <td>
                            <el-button
                                type="primary"
                                icon="el-icon-printer"
                                @click="directPrint(record.external_id)"
                            >
                                Imprimir
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
                <el-pagination
                    @current-change="getRecords"
                    layout="total, prev, pager, next"
                    :total="pagination.total"
                    :current-page.sync="pagination.current_page"
                    :page-size="pagination.per_page"
                >
                </el-pagination>
            </div>
        </div>

        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cerrar</el-button>
        </div>
    </el-dialog>
</template>

<script>

export default {
    props: [
    
        "showDialog",
    
    ],
    data() {
        return {
            quotationNewId: null,
            form: {
                customer_id: null
            },
            showDialogNewPerson: false,
            customers: [],
            resource: "quotations",
            loading_search: false,
            percentage_igv: 18,
            loading: false,
            showDialogOptions: false,
            records: [],
            pagination: {
                total: 0,
                current_page: 1,
                per_page: 20
            }
        };
    },
    created() {},
    watch: {},
    methods: {
        async directPrint(external_id) {
            let typePrint = "3";

            let url = "";
            //colocar una condicion para cada caso desde impresira de 80mm hasta las a4 y a5
            if (typePrint == "1") {
                url = `/quotations/print/${external_id}/a4`;
            }
            if (typePrint == "2") {
                url = `/quotations/print/${external_id}/a5`;
            }
            if (typePrint == "3" || typePrint == null) {
                url = `/quotations/print/${external_id}/ticket`;
            }
            if (typePrint == "4") {
                url = `/quotations/print/${external_id}/ticket_50`;
            }
            //console.log(config.direct_printing)

            await this.$http.post(`/caja/re-print`, {
                url
            });
        },
        async getRecords() {
            try {
                this.loading = true;
                let url = `/quotations/records-current-user`;
                let response = await this.$http.get(url);
                this.records = response.data.data;
                this.pagination = response.data.meta;
                this.pagination.per_page = parseInt(
                    response.data.meta.per_page
                );
            } catch (err) {
                console.log(err);
            } finally {
                this.loading = false;
            }
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
