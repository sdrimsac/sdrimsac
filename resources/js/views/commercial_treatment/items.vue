<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        :title="title"
        v-loading="loading"
    >
        <div class="row">
            <div class="col-8">
                <label for="general">Producto </label>
                <el-select
                    v-model="form.item_id"
                    class="w-100"
                    filterable
                    remote
                    popper-class="el-select-customers"
                    clearable
                    @change="changeItem"
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
            <div class="col-4 d-flex align-items-end">
                <el-button
                    type="primary"
                    icon="el-icon-plus"
                    :disabled="!form.item_id"
                    @click="addGeneralValue"
                >
                    Agregar
                </el-button>
            </div>
        </div>
        <div class="row d-flex justify-content-center table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Valor - Tratamiento comercial</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in tableData" :key="index">
                        <td>{{ customIndex(index) }}</td>
                        <td>{{ item.item.description }}</td>
                        <td>{{ item.amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <el-pagination
            @current-change="getRecords"
            layout="total, prev, pager, next"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size="pagination.per_page"
        >
        </el-pagination>
        <el-dialog
            :visible.sync="showDialogLocal"
            width="30%"
            :title="`Tratamiento comercial - ${item.description}`"
            append-to-body
            @open="openRecord"
            @close="showDialogLocal = false"
            v-loading="loadingLocal"
        >
            <div class="row m-2">
                <label for="general">Valor por tratamiento</label>
                <el-input
                    type="number"
                    class="w-100"
                    v-model="general"
                ></el-input>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showDialogLocal = false">Cancelar</el-button>
                <el-button type="primary" @click="setGeneralValue"
                    >Agregar</el-button
                >
            </span>
        </el-dialog>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "commercialTreatment"],
    data() {
        return {
            general: 0,
            originalTitle: "Producto x tratamiento comercial",
            title: "Producto x tratamiento comercial",
            form: {},
            loading: false,
            resource: "commercial_treatment/items",
            tableData: [],
            timer: null,
            items: [],
            loading_search_item: false,
            showDialogLocal: false,
            item: {},
            loadingLocal: false,
            pagination: {}
        };
    },
    methods: {
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async setGeneralValue() {
            try {
                this.loadingLocal = true;
                const response = await this.$http.post(
                    `${this.resource}/record/${this.item.id}/${this.commercialTreatment.id}`,
                    {
                        amount: this.general
                    }
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Datos guardados correctamente",
                        type: "success"
                    });
                    this.showDialogLocal = false;
                    this.getRecords();
                }
            } catch (e) {
            } finally {
                this.loadingLocal = false;
            }
        },
        changeItem() {},
        searchRemoteItems(input) {
            if (input.length > 2) {
                clearTimeout(this.timer);
                this.loading_search_item = true;
                this.timer = setTimeout(() => {
                    this.$http
                        .get(`/inventory/items?value=${input}`)
                        .then(response => {
                            this.items = response.data;
                            this.loading_search_item = false;
                        });
                }, 600);
            }
        },
        addGeneralValue() {
            this.showDialogLocal = true;
            this.item = this.items.find(item => item.id == this.form.item_id);
        },
        async getRecords() {
            this.loading = true;
            const response = await this.$http.get(
                `${this.resource}/records/${this.commercialTreatment.id}`
            );

            if (response.status == 200) {
                let { data, meta } = response.data;
                this.tableData = data;
                this.pagination = meta;
                this.pagination.per_page = parseInt(
                    response.data.meta.per_page
                );
            }
            this.loading = false;
        },
        async openRecord() {
            const response = await this.$http.get(
                `${this.resource}/record/${this.item.id}/${this.commercialTreatment.id}`
            );
            console.log(
                "🚀 ~ file: items.vue:132 ~ openRecord ~ response:",
                response
            );
        },
        async submit() {
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `${this.resource}/${this.commercialTreatment.id}`,
                    {
                        data: this.tableData
                    }
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Datos guardados correctamente",
                        type: "success"
                    });
                    this.close();
                }
            } catch (e) {
                this.$message({
                    message: "Ocurrio un error al guardar los datos",
                    type: "error"
                });
            } finally {
                this.loading = false;
            }
        },
        async open() {
            this.form = {
                item_id: null
            };
            this.title =
                this.originalTitle + "/" + this.commercialTreatment.description;
            await this.getRecords();
        },
        async close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
