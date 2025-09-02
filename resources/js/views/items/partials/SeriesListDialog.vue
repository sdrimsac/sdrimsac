<template>
  <el-dialog :visible.sync="visible" title="Series del producto" width="600px" @close="$emit('close')">
    <div v-if="series && series.length">
      <table class="table">
        <thead>
          <tr>
            <th>Serie</th>
            <th>Estado</th>
            <th>Fecha de registro</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="serie in series" :key="serie.id">
            <td>{{ serie.series }}</td>
            <td>{{ serie.state }}</td>
            <td>{{ serie.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>No hay series para este producto.</p>
    </div>
    <span slot="footer" class="dialog-footer">
      <el-button @click="$emit('close')">Cerrar</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
  name: "SeriesListDialog",
  props: {
    visible: Boolean,
    series: {
      type: Array,
      default: () => []
    }
  }
};
</script>
