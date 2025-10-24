<template>
    <el-dialog
        :visible="showDialog"
        title="Servicios del estilista"
        @close="close"
        @open="open"
        append-to-body
    >
        <div class="row mt-2" v-loading="loading_user_items">
            <div class="col-md-8">
                <label class="control-label">Servicio</label>
                <el-select
                    class="w-100"
                    v-model="form.item_id"
                    filterable
                    remote
                    popper-class="el-select-customers"
                    clearable
                    placeholder="Nombre o código interno"
                    :remote-method="searchRemoteItems"
                    :loading="loading_search_item"
                >
                    <el-option
                        v-for="option in items"
                        :key="option.id"
                        :value="option.id"
                        :label="option.description"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-4">  
                <label class="control-label">
                    <i class="fas fa-plus"></i>
                </label>
                <el-button type="primary" @click="addItem">Agregar</el-button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in itemsSelected" :key="item.id">
                            <td>{{ item.description }}</td>
                            <td>{{ item.sale_unit_price }}</td>
                            <td>
                                <el-button type="danger" @click="removeItem(item)">
                                    <i class="fas fa-trash"></i>
                                </el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <span class="card-footer d-flex justify-content-end">  
                <el-button type="primary" @click="saveItems">Guardar</el-button>
            </span>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "userId"],
    data() {
        return {
            items: [],
            loading_user_items: false,
            loading_search_item: false,
            itemsSelected: [],
            timer: null,
            form: {
                item_id: null
            }
        };
    },
    methods: {
        removeItem(item){
            this.itemsSelected = this.itemsSelected.filter(i => i !== item);
        },
        addItem(){
            if(!this.form.item_id) return;
            if(this.itemsSelected.some(i => i.id === this.form.item_id)) {
                this.$message({
                    message: 'El servicio ya fue agregado',
                    type: 'warning'
                });
                return;
            }
            let item = this.items.find(i => i.id === this.form.item_id);
            this.itemsSelected.push(item);
            this.form.item_id = null;
        },
        async searchRemoteItems(input) {
            if (input.length > 2) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    try {
                        let parameters = `input=${input}`;
                        this.loading_search_item = true;
                        const response = await this.$http.get(
                            `/restobar/estilista/get-individual-services?${parameters}`
                        );

                        this.items = response.data.items;
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.loading_search_item = false;
                    }
                }, 250);
            }
        },
        async getUserItems() {
            this.loading_user_items = true;
            const response = await this.$http.get(
                `/restobar/estilista/get-user-items/${this.userId}`
            );
            this.itemsSelected = response.data;
            console.log(this.itemsSelected, 'itemsSelected');
            this.loading_user_items = false;
        },
        async open() {
            this.items = [];
            this.itemsSelected = [];
            this.form.item_id = null;
            if(this.userId) {
                this.getUserItems();
            }
        },
        async close() {
            this.$emit("update:showDialog", false);
        },
        async saveItems() {
            this.$emit("saveItems", this.itemsSelected);
            this.close();
        }
    }
};
</script>

<style></style>
