webpackJsonp([216],{

/***/ "./modules/College/Resources/assets/js/views/plans/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/plans/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7c5d8c08\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/plans/form.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/views/plans/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7c5d8c08", Component.options)
  } else {
    hotAPI.reload("data-v-7c5d8c08", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/plans/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



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
var FormService = function FormService() {
  return __webpack_require__.e/* import() */(142/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/service_create.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    FormService: FormService
  },
  props: ["showDialog", "record"],
  data: function data() {
    return {
      showFormCreateService: false,
      title: "Crear nuevo",
      loading: false,
      resource: "plans",
      form: {},
      periods: [],
      tab: "plan",
      services: [],
      items: [],
      loading_search_item: false,
      timer: null,
      price: null,
      penalties: [],
      types: [],
      currentPenalty: null,
      disabled: false
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
              return _this.getTables();

            case 2:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    changePenalty: function changePenalty() {
      var penalty_id = this.form.penalty_id;

      if (penalty_id) {
        var penalty = this.penalties.find(function (p) {
          return p.id == penalty_id;
        });
        console.log(penalty);
        var type = penalty.type,
            percentage = penalty.percentage;

        if (type == "percentage") {
          this.currentPenalty = "Por d\xEDa: ".concat(percentage, " %");
        } else {
          this.currentPenalty = "Por d\xEDa: S/ ".concat(percentage);
        }
      }
    },
    add: function add(data) {
      this.items = [].concat(_toConsumableArray(this.items), [data]);
      this.form.item_id = data.id;
      this.changeItem();
    },
    openCreateService: function openCreateService() {
      this.showFormCreateService = true;
    },
    initItemForm: function initItemForm() {
      this.form.item_id = null;
      this.form.disabled = false;
      this.price = null;
    },
    deleteService: function deleteService(id) {
      this.services = this.services.filter(function (s) {
        return s.item_id != id;
      });
    },
    changeItem: function changeItem() {
      var _this2 = this;

      var item = this.items.find(function (i) {
        return i.id == _this2.form.item_id;
      });
      var sale_unit_price = item.sale_unit_price;
      this.price = Number(sale_unit_price).toFixed(2);
    },
    addItem: function addItem() {
      var _this3 = this;

      var item = this.items.find(function (i) {
        return i.id == _this3.form.item_id;
      }); // let { id } = item;
      // if (this.services.some(s => s.item_id == id)) {
      //     return this.$toast.error("Ya agregó ese servicio");
      // }

      this.services = [// ...this.services,
      {
        price: this.price,
        item: item,
        item_id: item.id
      }];
      this.initItemForm();
    },
    searchRemoteItems: function searchRemoteItems(input) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (input.length > 2) {
                  if (_this4.timer) {
                    clearTimeout(_this4.timer);
                  }

                  _this4.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
                    var parameters, response;
                    return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
                      while (1) {
                        switch (_context2.prev = _context2.next) {
                          case 0:
                            _context2.prev = 0;
                            parameters = "input=".concat(input);
                            _this4.loading_search = true;
                            _context2.next = 5;
                            return _this4.$http.get("/documents/data-table/items?service=1&".concat(parameters));

                          case 5:
                            response = _context2.sent;
                            _this4.items = response.data;
                            _context2.next = 12;
                            break;

                          case 9:
                            _context2.prev = 9;
                            _context2.t0 = _context2["catch"](0);
                            console.log(_context2.t0);

                          case 12:
                            _context2.prev = 12;
                            _this4.loading_search = false;
                            return _context2.finish(12);

                          case 15:
                          case "end":
                            return _context2.stop();
                        }
                      }
                    }, _callee2, null, [[0, 9, 12, 15]]);
                  })), 250);
                }

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getTables: function getTables() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response, _response$data, periods, items, types, penalties;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.prev = 0;
                _this5.loading = true;
                _context4.next = 4;
                return _this5.$http.get("".concat(_this5.resource, "/tables"));

              case 4:
                response = _context4.sent;
                _response$data = response.data, periods = _response$data.periods, items = _response$data.items, types = _response$data.types, penalties = _response$data.penalties;
                _this5.items = items;
                _this5.penalties = penalties;
                _this5.periods = periods;
                _this5.types = types;
                _context4.next = 16;
                break;

              case 12:
                _context4.prev = 12;
                _context4.t0 = _context4["catch"](0);
                console.log(_context4.t0);

                _this5.$toast.error("Ocurrió un problema");

              case 16:
                _context4.prev = 16;
                _this5.loading = false;
                return _context4.finish(16);

              case 19:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, null, [[0, 12, 16, 19]]);
      }))();
    },
    validate: function validate() {
      var fail = false;
      var _this$form = this.form,
          name = _this$form.name,
          description = _this$form.description,
          period_id = _this$form.period_id,
          type_id = _this$form.type_id,
          payment_date = _this$form.payment_date;

      if (this.services.length == 0) {
        this.$toast.error("Debe agregar un servicio");
        fail = true;
      }

      if (!name) {
        this.$toast.error("Debe ingresar un nombre");
        fail = true;
      }

      if (!description) {
        this.$toast.error("Debe ingresar una descripción");
        fail = true;
      }

      if (!period_id) {
        this.$toast.error("Debe elegir un periodo");
        fail = true;
      }

      if (!type_id) {
        this.$toast.error("Debe elegir un tipo");
        fail = true;
      }

      if (type_id == 2) {
        if (!payment_date) {
          this.$toast.error("La fecha de pago es obligatoria");
          fail = true;
        }
      }

      return fail;
    },
    submit: function submit() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var response, _response$data2, message, success;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                if (!_this6.validate()) {
                  _context5.next = 2;
                  break;
                }

                return _context5.abrupt("return");

              case 2:
                _context5.prev = 2;
                _this6.loading = true;
                _this6.form.services = _this6.services;
                _context5.next = 7;
                return _this6.$http.post("".concat(_this6.resource), _objectSpread(_objectSpread({}, _this6.form), {}, {
                  id: _this6.record ? _this6.record.id : null
                }));

              case 7:
                response = _context5.sent;
                _response$data2 = response.data, message = _response$data2.message, success = _response$data2.success;

                if (success) {
                  _this6.$toast.success(message);

                  _this6.$emit("getRecords");
                } else {
                  _this6.$toast.error(message);
                }

                _context5.next = 16;
                break;

              case 12:
                _context5.prev = 12;
                _context5.t0 = _context5["catch"](2);
                console.log(_context5.t0);

                _this6.$toast.error("Ocurrió un problema");

              case 16:
                _context5.prev = 16;
                _this6.loading = false;

                _this6.close();

                return _context5.finish(16);

              case 20:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, null, [[2, 12, 16, 20]]);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog");
    },
    open: function open() {
      this.currentPenalty = null;
      this.services = [];
      this.price = null;
      this.form = {
        default_count: 1,
        days_extension: 0
      };

      if (this.record) {
        this.form = _objectSpread({}, this.record); // this.form.penalty_id = this.form.penalty.id;

        this.services = _toConsumableArray(this.form.services);

        if (this.form.payment_date) {
          this.form.payment_date = this.form.payment_date.split("/").reverse().join("-");
          this.changePenalty();
        }

        this.title = "Editar plan";
      } else {
        this.title = "Crear nuevo plan";
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7c5d8c08\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/plans/form.vue":
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
        "append-to-body": "",
        title: _vm.title,
        visible: _vm.showDialog
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c(
        "el-tabs",
        {
          attrs: { "tab-position": "top" },
          model: {
            value: _vm.tab,
            callback: function($$v) {
              _vm.tab = $$v
            },
            expression: "tab"
          }
        },
        [
          _c(
            "el-tab-pane",
            { attrs: { name: "plan", label: "Datos del plan" } },
            [
              _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "card-body" }, [
                  _c("div", { staticClass: "row" }, [
                    _c(
                      "div",
                      { staticClass: "col-md-6 col-12" },
                      [
                        _c("label", [_vm._v("Nombre")]),
                        _vm._v(" "),
                        _c("el-input", {
                          model: {
                            value: _vm.form.name,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "name", $$v)
                            },
                            expression: "form.name"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-6 col-12" },
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
                      { staticClass: "col-md-6 col-12" },
                      [
                        _c("label", [_vm._v("Periodo")]),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            model: {
                              value: _vm.form.period_id,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "period_id", $$v)
                              },
                              expression: "form.period_id"
                            }
                          },
                          _vm._l(_vm.periods, function(period, idx) {
                            return _c("el-option", {
                              key: idx,
                              attrs: {
                                label: period.description,
                                value: period.id
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-6 col-12" },
                      [
                        _c("label", [_vm._v("Tipo")]),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            model: {
                              value: _vm.form.type_id,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "type_id", $$v)
                              },
                              expression: "form.type_id"
                            }
                          },
                          _vm._l(_vm.types, function(type, idx) {
                            return _c("el-option", {
                              key: idx,
                              attrs: { label: type.description, value: type.id }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-6 col-12 mt-1" },
                      [
                        _c("label", { staticClass: "label-control w-100" }, [
                          _vm._v("Penalidad")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            on: { change: _vm.changePenalty },
                            model: {
                              value: _vm.form.penalty_id,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "penalty_id", $$v)
                              },
                              expression: "form.penalty_id"
                            }
                          },
                          _vm._l(_vm.penalties, function(penalty, idx) {
                            return _c("el-option", {
                              key: idx,
                              attrs: {
                                label: penalty.description,
                                value: penalty.id
                              }
                            })
                          }),
                          1
                        ),
                        _vm._v(" "),
                        _vm.currentPenalty
                          ? _c("small", { staticClass: "text-primary" }, [
                              _vm._v(_vm._s(_vm.currentPenalty))
                            ])
                          : _vm._e()
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _vm.form.penalty_id
                      ? _c(
                          "div",
                          { staticClass: "col-md-6 col-12 mt-1" },
                          [
                            _c(
                              "label",
                              {
                                staticClass: "label-control w-100",
                                attrs: { for: "" }
                              },
                              [
                                _vm._v(
                                  "\n                                Días de prorroga\n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c("el-input-number", {
                              staticStyle: { width: "100%" },
                              attrs: {
                                precision: 0,
                                "controls-position": "right"
                              },
                              model: {
                                value: _vm.form.days_extension,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "days_extension", $$v)
                                },
                                expression: "form.days_extension"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-6 col-12 mt-1" },
                      [
                        _c("label", { staticClass: "label-control w-100" }, [
                          _vm._v("Fecha de pago")
                        ]),
                        _vm._v(" "),
                        _c("el-date-picker", {
                          staticClass: "w-100",
                          attrs: {
                            format: "dd/MM/yyyy",
                            "value-format": "yyyy-MM-dd"
                          },
                          model: {
                            value: _vm.form.payment_date,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "payment_date", $$v)
                            },
                            expression: "form.payment_date"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-6 col-12 mt-1" },
                      [
                        _c("label", { staticClass: "label-control w-100" }, [
                          _vm._v("Vigencia")
                        ]),
                        _vm._v(" "),
                        _c("el-date-picker", {
                          staticClass: "w-100",
                          attrs: {
                            format: "dd/MM/yyyy",
                            "value-format": "yyyy-MM-dd"
                          },
                          model: {
                            value: _vm.form.validity_date,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "validity_date", $$v)
                            },
                            expression: "form.validity_date"
                          }
                        })
                      ],
                      1
                    )
                  ])
                ])
              ])
            ]
          ),
          _vm._v(" "),
          _c(
            "el-tab-pane",
            { attrs: { name: "service", label: "Servicios" } },
            [
              _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "card-body" }, [
                  _c("div", { staticClass: "row" }, [
                    _c(
                      "div",
                      { staticClass: "col-md-5" },
                      [
                        _c("label", { staticClass: "control-label w-100" }, [
                          _vm._v("Servicio\n                                "),
                          _c(
                            "a",
                            {
                              staticClass:
                                "control-label font-weight-bold text-info",
                              attrs: { href: "#" },
                              on: { click: _vm.openCreateService }
                            },
                            [
                              _vm._v(
                                "\n                                    [ + Nuevo]"
                              )
                            ]
                          )
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            staticClass: "w-100",
                            attrs: {
                              filterable: "",
                              remote: "",
                              "popper-class": "el-select-customers",
                              clearable: "",
                              placeholder: "Nombre o código interno",
                              "remote-method": _vm.searchRemoteItems,
                              loading: _vm.loading_search_item
                            },
                            on: { change: _vm.changeItem },
                            model: {
                              value: _vm.form.item_id,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "item_id", $$v)
                              },
                              expression: "form.item_id"
                            }
                          },
                          _vm._l(_vm.items, function(option) {
                            return _c("el-option", {
                              key: option.id,
                              attrs: {
                                value: option.id,
                                label: option.description
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-4" },
                      [
                        _c(
                          "label",
                          {
                            staticClass: "control-label w-100",
                            attrs: { for: "" }
                          },
                          [_vm._v("Precio")]
                        ),
                        _vm._v(" "),
                        _c("el-input", {
                          attrs: { disabled: !_vm.disabled },
                          model: {
                            value: _vm.price,
                            callback: function($$v) {
                              _vm.price = $$v
                            },
                            expression: "price"
                          }
                        }),
                        _c("br"),
                        _vm._v(" "),
                        _vm.form.item_id
                          ? _c(
                              "el-checkbox",
                              {
                                staticClass: "mt-1",
                                model: {
                                  value: _vm.disabled,
                                  callback: function($$v) {
                                    _vm.disabled = $$v
                                  },
                                  expression: "disabled"
                                }
                              },
                              [_vm._v("Editar")]
                            )
                          : _vm._e()
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-3 " },
                      [
                        _c("label", {
                          staticClass: "control-label w-100",
                          attrs: { for: "" }
                        }),
                        _vm._v(" "),
                        _c("el-button", { on: { click: _vm.addItem } }, [
                          _vm._v(
                            "\n                                Agregar\n                            "
                          )
                        ])
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "row" }, [
                    _c("table", { staticClass: "table" }, [
                      _c("thead", [
                        _c("tr", [
                          _c("th", [_vm._v("#")]),
                          _vm._v(" "),
                          _c("th", [_vm._v("Descripción")]),
                          _vm._v(" "),
                          _c("th", [_vm._v("Costo")]),
                          _vm._v(" "),
                          _c("th")
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        _vm._l(_vm.services, function(service, idx) {
                          return _c("tr", { key: idx }, [
                            _c("td", [_vm._v(_vm._s(idx + 1))]),
                            _vm._v(" "),
                            _c("td", [
                              _vm._v(_vm._s(service.item.description))
                            ]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(service.price))]),
                            _vm._v(" "),
                            _c(
                              "td",
                              [
                                _c("el-button", {
                                  attrs: {
                                    type: "danger",
                                    size: "mini",
                                    icon: "el-icon-delete",
                                    circle: ""
                                  },
                                  on: {
                                    click: function($event) {
                                      return _vm.deleteService(service.item.id)
                                    }
                                  }
                                })
                              ],
                              1
                            )
                          ])
                        }),
                        0
                      )
                    ])
                  ])
                ])
              ])
            ]
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "dialog-footer",
          attrs: { slot: "footer" },
          slot: "footer"
        },
        [
          _c("el-button", { on: { click: _vm.close } }, [_vm._v("Cancelar")]),
          _vm._v(" "),
          _c(
            "el-button",
            { attrs: { type: "primary" }, on: { click: _vm.submit } },
            [_vm._v("Guardar")]
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("form-service", {
        attrs: { showDialog: _vm.showFormCreateService },
        on: {
          add: _vm.add,
          "update:showDialog": function($event) {
            _vm.showFormCreateService = $event
          },
          "update:show-dialog": function($event) {
            _vm.showFormCreateService = $event
          }
        }
      })
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
    require("vue-hot-reload-api")      .rerender("data-v-7c5d8c08", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=216.js.map