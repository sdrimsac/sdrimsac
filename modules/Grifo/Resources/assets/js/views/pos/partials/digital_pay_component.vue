<template>
    <div class="">
      <div class="text-white h4">PAGO DIGITAL</div>
      <div class="text-white h5">{{ message }}</div>
    </div>
  </template>

  <script>
  export default {
    name: 'DigitalPayComponent',
    props: {
      message: {
        type: String,
        required: true
      }
    }
  }
  </script>
