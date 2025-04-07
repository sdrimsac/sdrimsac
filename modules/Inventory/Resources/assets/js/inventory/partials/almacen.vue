<!-- Regularizar Stock de Productos por Almacén -->
<template>
<el-dialog 
    :title="titleDialog" width="40%" 
    :visible.sync="showDialog" 
    :close-on-click-modal="false" 
    :close-on-press-escape="false" 
    append-to-body :show-close="false">
    <div class="form-body">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label fw-bold">Seleccione Almacén</label>
                        <el-select 
                            v-model="selectedWarehouse_id" 
                            placeholder="Seleccione un almacén" 
                            class="w-100"
                        >
                            <el-option 
                                v-for="warehouse in warehouses" 
                                :key="warehouse.id" 
                                :value="warehouse.id" 
                                :label="warehouse.description"
                            />
                        </el-select>
                    </div>
                    <div class="dialog-footer d-flex justify-content-end mt-3">
                        <el-button 
                            icon="fas fa-times fa-lg" 
                            @click="close" 
                            class="btn-cancel btn-cancel:hover mr-2"
                        >
                            Cancelar
                        </el-button>
                        <el-button 
                            type="primary"
                            class="btn-save btn-save:hover"
                            @click="regularizarStock"
                        >
                            <i class="fas fa-sync-alt fa-lg"></i> Regularizar Stock
                        </el-button>
                    </div>
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
            titleDialog: 'Regularizar Stock de Productos por Almacén',
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
