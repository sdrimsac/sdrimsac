<template>
<el-dialog 
    :title="titleDialog" width="40%" 
    :visible.sync="showDialog" 
    :close-on-click-modal="false" 
    :close-on-press-escape="false" 
    append-to-body :show-close="false">
    <div class="form-body">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label fw-bold"> Seleccione Almacen</label>
                        <el-select v-model="selectedWarehouse_id">
                            <el-option v-for="warehouse in warehouses" :key="warehouse.id" :value="warehouse.id"
                            :label="warehouse.description"
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <span slot="footer" class="dialog-footer">
                        <el-button icon="fas fa-times" @click="close"> Cancelar</el-button>
                        <el-button type="primary" @click="regularizarStock">Regularizar Stock</el-button>
                        <br>
                    </span>
                </div>
            </div>
        </div>
    </div>
</el-dialog>
</template>

<script>
export default {
    props: ['showDialog', 'warehouses'],
    data() {
        return {
            titleDialog: 'Regularizar stock de productos',
            selectedWarehouse_id: null
        };
    },
    methods: {
        regularizarStock() {
            this.$emit('regularizarStock', this.selectedWarehouse_id);
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
