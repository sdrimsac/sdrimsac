<template>
    <el-dialog
        title="Información de la Renta"
        :visible="showDialog"
        @close="close"
        @open="open"
        append-to-body
    >
        <div v-loading="loading">
            <div class="row m-2">
                <div class="col-12 mb-3">
                    <h5 class="text-primary">
                        <i class="fas fa-info-circle"></i> Detalles de la Renta
                        <el-button
                            type="primary"
                            size="mini"
                            class="float-right"
                            @click="openContract"
                            icon="el-icon-document"
                        >
                            Ver Contrato
                        </el-button>
                    </h5>
                </div>
                <div v-if="info.due_date" class="col-12 mb-3">
                    <div class="due-date-alert">
                        <i class="fas fa-calendar-alt"></i>
                        Fecha de Vencimiento:
                        <span class="due-date">{{
                            formatDate(info.due_date)
                        }}</span>
                        <span class="days-left" v-if="daysLeft !== null">
                            ({{ daysLeft }} días restantes)
                        </span>
                    </div>
                </div>
                <div class="col-12 table-responsive">
                    <div class="row" v-if="info.customer_img">
                        <div class="col-md-3">
                            <img :src="info.customer_img" alt="Imagen del cliente" style="width: 100%; height: auto;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cliente:</label>
                                <el-input
                                    v-model="info.customer_name"
                                    readonly
                                    size="small"
                                ></el-input>
                            </div>
                            <div class="form-group">
                                <label>Documento:</label>
                                <el-input
                                    v-model="info.customer_number"
                                    readonly
                                    size="small"
                                ></el-input>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Habitación:</label>
                                <el-input
                                    v-model="info.table"
                                    readonly
                                    size="small"
                                ></el-input>
                            </div>
                            <div class="form-group">
                                <label>Fecha de ingreso:</label>
                                <el-input
                                    v-model="formattedDate"
                                    readonly
                                    size="small"
                                ></el-input>
                            </div>
                        </div>
                    </div>
                    <div
                        class="row"
                        v-if="info.guesses && info.guesses.length > 0"
                    >
                        <div class="col-12">
                            <h5 class="text-primary">
                                <i class="fas fa-user-friends"></i> Habitantes
                            </h5>
                        </div>
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="guess in info.guesses" :key="guess.id">
                                        <td>{{ guess.name }}</td>
                                        <td>{{ guess.number }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            loading: false,
            info: {}
        };
    },
    computed: {
        formattedDate() {
            return this.formatDate(this.info.checkin_date);
        },
        daysLeft() {
            if (!this.info.due_date) return null;
            const today = moment();
            const dueDate = moment(this.info.due_date);
            return dueDate.diff(today, "days");
        }
    },
    methods: {
        openContract() {
            window.open(`/caja/rooms/pdf/${this.rentId}`, "_blank");
        },
        formatDate(date) {
            if (!date) return "";
            return moment(date).format("DD/MM/YYYY");
        },
        getInfo() {
            this.loading = true;
            this.$http
                .get(`/caja/rent/get-info/${this.rentId}`)
                .then(response => {
                    if (response.data.success) {
                        this.info = response.data;
                    } else {
                        this.$toast.error("Error al obtener la información");
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.$toast.error("Error al obtener la información");
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        open() {
            this.getInfo();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style scoped>
.form-group {
    margin-bottom: 1rem;
}
.form-group label {
    color: #606266;
    font-size: 0.9rem;
    margin-bottom: 0.3rem;
    display: block;
}
.el-input.is-disabled .el-input__inner {
    color: #606266;
}

.due-date-alert {
    background-color: #fdf6ec;
    border-left: 4px solid #e6a23c;
    padding: 12px;
    border-radius: 4px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.due-date-alert i {
    color: #e6a23c;
    font-size: 18px;
}

.due-date {
    font-weight: bold;
    color: #e6a23c;
}

.days-left {
    margin-left: auto;
    background-color: #e6a23c;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
}
</style>
