webpackJsonp([189],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-a39b9b8c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_modal.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a39b9b8c", Component.options)
  } else {
    hotAPI.reload("data-v-a39b9b8c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_modal.vue":
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
var PersonForm = function PersonForm() {
  return __webpack_require__.e/* import() */(124/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/views/persons/form.vue"));
};

var PenaltyForm = function PenaltyForm() {
  return __webpack_require__.e/* import() */(138/* duplicate */).then(__webpack_require__.bind(null, "./modules/Consignment/Resources/assets/js/views/partials/penalty_form.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "items", "all_customers", "establishments"],
  components: {
    PersonForm: PersonForm,
    PenaltyForm: PenaltyForm
  },
  data: function data() {
    return {
      loading: false,
      showDialogNewPenalty: false,
      showDialogNewPerson: false,
      form: {},
      customers: [],
      penalties: [],
      loading_search: false
    };
  },
  created: function created() {
    this.getPenalties();
  },
  methods: {
    initForm: function initForm() {
      this.form = {
        person_id: null,
        date_of_issue: null,
        date_of_end: null,
        penalty_id: null
      };
    },
    getPenalties: function getPenalties() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this.$http("/consignment/penalty/records");

              case 2:
                response = _context.sent;
                _this.penalties = response.data;

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    formatedItems: function formatedItems() {
      var formatted = [];

      for (var i = 0; i < this.items.length; i++) {
        var item = this.items[i];
        var newItem = {};
        newItem.establishment_id = this.establishments.id;
        newItem.id = item.food.item.id;
        newItem.quantity = item.quantity;
        newItem.price = item.price;
        newItem.has_lots = item.series.length > 0;
        newItem.lots = item.series.map(function (s) {
          return {
            series: s.series,
            date: s.date,
            id: s.id
          };
        });
        formatted.push(newItem);
      }

      return formatted;
    },
    validate: function validate() {
      var hasError = false;
      var _this$form = this.form,
          person_id = _this$form.person_id,
          date_of_issue = _this$form.date_of_issue,
          date_of_end = _this$form.date_of_end;

      if (!person_id) {
        this.$toast.error("Debe seleccionar un cliente/vendedor");
        hasError = true;
      }

      if (!date_of_issue) {
        this.$toast.error("Debe seleccionar una fecha de consignación");
        hasError = true;
      }

      if (!date_of_end) {
        this.$toast.error("Debe seleccionar una fecha de liquidación");
        hasError = true;
      }

      return hasError;
    },
    submit: function submit() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var items, response, _response$data, success, message, id;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!_this2.validate()) {
                  _context2.next = 2;
                  break;
                }

                return _context2.abrupt("return");

              case 2:
                _context2.prev = 2;
                _this2.loading = true;
                items = _this2.formatedItems();
                _this2.form.items = items;
                _context2.next = 8;
                return _this2.$http.post("/consignment", _this2.form);

              case 8:
                response = _context2.sent;

                if (response.status == 200) {
                  _response$data = response.data, success = _response$data.success, message = _response$data.message, id = _response$data.id;

                  if (success) {
                    _this2.$toast.success(message);

                    _this2.$emit("update:showDialog", false);

                    _this2.$emit("limpiarForm");
                  } else {
                    _this2.$toast.error(message);
                  }
                }

                console.log(response);
                _context2.next = 17;
                break;

              case 13:
                _context2.prev = 13;
                _context2.t0 = _context2["catch"](2);

                _this2.$message.error("Ocurrió un error al crear la consignación");

                console.log(_context2.t0);

              case 17:
                _context2.prev = 17;
                _this2.loading = false;
                return _context2.finish(17);

              case 20:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[2, 13, 17, 20]]);
      }))();
    },
    clickNewPenalty: function clickNewPenalty() {
      this.showDialogNewPenalty = true;
    },
    clickNewPerson: function clickNewPerson() {
      this.showDialogNewPerson = true; // this.$emit('clickNewPerson');
    },
    reloadPenalties: function reloadPenalties(id) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.next = 2;
                return _this3.getPenalties();

              case 2:
                _this3.form.penalty_id = id;

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    open: function open() {
      this.customers = this.all_customers;
      this.initForm();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    searchRemoteCustomers: function searchRemoteCustomers(input) {
      var _this4 = this;

      if (input.length > 0) {
        this.loading_search = true;
        var parameters = "input=".concat(input);
        this.$http.get("/quotations/search/customers?".concat(parameters)).then(function (response) {
          _this4.customers = response.data.customers;
          _this4.loading_search = false;

          if (_this4.customers.length == 0) {
            _this4.customers = _this4.all_customers;
          }
        });
      } else {
        this.customers = this.all_customers;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-a39b9b8c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_modal.vue":
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
      attrs: { visible: _vm.showDialog, title: "Consignación" },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c(
        "div",
        { staticClass: "row m-2" },
        [
          _c(
            "div",
            { staticClass: "col-md-6 col-12" },
            [
              _c("label", { attrs: { for: "person_id" } }, [
                _vm._v("Cliente\n\n                "),
                _c(
                  "a",
                  { attrs: { href: "#" }, on: { click: _vm.clickNewPerson } },
                  [
                    _vm._v(
                      "\n                    [ + Nuevo ]\n                "
                    )
                  ]
                )
              ]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "border-left rounded-left border-info",
                  attrs: {
                    filterable: "",
                    remote: "",
                    "popper-class": "el-select-customers",
                    dusk: "customer_id",
                    placeholder:
                      "Escriba el nombre o número de documento del cliente",
                    "remote-method": _vm.searchRemoteCustomers,
                    loading: _vm.loading_search
                  },
                  model: {
                    value: _vm.form.person_id,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "person_id", $$v)
                    },
                    expression: "form.person_id"
                  }
                },
                _vm._l(_vm.customers, function(option) {
                  return _c("el-option", {
                    key: option.id,
                    attrs: { value: option.id, label: option.name }
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
            { staticClass: "col-md-3 col-12" },
            [
              _c("label", { attrs: { for: "date_of_issue" } }, [
                _vm._v("Fecha de consignación")
              ]),
              _vm._v(" "),
              _c("el-date-picker", {
                staticClass: "w-100",
                attrs: { type: "date", placeholder: "Seleccione una fecha" },
                model: {
                  value: _vm.form.date_of_issue,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "date_of_issue", $$v)
                  },
                  expression: "form.date_of_issue"
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
              _c("label", { attrs: { for: "date_of_end" } }, [
                _vm._v("Fecha de liquidación")
              ]),
              _vm._v(" "),
              _c("el-date-picker", {
                staticClass: "w-100",
                attrs: { type: "date", placeholder: "Seleccione una fecha" },
                model: {
                  value: _vm.form.date_of_end,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "date_of_end", $$v)
                  },
                  expression: "form.date_of_end"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 col-12" },
            [
              _c("label", { attrs: { for: "date_of_end" } }, [
                _vm._v("Penalización\n                "),
                _c(
                  "a",
                  { attrs: { href: "#" }, on: { click: _vm.clickNewPenalty } },
                  [
                    _vm._v(
                      "\n                    [ + Nuevo ]\n                "
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
                    placeholder: "Seleccione una penalización",
                    dusk: "penalty_id"
                  },
                  model: {
                    value: _vm.form.penalty_id,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "penalty_id", $$v)
                    },
                    expression: "form.penalty_id"
                  }
                },
                _vm._l(_vm.penalties, function(option) {
                  return _c("el-option", {
                    key: option.id,
                    attrs: { value: option.id, label: option.description }
                  })
                }),
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("person-form", {
            attrs: {
              showDialog: _vm.showDialogNewPerson,
              type: "customers",
              external: true
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogNewPerson = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogNewPerson = $event
              }
            }
          }),
          _vm._v(" "),
          _c("penalty-form", {
            attrs: { showDialog: _vm.showDialogNewPenalty },
            on: {
              reloadPenalties: _vm.reloadPenalties,
              "update:showDialog": function($event) {
                _vm.showDialogNewPenalty = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogNewPenalty = $event
              }
            }
          })
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
    require("vue-hot-reload-api")      .rerender("data-v-a39b9b8c", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=189.js.map