<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
    >
        <form autocomplete="off" @submit.prevent="sendItems">
            <div class="form-body">
                <div class="row mt-2">
                    <div class="col-md-3 col-lg-3 col-12">
                        <label>Almacén</label>
                        <el-select
                            v-model="form.warehouse_id"
                            placeholder="Seleccione un almacén"
                            clearable
                            filterable
                            :disabled="loading_submit"
                        >
                            <el-option
                                v-for="item in warehouses"
                                :key="item.id"
                                :label="item.description"
                                :value="item.id"
                            ></el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-8 col-lg-8 col-12">
                        <label>Productos</label>
                        <el-select
                            :disabled="!form.warehouse_id"
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
                    <div
                        class="col-md-4 col-lg-4 col-12 d-flex align-items-end"
                    >
                        <el-button
                            class="w-100"
                            type="primary"
                            @click.prevent="addItem"
                        >
                            Agregar
                        </el-button>
                    </div>
                </div>

                <div
                    :key="it.id"
                    class="row mt-2"
                    v-for="(it, idx) in selectedItems"
                >
                    <div class="col-md-8 col-lg-8 col-12">
                        <el-input readonly v-model="it.description"> </el-input>
                    </div>
                    <div class="col-md-3 col-lg-3 col-12">
                        <el-input v-model="it.quantity"> </el-input><br />
                        <small>
                            {{ it.max_quantity_description }}
                        </small>
                    </div>
                    <div class="col-md-1 col-lg-1 col-12">
                        <el-button
                            class="w-100"
                            type="danger"
                            size="mini"
                            @click.prevent="selectedItems.splice(idx, 1)"
                        >
                            <i class="fa fa-trash"></i>
                        </el-button>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >Transformar</el-button
                >
            </div>
        </form>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId"],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "manufactured",
            errors: {},
            form: {},
            warehouses: [],
            timer: null,
            loading_search_item: false,
            items: [],
            selectedItems: []
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        addItem() {
            let item = this.items.find(item => item.id === this.form.item_id);
            this.selectedItems.push({
                id: item.id,
                description: item.description,
                quantity: 0,
                max_quantity: item.max_quantity,
                max_quantity_description: item.max_quantity_description
            });
            this.form.item_id = null;
            // this.items =
        },
        valid(){
            let pass = true;
            let {warehouse_id} = this.form;
            if(!warehouse_id){
                this.$toast.error('Seleccione un almacén');
                pass = false;
            }
            if(this.selectedItems.length === 0){
                this.$toast.error('Seleccione al menos un producto');
                pass = false;
            }
            //revisar si todos los items tienen cantidad
            this.selectedItems.forEach(item=>{
                if(item.quantity === 0){
                    this.$toast.error('Ingrese una cantidad para todos los productos');
                    pass = false;
                }
            })

            return pass;

        },
        searchRemoteItems(input) {
            if (input.length > 0) {
                clearTimeout(this.timer);
                this.loading_search_item = true;
                this.timer = setTimeout(() => {
                    this.$http
                        .get(
                            `/${this.resource}/search?input=${input}&warehouse_id=${this.form.warehouse_id}`
                        )
                        .then(response => {
                            console.log(
                                "🚀 ~ file: form.vue:98 ~ this.timer=setTimeout ~ response:",
                                response
                            );
                            if (response.status === 200) {
                                let { data } = response;
                                this.items = data.items;
                                1;
                            }
                        })
                        .catch(error => {
                            console.log(error.response);
                        })
                        .then(() => {
                            this.loading_search_item = false;
                        });
                }, 500);
            }
        },
        initForm() {
            this.errors = {};

            this.form = {
                warehouse_id: null,
                item_id: null
            };
        },
        async sendItems() {
            if(!this.valid()){
                return;
            }
            const response = await this.$http.post(
                `/${this.resource}/send-items`,
                {
                    items: this.selectedItems,
                    warehouse_id: this.form.warehouse_id,
                    manufactured_id: this.recordId
                }
            );
            if (response.status === 200) {
                let { data } = response;
                if (data.success) {
                    this.$toast.success(data.message);
                    this.$eventHub.$emit("reloadData");
                    this.close();
                } else {
                    this.$toast.error(data.message);
                }
            }         
        },
        async getTables() {
            const response = await this.$http(`/${this.resource}/tables`);
            if (response.status === 200) {
                let { data } = response;
                this.warehouses = data.warehouses;
            }
            console.log(
                "🚀 ~ file: form.vue:56 ~ getTables ~ response:",
                response
            );
        },
        async getLastProduct() {
            const response = await this.$http.get(
                `/${this.resource}/get-last-items/${this.recordId}`
            );
            if (response.status === 200) {
                let { data } = response;
                if (data.success) {
                    this.items = data.data;
                }
            }
        },
        create() {
            this.titleDialog = "Transformar producto";
            this.getLastProduct();
            this.getTables();
        },
        submit() {
            this.loading_submit = true;
            this.$http
                .post(`${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    } else {
                        console.log(error.response);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
