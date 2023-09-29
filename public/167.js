webpackJsonp([167],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/persons/client_zones.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_query_string__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog"],
  data: function data() {
    return {
      form: {},
      loading: false,
      zones: [],
      resource: "client_zones",
      search: {
        column: null,
        value: null
      },
      pagination: {
        current_page: 1,
        per_page: 20,
        total: 0
      },
      showCreateForm: false
    };
  },
  methods: {
    clickActive: function clickActive(zone) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _this.loading = true;
                _context.next = 4;
                return _this.$http("/".concat(_this.resource, "/active/").concat(zone.id));

              case 4:
                response = _context.sent;

                _this.$message.success(response.data.message);

                _this.showCreateForm = false;
                _context.next = 9;
                return _this.getRecords();

              case 9:
                _context.next = 14;
                break;

              case 11:
                _context.prev = 11;
                _context.t0 = _context["catch"](0);
                console.log(_context.t0);

              case 14:
                _context.prev = 14;
                _this.loading = false;
                return _context.finish(14);

              case 17:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 11, 14, 17]]);
      }))();
    },
    clickEdit: function clickEdit(zone) {
      this.form = zone;
      this.showCreateForm = true;
    },
    clickDelete: function clickDelete(zone) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var confirm, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _context2.next = 3;
                return _this2.$confirm("¿Está seguro de eliminar este registro?", "Confirmación", {
                  confirmButtonText: "Aceptar",
                  cancelButtonText: "Cancelar",
                  type: "warning"
                });

              case 3:
                confirm = _context2.sent;

                if (!(confirm == "confirm")) {
                  _context2.next = 13;
                  break;
                }

                _this2.loading = true;
                _context2.next = 8;
                return _this2.$http["delete"]("/".concat(_this2.resource, "/delete/").concat(zone.id));

              case 8:
                response = _context2.sent;

                _this2.$message.success(response.data.message);

                _this2.showCreateForm = false;
                _context2.next = 13;
                return _this2.getRecords();

              case 13:
                _context2.next = 18;
                break;

              case 15:
                _context2.prev = 15;
                _context2.t0 = _context2["catch"](0);
                console.log(_context2.t0);

              case 18:
                _context2.prev = 18;
                _this2.loading = false;
                return _context2.finish(18);

              case 21:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[0, 15, 18, 21]]);
      }))();
    },
    submit: function submit() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.prev = 0;
                _this3.loading = true;
                _context3.next = 4;
                return _this3.$http.post("/".concat(_this3.resource), _this3.form);

              case 4:
                response = _context3.sent;

                _this3.$message.success(response.data.message);

                _this3.showCreateForm = false;
                _context3.next = 9;
                return _this3.getRecords();

              case 9:
                _context3.next = 14;
                break;

              case 11:
                _context3.prev = 11;
                _context3.t0 = _context3["catch"](0);
                console.log(_context3.t0);

              case 14:
                _context3.prev = 14;
                _this3.loading = false;
                return _context3.finish(14);

              case 17:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[0, 11, 14, 17]]);
      }))();
    },
    clickCreate: function clickCreate() {
      this.form = {};
      this.showCreateForm = true;
    },
    getQueryParameters: function getQueryParameters() {
      return __WEBPACK_IMPORTED_MODULE_1_query_string___default.a.stringify(_objectSpread({
        page: this.pagination.current_page
      }, this.search));
    },
    getRecords: function getRecords() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.prev = 0;
                _this4.loading = true;
                _context4.next = 4;
                return _this4.$http("/".concat(_this4.resource, "/records?").concat(_this4.getQueryParameters()));

              case 4:
                response = _context4.sent;

                if (response.status == 200) {
                  _this4.zones = response.data; // this.pagination = response.data;
                }

                _context4.next = 11;
                break;

              case 8:
                _context4.prev = 8;
                _context4.t0 = _context4["catch"](0);
                console.log(_context4.t0);

              case 11:
                _context4.prev = 11;
                _this4.loading = false;
                return _context4.finish(11);

              case 14:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, null, [[0, 8, 11, 14]]);
      }))();
    },
    open: function open() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _context5.next = 2;
                return _this5.getRecords();

              case 2:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-036b3703\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/persons/client_zones.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ],
      attrs: {
        visible: _vm.showDialog,
        "append-to-body": "",
        title: "Zonas de cliente"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c(
        "div",
        {
          staticClass: " d-flex justify-content-end",
          staticStyle: { "margin-top": "5px" }
        },
        [
          _c(
            "button",
            {
              staticClass:
                "btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto",
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.clickCreate()
                }
              }
            },
            [
              _c("i", { staticClass: "icofont-plus-circle" }),
              _vm._v(" "),
              _c("span", [_vm._v("Nuevo")])
            ]
          )
        ]
      ),
      _vm._v(" "),
      _vm.zones.length != 0
        ? _c("div", { staticClass: "row" }, [
            _c(
              "table",
              { staticClass: "table table-responsive table-striped" },
              [
                _c("thead", [
                  _c("tr", [
                    _c("th", [_vm._v("#")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Descripción")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Acciones")])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.zones, function(zone, idx) {
                    return _c("tr", { key: idx }, [
                      _c("td", [_vm._v(_vm._s(idx + 1))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(zone.description))]),
                      _vm._v(" "),
                      _c("td", [
                        _c(
                          "button",
                          {
                            class:
                              "btn " +
                              (zone.active ? "btn-danger" : "btn-success"),
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.clickActive(zone)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(zone.active ? "Desactivar" : "Activar") +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-primary ",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.clickEdit(zone)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                            Editar\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-danger",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.clickDelete(zone)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                            Eliminar\n                        "
                            )
                          ]
                        )
                      ])
                    ])
                  }),
                  0
                )
              ]
            )
          ])
        : _c("div", [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-12" }, [
                _c("div", { staticClass: "alert alert-info" }, [
                  _vm._v(
                    "\n                    No hay registros\n                "
                  )
                ])
              ])
            ])
          ]),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          attrs: {
            width: "550px",
            visible: _vm.showCreateForm,
            "append-to-body": "",
            title: _vm.form.id ? "Editar Zona" : "Crear Zona"
          },
          on: {
            "update:visible": function($event) {
              _vm.showCreateForm = $event
            },
            close: function($event) {
              _vm.showCreateForm = false
            }
          }
        },
        [
          _c("div", { staticClass: "row m-2" }, [
            _c(
              "div",
              { staticClass: "col-12" },
              [
                _c("label", [_vm._v("Descripción")]),
                _vm._v(" "),
                _c("el-input", {
                  model: {
                    value: _vm.form.description,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "description", $$v)
                    },
                    expression: "form.description"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "d-flex justify-content-center ",
                staticStyle: { "margin-top": "5px" }
              },
              [
                _c(
                  "button",
                  {
                    staticClass:
                      "btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.submit.apply(null, arguments)
                      }
                    }
                  },
                  [
                    _c("span", [
                      _vm._v(
                        " " + _vm._s(_vm.form.id ? "Actualizar" : "Crear") + " "
                      )
                    ])
                  ]
                )
              ]
            )
          ])
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-036b3703", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/persons/client_zones.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/persons/client_zones.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-036b3703\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/persons/client_zones.vue")
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
Component.options.__file = "resources/js/views/persons/client_zones.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-036b3703", Component.options)
  } else {
    hotAPI.reload("data-v-036b3703", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=167.js.map