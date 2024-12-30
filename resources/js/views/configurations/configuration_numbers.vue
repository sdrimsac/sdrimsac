<template>
    <el-dialog
        :visible.sync="showDialog"
        title="Configuración de números"
        width="90%"
        @open="open"
        @close="close"
    >
        <div v-loading="loading" class="mt-2">
            <!-- Filtro de búsqueda -->
            <div class="col-12 text-end">
                <el-button
                    @click="openAddNumberWhatsapp"
                    icon="fas fa-plus fa-lg"
                    type="primary"
                    >Agregar número</el-button
                >
            </div>
            <div class="col-12">
                <el-input
                    v-model="searchQuery"
                    placeholder="Buscar establecimiento..."
                    prefix-icon="el-icon-search"
                    clearable
                    class="mb-4"
                />
            </div>

            <!-- Tabla de configuración -->
            <el-table :data="tableData" border>
                <!-- Fila de "Seleccionar Todos" -->
                <el-table-column label="Establecimiento" prop="establishment">
                    <template slot="header">
                        Establecimiento
                    </template>
                    <template slot-scope="{ row }">
                        <template v-if="row.isSelectAll">
                            <strong>Seleccionar Todos</strong>
                        </template>
                        <template v-else>
                            {{ row.establishment.description }}
                        </template>
                    </template>
                </el-table-column>

                <el-table-column
                    v-for="number in numbers"
                    :key="number.id"
                
                    :label="
                        `${number.number}  ${
                            number.description ? `- ${number.description}` : ''
                        }`
                    "
                >
                    <template slot-scope="{ row }">
                        <div class="checkbox-container">
                            <input
                                type="checkbox"
                                :checked="
                                    row.isSelectAll
                                        ? selectAllStatus[number.id]
                                        : isSelected(
                                              row.establishment.id,
                                              number.id
                                          )
                                "
                                @change="
                                    event => {
                                        const val = event.target.checked;
                                        if (row.isSelectAll) {
                                            handleSelectAll(number.id, val);
                                        } else {
                                            updateConfiguration(
                                                row.establishment.id,
                                                number.id,
                                                val
                                            );
                                        }
                                    }
                                "
                                class="align-right-checkbox"
                            />
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button
                type="primary"
                @click="saveConfiguration"
                :loading="saving"
            >
                Guardar
            </el-button>
        </div>
        <el-dialog
            append-to-body
            :visible.sync="showAddNumberwhatsapp"
            @close="showAddNumberwhatsapp = false"
            title="Agregar número de whatsapp"
        >
            <div class="row mt-2">
                <div class="col-12">
                    <el-input
                        :maxlength="9"
                        placeholder="Número de whatsapp"
                        v-model="numberWhatsapp"
                    ></el-input>
                </div>
                <div class="col-12 mt-1">
                    <el-input
                        placeholder="Descripción"
                        v-model="descriptionNumberWhatsapp"
                    ></el-input>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button
                    icon="fas fa-times fa-lg"
                    @click="showAddNumberwhatsapp = false"
                    >Cancelar</el-button
                >
                <el-button
                    icon="fas fa-save fa-lg"
                    type="primary"
                    @click="sendNumberWhatsapp"
                    >Agregar</el-button
                >
            </span>
        </el-dialog>
    </el-dialog>
</template>
<style scoped>

.el-table__cell {
    display: flex;
    justify-content: flex-end;
}

