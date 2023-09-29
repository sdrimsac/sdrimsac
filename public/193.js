webpackJsonp([193],{

/***/ "./modules/Restaurant/Resources/assets/js/views/cash/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/cash/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7326d5df\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/cash/form.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/cash/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7326d5df", Component.options)
  } else {
    hotAPI.reload("data-v-7326d5df", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/cash/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);


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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "recordId", "typeUser", "fromBox"],
  data: function data() {
    return {
      loading_submit: false,
      titleDialog: null,
      resource: "caja/worker/cash",
      errors: {},
      form: {},
      user: {},
      all_departments: [],
      all_provinces: [],
      all_districts: [],
      provinces: [],
      districts: [],
      identity_document_types: [],
      users: [],
      turnsTable: [],
      dontClose: false
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
              return _this.$http.get("/".concat(_this.resource, "/tables")).then(function (response) {
                _this.users = response.data.users;
                _this.user = response.data.user;
                _this.turnsTable = response.data.turnsTable;
              });

            case 2:
              _this.initForm();

            case 3:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  computed: {
    disableUser: function disableUser() {
      if (this.typeUser == "admin" || this.typeUser === "superadmin") {
        return false;
      }

      return true;
    }
  },
  methods: {
    ocultarBoton: function ocultarBoton() {
      this.$emit("ocultarBoton");
    },
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        id: null,
        user_id: this.user.id,
        // user: null,
        date_opening: null,
        time_opening: null,
        date_closed: null,
        time_closed: null,
        beginning_balance: 0,
        final_balance: 0,
        income: 0,
        state: true,
        reference_number: null
      };
    },
    create: function create() {
      var _this2 = this;

      this.titleDialog = this.recordId ? "Editar Caja" : "Aperturar Caja";

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this2.form = response.data.data;
        });
      } else {
        this.form.user_id = this.user.id; //sesion
        //this.form.user = this.user.name
      }
    },
    openingCashCkeck: function openingCashCkeck() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, cash;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this3.$http.get("/".concat(_this3.resource, "/opening_cash_check/").concat(_this3.form.user_id));

              case 2:
                response = _context2.sent;
                cash = response.data.cash;
                return _context2.abrupt("return", cash ? true : false);

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    submit: function submit() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this4.loading_submit = true;

                if (!(_this4.form.turn_id == undefined)) {
                  _context3.next = 5;
                  break;
                }

                _this4.$toast.warning("La opcion 'Seleccionar turno de apertura' no puede ser un campo vacio, por favor seleccione una opcion");

                _this4.loading_submit = false;
                return _context3.abrupt("return", false);

              case 5:
                if (_this4.recordId) {
                  _context3.next = 12;
                  break;
                }

                _context3.next = 8;
                return _this4.openingCashCkeck();

              case 8:
                if (!_context3.sent) {
                  _context3.next = 12;
                  break;
                }

                _this4.$toast.warning("No puede crear caja, porfavor cierre caja para el usuario definido");

                _this4.loading_submit = false;
                return _context3.abrupt("return", false);

              case 12:
                _this4.$http.post("/".concat(_this4.resource), _this4.form).then(function (response) {
                  console.log(response);

                  if (response.data.success) {
                    _this4.$toast.success(response.data.message);

                    if (_this4.form.user_id === _this4.user.id) _this4.$eventHub.$emit("openCash");

                    _this4.$eventHub.$emit("reloadData");

                    if (_this4.fromBox) {
                      _this4.$emit("updateCashId", response.data.cash_id);
                    } // window.open('/pos/init')


                    _this4.close();

                    _this4.ocultarBoton();
                  } else {
                    _this4.$toast.error(response.data.message);
                  }
                })["catch"](function (error) {
                  if (error.response.status === 422) {
                    _this4.errors = error.response.data;
                  } else {
                    console.log(error);
                  }
                }).then(function () {
                  _this4.loading_submit = false;
                });

              case 13:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
      this.initForm();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7326d5df\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/cash/form.vue":
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
        "data-keyboard": false,
        closeOnPressEscape: _vm.dontClose,
        closeOnClickModal: _vm.dontClose
      },
      on: { close: _vm.close, open: _vm.create }
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
          _c("div", { staticClass: "form-body" }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-6" }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Cajero ")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        attrs: { disabled: _vm.disableUser },
                        model: {
                          value: _vm.form.user_id,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "user_id", $$v)
                          },
                          expression: "form.user_id"
                        }
                      },
                      _vm._l(_vm.users, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.name }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.user
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: { textContent: _vm._s(_vm.errors.user[0]) }
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
                    class: { "has-danger": _vm.errors.beginning_balance }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v(
                        "Saldo inicial de Apertura\n                        "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        model: {
                          value: _vm.form.beginning_balance,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "beginning_balance", $$v)
                          },
                          expression: "form.beginning_balance"
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
                    _vm.errors.beginning_balance
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.beginning_balance[0])
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
                    class: { "has-danger": _vm.errors.reference_number }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Seleccionar Turno de Apertura")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        model: {
                          value: _vm.form.turn_id,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "turn_id", $$v)
                          },
                          expression: "form.turn_id"
                        }
                      },
                      _vm._l(_vm.turnsTable, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.turn_desc }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.reference_number
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.reference_number[0])
                          }
                        })
                      : _vm._e()
                  ],
                  1
                )
              ])
            ])
          ]),
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
    require("vue-hot-reload-api")      .rerender("data-v-7326d5df", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=193.js.map