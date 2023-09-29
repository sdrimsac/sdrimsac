webpackJsonp([106],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/search/index.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  data: function data() {
    return {
      loading_submit: false,
      resource: 'search',
      errors: {},
      form: {},
      record: null,
      document_types: []
    };
  },
  created: function created() {
    var _this = this;

    this.initForm();
    this.$http.get("/".concat(this.resource, "/tables")).then(function (response) {
      _this.document_types = response.data.document_types;
    });
  },
  methods: {
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        id: null,
        document_type_id: '01',
        customer_number: null,
        series: null,
        number: null,
        total: null,
        date_of_issue: moment().format('YYYY-MM-DD')
      };
    },
    submit: function submit() {
      var _this2 = this;

      this.loading_submit = true;
      this.record = null;
      this.errors = {};
      this.$http.post("/".concat(this.resource), this.form).then(function (response) {
        if (response.data.success) {
          _this2.record = response.data.data;
        } else {
          _this2.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this2.errors = error.response.data.errors;
        } else {
          _this2.$toast.error(error.response.data.message);
        }
      }).then(function () {
        _this2.loading_submit = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1dbd66ac\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/search/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "card" }, [
    _vm._m(0),
    _vm._v(" "),
    _c("div", { staticClass: "card-body" }, [
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
              _c("div", { staticClass: "col-md-8" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.document_type_id }
                  },
                  [
                    _vm._m(1),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        model: {
                          value: _vm.form.document_type_id,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "document_type_id", $$v)
                          },
                          expression: "form.document_type_id"
                        }
                      },
                      _vm._l(_vm.document_types, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.description }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.document_type_id
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.document_type_id[0])
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
                    class: { "has-danger": _vm.errors.date_of_issue }
                  },
                  [
                    _vm._m(2),
                    _vm._v(" "),
                    _c("el-date-picker", {
                      attrs: {
                        type: "date",
                        "value-format": "yyyy-MM-dd",
                        clearable: false
                      },
                      model: {
                        value: _vm.form.date_of_issue,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "date_of_issue", $$v)
                        },
                        expression: "form.date_of_issue"
                      }
                    }),
                    _vm._v(" "),
                    _vm.errors.date_of_issue
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.date_of_issue[0])
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
              _c("div", { staticClass: "col-md-6" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.series }
                  },
                  [
                    _vm._m(3),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        attrs: { maxlength: 4 },
                        model: {
                          value: _vm.form.series,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "series", $$v)
                          },
                          expression: "form.series"
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
                    _vm.errors.series
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.series[0])
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
                    class: { "has-danger": _vm.errors.number }
                  },
                  [
                    _vm._m(4),
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
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-6" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.customer_number }
                  },
                  [
                    _vm._m(5),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        attrs: { maxlength: 11 },
                        model: {
                          value: _vm.form.customer_number,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "customer_number", $$v)
                          },
                          expression: "form.customer_number"
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
                    _vm.errors.customer_number
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.customer_number[0])
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
                    class: { "has-danger": _vm.errors.total }
                  },
                  [
                    _vm._m(6),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        model: {
                          value: _vm.form.total,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "total", $$v)
                          },
                          expression: "form.total"
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
                    _vm.errors.total
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: { textContent: _vm._s(_vm.errors.total[0]) }
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
            { staticClass: "form-actions text-end pt-2 mt-2" },
            [
              _c(
                "el-button",
                {
                  attrs: {
                    type: "primary",
                    "native-type": "submit",
                    loading: _vm.loading_submit
                  }
                },
                [_vm._v("Buscar")]
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _vm.record
        ? _c("div", { staticClass: "table-responsive" }, [
            _c("table", { staticClass: "table" }, [
              _vm._m(7),
              _vm._v(" "),
              _c("tbody", [
                _c("tr", [
                  _c("td", [_vm._v(_vm._s(_vm.record.customer))]),
                  _vm._v(" "),
                  _c("td", [_vm._v(_vm._s(_vm.record.number))]),
                  _vm._v(" "),
                  _c("td", { staticClass: "text-end" }, [
                    _vm._v(_vm._s(_vm.record.total))
                  ]),
                  _vm._v(" "),
                  _c("td", { staticClass: "text-end" }, [
                    _c("a", { attrs: { href: _vm.record.download_xml } }, [
                      _vm._v("XML")
                    ]),
                    _vm._v(" "),
                    _c("a", { attrs: { href: _vm.record.download_pdf } }, [
                      _vm._v("PDF")
                    ])
                  ])
                ])
              ])
            ])
          ])
        : _vm._e()
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header bg-primary" }, [
      _c("h6", { staticClass: "my-0 text-white" }, [
        _vm._v("\n            Buscar comprobante electrónico\n        ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "control-label mt-2" }, [
      _vm._v("Tipo Documento"),
      _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "control-label mt-2" }, [
      _vm._v("Fecha de emisión"),
      _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "control-label mt-2" }, [
      _vm._v("Serie"),
      _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "control-label mt-2" }, [
      _vm._v("Número"),
      _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "control-label mt-2" }, [
      _vm._v("Número Cliente (RUC/DNI/CE)"),
      _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "control-label mt-2" }, [
      _vm._v("Monto total"),
      _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("Cliente")]),
        _vm._v(" "),
        _c("th", [_vm._v("Número")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-end" }, [_vm._v("Total")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-end" }, [_vm._v("Descargas")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1dbd66ac", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/search/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/search/index.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1dbd66ac\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/search/index.vue")
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
Component.options.__file = "resources/js/views/search/index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1dbd66ac", Component.options)
  } else {
    hotAPI.reload("data-v-1dbd66ac", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=tenant-search-index.js.map