</style>
<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            showAddNumberwhatsapp: false,
            numberWhatsapp: null,
            descriptionNumberWhatsapp: null,

            loading: false,
            saving: false,
            numbers: [],
            establishments: [],
            searchQuery: "",
            configurations: new Map(),
            selectAllStatus: {}
        };
    },
    computed: {
        tableData() {
            const selectAllRow = {
                isSelectAll: true,
                establishment: { id: "all", description: "Seleccionar Todos" }
            };

            const filteredEstablishments = this.establishments
                .filter(
                    est =>
                        !this.searchQuery ||
                        est.description
                            .toLowerCase()
                            .includes(this.searchQuery.toLowerCase())
                )
                .map(est => ({
                    isSelectAll: false,
                    establishment: est
                }));

            return [selectAllRow, ...filteredEstablishments];
        }
    },
    methods: {
        openAddNumberWhatsapp() {
            this.showAddNumberwhatsapp = true;
            console.log("abrir modal");
        },
        async sendNumberWhatsapp() {
            try {
                const response = await this.$http.post("/whatsapp/save", {
                    number: this.numberWhatsapp,
                    description: this.descriptionNumberWhatsapp
                });
                if (response.status == 200) {
                    // Usando SweetAlert para mostrar un mensaje de éxito
                    Swal.fire({
                        position: "center", // Centrado en la pantalla
                        icon: "success", // Icono de éxito
                        title: "Éxito",
                        text: "Número de Whatsapp agregado correctamente",
                        showConfirmButton: false,
                        timer: 2000 // Duración de 2 segundos
                    });

                    this.showAddNumberwhatsapp = false;
                    this.numberWhatsapp = null;
                    this.descriptionNumberWhatsapp = null;
                    this.open();
                } else {
                    // Usando SweetAlert para mostrar un mensaje de error
                    Swal.fire({
                        position: "center", // Centrado en la pantalla
                        icon: "error", // Icono de error
                        title: "Error",
                        text: "Ocurrió un error al agregar el número",
                        showConfirmButton: false,
                        timer: 2000 // Duración de 2 segundos
                    });
                }
            } catch (e) {
                let { message } = e.response.data;
                // Usando SweetAlert para mostrar un mensaje de error en caso de excepción
                Swal.fire({
                    position: "center", // Centrado en la pantalla
                    icon: "error", // Icono de error
                    title: "Error",
                    text: message || "Ocurrió un error al agregar el número",
                    showConfirmButton: false,
                    timer: 2000 // Duración de 2 segundos
                });
            }
        },
        async getTable() {
            "cargando datos"; // console.log
            this.loading = true;
            try {
                const response = await this.$http.get(
                    "configurations/tablesNumbersEstablishments"
                );
                this.establishments = response.data.establishments;
                this.numbers = response.data.numbers;
                this.initializeConfigurations(response.data.records);
            } catch (error) {
                ("error al cargar datos"); // console.log
                this.$message.error("Error al cargar los datos");
            } finally {
                this.loading = false;
            }
        },

        initializeConfigurations(records) {
            "inicializando configuraciones"; // console.log
            this.configurations.clear();
            this.selectAllStatus = {};

            // Asegúrate de que los registros contienen los datos correctos
            console.log("Registros recibidos:", records);

            records.forEach(record => {
                // Verifica que estás utilizando las propiedades correctas
                const key = `${record.establishment_id}-${record.number}`;
                this.configurations.set(key, true);
            });

            this.numbers.forEach(number => {
                // Verifica que el estado de "seleccionar todos" se establece correctamente
                this.$set(
                    this.selectAllStatus,
                    number.id,
                    this.establishments.every(est =>
                        this.configurations.has(`${est.id}-${number.id}`)
                    )
                );
            });

            console.log("Configuraciones inicializadas:", this.configurations);
        },

        isSelected(establishmentId, numberId) {
            return this.configurations.has(`${establishmentId}-${numberId}`);
        },

        handleSelectAll(numberId, checked) {
            this.selectAllStatus[numberId] = checked;
            this.$set(this.selectAllStatus, numberId, checked);

            this.establishments.forEach(est => {
                const key = `${est.id}-${numberId}`;
                if (checked) {
                    this.configurations.set(key, true);
                } else {
                    this.configurations.delete(key);
                }
            });

            this.$forceUpdate();
        },

        updateConfiguration(establishmentId, numberId, checked) {
            const key = `${establishmentId}-${numberId}`;
            if (checked) {
                this.configurations.set(key, true);
            } else {
                this.configurations.delete(key);
            }

            // Usar Vue.set para asegurar la reactividad
            this.$set(
                this.selectAllStatus,
                numberId,
                this.establishments.every(est =>
                    this.configurations.has(`${est.id}-${numberId}`)
                )
            );

            // Forzar actualización de la propiedad reactiva
            this.$set(this.configurations, key, checked);
        },

        async saveConfiguration() {
            this.saving = true;
            const payload = [];

            this.configurations.forEach((value, key) => {
                const [establishmentId, numberId] = key.split("-");
                payload.push({
                    establishment_id: parseInt(establishmentId),
                    number_id: parseInt(numberId)
                });
            });

            try {
                await this.$http.post(
                    "configurations/tablesNumbersEstablishments",
                    { payload }
                );
                this.$message.success("Configuración guardada exitosamente");
                this.close();
            } catch (error) {
                this.$message.error("Error al guardar la configuración");
            } finally {
                this.saving = false;
            }
        },

        open() {
            this.getTable();
        },

        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style scoped>
.el-table >>> .select-all-row {
    background-color: #f5f7fa;
}
</style>
