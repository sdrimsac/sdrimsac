<template>
    <div class="d-flex flex-column justify-content-start align-items-center">
        <div id="form" autocomplete="off">
            <div class="form-header">
                <img v-if="company.logo != null" :src="`/storage/uploads/logos/${company.logo}`" alt="" />
                <img v-else :src="`/acorn/img/restaurant.png`" alt="" />
                <h2 v-if="company.trade_name != null" class="text-white">
                    {{ company.trade_name }}
                </h2>

                <h2 v-else class="text-white">Tu Negocio Sdrimsac</h2>
            </div>
            <div class="form-body" style="padding-bottom: 5px">
                <div class="form-menu">
                    <!-- <button type="button" class="form-menu-btn" value="#admin">
                        <i class="fa fa-user"></i>   ADMINISTRADOR
                    </button> -->
                    <!-- <button
                        type="button"
                        class="form-menu-btn selected"
                        value="#pin"
                    >
                        <i class="fa fa-key"></i> PIN DE ACCESO
                    </button> -->
                </div>
                <div id="pin" style="display: block">
                    <p>Ingrese PIN de acceso</p>
                    <div id="pin-container">
                        <input type="hidden" id="password-pin" name="password-pin" />
                    </div>
                    <table id="table-pin">
                        <tbody></tbody>
                    </table>
                </div>
                <!-- <div id="admin" class="form-login" style="display: none">
                    <label for="email">
                        <i class="fa fa-envelope"></i>
                        <input
                            v-model="form.email"
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Correo electrónico"
                            required
                        />
                    </label>
                    <label for="password">
                        <i class="fa fa-lock"></i>
                        <input
                            v-model="form.password"
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Contraseña"
                            required
                        />
                    </label>
                    <input
                        type="checkbox"
                        name="remember-me"
                        id="remember-me"
                        checked
                    />
                    <label class="remember-me" for="remember-me">
                        Recuerdame
                    </label>
                    <button id="btn-submit" @click="login">
                        INICIAR SESIÓN
                    </button>
                </div> -->
            </div>
            <div class="d-flex justify-content-center" style="padding-bottom: 30px">
                <div id="footer" class="">
                    <img id="logo" src="images/sdrimsac.png" alt="SDRIMSAC Solutions" />
                    <div class="text-white display-5">
                        <a :href="socialLinks.whatsapp" target="_blank" class="text-white me-3">
                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                        </a>
                        <a :href="socialLinks.facebook" target="_blank" class="text-white me-3">
                            <i class="fab fa-facebook" aria-hidden="true"></i>
                        </a>
                        <a :href="socialLinks.instagram" target="_blank" class="text-white me-3">
                            <i class="fab fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a :href="socialLinks.web" target="_blank" class="text-white">
                            <i class="fas fa-globe" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="" style="height: 50px"></div>
    </div>
</template>

