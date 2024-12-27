<template>
    <el-dialog
        :visible.sync="showDialog"
        title="Configuración de números"
        width="90%"
        @open="open"
        @close="close"
    >
        <div v-loading="loading">
            <!-- Filtro de búsqueda -->
            <el-input
                v-model="searchQuery"
                placeholder="Buscar establecimiento..."
                prefix-icon="el-icon-search"
                clearable
                class="mb-4"
            />

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
                
                <el-table-column v-for="number in numbers" :key="number.id" :label="`${number.number}`">
                    <template slot-scope="{ row }">
                        <el-checkbox 
                            :value="row.isSelectAll ? selectAllStatus[number.id] : isSelected(row.establishment.id, number.id)"
                            @change="(val) => row.isSelectAll 
                                ? handleSelectAll(number.id, val) 
                                : updateConfiguration(row.establishment.id, number.id, val)"
                        />
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="saveConfiguration" :loading="saving">
                Guardar
            </el-button>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            loading: false,
            saving: false,
            numbers: [],
            establishments: [],
            searchQuery: '',
            configurations: new Map(),
            selectAllStatus: {},
        }
    },
    computed: {
        tableData() {
            const selectAllRow = {
                isSelectAll: true,
                establishment: { id: 'all', description: 'Seleccionar Todos' }
            }

            const filteredEstablishments = this.establishments
                .filter(est => 
                    !this.searchQuery || 
                    est.description.toLowerCase().includes(this.searchQuery.toLowerCase())
                )
                .map(est => ({
                    isSelectAll: false,
                    establishment: est
                }))

            return [selectAllRow, ...filteredEstablishments]
        }
    },
    methods: {
        async getTable() {
            "cargando datos" // console.log
            this.loading = true
            try {
                const response = await this.$http.get("configurations/tablesNumbersEstablishments")
                this.establishments = response.data.establishments
                this.numbers = response.data.numbers
                this.initializeConfigurations(response.data.records)
            } catch (error) {
                "error al cargar datos" // console.log
                this.$message.error('Error al cargar los datos')
            } finally {
                this.loading = false
            }
        },

        initializeConfigurations(records) {
            "inicializando configuraciones" // console.log
            this.configurations.clear()
            this.selectAllStatus = {}
            
            // Asegúrate de que los registros contienen los datos correctos
            console.log("Registros recibidos:", records)

            records.forEach(record => {
                // Verifica que estás utilizando las propiedades correctas
                const key = `${record.establishment_id}-${record.number}`
                this.configurations.set(key, true)
            })

            this.numbers.forEach(number => {
                // Verifica que el estado de "seleccionar todos" se establece correctamente
                this.$set(
                    this.selectAllStatus,
                    number.id,
                    this.establishments.every(est => 
                        this.configurations.has(`${est.id}-${number.id}`)
                    )
                )
            })

            console.log("Configuraciones inicializadas:", this.configurations)
        },

        isSelected(establishmentId, numberId) {
            return this.configurations.has(`${establishmentId}-${numberId}`)
        },

        handleSelectAll(numberId, checked) {
            "handleSelectAll" // console.log
            this.selectAllStatus[numberId] = checked
            this.$set(this.selectAllStatus, numberId, checked)

            this.establishments.forEach(est => {
                const key = `${est.id}-${numberId}`
                if (checked) {
                    this.configurations.set(key, true)
                } else {
                    this.configurations.delete(key)
                }
            })

            this.$forceUpdate()
        },

        updateConfiguration(establishmentId, numberId, checked) {
            const key = `${establishmentId}-${numberId}`
            if (checked) {
                this.configurations.set(key, true)
            } else {
                this.configurations.delete(key)
            }

            this.$set(
                this.selectAllStatus, 
                numberId, 
                this.establishments.every(est => this.configurations.has(`${est.id}-${numberId}`))
            )
        },

        async saveConfiguration() {
            this.saving = true
            const payload = []
            
            this.configurations.forEach((value, key) => {
                const [establishmentId, numberId] = key.split('-')
                payload.push({
                    establishment_id: parseInt(establishmentId),
                    number_id: parseInt(numberId)
                })
            })

            try {
                await this.$http.post("configurations/tablesNumbersEstablishments", { payload })
                this.$message.success('Configuración guardada exitosamente')
                this.close()
            } catch (error) {
                this.$message.error('Error al guardar la configuración')
            } finally {
                this.saving = false
            }
        },

        open() {
            this.getTable()
        },

        close() {
            this.$emit("update:showDialog", false)
        },
    }
}
</script>

<style scoped>
.el-table >>> .select-all-row {
    background-color: #f5f7fa;
}
</style>