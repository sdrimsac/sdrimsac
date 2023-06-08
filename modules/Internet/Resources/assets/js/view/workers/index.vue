<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Listado de Trabajadores</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Internet</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Trabajadores </span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="d-flex flex-wrap justify-content-center">
                <div class="col-md-7 col-12 card m-2">
                    <div class="card-header bg-primary">
                        <h6 class="my-0 text-white">Listado de Trabajadores</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class=" btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                                    @click="newWorker()"
                                >
                                    <i class="icofont-plus-circle"></i>
                                    <span>Nuevo</span>
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive" v-loading="loading">
                            <table
                                class="table  table-striped table-hover"
                                style="width: 100%; white-space: nowrap"
                            >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre Apellido</th>

                                        <th>Dni</th>
                                        <th>Celular</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record, idx) in recordsWorkers"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>{{ record.person.name }}</td>
                                        <td>{{ record.person.number }}</td>
                                        <td>{{ record.person.telephone }}</td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-end"
                                            >
                                                <el-button
                                                    size="mini"
                                                    type="primary"
                                                    @click="
                                                        editWorkers(
                                                            record.person_id
                                                        )
                                                    "
                                                    >Editar</el-button
                                                >
                                                <el-button
                                                    @click="
                                                        desactiveWorkers(
                                                            record.id
                                                        )
                                                    "
                                                    size="mini"
                                                    :type="
                                                        record.active
                                                            ? 'danger'
                                                            : 'success'
                                                    "
                                                    >{{
                                                        record.active
                                                            ? "Desactivar"
                                                            : "Activar"
                                                    }}</el-button
                                                >
                                            </div>
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
