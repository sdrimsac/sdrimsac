<!-- Listado de Cuentas Bancarias  -->
<template>
<div class="card">

    <div class="card-header bg-primary mt-0">
        <h4 class="my-0 text-white"><i class="fas fa-coins"></i> Listado de Cuentas Bancarias</h4>
    </div>

    <div class="data-table-visible-columns">
         <el-button type="primary" 
                    class="" 
                    href="javascript:void(0)" 
                    @click.prevent="addNewAccount">
                    <i class="fas fa-coins fa-lg"></i>
                  <i class="fa fa-plus"></i>
                  Agregar Nueva Cuenta
          </el-button>
    </div> 
    

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Descripción</th>
                        <th class="text-white text-center">Número</th>
                        <th class="text-white text-center">Balance</th>
                        <th class="text-end text-white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in records" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ row.description }}</td>
                        <td class="text-center">{{ row.number }}</td>
                        <td class="text-center">{{ row.balance }}</td>
                        <td class="text-end">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a type="button" class="dropdown-item text-secondary" @click.prevent=" clickCreate(row.id)"> <i class="fa fa-edit"></i> Editar
                                </a>
                                <template v-if=" typeUser === 'admin' || typeUser === 'superadmin'">

                                    <a type="button" class="dropdown-item text-danger" @click.prevent="
                                    clickDelete(row.id)"> <i class="fa fa-trash"></i> Eliminar
                                    </a>
                                </template>
                                <!-- <a type="button" class="dropdown-item text-warning" @click.prevent="
                                    clickDisable(row.id)" v-if="row.active">Inhabilitar
                                </a>
                                <a type="button" class="dropdown-item text-success" @click.prevent="
                                    clickEnable(row.id)" v-else>Habilitar
                                </a> -->
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" @click.prevent="clickCreate()">
                    <i class="fa fa-plus-circle"></i> Nuevo
                </button>
            </div>
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
