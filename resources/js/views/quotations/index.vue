<!-- Modulo de Cotizaciones -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary d-flex align-items-center" style="padding: 15px;">
                    <h4
                        class="my-0 text-white d-flex align-items-center"
                        style="font-size: 1.5rem; font-weight: bold;"
                    >
                        <i
                            class="fas fa-file-alt"
                            style="font-size: 2rem; margin-right: 0.5rem;"
                        ></i>
                        Cotizaciones
                    </h4>
                </div>
                

                <div class="data-table-visible-columns">
                    <a
                        :href="`/${resource}/create`"
                        class="btn_buscar"
                    >
                        <i class="fa fa-plus"></i>
                        <span>Nuevo</span>
                    </a>
                </div>

                <div class="card-body">
                    <data-table :resource="resource" :sellers="sellers">
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white">#</th>
                            <th class="text-white text-end">Acciones</th>
                            <th class="text-white text-center">
                                Fecha Emisión
                            </th>
                            <th
                                class="text-white text-center"
                                v-if="columns.delivery_date.visible"
                            >
                                Fecha Entrega
                            </th>
                            <th class="text-white">Vendedor</th>
                            <th class="text-white">Cliente</th>
                            
                            <th class="text-white">Cotización</th>
                            <th class="text-white">CPE</th>
                            <th class="text-white">Nota de venta</th>
                            <!-- <th class="text-white">Oportunidad Venta</th> -->
                            <th
                                class="text-white"
                                v-if="columns.contract.visible"
                            >
                                Contrato
                            </th>
                            <!-- <th>Estado</th> -->
                            <th class="text-white text-center">Moneda</th>
                            <th
                                class="text-end text-white"
                                v-if="columns.total_exportation.visible"
                            >
                                T.Exportación
                            </th>
                            <th
                                class="text-endtext-white"
                                v-if="columns.total_free.visible"
                            >
                                T.Gratuito
                            </th>
                            <th
                                class="text-end text-white"
                                v-if="columns.total_unaffected.visible"
                            >
                                T.Inafecta
                            </th>
                            <th
                                class="text-end text-white"
                                v-if="columns.total_exonerated.visible"
                            >
                                T.Exonerado
                            </th>
                            <!-- <th class="text-end text-white">T.Gravado</th> -->
                            <th class="text-end text-white">IGV</th>
                            <th class="text-end text-white">Total</th>
                            <th class="text-end text-white"></th>
                        </tr>

                        <tr></tr>
                        <tr
                            slot-scope="{ index, row }"
                            :class="{
                                anulate_color: row.state_type_id == '11'
                            }"
                        >
                            <td>{{ index }}</td>

                            <!-- Acciones -->
                            <td class="text-end">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-sm btn-primary dropdown-toggle"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        Acciones
                                    </button>
                                    <ul
                                        class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton"
                                        style="background-color: #e0e0e0; padding: 0 10px;"
                                    >
                                        <li>
                                            <button
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        row.btn_generate &&
                                                        (typeUser == 'admin' ||
                                                            typeUser == 'superadmin') &&
                                                        soapCompany != '03'
                                                "
                                                type="button"
                                                class="dropdown-item btn btn-success text-start"
                                                style="margin-bottom: 10px; background-color: #28a745; color: white;"
                                                @click.prevent="clickOptions(row.id)"
                                            >
                                                <i class="fa fa-file-alt me-2"></i>
                                                Generar CPE
                                            </button>
                                        </li>
                                        <li>
                                            <a
                                                v-if="
                                                    row.documents.length == 0 &&
                                                        row.state_type_id != '11'
                                                "
                                                :href="`/${resource}/edit/${row.id}`"
                                                class="dropdown-item btn btn-primary text-start"
                                                style="margin-bottom: 10px; background-color: #007bff; color: white;"
                                            >
                                                <i class="fa fa-edit me-2"></i>
                                                Modificar
                                            </a>
                                        </li>
                                        <li>
                                            <button
                                                v-if="
                                                    row.documents.length == 0 &&
                                                        row.state_type_id != '11'
                                                "
                                                type="button"
                                                class="dropdown-item btn btn-danger text-start"
                                                style="margin-bottom: 10px; background-color: #dc3545; color: white;"
                                                @click.prevent="clickAnulate(row.id)"
                                            >
                                                <i class="fa fa-ban me-2"></i>
                                                Anular
                                            </button>
                                        </li>
                                        <li>
                                            <button
                                                @click="duplicate(row.id)"
                                                type="button"
                                                class="dropdown-item btn btn-warning text-start"
                                                style="margin-bottom: 10px; background-color: #ffc107; color: black;"
                                            >
                                                <i class="fa fa-copy me-2"></i>
                                                Duplicar
                                            </button>
                                        </li>
                                        <li>
                                            <a
                                                v-if="
                                                    row.btn_generate_cnt &&
                                                        row.state_type_id != '11'
                                                "
                                                :href="
                                                    `/contracts/generate-quotation/${row.id}`
                                                "
                                                class="dropdown-item btn btn-info text-start"
                                                style="margin-bottom: 10px; background-color: #17a2b8; color: white;"
                                            >
                                                <i class="fa fa-file-contract me-2"></i>
                                                Generar contrato
                                            </a>
                                        </li>
                                    
                                        <li>
                                            <button
                                                class="dropdown-item btn btn-info text-start"
                                                style="margin-bottom: 10px; background-color: #17a2b8; color: white;"
                                                @click.prevent="clickOptionsPdf(row.id)"
                                            >
                                                <i class="fa fa-print me-2"></i>
                                                Imprimir
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center">{{ row.date_of_issue }}</td>

                            

                            <td
                                class="text-center"
                                v-if="columns.delivery_date.visible"
                            >
                                {{ row.delivery_date }}
                            </td>

                            <td>
                                <template v-if="row.user_name.includes(' - ')">
                                    <div v-for="(part, index) in row.user_name.split(' - ')" :key="index">
                                        {{ part }}
                                    </div>
                                </template>
                                <template v-else>
                                    {{ row.user_name }}
                                </template>
                            </td>
                            <td>
                                {{ row.customer_name }}<br /><small
                                    v-text="row.customer_number"
                                ></small>
                            </td>
                            <!-- <td>
                                <template v-if="row.state_type_id == '11'">
                                    {{ row.state_type_description }}
                                </template>
                                <template v-else>
                                    <el-select
                                        v-model="row.state_type_id"
                                        @change="changeStateType(row)"
                                        style="width:120px !important"
                                    >
                                        <el-option
                                            v-for="option in state_types"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                </template>
                            </td> -->
                            <td><span style="color: blue; font-weight: bold;">{{ row.identifier }}</span></td>
                            <td>
                                <template
                                    v-for="(document, i) in row.documents"
                                >
                                    <label
                                        ::key="i"
                                        v-text="document.number_full"
                                        class="d-block"
                                        style="color: darkgreen; font-weight: bold;"
                                    ></label>
                                </template>
                            </td>
                            <td>
                                <template
                                    v-for="(sale_note, i) in row.sale_notes"
                                >
                                    <label
                                        ::key="i"
                                        v-text="sale_note.identifier"
                                        class="d-block"
                                        style="color: #ffc107; font-weight: bold;"
                                    ></label>
                                </template>
                            </td>

                            <!-- Oportunidad de Venta -->
                              <!-- {{ row.sale_opportunity_number_full }} -->
                            <!-- <td>
                               

                                <el-popover
                                    placement="right"
                                    v-if="row.sale_opportunity"
                                    width="400"
                                    trigger="click"
                                >
                                    <div class="col-md-12 mt-4">
                                        <table>
                                            <tr>
                                                <td>
                                                    <strong>O. Venta: </strong>
                                                </td>
                                                <td>
                                                    <strong>{{
                                                        row.sale_opportunity_number_full
                                                    }}</strong>
                                                </td>
                                            </tr>
                                            <tr class="mt-4 mb-4">
                                                <td>
                                                    <strong>F. Emisión:</strong>
                                                </td>
                                                <td>
                                                    <strong>{{
                                                        row.date_of_issue
                                                    }}</strong>
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="table-responsive mt-4">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Descripción</th>
                                                        <th>Cantidad</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="(row,
                                                        index) in row
                                                            .sale_opportunity
                                                            .items"
                                                        :key="index"
                                                    >
                                                        <td>{{ index + 1 }}</td>
                                                        <td>
                                                            {{
                                                                row.item
                                                                    .description
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{ row.quantity }}
                                                        </td>
                                                        <td>{{ row.total }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <el-button slot="reference">
                                        <i class="fa fa-eye"></i
                                    ></el-button>
                                </el-popover>
                            </td> -->
                            
                            <!-- <td>{{ row.state_type_description }}</td> -->
                            <td v-if="columns.contract.visible">
                                {{ row.contract_number_full }}
                            </td>
                            <td class="text-center">
                                {{ row.currency_type_id }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_exportation.visible"
                            >
                                {{ row.total_exportation }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_free.visible"
                            >
                                {{ row.total_free }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_unaffected.visible"
                            >
                                {{ row.total_unaffected }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_exonerated.visible"
                            >
                                {{ row.total_exonerated }}
                            </td>
                            <!-- <td class="text-end">{{ row.total_taxed }}</td> -->
                            <td class="text-end">{{ row.total_igv }}</td>
                            <td class="text-end">{{ row.total }}</td>
                            <td class="text-end"></td>
                        </tr>
                    </data-table>
                </div>

                <quotation-options
                    :showDialog.sync="showDialogOptions"
                    :recordId="recordId"
                    :showGenerate="true"
                    :showClose="true"
                ></quotation-options>

                <quotation-options-pdf
                    :showDialog.sync="showDialogOptionsPdf"
                    :recordId="recordId"
                    :showClose="true"
                ></quotation-options-pdf>
            </div>
        </div>
    </div>
</template>
<style scoped>
.anulate_color {
    color: red;
}
</style>
<script>
import QuotationOptions from "./partials/options.vue";
import QuotationOptionsPdf from "./partials/options_pdf.vue";
import DataTable from "../../components/DataTable.vue";
import { deletable } from "../../mixins/deletable";

export default {
    props: ["typeUser", "soapCompany"],
    mixins: [deletable],
    components: { DataTable, QuotationOptions, QuotationOptionsPdf },
    data() {
        return {
            resource: "quotations",
            recordId: null,
            showDialogOptions: false,
            showDialogOptionsPdf: false,
            state_types: [],
            cashId: null,
            sellers: [],
            columns: {
                total_exportation: {
                    title: "T.Exportación",
                    visible: false
                },
                total_unaffected: {
                    title: "T.Inafecto",
                    visible: false
                },
                total_exonerated: {
                    title: "T.Exonerado",
                    visible: false
                },
                total_free: {
                    title: "T.Gratuito",
                    visible: false
                },
                contract: {
                    title: "Contrato",
                    visible: false
                },
                delivery_date: {
                    title: "F.Entrega",
                    visible: false
                }
            }
        };
    },
    async created() {
        await this.filter();
        if (this.$cashId) {
            this.cashId = this.$cashId;
        }
    },
    methods: {
        async changeStateType(row) {
            await this.updateStateType(
                `/${this.resource}/state-type/${row.state_type_id}/${row.id}`
            ).then(() => this.$eventHub.$emit("reloadData"));
        },
        filter() {
            this.$http.get(`/${this.resource}/filter`).then(response => {
                this.state_types = response.data.state_types;
                this.sellers = response.data.sellers;
            });
        },
        clickEdit(id) {
            this.recordId = id;
            this.showDialogFormEdit = true;
        },
        clickOptions(recordId = null) {
            this.recordId = recordId;
            this.showDialogOptions = true;
        },
        clickOptionsPdf(recordId = null) {
            this.recordId = recordId;
            this.showDialogOptionsPdf = true;
        },
        clickAnulate(id) {
            this.anular(`/${this.resource}/anular/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        duplicate(id) {
            this.$http
                .post(`${this.resource}/duplicate`, { id })
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(
                            "Se guardaron los cambios correctamente."
                        );
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$message.error("No se guardaron los cambios");
                    }
                })
                .catch(error => {});
            this.$eventHub.$emit("reloadData");
        }
    }
};
</script>
