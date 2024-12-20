<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        width="80%"
        :title="`Archivos pendientes de descarga  e eliminación`"
    >
    <div class="row mt-2">
        <div class="col-12">
            <table class="table" v-loading="loading">
                <thead> 
                    <tr>
                        <th>Archivo</th>
                        <th>Archivos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="file in files" :key="file.id">
                        <td>{{ file.file_zip }}</td>
                        <td>{{ file.items_count }}</td>
                        <td>
                            <button class="btn btn-primary"
                                @click="downloadZip(file)"
                            >
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn btn-danger"
                                @click="deleteZip(file.id)"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            files: [],
            loading: false
        };
    },
    methods: {
         deleteZip(id){
            this.$confirm('¿Estás seguro de eliminar el archivo, y los archivos que contiene? estos ya no se podrán descargar', 'Eliminar archivo', {
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                type: 'warning'
            }).then(() => {
                this.$http.delete(`/download-files/delete-zip-file/${id}`).then(response => {
                    this.getZipFiles();
                });
            });
        },
        downloadZip(row){
            this.$http.get(`/download-files/download-zip-file/${row.id}`, {
                responseType: 'blob'
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data], {
                    type: 'application/zip'
                }));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', row.file_zip);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
            }).catch(error => {
                this.$message.error('Error al descargar el archivo');
            });
        },
        getZipFiles(){
            this.loading = true;
            this.$http.get('/download-files/get-zip-files').then(response => {
                this.files = response.data;
            }).catch(error => {
                this.$message.error('Error al obtener los archivos');
            }).finally(() => {
                this.loading = false;
            });
        },
        open() {
            this.getZipFiles();
        },
        close() {
            this.$emit('update:showDialog', false);
        }
    }
};
</script>

<style></style>
