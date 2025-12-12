<template>
    <div class="card card-collapsed">
    
        <div class="card-header bg-primary">
            <h4 class="my-0 text-white">
                <i class="fas fa-sitemap"></i> Listado de Atributos
            </h4>
        </div>
        <div class="data-table-visible-columns">
            <el-button type="primary" class="btn_guardarsmall" @click.prevent="clickCreate()">
                <i class="fa fa-plus"></i>
                Nuevo
            </el-button>
        </div>
    
        <div class="card-body">
            <data-table :resource="resource">
    
                <tr slot="heading" class="bg-primary">
                    <th class="text-white">#</th>
                    <th class="text-white">Código</th>
                    <th class="text-white">Descripción</th>
                    <th class="text-white">Activo</th>
                    <th class="text-white text-end">Acciones</th>
                </tr>
    
                <tr slot-scope="{ index, row }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                    <td>{{ index }}</td>
                    <td>{{ row.id }}</td>
                    <td>{{ row.description }}</td>
                    <td class="text-center">{{ row.active }}</td>
                    <td class="text-right">
                        <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a type="button" class="dropdown-item text-secondary" @click.prevent="
                                         clickCreate(row.id)"> <i class="fa fa-edit"></i> Editar
                            </a>
                            <a type="button" class="dropdown-item text-danger" @click.prevent="clickDelete(row.id)">
                                <i class="fa fa-trash"></i>
                                Eliminar
                            </a>
                        </div>
                    </td>
                </tr>
            </data-table>
        </div>
    
        <tribute-concept-types-form :showDialog.sync="showDialog" :recordId="recordId"></tribute-concept-types-form>
    </div>
    </template>
    
   
    
    <script>
    import TributeConceptTypesForm from "./form.vue";
    import DataTable from "../../components/DataTable.vue"
    
    import {
        deletable
    } from "../../mixins/deletable";
    
    export default {
        mixins: [deletable],
        props: ["typeUser"],
        components: {
            TributeConceptTypesForm,
            DataTable
        },
        data() {
            return {
                showDialog: false,
                resource: "tribute_concept_types",
                recordId: null,
                /* records: [] */
            };
        },
        /* created() {
            this.$eventHub.$on("reloadData", () => {
                this.getData();
            });
            this.getData();
        }, */
        methods: {
            /* getData() {
                this.$http.get(`/${this.resource}/records`).then(response => {
                    this.records = response.data.data;
                });
            }, */
            clickCreate(recordId = null) {
                this.recordId = recordId;
                this.showDialog = true;
            },
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit("reloadData")
                );
            }
        }
    };
    </script>
    