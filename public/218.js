webpackJsonp([218],{

/***/ "./modules/College/Resources/assets/js/views/penalties/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/penalties/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0286809f\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/penalties/form.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/views/penalties/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0286809f", Component.options)
  } else {
    hotAPI.reload("data-v-0286809f", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/penalties/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

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
var FormService = function FormService() {
  return __webpack_require__.e/* import() */(141/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/service_create.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    FormService: FormService
  },
  props: ["showDialog", "record"],
  data: function data() {
    return {
      title: "Crear nuevo",
      loading: false,
      form: {},
      timer: null,
      loading_search: false,
      items: [],
      price: null,
      loading_search_item: false,
      services: [],
      resource: "penalties",
      showFormCreateService: false
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
    openCreateService: function openCreateService() {
      this.showFormCreateService = true;
    },
    add: function add(data) {
      this.items = [].concat(_toConsumableArray(this.items), [data]);
      this.form.item_id = data.id;
      this.changeItem();
    },
    getTables: function getTables() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, items;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _this2.loading = true;
                _context2.next = 4;
                return _this2.$http.get("".concat(_this2.resource, "/tables"));

              case 4:
                response = _context2.sent;
                items = response.data.items;
                _this2.items = items;
                _context2.next = 13;
                break;

              case 9:
                _context2.prev = 9;
                _context2.t0 = _context2["catch"](0);
                console.log(_context2.t0);

                _this2.$toast.error("Ocurrió un problema");

              case 13:
                _context2.prev = 13;
                _this2.loading = false;
                return _context2.finish(13);

              case 16:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[0, 9, 13, 16]]);
      }))();
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
    addItem: function addItem() {
      var _this3 = this;

      var item = this.items.find(function (i) {
        return i.id == _this3.form.item_id;
      }); // let { id } = item;

      this.services = [item]; // this.initItemForm();
    },
    changeItem: function changeItem() {
      this.addItem();
    },
    searchRemoteItems: function searchRemoteItems(input) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                if (input.length > 2) {
                  if (_this4.timer) {
                    clearTimeout(_this4.timer);
                  }

                  _this4.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
                    var parameters, response;
                    return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
                      while (1) {
                        switch (_context3.prev = _context3.next) {
                          case 0:
                            _context3.prev = 0;
                            parameters = "input=".concat(input);
                            _this4.loading_search = true;
                            _context3.next = 5;
                            return _this4.$http.get("/documents/data-table/items?service=1&".concat(parameters));

                          case 5:
                            response = _context3.sent;
                            _this4.items = response.data;
                            _context3.next = 12;
                            break;

                          case 9:
                            _context3.prev = 9;
                            _context3.t0 = _context3["catch"](0);
                            console.log(_context3.t0);

                          case 12:
                            _context3.prev = 12;
                            _this4.loading_search = false;
                            return _context3.finish(12);

                          case 15:
                          case "end":
                            return _context3.stop();
                        }
                      }
                    }, _callee3, null, [[0, 9, 12, 15]]);
                  })), 250);
                }

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    submit: function submit() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var response, _response$data, message, success;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _context5.prev = 0;
                _this5.loading = true;
                _this5.form.services = _this5.services;
                _context5.next = 5;
                return _this5.$http.post("penalties", _objectSpread(_objectSpread({}, _this5.form), {}, {
                  id: _this5.record ? _this5.record.id : null
                }));

              case 5:
                response = _context5.sent;
                _response$data = response.data, message = _response$data.message, success = _response$data.success;

                if (success) {
                  _this5.$toast.success(message);

                  _this5.$emit("getRecords");
                } else {
                  _this5.$toast.error(message);
                }

                console.log(response);
                _context5.next = 15;
                break;

              case 11:
                _context5.prev = 11;
                _context5.t0 = _context5["catch"](0);
                console.log(_context5.t0);

                _this5.$toast.error("Ocurrió un problema");

              case 15:
                _context5.prev = 15;
                _this5.loading = false;

                _this5.close();

                return _context5.finish(15);

              case 19:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, null, [[0, 11, 15, 19]]);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog");
    },
    open: function open() {
      this.form = {
        default_count: 1,
        type: "amount"
      };

      if (this.record) {
        console.log(this.record);
        this.form = _objectSpread({}, this.record);
        this.items = this.form.services.map(function (s) {
          return s.item;
        });
        this.services = _toConsumableArray(this.items);

        var _this$items = _slicedToArray(this.items, 1),
            item = _this$items[0];

        this.form.item_id = item.id;
        this.title = "Editar penalidad";
      } else {
        this.title = "Crear nueva penalidad";
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0286809f\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/penalties/form.vue":
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
        visible: _vm.showDialog,
        width: "650px"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", [
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-md-6 col-12" },
            [
              _c(
                "label",
                { staticClass: "label-control w-100", attrs: { for: "" } },
                [_vm._v("Descripción")]
              ),
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
            { staticClass: "col-md-3 col-12" },
            [
              _c(
                "label",
                { staticClass: "label-control w-100", attrs: { for: "" } },
                [
                  _vm._v(
                    "\n                    Tipo de cobro\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  model: {
                    value: _vm.form.type,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "type", $$v)
                    },
                    expression: "form.type"
                  }
                },
                [
                  _c("el-option", {
                    attrs: { value: "percentage", label: "Porcentaje" }
                  }),
                  _vm._v(" "),
                  _c("el-option", {
                    attrs: { value: "amount", label: "Monto fijo" }
                  })
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-3 col-12" },
            [
              _c(
                "label",
                { staticClass: "label-control w-100", attrs: { for: "" } },
                [
                  _vm._v(
                    "\n                    " +
                      _vm._s(
                        _vm.form.type == "percentage"
                          ? "Porcentaje %"
                          : "S/ Monto"
                      ) +
                      "\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _vm.form.type == "amount"
                ? _c("el-input-number", {
                    staticStyle: { width: "100%" },
                    attrs: {
                      "controls-position": "right",
                      precision: 2,
                      step: 0.1
                    },
                    model: {
                      value: _vm.form.percentage,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "percentage", $$v)
                      },
                      expression: "form.percentage"
                    }
                  })
                : _c("el-input-number", {
                    staticStyle: { width: "100%" },
                    attrs: {
                      "controls-position": "right",
                      precision: 2,
                      max: 100,
                      step: 0.1
                    },
                    model: {
                      value: _vm.form.percentage,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "percentage", $$v)
                      },
                      expression: "form.percentage"
                    }
                  })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-12" },
            [
              _c("label", { staticClass: "control-label w-100" }, [
                _vm._v("Servicio\n                    "),
                _c(
                  "a",
                  {
                    staticClass: "control-label font-weight-bold text-info",
                    attrs: { href: "#" },
                    on: { click: _vm.openCreateService }
                  },
                  [_vm._v("\n                        [ + Nuevo]")]
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
                    attrs: { value: option.id, label: option.description }
                  })
                }),
                1
              )
            ],
            1
          )
        ])
      ]),
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
    require("vue-hot-reload-api")      .rerender("data-v-0286809f", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=218.js.map