<template>
    <el-dialog
        title="Cronograma"
        :visible.sync="dialogAjustment"
        width="80%"
        :before-close="handleClose"
        @open="open"
        append-to-body
        v-loading="loading"
    >
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Fecha
                        </th>
                        <th>
                            Cuota
                        </th>
                        <th>
                            Estado
                        </th>
                        <th>Penalidad</th>
                        <th>Pagado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, idx) in paginatedRecords" :key="idx">
                        <td>
                            {{ idx + 1 }}
                        </td>
                        <td>
                            <el-date-picker
                                v-model="record.date_payment"
                                type="date"
                                placeholder="Seleccione una fecha"
                                value-format="yyyy-MM-dd"
                                format="yyyy-MM-dd"
                                @change="updatePayment(record, 'date_payment')"
                            ></el-date-picker>
                        </td>
                        <td>
                            {{ Number(record.amount).toFixed(2) }}
                        </td>
                        <td>
                            <el-button
                                :type="record.paid == 1 ? 'success' : 'warning'"
                                @click="updatePayment(record, 'paid')"
                            >
                                {{ record.paid == 1 ? 'Pagado' : 'Pendiente' }}
                            </el-button>

                        </td>
                        <td style="width:200px;">
                            <el-input
                                :disabled="record.paid == 1"
                                v-model="record.penalty_amount"
                                type="number"
                            >
                                <el-button
                                    slot="append"
                                    icon="el-icon-check"
                                    @click="
                                        updatePayment(record, 'penalty_amount')
                                    "
                                ></el-button>
                            </el-input>
                        </td>
                        <td style="width:200px;">
                            <el-input
                                v-model="record.amount_paid"
                                type="number"
                            >
                                <el-button
                                    icon="el-icon-check"
                                    slot="append"
                                    @click="
                                        updatePayment(record, 'amount_paid')
                                    "
                                ></el-button>
                            </el-input>
                        </td>
                    </tr>
                </tbody>
            </table>
            <el-pagination
                @current-change="handleCurrentChange"
                :current-page="page"
                :page-size="10"
                layout="prev, pager, next"
                :total="all_records.length"
            ></el-pagination>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["dialogAjustment", "recordId"],
    data() {
        return {
            loading: false,
            records: [],
            all_records: [],
            page: 1,
            pagination: {
                total: 0,
                current_page: 1,
                per_page: 10
            }
        };
    },
    computed: {
        paginatedRecords() {
            const start = (this.page -1)  * 10;
            console.log("🚀 ~ paginatedRecords ~ start:", start)
            const end = start + 10;
            console.log("🚀 ~ paginatedRecords ~ end:", end)
            return this.all_records.slice(start, end);
        }
    },
    methods: {
        async updatePayment(record, type) {
            this.loading = true;
            let value = record[type];
            if (type === "paid") {
                value = 1;
                try{
                    await this.$confirm(
                    `¿Está seguro de cambiar el estado de la cuota?`,
                    "Confirmar",
                    {
                        confirmButtonText: "Sí",
                        cancelButtonText: "No",
                        type: "warning"
                    }
                );
                }catch(e){
                    return;
                }

            }
            this.$http
                .put(`/sale-notes/update-payment`, {
                    value,
                    type,
                    payment_id: record.id
                })
                .then(response => {
                    console.log(response.data);
                    let data = response.data;
                    if (data.success) {
                        this.$toast.success(data.message);
                        this.$emit("updateRecord");
                    } else {
                        this.$toast.error(
                            "Ocurrió un error al actualizar el pago"
                        );
                    }
                    this.getPayments();
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
            // console.log("🚀 ~ updatePayment ~ record:", record);
        },
        handleCurrentChange(val) {
            this.page = val;
            console.log("🚀 ~ handleCurrentChange ~ this.page:", this.page)
        },
        getPayments() {
            this.loading = true;
            this.$http(`/sale-notes/get-payments/${this.recordId}`)
                .then(response => {
                    this.all_records = response.data.map(record => {
                        record.isEditing = false;
                        return record;
                    });
                    
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        open() {
            console.log(this.recordId);
            this.getPayments();
        },
        handleClose() {
            this.$emit("update:dialogAjustment", false);
        }
    }
};
</script>
