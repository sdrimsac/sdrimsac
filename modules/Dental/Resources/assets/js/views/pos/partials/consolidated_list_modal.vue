<template>
    <el-dialog
        :visible="showDialog"
        title="Consolidados"
        @open="open"
        @close="close"
        append-to-body
        v-loading="loading"
    >
        <div class="row m-2">
            <div class="col-md-3">
                <el-input
                    v-model="form.number"
                    placeholder="Número"
                    @input="getRecordsTimer"
                    clearable
                ></el-input>
            </div>
            <div class="col-md-3">
                <el-date-picker
                    @change="getRecords"
                    v-model="form.date"
                    type="date"
                    placeholder="Fecha"
                    clearable
                    value-format="yyyy-MM-dd"
                    format="yyyy-MM-dd"
                ></el-date-picker>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Consolidación
                        </th>
                        <th>
                            Fecha
                        </th>
                        <th>
                            Usuario
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, idx) in records" :key="idx">
                        <td>
                            {{ customIndex(idx) }}
                        </td>
                        <td>
                            {{ record.identifier }}
                        </td>
                        <td>{{ record.date }}</td>
                        <td>
                            {{ record.user_name }}
                        </td>
                        <td>
                            <el-button
                                type="primary"
                                size="mini"
                                @click="clickExport(record)"
                            >
                                <i class="el-icon-download"></i>
                            </el-button>
                            <el-tooltip
                                content="Exportar formato de entrega"
                                placement="top"
                                effect="dark"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    @click="clickExportDelivery(record)"
                                >
                                    <i class="fas fa-truck"></i>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                content="Imprimir cotizaciones"
                                placement="top"
                                effect="dark"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    @click="clickPrint(record)"
                                >
                                    <i class="el-icon-printer"></i>
                                </el-button>
                            </el-tooltip>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <el-pagination
                @current-change="getRecords"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="Number(pagination.per_page)"
            >
            </el-pagination>
        </div>
    </el-dialog>
</template>

<script>
import querystring from "querystring";
export default {
    props: ["showDialog"],
    data() {
        return {
            form: {
                date: ""
            },
            resource: "quotations",
            records: [],
            excludes: [],
            loading: false,
            checkAll: false,
            pagination: {},
            loading: false,
            timer: null
        };
    },
    computed: {},
    methods: {
        clickReport() {
            window.open(`/${this.resource}/consolidateds/${record.id}/report`);
        },
        query() {
            return querystring.stringify({
                number: this.form.number,
                date: this.form.date,
                page: this.pagination.current_page
            });
        },
        getRecordsTimer() {
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(() => {
                this.getRecords();
            }, 500);
        },
        clickExport(record) {
            window.open(`/${this.resource}/consolidateds/${record.id}/export`);
        },
        clickExportDelivery(record) {
            window.open(
                `/${this.resource}/consolidateds/${record.id}/export-delivery`
            );
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        open() {
            this.checkAll = false;
            this.excludes = [];
            this.pagination = {};
            this.getRecords();
        },
        clickPrint(record) {
            this.$http
                .get(`/${this.resource}/consolidateds/${record.id}/print`)
                .then(response => {
                    // window.open(response.data.url);
                    this.$message.success("Imprimiendo...");
                })
                .catch(error => {
                    console.error(error);
                });

            // window.open(`/${this.resource}/consolidateds/${record.id}/print`);
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/consolidateds?${this.query()}`
                );
                this.pagination = response.data.meta;
                this.pagination.current_page = Number(
                    this.pagination.current_page
                );
                this.records = response.data.data.map(record => {
                    return {
                        ...record,
                        checked: true
                    };
                });
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
