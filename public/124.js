webpackJsonp([124],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/persons/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_functions__ = __webpack_require__("./resources/js/mixins/functions.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_functions__["c" /* serviceNumber */]],
  props: ["worker", "showDialog", "type", "recordId", "external", "document_type_id", "input_person", "user_id", "newTech"],
  data: function data() {
    return {
      zones: [],
      social_medias: [],
      loading_submit: false,
      titleDialog: null,
      resource: this.worker ? "caja/worker/persons" : "persons",
      errors: {},
      api_service_token: false,
      form: {},
      countries: [],
      all_departments: [],
      all_provinces: [],
      all_districts: [],
      provinces: [],
      districts: [],
      locations: [],
      person_types: [],
      identity_document_types: [],
      all_users: []
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              console.log(_this.newTech, " a");
              _context.next = 3;
              return _this.initForm();

            case 3:
              _context.next = 5;
              return _this.$http.get("/".concat(_this.resource, "/tables")).then(function (response) {
                _this.api_service_token = response.data.api_service_token;
                _this.social_medias = response.data.social_media;
                _this.all_users = response.data.users;
                _this.countries = response.data.countries;
                _this.all_departments = response.data.departments;
                _this.all_provinces = response.data.provinces;
                _this.zones = response.data.zones;
                _this.all_districts = response.data.districts;
                _this.identity_document_types = response.data.identity_document_types;
                _this.locations = response.data.locations;
                _this.person_types = response.data.person_types;
              });

            case 5:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  computed: {
    maxLength: function maxLength() {
      if (this.form.identity_document_type_id === "6") {
        return 11;
      }

      if (this.form.identity_document_type_id === "1") {
        return 8;
      }
    }
  },
  methods: {
    nuevoMetodo: function nuevoMetodo() {
      var admin = this.all_users.find(function (user) {
        return user.type == "admin";
      });

      if (admin) {
        this.form.seller_id = admin.id;
      } else {
        if (this.all_users.length != 0) {
          this.form.seller_id = this.all_users[0].id;
        }
      }
    },
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        id: null,
        type: this.type,
        identity_document_type_id: "6",
        number: "",
        name: null,
        trade_name: null,
        country_id: "PE",
        department_id: null,
        province_id: null,
        district_id: null,
        address: null,
        telephone: null,
        condition: null,
        state: null,
        email: null,
        perception_agent: false,
        percentage_perception: 0,
        person_type_id: null,
        comment: null,
        addresses: [],
        seller_id: null
      };
    },
    opened: function opened() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!(_this2.external && _this2.input_person)) {
                  _context2.next = 8;
                  break;
                }

                if (!(_this2.form.number.length === 8 || _this2.form.number.length === 11)) {
                  _context2.next = 8;
                  break;
                }

                if (!(_this2.api_service_token != false)) {
                  _context2.next = 7;
                  break;
                }

                _context2.next = 5;
                return _this2.$eventHub.$emit("enableClickSearch");

              case 5:
                _context2.next = 8;
                break;

              case 7:
                _this2.searchCustomer();

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    create: function create() {
      var _this3 = this;

      if (this.external) {
        if (this.document_type_id === "01") {
          this.form.identity_document_type_id = "6";
        }

        if (this.document_type_id === "03") {
          this.form.identity_document_type_id = "1";
        }

        if (this.input_person) {
          this.form.identity_document_type_id = this.input_person.identity_document_type_id ? this.input_person.identity_document_type_id : this.form.identity_document_type_id;
          this.form.number = this.input_person.number ? this.input_person.number : "";
        }
      }

      if (this.type == undefined) {
        this.titleDialog = this.newTech ? "Nuevo Técnico" : "Nuevo Cliente";
      }

      if (this.type === "customers") {
        this.titleDialog = this.recordId ? "Editar Cliente" : "Nuevo Cliente";
      }

      if (this.type === "suppliers") {
        this.titleDialog = this.recordId ? "Editar Proveedor" : "Nuevo Proveedor";
      }

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this3.form = response.data.data;

          _this3.filterProvinces();

          _this3.filterDistricts();
        });
      }
    },
    clickAddAddress: function clickAddAddress() {
      /* this.form.more_address.push({
              location_id: [],
              address: null,
          })*/
      this.form.addresses.push({
        id: null,
        country_id: "PE",
        location_id: [],
        address: null,
        email: null,
        phone: null,
        main: false
      });
    },
    submit: function submit() {
      var _this4 = this;

      this.nuevoMetodo();

      if (!this.form.seller_id) {
        this.$toast.error("Debe seleccionar un asesor");
        return;
      }

      if (this.form.identity_document_type_id == "6" && this.form.number.length != 11) {
        this.$toast.error("La longitud del RUC debe ser de 11");
        return;
      }

      if (this.form.identity_document_type_id == "1" && this.form.number.length != 8) {
        this.$toast.error("La longitud del DNI debe ser de 8");
        return;
      }

      this.loading_submit = true;
      this.$http.post("/".concat(this.resource), this.form).then(function (response) {
        if (response.data.success) {
          _this4.$toast.success(response.data.message);

          _this4.$emit("add_customer", response.data.id);

          if (_this4.external) {
            _this4.$eventHub.$emit("reloadDataPersons", response.data.id);
          } else {
            _this4.$eventHub.$emit("reloadData");
          }

          _this4.close();
        } else {
          _this4.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          console.log(error.response.data.errors);
          _this4.errors = error.response.data.errors;
        } else {
          console.log(error);
        }
      }).then(function () {
        _this4.loading_submit = false;
      });
    },
    changeIdentityDocType: function changeIdentityDocType() {
      this.recordId == null ? this.setDataDefaultCustomer() : null;
    },
    setDataDefaultCustomer: function setDataDefaultCustomer() {
      if (this.form.identity_document_type_id == "0") {
        this.form.number = "99999999";
        this.form.name = "Clientes - Varios";
      } else {
        this.form.number = "";
        this.form.name = null;
      }
    },
    close: function close() {
      this.$eventHub.$emit("initInputPerson");
      this.$emit("update:showDialog", false);
      this.initForm();
    },
    searchCustomer: function searchCustomer() {
      this.searchServiceNumberByType();
    },
    searchNumber: function searchNumber(data) {
      this.form.district_id = data.ubigeo[2];
      this.filterDistricts();
      this.form.name = this.form.identity_document_type_id === "1" ? data.nombre_completo : data.nombre_o_razon_social;
      this.form.trade_name = this.form.identity_document_type_id === "6" ? data.nombre_o_razon_social : "";
      this.form.location_id = data.ubigeo;
      this.form.department_id = data.ubigeo ? data.ubigeo[0] : null;
      this.form.province_id = data.ubigeo ? data.ubigeo[1] : null;
      this.form.district_id = data.ubigeo ? data.ubigeo[2] : null;
      this.filterProvinces();
      this.filterDistricts();
      this.form.address = data.direccion;
      this.form.condition = data.condicion;
      this.form.state = data.estado;
    },
    clickRemoveAddress: function clickRemoveAddress(index) {
      this.form.addresses.splice(index, 1);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7cc91674\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        title: _vm.titleDialog,
        visible: _vm.showDialog,
        "append-to-body": "",
        "close-on-click-modal": false
      },
      on: { close: _vm.close, open: _vm.create, opened: _vm.opened }
    },
    [
      _c(
        "form",
        {
          attrs: { autocomplete: "off" },
          on: {
            submit: function($event) {
              $event.preventDefault()
              return _vm.submit.apply(null, arguments)
            }
          }
        },
        [
          _c(
            "div",
            { staticClass: "form-body" },
            [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: {
                        "has-danger": _vm.errors.identity_document_type_id
                      }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v(
                          "Tipo Doc. Identidad\n                            "
                        ),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v("*")
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            "popper-class": "el-select-identity_document_type",
                            dusk: "identity_document_type_id"
                          },
                          on: { change: _vm.changeIdentityDocType },
                          model: {
                            value: _vm.form.identity_document_type_id,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.form,
                                "identity_document_type_id",
                                $$v
                              )
                            },
                            expression: "form.identity_document_type_id"
                          }
                        },
                        _vm._l(_vm.identity_document_types, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.identity_document_type_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(
                                _vm.errors.identity_document_type_id[0]
                              )
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.number }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Número\n                            "),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v("*")
                        ])
                      ]),
                      _vm._v(" "),
                      _vm.api_service_token != false
                        ? _c(
                            "div",
                            [
                              _c("x-input-service", {
                                attrs: {
                                  identity_document_type_id:
                                    _vm.form.identity_document_type_id
                                },
                                on: { search: _vm.searchNumber },
                                model: {
                                  value: _vm.form.number,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "number", $$v)
                                  },
                                  expression: "form.number"
                                }
                              })
                            ],
                            1
                          )
                        : _c(
                            "div",
                            [
                              _c(
                                "el-input",
                                {
                                  attrs: {
                                    maxlength: _vm.maxLength,
                                    dusk: "number"
                                  },
                                  model: {
                                    value: _vm.form.number,
                                    callback: function($$v) {
                                      _vm.$set(_vm.form, "number", $$v)
                                    },
                                    expression: "form.number"
                                  }
                                },
                                [
                                  _vm.form.identity_document_type_id === "6" ||
                                  _vm.form.identity_document_type_id === "1"
                                    ? [
                                        _c("el-button", {
                                          attrs: {
                                            slot: "append",
                                            type: "primary",
                                            loading: _vm.loading_search,
                                            icon: "el-icon-search"
                                          },
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              return _vm.searchCustomer.apply(
                                                null,
                                                arguments
                                              )
                                            }
                                          },
                                          slot: "append"
                                        })
                                      ]
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _c("i", {
                                    staticClass: "el-icon-edit-outline",
                                    attrs: { slot: "prefix" },
                                    slot: "prefix"
                                  })
                                ],
                                2
                              )
                            ],
                            1
                          ),
                      _vm._v(" "),
                      _vm.errors.number
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.number[0])
                            }
                          })
                        : _vm._e()
                    ]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.name }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Nombre\n                            "),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v("*")
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "name" },
                          model: {
                            value: _vm.form.name,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "name", $$v)
                            },
                            expression: "form.name"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.name
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.name[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-12" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.trade_name }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Nombre comercial")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "trade_name" },
                          model: {
                            value: _vm.form.trade_name,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "trade_name", $$v)
                            },
                            expression: "form.trade_name"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.trade_name
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.trade_name[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-3" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.country_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("País")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: { filterable: "", dusk: "country_id" },
                          model: {
                            value: _vm.form.country_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "country_id", $$v)
                            },
                            expression: "form.country_id"
                          }
                        },
                        _vm._l(_vm.countries, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.country_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.country_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-3" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.department_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Departamento")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            "popper-class": "el-select-departments",
                            dusk: "department_id"
                          },
                          on: { change: _vm.filterProvince },
                          model: {
                            value: _vm.form.department_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "department_id", $$v)
                            },
                            expression: "form.department_id"
                          }
                        },
                        _vm._l(_vm.all_departments, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.department_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.department_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-3" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.province_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Provincia")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            "popper-class": "el-select-provinces",
                            dusk: "province_id"
                          },
                          on: { change: _vm.filterDistrict },
                          model: {
                            value: _vm.form.province_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "province_id", $$v)
                            },
                            expression: "form.province_id"
                          }
                        },
                        _vm._l(_vm.provinces, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.province_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.province_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-3" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.province_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Distrito")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            "popper-class": "el-select-districts",
                            dusk: "district_id"
                          },
                          model: {
                            value: _vm.form.district_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "district_id", $$v)
                            },
                            expression: "form.district_id"
                          }
                        },
                        _vm._l(_vm.districts, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.district_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.district_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-12" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.address }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Dirección")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "address" },
                          model: {
                            value: _vm.form.address,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "address", $$v)
                            },
                            expression: "form.address"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.address
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.address[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.client_zone_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Zona")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: { filterable: "", dusk: "client_zone_id" },
                          model: {
                            value: _vm.form.client_zone_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "client_zone_id", $$v)
                            },
                            expression: "form.client_zone_id"
                          }
                        },
                        _vm._l(_vm.zones, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.client_zone_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.client_zone_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.telephone }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Teléfono")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "telephone" },
                          model: {
                            value: _vm.form.telephone,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "telephone", $$v)
                            },
                            expression: "form.telephone"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.telephone
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.telephone[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.email }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Correo electrónico")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "email" },
                          model: {
                            value: _vm.form.email,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "email", $$v)
                            },
                            expression: "form.email"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.email
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.email[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _vm.form.state
                  ? _c("div", { staticClass: "col-md-6" }, [
                      _c(
                        "div",
                        { staticClass: "form-group" },
                        [
                          _c("label", { staticClass: "control-label" }, [
                            _vm._v("Estado del Contribuyente")
                          ]),
                          _vm._v(" "),
                          _vm.form.state == "ACTIVO"
                            ? [
                                _c("el-alert", {
                                  attrs: {
                                    title: "" + _vm.form.state,
                                    type: "success",
                                    "show-icon": "",
                                    closable: false
                                  }
                                })
                              ]
                            : [
                                _c("el-alert", {
                                  attrs: {
                                    title: "" + _vm.form.state,
                                    type: "error",
                                    "show-icon": "",
                                    closable: false
                                  }
                                })
                              ]
                        ],
                        2
                      )
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.form.condition
                  ? _c("div", { staticClass: "col-md-6" }, [
                      _c(
                        "div",
                        { staticClass: "form-group" },
                        [
                          _c("label", { staticClass: "control-label" }, [
                            _vm._v("Condición del Contribuyente")
                          ]),
                          _vm._v(" "),
                          _vm.form.condition == "HABIDO"
                            ? [
                                _c("el-alert", {
                                  attrs: {
                                    title: "" + _vm.form.condition,
                                    type: "success",
                                    "show-icon": "",
                                    closable: false
                                  }
                                })
                              ]
                            : [
                                _c("el-alert", {
                                  attrs: {
                                    title: "" + _vm.form.condition,
                                    type: "error",
                                    "show-icon": "",
                                    closable: false
                                  }
                                })
                              ]
                        ],
                        2
                      )
                    ])
                  : _vm._e()
              ]),
              _vm._v(" "),
              _vm.type === "suppliers"
                ? _c("div", { staticClass: "row mt-2" }, [
                    _c("div", { staticClass: "col-md-6 center-el-checkbox" }, [
                      _c(
                        "div",
                        {
                          staticClass: "form-group",
                          class: { "has-danger": _vm.errors.perception_agent }
                        },
                        [
                          _c(
                            "el-checkbox",
                            {
                              model: {
                                value: _vm.form.perception_agent,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "perception_agent", $$v)
                                },
                                expression: "form.perception_agent"
                              }
                            },
                            [_vm._v("¿Es agente de percepción?")]
                          ),
                          _c("br"),
                          _vm._v(" "),
                          _vm.errors.perception_agent
                            ? _c("small", {
                                staticClass: "text-danger",
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.errors.perception_agent[0]
                                  )
                                }
                              })
                            : _vm._e()
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _vm.type === "suppliers"
                      ? _c(
                          "div",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.form.perception_agent,
                                expression: "form.perception_agent"
                              }
                            ],
                            staticClass: "col-md-6"
                          },
                          [
                            _c(
                              "div",
                              { staticClass: "form-group" },
                              [
                                _c("label", { staticClass: "control-label" }, [
                                  _vm._v("Porcentaje de percepción")
                                ]),
                                _vm._v(" "),
                                _c(
                                  "el-input",
                                  {
                                    model: {
                                      value: _vm.form.percentage_perception,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.form,
                                          "percentage_perception",
                                          $$v
                                        )
                                      },
                                      expression: "form.percentage_perception"
                                    }
                                  },
                                  [
                                    _c("i", {
                                      staticClass: "el-icon-edit-outline",
                                      attrs: { slot: "prefix" },
                                      slot: "prefix"
                                    })
                                  ]
                                )
                              ],
                              1
                            )
                          ]
                        )
                      : _vm._e()
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm._l(_vm.form.addresses, function(row, index) {
                return _c("div", { key: index, staticClass: "row m-t-10" }, [
                  _c("div", { staticClass: "col-md-12" }, [
                    index === 0
                      ? _c("label", { staticClass: "control-label" }, [
                          _vm._v(
                            "\n                        Dirección principal\n                    "
                          )
                        ])
                      : _c(
                          "label",
                          { staticClass: "control-label" },
                          [
                            _vm._v(
                              "\n                        Dirección secundaria # " +
                                _vm._s(index) +
                                "\n                        "
                            ),
                            _c(
                              "el-button",
                              {
                                staticClass: "btn-default-danger",
                                attrs: { size: "mini", icon: "el-icon-minus" },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.clickRemoveAddress(index)
                                  }
                                }
                              },
                              [_vm._v("Eliminar dirección")]
                            )
                          ],
                          1
                        )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-4" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.country_id }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("País")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            attrs: { filterable: "" },
                            model: {
                              value: row.country_id,
                              callback: function($$v) {
                                _vm.$set(row, "country_id", $$v)
                              },
                              expression: "row.country_id"
                            }
                          },
                          _vm._l(_vm.countries, function(option) {
                            return _c("el-option", {
                              key: option.id,
                              attrs: {
                                value: option.id,
                                label: option.description
                              }
                            })
                          }),
                          1
                        ),
                        _vm._v(" "),
                        _vm.errors.country_id
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.country_id[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.location_id }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Ubigeo")
                        ]),
                        _vm._v(" "),
                        _c("el-cascader", {
                          attrs: {
                            options: _vm.locations,
                            clearable: true,
                            filterable: ""
                          },
                          model: {
                            value: row.location_id,
                            callback: function($$v) {
                              _vm.$set(row, "location_id", $$v)
                            },
                            expression: "row.location_id"
                          }
                        }),
                        _vm._v(" "),
                        _vm.errors.location_id
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.location_id[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-12" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.address }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Dirección")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-input",
                          {
                            model: {
                              value: row.address,
                              callback: function($$v) {
                                _vm.$set(row, "address", $$v)
                              },
                              expression: "row.address"
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "el-icon-edit-outline",
                              attrs: { slot: "prefix" },
                              slot: "prefix"
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _vm.errors.address
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.address[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-6" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.phone }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Teléfono")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-input",
                          {
                            model: {
                              value: row.phone,
                              callback: function($$v) {
                                _vm.$set(row, "phone", $$v)
                              },
                              expression: "row.phone"
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "el-icon-edit-outline",
                              attrs: { slot: "prefix" },
                              slot: "prefix"
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _vm.errors.phone
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.phone[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-6" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.email }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Correo electrónico")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-input",
                          {
                            model: {
                              value: row.email,
                              callback: function($$v) {
                                _vm.$set(row, "email", $$v)
                              },
                              expression: "row.email"
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "el-icon-edit-outline",
                              attrs: { slot: "prefix" },
                              slot: "prefix"
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _vm.errors.email
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.email[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ])
                ])
              })
            ],
            2
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "form-actions text-end pt-2 pb-2" },
            [
              _c(
                "el-button",
                {
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.close()
                    }
                  }
                },
                [_vm._v("Cancelar")]
              ),
              _vm._v(" "),
              _c(
                "el-button",
                {
                  attrs: {
                    type: "primary",
                    "native-type": "submit",
                    loading: _vm.loading_submit
                  }
                },
                [_vm._v("Guardar")]
              )
            ],
            1
          )
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7cc91674", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/persons/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7cc91674\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/persons/form.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/views/persons/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7cc91674", Component.options)
  } else {
    hotAPI.reload("data-v-7cc91674", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=124.js.map