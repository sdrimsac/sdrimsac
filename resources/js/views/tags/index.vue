<template>
  <div>
    <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6><span>Tags</span></h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><span class="text-muted">Tags</span></li>
                  </ol>
                </div>
                 <div class="col-sm-6">
                  <div class="bookmark">
                  <ul>
                      <li  v-if="typeUser != 'integrator'">
                          <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                            <a  href="javascript:void(0)" @click.prevent="clickCreate()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                <i data-feather="plus-circle"></i>
                            </a>
                          </el-tooltip>
                    </li>
                </ul>
                </div>
                </div>
              </div>
            </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
          <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Listado de Tags Tienda Virtual</h6>
          </div>
          <div class="card-body">
            <data-table :resource="resource">
              <tr slot="heading" width="100%">
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th class="text-end">Acciones</th>
              </tr>
              <tr></tr>
              <tr slot-scope="{ index, row }">
                <td>{{ index }}</td>
                <td>{{ row.name }}</td>
                <td>{{ row.description }}</td>
                <td class="text-end">
                  <template>
                    <!-- v-if="typeUser === 'admin'" -->
                    <button
                      type="button"
                      class="btn waves-effect waves-light btn-sm btn-info"
                      @click.prevent="clickCreate(row.id)"
                    >Editar</button>
                    <button
                      type="button"
                      class="btn waves-effect waves-light btn-sm btn-danger"
                      @click.prevent="clickDelete(row.id)"
                    >Eliminar</button>
                  </template>
                </td>
              </tr>
            </data-table>
          </div>

          <tags-form :showDialog.sync="showDialog" :recordId="recordId"></tags-form>

        </div>
    </div>
  </div>
</template>
<script>
import TagsForm from "./form.vue";
// import ItemsImport from './import.vue'
import DataTable from "../../components/DataTable.vue";
import { deletable } from "../../mixins/deletable";

export default {
  props: [], //'typeUser'
  mixins: [deletable],
  components: { TagsForm, DataTable  }, //ItemsImport
  data() {
    return {
      showDialog: false,
      showImportDialog: false,
  
      showImageDetail: false,
      resource: "tags",
      recordId: null,
    };
  },
  created() {},
  methods: {

    clickCreate(recordId = null) {
      this.recordId = recordId;
      this.showDialog = true;
    },
    clickImport() {
      this.showImportDialog = true;
    },
    clickDelete(id) {
      this.destroy(`/${this.resource}/${id}`).then(() =>
        this.$eventHub.$emit("reloadData")
      );
    }
  }
};
</script>
