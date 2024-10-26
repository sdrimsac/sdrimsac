<template>
  <el-input :value="value" :maxlength="maxLength" @input="handleInput($event)" show-word-limit>
    <template v-if="buttonText">
      <el-button
        slot="append"
        :loading="loading"
        type="primary"
        icon="el-icon-search"
        @click.prevent="clickBuscar"
      ></el-button>
    </template>
    <i slot="prefix" class="el-icon-edit-outline"></i>
  </el-input>
</template>
<script type="text/javascript">
export default {
  props: {
    value: {
      required: true,
      type: String,
      default: ""
    }
  },
  data() {
    return {
      loading: false,
      resource_base: "carro",
      resource: null,
      maxLength: 6,
      buttonText: null
    };
  },
  methods: {
    handleInput(value) {
      this.$emit("input", value);
    },
    clickBuscar() {
      this.loading = true;
      this.$http
        .get(`/${this.resource}/${this.value}`)
        .then(response => {
          let res = response.data;
          console.log(res.message);
          if (res.status === 200) {
            this.$emit("buscar", res.data);
          } else {
            this.$toast.error(res.message);
          }
        })
        .catch(error => {
          console.log(error.response);
        })
        .then(() => {
          this.loading = false;
        });
    }
  }
};
</script>