<script>
import $ from "jquery";
import "./js/fontawesome.min.js";
export default {
    props: ["company", "config"],
    data() {
        return {
            resource: "caja",
            maskPin: null,
            form: {}
        };
    },
    computed: {
        socialLinks() {
            const domain = window.location.hostname;
            if (domain.includes('miperufactura')) {
                return {
                    whatsapp: 'https://wa.me/51938777829',
                    facebook: 'https://www.facebook.com/grupovillacorp',
                    instagram: 'https://www.instagram.com/grupovillacorp/',
                    web: 'https://grupovillacorp.com'
                };
            } else if (domain.includes('guepardo')) {
                return {
                    whatsapp: 'https://wa.me/51938777829',
                    facebook: 'https://www.facebook.com/grupovillacorp',
                    instagram: 'https://www.instagram.com/grupovillacorp/',
                    web: 'https://grupovillacorp.com'
                };
            }
            // Por defecto SDRIMSAC
            return {
                whatsapp: 'https://wa.me/51995764963',
                facebook: 'https://www.facebook.com/sdrimsac',
                instagram: 'https://www.instagram.com/sdrimsacsolutions',
                web: 'https://www.sdrimsac.com'
            };
        }
    },
    created() {
        this.initForm();
        this.getOption("delete");
    },
    methods: {
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
        async login() {
            this.$http
                .post("/auth", {
                    email: this.form.email,
                    password: this.form.password
                })
                .then(response => {
                    console.log(response);
                    if (response.data.success) {
                        let user = response.data.user;
                        this.$toast.success(response.data.message);
                        window.location.href = "items";
                        //  this.$router.push({name: 'dashboard'})
                    } else {
                        this.error = response.data.message;
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        initForm() {
            this.form = {
                email: null,
                password: null,
                remember: false
            };
        },

        async enter(pin) {
            if (!localStorage.getItem("browser_token")) {
                localStorage.setItem("browser_token", this.uuidv4());
            }

            const browser_token = localStorage.getItem("browser_token");

            const response = await this.$http.post(`${this.resource}/login`, {
                pin: pin,
                browser_token: browser_token
            });
            console.log(
                "🚀 ~ file: index.vue:174 ~ enter ~ response:",
                response
            );
            const {
                data: { success }
            } = response;

            if (success) {
                if (pin.length == 6) {
                    window.location.href = "items";

                    //dashboard
                }
                let route = "";
                this.$showSAlert("Sesión exitosa. Bienvenido/a.", "success");

                /* this.$toast.success("Sesión exitosa. Bienvenido/a ."); */
                // if (response.data.kitchen == true) {
                //     window.location.href = "caja/worker/dashboard-kitchen";
                // } else if (response.data.pos == true) {
                //     if (this.config.internet) {
                //         window.location.href = "internet/worker/dashboard-pos";
                //     }

                //     else if(this.config.workshop && response.data.mechanic){
                //         window.location.href = "workshop/worker/dashboard-pos";
                //     }
                //     else {
                //         window.location.href = "caja/worker/dashboard-pos";
                //     }
                // } else if (response.data.waiter == true) {
                //     window.location.href = "caja/worker/dashboard";
                // } else if (response.data.collector == true) {
                //     window.location.href = "toll";
                // } else if (response.data.logistic == true) {
                //     window.location.href = "items";
                // } else if (
                //     response.data.cleaner == true ||
                //     response.data.maintenance == true
                // ) {
                //     window.location.href = "caja/worker/cleaner";
                // } else {
                //     if (this.company.soap_type_id != "03") {
                //         window.location.href = "documents";
                //     } else {
                //         window.location.href = "sale-notes";
                //     }
                // }
                if (response.data.kitchen == true) {
                    route = "caja/worker/dashboard-kitchen";
                } else if (response.data.pos == true) {
                    if (this.config.internet) {
                        route = "internet/worker/dashboard-pos";
                    } else if (this.config.workshop && response.data.mechanic) {
                        route = "workshop/worker/dashboard-pos";
                    } else if (this.config.modo_billar) {
                        route = "billar/worker/dashboard-pos";
                    } else if (this.config.mod_renta) {
                        route = "caja/worker/rent-pos";
                    } else if (this.config.mode_salon) {
                        route = "caja/worker/salon-pos";
                    } else if (this.config.tap) {
                        route = "grifo/worker/dashboard-pos";
                    } else if (this.config.meat_shop) {
                        route = "meatshop/worker/dashboard-pos";
                    } else {
                        route = "caja/worker/dashboard-pos";
                    }
                } else if (response.data.waiter == true) {
                    route = "caja/worker/dashboard";
                } else if (response.data.collector == true) {
                    route = "toll";
                } else if (response.data.logistic == true) {
                    route = "items";
                } else if (
                    response.data.cleaner == true ||
                    response.data.maintenance == true
                ) {
                    route = "caja/worker/cleaner";
                } else if (response.data.estilista == true) {
                    route = "caja/estilista/time-worker";
                } else {
                    if (this.company.soap_type_id != "03") {
                        route = "documents";
                    } else {
                        route = "sale-notes";
                    }
                }

                // Realiza la redirección al final
                // console.log("🚀 ~ file: index.vue:174 ~ enter ~ route:", route);
                window.location.href = route;
            } else {
                $("#password-pin").val("");
                let pins = document.querySelectorAll(".pin-radio");
                for (let pin of pins) {
                    pin.checked = false;
                }
                this.$toast.error(response.data.message);
                this.pinHide = "";
                this.maskPin = null;
            }
        },
        uuidv4() {
            return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
                /[xy]/g,
                function (c) {
                    var r = (Math.random() * 16) | 0,
                        v = c == "x" ? r : (r & 0x3) | 0x8;
                    return v.toString(16);
                }
            );
        }
    },
    mounted() {
        var sound = new Audio("sounds/sound.mp3");
        var pines = 6;
        var socials = {
            whatsapp: "#",
            facebook: "#",
            instagram: "#",
            globe: "https://sdrimsac.com"
        };
        $(document).ready(function () {
            $("#email").focus();
        });

        $(document).on("submit", "#form", function (e) {
            e.preventDefault();
        });

        $(document).on("reset", "#form", function () {
            $("#password-pin").val("");
        });

        $(document).on("click", ".form-menu-btn", function () {
            let value = $(this).val();
            $(".form-menu-btn").removeClass("selected");
            $(this).addClass("selected");
            if (value == "#admin") {
                $("#pin").hide(150);
                $("#admin").show(150);
                $("#email").prop("required", true);
                $("#password").prop("required", true);
                $("#email").focus();
            } else {
                $("#pin").show(150);
                $("#admin").hide(150);
                $("#email").prop("required", false);
                $("#password").prop("required", false);
            }
            $("#form").trigger("reset");
        });

        $(document).on("click", ".btn-pin", function () {
            let newValue = $(this)
                .text()
                .trim();
            let prevValue = $("#password-pin").val();
            sound.play();
            $("#password-pin")
                .val(prevValue + newValue)
                .trigger("change");
            if (prevValue.length + 1 >= pines) {
                validate_pin();
                return;
            }
        });

        $(document).on("change", "#password-pin", function () {
            let value = $(this).val();
            let length = value.length;
            $(".pin-radio").prop("checked", false);
            for (let i = 1; i <= length; i++) {
                $(`#pin-${i}`).prop("checked", true);
            }
        });

        const validate_pin = async () => {
            let value = $("#password-pin").val();
            await this.enter(value);
            // alert(value);
            $("#form").trigger("reset");
        };

        $(document).on("keyup", function (e) {
            if (!$("#pin").is(":visible")) {
                return;
            }
            let key = e.key;
            if (
                ![
                    "1",
                    "2",
                    "3",
                    "4",
                    "5",
                    "6",
                    "7",
                    "8",
                    "9",
                    "0",
                    "Enter"
                ].includes(key)
            ) {
                return;
            }
            if (key == "Enter") {
                validate_pin();
            } else {
                $(`.btn-pin[value="${key}"]`).trigger("click");
            }
        });
        const Pin = i => {
            return `
    <input class="pin-radio" type="radio" name="pin-${i}" id="pin-${i}" disabled>
    <label for="pin-${i}"></label>
    `;
        };

        const Tr = () => {
            let tr = document.createElement("tr");
            return $(tr);
        };

        const PinButton = ({ _type = "button", _class = "btn-pin", _text }) => {
            return `
    <td>
        <button type="${_type}" class="${_class}" value="${_text}">
            ${_text}
        </button>
    </td>
    `;
        };

        const Social = (icon, url) => {
            return `    <a href="${url}" target="_blank">        <i class="fa fa-solid fa-${icon}"></i>    </a>    `;
        };
        let pin_container = $("#pin-container");
        for (let i = 1; i <= pines; i++) {
            let pin = Pin(i);
            pin_container.append(pin);
        }
        // END: Drawing the Pines Shower

        // BEGIN: Drawing the Pines Button
        let table = $("#table-pin tbody");
        table.empty();
        let text = 1;
        for (let x = 0; x < 3; x++) {
            let tr = Tr();
            for (let y = 0; y < 3; y++) {
                let pinButton = PinButton({
                    _text: text
                });
                tr.append(pinButton);
                text++;
            }
            table.append(tr);
        }
        let tr = Tr();
        tr.append(
            PinButton({
                _type: "reset",
                _class: "btn-pin-danger",
                _text: "DEL"

            })
        );
        tr.append(
            PinButton({
                _text: "0"
            })
        );
        tr.append(
            PinButton({
                _type: "reset",
                _class: "btn-pin-success",
                _text: "OK"
            })
        );
        table.append(tr);
        // END: Drawing the Pines Button

        // BEGIN: Drawing the Social Network
        let social_container = $("#supported_icons");
        social_container.empty();

        let send_pin = document.querySelector(".btn-pin-success");
        let delete_pin = document.querySelector(".btn-pin-danger");
        delete_pin.onclick = () => {
            //console.log("object");
            $("#password-pin").val("");
            let pins = document.querySelectorAll(".pin-radio");
            for (let pin of pins) {
                pin.checked = false;
            }
        };

        send_pin.onclick = validate_pin;
    }
};
</script>

<style scoped>
.btn-pin {
    background: linear-gradient(180deg, #0a5a9c 0%, #073f68 60%, #052b47 100%) !important;
    color: #fff !important;
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 16px 0 rgba(7, 63, 104, 0.25), 0 2px 0 #052b47;
    font-size: 1.7rem;
    font-weight: bold;
    padding: 16px 0;
    width: 64px;
    height: 64px;
    margin: 10px;
    transition: all 0.12s cubic-bezier(.4, 0, .2, 1);
    outline: none;
    cursor: pointer;
    position: relative;
    user-select: none;
    overflow: hidden;
}

.btn-pin::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 50%;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.05) 100%);
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    pointer-events: none;
}

.btn-pin:active {
    box-shadow: 0 2px 4px 0 rgba(7, 63, 104, 0.18), 0 1px 0 #052b47;
    transform: translateY(3px) scale(0.96);
    background: linear-gradient(180deg, #073f68 0%, #052b47 100%) !important;
}

.btn-pin-danger {
    background: linear-gradient(180deg, #ff6f61 0%, #e74c3c 60%, #a93226 100%) !important;
    color: #fff !important;
    box-shadow: 0 8px 16px 0 rgba(231, 76, 60, 0.18), 0 2px 0 #a93226;
}

.btn-pin-danger:active {
    box-shadow: 0 2px 4px 0 rgba(231, 76, 60, 0.12), 0 1px 0 #a93226;
    background: linear-gradient(180deg, #e74c3c 0%, #a93226 100%) !important;
}

.btn-pin-success {
    background: linear-gradient(180deg, #58d68d 0%, #27ae60 60%, #1e8449 100%) !important;
    color: #fff !important;
    box-shadow: 0 8px 16px 0 rgba(39, 174, 96, 0.18), 0 2px 0 #1e8449;
}

.btn-pin-success:active {
    box-shadow: 0 2px 4px 0 rgba(39, 174, 96, 0.12), 0 1px 0 #1e8449;
    background: linear-gradient(180deg, #27ae60 0%, #1e8449 100%) !important;
}

/* Icono centrado en el botón DEL */
.btn-pin-danger i {
    font-size: 1.3em;
    vertical-align: middle;
}

.btn-pin:active {
    box-shadow: 0 2px 0 #052b47, 0 2px 8px rgba(0, 0, 0, 0.19);
    transform: translateY(2px) scale(0.97);
    background-color: #055082 !important;
}

.btn-pin-danger {
    background-color: #e74c3c !important;
    color: #fff !important;
    box-shadow: 0 4px 0 #a93226, 0 6px 20px rgba(0, 0, 0, 0.19);
}

.btn-pin-danger:active {
    box-shadow: 0 2px 0 #a93226, 0 2px 8px rgba(0, 0, 0, 0.19);
    background-color: #c0392b !important;
}

.btn-pin-success {
    background-color: #27ae60 !important;
    color: #fff !important;
    box-shadow: 0 4px 0 #1e8449, 0 6px 20px rgba(0, 0, 0, 0.19);
}

.btn-pin-success:active {
    box-shadow: 0 2px 0 #1e8449, 0 2px 8px rgba(0, 0, 0, 0.19);
    background-color: #229954 !important;
}

/* Icono centrado en el botón DEL */
.btn-pin-danger i {
    font-size: 1.3em;
    vertical-align: middle;
}
</style>
