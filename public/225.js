webpackJsonp([225],{

/***/ "./modules/College/Resources/assets/js/components/service_form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/service_form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-3fbe7136\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/service_form.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/components/service_form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3fbe7136", Component.options)
  } else {
    hotAPI.reload("data-v-3fbe7136", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/service_form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_moment__);
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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["member"],
  data: function data() {
    return {
      resource: "registers",
      loading: false,
      plans: [],
      date: __WEBPACK_IMPORTED_MODULE_1_moment___default()(),
      monthsPayed: [],
      paymentDay: null,
      form: {},
      currentPlan: null,
      penalties: [],
      limitDate: null,
      selectedMonths: [],
      months: [{
        id: 1,
        label: "Enero",
        disabled: false
      }, {
        id: 2,
        label: "Febrero",
        disabled: false
      }, {
        id: 3,
        label: "Marzo",
        disabled: false
      }, {
        id: 4,
        label: "Abril",
        disabled: false
      }, {
        id: 5,
        label: "Mayo",
        disabled: false
      }, {
        id: 6,
        label: "Junio",
        disabled: false
      }, {
        id: 7,
        label: "Julio",
        disabled: false
      }, {
        id: 8,
        label: "Agosto",
        disabled: false
      }, {
        id: 9,
        label: "Setiembre",
        disabled: false
      }, {
        id: 10,
        label: "Octubre",
        disabled: false
      }, {
        id: 11,
        label: "Noviembre",
        disabled: false
      }, {
        id: 12,
        label: "Diciembre",
        disabled: false
      }]
    };
  },
  created: function created() {// await this.getTables();

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    changePlan: function changePlan() {
      this.paymentDay = null;
      this.penalties = [];
      this.currentPlan = null;
      this.limitDate = null;
      this.selectedMonths = [];
      this.updateTotal();
    },
    //limit  es una fecha, con el mes y año actual, pero con el día del pago
    //date es la fecha actual
    //paymentday es solo el día
    //
    checkPenalty: function checkPenalty(date) {
      var _this$currentPlan = this.currentPlan,
          total = _this$currentPlan.total,
          penalty = _this$currentPlan.penalty,
          days_extension = _this$currentPlan.days_extension;
      date = date.add(days_extension, "days");

      if (this.date.isAfter(date.add())) {
        if (penalty) {
          var percentage = penalty.percentage,
              type = penalty.type;
          percentage = type == "percentage" ? Number(percentage) / 100 : Number(percentage);
          var totalPerDay = type == "percentage" ? total * percentage : percentage;
          var days = this.date.diff(date, "days");
          var month = date.get("month") + 1;
          var nameMonth = this.months.find(function (m) {
            return m.id == month;
          }).label;
          this.penalties.push({
            id: month,
            days: days,
            label: nameMonth,
            penalty: days * totalPerDay
          });
        }
      }
    },
    selectMonth: function selectMonth() {
      var _this = this;

      this.penalties = [];

      if (this.paymentDay) {
        this.selectedMonths.forEach(function (sm) {
          var date = __WEBPACK_IMPORTED_MODULE_1_moment___default()("".concat(sm, "-").concat(_this.paymentDay, "-").concat(_this.date.format("Y")));

          _this.checkPenalty(date);
        });
      }

      this.updateTotal();
    },
    initForm: function initForm() {
      this.currentPlan = null;
      this.penalties = [];
      this.paymentDay = null;
      this.form = {};
      this.months = [{
        id: 1,
        label: "Enero",
        disabled: false
      }, {
        id: 2,
        label: "Febrero",
        disabled: false
      }, {
        id: 3,
        label: "Marzo",
        disabled: false
      }, {
        id: 4,
        label: "Abril",
        disabled: false
      }, {
        id: 5,
        label: "Mayo",
        disabled: false
      }, {
        id: 6,
        label: "Junio",
        disabled: false
      }, {
        id: 7,
        label: "Julio",
        disabled: false
      }, {
        id: 8,
        label: "Agosto",
        disabled: false
      }, {
        id: 9,
        label: "Setiembre",
        disabled: false
      }, {
        id: 10,
        label: "Octubre",
        disabled: false
      }, {
        id: 11,
        label: "Noviembre",
        disabled: false
      }, {
        id: 12,
        label: "Diciembre",
        disabled: false
      }];
    },
    typeParent: function typeParent(type) {
      var types = {
        mother: "Madre:",
        father: "Padre:",
        attorney: "Apoderado:"
      };
      return types[type];
    },
    setMonths: function setMonths() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var months;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.months = [{
                  id: 1,
                  label: "Enero",
                  disabled: false
                }, {
                  id: 2,
                  label: "Febrero",
                  disabled: false
                }, {
                  id: 3,
                  label: "Marzo",
                  disabled: false
                }, {
                  id: 4,
                  label: "Abril",
                  disabled: false
                }, {
                  id: 5,
                  label: "Mayo",
                  disabled: false
                }, {
                  id: 6,
                  label: "Junio",
                  disabled: false
                }, {
                  id: 7,
                  label: "Julio",
                  disabled: false
                }, {
                  id: 8,
                  label: "Agosto",
                  disabled: false
                }, {
                  id: 9,
                  label: "Setiembre",
                  disabled: false
                }, {
                  id: 10,
                  label: "Octubre",
                  disabled: false
                }, {
                  id: 11,
                  label: "Noviembre",
                  disabled: false
                }, {
                  id: 12,
                  label: "Diciembre",
                  disabled: false
                }];

                if (_this2.form.plan_id) {
                  months = _this2.monthsPayed.filter(function (m) {
                    return m.plan_id == _this2.form.plan_id;
                  });
                  months.forEach(function (m) {
                    _this2.months.find(function (n) {
                      return n.id == m.month;
                    }).disabled = true;
                  });
                }

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    updateTotal: function updateTotal() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var plan, items, name, description, _this3$member, id, parent, person, observation, totalPenalties, form, penalties;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (_this3.form.plan_id) {
                  _context3.next = 2;
                  break;
                }

                return _context3.abrupt("return");

              case 2:
                _this3.setMonths();

                plan = _this3.plans.find(function (p) {
                  return p.id == _this3.form.plan_id;
                });
                items = [];

                if (plan) {
                  _this3.currentPlan = plan;

                  if (plan.payment_date) {
                    _this3.paymentDay = plan.payment_date.split("/")[0];
                    _this3.limitDate = __WEBPACK_IMPORTED_MODULE_1_moment___default()().set("date", _this3.paymentDay);
                  }

                  items = plan.services.map(function (s) {
                    s.item.sale_unit_price = s.price * _this3.selectedMonths.length;
                    s.item.percentage_igv = 18;
                    return s.item;
                  });
                } else {
                  _this3.currentPlan = null;
                  _this3.paymentDay = null;
                  _this3.limitDate = null;
                }

                name = plan.name, description = plan.description;
                _this3$member = _this3.member, id = _this3$member.id, parent = _this3$member.parent, person = _this3$member.person;
                observation = "".concat(name, " - ").concat(description, " ").concat(_this3.selectedMonths.length != 0 ? "Meses: ".concat(_this3.selectedMonths.sort(function (a, b) {
                  return a - b;
                }).map(function (n) {
                  return _this3.months.find(function (m) {
                    return m.id == n;
                  }).label;
                }).join("-")) : "").toUpperCase();

                _this3.penalties.sort(function (a, b) {
                  return a.id - b.id;
                });

                totalPenalties = _this3.penalties.reduce(function (a, b) {
                  return a + Number(b.penalty);
                }, 0);
                form = {
                  member_id: id,
                  plan_id: plan.id,
                  first_pay: "2023-01-30",
                  last_pay: "2023-01-30",
                  payment_count: 1,
                  active: 1,
                  months: _this3.selectedMonths
                };

                if (_this3.currentPlan && _this3.currentPlan.penalty) {
                  penalties = _this3.currentPlan.penalty.services.map(function (s) {
                    s.item.sale_unit_price = totalPenalties;
                    s.item.percentage_igv = 18;
                    return s.item;
                  });
                  form.detail = {
                    items: items,
                    penalties: penalties
                  };
                  items = [].concat(_toConsumableArray(items), _toConsumableArray(penalties));
                }

                _this3.$emit("createFormRegister", form);

                _this3.$emit("updateItems", items);

                _this3.$emit("updateObservation", observation);

                _this3.$emit("updateCustomer", parent.person);

              case 17:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getTables: function getTables() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response, _response$data, plans, months;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.prev = 0;
                _this4.loading = true;
                _context4.next = 4;
                return _this4.$http.get("/college/".concat(_this4.resource, "/tables?service=1&member_id=").concat(_this4.member.id));

              case 4:
                response = _context4.sent;
                _response$data = response.data, plans = _response$data.plans, months = _response$data.months;
                _this4.monthsPayed = months;

                _this4.setMonths();

                _this4.plans = plans.map(function (r) {
                  return _objectSpread(_objectSpread({}, r), {}, {
                    total: r.services.reduce(function (a, b) {
                      return a + Number(b.price);
                    }, 0)
                  });
                });
                _context4.next = 15;
                break;

              case 11:
                _context4.prev = 11;
                _context4.t0 = _context4["catch"](0);
                console.log(_context4.t0);

                _this4.$toast.error("Ocurrió un problema");

              case 15:
                _context4.prev = 15;
                _this4.loading = false;
                return _context4.finish(15);

              case 18:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, null, [[0, 11, 15, 18]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-3fbe7136\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/service_form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ],
      staticClass: "card bg-ligth"
    },
    [
      _c("div", { staticClass: "row mt-2" }, [
        _c(
          "div",
          { staticClass: "col-12" },
          [
            _c("label", { staticClass: "label-control w-100" }, [
              _vm._v("Plan")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                on: { change: _vm.changePlan },
                model: {
                  value: _vm.form.plan_id,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "plan_id", $$v)
                  },
                  expression: "form.plan_id"
                }
              },
              _vm._l(_vm.plans, function(plan, idx) {
                return _c("el-option", {
                  key: idx,
                  attrs: {
                    label:
                      plan.name + " " + plan.description + " S/" + plan.total,
                    value: plan.id
                  }
                })
              }),
              1
            ),
            _vm._v(" "),
            _vm.paymentDay
              ? _c("label", { staticClass: "mt-2 label-control" }, [
                  _vm._v("Vencimiento:\n                "),
                  _c("strong", [
                    _vm._v(
                      "\n                    " +
                        _vm._s(_vm.paymentDay.split("/")[0] + " de cada mes")
                    )
                  ])
                ])
              : _vm._e(),
            _vm._v(" "),
            _vm.currentPlan && _vm.currentPlan.days_extension != 0
              ? _c(
                  "label",
                  {
                    staticClass: "text-primary",
                    staticStyle: { "font-weight": "bold" }
                  },
                  [
                    _vm._v("\n                / Prorroga:\n                "),
                    _c("strong", [
                      _vm._v(
                        " " + _vm._s(_vm.currentPlan.days_extension) + " días "
                      )
                    ])
                  ]
                )
              : _vm._e()
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "row mt-1 " },
        [
          _c(
            "el-checkbox-group",
            {
              staticClass: " d-flex flex-wrap justify-content-center",
              attrs: { disabled: !_vm.form.plan_id },
              on: { change: _vm.selectMonth },
              model: {
                value: _vm.selectedMonths,
                callback: function($$v) {
                  _vm.selectedMonths = $$v
                },
                expression: "selectedMonths"
              }
            },
            _vm._l(_vm.months, function(m) {
              return _c(
                "el-checkbox-button",
                {
                  key: m.id,
                  staticClass: "mt-1",
                  attrs: { disabled: m.disabled, label: m.id }
                },
                [_vm._v(_vm._s(m.label))]
              )
            }),
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _vm.penalties.length != 0
        ? _c("div", { staticClass: "row p-2 d-flex justify-content-center" }, [
            _c(
              "table",
              { staticClass: "table-sm table-bordered border-danger w-75" },
              [
                _c("thead", { staticClass: "thead-dark" }, [
                  _c("tr", [
                    _c("th", { staticClass: "text-center" }, [
                      _vm._v(
                        "\n                        Mes\n                    "
                      )
                    ]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-center" }, [
                      _vm._v("Días de retraso")
                    ]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-center" }, [
                      _vm._v(
                        "\n                        Penalidad x día" +
                          _vm._s(
                            _vm.currentPlan.penalty.type == "percentage"
                              ? " " + _vm.currentPlan.penalty.percentage + " %"
                              : " S/ " + _vm.currentPlan.penalty.percentage
                          ) +
                          "\n                    "
                      )
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "tbody",
                  [
                    _vm._l(_vm.penalties, function(penal, idx) {
                      return _c("tr", { key: idx }, [
                        _c("td", { staticClass: "text-center" }, [
                          _vm._v(_vm._s(penal.label))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-center" }, [
                          _vm._v(_vm._s(penal.days))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-center" }, [
                          _vm._v(
                            "\n                        " +
                              _vm._s(penal.penalty.toFixed(2)) +
                              "\n                    "
                          )
                        ])
                      ])
                    }),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }),
                      _vm._v(" "),
                      _vm._m(0),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _vm._v(
                          "\n                        " +
                            _vm._s(
                              _vm.penalties
                                .reduce(function(a, b) {
                                  return a + Number(b.penalty)
                                }, 0)
                                .toFixed(2)
                            ) +
                            "\n                    "
                        )
                      ])
                    ])
                  ],
                  2
                )
              ]
            )
          ])
        : _vm._e()
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", { staticClass: "text-center" }, [
      _c("span", { staticClass: "bold" }, [_vm._v("Total")])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-3fbe7136", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=225.js.map