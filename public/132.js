webpackJsonp([132,137],{

/***/ "./modules/Internet/Resources/assets/js/view/cash/closecash.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31b9449d\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/cash/closecash.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/cash/closecash.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-31b9449d\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/cash/closecash.vue")
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
Component.options.__file = "modules/Internet/Resources/assets/js/view/cash/closecash.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-31b9449d", Component.options)
  } else {
    hotAPI.reload("data-v-31b9449d", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./modules/Internet/Resources/assets/js/view/cash/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/cash/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-230eaac2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/cash/form.vue")
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
Component.options.__file = "modules/Internet/Resources/assets/js/view/cash/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-230eaac2", Component.options)
  } else {
    hotAPI.reload("data-v-230eaac2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/cash/closecash.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__resources_js_mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__form_vue__ = __webpack_require__("./modules/Internet/Resources/assets/js/view/cash/form.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__form_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__form_vue__);


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
//'../../../../components/DataTable.vue'
 ///mixins/deletable'


/* harmony default export */ __webpack_exports__["default"] = ({
  mixins: [__WEBPACK_IMPORTED_MODULE_1__resources_js_mixins_deletable__["a" /* deletable */]],
  props: ["showDialogClose", "recordId", "fromBox"],
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
      loading: false
    };
  },
  methods: {
    ocultarBoton: function ocultarBoton() {
      this.$emit("ocultarBoton");
    },
    sumCount: function sumCount() {
      var sum = 0;

      for (var amount in this.count) {
        if (this.count[amount] > 0) {
          sum += (Number(this.count[amount]) || 0) * (Number(amount) || 0);
        } else {
          delete this.count[amount];
        }
      }

      return sum;
    },
    updateFinalBalance: function updateFinalBalance(quantity, value) {
      this.count[value.toString()] = quantity;
      this.final_balance = _.round(this.sumCount(), 2);
    },
    clickCloseCash: function clickCloseCash() {
      var _this = this;

      var h = this.$createElement;
      this.$msgbox({
        title: "Cerrar caja",
        type: "warning",
        message: h("p", null, [h("p", {
          style: "text-align: justify; font-size:15px"
        }, "¿Está seguro de cerrar la caja?")]),
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
    dateclosed: function dateclosed(date_closed) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.loading = true;
                _context.next = 3;
                return _this2.$http.get("/caja/cash/balance-final/".concat(_this2.date_closed)).then(function (response) {
                  //  this.final_balance = response.data.balance_total.toFixed(2);
                  _this2.loading = false;
                });

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
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
                  counter: _this3.count
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
                instance.confirmButtonLoading = true;
                instance.confirmButtonText = "Cerrando caja...";
                window.open("/caja/report-boxes/reports_resumen_type?cash_id=".concat(_this3.recordId), "_blank");

                _this3.closeDialog();

              case 20:
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

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/cash/form.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "recordId", "typeUser", "fromBox"],
  data: function data() {
    return {
      loading_submit: false,
      titleDialog: null,
      resource: "caja/worker/cash",
      errors: {},
      form: {},
      user: {},
      all_departments: [],
      all_provinces: [],
      all_districts: [],
      provinces: [],
      districts: [],
      identity_document_types: [],
      users: [],
      turnsTable: [],
      dontClose: false
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
              return _this.$http.get("/".concat(_this.resource, "/tables")).then(function (response) {
                _this.users = response.data.users;
                _this.user = response.data.user;
                _this.turnsTable = response.data.turnsTable;
              });

            case 2:
              _this.initForm();

            case 3:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  computed: {
    disableUser: function disableUser() {
      if (this.typeUser == "admin" || this.typeUser === "superadmin") {
        return false;
      }

      return true;
    }
  },
  methods: {
    ocultarBoton: function ocultarBoton() {
      this.$emit("ocultarBoton");
    },
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        id: null,
        user_id: this.user.id,
        // user: null,
        date_opening: null,
        time_opening: null,
        date_closed: null,
        time_closed: null,
        beginning_balance: 0,
        final_balance: 0,
        income: 0,
        state: true,
        reference_number: null
      };
    },
    create: function create() {
      var _this2 = this;

      this.titleDialog = this.recordId ? "Editar Caja" : "Aperturar Caja";

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this2.form = response.data.data;
        });
      } else {
        this.form.user_id = this.user.id; //sesion
        //this.form.user = this.user.name
      }
    },
    openingCashCkeck: function openingCashCkeck() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, cash;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this3.$http.get("/".concat(_this3.resource, "/opening_cash_check/").concat(_this3.form.user_id));

              case 2:
                response = _context2.sent;
                cash = response.data.cash;
                return _context2.abrupt("return", cash ? true : false);

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    submit: function submit() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this4.loading_submit = true;

                if (!(_this4.form.turn_id == undefined)) {
                  _context3.next = 5;
                  break;
                }

                _this4.$toast.warning("La opcion 'Seleccionar turno de apertura' no puede ser un campo vacio, por favor seleccione una opcion");

                _this4.loading_submit = false;
                return _context3.abrupt("return", false);

              case 5:
                if (_this4.recordId) {
                  _context3.next = 12;
                  break;
                }

                _context3.next = 8;
                return _this4.openingCashCkeck();

              case 8:
                if (!_context3.sent) {
                  _context3.next = 12;
                  break;
                }

                _this4.$toast.warning("No puede crear caja, porfavor cierre caja para el usuario definido");

                _this4.loading_submit = false;
                return _context3.abrupt("return", false);

              case 12:
                _this4.$http.post("/".concat(_this4.resource), _this4.form).then(function (response) {
                  console.log(response);

                  if (response.data.success) {
                    _this4.$toast.success(response.data.message);

                    if (_this4.form.user_id === _this4.user.id) _this4.$eventHub.$emit("openCash");

                    _this4.$eventHub.$emit("reloadData");

                    if (_this4.fromBox) {
                      _this4.$emit("updateCashId", response.data.cash_id);
                    } // window.open('/pos/init')


                    _this4.close();

                    _this4.ocultarBoton();
                  } else {
                    _this4.$toast.error(response.data.message);
                  }
                })["catch"](function (error) {
                  if (error.response.status === 422) {
                    _this4.errors = error.response.data;
                  } else {
                    console.log(error);
                  }
                }).then(function () {
                  _this4.loading_submit = false;
                });

              case 13:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
      this.initForm();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31b9449d\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/cash/closecash.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\r\n/* .el-input__inner {\r\n    padding: 0 25px !important;\r\n} */\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/modules/Internet/Resources/assets/js/view/cash/modules/Internet/Resources/assets/js/view/cash/closecash.vue"],"names":[],"mappings":";;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;AA4OA;;IAEA","file":"closecash.vue","sourcesContent":["<template>\r\n    <div>\r\n        <div class=\"row\">\r\n            <el-dialog\r\n                title=\"Cierra de Caja\"\r\n                :visible.sync=\"showDialogClose\"\r\n                @open=\"dateclosed()\"\r\n                :before-close=\"closeDialog\"\r\n                width=\"35%\"\r\n            >\r\n                <span>\r\n                    <form autocomplete=\"off\" @submit.prevent=\"submit\">\r\n                        <div class=\"form-body\">\r\n                            <div class=\"row\">\r\n                                <div class=\"col-12\"><span>Billetes</span></div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['200']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(\r\n                                                count['200'],\r\n                                                200\r\n                                            )\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">200</template>\r\n                                    </el-input>\r\n                                </div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['100']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(\r\n                                                count['100'],\r\n                                                100\r\n                                            )\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">100</template>\r\n                                    </el-input>\r\n                                </div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['50']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(count['50'], 50)\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">50</template>\r\n                                    </el-input>\r\n                                </div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['20']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(count['20'], 20)\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">20</template>\r\n                                    </el-input>\r\n                                </div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['10']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(count['10'], 10)\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">10</template>\r\n                                    </el-input>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"row\">\r\n                                <div class=\"col-12\"><span>Monedas</span></div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['5']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(count['5'], 5)\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">5</template>\r\n                                    </el-input>\r\n                                </div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['2']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(count['2'], 2)\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">2</template>\r\n                                    </el-input>\r\n                                </div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['1']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(count['1'], 1)\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">1</template>\r\n                                    </el-input>\r\n                                </div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['0.5']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(\r\n                                                count['0.5'],\r\n                                                0.5\r\n                                            )\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">0.50</template>\r\n                                    </el-input>\r\n                                </div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['0.2']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(\r\n                                                count['0.2'],\r\n                                                0.2\r\n                                            )\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">0.20</template>\r\n                                    </el-input>\r\n                                </div>\r\n                                <div\r\n                                    class=\"col-md-5 col-sm-3 col-xxl-3 col-6 mt-1\"\r\n                                >\r\n                                    <el-input\r\n                                        placeholder=\"0\"\r\n                                        v-model=\"count['0.1']\"\r\n                                        @input=\"\r\n                                            updateFinalBalance(\r\n                                                count['0.1'],\r\n                                                0.1\r\n                                            )\r\n                                        \"\r\n                                    >\r\n                                        <template slot=\"prepend\">0.10</template>\r\n                                    </el-input>\r\n                                </div>\r\n                            </div>\r\n                            <div\r\n                                style=\"margin-top:10px;\"\r\n                                class=\"row\"\r\n                                v-loading=\"loading\"\r\n                            >\r\n                                <div class=\"col-md-4\"></div>\r\n                                <div class=\"col-md-4\">\r\n                                    <div\r\n                                        class=\"form-group\"\r\n                                        :class=\"{\r\n                                            'has-danger': errors.date_closed\r\n                                        }\"\r\n                                    >\r\n                                        <label class=\"control-label disabled\"\r\n                                            >Fecha </label\r\n                                        ><br />\r\n                                        <el-date-picker\r\n                                            prefix-icon=\"el-icon\"\r\n                                            v-model=\"date_closed\"\r\n                                            type=\"date\"\r\n                                            disabled\r\n                                            format=\"dd/MM/yyyy\"\r\n                                            value-format=\"yyyy-MM-dd\"\r\n                                            @change=\"dateclosed()\"\r\n                                        >\r\n                                        </el-date-picker>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"col-md-4\">\r\n                                    <div\r\n                                        class=\"form-group\"\r\n                                        :class=\"{\r\n                                            'has-danger': errors.final_balance\r\n                                        }\"\r\n                                    >\r\n                                        <label class=\"control-label\"\r\n                                            >Saldo Final</label\r\n                                        >\r\n                                        <el-input\r\n                                            readonly\r\n                                            v-model=\"final_balance\"\r\n                                        ></el-input>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </form>\r\n                </span>\r\n                <span slot=\"footer\" class=\"dialog-footer\">\r\n                    <el-button @click=\"closeDialog()\">Cerrar</el-button>\r\n                    <el-button type=\"primary\" @click=\"clickCloseCash()\"\r\n                        >Guardar</el-button\r\n                    >\r\n                </span>\r\n            </el-dialog>\r\n        </div>\r\n    </div>\r\n</template>\r\n<style>\r\n/* .el-input__inner {\r\n    padding: 0 25px !important;\r\n} */\r\n</style>\r\n<script>\r\n//'../../../../components/DataTable.vue'\r\nimport { deletable } from \"../../../../../../../resources/js/mixins/deletable\";\r\n///mixins/deletable'\r\nimport CashForm from \"./form.vue\";\r\n\r\nexport default {\r\n    mixins: [deletable],\r\n    props: [\"showDialogClose\", \"recordId\", \"fromBox\"],\r\n    data() {\r\n        return {\r\n            total: 0,\r\n            count: {},\r\n            showDialog: false,\r\n            open_cash: true,\r\n            errors: {},\r\n            resource: \"caja/worker/cash\",\r\n            date_closed: moment().format(\"YYYY-MM-DD\"),\r\n            date_start: moment().format(\"YYYY-MM-DD\"),\r\n            month_start: moment().format(\"YYYY-MM\"),\r\n            final_balance: 0,\r\n            cash: null,\r\n            loading: false\r\n        };\r\n    },\r\n\r\n    methods: {\r\n        ocultarBoton() {\r\n            this.$emit(\"ocultarBoton\");\r\n        },\r\n        sumCount() {\r\n            let sum = 0;\r\n            for (const amount in this.count) {\r\n                if (this.count[amount] > 0) {\r\n                    sum +=\r\n                        (Number(this.count[amount]) || 0) *\r\n                        (Number(amount) || 0);\r\n                } else {\r\n                    delete this.count[amount];\r\n                }\r\n            }\r\n            return sum;\r\n        },\r\n        updateFinalBalance(quantity, value) {\r\n            this.count[value.toString()] = quantity;\r\n\r\n            this.final_balance = _.round(this.sumCount(), 2);\r\n        },\r\n        clickCloseCash() {\r\n            const h = this.$createElement;\r\n            this.$msgbox({\r\n                title: \"Cerrar caja\",\r\n                type: \"warning\",\r\n                message: h(\"p\", null, [\r\n                    h(\r\n                        \"p\",\r\n                        { style: \"text-align: justify; font-size:15px\" },\r\n                        \"¿Está seguro de cerrar la caja?\"\r\n                    )\r\n                ]),\r\n\r\n                showCancelButton: true,\r\n                confirmButtonText: \"Aceptar\",\r\n                cancelButtonText: \"Cancelar\",\r\n                beforeClose: (action, instance, done) => {\r\n                    if (action === \"confirm\") {\r\n                        //  console.log(this.count);\r\n                        this.createRegister(instance, done);\r\n                    } else {\r\n                        done();\r\n                    }\r\n                }\r\n            })\r\n                .then(action => {})\r\n                .catch(action => {});\r\n        },\r\n        async dateclosed(date_closed) {\r\n            this.loading = true;\r\n            await this.$http\r\n                .get(`/caja/cash/balance-final/${this.date_closed}`)\r\n                .then(response => {\r\n                    //  this.final_balance = response.data.balance_total.toFixed(2);\r\n                    this.loading = false;\r\n                });\r\n        },\r\n        closeDialog() {\r\n            this.$emit(\"update:showDialogClose\", false);\r\n            this.count = {};\r\n            this.final_balance = 0;\r\n        },\r\n        async createRegister(instance, done) {\r\n            const body = {\r\n                id: this.recordId,\r\n                final_balance: this.final_balance,\r\n                counter: this.count\r\n            };\r\n            try {\r\n                const response = await this.$http.post(\r\n                    `/${this.resource}/close`,\r\n                    body\r\n                );\r\n\r\n                if (response.data.success) {\r\n                    this.$eventHub.$emit(\"reloadData\");\r\n                    this.open_cash = true;\r\n                    this.$toast.success(response.data.message);\r\n                    this.ocultarBoton();\r\n                    if (this.fromBox) {\r\n                        this.$emit(\"updateCashId\", null);\r\n                    }\r\n                } else {\r\n                    console.log(response);\r\n                }\r\n            } catch (error) {\r\n                console.log(error);\r\n            } finally {\r\n                instance.confirmButtonLoading = false;\r\n                instance.confirmButtonText = \"Iniciar prueba\";\r\n                done();\r\n            }\r\n\r\n            instance.confirmButtonLoading = true;\r\n            instance.confirmButtonText = \"Cerrando caja...\";\r\n            window.open(\r\n                `/caja/report-boxes/reports_resumen_type?cash_id=${this.recordId}`,\r\n                \"_blank\"\r\n            );\r\n            this.closeDialog();\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-230eaac2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/cash/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        title: _vm.titleDialog,
        visible: _vm.showDialog,
        "data-keyboard": false,
        closeOnPressEscape: _vm.dontClose,
        closeOnClickModal: _vm.dontClose
      },
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
              _c("div", { staticClass: "col-md-6" }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Cajero ")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        attrs: { disabled: _vm.disableUser },
                        model: {
                          value: _vm.form.user_id,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "user_id", $$v)
                          },
                          expression: "form.user_id"
                        }
                      },
                      _vm._l(_vm.users, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.name }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.user
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: { textContent: _vm._s(_vm.errors.user[0]) }
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
                    class: { "has-danger": _vm.errors.beginning_balance }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v(
                        "Saldo inicial de Apertura\n                        "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        model: {
                          value: _vm.form.beginning_balance,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "beginning_balance", $$v)
                          },
                          expression: "form.beginning_balance"
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
                    _vm.errors.beginning_balance
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.beginning_balance[0])
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
                    class: { "has-danger": _vm.errors.reference_number }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Seleccionar Turno de Apertura")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        model: {
                          value: _vm.form.turn_id,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "turn_id", $$v)
                          },
                          expression: "form.turn_id"
                        }
                      },
                      _vm._l(_vm.turnsTable, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.turn_desc }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.reference_number
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.reference_number[0])
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
    require("vue-hot-reload-api")      .rerender("data-v-230eaac2", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-31b9449d\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/cash/closecash.vue":
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
              title: "Cierra de Caja",
              visible: _vm.showDialogClose,
              "before-close": _vm.closeDialog,
              width: "35%"
            },
            on: {
              "update:visible": function($event) {
                _vm.showDialogClose = $event
              },
              open: function($event) {
                return _vm.dateclosed()
              }
            }
          },
          [
            _c("span", [
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
                      _c("div", { staticClass: "col-12" }, [
                        _c("span", [_vm._v("Billetes")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [
                                _vm._v("200")
                              ])
                            ],
                            2
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [
                                _vm._v("100")
                              ])
                            ],
                            2
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [
                                _vm._v("50")
                              ])
                            ],
                            2
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [
                                _vm._v("20")
                              ])
                            ],
                            2
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [
                                _vm._v("10")
                              ])
                            ],
                            2
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c("div", { staticClass: "col-12" }, [
                        _c("span", [_vm._v("Monedas")])
                      ]),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
                              attrs: { placeholder: "0" },
                              on: {
                                input: function($event) {
                                  return _vm.updateFinalBalance(
                                    _vm.count["5"],
                                    5
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [_vm._v("5")])
                            ],
                            2
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
                              attrs: { placeholder: "0" },
                              on: {
                                input: function($event) {
                                  return _vm.updateFinalBalance(
                                    _vm.count["2"],
                                    2
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [_vm._v("2")])
                            ],
                            2
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
                              attrs: { placeholder: "0" },
                              on: {
                                input: function($event) {
                                  return _vm.updateFinalBalance(
                                    _vm.count["1"],
                                    1
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [_vm._v("1")])
                            ],
                            2
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
                              attrs: { placeholder: "0" },
                              on: {
                                input: function($event) {
                                  return _vm.updateFinalBalance(
                                    _vm.count["0.5"],
                                    0.5
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [
                                _vm._v("0.50")
                              ])
                            ],
                            2
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
                              attrs: { placeholder: "0" },
                              on: {
                                input: function($event) {
                                  return _vm.updateFinalBalance(
                                    _vm.count["0.2"],
                                    0.2
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [
                                _vm._v("0.20")
                              ])
                            ],
                            2
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-5 col-sm-3 col-xxl-3 col-6 mt-1"
                        },
                        [
                          _c(
                            "el-input",
                            {
                              attrs: { placeholder: "0" },
                              on: {
                                input: function($event) {
                                  return _vm.updateFinalBalance(
                                    _vm.count["0.1"],
                                    0.1
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
                            },
                            [
                              _c("template", { slot: "prepend" }, [
                                _vm._v("0.10")
                              ])
                            ],
                            2
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c(
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
                        staticClass: "row",
                        staticStyle: { "margin-top": "10px" }
                      },
                      [
                        _c("div", { staticClass: "col-md-4" }),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-md-4" }, [
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
                                { staticClass: "control-label disabled" },
                                [_vm._v("Fecha ")]
                              ),
                              _c("br"),
                              _vm._v(" "),
                              _c("el-date-picker", {
                                attrs: {
                                  "prefix-icon": "el-icon",
                                  type: "date",
                                  disabled: "",
                                  format: "dd/MM/yyyy",
                                  "value-format": "yyyy-MM-dd"
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.dateclosed()
                                  }
                                },
                                model: {
                                  value: _vm.date_closed,
                                  callback: function($$v) {
                                    _vm.date_closed = $$v
                                  },
                                  expression: "date_closed"
                                }
                              })
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
                              class: {
                                "has-danger": _vm.errors.final_balance
                              }
                            },
                            [
                              _c("label", { staticClass: "control-label" }, [
                                _vm._v("Saldo Final")
                              ]),
                              _vm._v(" "),
                              _c("el-input", {
                                attrs: { readonly: "" },
                                model: {
                                  value: _vm.final_balance,
                                  callback: function($$v) {
                                    _vm.final_balance = $$v
                                  },
                                  expression: "final_balance"
                                }
                              })
                            ],
                            1
                          )
                        ])
                      ]
                    )
                  ])
                ]
              )
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
                    on: {
                      click: function($event) {
                        return _vm.clickCloseCash()
                      }
                    }
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
    require("vue-hot-reload-api")      .rerender("data-v-31b9449d", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31b9449d\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/cash/closecash.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31b9449d\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/cash/closecash.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("8b4f310c", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31b9449d\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./closecash.vue", function() {
     var newContent = require("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-31b9449d\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./closecash.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=132.js.map