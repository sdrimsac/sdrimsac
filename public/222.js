webpackJsonp([222],{

/***/ "./modules/College/Resources/assets/js/components/payment_incomplete.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/payment_incomplete.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-46ad24ce\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/payment_incomplete.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/components/payment_incomplete.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-46ad24ce", Component.options)
  } else {
    hotAPI.reload("data-v-46ad24ce", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/payment_incomplete.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["plan", "register", "services", "member", "payable"],
  data: function data() {
    return {
      loading: false,
      form: {},
      plans: [this.plan],
      resource: "payments"
    };
  },
  created: function created() {},
  methods: {
    typeParent: function typeParent(type) {
      var types = {
        mother: "Madre:",
        father: "Padre:",
        attorney: "Apoderado:"
      };
      return types[type];
    },
    initForm: function initForm() {},
    updateTotal: function updateTotal() {
      if (!this.form.plan_id) {
        return;
      }

      var _this$register = this.register,
          payments = _this$register.payments,
          penalty = _this$register.penalty,
          rest = _this$register.rest;
      var lastPayment = payments[payments.length - 1];
      var _lastPayment$details = lastPayment.details,
          paymentItems = _lastPayment$details.items,
          paymentPenalties = _lastPayment$details.penalties;
      var detail = {};
      var items = paymentItems.map(function (s) {
        s.sale_unit_price = rest;
        s.percentage_igv = 18;
        return s;
      });
      detail.items = items;
      var penalties = [];

      if (paymentPenalties) {
        penalties = paymentPenalties.map(function (s) {
          s.sale_unit_price = penalty || 0;
          s.percentage_igv = 18;
          return s;
        });
      }

      detail.penalties = penalties;
      this.$emit("createFormRegister", {
        detail: detail
      });
      items = [].concat(_toConsumableArray(items), _toConsumableArray(penalties));
      var _this$plan = this.plan,
          name = _this$plan.name,
          description = _this$plan.description;
      var _this$member = this.member,
          parent = _this$member.parent,
          person = _this$member.person;
      var observation = "".concat(name, " - ").concat(description, " ").toUpperCase();
      console.log(items);
      this.$emit("updateItems", items);
      this.$emit("updateObservation", observation);
      this.$emit("updateCustomer", parent.person);
    },
    getTables: function getTables() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                setTimeout(function () {
                  _this.plan.total = _this.services.reduce(function (a, b) {
                    return a + parseFloat(b.price);
                  }, 0);
                  _this.form.plan_id = _this.plan.id;

                  _this.$forceUpdate();

                  _this.updateTotal();
                }, 250);

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-46ad24ce\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/payment_incomplete.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "card" }, [
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-12" },
        [
          _c("label", { staticClass: "label-control w-100" }, [_vm._v("Plan")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              attrs: { disabled: "" },
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
          )
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-46ad24ce", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=222.js.map