<template>
    <div>
        Limpieza
    </div>
</template>

<script>
export default {
    props: ["configuration", "establishment"],
    data() {
        return {
            resource: "caja/worker/cleaner"
        };
    },
    mounted() {
        this.getTables();
    },
    methods: {
        async getTables() {
            const response = await this.$http(`/caja/maintenance/records`);
            console.log(
                "🚀 ~ file: index.vue:20 ~ getTables ~ response:",
                response
            );
        }
    }
};
</script>
