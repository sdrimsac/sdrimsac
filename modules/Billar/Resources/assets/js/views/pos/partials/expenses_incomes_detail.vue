<template>
    <div v-loading="loading">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Motivo
                    </th>
                    <th>Detalle</th>
                    <th>Fecha</th>
                    <th>
                        Total
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data, idx) in records" :key="idx">
                    <td>{{ idx + 1 }}</td>
                    <td>{{ data.description }}</td>
                    <td>
                        <template v-if="data.items.length != 0">
                            <el-button @click="seeDetail(data.items)">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                Ver
                            </el-button>
                        </template>
                    </td>
                    <td>{{ data.date }}</td>
                    <td>{{ data.amount }} <br /></td>
                    <td>
                        <el-button
                        rounded
                            size="mini"
                            type="success"
                            @click="Printer(data)"
                        >
                            <i class="fa fa-print" aria-hidden="true"></i>
                        </el-button>
                        <el-button
                            rounded
                            size="mini"
                            type="danger"
                            @click="deleteRecord(data.id)"
                        >
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </el-button>
                        <el-button
                            rounded
                            size="mini"
                            type="info"
                            @click="editRecord(data.id)"
                        >
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </el-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <el-pagination
            @current-change="getRecords"
            layout="total, prev, pager, next"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size="pagination.per_page"
        ></el-pagination>
        <el-dialog append-to-body :visible.sync="showDetails">
            <div class="p-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>DESCP.</th>
                            <th>CANT.</th>
                            <th>PRECIO UNIT</th>
                            <th>PRECIO ADICIONAL</th>
                            <th>PRECIO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(dt, idx) in currentItems" :key="idx">
                            <td>{{ dt.detail }}</td>
                            <td>
                                {{ dt.quantity.toFixed(2) }}
                                {{ dt.unit_id }}
                            </td>
                            <td>{{ dt.price.toFixed(2) }}</td>
                            <td>{{ dt.extra_price.toFixed(2) }}</td>
                            <td>
                                {{
                                    (
                                        dt.price * dt.quantity +
                                        dt.extra_price
                                    ).toFixed(2)
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </el-dialog>
    </div>
</template>

<script>
export default {
    components: {},
    props: ["records", "pagination", "type", "company", "establishments"],
    data() {
        return {
            loading: false,
            showWhatsappModal: false,
            currentId: null,
            currentType: null,
            currentNumber: null,
            currentItems: [],
            showDetails: false
        };
    },
    methods: {
        editRecord(id) {
            this.$emit("editRecord", id, this.type);
        },
        async Printer(box) {
            console.log(box);
            let linkpdf = `/caja/worker/expenses/print-box?box_id=${box.id}`
            
            let Printer = this.establishments.printer;
            let paperConfig = {
                scaleContent: false
            };
            let config = qz.configs.create(Printer, paperConfig);

            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }
            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: linkpdf
                }
            ];

            qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
            });
        },
        async deleteRecord(id) {
            //$confirm
            try {
                await this.$confirm(
                    "¿Está seguro de eliminar este registro?",
                    "Advertencia",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );

                const response = await this.$http.delete(
                    `/caja/worker/cash/incomes_expenses/${id}/${this.type}`
                );

                if (response.data.success) {
                    this.$toast.success("Registro eliminado con éxito");
                    this.$emit("getRecords", this.pagination.current_page);
                }
            } catch (e) {
                console.log(e);
            }
        },
        seeDetail(items) {
            this.currentItems = items;
            this.showDetails = true;
        },
        getRecords() {
            this.$emit("getRecords", this.pagination.current_page);
        }
    }
};
</script>
