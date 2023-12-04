<template>
    <div>
        <div class="col-md- d-flex justify-content-end">
            <button
                v-if="!cash_id"
                type="button"
                class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                @click.prevent="clickCreate()"
            >
                <i class="icofont-plus-circle"></i>
                <span>Nuevo</span>
            </button>
            <button
                v-else
                type="button"
                class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                @click.prevent="clickClose()"
            >
                <i class="icofont-plus-circle"></i>
                <span>Cerrar</span>
            </button>
            <cash-form
                :showDialog.sync="showDialogCash"
                :recordId="cash_id"
                @updateCashId="updateCashId"
                :principal="true"
            ></cash-form>
            <close-cash
                :recordId.sync="cash_id"
                :showDialogClose.sync="showDialogClose"
                :configuration="configuration"
                @updateCashId="updateCashId"
            >
            </close-cash>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CAJA</th>
                            <th>USUARIO</th>
                            <th>MONTO</th>
                            <th>OBS.</th>
                            <th>ESTADO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(record, idx) in records" :key="idx">
                            <td>{{ idx + 1 }}</td>
                            <td>{{ record.cash.reference_number }}</td>
                            <td>{{ record.user_name }}</td>
                            <td>{{ record.amount }}</td>
                            <td>{{ record.comment }}</td>
                            <td>{{ record.status_description }}</td>
                            <td>
                                <template
                                    v-if="
                                        record.status == 1 || record.status == 2
                                    "
                                >
                                    <!-- boton succes para aceptar el ingreso -->
                                    <el-tooltip
                                        :content="`Aceptar el ingreso`"
                                        placement="top"
                                    >
                                        <el-button
                                            type="success"
                                            icon="el-icon-check"
                                            size="mini"
                                            @click="accept(record.id)"
                                        ></el-button>
                                    </el-tooltip>
                                    <!-- boton danger para mandar a observacion el ingreso -->
                                    <el-tooltip
                                        :content="`Mandar a observación`"
                                        placement="top"
                                    >
                                        <el-button
                                            type="warning"
                                            icon="el-icon-close"
                                            size="mini"
                                            @click="reject(record.id)"
                                        ></el-button>
                                    </el-tooltip>
                                </template>
                                <!-- <template v-if="record.status == 2">
                                    <el-button
                                        type="success"
                                        icon="el-icon-check"
                                        size="mini"
                                        @click="accept(record.id)"
                                    ></el-button>
                                </template> -->
                                <!-- <template
                            v-if-else="record.status == 3"
                            >
                            
                            </template> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
const CashForm = () => import("./partials/form.vue");
const CloseCash = () => import("./partials/closecash.vue");

export default {
    props: ["configuration", "cashid"],
    components: {
        CashForm,
        CloseCash
    },
    created() {
        if (this.cashid != null) {
            this.cash_id = true;
        }
    },
    mounted() {
        this.getRecords();
    },
    data() {
        return {
            showDialogClose: false,
            showDialogCash: false,
            cash_id: null,
            records: []
        };
    },
    methods: {
       async accept(id) {
        try{
            await this.$confirm("¿Está seguro de aceptar el ingreso?", "Advertencia", {
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                type: "warning"
            });
               const response = await this.$http(`/cash/main_cash/accept/${id}`);
        if (response.status == 200) {
            this.$message({
                message: "Se acepto el ingreso",
                type: "success"
            });
            this.getRecords();
        }
        }catch(e){

        }
       },
        reject() {},
        async getRecords() {
            const response = await this.$http.get(`/cash/main_cash/records`);
            if (response.status == 200) {
                let {
                    data: { data }
                } = response;
                this.records = data;
            }
        },
        clickClose() {
            this.showDialogClose = true;
        },
        clickCreate() {
            this.showDialogCash = true;
        },
        updateCashId(id) {
            this.cash_id = id;
        }
    }
};
</script>
