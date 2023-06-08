<template>
    <el-dialog
        @open="open"
        @close="close"
        :visible="showDialog"
        v-loading="loading"
        title="Lista de hijo"
    >
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Grado-Sección</th>
                    <th>Nivel</th>
                    <th>Turno</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(student, idx) in children" :key="idx">
                    <td>{{ idx + 1 }}</td>
                    <td>
                        {{ student.name }}
                        <br />
                        <small>{{ student.number }}</small>
                    </td>
                    <template v-if="student.degree">
                        <td>
                            {{ student.degree.description }}-
                            {{ student.section.description }}
                        </td>
                        <td>
                            {{ student.level.description }}
                        </td>
                        <td>
                            {{ student.turn.description }}
                        </td>
                    </template>
                    <template v-else>
                        <td colspan="3" class="text-center">No matriculado</td>
                    </template>
                </tr>
            </tbody>
        </table>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "parentId"],
    data() {
        return {
            loading: false,
            children: []
        };
        {
        }
    },
    methods: {
        async open() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `persons/children/${this.parentId}`
                );
                console.log(response);
                this.children = response.data;
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
            console.log(this.parentId);
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
