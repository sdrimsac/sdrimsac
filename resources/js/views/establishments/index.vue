<!-- Listado de Establecimientos -->
<template>
<div>
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white my-0">
                <i class="fas fa-warehouse fa-lg"></i> 
                Listado de establecimientos
            </h4>
        </div>
        <div class="data-table-visible-columns">
                <el-button type="primary" 
                            class="" 
                            href="javascript:void(0)" 
                            @click.prevent="clickCreate()">
                            <i class="fas fa-warehouse fa-lg"></i>
                            <i class="fas fa-plus"></i>
                             Nuevo Establecimiento
                </el-button>
        </div> 
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white">#</th>
                            <th class="text-white">Descripción</th>
                            <th class="text-white text-end">Código</th>
                            <th class="text-white text-end">Factura</th>
                            <th class="text-white text-end">Boleta</th>
                            <th class="text-white text-end">Nota de venta</th>
                            <th class="text-white text-end">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in records" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ row.description }}</td>
                            <td class="text-end">{{ row.code }}</td>
                            <td class="text-end">{{ row.factura }}</td>
                            <td class="text-end">{{ row.boleta }}</td>
                            <td class="text-end">{{ row.nota_venta }}</td>
                            <td class="text-end">

                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a type="button" class="dropdown-item" @click.prevent="
                                                        clickCreate(
                                                            row.id
                                                        )
                                                    ">Editar
                                    </a>
                                    <a type="button" class="dropdown-item" @click.prevent="
                                                        clickDelete(
                                                            row.id
                                                        )
                                                    ">Eliminar
                                    </a>
                                    <a type="button" class="dropdown-item" @click.prevent="
                                                        clickSeries(
                                                            row.id
                                                        )
                                                    ">Series
                                    </a>

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" v-if="typeUser != 'integrator'" @click.prevent="clickCreate()"><i class="fa fa-plus-circle"></i> Nuevo</button>
                        </div>
                    </div> -->
        </div>
        <establishments-form :configuration="configuration" :seriesDefault.sync="seriesDefault" :soap_type_id="soap_type_id" :showDialog.sync="showDialog" :number.sync="number" :recordId="recordId" @generateSerie="generateSerie"></establishments-form>
        <establishment-series :showDialog.sync="showDialogSeries" :establishmentId="recordId"></establishment-series>
    </div>
</div>
</template>

<script>
import EstablishmentsForm from "./form1.vue";
import { deletable } from "../../mixins/deletable";
import EstablishmentSeries from "./partials/series.vue";

export default {
    props: ["typeUser", "soap_type_id","configuration"],
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
