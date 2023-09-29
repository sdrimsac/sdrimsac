webpackJsonp([88],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/bank_accounts/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers_bus__ = __webpack_require__("./resources/js/helpers/bus.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['showDialog', 'recordId'],
  data: function data() {
    return {
      loading_submit: false,
      titleDialog: null,
      resource: 'bank_accounts',
      errors: {},
      form: {},
      banks: [],
      currency_types: []
    };
  },
  created: function created() {
    var _this = this;

    this.initForm();
    this.$http.get("/".concat(this.resource, "/tables")).then(function (response) {
      _this.banks = response.data.banks;
      _this.currency_types = response.data.currency_types;
    }); //            await this.$http.get(`/${this.resource}/record`)
    //                .then(response => {
    //                    if (response.data !== '') {
    //                        this.form = response.data.data
    //                    }
    //                })
  },
  methods: {
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        id: null,
        bank_id: null,
        description: null,
        number: null,
        currency_type_id: null,
        cci: null
      };
    },
    create: function create() {
      var _this2 = this;

      this.titleDialog = this.recordId ? 'Editar Cuenta Bancaria' : 'Nueva Cuenta Bancaria';

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this2.form = response.data.data;
        });
      }
    },
    submit: function submit() {
      var _this3 = this;

      this.loading_submit = true;
      this.$http.post("/".concat(this.resource), this.form).then(function (response) {
        if (response.data.success) {
          _this3.$toast.success(response.data.message);

          _this3.$eventHub.$emit('reloadData');

          _this3.close();
        } else {
          _this3.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this3.errors = error.response.data;
        } else {
          console.log(error);
        }
      }).then(function () {
        _this3.loading_submit = false;
      });
    },
    close: function close() {
      this.$emit('update:showDialog', false);
      this.initForm();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/bank_accounts/index.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__form_vue__ = __webpack_require__("./resources/js/views/bank_accounts/form.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__form_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__form_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_deletable__["a" /* deletable */]],
  props: ["typeUser"],
  components: {
    BankAccountsForm: __WEBPACK_IMPORTED_MODULE_0__form_vue___default.a
  },
  data: function data() {
    return {
      showDialog: false,
      resource: "bank_accounts",
      recordId: null,
      records: []
    };
  },
  created: function created() {
    var _this = this;

    this.$eventHub.$on("reloadData", function () {
      _this.getData();
    });
    this.getData();
  },
  methods: {
    addNewAccount: function addNewAccount() {
      this.showDialog = true;
    },
    getData: function getData() {
      var _this2 = this;

      this.$http.get("/".concat(this.resource, "/records")).then(function (response) {
        _this2.records = response.data.data;
      });
    },
    clickCreate: function clickCreate() {
      var recordId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.recordId = recordId;
      this.showDialog = true;
    },
    clickDelete: function clickDelete(id) {
      var _this3 = this;

      this.destroy("/".concat(this.resource, "/").concat(id)).then(function () {
        return _this3.$eventHub.$emit("reloadData");
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-31a1326e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/bank_accounts/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: { title: _vm.titleDialog, visible: _vm.showDialog },
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
              _c("div", { staticClass: "col-md-4" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.bank_id }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Banco")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        model: {
                          value: _vm.form.bank_id,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "bank_id", $$v)
                          },
                          expression: "form.bank_id"
                        }
                      },
                      _vm._l(_vm.banks, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.description }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.bank_id
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.bank_id[0])
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
                    class: { "has-danger": _vm.errors.description }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Descripción")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        model: {
                          value: _vm.form.description,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "description", $$v)
                          },
                          expression: "form.description"
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
                    _vm.errors.description
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.description[0])
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
              _c("div", { staticClass: "col-md-8" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.number }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Número")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        model: {
                          value: _vm.form.number,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "number", $$v)
                          },
                          expression: "form.number"
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
                    _vm.errors.number
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.number[0])
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
                    class: { "has-danger": _vm.errors.currency_type_id }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Moneda")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        model: {
                          value: _vm.form.currency_type_id,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "currency_type_id", $$v)
                          },
                          expression: "form.currency_type_id"
                        }
                      },
                      _vm._l(_vm.currency_types, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.description }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.currency_type_id
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.currency_type_id[0])
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
                    class: { "has-danger": _vm.errors.balance }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Balance")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        attrs: { type: "number" },
                        model: {
                          value: _vm.form.balance,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "balance", $$v)
                          },
                          expression: "form.balance"
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
                    _vm.errors.balance
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.balance[0])
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
    require("vue-hot-reload-api")      .rerender("data-v-31a1326e", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-655da69d\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/bank_accounts/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "card" },
    [
      _c("div", { staticClass: "row d-flex justify-content-end" }, [
        _c(
          "button",
          {
            staticClass:
              "btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-2",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.addNewAccount.apply(null, arguments)
              }
            }
          },
          [
            _c("span", [
              _vm._v("\n                Agregar nueva cuenta\n            ")
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "card-body" }, [
        _c("div", { staticClass: "table-responsive" }, [
          _c("table", { staticClass: "table" }, [
            _vm._m(1),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.records, function(row, index) {
                return _c("tr", { key: index }, [
                  _c("td", [_vm._v(_vm._s(index + 1))]),
                  _vm._v(" "),
                  _c("td", [_vm._v(_vm._s(row.description))]),
                  _vm._v(" "),
                  _c("td", { staticClass: "text-end" }, [
                    _vm._v(_vm._s(row.number))
                  ]),
                  _vm._v(" "),
                  _c("td", { staticClass: "text-end" }, [
                    _vm._v(_vm._s(row.balance))
                  ]),
                  _vm._v(" "),
                  _c(
                    "td",
                    { staticClass: "text-end" },
                    [
                      _c(
                        "button",
                        {
                          staticClass:
                            "btn waves-effect waves-light btn-sm btn-info",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.clickCreate(row.id)
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                                Editar\n                            "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _vm.typeUser === "admin" || _vm.typeUser === "superadmin"
                        ? [
                            _c(
                              "button",
                              {
                                staticClass:
                                  "btn waves-effect waves-light btn-sm btn-danger",
                                attrs: { type: "button" },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.clickDelete(row.id)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                    Eliminar\n                                "
                                )
                              ]
                            )
                          ]
                        : _vm._e()
                    ],
                    2
                  )
                ])
              }),
              0
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-custom btn-sm  mt-2 mr-2",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.clickCreate()
                  }
                }
              },
              [
                _c("i", { staticClass: "fa fa-plus-circle" }),
                _vm._v(" Nuevo\n                ")
              ]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c("bank-accounts-form", {
        attrs: { showDialog: _vm.showDialog, recordId: _vm.recordId },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialog = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialog = $event
          }
        }
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header bg-primary mt-1" }, [
      _c("h6", { staticClass: "my-0 text-white" }, [
        _vm._v("Listado de cuentas bancarias")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("#")]),
        _vm._v(" "),
        _c("th", [_vm._v("Descripción")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-end" }, [_vm._v("Número")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-end" }, [_vm._v("Balance")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-end" }, [_vm._v("Acciones")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-655da69d", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/bank_accounts/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/bank_accounts/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-31a1326e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/bank_accounts/form.vue")
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
Component.options.__file = "resources/js/views/bank_accounts/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-31a1326e", Component.options)
  } else {
    hotAPI.reload("data-v-31a1326e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/bank_accounts/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/bank_accounts/index.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-655da69d\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/bank_accounts/index.vue")
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
Component.options.__file = "resources/js/views/bank_accounts/index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-655da69d", Component.options)
  } else {
    hotAPI.reload("data-v-655da69d", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=bank_accounts.js.map