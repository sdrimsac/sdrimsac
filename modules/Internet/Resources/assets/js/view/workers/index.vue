<template>
    <div>
        
        <div class="container-fluid p-l-0 p-r-0">
            <div class="d-flex flex-wrap justify-content-center">
                <div class="col-md-6 col-12 card m-2 flex-grow-1" style="min-width:350px; max-width: 980px;">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h6 class="my-0 text-white">Listado de Técnicos</h6>
                        <button
                            type="button"
                            class="btn_guardarsmall"
                            @click="newWorker()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row table-responsive">
                            <table
                                class="table table-striped table-hover w-100 shadow-sm rounded"
                                style="background: #fff; border-radius: 8px; overflow: hidden;"
                            >
                                <thead>
                                    <tr style="background: linear-gradient(90deg, #1e5a85 0%, #2980b9 100%); color: #fff;">
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">#</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Apellidos y Nombres</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">DNI</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Nº Celular</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px; text-align: center;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record, idx) in recordsWorkers"
                                        :key="idx"
                                        :style="{ background: idx % 2 === 0 ? '#f8fafc' : '#eaf1f8' }"
                                    >
                                        <td style="vertical-align: middle; font-weight: 500;">{{ idx + 1 }}</td>
                                        <td style="vertical-align: middle;">{{ record.person.name }}</td>
                                        <td style="vertical-align: middle;">{{ record.person.number }}</td>
                                        <td style="vertical-align: middle;">{{ record.person.telephone }}</td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <div class="d-flex justify-content-center gap-2">
                                                <el-tooltip content="Editar" placement="top">
                                                    <el-button
                                                        size="mini"
                                                        type="primary"
                                                        icon="el-icon-edit"
                                                        circle
                                                        @click="editWorkers(record.person_id)"
                                                        style="border-radius: 50%;"
                                                    ></el-button>
                                                </el-tooltip>
                                                <el-tooltip :content="record.active ? 'Desactivar' : 'Activar'" placement="top">
                                                    <el-button
                                                        size="mini"
                                                        :type="record.active ? 'danger' : 'success'"
                                                        :icon="record.active ? 'el-icon-close' : 'el-icon-check'"
                                                        circle
                                                        @click="desactiveWorkers(record.id)"
                                                        style="border-radius: 50%;"
                                                    ></el-button>
                                                </el-tooltip>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="!recordsWorkers.length">
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="el-icon-info"></i> No hay técnicos registrados.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <person-form
            :external="true"
            :showDialog.sync="showDialogNewPerson"
            :recordId="recordId"
            :newTech.sync="newTech"
        ></person-form>
    </div>
</template>

<script>
const PersonForm = () =>
    import("../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: ["pos"],
    components: {
        PersonForm
    },
    data() {
        return {
            newTech: true,
            resource: "/internet/workersadm",
            form: {},
            loading: false,
            recordsWorkers: {},
            showDialogNewPerson: false,
            recordId: null
        };
    },
    async created() {
        // this.getColumns();
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });
        this.getRecords();
    },
    methods: {
        async getRecords() {
            this.loading = true;

            try {
                const response = await axios.get(
                    `${this.resource}/getAllRecords`
                );

                const { status, data } = response;
                this.recordsWorkers = data.data;

                //editar trabajador
                //activar o desactivar registro
            } catch (error) {
                console.log(error);
                this.$toast.error("Disculpe algo malo ha ocurrido ");
            } finally {
                this.loading = false;
            }
        },
        newWorker(recordId = null) {
            this.recordId = recordId;
            this.newTech = true;
            this.showDialogNewPerson = true;
        },
        editWorkers(recordId = null) {
            this.recordId = recordId;

            this.type = "customers";
            //this.type = this.type.
            //this.recordId = id

            this.showDialogNewPerson = true;
        },
        async desactiveWorkers(id) {
            try {
                const response = await axios.post(
                    `${this.resource}/changeStatus`,
                    {
                        id
                    }
                );
                const { status, data } = response;
                if (status == 200) {
                    this.getRecords();
                }
            } catch (error) {
                console.log(error);
            }
        },
        async reloadDataCustomers(customer_id) {
            const existe = this.recordsWorkers.find(
                m => m.person_id == customer_id
            );

            if (existe == undefined) {
                try {
                    const response = await axios.post(
                        `${this.resource}/saveRecord`,
                        {
                            customer_id
                        }
                    );
                    const { status, data } = response;
                    if (status == 200) {
                        this.getRecords();
                    }
                    console.log(response);
                } catch (error) {}
            } else {
                this.getRecords();
            }
        }
    }
};
</script>
