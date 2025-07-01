<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        class="dialog-import rounded-dialog"
        :close-on-click-modal="false" 
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <label class="form-control-label" for="warehouse_id"
                            >Almacén</label
                        >
                        <el-select
                            v-model="form.warehouse_id"
                            placeholder="Seleccione un almacén"
                            :disabled="loading_submit"
                            :class="{ 'is-invalid': errors.warehouse_id }"
                        >
                            <el-option
                                v-for="warehouse in warehouses"
                                :key="warehouse.id"
                                :label="warehouse.description"
                                :value="warehouse.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div
                            class="form-group text-center"
                            :class="{ 'has-danger': errors.file }"
                        >
                            <el-upload
                                ref="upload"
                                :headers="headers"
                                action="/item-color-size/import"
                                :show-file-list="true"
                                :auto-upload="false"
                                :multiple="false"
                                :on-error="errorUpload"
                                :limit="1"
                                :data="form"
                                :on-success="successUpload"
                                :on-change="handleExcelFile"
                            >
                                <el-button slot="trigger" type="primary"
                                    >Seleccione un archivo (xlsx)</el-button
                                >
                            </el-upload>
                            <small
                                class="form-control-feedback"
                                v-if="errors.file"
                                v-text="errors.file[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="/formats/item_color_size.xlsx" target="_new"
                            >Descargar formato</a
                        >
                    </div>
                </div>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button icon="fas fa-times fa-lg" @click.prevent=close()> Cancelar</el-button>
                <el-button icon="fas fa-random fa-lg" type="primary"native-type="submit" :loading="loading_submit">
                     Procesar
                </el-button>
            </div>
            <br>
        </form>
    </el-dialog>
</template>

<style>
.el-dialog {
border-radius: 10px;
overflow: hidden;
}
</style>

<script>
import readXlsxFile from "read-excel-file";
export default {
    props: ["showDialog"],
    data() {
        return {
            loading_submit: false,
            headers: headers_token,
            titleDialog: "Importar Productos con Talla y Color",
            resource: "item-color-size",
            errors: {},
            form: {
                warehouse_id: null,
                excelData: null // Agregamos propiedad para los datos del Excel
            },
            warehouses: []
        };
    },
    methods: {
        initForm() {
            this.errors = {};
            this.form = {
                warehouse_id: null
            };
            this.getWarehouses();
        },
        create() {
            this.titleDialog = "Importar Productos con Talla y Color";
            this.initForm();
        },
        getWarehouses() {
            return this.$http.get(`/warehouses/records`)
                .then(response => {
                    this.warehouses = response.data.data || [];
                });
        },
        close() {
            this.$emit('update:showDialog', false);
            this.initForm();
        },
        async submit() {
            if (!this.form.warehouse_id) {
                this.$toast.warning(
                    "Seleccione un almacén para poder continuar"
                );
                return;
            }
            if (!this.form.excelData) {
                this.$toast.warning(
                    "Por favor seleccione un archivo Excel válido"
                );
                return;
            }
            
            // Emitir los datos al componente padre
            this.$emit('excel-data', {
                warehouse_id: this.form.warehouse_id,
                data: this.form.excelData
                
            });
            console.log("Datos a enviar:", this.form.excelData);
            
            // Cerrar el diálogo
            this.close();
        },
        successUpload(response) {
            this.loading_submit = false;
            if (response.success) {
                this.$message.success(response.message);
                this.close();
            } else {
                this.$message.error(response.message);
            }
        },
        errorUpload(error) {
            this.loading_submit = false;
            if (error.response.data.message) {
                this.$message.error(error.response.data.message);
            } else {
                this.$message.error('Ocurrió un error al procesar el archivo');
            }
        },
        /* handleExcelFile(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                
                // Asumimos que queremos leer la primera hoja del Excel
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                
                // Convertir a JSON
                const jsonData = XLSX.utils.sheet_to_json(worksheet);
                
                // Guardar los datos en el formulario
                this.form.excelData = jsonData;
                
                // Mostrar mensaje de éxito
                this.$message.success(`Archivo Excel procesado correctamente. Se encontraron ${jsonData.length} registros.`);
            };
            reader.readAsArrayBuffer(file.raw);
        } */
        handleExcelFile(file) {
            readXlsxFile(file.raw).then(rows => {
                rows.shift();
                const groupedData = {};
                
                // Primero agrupamos por internal_id
                rows.forEach(row => {
                    const internal_id = row[0];
                    const colorSizeItem = {
                        color: row[1],
                        size: row[2],
                        stock: row[3],
                        price: row[4],
                        code: row[5]
                    };

                    if (groupedData[internal_id]) {
                        // Si ya existe el internal_id, agregamos al array de color_size
                        groupedData[internal_id].color_size.push(colorSizeItem);
                    } else {
                        // Si no existe, creamos nuevo objeto con el primer color_size
                        groupedData[internal_id] = {
                            internal_id: internal_id,
                            color_size: [colorSizeItem]
                        };
                    }
                });

                // Convertimos el objeto agrupado a array
                const colorSizeArr = Object.values(groupedData);
                // Validar códigos duplicados
                const codes = colorSizeArr.flatMap(item => item.color_size.map(cs => cs.code));
                const duplicates = codes.filter(
                    (code, idx) => codes.indexOf(code) !== idx
                );
                if (duplicates.length > 0) {
                    this.$showSAlert(
                        "Alerta",
                        `El código "${duplicates[0]}" ya existe en el archivo Excel.`,
                        "error"
                    );
                    this.$refs.upload.clearFiles();
                    return;
                }
                this.color_size = colorSizeArr;
                this.form.excelData = colorSizeArr;
                this.form.quantity = this.color_size.reduce(
                    (total, item) => total + item.color_size.reduce(
                        (subtotal, cs) => subtotal + Number(cs.stock), 
                        0
                    ),
                    0
                );
                this.colorSizeImported = true;
                this.$refs.upload.clearFiles();
            });
        },
    },
    created() {
        this.initForm();
    },
    /* methods: {
        getWarehouses() {
            this.$http.get("/items/import/tables").then(response => {
                this.warehouses = response.data.warehouses;
            });
        },
        initForm() {
            this.errors = {};
            this.form = {
                file: null
            };
        },
        create() {
            this.titleDialog = "Importar Colores y Tallas";
            this.getWarehouses();
        },
        async submit() {
            if (!this.form.warehouse_id) {
                this.$toast.warning(
                    "Seleccione un almacén para poder continuar"
                );
                return;
            }
            this.loading_submit = true;
            await this.$refs.upload.submit();
            this.loading_submit = false;
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        },
        successUpload(response, file, fileList) {
            if (response.success) {
                this.$toast.success(response.message);
                this.$eventHub.$emit("reloadData");
                this.$refs.upload.clearFiles();
                this.close();
            } else {
                this.$toast.error(response.message);
            }
        },
        errorUpload(response) {
            console.log(response);
        }
    } */
};
</script>
