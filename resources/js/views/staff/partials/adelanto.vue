<template>
    <el-dialog :visible.sync="showDialog" width="600px" :before-close="handleBeforeClose" :close-on-click-modal="false"
        :close-on-press-escape="false" title="Adelanto de sueldo">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <label for="amount">Ingrese Monto de adelanto</label>
                        <!-- <el-input type="number" v-model="amount" id="amount" placeholder="Ingrese el monto"></el-input> -->
                        <el-input-number v-model="amount_enter" controls-position="right" :min="1"
                            :max="99999"></el-input-number>
                    </div>
                    <div class="col-12">
                        <label for="amount">Seleccione Metodo de pago</label>
                        <el-select v-model="method" placeholder="Seleccione un metodo de pago">
                            <el-option label="Efectivo" value="Efectivo"></el-option>
                            <el-option label="YAPE" value="YAPE"></el-option>
                            <el-option label="PLIN" value="PLIN"></el-option>
                        </el-select>
                    </div>
                    <div class="col-12">
                        <label for="amount">Observacion</label>
                        <el-input type="textarea" rows="3" placeholder="Ingrese una observacion"
                            v-model="observacion"></el-input>
                    </div> 
                    <br>
                    <div class="col-12 d-flex justify-content-end">
                        <el-button class="ml-2" @click="cancel">Cancelar</el-button>
                        <el-button type="primary" @click="submitAdelanto">Enviar</el-button>
                        
                    </div>
                </div>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: {
        showDialog: { type: Boolean, default: false },
        person_id: { type: [Number, String], default: null }
    },
    data() {
        return {
            amount_enter: 0,
            method: null,
            observacion: null
        };
    },
    mounted() {
        console.log('adelanto mounted, person_id prop:', this.person_id, 'showDialog:', this.showDialog);
    },
    watch: {
        person_id(newVal) {
            console.log('adelanto person_id changed:', newVal);
        }
    },
    methods: {
        handleBeforeClose(done) {
            // emit update for .sync binding so parent updates its boolean
            this.$emit('update:showDialog', false);
            if (typeof done === 'function') done();
        },
        submitAdelanto() {
            if (!this.person_id) {
                this.$message({ message: 'Person ID missing', type: 'warning' });
                return;
            }
            this.$http.post(`/staff/adelanto`, {
                person_id: this.person_id,
                amount: this.amount_enter,
                method: this.method,
                observacion: this.observacion,
                date_time_advances: new Date().toISOString().slice(0, 19).replace('T', ' ')
            }).then(response => {
                this.$emit('success', response.data);
                this.$message({
                    message: 'Adelanto registrado con exito',
                    type: 'success'
                });
                // close dialog
                this.$emit('update:showDialog', false);
            }).catch(error => {
                this.$message({
                    message: 'Error al registrar el adelanto',
                    type: 'error'
                });
            });
        },
        cancel() {
            this.$emit('update:showDialog', false);
        }
    }
};
</script>