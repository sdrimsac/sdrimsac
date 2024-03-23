<template>
    <el-dialog
        @open="open"
        @close="close"
        :visible="showDialog"
        width="60%"
        append-to-body
        title="Documentos farmacia"
    >
        <div class="row mt-2">
            <!-- un boton para subir un archivo de tipo zip -->
            <div class="col-md-12 text-center m-2">
                <el-upload
                    :headers="headers"
                    class="upload-demo"
                    action="/store_zip"
                    :onSuccess="handleSuccess"
                    :onError="handleError"
                    :auto-upload="true"
                    :on-exceed="handleExceed"
                    :limit="1"
                    :on-change="handleChange"
                    :before-upload="beforeUpload"
                >
                    <el-button size="small" type="primary"
                        >Seleccionar archivo zip</el-button
                    >
                </el-upload>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <el-select
                    v-model="form.column"
                    placeholder="Seleccione un estado"
                    clearable
                >
                    <el-option
                        v-for="item in columns"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <template v-if="form.column == 'status'">
                    <el-select
                        v-model="form.value"
                        placeholder="Seleccione un estado"
                        clearable
                    >
                        <el-option
                            v-for="item in statuses"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        ></el-option>
                    </el-select>
                </template>
                <template
                    v-else-if="
                        form.column == 'date_of_charge' ||
                            form.column == 'date_of_issue'
                    "
                >
                    <el-date-picker
                        v-model="form.value"
                        type="date"
                        placeholder="Seleccione una fecha"
                        value-format="yyyy-MM-dd"
                        format="yyyy-MM-dd"
                        clearable
                    ></el-date-picker>
                </template>
                <template v-else>
                    <el-input v-model="form.value" clearable></el-input>
                </template>
            </div>
            <div class="col-md-4">
                <el-button
                    type="primary"
                    icon="el-icon-search"
                    @click="getRecords"
                ></el-button>
            </div>
        </div>
        <div class="row">
            <el-pagination
                @current-change="getRecords"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="Number(pagination.per_page)"
            ></el-pagination>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Identificador</th>
                            <th>Archivo</th>
                            <th>Fecha subida</th>
                            <th>Fecha emisión</th>
                            <th>Estado</th>
                            <th width="30%">Error</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(record, idx) in records" :key="record.id">
                            <td>{{ customIndex(idx) }}</td>
                            <td>{{ record.identifier }}</td>
                            <td>{{ record.file_name }}</td>
                            <td>{{ record.date_of_charge }}</td>
                            <td>{{ record.date_of_issue }}</td>
                            <td>{{ record.status }}</td>
                            <td class="text-danger">{{ record.error }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </el-dialog>
</template>

<script>
import queryString from "query-string";
export default {
    props: ["showDialog"],
    data() {
        return {
            statuses: [
                { label: "Repetido", value: "Repetido" },
                { label: "Aceptado", value: "Aceptado" },
                { label: "Fallido", value: "Fallido" }
            ],
            columns: [
                { label: "Identificador", value: "identifier" },
                { label: "Archivo", value: "file_name" },
                { label: "Fecha subida", value: "date_of_charge" },
                { label: "Fecha emisión", value: "date_of_issue" },
                { label: "Estado", value: "status" },
                { label: "Error", value: "error" }
            ],
            headers: headers_token,
            records: [],
            form: {},
            pagination: {
                current_page: 1,
                per_page: 10,
                total: 0
            }
        };
    },
    methods: {
        customIndex(index) {
            return (
                (this.pagination.current_page - 1) * this.pagination.per_page +
                index +
                1
            );
        },
        async getRecords() {
            const response = await this.$http(
                `/documents-salud/records?${this.getQueryParameters()}`
            );
            const { data, meta } = response.data;
            this.pagination = meta;
            this.records = data;
        },
        open() {
            this.getRecords();
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.form
            });
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        handleSuccess(response, file, fileList) {
            if (response.success) {
                this.$message.success(response.message);
            } else {
                this.$message.error(response.message);
            }
            this.close();
        },
        handleError(err, file, fileList) {
            console.log("🚀 ~ file, fileList", file, fileList);
            this.$message.error("Error al subir el archivo");
        },
        handleExceed(files, fileList) {
            this.$message.warning(
                `Limite de archivos excedido, solo se puede subir un archivo`
            );
        },
        handleChange(file, fileList) {
            console.log(file, fileList);
        },
        beforeUpload(file) {
            console.log("🚀 ~ beforeUpload ~ file:", file);
            const isZip =
                file.type === "application/zip" ||
                file.type == "application/x-zip-compressed";
            if (!isZip) {
                this.$message.error("Solo se permiten archivos de tipo zip");
            }
            return isZip;
        }
    }
};
</script>
