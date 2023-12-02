<template>
    <div class="d-flex flex-column justify-content-start align-items-center">
        <div id="form" autocomplete="off">
            <div class="form-header">
                <img
                    v-if="company.logo != null"
                    :src="`/storage/uploads/logos/${company.logo}`"
                    alt=""
                />
                <img v-else :src="`/acorn/img/restaurant.png`" alt="" />
                <h2 v-if="company.trade_name != null" class="text-white">
                    {{ company.trade_name }}
                </h2>

                <h2 v-else class="text-white">Tu Negocio Peru</h2>
            </div>
            <div class="form-body" style="padding-bottom: 5px">
                <div class="form-menu">
                    <button type="button" class="form-menu-btn" value="#admin">
                        <i class="fa fa-user"></i>ADMINISTRADOR
                    </button>
                    <button
                        type="button"
                        class="form-menu-btn selected"
                        value="#pin"
                    >
                        <i class="fa fa-key"></i> PIN
                    </button>
                </div>
                <div id="pin" style="display: block">
                    <p>Ingrese clave de acceso</p>
                    <div id="pin-container">
                        <input
                            type="hidden"
                            id="password-pin"
                            name="password-pin"
                        />
                    </div>
                    <table id="table-pin">
                        <tbody></tbody>
                    </table>
                </div>
                <div id="admin" class="form-login" style="display: none">
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
                </div>
            </div>
            <div
                class="d-flex justify-content-center"
                style="padding-bottom: 30px"
            >
                <div id="footer" class="">
                    <img
                        id="logo"
                        src="images/sdrimsac.png"
                        alt="SDRIMSAC Solutions"
                    />
                    <div class="text-white display-5">
                        <i
                            class="fa fa-solid fa-whatsapp"
                            aria-hidden="true"
                        ></i>
                        <i
                            class="fa fa-solid fa-facebook"
                            aria-hidden="true"
                        ></i>
                        <i
                            class="fa fa-solid fa-instagram"
                            aria-hidden="true"
                        ></i>
                        <i class="fa fa-solid fa-globe" aria-hidden="true"></i>
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
                .catch(function(error) {
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
            const response = await this.$http.post(`${this.resource}/login`, {
                pin: pin
            });
            const {
                data: { success }
            } = response;

            if (success) {
                if (pin.length == 6) {
                    window.location.href = "items";

                    //dashboard
                }
                this.$toast.success("Sesión exitosa. Bienvenido/a .");
                if (response.data.kitchen == true) {
                    window.location.href =
                        "caja/worker/dashboard-kitchen";
                } else if (response.data.pos == true) {
                    if (this.config.internet) {
                        window.location.href = "internet/worker/dashboard-pos";
                    } else {
                        window.location.href =
                            "caja/worker/dashboard-pos";
                    }
                } else if (response.data.waiter == true) {
                    window.location.href = "caja/worker/dashboard";
                } else if (response.data.collector == true) {
                    window.location.href = "toll";
               } else if (response.data.cleaner == true || response.data.maintenance == true) {
                    window.location.href = "caja/worker/cleaner";
               }
                
                else {
                    if (this.company.soap_type_id != "03") {
                        window.location.href = "documents";
                    } else {
                        window.location.href = "sale-notes";
                    }
                }
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
        $(document).ready(function() {
            $("#email").focus();
        });

        $(document).on("submit", "#form", function(e) {
            e.preventDefault();
        });

        $(document).on("reset", "#form", function() {
            $("#password-pin").val("");
        });

        $(document).on("click", ".form-menu-btn", function() {
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

        $(document).on("click", ".btn-pin", function() {
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

        $(document).on("change", "#password-pin", function() {
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

        $(document).on("keyup", function(e) {
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
                let pinButton = PinButton({ _text: text });
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
