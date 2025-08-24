<!-- Listado de Cuentas Bancarias  -->
<template>
    
<div class="card">
    <!-- Titulo de la vista -->
    <div class="card-header bg-primary d-flex align-items-center" style="padding: 8px;">
        <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1rem; font-weight: bold;">
            <i class="fas fa-coins" style="font-size: 1rem; margin-right: 0.5rem;"></i>
            Módulo de Cuentas Bancarias
        </h4>
    </div>

    <div class="data-table-visible-columns" >
        <el-button class="btn_guardarsmall" type="primary" href="javascript:void(0)" @click.prevent="addNewAccount">
            
            <i class="fa fa-plus"></i>
            <span >Nuevo</span>
        </el-button>
    </div>

    
<!--     
    <div class="data-table-visible-columns">
        <div class="d-flex align-items-center justify-content-start gap-3">
            <el-button type="primary" class="btn-large" href="javascript:void(0)" @click.prevent="addNewAccount">
                <i class="fas fa-coins fa-lg" style="font-size: 1.5rem; margin-right: 0.5rem;"></i>
                <span style="font-size: 1.25rem; font-weight: bold;">
                    <i class="fa fa-plus"></i>
                    Nueva Cuenta Bancaria
                </span>
            </el-button>

        </div>
    </div> -->

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover custom-table">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="text-white">#</th>
                        <th class="text-white">Descripción</th>
                        <th class="text-white text-center">Creado Por</th>
                        <th class="text-white text-center">Número</th>
                        <th class="text-white text-center">Balance</th>
                        <th class="text-end text-white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in records" :key="index" :class="index % 2 === 0 ? 'table-row-even' : 'table-row-odd'">
                        <!-- Número de Fila -->
                        <td>{{ index + 1 }}</td>

                        <!-- Descripción -->
                        <td>{{ row.description }}</td>
                        <td class="text-center">{{ row.user_name }}</td>

                        <!-- Número -->
                        <td class="text-center">{{ row.number }}</td>

                        <!-- Balance -->
                        <td class="text-center">{{ row.balance }}</td>

                        <!-- Acciones -->
                        <td class="text-end">
                            <!-- Botón Editar -->
                            <el-button
                                circle
                                size="small"
                                type="info"
                                title="Editar"
                                @click.prevent="clickCreate(row.id)"
                                class="me-1"
                            >
                                <i class="fa fa-edit"></i>
                            </el-button>
                            <!-- Botón Eliminar (Solo para Admin/SuperAdmin) -->
                            <el-button
                                v-if="typeUser === 'admin' || typeUser === 'superadmin'"
                                circle
                                size="small"
                                type="danger"
                                title="Eliminar"
                                @click.prevent="clickDelete(row.id)"
                            >
                                <i class="fa fa-trash"></i>
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    <bank-accounts-form :showDialog.sync="showDialog" :recordId="recordId"></bank-accounts-form>
</div>
</template>

<script>
import BankAccountsForm from "./form.vue";
import {
    deletable
} from "../../mixins/deletable";

export default {
    mixins: [deletable],
    props: ["typeUser"],
    components: {
        BankAccountsForm
    },
    data() {
        return {
            showDialog: false,
            resource: "bank_accounts",
            recordId: null,
            records: [],
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
    },
    methods: {
        addNewAccount() {
            this.showDialog = true;
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
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
