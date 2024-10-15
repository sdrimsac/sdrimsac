<template>
    <el-dialog
        :visible="showDialogPing"
        @close="close"
        width="20%"
        @open="open"
    >
        <div
            class="d-flex flex-column justify-content-center align-items-center"
        >
            <span>Ingrese su pin</span>

            <input type="hidden" id="password-pin" name="password-pin" />

            <div class="d-flex justify-content-around w-50 ">
                <div v-for="(value, idx) in password" :key="idx">
                    <input
                        class="pin-radio"
                        type="radio"
                        :name="`pin-${idx}`"
                        :id="`pin-${idx}`"
                        disabled
                    />
                    <label :for="`pin-${idx}`"></label>
                </div>
            </div>
            <table class="table table-borderless">
                <tbody>
                    <tr v-for="(nums, idx) in numbers" :key="idx">
                        <td
                            class="text-center"
                            v-for="(num, indx) in nums"
                            :key="indx"
                        >
                            <button
                                @click="addPin(num)"
                                class="btn-pin"
                                type="button"
                            >
                                {{ num }}
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <button
                                class="btn-pin btn-pin-danger"
                                type="button"
                            >
                                DEL
                            </button>
                        </td>
                        <td class="text-center">
                            <button class="btn-pin" type="button">
                                0
                            </button>
                        </td>
                        <td class="text-center">
                            <button
                                class="btn-pin btn-pin-success"
                                type="button"
                            >
                                OK
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<style scoped>
.btn-pin,
.btn-pin-danger,
.btn-pin-success {
    display: inline-block;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #0071bb;
    color: #fff;
    font-size: larger;
    font-weight: bold;
    border: 1px solid #0071bb;
    cursor: pointer;
}
.btn-pin-danger {
    background-color: #ff6161;
    border-color: #ff6161;
}
.btn-pin-success {
    background-color: #33cc33;
    border-color: #33cc33;
}
.pin-radio:checked + label {
    background-color: #0071bb;
}
.pin-radio {
    display: none;
}
</style>
<script>
export default {
    props: [
        "showDialogPing",
        "ordenSelectedId",
        "tableId",
        "localOrden",
        "configuration",
        "to_carry",
        "referencia"
    ],
    data() {
        return {
            password: [false, false, false, false],
            numbers: [
                ["1", "2", "3"],
                ["4", "5", "6"],
                ["7", "8", "9"]
            ],
            resource: "caja",
            loading: false,
            maskPin: null,
            pinHide: "",
            form_submit: {},
            printerDefault: null
        };
    },
    created() {
        this.getOption("delete");
    },
    methods: {
        addPin(num) {
            if (this.password.some(v => !v)) {
                let idx = this.password.findIndex(v => !v);
                console.log(idx);
                this.password[idx] = true;
                let radio = document.getElementById(`pin-${idx}`);
                let label = document.querySelector(`[for="pin-${idx}"]`);
                radio.checked = true;
                label.style.background = "red";

                this.pinHide += `${num}`;
            }
        },
        open() {
            this.clearPin();
        },
        getOption(option) {
            if (option == "delete") {
                this.pinHide = "";
                this.maskPin = null;
                return;
            }
            if (this.pinHide && this.pinHide.length == 4) {
                return;
            }
            this.pinHide += option.toString();
            this.maskPin = "*".repeat(this.pinHide.length);
        },
        close() {
            this.$emit("update:showDialogPing", false);
        },

        clearPin() {
            if (this.maskPin != null) {
                if (this.maskPin.length > 0) {
                    this.pinHide = "";
                    this.maskPin = null;
                }
            }
        },
        async sendOrden() {
            this.$emit("sendOrden", this.pinHide);
        }
    }
};
</script>
