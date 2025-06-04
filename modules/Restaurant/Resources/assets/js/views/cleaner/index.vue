<template>
    <div class="row m-2">
        <div class="col-12">
            <div
                v-if="records.length > 0"
                class="d-flex flex-wrap justify-content-center"
            >
                <div
                    v-for="(table, idx) in records"
                    :class="[
                        'btn',
                        'col-2',
                        'm-1',
                        'd-flex',
                        'flex-column',
                        'justify-content-center',
                        'align-items-center',
                        table.status == 1 ? 'btn-dirty' : (table.status == 2 ? 'btn-cleaning' : 'btn-dirty')
                    ]"
                    :key="idx"
                    style="height: 150px; width: 135px;"
                    @click="changeState(table)"
                >
                    <div
                        class="d-flex flex-column justify-content-center align-items-center"
                    >
                        <span style="font-size:45px;margin:5px;">
                            <i class="fas fa-door-closed"></i>
                        </span>
                        <span class="text-center">
                            {{ table.name.toUpperCase() }}
                        </span>
                        <span v-if="table.status == 1">
                            EMPEZAR
                        </span>
                        <span v-else-if="table.status == 2">
                            {{ userType === 'mantenimiento' ? 'EN MANTENIMIENTO' : 'EN LIMPIEZA' }}
                        </span>
                        <span v-else>
                            TERMINAR
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <el-dialog
            title="Terminar trabajo"
            :visible.sync="showDialog"
            append-to-body
            v-loading="loading"
        >
            <div class="row m-2">
                <div class="col-12">
                    <label for="observations">Observaciones</label>
                    <el-input
                        type="textarea"
                        :rows="3"
                        placeholder="Ingrese las observaciones"
                        v-model="form.finish_comment"
                    ></el-input>
                </div>
            </div>

            <span slot="footer" class="dialog-footer">
                <el-button 
                    @click="cancelDialog" 
                    style="background-color: #e74c3c; color: #fff; font-size: 18px; border-radius: 25px; padding: 10px 30px; border: none;"
                >
                    Cancelar
                </el-button>
                <el-button 
                    type="primary" 
                    @click="sendState"
                    style="background-color: #27ae60; color: #fff; font-size: 18px; border-radius: 25px; padding: 10px 30px; border: none;"
                >
                    Enviar
                </el-button>
            </span>
        </el-dialog>
    </div>
</template>
<style>
.btn-black {
    background-color: #000;
}
.btn-free {
    background-color: #91d24c;
}
.btn-dirty {
    background-color: #a7a5a8;
}
.btn-reserve {
    background-color: #7030a0;
}
.btn-cleaning {
    background-color: #4fc3f7;
    color: #fff;
}
</style>
<script>
import Swal from 'sweetalert2';
export default {
    props: ["configuration", "establishment"],
    components: {
        Swal
    },
    data() {
        return {
            resource: "caja/worker/cleaner",
            records: [],
            loading: false,
            showDialog: false,
            form: {
                finish_comment: null,
                id: null
            },
            currentTable: null,
            userType: 'limpieza' // Cambia esto dinámicamente según el usuario
        };
    },
    mounted() {
        this.initForm();
        this.getTables();
    },
    methods: {
        initForm() {
            this.form = {
                finish_comment: null,
                id: null
            };
        },
        async sendState() {
            try {
                this.loading = true;
                this.form.id = this.currentTable.id;
                const response = await this.$http.post(
                    `/caja/maintenance/change-state`,
                    this.form
                );
                if (response.data.success) {
                    this.getTables();
                }
            } catch (e) {
                console.log("🚀 ~ file: index.vue:114 ~ sendState ~ e:", e);
            } finally {
                this.showDialog = false;
                this.loading = false;
                this.initForm();
            }
        },
        async changeState(table) {
            this.currentTable = table;
            let message = "¿Está seguro de";
            if (table.status == 1) {
                message += " empezar la limpieza de la habitación?";
            } else {
                message += " terminar la limpieza de la habitación?";
            }
            try {
                if (table.status == 1) {
                    const result = await Swal.fire({
                        title: 'Confirmación',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    });
                    if (result.isConfirmed) {
                        await this.sendState();
                        this.initForm();
                    }
                } else {
                    this.showFinishDialog();
                }
            } catch (e) {
                return;
            }
        },
        showFinishDialog() {
            this.showDialog = true;
        },
        cancelDialog() {
            this.showDialog = false;
            this.initForm();
        },
        async getTables() {
            const response = await this.$http(`/caja/maintenance/records`);
            if (response.data.records) {
                this.records = response.data.records;
            }
        }
    }
};
</script>
