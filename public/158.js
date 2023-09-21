webpackJsonp([158],{

/***/ "./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7afef8c0\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7afef8c0\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/cash/closecash.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7afef8c0", Component.options)
  } else {
    hotAPI.reload("data-v-7afef8c0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__resources_js_mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//'../../../../components/DataTable.vue'
 ///mixins/deletable'

/* harmony default export */ __webpack_exports__["default"] = ({
  mixins: [__WEBPACK_IMPORTED_MODULE_1__resources_js_mixins_deletable__["a" /* deletable */]],
  props: ["showDialogClose", "recordId", "fromBox", "configuration"],
  data: function data() {
    return {
      total: 0,
      count: {},
      showDialog: false,
      open_cash: true,
      errors: {},
      resource: "caja/worker/cash",
      date_closed: moment().format("YYYY-MM-DD"),
      date_start: moment().format("YYYY-MM-DD"),
      month_start: moment().format("YYYY-MM"),
      final_balance: 0,
      cash: null,
      loading: false,
      totalSales: 0,
      totalCoins: 0,
      totalBills: 0,
      difference: 0
    };
  },
  methods: {
    returnTextObfuscated: function returnTextObfuscated(text) {
      var textObfuscated = "";

      for (var i = 0; i < text.length; i++) {
        textObfuscated += "*";
      }

      return textObfuscated;
    },
    ocultarBoton: function ocultarBoton() {
      this.$emit("ocultarBoton");
    },
    sumCount: function sumCount() {
      this.totalCoins = 0;
      this.totalBills = 0;
      var sum = 0;

      for (var amount in this.count) {
        if (this.count[amount] > 0) {
          sum += (Number(this.count[amount]) || 0) * (Number(amount) || 0);

          if (Number(amount) > 5) {
            this.totalBills += (Number(this.count[amount]) || 0) * (Number(amount) || 0);
          } else {
            this.totalCoins += (Number(this.count[amount]) || 0) * (Number(amount) || 0);
          }
        } else {
          delete this.count[amount];
        }
      }

      return sum;
    },
    updateFinalBalance: function updateFinalBalance(quantity, value) {
      var isCoin = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
      this.count[value.toString()] = quantity;
      this.final_balance = _.round(this.sumCount(), 2);
      this.difference = (this.totalSales - this.final_balance).toFixed(2);
    },
    clickCloseCash: function clickCloseCash() {
      var _this = this;

      var h = this.$createElement;
      this.$msgbox({
        title: "Cerrar caja",
        type: "warning",
        message: h("p", null, [h("p", {
          style: "text-align: justify; font-size:15px"
        }, "".concat(this.difference == 0 ? "¿Está seguro de cerrar la caja?" : "¿Está seguro de cerrar la caja,  sin realizar el conteo en efectivo?"))]),
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        beforeClose: function beforeClose(action, instance, done) {
          if (action === "confirm") {
            //  console.log(this.count);
            _this.createRegister(instance, done);
          } else {
            done();
          }
        }
      }).then(function (action) {})["catch"](function (action) {});
    },
    dateclosed: function dateclosed() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.totalCoins = 0;
                _this2.totalBills = 0;
                _context.prev = 2;
                _this2.loading = true;
                _context.next = 6;
                return _this2.$http.get("/caja/worker/totales_sales?cash_id=".concat(_this2.recordId, "&only_cash=1"));

              case 6:
                response = _context.sent;

                if (response.status == 200) {
                  data = response.data;
                  _this2.totalSales = data.total_sales;
                }

                _context.next = 13;
                break;

              case 10:
                _context.prev = 10;
                _context.t0 = _context["catch"](2);
                console.log(_context.t0);

              case 13:
                _context.prev = 13;
                _this2.loading = false;
                return _context.finish(13);

              case 16:
                _this2.difference = (_this2.totalSales - _this2.final_balance).toFixed(2);

              case 17:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[2, 10, 13, 16]]);
      }))();
    },
    closeDialog: function closeDialog() {
      this.$emit("update:showDialogClose", false);
      this.count = {};
      this.final_balance = 0;
    },
    createRegister: function createRegister(instance, done) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var body, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                body = {
                  id: _this3.recordId,
                  final_balance: _this3.final_balance,
                  counter: _this3.count,
                  difference: _this3.difference
                };
                _context2.prev = 1;
                _context2.next = 4;
                return _this3.$http.post("/".concat(_this3.resource, "/close"), body);

              case 4:
                response = _context2.sent;

                if (response.data.success) {
                  _this3.$eventHub.$emit("reloadData");

                  _this3.open_cash = true;

                  _this3.$toast.success(response.data.message);

                  _this3.ocultarBoton();

                  if (_this3.fromBox) {
                    _this3.$emit("updateCashId", null);
                  }
                } else {
                  console.log(response);
                }

                _context2.next = 11;
                break;

              case 8:
                _context2.prev = 8;
                _context2.t0 = _context2["catch"](1);
                console.log(_context2.t0);

              case 11:
                _context2.prev = 11;
                instance.confirmButtonLoading = false;
                instance.confirmButtonText = "Iniciar prueba";
                done();
                return _context2.finish(11);

              case 16:
                instance.confirmButtonText = "Cerrando caja...";
                window.open("/caja/report-boxes/reports_resumen_type?cash_id=".concat(_this3.recordId), "_blank");

                _this3.closeDialog();

              case 19:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[1, 8, 11, 16]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7afef8c0\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.text-danger-difference .el-input__inner {\r\n    color: red !important;\n}\r\n/* .el-input__inner {\r\n    padding: 0 25px !important;\r\n} */\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/modules/Restaurant/Resources/assets/js/views/cash/modules/Restaurant/Resources/assets/js/views/cash/closecash.vue"],"names":[],"mappings":";AAoeA;IACA,sBAAA;CACA;AACA;;IAEA","file":"closecash.vue","sourcesContent":["<template>\r\n    <div>\r\n        <div class=\"row\">\r\n            <el-dialog\r\n                title=\"Cierra de Caja - Contador de dinero\"\r\n                :visible.sync=\"showDialogClose\"\r\n                @open=\"dateclosed\"\r\n                :before-close=\"closeDialog\"\r\n            >\r\n                <div class=\"row\">\r\n                    <div class=\"col-md-6\">\r\n                        <div\r\n                            class=\"form-group\"\r\n                            :class=\"{\r\n                                'has-danger': errors.date_closed\r\n                            }\"\r\n                        >\r\n                            <label class=\"control-label disabled w-100\"\r\n                                >Fecha\r\n                            </label>\r\n                            <h3>\r\n                                {{ date_closed }}\r\n                            </h3>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"col-md-6\">\r\n                        <div\r\n                            class=\"form-group\"\r\n                            v-if=\"configuration.view_daily_cash ||  configuration.view_daily_cash_pin\"\r\n                        >\r\n                            <label class=\"control-label disabled w-100\"\r\n                                >Total V. Efectivo</label\r\n                            >\r\n                            <template v-if=\"configuration.view_daily_cash_pin\">\r\n                                <h3>\r\n                                    {{\r\n                                        returnTextObfuscated(\r\n                                            \"123456\"\r\n                                        )\r\n                                    }}\r\n                                </h3>\r\n                            </template>\r\n                            <template v-else>\r\n                                <h3>{{ totalSales.toFixed(2) }}</h3>\r\n                            </template>\r\n                            <!-- <el-input :value=\"totalSales\"> </el-input> -->\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                    <div class=\"col-md-6\">\r\n                        <table class=\"table-responsive table\">\r\n                            <thead>\r\n                                <tr>\r\n                                    <th\r\n                                        style=\"vertical-align:bottom;text-align:center;\"\r\n                                    >\r\n                                        <img\r\n                                            width=\"75px\"\r\n                                            height=\"50px\"\r\n                                            src=\"/billetes.png\"\r\n                                            alt=\"billete\"\r\n                                        />\r\n                                    </th>\r\n                                    <th\r\n                                        style=\"vertical-align:bottom;text-align:center;\"\r\n                                    >\r\n                                        UND\r\n                                    </th>\r\n                                    <th\r\n                                        style=\"vertical-align:bottom;text-align:center;\"\r\n                                    >\r\n                                        TOTAL\r\n                                    </th>\r\n                                </tr>\r\n                            </thead>\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>10.00</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['10']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['10'],\r\n                                                    10\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                (\r\n                                                    (count[\"10\"] || 0) * 10\r\n                                                ).toFixed(2)\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>20.00</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['20']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['20'],\r\n                                                    20\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                (\r\n                                                    (count[\"20\"] || 0) * 20\r\n                                                ).toFixed(2)\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>50.00</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['50']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['50'],\r\n                                                    50\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                (\r\n                                                    (count[\"50\"] || 0) * 50\r\n                                                ).toFixed(2)\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>100.00</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['100']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['100'],\r\n                                                    100\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                (\r\n                                                    (count[\"100\"] || 0) * 100\r\n                                                ).toFixed(2)\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>200.00</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['200']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['200'],\r\n                                                    200\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                (\r\n                                                    (count[\"200\"] || 0) * 200\r\n                                                ).toFixed(2)\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                            </tbody>\r\n                            <tfoot>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>TOTAL</h3>\r\n                                    </td>\r\n                                    <td></td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>{{ totalBills.toFixed(2) }}</h6>\r\n                                    </td>\r\n                                </tr>\r\n                            </tfoot>\r\n                        </table>\r\n                    </div>\r\n                    <div class=\"col-md-6\">\r\n                        <table class=\"table-responsive table\">\r\n                            <thead>\r\n                                <tr>\r\n                                    <th\r\n                                        style=\"vertical-align:bottom;text-align:center;\"\r\n                                    >\r\n                                        <img\r\n                                            width=\"75px\"\r\n                                            height=\"50px\"\r\n                                            src=\"/monedas.png\"\r\n                                            alt=\"monedas\"\r\n                                        />\r\n                                    </th>\r\n                                    <th\r\n                                        style=\"vertical-align:bottom;text-align:center;\"\r\n                                    >\r\n                                        UND\r\n                                    </th>\r\n                                    <th\r\n                                        style=\"vertical-align:bottom;text-align:center;\"\r\n                                    >\r\n                                        TOTAL\r\n                                    </th>\r\n                                </tr>\r\n                            </thead>\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>0.10</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['0.1']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['0.1'],\r\n                                                    0.1,\r\n                                                    true\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                (\r\n                                                    (count[\"0.1\"] || 0) * 0.1\r\n                                                ).toFixed(2)\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>0.20</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['0.2']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['0.2'],\r\n                                                    0.2,\r\n                                                    true\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                (\r\n                                                    (count[\"0.2\"] || 0) * 0.2\r\n                                                ).toFixed(2)\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>0.50</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['0.5']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['0.5'],\r\n                                                    0.5,\r\n                                                    true\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                (\r\n                                                    (count[\"0.5\"] || 0) * 0.5\r\n                                                ).toFixed(2)\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>1.00</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['1']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['1'],\r\n                                                    1,\r\n                                                    true\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                ((count[\"1\"] || 0) * 1).toFixed(\r\n                                                    2\r\n                                                )\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>2.00</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['2']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['2'],\r\n                                                    2,\r\n                                                    true\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                ((count[\"2\"] || 0) * 2).toFixed(\r\n                                                    2\r\n                                                )\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>5.00</h3>\r\n                                    </td>\r\n                                    <td>\r\n                                        <el-input\r\n                                            placeholder=\"0\"\r\n                                            v-model=\"count['5']\"\r\n                                            @input=\"\r\n                                                updateFinalBalance(\r\n                                                    count['5'],\r\n                                                    5,\r\n                                                    true\r\n                                                )\r\n                                            \"\r\n                                        >\r\n                                        </el-input>\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>\r\n                                            {{\r\n                                                ((count[\"5\"] || 0) * 5).toFixed(\r\n                                                    2\r\n                                                )\r\n                                            }}\r\n                                        </h6>\r\n                                    </td>\r\n                                </tr>\r\n                            </tbody>\r\n                            <tfoot>\r\n                                <tr>\r\n                                    <td class=\"text-center\">\r\n                                        <h3>TOTAL</h3>\r\n                                    </td>\r\n                                    <td></td>\r\n                                    <td class=\"text-center\">\r\n                                        <h6>{{ totalCoins.toFixed(2) }}</h6>\r\n                                    </td>\r\n                                </tr>\r\n                            </tfoot>\r\n                        </table>\r\n                    </div>\r\n                </div>\r\n\r\n                <div class=\"row\">\r\n                    <div class=\"col-md-4\">\r\n                        <label class=\"w-100\">\r\n                            Total Efectivo\r\n                        </label>\r\n                        <el-input :value=\"final_balance.toFixed(2)\" readonly>\r\n                        </el-input>\r\n                    </div>\r\n                    <div v-if=\"configuration.view_daily_cash ||  configuration.view_daily_cash_pin\" class=\"col-md-4\">\r\n                        <label class=\"w-100\">\r\n                            Diferencia\r\n                        </label>\r\n                        <template v-if=\"configuration.view_daily_cash_pin\">\r\n                            <el-input\r\n                                :value=\"\r\n                                    returnTextObfuscated('123456')\"\r\n                                readonly\r\n                            >\r\n                            </el-input>\r\n                        </template>\r\n                        <template v-else>\r\n                            <el-input\r\n                                :class=\"\r\n                                    `${\r\n                                        difference < 0\r\n                                            ? 'text-danger-difference'\r\n                                            : ''\r\n                                    }`\r\n                                \"\r\n                                :value=\"difference\"\r\n                                readonly\r\n                            >\r\n                            </el-input>\r\n                        </template>\r\n                    </div>\r\n                </div>\r\n                <span slot=\"footer\" class=\"dialog-footer\">\r\n                    <el-button @click=\"closeDialog()\">Cerrar</el-button>\r\n                    <el-button type=\"primary\" @click=\"clickCloseCash\"\r\n                        >Guardar</el-button\r\n                    >\r\n                </span>\r\n            </el-dialog>\r\n        </div>\r\n    </div>\r\n</template>\r\n<style>\r\n.text-danger-difference .el-input__inner {\r\n    color: red !important;\r\n}\r\n/* .el-input__inner {\r\n    padding: 0 25px !important;\r\n} */\r\n</style>\r\n<script>\r\n//'../../../../components/DataTable.vue'\r\nimport { deletable } from \"../../../../../../../resources/js/mixins/deletable\";\r\n///mixins/deletable'\r\n\r\nexport default {\r\n    mixins: [deletable],\r\n    props: [\"showDialogClose\", \"recordId\", \"fromBox\", \"configuration\"],\r\n    data() {\r\n        return {\r\n            total: 0,\r\n            count: {},\r\n            showDialog: false,\r\n            open_cash: true,\r\n            errors: {},\r\n            resource: \"caja/worker/cash\",\r\n            date_closed: moment().format(\"YYYY-MM-DD\"),\r\n            date_start: moment().format(\"YYYY-MM-DD\"),\r\n            month_start: moment().format(\"YYYY-MM\"),\r\n            final_balance: 0,\r\n            cash: null,\r\n            loading: false,\r\n            totalSales: 0,\r\n            totalCoins: 0,\r\n            totalBills: 0,\r\n            difference: 0\r\n        };\r\n    },\r\n\r\n    methods: {\r\n                returnTextObfuscated(text){\r\n            let textObfuscated = \"\";\r\n            for (let i = 0; i < text.length; i++) {\r\n                textObfuscated += \"*\";\r\n            }\r\n            return textObfuscated;\r\n        },\r\n        ocultarBoton() {\r\n            this.$emit(\"ocultarBoton\");\r\n        },\r\n        sumCount() {\r\n            this.totalCoins = 0;\r\n            this.totalBills = 0;\r\n            let sum = 0;\r\n            for (const amount in this.count) {\r\n                if (this.count[amount] > 0) {\r\n                    sum +=\r\n                        (Number(this.count[amount]) || 0) *\r\n                        (Number(amount) || 0);\r\n                    if (Number(amount) > 5) {\r\n                        this.totalBills +=\r\n                            (Number(this.count[amount]) || 0) *\r\n                            (Number(amount) || 0);\r\n                    } else {\r\n                        this.totalCoins +=\r\n                            (Number(this.count[amount]) || 0) *\r\n                            (Number(amount) || 0);\r\n                    }\r\n                } else {\r\n                    delete this.count[amount];\r\n                }\r\n            }\r\n\r\n            return sum;\r\n        },\r\n        updateFinalBalance(quantity, value, isCoin = false) {\r\n            this.count[value.toString()] = quantity;\r\n            this.final_balance = _.round(this.sumCount(), 2);\r\n            this.difference = (this.totalSales - this.final_balance).toFixed(2);\r\n        },\r\n        clickCloseCash() {\r\n            const h = this.$createElement;\r\n            this.$msgbox({\r\n                title: \"Cerrar caja\",\r\n                type: \"warning\",\r\n                message: h(\"p\", null, [\r\n                    h(\r\n                        \"p\",\r\n                        { style: \"text-align: justify; font-size:15px\" },\r\n                        `${\r\n                            this.difference == 0\r\n                                ? \"¿Está seguro de cerrar la caja?\"\r\n                                : \"¿Está seguro de cerrar la caja,  sin realizar el conteo en efectivo?\"\r\n                        }`\r\n                    )\r\n                ]),\r\n\r\n                showCancelButton: true,\r\n                confirmButtonText: \"Aceptar\",\r\n                cancelButtonText: \"Cancelar\",\r\n                beforeClose: (action, instance, done) => {\r\n                    if (action === \"confirm\") {\r\n                        //  console.log(this.count);\r\n                        this.createRegister(instance, done);\r\n                    } else {\r\n                        done();\r\n                    }\r\n                }\r\n            })\r\n                .then(action => {})\r\n                .catch(action => {});\r\n        },\r\n        async dateclosed() {\r\n            this.totalCoins = 0;\r\n            this.totalBills = 0;\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.get(\r\n                    `/caja/worker/totales_sales?cash_id=${this.recordId}&only_cash=1`\r\n                );\r\n                if (response.status == 200) {\r\n                    const { data } = response;\r\n                    this.totalSales = data.total_sales;\r\n                }\r\n            } catch (error) {\r\n                console.log(error);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n            this.difference = (this.totalSales - this.final_balance).toFixed(2);\r\n        },\r\n        closeDialog() {\r\n            this.$emit(\"update:showDialogClose\", false);\r\n            this.count = {};\r\n            this.final_balance = 0;\r\n        },\r\n        async createRegister(instance, done) {\r\n            const body = {\r\n                id: this.recordId,\r\n                final_balance: this.final_balance,\r\n                counter: this.count,\r\n                difference: this.difference\r\n            };\r\n            try {\r\n                const response = await this.$http.post(\r\n                    `/${this.resource}/close`,\r\n                    body\r\n                );\r\n\r\n                if (response.data.success) {\r\n                    this.$eventHub.$emit(\"reloadData\");\r\n                    this.open_cash = true;\r\n                    this.$toast.success(response.data.message);\r\n                    this.ocultarBoton();\r\n                    if (this.fromBox) {\r\n                        this.$emit(\"updateCashId\", null);\r\n                    }\r\n                } else {\r\n                    console.log(response);\r\n                }\r\n            } catch (error) {\r\n                console.log(error);\r\n            } finally {\r\n                instance.confirmButtonLoading = false;\r\n                instance.confirmButtonText = \"Iniciar prueba\";\r\n                done();\r\n            }\r\n\r\n            instance.confirmButtonText = \"Cerrando caja...\";\r\n            window.open(\r\n                `/caja/report-boxes/reports_resumen_type?cash_id=${this.recordId}`,\r\n                \"_blank\"\r\n            );\r\n            this.closeDialog();\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7afef8c0\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "div",
      { staticClass: "row" },
      [
        _c(
          "el-dialog",
          {
            attrs: {
              title: "Cierra de Caja - Contador de dinero",
              visible: _vm.showDialogClose,
              "before-close": _vm.closeDialog
            },
            on: {
              "update:visible": function($event) {
                _vm.showDialogClose = $event
              },
              open: _vm.dateclosed
            }
          },
          [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-6" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: {
                      "has-danger": _vm.errors.date_closed
                    }
                  },
                  [
                    _c(
                      "label",
                      { staticClass: "control-label disabled w-100" },
                      [_vm._v("Fecha\n                        ")]
                    ),
                    _vm._v(" "),
                    _c("h3", [
                      _vm._v(
                        "\n                            " +
                          _vm._s(_vm.date_closed) +
                          "\n                        "
                      )
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-6" }, [
                _vm.configuration.view_daily_cash ||
                _vm.configuration.view_daily_cash_pin
                  ? _c(
                      "div",
                      { staticClass: "form-group" },
                      [
                        _c(
                          "label",
                          { staticClass: "control-label disabled w-100" },
                          [_vm._v("Total V. Efectivo")]
                        ),
                        _vm._v(" "),
                        _vm.configuration.view_daily_cash_pin
                          ? [
                              _c("h3", [
                                _vm._v(
                                  "\n                                " +
                                    _vm._s(_vm.returnTextObfuscated("123456")) +
                                    "\n                            "
                                )
                              ])
                            ]
                          : [
                              _c("h3", [
                                _vm._v(_vm._s(_vm.totalSales.toFixed(2)))
                              ])
                            ]
                      ],
                      2
                    )
                  : _vm._e()
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-6" }, [
                _c("table", { staticClass: "table-responsive table" }, [
                  _c("thead", [
                    _c("tr", [
                      _c(
                        "th",
                        {
                          staticStyle: {
                            "vertical-align": "bottom",
                            "text-align": "center"
                          }
                        },
                        [
                          _c("img", {
                            attrs: {
                              width: "75px",
                              height: "50px",
                              src: "/billetes.png",
                              alt: "billete"
                            }
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "th",
                        {
                          staticStyle: {
                            "vertical-align": "bottom",
                            "text-align": "center"
                          }
                        },
                        [
                          _vm._v(
                            "\n                                    UND\n                                "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "th",
                        {
                          staticStyle: {
                            "vertical-align": "bottom",
                            "text-align": "center"
                          }
                        },
                        [
                          _vm._v(
                            "\n                                    TOTAL\n                                "
                          )
                        ]
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tbody", [
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("10.00")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["10"],
                                  10
                                )
                              }
                            },
                            model: {
                              value: _vm.count["10"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "10", $$v)
                              },
                              expression: "count['10']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(((_vm.count["10"] || 0) * 10).toFixed(2)) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("20.00")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["20"],
                                  20
                                )
                              }
                            },
                            model: {
                              value: _vm.count["20"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "20", $$v)
                              },
                              expression: "count['20']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(((_vm.count["20"] || 0) * 20).toFixed(2)) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("50.00")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["50"],
                                  50
                                )
                              }
                            },
                            model: {
                              value: _vm.count["50"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "50", $$v)
                              },
                              expression: "count['50']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(((_vm.count["50"] || 0) * 50).toFixed(2)) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("100.00")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["100"],
                                  100
                                )
                              }
                            },
                            model: {
                              value: _vm.count["100"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "100", $$v)
                              },
                              expression: "count['100']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                ((_vm.count["100"] || 0) * 100).toFixed(2)
                              ) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("200.00")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["200"],
                                  200
                                )
                              }
                            },
                            model: {
                              value: _vm.count["200"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "200", $$v)
                              },
                              expression: "count['200']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                ((_vm.count["200"] || 0) * 200).toFixed(2)
                              ) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tfoot", [
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("TOTAL")])
                      ]),
                      _vm._v(" "),
                      _c("td"),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [_vm._v(_vm._s(_vm.totalBills.toFixed(2)))])
                      ])
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-6" }, [
                _c("table", { staticClass: "table-responsive table" }, [
                  _c("thead", [
                    _c("tr", [
                      _c(
                        "th",
                        {
                          staticStyle: {
                            "vertical-align": "bottom",
                            "text-align": "center"
                          }
                        },
                        [
                          _c("img", {
                            attrs: {
                              width: "75px",
                              height: "50px",
                              src: "/monedas.png",
                              alt: "monedas"
                            }
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "th",
                        {
                          staticStyle: {
                            "vertical-align": "bottom",
                            "text-align": "center"
                          }
                        },
                        [
                          _vm._v(
                            "\n                                    UND\n                                "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "th",
                        {
                          staticStyle: {
                            "vertical-align": "bottom",
                            "text-align": "center"
                          }
                        },
                        [
                          _vm._v(
                            "\n                                    TOTAL\n                                "
                          )
                        ]
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tbody", [
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("0.10")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["0.1"],
                                  0.1,
                                  true
                                )
                              }
                            },
                            model: {
                              value: _vm.count["0.1"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "0.1", $$v)
                              },
                              expression: "count['0.1']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                ((_vm.count["0.1"] || 0) * 0.1).toFixed(2)
                              ) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("0.20")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["0.2"],
                                  0.2,
                                  true
                                )
                              }
                            },
                            model: {
                              value: _vm.count["0.2"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "0.2", $$v)
                              },
                              expression: "count['0.2']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                ((_vm.count["0.2"] || 0) * 0.2).toFixed(2)
                              ) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("0.50")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["0.5"],
                                  0.5,
                                  true
                                )
                              }
                            },
                            model: {
                              value: _vm.count["0.5"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "0.5", $$v)
                              },
                              expression: "count['0.5']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                ((_vm.count["0.5"] || 0) * 0.5).toFixed(2)
                              ) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("1.00")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["1"],
                                  1,
                                  true
                                )
                              }
                            },
                            model: {
                              value: _vm.count["1"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "1", $$v)
                              },
                              expression: "count['1']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(((_vm.count["1"] || 0) * 1).toFixed(2)) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("2.00")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["2"],
                                  2,
                                  true
                                )
                              }
                            },
                            model: {
                              value: _vm.count["2"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "2", $$v)
                              },
                              expression: "count['2']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(((_vm.count["2"] || 0) * 2).toFixed(2)) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("5.00")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("el-input", {
                            attrs: { placeholder: "0" },
                            on: {
                              input: function($event) {
                                return _vm.updateFinalBalance(
                                  _vm.count["5"],
                                  5,
                                  true
                                )
                              }
                            },
                            model: {
                              value: _vm.count["5"],
                              callback: function($$v) {
                                _vm.$set(_vm.count, "5", $$v)
                              },
                              expression: "count['5']"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(((_vm.count["5"] || 0) * 5).toFixed(2)) +
                              "\n                                    "
                          )
                        ])
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tfoot", [
                    _c("tr", [
                      _c("td", { staticClass: "text-center" }, [
                        _c("h3", [_vm._v("TOTAL")])
                      ]),
                      _vm._v(" "),
                      _c("td"),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        _c("h6", [_vm._v(_vm._s(_vm.totalCoins.toFixed(2)))])
                      ])
                    ])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c(
                "div",
                { staticClass: "col-md-4" },
                [
                  _c("label", { staticClass: "w-100" }, [
                    _vm._v(
                      "\n                        Total Efectivo\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("el-input", {
                    attrs: { value: _vm.final_balance.toFixed(2), readonly: "" }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _vm.configuration.view_daily_cash ||
              _vm.configuration.view_daily_cash_pin
                ? _c(
                    "div",
                    { staticClass: "col-md-4" },
                    [
                      _c("label", { staticClass: "w-100" }, [
                        _vm._v(
                          "\n                        Diferencia\n                    "
                        )
                      ]),
                      _vm._v(" "),
                      _vm.configuration.view_daily_cash_pin
                        ? [
                            _c("el-input", {
                              attrs: {
                                value: _vm.returnTextObfuscated("123456"),
                                readonly: ""
                              }
                            })
                          ]
                        : [
                            _c("el-input", {
                              class:
                                "" +
                                (_vm.difference < 0
                                  ? "text-danger-difference"
                                  : ""),
                              attrs: { value: _vm.difference, readonly: "" }
                            })
                          ]
                    ],
                    2
                  )
                : _vm._e()
            ]),
            _vm._v(" "),
            _c(
              "span",
              {
                staticClass: "dialog-footer",
                attrs: { slot: "footer" },
                slot: "footer"
              },
              [
                _c(
                  "el-button",
                  {
                    on: {
                      click: function($event) {
                        return _vm.closeDialog()
                      }
                    }
                  },
                  [_vm._v("Cerrar")]
                ),
                _vm._v(" "),
                _c(
                  "el-button",
                  {
                    attrs: { type: "primary" },
                    on: { click: _vm.clickCloseCash }
                  },
                  [_vm._v("Guardar")]
                )
              ],
              1
            )
          ]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7afef8c0", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7afef8c0\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7afef8c0\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("40819eaa", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7afef8c0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./closecash.vue", function() {
     var newContent = require("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7afef8c0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./closecash.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=158.js.map