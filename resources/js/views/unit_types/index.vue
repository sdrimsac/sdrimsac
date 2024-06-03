<template>
    <div class="card card-collapsed">
        <div class="card-header bg-primary">
            <h4 class="my-0 text-white">
                <i class="fas fa-sitemap"></i> Listado de Unidad de Medida
            </h4>
        </div>
        <div class="data-table-visible-columns">
            <el-button type="primary" class="" @click.prevent="clickCreate()">
                <i class="fas fa-sitemap fa-lg"></i>
                <i class="fa fa-plus"></i>
                Nueva Unidad
            </el-button>
        </div>
        <div class="card-body">
            <data-table :resource="resource" >
    
                <tr slot="heading" class="bg-primary">
                    <th class="text-white">#</th>
                    <th class="text-white">Código</th>
                    <th class="text-white">Descripción</th>
                    <th class="text-white">Símbolo</th>
                    <th class="text-white text-center">Activo</th>
                    <th class="text-white text-end">Acciones</th>
                </tr>
    
                <tr slot-scope="{ index, row }">
                    <td>{{ index }}</td>
                    <td>{{ row.id }}</td>
                    <td>{{ row.description }}</td>
                    <td>{{ row.symbol }}</td>
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
        <unit-types-form :showDialog.sync="showDialog" :recordId="recordId"></unit-types-form>
    </div>
    </template>

    <script>
    import UnitTypesForm from "./form.vue";
    import DataTable from "../../components/DataTable.vue";
    import {
        deletable
    } from "../../mixins/deletable";
    
    export default {
        mixins: [deletable],
        components: {
            DataTable,
            UnitTypesForm
        },
        data() {
            return {
                title: null,
                showDialog: false,
                resource: "unit_types",
                recordId: null,
    
            };
        },
        methods: {
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
    