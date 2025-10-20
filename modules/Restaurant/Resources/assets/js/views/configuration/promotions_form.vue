<template>
    <el-dialog width="60%" :visible="showDialog" append-to-body @close="close" @open="open" v-loading="loading"
        :title="title" class="rounded-dialog" w>

        <div class="row">
            <div class="col-12">
                <label for="name">Nombres</label>
                <el-input v-model="form.name" placeholder="Nombre" clearable></el-input>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="description">Descripción</label>
                    <el-input v-model="form.description" placeholder="Descripción" clearable></el-input>
                </div>
                <div class="col-6">
                    <label for="description">Hora de vencimiento</label>
                    <el-time-picker clearable v-model="form.due_time" size="small"
                        placeholder="Hora a vencerse la promoción" style="width: 100%;" value-format="HH:mm:ss"
                        :format="'hh:mm A'" :picker-options="{
                            format: 'hh:mm A'
                        }" timezone="America/Lima"></el-time-picker>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-8">
                    <label for="items">Productos que contiene
                        <small>(opcional)</small>
                    </label>
                    <el-select v-model="form.item_id" placeholder="Productos" filterable remote
                        popper-class="el-select-customers" clearable :remote-method="searchRemoteItems"
                        :loading="loading_search_item" @change="changeItem">
                        <el-option v-for="item in items" :key="item.id" :label="item.description" :value="item.id">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-4">
                    <el-button class="btn_guardarsmall" type="primary" icon="el-icon-plus"  :disabled="!form.item_id"
                        @click="addItem">Agregar producto</el-button>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="" v-if="service_items.length > 0">
                <table class="table">
                    <thead style="background-color: #073f68; color: #fff;">
                        <tr>
                            <th style="color: #fff;">Producto</th>
                            <th style="color: #fff;">Cantidad</th>
                            <th style="color: #fff;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, idx) in service_items" :key="idx" :style="{ backgroundColor: idx % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                            <td>
                                {{ item.description }}
                            </td>
                            <td>
                                <el-input-number @change="changeQuantity(item, idx)" :min="1" v-model="item.quantity"
                                    placeholder="Cantidad"></el-input-number>
                            </td>
                            <td>
                                <el-button type="danger" icon="el-icon-delete" size="mini"
                                    @click="service_items.splice(idx, 1)"></el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <span slot="footer" class="dialog-footer" style="display:flex; justify-content:flex-end; gap:8px;">
            <el-button class="btn_cancelarsmall" type="danger" @click="close">
                <i class="el-icon-close" style="margin-right:8px;"></i>
                Cancelar
            </el-button>
            <el-button class="btn_guardarsmall" type="primary" @click="submit">
               
                <i class="el-icon-check" style="margin-right:8px;"></i>
                Guardar
            </el-button>
        </span>
    </el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
</style>

<script>
export default {
    props: ["showDialog", "recordId"],
    data() {
        return {
            loading: false,
            form: {},
            items: [],
            showAddPromotion: false,
            service_items: [],
            time: null,
            loading_search_item: false,
            title: "Crear servicio"
        };
    },
    methods: {
        async getRecord() {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/caja/room_services/record/${this.recordId}`
                );
                this.form = response.data.record;
                this.service_items = response.data.record.items;
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un error");
            } finally {
                this.loading = false;
            }
        },

        initForm() {
            this.form = {
                name: null,
                description: null,
                items: [],
                due_time: null
            };
            this.service_items = [];
        },
        changeQuantity(item, idx) {
            this.$forceUpdate();
        },
        async submit() {
            try {
                this.loading = true;
                let form = {
                    id: this.recordId,
                    name: this.form.name,
                    description: this.form.description,
                    items: this.service_items,
                    due_time: this.form.due_time
                };
                const response = await this.$http.post(
                    "/caja/room_services",
                    form
                );
                if (response.status == 200) {
                    this.$toast.success("Registro guardado");
                    this.initForm();
                    this.$emit("getRecords");
                }
            } catch (e) {
                this.$toast.error("Ocurrió un error");
            } finally {
                this.loading = false;
            }
        },
        changeItem() { },
        async searchRemoteItems(input) {
            if (input.length > 2) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    try {
                        let parameters = `input=${input}`;
                        this.loading_search = true;
                        const response = await this.$http.get(
                            `/documents/data-table/items?${parameters}`
                        );

                        this.items = response.data;
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.loading_search = false;
                    }
                }, 250);
            }
        },
        addItem() {
            let item = this.items.find(item => item.id == this.form.item_id);
            item.quantity = 1;
            this.service_items.push(item);
            this.form.item_id = null;
        },
        addNewRecord() {
            this.showAddPromotion = true;
        },
        close() {
            this.$emit("update:showDialog", false);
            this.$emit("update:recordId", null);
        },
        open() {
            this.initForm();

            if (this.recordId) {
                this.title = "Editar servicio";
                this.getRecord();
            }
        }
    }
};
</script>
