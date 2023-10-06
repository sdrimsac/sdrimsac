webpackJsonp([137],{

/***/ "./modules/College/Resources/assets/js/components/payment_form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-35cd8734\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/components/payment_form.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/payment_form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-35cd8734\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/payment_form.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "modules/College/Resources/assets/js/components/payment_form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-35cd8734", Component.options)
  } else {
    hotAPI.reload("data-v-35cd8734", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/payment_form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_moment__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


var PaymentCollege = function PaymentCollege() {
  return __webpack_require__.e/* import() */(127/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/payment_college.vue"));
};

var ShowPaymentsForm = function ShowPaymentsForm() {
  return __webpack_require__.e/* import() */(224).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/show_payments.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    PaymentCollege: PaymentCollege,
    ShowPaymentsForm: ShowPaymentsForm
  },
  props: ["member", "showDialog", "title"],
  data: function data() {
    return {
      showPayment: false,
      loading: false,
      registers: [],
      resource: "registers",
      planForm: null,
      registerForm: null,
      servicesForm: [],
      paymentsForm: [],
      memberForm: null,
      showPayments: false,
      payableForm: null,
      date: __WEBPACK_IMPORTED_MODULE_1_moment___default()(),
      titlePayment: ""
    };
  },
  methods: {
    openFormPayments: function openFormPayments(record) {
      this.showPayments = true;
      this.paymentsForm = record.payments;

      var _record$payments = _slicedToArray(record.payments, 1),
          payment = _record$payments[0];

      if (payment) {
        var document = payment.document,
            sale_note = payment.sale_note;
        var doct = document !== null && document !== void 0 ? document : sale_note;
        console.log(doct);

        var _doct$items = _slicedToArray(doct.items, 1),
            item = _doct$items[0];

        var name = item.item.description;
        this.titlePayment = "Pagos de ".concat(name);
      } else {
        this.titlePayment = "Pagos de ".concat(this.member.person.name);
      }
    },
    getRecords: function getRecords() {
      this.getRegisters();
      this.$emit("getRecords");
    },
    openFormPayment: function openFormPayment(record) {
      this.planForm = record.plan;
      this.registerForm = record;
      this.servicesForm = record.services;
      this.memberForm = this.member;
      this.payableForm = record.total - record.paid;
      this.showPayment = true;
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    open: function open() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this.getRegisters();

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    checkPenalty: function checkPenalty(plan, month, date) {
      var penalties = [];
      var total = plan.total,
          penalty = plan.penalty,
          payment_date = plan.payment_date;
      if (!penalty) return;
      var paymentDay = payment_date.split("-")[2]; // let date = moment(
      //     `${month}-${paymentDay}-${this.date.format("Y")}`
      // );

      if (this.date.isAfter(date)) {
        if (penalty) {
          var percentage = penalty.percentage,
              type = penalty.type;
          percentage = type == "percentage" ? Number(percentage) / 100 : Number(percentage);
          var totalPerDay = type == "percentage" ? total * percentage : percentage;
          var days = this.date.diff(date, "days");
          penalties.push(days * totalPerDay);
        }
      }

      return penalties.reduce(function (a, b) {
        return a + b;
      }, 0);
    },
    getRegisters: function getRegisters() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _this2.loading = true;
                _context2.next = 4;
                return _this2.$http("/college/".concat(_this2.resource, "/records?member_id=").concat(_this2.member.id));

              case 4:
                response = _context2.sent;

                if (response.status == 200) {
                  data = response.data.data;
                  _this2.registers = data.map(function (d) {
                    if (d.payments.length > 0) {
                      var lastPayment = d.payments[d.payments.length - 1];
                      var _lastPayment$details = lastPayment.details,
                          items = _lastPayment$details.items,
                          penalties = _lastPayment$details.penalties;
                      var penaltiesAmount = 0;

                      if (penalties) {
                        penaltiesAmount = penalties.reduce(function (a, b) {
                          return a + Number(b.sale_unit_price);
                        }, 0);
                      }

                      var itemsAmount = 0;
                      itemsAmount = items.reduce(function (a, b) {
                        return a + Number(b.sale_unit_price);
                      }, 0);
                      d.rest = itemsAmount + (penaltiesAmount || 0) - (lastPayment.document ? lastPayment.document.total : lastPayment.sale_note.total);
                      console.log(d.rest);
                    }

                    d.paid = d.payments.reduce(function (a, b) {
                      if (b.sale_note) {
                        return a + parseFloat(b.sale_note.total);
                      } else {
                        return a + parseFloat(b.document.total);
                      }
                    }, 0); // let times = d.plan.period.default_count;

                    d.total = d.services.reduce(function (a, b) {
                      return a + parseFloat(b.price);
                    }, 0);
                    var months = d.payments.reduce(function (a, b) {
                      return a + b.months.length;
                    }, 0);
                    d.total = d.total * (months == 0 ? 1 : months);

                    if (d.plan.penalty) {
                      var payment = d.payments[d.payments.length - 1];

                      if (payment) {
                        var created_at = payment.created_at;
                        var date = __WEBPACK_IMPORTED_MODULE_1_moment___default()(created_at);

                        if (payment.months.length != 0) {
                          var month = payment.months[0];
                          d.penalty = _this2.checkPenalty(d.plan, month.month, date);
                        }
                      }
                    }

                    return d;
                  });
                }

                _context2.next = 11;
                break;

              case 8:
                _context2.prev = 8;
                _context2.t0 = _context2["catch"](0);
                console.log(_context2.t0);

              case 11:
                _context2.prev = 11;
                _this2.loading = false;
                return _context2.finish(11);

              case 14:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[0, 8, 11, 14]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-35cd8734\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/components/payment_form.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.el-dialog__body{\r\n    word-break: normal;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/modules/College/Resources/assets/js/components/modules/College/Resources/assets/js/components/payment_form.vue"],"names":[],"mappings":";AAuFA;IACA,mBAAA;CACA","file":"payment_form.vue","sourcesContent":["<template>\r\n    <el-dialog\r\n        :visible=\"showDialog\"\r\n        close-on-click-modal\r\n        append-to-body\r\n        @open=\"open\"\r\n        @close=\"close\"\r\n        v-loading=\"loading\"\r\n        :title=\"title\"\r\n        width=\"75%\"\r\n        class=\"no_break_word\"\r\n    >\r\n    <div class=\"table-responsive\">\r\n              <table class=\"table table-striped\">\r\n            <thead>\r\n                <tr>\r\n                    <th>#</th>\r\n                    <th>Plan</th>\r\n                    <th>Pagado</th>\r\n                    <th>Deuda</th>\r\n                    <th>Penalidad</th>\r\n                    <th>Total</th>\r\n                    <th></th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                <tr v-for=\"(payment, idx) in registers\" :key=\"idx\">\r\n                    <td>{{ idx + 1 }}</td>\r\n                    <td>\r\n                        {{ payment.plan.name }}-{{ payment.plan.description }}\r\n                    </td>\r\n                    <td>\r\n                        {{ payment.paid.toFixed(2) }}\r\n                    </td>\r\n                    <td>\r\n                        {{ (payment.rest || 0).toFixed(2) }}\r\n                    </td>\r\n                    <td v-if=\"payment.penalty\">\r\n                        {{ payment.penalty.toFixed(2) }}\r\n                    </td>\r\n                    <td v-else>-</td>\r\n                    <td v-if=\"payment.penalty\">\r\n                        {{ (payment.penalty + (payment.rest || 0)).toFixed(2) }}\r\n                    </td>\r\n                    <td v-else>\r\n                        {{ (payment.rest || 0).toFixed(2) }}\r\n                    </td>\r\n                    <td>\r\n                        <el-button\r\n                            v-if=\"payment.payments.length != 0\"\r\n                            type=\"primary\"\r\n                            @click=\"openFormPayments(payment)\"\r\n                        >\r\n                            Ver Pagos\r\n                        </el-button>\r\n                        <el-button\r\n                            v-if=\"payment.rest > 0\"\r\n                            type=\"success\"\r\n                            @click=\"openFormPayment(payment)\"\r\n                        >\r\n                            Pagar\r\n                        </el-button>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </div>\r\n        <payment-college\r\n            type=\"incomplete\"\r\n            :plan=\"planForm\"\r\n            :register.sync=\"registerForm\"\r\n            :is_payment.sync=\"showPayment\"\r\n            @getRecords=\"getRecords\"\r\n            :services=\"servicesForm\"\r\n            :member=\"memberForm\"\r\n            :payable=\"payableForm\"\r\n        >\r\n        </payment-college>\r\n        <show-payments-form\r\n            :title.sync=\"titlePayment\"\r\n            :showDialog.sync=\"showPayments\"\r\n            :payments=\"paymentsForm\"\r\n        >\r\n        </show-payments-form>\r\n    </el-dialog>\r\n</template>\r\n<style>\r\n.el-dialog__body{\r\n    word-break: normal;\r\n}\r\n</style>\r\n<script>\r\nimport moment from \"moment\";\r\nconst PaymentCollege = () => import(\"../components/payment_college.vue\");\r\nconst ShowPaymentsForm = () => import(\"../components/show_payments.vue\");\r\nexport default {\r\n    components: { PaymentCollege, ShowPaymentsForm },\r\n    props: [\"member\", \"showDialog\", \"title\"],\r\n    data() {\r\n        return {\r\n            showPayment: false,\r\n            loading: false,\r\n            registers: [],\r\n            resource: \"registers\",\r\n            planForm: null,\r\n            registerForm: null,\r\n            servicesForm: [],\r\n            paymentsForm: [],\r\n            memberForm: null,\r\n            showPayments: false,\r\n            payableForm: null,\r\n            date: moment(),\r\n            titlePayment: \"\"\r\n        };\r\n    },\r\n    methods: {\r\n        openFormPayments(record) {\r\n            this.showPayments = true;\r\n            this.paymentsForm = record.payments;\r\n            let [payment] = record.payments;\r\n            if (payment) {\r\n                let { document, sale_note } = payment;\r\n                let doct = document ?? sale_note;\r\n                console.log(doct);\r\n                let [item] = doct.items;\r\n                let name = item.item.description;\r\n                this.titlePayment = `Pagos de ${name}`;\r\n            } else {\r\n                this.titlePayment = `Pagos de ${this.member.person.name}`;\r\n            }\r\n        },\r\n        getRecords() {\r\n            this.getRegisters();\r\n            this.$emit(\"getRecords\");\r\n        },\r\n        openFormPayment(record) {\r\n            this.planForm = record.plan;\r\n            this.registerForm = record;\r\n            this.servicesForm = record.services;\r\n            this.memberForm = this.member;\r\n            this.payableForm = record.total - record.paid;\r\n            this.showPayment = true;\r\n        },\r\n        close() {\r\n            this.$emit(\"update:showDialog\", false);\r\n        },\r\n        async open() {\r\n            await this.getRegisters();\r\n        },\r\n\r\n        checkPenalty(plan, month, date) {\r\n            let penalties = [];\r\n            let { total, penalty, payment_date } = plan;\r\n            if (!penalty) return;\r\n            let paymentDay = payment_date.split(\"-\")[2];\r\n            // let date = moment(\r\n            //     `${month}-${paymentDay}-${this.date.format(\"Y\")}`\r\n            // );\r\n            if (this.date.isAfter(date)) {\r\n                if (penalty) {\r\n                    let { percentage, type } = penalty;\r\n                    percentage =\r\n                        type == \"percentage\"\r\n                            ? Number(percentage) / 100\r\n                            : Number(percentage);\r\n                    let totalPerDay =\r\n                        type == \"percentage\" ? total * percentage : percentage;\r\n                    let days = this.date.diff(date, \"days\");\r\n                    penalties.push(days * totalPerDay);\r\n                }\r\n            }\r\n\r\n            return penalties.reduce((a, b) => a + b, 0);\r\n        },\r\n        async getRegisters() {\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http(\r\n                    `/college/${this.resource}/records?member_id=${this.member.id}`\r\n                );\r\n                if (response.status == 200) {\r\n                    const { data } = response.data;\r\n\r\n                    this.registers = data.map(d => {\r\n                        if (d.payments.length > 0) {\r\n                            let lastPayment = d.payments[d.payments.length - 1];\r\n                            let { items, penalties } = lastPayment.details;\r\n                            let penaltiesAmount = 0;\r\n                            if (penalties) {\r\n                                penaltiesAmount = penalties.reduce(\r\n                                    (a, b) => a + Number(b.sale_unit_price),\r\n                                    0\r\n                                );\r\n                            }\r\n                            let itemsAmount = 0;\r\n                            itemsAmount = items.reduce(\r\n                                (a, b) => a + Number(b.sale_unit_price),\r\n                                0\r\n                            );\r\n                            d.rest =\r\n                                itemsAmount +\r\n                                (penaltiesAmount || 0) -\r\n                                (lastPayment.document\r\n                                    ? lastPayment.document.total\r\n                                    : lastPayment.sale_note.total);\r\n                            console.log(d.rest);\r\n                        }\r\n\r\n                        d.paid = d.payments.reduce((a, b) => {\r\n                            if (b.sale_note) {\r\n                                return a + parseFloat(b.sale_note.total);\r\n                            } else {\r\n                                return a + parseFloat(b.document.total);\r\n                            }\r\n                        }, 0);\r\n                        // let times = d.plan.period.default_count;\r\n                        d.total = d.services.reduce(\r\n                            (a, b) => a + parseFloat(b.price),\r\n                            0\r\n                        );\r\n                        let months = d.payments.reduce(\r\n                            (a, b) => a + b.months.length,\r\n                            0\r\n                        );\r\n                        d.total = d.total * (months == 0 ? 1 : months);\r\n                        if (d.plan.penalty) {\r\n                            let payment = d.payments[d.payments.length - 1];\r\n                            if (payment) {\r\n                                let { created_at } = payment;\r\n                                let date = moment(created_at);\r\n                                if (payment.months.length != 0) {\r\n                                    let month = payment.months[0];\r\n                                    d.penalty = this.checkPenalty(\r\n                                        d.plan,\r\n                                        month.month,\r\n                                        date\r\n                                    );\r\n                                }\r\n                            }\r\n                        }\r\n\r\n                        return d;\r\n                    });\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-35cd8734\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/payment_form.vue":
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
      staticClass: "no_break_word",
      attrs: {
        visible: _vm.showDialog,
        "close-on-click-modal": "",
        "append-to-body": "",
        title: _vm.title,
        width: "75%"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "table-responsive" }, [
        _c("table", { staticClass: "table table-striped" }, [
          _c("thead", [
            _c("tr", [
              _c("th", [_vm._v("#")]),
              _vm._v(" "),
              _c("th", [_vm._v("Plan")]),
              _vm._v(" "),
              _c("th", [_vm._v("Pagado")]),
              _vm._v(" "),
              _c("th", [_vm._v("Deuda")]),
              _vm._v(" "),
              _c("th", [_vm._v("Penalidad")]),
              _vm._v(" "),
              _c("th", [_vm._v("Total")]),
              _vm._v(" "),
              _c("th")
            ])
          ]),
          _vm._v(" "),
          _c(
            "tbody",
            _vm._l(_vm.registers, function(payment, idx) {
              return _c("tr", { key: idx }, [
                _c("td", [_vm._v(_vm._s(idx + 1))]),
                _vm._v(" "),
                _c("td", [
                  _vm._v(
                    "\n                    " +
                      _vm._s(payment.plan.name) +
                      "-" +
                      _vm._s(payment.plan.description) +
                      "\n                "
                  )
                ]),
                _vm._v(" "),
                _c("td", [
                  _vm._v(
                    "\n                    " +
                      _vm._s(payment.paid.toFixed(2)) +
                      "\n                "
                  )
                ]),
                _vm._v(" "),
                _c("td", [
                  _vm._v(
                    "\n                    " +
                      _vm._s((payment.rest || 0).toFixed(2)) +
                      "\n                "
                  )
                ]),
                _vm._v(" "),
                payment.penalty
                  ? _c("td", [
                      _vm._v(
                        "\n                    " +
                          _vm._s(payment.penalty.toFixed(2)) +
                          "\n                "
                      )
                    ])
                  : _c("td", [_vm._v("-")]),
                _vm._v(" "),
                payment.penalty
                  ? _c("td", [
                      _vm._v(
                        "\n                    " +
                          _vm._s(
                            (payment.penalty + (payment.rest || 0)).toFixed(2)
                          ) +
                          "\n                "
                      )
                    ])
                  : _c("td", [
                      _vm._v(
                        "\n                    " +
                          _vm._s((payment.rest || 0).toFixed(2)) +
                          "\n                "
                      )
                    ]),
                _vm._v(" "),
                _c(
                  "td",
                  [
                    payment.payments.length != 0
                      ? _c(
                          "el-button",
                          {
                            attrs: { type: "primary" },
                            on: {
                              click: function($event) {
                                return _vm.openFormPayments(payment)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                        Ver Pagos\n                    "
                            )
                          ]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    payment.rest > 0
                      ? _c(
                          "el-button",
                          {
                            attrs: { type: "success" },
                            on: {
                              click: function($event) {
                                return _vm.openFormPayment(payment)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                        Pagar\n                    "
                            )
                          ]
                        )
                      : _vm._e()
                  ],
                  1
                )
              ])
            }),
            0
          )
        ])
      ]),
      _vm._v(" "),
      _c("payment-college", {
        attrs: {
          type: "incomplete",
          plan: _vm.planForm,
          register: _vm.registerForm,
          is_payment: _vm.showPayment,
          services: _vm.servicesForm,
          member: _vm.memberForm,
          payable: _vm.payableForm
        },
        on: {
          "update:register": function($event) {
            _vm.registerForm = $event
          },
          "update:is_payment": function($event) {
            _vm.showPayment = $event
          },
          getRecords: _vm.getRecords
        }
      }),
      _vm._v(" "),
      _c("show-payments-form", {
        attrs: {
          title: _vm.titlePayment,
          showDialog: _vm.showPayments,
          payments: _vm.paymentsForm
        },
        on: {
          "update:title": function($event) {
            _vm.titlePayment = $event
          },
          "update:showDialog": function($event) {
            _vm.showPayments = $event
          },
          "update:show-dialog": function($event) {
            _vm.showPayments = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-35cd8734", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-35cd8734\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/components/payment_form.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-35cd8734\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/components/payment_form.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("511ea324", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-35cd8734\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./payment_form.vue", function() {
     var newContent = require("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-35cd8734\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./payment_form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=137.js.map