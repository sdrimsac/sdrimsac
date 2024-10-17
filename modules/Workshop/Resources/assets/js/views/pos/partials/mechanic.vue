<template>
  <el-dialog
    :title="title"
    :visible="showDialog"
    :close-on-click-modal="false"
    @close="close"
    @open="open"
    width="80%"
    append-to-body
  >
    <form autocomplete="off" action>
      <br />
      <div class="">
        <div class="">
          <div class="row">
            <div class="col-md-4">
              <label>cliente</label>
              <el-input></el-input>
            </div>
            <div class="col-md-4">
              <label>cliente</label>
              <el-input></el-input>
            </div>
            <div class="col-md-4 text-end">
              <el-button
              type="primary"
              @click="clickRegisterHistory"
              >
                Nuevo Registro
              </el-button>
            </div>
          </div>
        </div>
      </div>
      <br />
      <div class="card-body">
        <div class="">
          <table class="table-responsive col-md-12">
            <thead>
              <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
              </tr>
            </thead>
            <tbody>
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
            </tbody>
          </table>
        </div>
      </div>
      <register-history :showDialog.sync="showDialogRegisterHistory"></register-history>
    </form>
  </el-dialog>
</template>
<script>
import registerHistory from './register_history.vue'
export default {
  props: ["showDialog"],
  components: {
    registerHistory
  },
  data() {
    return {
      title: "Registro Ingreso Vehiculo",
      showDialogRegisterHistory: false,
    };
  },
  methods: {
    clickRegisterHistory() {
      this.showDialogRegisterHistory = true;
    },
    open() {
      
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>