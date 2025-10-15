<template>
    <el-dialog
        title="Edición de producto"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        width="40%"
    >
        <div class="row mt-2">
            <div class="col-md-10">
                <el-select
                    filterable
                    :remote-method="searchRemoteItems"
                    :loading="loadingSearchItem"
                    remote
                    v-model="form.item_id"
                >
                    <el-option
                        v-for="item in items"
                        :key="item.id"
                        :label="item.description"
                        :value="item.id"
                    >
                    </el-option>
                </el-select>
            </div>

            <div class="col-md-2">
                <el-button
                    class="btn_guardarsmall"
                    type="primary"
                    @click="editProduct"
                    :loading="loading"
                >
                    <i class="fas fa-edit"></i>
                    Editar
                </el-button>
            </div>
        </div>

        <span slot="footer" class="dialog-footer mt-1 d-flex justify-content-end">
            <el-button class="btn_cancelarsmall" type="primary" @click="close">Cerrar</el-button>
        </span>
        <item-form
            :showDialog.sync="showDialogNewItem"
            :external="false"
            :recordId="form.item_id"
        >
        </item-form>
    </el-dialog>
</template>
<script>
const ItemForm = () =>
    import("../../../../../../../../resources/js/views/items/form.vue");
export default {
    props: ["showDialog", "allItems"],
    components: {
        ItemForm
    },
    data() {
        return {
            loading: false,
            items: [],
            form: {},
            loadingSearchItem: false,
            showDialogNewItem: false
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
        
            this.$emit("getFoods");
            this.form.item_id = null;
        });
    },
    methods: {
        editProduct() {
            this.showDialogNewItem = true;
        },
        searchRemoteItems(input) {
            if (input.length > 0) {
                this.loadingSearchItem = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/documents/search-items?${parameters}`)
                    .then(response => {
                        if (response.data) {
                            let items = response.data;

                            if (items.length > 0) {
                                this.items = items;
                            }
                        }
                        this.loadingSearchItem = false;
                    })
                    .catch(_ => {
                        this.loadingSearchItem = false;
                    });
            }
        },
        open() {
            this.items = this.allItems.map(i => i.item);
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
