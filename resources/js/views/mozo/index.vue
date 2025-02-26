<!-- Listado de Vendedores -->
<template>
    <div>
      <div class="container-fluid p-l-0 p-r-0">
        <div class="card">
          <div class="card-header bg-primary d-flex align-items-center" style="padding: 15px;">
            <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1.5rem; font-weight: bold;">
              <i class="fas fa-user-tie" style="font-size: 2rem; margin-right: 0.5rem;"></i>
              Módulo de Mozos 
            </h4>
          </div>
          <div class="data-table-visible-columns">
            <el-button class="btn_titulos_modal" href="javascript:void(0)" @click.prevent="clickCreate()">
              <i class="fas fa-user-tie fa-lg"></i>
              <i class="fa fa-plus"></i>
              <span style="color: #000; font-size: 1.25rem; font-weight: bold;">Nuevo</span>
            </el-button>
          </div>
          <div class="card-body">
            <br />
            <data-table :resource="resource">
              <tr slot="heading" class="bg-primary">
                <th class="text-white">#</th>
                <th class="text-white">Nombre</th>
                <th class="text-white">Documento</th>
                <th class="text-white">Creado por</th>
                <th class="text-white">Fecha</th>
                <th class="text-white">Establecimiento</th>
                <th class="text-white text-end">Acciones</th>
              </tr>
              <tr></tr>
              <tr slot-scope="{ index, row }">
                <td>{{ index + 1 }}</td>
                <td>{{ row.name }}</td>
                <td>{{ row.document }}</td>
                <td>{{ row.user_name }}</td>
                <td>{{ row.created_at }}</td>
                <td>{{ row.establishment_description }}</td>
                <td class="text-end">
                  <button
                    class="btn p-0"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <span
                      class="btn btn-primary dropdown-toggle"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      data-bs-delay="0"
                      title
                      data-bs-original-title="Item Count"
                      aria-label="Item Count"
                    >Acciones</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" style>
                    <a
                      type="button"
                      class="dropdown-item text-secondary"
                      @click.prevent=" clickCreate(row.id)"
                    >
                      <i class="fa fa-edit"></i> Editar
                    </a>
                    <!-- <a
                      type="button"
                      class="dropdown-item text-danger"
                      @click.prevent="
                                              clickDelete(row.id)"
                    >
                      <i class="fa fa-trash"></i> Eliminar
                    </a>-->
                    <a
                      type="button"
                      class="dropdown-item text-warning"
                      @click.prevent="clickDisable(row.id)"
                      v-if="row.active"
                    >Inhabilitar</a>
                    <a
                      type="button"
                      class="dropdown-item text-success"
                      @click.prevent="clickEnable(row.id)"
                      v-else
                    >Habilitar</a>
                  </div>
                </td>
              </tr>
            </data-table>
          </div>
          <mozo-form
            :showDialog.sync="showDialog"
            :typeUser="typeUser"
            :establishments="establishments"
            :document_types="document_types"
            :recordId="recordId"
          ></mozo-form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import MozoForm from "./form.vue";
  import DataTable from "../../components/DataTableMozo.vue";
  import { deletable } from "../../mixins/deletable";
  
  export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: {
      MozoForm,
      DataTable,
    },
    data() {
      return {
        showDialog: false,
        showDialogProd: false,
        resource: "mozo",
        recordId: null,
        records: [],
        sellers: [],
        title: null,
        establishments: [],
        document_types: []
      };
    },
    created() {
      this.$eventHub.$on("reloadData", () => {
        this.getData();
      });
      this.getData();
      this.getTables();
    },
    methods: {
      getProd(id) {
        this.ListProdId = id;
        console.log("Ver el id del vendedor:", id);
        this.showDialogProd = true;
      },
      async getTables() {
        const response = await this.$http(`${this.resource}/tables`);
        console.log(response);
        const { establishments, document_types } = response.data;
        this.establishments = establishments;
        this.document_types = document_types;
        // this.establishments = response.data.data.establishments;
      },
      getData() {
        this.$http.get(`/${this.resource}/records`).then(response => {
          console.log("Datos de vendedores:", response.data.data);
          this.records = response.data.data;
          this.sellers = response.data.data;
        });
      },
      clickCreate(recordId = null) {
        console.log("sadas");
        this.recordId = recordId;
        this.showDialog = true;
      },
      clickDelete(id) {
        this.destroy(`/${this.resource}/delete/${id}`).then(() =>
          this.$eventHub.$emit("reloadData")
        );
      },
      clickDisable(id) {
        this.disable(`/${this.resource}/enabled/${0}/${id}`).then(() =>
          this.$eventHub.$emit("reloadData")
        );
      },
      clickEnable(id) {
        this.enable(`/${this.resource}/enabled/${1}/${id}`).then(() =>
          this.$eventHub.$emit("reloadData")
        );
      }
    }
  };
  </script>
  