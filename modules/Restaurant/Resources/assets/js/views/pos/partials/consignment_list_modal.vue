<template>
    <el-dialog
        v-loading="loading"
        @open="open"
        @close="close"
        :visible="showDialog"
        title="Lista de Consignaciones"
        width="80%"
    >
        <div class="row mt-2">
            <div class="col-md-3">
                <label for="filter" class="w-100">Filtrar por:</label>
                <el-select v-model="search.column" placeholder="Selecccionar">
                    <el-option
                        v-for="(label, key) in columns"
                        :key="key"
                        :value="key"
                        :label="label"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-3">
                <label for="filter" class="w-100">Buscar:</label>
                <template
                    v-if="
                        search.column == 'date_of_issue' ||
                            search.column == 'date_of_end'
                    "
                >
                    <el-date-picker
                        v-model="search.value"
                        type="date"
                        style="width: 100%;"
                        placeholder="Buscar"
                        value-format="yyyy-MM-dd"
                        @change="getRecords"
                    >
                    </el-date-picker>
                </template>
                <template v-else>
                    <el-input
                        v-model="search.value"
                        placeholder="Buscar"
                        @input="getRecords"
                    >
                    </el-input>
                </template>
            </div>
        </div>
        <div>
            <el-pagination
                @current-change="getRecords()"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="Number(pagination.per_page)"
            >
            </el-pagination>
        </div>
        <div class="row mt-2">
            <table class="table table-responsive table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Cliente</th>
                        <th>Fecha de consignación</th>
                        <th>Fecha de liquidación</th>
                        <th>Productos</th>
                        <th>Total</th>
                        <th>Penalidad</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(consignment, idx) in records" :key="idx">
                        <td>{{ customIndex(idx) }}</td>
                        <td class="text-small ">
                            <template v-if="consignment.user_name"> 
                                <strong>CREADO:</strong> {{ consignment.user_name }} <br>
                            </template>
                            <template v-if="consignment.user_liquidated_name"> 
                                <strong>LIQUIDADO:</strong> {{ consignment.user_liquidated_name }}
                            </template>
                        </td>
                        <td>{{ consignment.person.name }}</td>
                        <td>{{ consignment.date_of_issue }}</td>
                        <td>{{ consignment.date_of_end }}</td>
                        <td>
                            <el-button
                                type="primary"
                                icon="el-icon-search"
                                @click="clickShowProducts(consignment)"
                                >{{ consignment.stock }}</el-button
                            >
                        </td>
                        <td>{{ consignment.total }}</td>
                        <td>
                            {{ consignment.penalty }}
                        </td>
                        <td>
                            <el-tooltip
                                v-if="consignment.expired"
                                content="Enviar mensaje de vencimiento al número de contacto del cliente"
                            >
                                <el-button
                                    @click="clickSendMessage(consignment.id)"
                                    type="success"
                                >
                                    <i class="el-icon-message"></i>
                                </el-button>
                            </el-tooltip>
                            <el-button
                                @click="clickFormat(consignment.id)"
                                type="primary"
                            >
                                <i class="el-icon-s-order"></i>
                            </el-button>
                        </td>
                        <td>
                            <template
                                v-if="
                                    consignment.liquidated &&
                                        consignment.download_url
                                "
                            >
                                <el-button
                                    type="success"
                                    @click="clickDownload(consignment)"
                                >
                                    {{ consignment.number_document }}
                                </el-button>
                            </template>
                            <el-button
                                v-if="!consignment.liquidated"
                                @click="clickLiquidate(consignment)"
                                type="success"
                            >
                                <i class="el-icon-cash"></i>
                                Liquidar
                            </el-button>
                            <span v-else>
                                Liquidado
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <items-modal
                :showDialog.sync="showDialogItems"
                :recordId="recordId"
            >
            </items-modal>
        </div>
    </el-dialog>
</template>

<script>
const ItemsModal = () =>
    import(
        "../../../../../../../Consignment/Resources/assets/js/views/partials/items.vue"
    );
export default {
    props: ["showDialog"],
    components: {
        ItemsModal
    },
    data() {
        return {
            loading: false,
            showDialogItems: false,
            showDialogDetail: false,
            recordId: null,
            form: {},
            records: [],
            loading_search: false,
            resource: "/consignment",
            pagination: {},
            search: {},
            columns: {
                person_id: "Cliente",
                date_of_issue: "Fecha de consignación",
                date_of_end: "Fecha de liquidación"
            }
        };
    },
    methods: {
        clickDownload(consignment) {
            window.open(consignment.download_url, "_blank");
        },

        changeClearInput() {},
        async clickSendMessage(id) {
            try {
                this.loading = true;
                const response = await this.$http(
                    `${this.resource}/message/${id}`
                );
                if (response.status == 200) {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                } else {
                    this.$toast.error("Ocurrió un error al enviar el mensaje");
                }
            } catch (e) {
                this.$toast.error(e.message);
            } finally {
                this.loading = false;
            }
        },
        clickFormat(id) {
            window.open(`/consignment/format/${id}`, "_blank");
        },
        async clickDetail(consignment) {
            this.recordId = consignment.id;
            this.showDialogDetail = true;
        },
        async clickLiquidate(consignment) {
            const response = await this.$http(
                `${this.resource}/liquidate/${consignment.id}`
            );
            if (response.status == 200) {
                if (response.data.success) {
                    let { foods } = response.data;
                    foods = foods.map(food => {
                        food.toWarehouse = 0;
                        food.originalQuantity = food.quantity;

                        return food;
                    });
                    this.$emit("setItemsToLiquidate", foods, consignment.id);
                    this.close();
                } else {
                    this.$toast.error(response.data.message);
                }
            } else {
                this.$toast.error(
                    "Ocurrió un error al liquidar la consignación"
                );
            }
        },
        clickShowProducts(consignment) {
            this.recordId = consignment.id;
            this.showDialogItems = true;
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `${this.resource}/records?column=${this.search.column ||
                        ""}&value=${this.search.value || ""}`
                );
                console.log(response);
                this.records = response.data.data;
                this.pagination = response.data.meta;
            } catch (e) {
                this.$toast.error(e.message);
            } finally {
                this.loading = false;
            }
        },
        open() {
            this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
