<template>
    <el-dialog  
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="Productos con Garantia"
    close-on-click-modal
    width="50%"
    >
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label>Producto</label>
                    <el-input></el-input>

                </div>
                <div class="col-md-6">
                    <label>Garantia</label>
                    <el-input></el-input>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr class="bg-primary">
                                <th class="text-white">N° DOCUMENTO</th>
                                <th class="text-white">CLIENTE</th>
                                <th class="text-white">PRODUCTO</th>
                                <th class="text-white">SERIE</th>
                                <th class="text-white">GARANTIA RESTANTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in warranty" :key="record.id">
                                <td>{{ record.document_number }}</td>
                                <td>{{ record.client }}</td>
                                <td>{{ record.product }}</td>
                                <td>{{ record.series }}</td>
                                <td>{{ record.remaining_warranty }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                        <el-pagination
                            @current-change="getWarrantyRecords"
                            layout="total, prev, pager, next"
                            :total="pagination.total"
                            :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page"
                        >
                        </el-pagination>
                    </div>
            </div>
        </div>
    </div>

    </el-dialog>
</template>
<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            warranty: [],
            pagination: {
                total: 0,
                per_page: 10,
                current_page: 1
            },
        }
    },
    methods: {
        open() {
            this.getWarrantyRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        getWarrantyRecords(page = 1) {
            this.$http.get(`/warranty/records2?page=${page}&limit=${this.pagination.per_page}`).then(response => {
                console.log(response.data);
                this.warranty = response.data.data;
                this.pagination = response.data.meta;
                this.pagination.per_page = parseInt(response.data.meta.per_page);
                console.log("ver llegando datos", this.warranty);
            });
        },
        customIndex(index) {
            if (this.resource == "caja/cash-transfer/report") {
                return index + 1;
            }
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        getQueryParameters() {
            if (
                this.search.column == "date" &&
                this.search.value &&
                typeof this.search.value == "object"
            ) {
                this.search.value = this.search.value.join(",");
            }
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                value: this.search.value,
                column: this.search.column,
            });
        },

    },
}
</script>