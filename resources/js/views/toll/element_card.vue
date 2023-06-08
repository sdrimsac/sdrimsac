<template>
    <div class=" card d-flex flex-column align-items-center m-2 ">
        <span>{{ item.description }}</span>
        <template v-if="item.image == 'imagen-no-disponible.jpg'">
            <img
                src="/images/imagen-no-disponible.jpg"
                alt="User Img"
                style="width:150px;height:150px;"
            />
        </template>
        <template v-else>
            <img
                :src="formatUrlImage(item.image)"
                style="width:150px;height:150px;"
            />
        </template>
    </div>
</template>

<script>
export default {
    props: ["item"],
    data() {
        return {};
    },
    methods: {
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        }
    }
};
</script>
