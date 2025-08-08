<!-- Listado de Establecimientos -->
<template>
    <div>
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white my-0">
                    <i class="fas fa-warehouse "></i>
                    Listado
                </h4>
            </div>
            <div class="data-table-visible-columns">
                <el-tooltip content="Crear nuevo establecimiento" placement="top">
                    <el-button type="primary" class="btn_buscar" href="javascript:void(0)" @click.prevent="clickCreate()">
                        <i class="fas fa-plus"></i>
                        Nuevo
                    </el-button>
                </el-tooltip>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <el-table
                        :data="records"
                        style="width: 100%"
                        stripe
                        border
                        size="small"
                        empty-text="No hay establecimientos registrados."
                        header-cell-class-name="custom-table-header"
                    >
                        <el-table-column label="#" type="index" width="50" align="center" />
                        <el-table-column prop="document_logo" label="Logo Doc." min-width="100" align="center">
                            <template #default="scope">
                                <img
                                    v-if="scope.row.document_logo && scope.row.document_logo !== '0'"
                                    class="img-thumbnail"
                                    :src="`/storage/uploads/logos/${scope.row.document_logo}`"
                                    alt="Logo Documento"
                                    style="height: 100px; max-width: 150px; object-fit: contain;"
                                />
                                <span v-else style="color: #aaa;">Sin logo</span>
                            </template>
                        </el-table-column>
                        <el-table-column prop="description" label="Descripción" min-width="220">
                            <template #default="scope">
                                <div>
                                    <strong style="font-size: 1.3em; color: #073f68;">{{ scope.row.description }}</strong>
                                    <div>
                                        <strong style="font-size: 1em; ">
                                           CÓDIGO FISCAL:  {{ scope.row.code ? ' - ' + scope.row.code : '' }}
                                        </strong>
                                    </div>
                                    <div>
                                        <strong style="font-size: 1em; color: #145a32;">
                                           DIRECCIÓN : {{ scope.row.address || 'Sin dirección' }}
                                        </strong>
                                    </div>
                                    <div>
                                        <strong style="font-size: 1.2em; color: #073f68;">
                                            <i class="fas fa-print" style="margin-right: 6px;"></i>
                                            {{ scope.row.printer || 'No asignada' }}
                                        </strong>
                                    </div>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column prop="factura" label="Factura" min-width="100" align="center" />
                        <el-table-column prop="boleta" label="Boleta" min-width="100" align="center" />
                        <el-table-column prop="nota_venta" label="Nota de venta" min-width="100" align="center" />
                        <el-table-column label="Acciones" width="200" align="center" fixed="right">
                            <template #default="scope">
                                <el-tooltip content="Editar Establecimiento" placement="top">
                                    <el-button size="mini" type="primary" circle @click="clickCreate(scope.row.id)" class="mr-1">
                                        <i class="fas fa-edit"></i>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Eliminar Establecimiento" placement="top">
                                    <el-button size="mini" type="danger" circle @click="clickDelete(scope.row.id)" class="mr-1">
                                        <i class="fas fa-trash-alt"></i>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Series del Establecimiento" placement="top">
                                    <el-button size="mini" type="info" circle @click="clickSeries(scope.row.id)">
                                        <i class="fas fa-list-ol"></i>
                                    </el-button>
                                </el-tooltip>
                            </template>
                        </el-table-column>
                    </el-table>
                    
                </div>
    
            </div>
            <establishments-form :configuration="configuration" :seriesDefault.sync="seriesDefault"
                :soap_type_id="soap_type_id" :showDialog.sync="showDialog" :number.sync="number" :recordId="recordId"
                @generateSerie="generateSerie"></establishments-form>
            <establishment-series :showDialog.sync="showDialogSeries"
                :establishmentId="recordId"></establishment-series>
        </div>
    </div>
</template>

<style scoped>
                    .custom-table-header {
                        background: #195580 !important;
                        color: #fff !important;
                    }
                    </style>

<script>
import EstablishmentsForm from "./form1.vue";
import { deletable } from "../../mixins/deletable";
import EstablishmentSeries from "./partials/series.vue";

export default {
    props: ["typeUser", "soap_type_id", "configuration"],
    mixins: [deletable],
    components: { EstablishmentsForm, EstablishmentSeries },
    data() {
        return {
            showDialog: false,
            resource: "establishments",
            recordId: null,
            records: [],
            showDialogSeries: false,
            seriesDefault: [],
            number: 1
        };
    },
    created() {
        console.log(this.configuration);
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
        this.series();
    },
    methods: {
        generateSerie() {
            let num = this.number;
            console.log(this.number, " aa");
            if (num >= 100) {
                console.error("El número es mayor o igual a 100");
                return;
            }
            let numStr = num.toString().padStart(2, "0");
            const fCode = `F0${numStr}`;
            const bCode = `B0${numStr}`;
            const nCode = `NV${numStr}`;
            this.seriesDefault = [
                {
                    id: "01",
                    serie: fCode
                },
                {
                    id: "03",
                    serie: bCode
                },
                {
                    id: "80",
                    serie: nCode
                }
            ];
        },
        async series() {
            const response = await this.$http.get(`/series/records/all`);
            if (response.status == 200) {
                let {
                    data: { data }
                } = response;
                if (data.length != 0) {
                    data = data.map(d => d.number);

                    const onlyNumber = data.map(elemento => {
                        return parseInt(elemento.match(/\d+$/)[0]);
                    });
                    const bigNumber = Math.max(...onlyNumber);
                    const result = bigNumber + 1;
                    this.number = result;
                }

                this.generateSerie(this.number);
                console.log(this.seriesDefault);
            }
        },
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
                console.log('ESTABLISHMENTS DATA:', this.records);
            });
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickSeries(recordId = null) {
            this.recordId = recordId;
            this.showDialogSeries = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
