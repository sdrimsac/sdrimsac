<!-- Módulo de Bancos -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
                <div
                    class="card-header bg-primary d-flex align-items-center"
                    style="padding: 15px;"
                >
                    <h4
                        class="my-0 text-white d-flex align-items-center"
                        style="font-size: 1.5rem; font-weight: bold;"
                    >
                        <i
                            class="el-icon-download"
                            style="font-size: 2rem; margin-right: 0.5rem;"
                        ></i>
                        Descargas archivos
                    </h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Input para mes -->
                        <div class="col-md-2 mb-3">
                            <el-date-picker
                                v-model="form.month"
                                type="month"
                                format="yyyy-MM"
                                value-format="yyyy-MM"
                                placeholder="Seleccione mes"
                            >
                            </el-date-picker>
                        </div>
                        <div class="col-md-6 mb-3">
                            <el-checkbox-group
                                v-model="form.selectedTypes"
                                class="d-flex gap-4"
                            >
                                <el-checkbox label="pdf">PDF</el-checkbox>
                                <el-checkbox label="xml">XML</el-checkbox>
                                <el-checkbox label="cdr">CDR</el-checkbox>
                                <el-checkbox label="sale_note"
                                    >Notas de Venta</el-checkbox
                                >
                            </el-checkbox-group>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary" @click="search">
                                    Buscar
                                </button>
                                <button
                                    v-if="filesFound"
                                    class="btn btn-success ml-2"
                                    @click="confirmDownload"
                                >
                                    Descargar ZIP
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs section -->
                    <div class="row" v-if="form.selectedTypes.length > 0">
                        <div class="col-md-12">
                            <el-tabs v-model="activeTab">
                                <el-tab-pane
                                    v-if="form.selectedTypes.includes('pdf')"
                                    label="PDF"
                                    name="pdf"
                                >
                                    <div class="table-responsive">
                                        <table
                                            class="table table-hover table-bordered"
                                        >
                                            <thead
                                                class="bg-primary text-white"
                                            >
                                                <tr class="text-white">
                                                    <th>Nombre del archivo</th>
                                                    <th width="100">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                v-if="
                                                    records.pdf &&
                                                        records.pdf.length > 0
                                                "
                                            >
                                                <tr
                                                    v-for="file in records.pdf"
                                                    :key="file"
                                                >
                                                    <td>{{ file }}</td>
                                                    <td class="text-center">
                                                        <button
                                                            class="btn btn-link"
                                                            @click="
                                                                downloadFile(
                                                                    'pdf',
                                                                    file
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-download"
                                                            ></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td
                                                        colspan="2"
                                                        class="text-center"
                                                    >
                                                        No hay archivos
                                                        disponibles
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </el-tab-pane>

                                <el-tab-pane
                                    v-if="form.selectedTypes.includes('xml')"
                                    label="XML"
                                    name="xml"
                                >
                                    <div class="table-responsive">
                                        <table
                                            class="table table-hover table-bordered"
                                        >
                                            <thead
                                                class="bg-primary text-white"
                                            >
                                                <tr>
                                                    <th>Nombre del archivo</th>
                                                    <th width="100">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                v-if="
                                                    records.xml &&
                                                        records.xml.length > 0
                                                "
                                            >
                                                <tr
                                                    v-for="file in records.xml"
                                                    :key="file"
                                                >
                                                    <td>{{ file }}</td>
                                                    <td class="text-center">
                                                        <button
                                                            class="btn btn-link"
                                                            @click="
                                                                downloadFile(
                                                                    'xml',
                                                                    file
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-download"
                                                            ></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td
                                                        colspan="2"
                                                        class="text-center"
                                                    >
                                                        No hay archivos
                                                        disponibles
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </el-tab-pane>

                                <el-tab-pane
                                    v-if="form.selectedTypes.includes('cdr')"
                                    label="CDR"
                                    name="cdr"
                                >
                                    <div class="table-responsive">
                                        <table
                                            class="table table-hover table-bordered"
                                        >
                                            <thead
                                                class="bg-primary text-white"
                                            >
                                                <tr>
                                                    <th>Nombre del archivo</th>
                                                    <th width="100">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                v-if="
                                                    records.cdr &&
                                                        records.cdr.length > 0
                                                "
                                            >
                                                <tr
                                                    v-for="file in records.cdr"
                                                    :key="file"
                                                >
                                                    <td>{{ file }}</td>
                                                    <td class="text-center">
                                                        <button
                                                            class="btn btn-link"
                                                            @click="
                                                                downloadFile(
                                                                    'cdr',
                                                                    file
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-download"
                                                            ></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td
                                                        colspan="2"
                                                        class="text-center"
                                                    >
                                                        No hay archivos
                                                        disponibles
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </el-tab-pane>

                                <el-tab-pane
                                    v-if="
                                        form.selectedTypes.includes('sale_note')
                                    "
                                    label="Notas de Venta"
                                    name="sale_note"
                                >
                                    <div class="table-responsive">
                                        <table
                                            class="table table-hover table-bordered"
                                        >
                                            <thead
                                                class="bg-primary text-white"
                                            >
                                                <tr>
                                                    <th>Nombre del archivo</th>
                                                    <th width="100">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                v-if="
                                                    records.sale_note &&
                                                        records.sale_note
                                                            .length > 0
                                                "
                                            >
                                                <tr
                                                    v-for="file in records.sale_note"
                                                    :key="file"
                                                >
                                                    <td>{{ file }}</td>
                                                    <td class="text-center">
                                                        <button
                                                            class="btn btn-link"
                                                            @click="
                                                                downloadFile(
                                                                    'sale_note',
                                                                    file
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-download"
                                                            ></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td
                                                        colspan="2"
                                                        class="text-center"
                                                    >
                                                        No hay archivos
                                                        disponibles
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </el-tab-pane>
                            </el-tabs>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["typeUser", "companyNumber"],
    components: {},
    data() {
        return {
            loading: false,
            title: "Descargas archivos",
            resource: "download-files",
            recordId: null,
            records: [],
            activeTab: "pdf",
            form: {
                month: null,
                selectedTypes: ["pdf", "xml", "cdr", "sale_note"] // Todos marcados por defecto
            },
            filesFound: false
        };
    },
    created() {
        // Establecer el mes actual como valor por defecto
        const today = new Date();
        const year = today.getFullYear();
        const month = (today.getMonth() + 1).toString().padStart(2, "0");
        this.form.month = `${year}-${month}`;
    },
    watch: {
        "form.selectedTypes": {
            handler(newVal) {
                if (newVal.length > 0 && !newVal.includes(this.activeTab)) {
                    this.activeTab = newVal[0];
                }
            },
            immediate: true
        }
    },
    methods: {
        async search() {
            if (this.form.selectedTypes.length === 0) {
                this.$message({
                    message:
                        "Debe seleccionar al menos un tipo de documento para buscar",
                    type: "warning"
                });
                return;
            }

            try {
                this.loading = true;

                const response = await this.$http.post(
                    `/${this.resource}/search`,
                    {
                        month: this.form.month,
                        types: this.form.selectedTypes
                    }
                );

                if (response.data.success) {
                    this.records = response.data.data;

                    if (
                        Object.values(response.data.data).every(
                            arr => arr.length === 0
                        )
                    ) {
                        this.$message({
                            message:
                                "No se encontraron archivos para el mes seleccionado",
                            type: "info"
                        });
                    }
                }

                this.filesFound = Object.values(response.data.data).some(
                    arr => arr.length > 0
                );
            } catch (error) {
                console.error(error);
                let msg =
                    error.response?.data?.message ||
                    "Ocurrió un error al buscar los archivos";
                this.$message({
                    message: msg,
                    type: "error"
                });
            } finally {
                this.loading = false;
            }
        },
        downloadFile(type, filename) {
            // Implementa la lógica para descargar el archivo aquí
            console.log(`Descargando archivo ${filename} del tipo ${type}`);
        },
        async confirmDownload() {
            const result = await this.$confirm(
                "¿Estás seguro?",
                "Los archivos que se descarguen serán comprimidos en un archivo ZIP. En futuras versiones, estos archivos serán eliminados después de la descarga.",
                "warning"
            );

            if (result) {
                this.downloadZip();
            }
        },

        async downloadZip() {
            try {
                const response = await this.$http.post(
                    "/download-files/download-zip",
                    {
                        month: this.form.month,
                        types: this.form.selectedTypes
                    }
                );
                if (response.data.success) {
                    this.$message({
                        message: response.data.message,
                        type: "success"
                    });
                }

            } catch (error) {
                console.error("Error al descargar:", error);
                this.$swal(
                    "Error",
                    "No se pudo descargar el archivo ZIP",
                    "error"
                );
            }
        }
    }
};
</script>

<style scoped>
.gap-4 {
    gap: 2rem;
}
</style>
