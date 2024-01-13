<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        width="50%"
        append-to-body
        @close="close"
        @open="open"
        v-loading="loading"
    >
        <div class="row m-2">
            <div class="col-12">
                <label class="label-control w-100">
                    Apoderado actual
                </label>
                <el-input v-model="parentName"></el-input>
            </div>
            <div class="col-12">
                <label class="label-control w-100">
                    Buscar nuevo apoderado
                </label>
                <el-input
                    placeholder="Nombre/documento"
                    v-model="search.value"
                    @input="getRecordsTimer"
                >
                    <i slot="prefix" class="el-input__icon el-icon-search"></i>
                </el-input>
            </div>
        </div>
        <div class="row m-2 responsive-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Apoderado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, idx) in records" :key="idx">
                        <td>
                            {{ record.parent.name }}
                            <br />
                            <small>{{ record.parent.number }}</small>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <el-button
                                    @click="register(record)"
                                    type="success"
                                >
                                    Cambiar
                                </el-button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "student"],
    data() {
        return {
            loading: false,
            resource: "college/persons",
            title: "Cambiar de salón",
            search: {
                column: "description"
            },
            pagination: {},
            records: [],
            parentName: "",
            timer: null
        };
    },
    methods: {
        getRecordsTimer() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.getRecords();
            }, 500);
        },
        async register(parent) {
            try {
                this.loading = true;
                let { id } = parent;
                let {
                    member: {id:member_id, parent_id }
                } = this.student;
                if (id == parent_id) {
                    this.$toast.error("No puedes cambiar al mismo apoderado");
                    return;
                }
           
                const response = await this.$http.post(
                    "/college/persons/change",
                    {
                        parent_id_new: id,
                        parent_id_old: parent_id,
                        member_id : member_id
                    }
                );
                if (response.status == 200) {
                    this.$toast.success(
                        "Se ha cambiado de apoderado correctamente"
                    );
                    this.$emit("getRecordsClose");
                    this.close();
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ha ocurrido un error");
            } finally {
                this.loading = false;
            }
        },
        query() {
            let q = "?";

            Object.keys(this.search).forEach(s => {
                q += `${s}=${this.search[s]}&`;
            });

            return q;
        },
        open() {
            let {
                name,
                member: {
                    parent: {
                        person: { name: parentName }
                    }
                }
            } = this.student;
            this.parentName = parentName;
            this.title = `Cambiar de apoderado a ${name}`;
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/records${this.query()}`
                );
                const { data, meta } = response.data;
                this.pagination = meta;
                this.records = data;
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
