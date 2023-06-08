<template>
    <div class="col-12">
        <div
            class="d-flex
        flex-column
        "
        >
            <div class="btn-group d-flex flex-wrap">
                <button
                    v-for="(num, idx) in [1, 2, 3, 4, 5, 6, 7, 8, 9]"
                    :key="idx"
                    class="col-4 btn btn-outline-secondary p-4"
                    type="button"
                >
                    <h3>
                        {{ num }}
                    </h3>
                </button>
                <button
                    class="col-4 btn btn-outline-secondary p-4"
                    type="button"
                >
                    <h3>.</h3>
                </button>
                <button
                    class="col-4 btn btn-outline-secondary p-4"
                    type="button"
                >
                    <h3>
                        0
                    </h3>
                </button>
                <button
                    class="col-4 btn btn-outline-secondary p-4"
                    type="button"
                >
                    <h3><i class="fas fa-backspace"></i></h3>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            numbers: []
        };
    }
};
</script>
