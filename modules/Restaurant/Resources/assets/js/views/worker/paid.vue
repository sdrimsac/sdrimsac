<template>
  <el-dialog
    title="Ingrese Pin de Usuario"
    :visible="showDialogPing"
    @close="close"
    @open="open"
    width="350px"
    class="rounded-top"
  >
    <div class="row d-flex justify-content-center mb-3">
      <div class="col-md-12">
        <input
          v-model="maskPin"
          class="form-control"
          type="text"
          size="2"
          name="listeanzahl"
          value="10"
          style="text-align: center; letter-spacing: 1rem"
        />
      </div>
    </div>
    <div class="col-md-12" v-loading="loading">
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center"> 
          <button            class="btn btn-primary  btn-rounded2 text-white"            style="border-radius: 50% !important"            @click="getOption(1)"
          >
            1
          </button>
        </div>
        <div class="col-4 col-sm-4 col-md-4  " style=" text-align: center">
          <button class="btn btn-primary btn-rounded2" style="border-radius: 50%  !important ;" @click="getOption(2)">2</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button class="btn btn-primary btn-rounded2" style="border-radius: 50% !important" @click="getOption(3)">3</button>
        </div>
      </div>
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button class="btn btn-primary btn-rounded2" style="border-radius: 50% !important" @click="getOption(4)">4</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button class="btn btn-primary btn-rounded2" style="border-radius: 50% !important" @click="getOption(5)">5</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button class="btn btn-primary btn-rounded2" style="border-radius: 50% !important" @click="getOption(6)">6</button>
        </div>
      </div>
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button class="btn btn-primary btn-rounded2" style="border-radius: 50% !important" @click="getOption(7)">7</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button class="btn btn-primary btn-rounded2" style="border-radius: 50% !important" @click="getOption(8)">8</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button class="btn btn-primary btn-rounded2" style="border-radius: 50% !important" @click="getOption(9)">9</button>
        </div>
      </div>
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
            <button class="btn btn-danger w-100" style="margin-top: 16px;" @click="getOption('delete')">
            Borrar
          </button></div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button class="btn btn-primary btn-rounded2" style="border-radius: 50% !important" @click="getOption(0)">0</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center ; ">
            <button class="btn btn-success w-100 " style="margin-top: 16px;" @click="sendOrden">
            Ingresar
          </button>
        </div>
      </div>
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4" >
          
        </div>
        <div class="col-4 col-sm-4 col-md-4"></div>
        <div class="col-4 col-sm-4 col-md-4">
          
        </div>
      </div>
    </div>
  </el-dialog>
</template>
<style>
.pin-container label {
  display: inline-block;
  border: 2px solid #00000022;
  width: 15px;
  height: 15px;
  margin: 0 10px;
  border-radius: 50%;
}
.btn-rounded2{
    width: 70px;
    height: 70px;
    font-size: 30px;
}
</style>
<script>
import printjs from "print-js";
export default {
  props: [
    "showDialogPing",
    "ordenSelectedId",
    "tableId",
    "localOrden",
    "configuration",
    "to_carry",
    "referencia",
  ],
  data() {
    return {
      resource: "caja",
      loading: false,
      maskPin: null,
      pinHide: null,
      form_submit: {},
      printerDefault: null,
    };
  },
  created() {
    this.getOption("delete");
  },
  methods: {
    open() {
      if (this.maskPin != null) {
        this.clearPin();
      }
    },
    getOption(option) {
      if (option == "delete") {
        this.pinHide = "";
        this.maskPin = null;
        return;
      }
      if (this.pinHide && this.pinHide.length == 4) {
        return;
      }
      this.pinHide += option.toString();
      this.maskPin = "*".repeat(this.pinHide.length);
    },
    close() {
      this.$emit("update:showDialogPing", false);
    },

    clearPin() {
      if (this.maskPin.length > 0) {
        this.pinHide = "";
        this.maskPin = null;
      }
    },
    async sendOrden() {
      this.$emit("sendOrden", this.pinHide);
    },
    //     async enter() {
    //         //this.form_submit=this.form_pe
    //         /*
    //     id:null,
    //         caja:true,
    //         printing:this.configuration.print_commands,
    //         commands_fisico:this.commands_fisico,
    //         orden:{
    //             table_id:1,
    //             status_orden_id: 1,
    //         },
    //         items:this.localOrden,
    //         pin:null
    //   */
    //         let form_submit = {
    //             id: this.ordenSelectedId,
    //             caja: false,
    //             to_carry: this.to_carry,
    //             printing: this.configuration.print_commands,
    //             commands_fisico: null,
    //             ref: this.referencia,
    //             orden: {
    //                 table_id: this.tableId,
    //                 status_orden_id: 1
    //             },
    //             items: this.localOrden,
    //             pin: this.pinHide
    //         };
    //         this.loading = true;
    //         const response = await this.$http.post("send-orden", form_submit);
    //         if (response.status == 200) {
    //             const { success, message } = response.data;
    //             if (success) {
    //                 const { ordenId } = response.data;

    //                 this.$toast.success(message);
    //                 this.$emit("add", ordenId);
    //                 this.close();
    //                 this.loading = false;
    //             } else {
    //                 this.$toast.error(message);
    //                 this.loading = false;
    //             }
    //         }
    //         this.clearPin();
    //         this.loading = false;
    //     }
  },
};
</script>
