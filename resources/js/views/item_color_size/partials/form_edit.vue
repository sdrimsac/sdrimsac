<template>
    <el-dialog :visible.sync="localShowDialog" width="600px" :close-on-click-modal="false"
        :before-close="handleBeforeClose" centered :destroy-on-close="true"
        title="Editar Color y Talla">
        <el-form :model="formData" :disabled="isLoading">
            <!-- <el-form-item label="Color">
                <el-input v-model="formData.color" disabled></el-input>
            </el-form-item>
            <el-form-item label="Talla">
                <el-input v-model="formData.size" disabled></el-input>
            </el-form-item> -->
            <!-- <div>
                <label for="">Color</label>
                <el-input v-model="formData.color" disabled></el-input>
            </div> -->
            <div>
                <label for="">Precio</label>
                <el-input-number v-model="formData.price"></el-input-number>
            </div>
            <el-form-item style="text-align: right;">
                <el-button type="primary" @click="savePrice" :loading="isLoading">Guardar</el-button>
            </el-form-item>
        </el-form>
    </el-dialog>
</template>
<script>
import axios from 'axios';
export default {
    name: "FormEdit",
    props: ["showDialog", "recordId"],
    data() {
        return {
            localShowDialog: this.showDialog,
            localRecordId: this.recordId,
            formData: {
                color: '',
                size: ''
            },
            isLoading: false
        };
    },
    watch: {
        showDialog(val) {
            this.localShowDialog = val;
        },
        localShowDialog(val) {
            if (!val) {
                this.$emit('update:showDialog', false);
            }
        },
        recordId(val) {
            this.localRecordId = val;
            if (val && this.localShowDialog) {
                this.dataColorSize(val);
            }
        }
    },
    methods: {
        handleBeforeClose(done) {
            this.$emit('update:showDialog', false);
            this.$emit('update:recordId', null);
            done();
        },
        closeDialog() {
            this.$emit('update:showDialog', false);
            this.$emit('update:recordId', null);
        },
        dataColorSize(recordId) {
            axios.get(`/item-color-size/record/${recordId}`).then(response => {
                this.formData = response.data.data;
            }).catch(error => {
                console.error("Error fetching data:", error);
            });
        },
        savePrice() {
            this.isLoading = true;
            axios.post(`/item-color-size/update-price/${this.formData.id}`, {
                price: this.formData.price
            }).then(response => {
                if (response.data === true || response.data.success === true) {
                    this.$message.success('Precio actualizado correctamente');
                    this.$emit('price-updated', this.formData);
                    this.closeDialog();
                } else {
                    this.$message.error('Error al actualizar el precio');
                }
            }).catch(error => {
                this.$message.error('Error al actualizar el precio');
                console.error("Error updating price:", error);
            }).finally(() => {
                this.isLoading = false;
            });
        }
    }
};
</script>