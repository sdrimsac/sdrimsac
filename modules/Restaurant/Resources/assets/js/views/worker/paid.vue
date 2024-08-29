<template>
  <el-dialog
    title="Ingrese Pin de Usuario"
    :visible="showDialogPing"
    @close="close"
    @open="onOpenPinModal"
    width="350px"
    class="rounded-top"
  >
  <br>
    <div class="row d-flex justify-content-center mb-3">
      <div class="col-md-12">
        <input
          ref="pinInput"
          v-model="maskPin"
          class="form-control"
          type="text"
          size="2"
          name="listeanzahl"
          value="10"
          style="text-align: center; letter-spacing: 1rem"
          @keydown="handleKeyDown"
        />
      </div>
    </div>
    <div class="col-md-12" v-loading="loading">
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2 text-white"
            style="border-radius: 50% !important"
            @click="getOption(1)"
          >1</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2"
            style="border-radius: 50%  !important ;"
            @click="getOption(2)"
          >2</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2"
            style="border-radius: 50% !important"
            @click="getOption(3)"
          >3</button>
        </div>
      </div>
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2"
            style="border-radius: 50% !important"
            @click="getOption(4)"
          >4</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2"
            style="border-radius: 50% !important"
            @click="getOption(5)"
          >5</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2"
            style="border-radius: 50% !important"
            @click="getOption(6)"
          >6</button>
        </div>
      </div>
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2"
            style="border-radius: 50% !important"
            @click="getOption(7)"
          >7</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2"
            style="border-radius: 50% !important"
            @click="getOption(8)"
          >8</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2"
            style="border-radius: 50% !important"
            @click="getOption(9)"
          >9</button>
        </div>
      </div>
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-danger btn-rounded2"
            style="border-radius: 50% !important"
            @click="getOption('delete')"
          ><i class="el-icon-delete"></i></button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center">
          <button
            class="btn btn-primary btn-rounded2"
            style="border-radius: 50% !important"
            @click="getOption(0)"
          >0</button>
        </div>
        <div class="col-4 col-sm-4 col-md-4" style=" text-align: center ; ">
          <button
            class="btn btn-success btn-rounded2"
            style="border-radius: 50% !important"
            @click="sendOrden"
          ><i class="fas fa-paper-plane"></i></button>
        </div>
      </div>
      <div class="row" style="    margin-bottom: 10px;">
        <div class="col-4 col-sm-4 col-md-4"></div>
        <div class="col-4 col-sm-4 col-md-4"></div>
        <div class="col-4 col-sm-4 col-md-4"></div>
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
.btn-rounded2 {
  width: 70px;
  height: 70px;
  font-size: 30px;
}
.el-dialog {
  border-radius: 10px;
  overflow: hidden;
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
    "referencia"
  ],
  data() {
    return {
      resource: "caja",
      loading: false,
      maskPin: null,
      pinHide: null,
      form_submit: {},
      printerDefault: null
    };
  },
  created() {
    this.getOption("delete");
  },
  methods: {
    onOpenPinModal() {
      this.$nextTick(() => {
        this.focusPinInput();
      });
    },
    focusPinInput() {
      const pinInput = this.$refs.pinInput;
      if (pinInput) {
        pinInput.focus();
      } else {
        /* console.error("El input para el PIN no está disponible."); */
      }
    },
    handleKeyDown(event) {
      const key = event.key;

      if (/^[0-9]$/.test(key) && this.pinHide.length < 4) {
        event.preventDefault();

        this.pinHide += key;
        this.maskPin = "*".repeat(this.pinHide.length);
      } else if (key === "Backspace") {
        this.pinHide = this.pinHide.slice(0, -1);
        this.maskPin = "*".repeat(this.pinHide.length);
      } else if (key === "Enter") {
        this.sendOrden();
        this.clearPin();
      } else {
        event.preventDefault();
      }
    },
    getOption(option) {
      if (option === "delete") {
        this.pinHide = "";
        this.maskPin = null;
        this.focusPinInput();
        return;
      }

      if (this.pinHide.length < 4) {
        this.pinHide += option.toString();
        this.maskPin = "*".repeat(this.pinHide.length);
      }
    },
    open() {
      if (this.maskPin != null) {
        this.clearPin();
      }
    },
    /* getOption(option) {
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
    }, */
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
    }
  }
};
</script>
