webpackJsonp([5],{

/***/ "./modules/Inventory/Resources/assets/js/series/reporteSeriesSell.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Inventory/Resources/assets/js/series/reporteSeriesSell.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-a8f565a2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Inventory/Resources/assets/js/series/reporteSeriesSell.vue")
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
Component.options.__file = "modules/Inventory/Resources/assets/js/series/reporteSeriesSell.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a8f565a2", Component.options)
  } else {
    hotAPI.reload("data-v-a8f565a2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/whatsapp_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/whatsapp_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6dcfd6a1\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/whatsapp_modal.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/whatsapp_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6dcfd6a1", Component.options)
  } else {
    hotAPI.reload("data-v-6dcfd6a1", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Inventory/Resources/assets/js/series/reporteSeriesSell.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_query_string__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_moment__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__Restaurant_Resources_assets_js_views_pos_partials_whatsapp_modal_vue__ = __webpack_require__("./modules/Restaurant/Resources/assets/js/views/pos/partials/whatsapp_modal.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__Restaurant_Resources_assets_js_views_pos_partials_whatsapp_modal_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__Restaurant_Resources_assets_js_views_pos_partials_whatsapp_modal_vue__);
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: [],
  components: {
    WhatsappModal: __WEBPACK_IMPORTED_MODULE_3__Restaurant_Resources_assets_js_views_pos_partials_whatsapp_modal_vue___default.a
  },
  data: function data() {
    return {
      showModalWhatsapp: false,
      company: null,
      documentId: null,
      documentTypeId: null,
      documentNumber: null,
      sender: "sdrimsac",
      establishment: null,
      activeName: "documents",
      totalGeneral: null,
      totalGain: 0,
      warehouses: [],
      loading_submit: false,
      showDialog: false,
      showDialogClose: false,
      messageReport: null,
      resourceReport: null,
      open_cash: true,
      resource: "series",
      recordId: null,
      data_closed: __WEBPACK_IMPORTED_MODULE_2_moment___default()().format("YYYY-MM-DD"),
      date_start: __WEBPACK_IMPORTED_MODULE_2_moment___default()().format("YYYY-MM-DD"),
      month_start: __WEBPACK_IMPORTED_MODULE_2_moment___default()().format("YYYY-MM"),
      cash: null,
      otroNombre: false,
      form: {
        date_start: null
      },
      records: [],
      categories: [],
      pagination: {
        saleNotes: {},
        documents: {}
      },
      showWhatsappForm: false,
      ListPersonas: [],
      NotasDeventas: [],
      numeroWhatsapp: "",
      loadbuttonwhats: null
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
              return _this.$http.get("/reports/inventory/tables").then(function (response) {
                _this.warehouses = response.data.warehouses;
                _this.categories = response.data.categories;
              });

            case 2:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  mounted: function mounted() {
    this.getPersonas();
  },
  methods: {
    Printer: function Printer(_Printer, linkpdf) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var paperConfig, config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                paperConfig = {
                  scaleContent: false
                };
                config = qz.configs.create(_Printer, paperConfig);

                if (qz.websocket.isActive()) {
                  _context2.next = 5;
                  break;
                }

                _context2.next = 5;
                return qz.websocket.connect(config);

              case 5:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: linkpdf
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this2.$toast.error(e.message);
                });

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    printDocument: function printDocument(row) {
      var external_id = row.external_id,
          printer = row.printer,
          isNote = row.isNote;
      var url;

      if (isNote) {
        url = "/sale-notes/print/".concat(external_id, "/ticket");
      } else {
        //
        url = "/print/document/".concat(external_id, "/ticket");
      }

      this.Printer(printer, url);
    },
    getPersonas: function getPersonas() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response, data, status;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.prev = 0;
                _context3.next = 3;
                return _this3.$http.get("".concat(_this3.resource, "/getPersonas"));

              case 3:
                response = _context3.sent;
                data = response.data, status = response.status;

                if (status == 200) {
                  _this3.ListPersonas = _toConsumableArray(data.personas.map(function (s) {
                    s.degres_desc = "".concat(s.name, " - ").concat(s.number, " ");
                    return _objectSpread({}, s);
                  }));
                } else {
                  console.log(response);
                }

                _context3.next = 11;
                break;

              case 8:
                _context3.prev = 8;
                _context3.t0 = _context3["catch"](0);
                console.log(_context3.t0);

              case 11:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[0, 8]]);
      }))();
    },
    getRecordsByFilter: function getRecordsByFilter() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response, data, status, _response, _data, _status;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.prev = 0;

                if (!(_this4.activeName === "documents")) {
                  _context4.next = 7;
                  break;
                }

                _context4.next = 4;
                return axios.post("".concat(_this4.resource, "/getDataSeries?page=").concat(_this4.pagination.documents.current_page), {
                  form: _this4.form
                });

              case 4:
                response = _context4.sent;
                data = response.data, status = response.status;

                if (status == 200) {
                  _this4.records = data.datosSeries;
                  _this4.pagination.documents.total = data.dataPaginated.total;
                  _this4.pagination.documents.current_page = data.dataPaginated.current_page;
                  _this4.pagination.documents.per_page = data.dataPaginated.per_page;
                }

              case 7:
                if (!(_this4.activeName === "SalesNotes")) {
                  _context4.next = 13;
                  break;
                }

                _context4.next = 10;
                return axios.post("".concat(_this4.resource, "/getDataSeriesSalesnotes?page=").concat(_this4.pagination.saleNotes.current_page), {
                  form: _this4.form
                });

              case 10:
                _response = _context4.sent;
                _data = _response.data, _status = _response.status;

                if (_status == 200) {
                  _this4.NotasDeventas = _data.datosSeries;
                  _this4.pagination.saleNotes.total = _data.dataPaginated.total;
                  _this4.pagination.saleNotes.current_page = _data.dataPaginated.current_page;
                  _this4.pagination.saleNotes.per_page = _data.dataPaginated.per_page;
                }

              case 13:
                _context4.next = 18;
                break;

              case 15:
                _context4.prev = 15;
                _context4.t0 = _context4["catch"](0);
                console.log(_context4.t0);

              case 18:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, null, [[0, 15]]);
      }))();
    },
    clickDownload: function clickDownload(type) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var query;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                console.log(type); //

                query = __WEBPACK_IMPORTED_MODULE_1_query_string___default.a.stringify(_objectSpread({
                  activeTab: _this5.activeName
                }, _this5.form));
                console.log(query);

                try {
                  window.open("".concat(_this5.resource, "/reporteexcel?").concat(query), "_blank");
                } catch (error) {
                  console.log(error);

                  _this5.$toast.error(error.response.data.error);
                }

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    openWhastappForm: function openWhastappForm() {
      var row = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.numeroWhatsapp = "";

      if (row) {
        this.company = row.company;
        this.documentId = row.documentId;
        this.documentTypeId = row.documentTypeId;
        this.documentNumber = row.documentNumber;
        this.showModalWhatsapp = true;
      } else {
        this.showWhatsappForm = true;
        this.loadbuttonwhats = false;
      }
    },
    SendReportWhasapp: function SendReportWhasapp() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        var response, data, status, _response2, _data2, _status2;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                console.log("enviando por whatsapp ");
                _this6.loadbuttonwhats = true;

                if (!(_this6.numeroWhatsapp === "")) {
                  _context6.next = 5;
                  break;
                }

                _this6.$toast.warning("El numero para enviar no puede estar vacio ");

                return _context6.abrupt("return");

              case 5:
                _context6.prev = 5;

                if (!(_this6.activeName === "documents")) {
                  _context6.next = 12;
                  break;
                }

                _context6.next = 9;
                return axios.post("".concat(_this6.resource, "/envioReportWhastap"), {
                  form: _this6.form,
                  activeTab: _this6.activeName,
                  numeroWhatsapp: _this6.numeroWhatsapp
                });

              case 9:
                response = _context6.sent;
                data = response.data, status = response.status;

                if (status == 200) {
                  _this6.$toast.success("Reporte enviado correctamente");

                  _this6.loadbuttonwhats = false;
                  _this6.showWhatsappForm = false;
                }

              case 12:
                if (!(_this6.activeName === "SalesNotes")) {
                  _context6.next = 18;
                  break;
                }

                _context6.next = 15;
                return axios.post("".concat(_this6.resource, "/envioReportWhastap"), {
                  form: _this6.form,
                  activeTab: _this6.activeName,
                  numeroWhatsapp: _this6.numeroWhatsapp
                });

              case 15:
                _response2 = _context6.sent;
                _data2 = _response2.data, _status2 = _response2.status;

                if (_status2 == 200) {
                  _this6.$toast.success("Reporte enviado correctamente");

                  _this6.loadbuttonwhats = false;
                  _this6.showWhatsappForm = false;
                }

              case 18:
                _context6.next = 23;
                break;

              case 20:
                _context6.prev = 20;
                _context6.t0 = _context6["catch"](5);
                console.log(_context6.t0);

              case 23:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6, null, [[5, 20]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/whatsapp_modal.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "documentId", "documentTypeId", "company", "documentNumber", "sender", "establishment"],
  data: function data() {
    return {
      number: null,
      withXml: false,
      loading: false
    };
  },
  methods: {
    open: function open() {
      console.log(this.establishment);
    },
    close: function close() {
      this.$emit("update:showDialog", false);
      this.number = null;
      this.withXml = false;
    },
    existNumber: function existNumber() {
      var number = this.number;

      if (!number.startsWith("9")) {
        return false;
      }

      if (number.length != 9) {
        return false;
      }

      if (isNaN(Number(number))) {
        return false;
      }

      return true;
    },
    sendFiles: function sendFiles() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var formWhatsapp, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (_this.number) {
                  _context.next = 3;
                  break;
                }

                _this.$toast.warning("Ingrese un número");

                return _context.abrupt("return");

              case 3:
                if (_this.existNumber()) {
                  _context.next = 6;
                  break;
                }

                _this.$toast.error("Número para envío whatsapp inválido");

                return _context.abrupt("return");

              case 6:
                formWhatsapp = {
                  document_id: _this.documentId,
                  document_type_id: _this.documentTypeId,
                  customer_telephone: _this.number,
                  sender: _this.sender,
                  mensaje: "Su comprobante de pago electrónico " + _this.documentNumber + " de *" + (_this.establishment ? _this.establishment.description : _this.company.name) + "*, ha sido generado correctamente a través del facturador electrónico de *" + _this.$desarrollador + "*"
                };
                _context.prev = 7;
                _this.loading = true;
                _context.next = 11;
                return _this.$http.post("/whatsapp", formWhatsapp);

              case 11:
                response = _context.sent;

                if (!_this.withXml) {
                  _context.next = 17;
                  break;
                }

                formWhatsapp.xml = true;
                _context.next = 16;
                return _this.$http.post("/whatsapp", formWhatsapp);

              case 16:
                response = _context.sent;

              case 17:
                if (response.status == 200) {
                  _this.$toast.success("El mensaje se envió correctamente");
                } else {
                  _this.$toast.error("Ocurrió un error en el envio");
                }

                _context.next = 23;
                break;

              case 20:
                _context.prev = 20;
                _context.t0 = _context["catch"](7);

                _this.$toast.error("Ocurrió un error en el envio");

              case 23:
                _context.prev = 23;
                _this.loading = false;

                _this.close();

                return _context.finish(23);

              case 27:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[7, 20, 23, 27]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/sellers/form.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "recordId", "establishments", "document_types"],
  data: function data() {
    return {
      title: null,
      resource: "sellers",
      errors: {},
      form: {},
      loading_submit: false,
      loading_submitI: false,
      timer: null
    };
  },
  methods: {
    initForm: function initForm() {
      this.form = {
        name: null,
        document: null,
        establishment_id: null,
        document_type_id: null
      };
    },
    searchDocument: function searchDocument() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var identity_document_type_name, response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!(_this.form.document === "")) {
                  _context.next = 3;
                  break;
                }

                _this.$message.error("Ingresar el número a buscar");

                return _context.abrupt("return");

              case 3:
                if (!(_this.form.document.length != 8)) {
                  _context.next = 6;
                  break;
                }

                _this.$message.error("El número debe tener 8 dígitos");

                return _context.abrupt("return");

              case 6:
                identity_document_type_name = "dni";
                _context.next = 9;
                return _this.$http.get("/service/".concat(identity_document_type_name, "/").concat(_this.form.document));

              case 9:
                response = _context.sent;

                if (response.data.success) {
                  data = response.data.data;
                  _this.form.name = data.nombre_completo;
                } else {
                  _this.$message.error(response.data.message);
                }

              case 11:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    open: function open() {
      console.log(this.recordId);

      if (this.recordId) {
        this.title = "Editar vendedor";
        this.getRecord(this.recordId);
      } else {
        this.title = "Crear vendedor";
        this.initForm();
      }
    },
    getRecord: function getRecord(id) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this2.$http.get("/".concat(_this2.resource, "/record/").concat(id));

              case 2:
                response = _context2.sent;
                _this2.form = response.data.data;

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    close: function close() {
      this.$emit('update:showDialog', false);
    },
    submit: function submit() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.next = 2;
                return _this3.$http.post("/".concat(_this3.resource), _this3.form);

              case 2:
                response = _context3.sent;

                if (response.data.success) {
                  _this3.$message.success(response.data.message);

                  _this3.close();

                  _this3.$eventHub.$emit("reloadData");
                } else {
                  _this3.$message.error(response.data.message);
                }

              case 4:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/sellers/index.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__form_vue__ = __webpack_require__("./resources/js/views/sellers/form.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__form_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__form_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");


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


/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["typeUser"],
  mixins: [__WEBPACK_IMPORTED_MODULE_2__mixins_deletable__["a" /* deletable */]],
  components: {
    SellersForm: __WEBPACK_IMPORTED_MODULE_1__form_vue___default.a
  },
  data: function data() {
    return {
      showDialog: false,
      resource: "sellers",
      recordId: null,
      records: [],
      title: null,
      establishments: [],
      document_types: []
    };
  },
  created: function created() {
    var _this = this;

    this.$eventHub.$on("reloadData", function () {
      _this.getData();
    });
    this.getData();
    this.getTables();
  },
  methods: {
    getTables: function getTables() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, _response$data, establishments, document_types;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this2.$http("".concat(_this2.resource, "/tables"));

              case 2:
                response = _context.sent;
                console.log(response);
                _response$data = response.data, establishments = _response$data.establishments, document_types = _response$data.document_types;
                _this2.establishments = establishments;
                _this2.document_types = document_types; // this.establishments = response.data.data.establishments;

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getData: function getData() {
      var _this3 = this;

      this.$http.get("/".concat(this.resource, "/records")).then(function (response) {
        _this3.records = response.data.data;
      });
    },
    clickCreate: function clickCreate() {
      var recordId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      console.log("sadas");
      this.recordId = recordId;
      this.showDialog = true;
    },
    clickDelete: function clickDelete(id) {
      var _this4 = this;

      this.destroy("/".concat(this.resource, "/").concat(id)).then(function () {
        return _this4.$eventHub.$emit("reloadData");
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/object-assign/index.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/*
object-assign
(c) Sindre Sorhus
@license MIT
*/


/* eslint-disable no-unused-vars */
var getOwnPropertySymbols = Object.getOwnPropertySymbols;
var hasOwnProperty = Object.prototype.hasOwnProperty;
var propIsEnumerable = Object.prototype.propertyIsEnumerable;

function toObject(val) {
	if (val === null || val === undefined) {
		throw new TypeError('Object.assign cannot be called with null or undefined');
	}

	return Object(val);
}

function shouldUseNative() {
	try {
		if (!Object.assign) {
			return false;
		}

		// Detect buggy property enumeration order in older V8 versions.

		// https://bugs.chromium.org/p/v8/issues/detail?id=4118
		var test1 = new String('abc');  // eslint-disable-line no-new-wrappers
		test1[5] = 'de';
		if (Object.getOwnPropertyNames(test1)[0] === '5') {
			return false;
		}

		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
		var test2 = {};
		for (var i = 0; i < 10; i++) {
			test2['_' + String.fromCharCode(i)] = i;
		}
		var order2 = Object.getOwnPropertyNames(test2).map(function (n) {
			return test2[n];
		});
		if (order2.join('') !== '0123456789') {
			return false;
		}

		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
		var test3 = {};
		'abcdefghijklmnopqrst'.split('').forEach(function (letter) {
			test3[letter] = letter;
		});
		if (Object.keys(Object.assign({}, test3)).join('') !==
				'abcdefghijklmnopqrst') {
			return false;
		}

		return true;
	} catch (err) {
		// We don't expect any of the above to throw, but better to be safe.
		return false;
	}
}

module.exports = shouldUseNative() ? Object.assign : function (target, source) {
	var from;
	var to = toObject(target);
	var symbols;

	for (var s = 1; s < arguments.length; s++) {
		from = Object(arguments[s]);

		for (var key in from) {
			if (hasOwnProperty.call(from, key)) {
				to[key] = from[key];
			}
		}

		if (getOwnPropertySymbols) {
			symbols = getOwnPropertySymbols(from);
			for (var i = 0; i < symbols.length; i++) {
				if (propIsEnumerable.call(from, symbols[i])) {
					to[symbols[i]] = from[symbols[i]];
				}
			}
		}
	}

	return to;
};


/***/ }),

/***/ "./node_modules/query-string/index.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var strictUriEncode = __webpack_require__("./node_modules/strict-uri-encode/index.js");
var objectAssign = __webpack_require__("./node_modules/object-assign/index.js");

function encoderForArrayFormat(opts) {
	switch (opts.arrayFormat) {
		case 'index':
			return function (key, value, index) {
				return value === null ? [
					encode(key, opts),
					'[',
					index,
					']'
				].join('') : [
					encode(key, opts),
					'[',
					encode(index, opts),
					']=',
					encode(value, opts)
				].join('');
			};

		case 'bracket':
			return function (key, value) {
				return value === null ? encode(key, opts) : [
					encode(key, opts),
					'[]=',
					encode(value, opts)
				].join('');
			};

		default:
			return function (key, value) {
				return value === null ? encode(key, opts) : [
					encode(key, opts),
					'=',
					encode(value, opts)
				].join('');
			};
	}
}

function parserForArrayFormat(opts) {
	var result;

	switch (opts.arrayFormat) {
		case 'index':
			return function (key, value, accumulator) {
				result = /\[(\d*)\]$/.exec(key);

				key = key.replace(/\[\d*\]$/, '');

				if (!result) {
					accumulator[key] = value;
					return;
				}

				if (accumulator[key] === undefined) {
					accumulator[key] = {};
				}

				accumulator[key][result[1]] = value;
			};

		case 'bracket':
			return function (key, value, accumulator) {
				result = /(\[\])$/.exec(key);
				key = key.replace(/\[\]$/, '');

				if (!result) {
					accumulator[key] = value;
					return;
				} else if (accumulator[key] === undefined) {
					accumulator[key] = [value];
					return;
				}

				accumulator[key] = [].concat(accumulator[key], value);
			};

		default:
			return function (key, value, accumulator) {
				if (accumulator[key] === undefined) {
					accumulator[key] = value;
					return;
				}

				accumulator[key] = [].concat(accumulator[key], value);
			};
	}
}

function encode(value, opts) {
	if (opts.encode) {
		return opts.strict ? strictUriEncode(value) : encodeURIComponent(value);
	}

	return value;
}

function keysSorter(input) {
	if (Array.isArray(input)) {
		return input.sort();
	} else if (typeof input === 'object') {
		return keysSorter(Object.keys(input)).sort(function (a, b) {
			return Number(a) - Number(b);
		}).map(function (key) {
			return input[key];
		});
	}

	return input;
}

exports.extract = function (str) {
	return str.split('?')[1] || '';
};

exports.parse = function (str, opts) {
	opts = objectAssign({arrayFormat: 'none'}, opts);

	var formatter = parserForArrayFormat(opts);

	// Create an object with no prototype
	// https://github.com/sindresorhus/query-string/issues/47
	var ret = Object.create(null);

	if (typeof str !== 'string') {
		return ret;
	}

	str = str.trim().replace(/^(\?|#|&)/, '');

	if (!str) {
		return ret;
	}

	str.split('&').forEach(function (param) {
		var parts = param.replace(/\+/g, ' ').split('=');
		// Firefox (pre 40) decodes `%3D` to `=`
		// https://github.com/sindresorhus/query-string/pull/37
		var key = parts.shift();
		var val = parts.length > 0 ? parts.join('=') : undefined;

		// missing `=` should be `null`:
		// http://w3.org/TR/2012/WD-url-20120524/#collect-url-parameters
		val = val === undefined ? null : decodeURIComponent(val);

		formatter(decodeURIComponent(key), val, ret);
	});

	return Object.keys(ret).sort().reduce(function (result, key) {
		var val = ret[key];
		if (Boolean(val) && typeof val === 'object' && !Array.isArray(val)) {
			// Sort object keys, not values
			result[key] = keysSorter(val);
		} else {
			result[key] = val;
		}

		return result;
	}, Object.create(null));
};

exports.stringify = function (obj, opts) {
	var defaults = {
		encode: true,
		strict: true,
		arrayFormat: 'none'
	};

	opts = objectAssign(defaults, opts);

	var formatter = encoderForArrayFormat(opts);

	return obj ? Object.keys(obj).sort().map(function (key) {
		var val = obj[key];

		if (val === undefined) {
			return '';
		}

		if (val === null) {
			return encode(key, opts);
		}

		if (Array.isArray(val)) {
			var result = [];

			val.slice().forEach(function (val2) {
				if (val2 === undefined) {
					return;
				}

				result.push(formatter(key, val2, result.length));
			});

			return result.join('&');
		}

		return encode(key, opts) + '=' + encode(val, opts);
	}).filter(function (x) {
		return x.length > 0;
	}).join('&') : '';
};


/***/ }),

/***/ "./node_modules/strict-uri-encode/index.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

module.exports = function (str) {
	return encodeURIComponent(str).replace(/[!'()*]/g, function (c) {
		return '%' + c.charCodeAt(0).toString(16).toUpperCase();
	});
};


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0b2a4c30\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/sellers/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
      _c("div", { staticClass: "page-header" }, [
        _c("div", { staticClass: "row" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "col-sm-6 d-flex justify-content-end" }, [
            _c(
              "div",
              { staticClass: "bookmark" },
              [
                _c(
                  "el-button",
                  {
                    attrs: { type: "primary" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.clickCreate()
                      }
                    }
                  },
                  [
                    _vm._v(
                      "\n                            Crear vendedor\n                        "
                    )
                  ]
                )
              ],
              1
            )
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
      _c(
        "div",
        { staticClass: "card" },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("div", { staticClass: "card-body" }, [
            _c("div", { staticClass: "table-responsive" }, [
              _c("table", { staticClass: "table" }, [
                _vm._m(2),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.records, function(row, index) {
                    return _c("tr", { key: index }, [
                      _c("td", [_vm._v(_vm._s(index + 1))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(row.name))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(row.document))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(row.establishment_description))]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-end" }, [
                        _c(
                          "button",
                          {
                            staticClass:
                              "btn waves-effect waves-light btn-sm btn-info",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.clickCreate(row.id)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                                        Editar\n                                    "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        row.id != 1
                          ? _c(
                              "button",
                              {
                                staticClass:
                                  "btn waves-effect waves-light btn-sm btn-danger",
                                attrs: { type: "button" },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.clickDelete(row.id)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                        Eliminar\n                                    "
                                )
                              ]
                            )
                          : _vm._e()
                      ])
                    ])
                  }),
                  0
                )
              ])
            ])
          ]),
          _vm._v(" "),
          _c("sellers-form", {
            attrs: {
              showDialog: _vm.showDialog,
              typeUser: _vm.typeUser,
              establishments: _vm.establishments,
              document_types: _vm.document_types,
              recordId: _vm.recordId
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialog = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialog = $event
              }
            }
          })
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6" }, [
      _c("h6", [_c("span", [_vm._v("Lista de vendedores")])]),
      _vm._v(" "),
      _c("ol", { staticClass: "breadcrumb" }, [
        _c("li", { staticClass: "breadcrumb-item" }, [
          _c("a", { attrs: { href: "/dashboard" } }, [_vm._v("Dashboard")])
        ]),
        _vm._v(" "),
        _c("li", { staticClass: "breadcrumb-item active" }, [
          _c("span", { staticClass: "text-muted" }, [_vm._v("Vendedores")])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header bg-primary" }, [
      _c("h6", { staticClass: "my-0 text-white" }, [
        _vm._v("Listado de vendedores")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("#")]),
        _vm._v(" "),
        _c("th", [_vm._v("Nombre")]),
        _vm._v(" "),
        _c("th", [_vm._v("Documento")]),
        _vm._v(" "),
        _c("th", [_vm._v("Establecimiento")]),
        _vm._v(" "),
        _c("th", [_vm._v("Acciones")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0b2a4c30", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-57591e1e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/sellers/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        visible: _vm.showDialog,
        "append-to-body": "",
        title: _vm.title
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", { attrs: { for: "document_type" } }, [
              _vm._v("Tipo de documento")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: { disabled: _vm.loading_submit },
                model: {
                  value: _vm.form.document_type_id,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "document_type_id", $$v)
                  },
                  expression: "form.document_type_id"
                }
              },
              _vm._l(_vm.document_types, function(item, idx) {
                return _c("el-option", {
                  key: idx,
                  attrs: { label: item.description, value: item.id }
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
            _c("label", { attrs: { for: "document" } }, [_vm._v("Documento")]),
            _vm._v(" "),
            _c(
              "el-input",
              {
                attrs: {
                  placeholder: "Documento",
                  disabled: _vm.loading_submit,
                  minlength: "8"
                },
                model: {
                  value: _vm.form.document,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "document", $$v)
                  },
                  expression: "form.document"
                }
              },
              [
                _vm.form.document_type_id == 1
                  ? _c("el-button", {
                      attrs: { slot: "prepend", icon: "el-icon-search" },
                      on: { click: _vm.searchDocument },
                      slot: "prepend"
                    })
                  : _vm._e()
              ],
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
            _c("label", { attrs: { for: "name" } }, [_vm._v("Nombre")]),
            _vm._v(" "),
            _c("el-input", {
              attrs: { placeholder: "Nombre", disabled: _vm.loading_submit },
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
          { staticClass: "col-md-4" },
          [
            _c("label", { attrs: { for: "establishment_id" } }, [
              _vm._v("Establecimiento")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: {
                  placeholder: "Establecimiento",
                  disabled: _vm.loading_submit
                },
                model: {
                  value: _vm.form.establishment_id,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "establishment_id", $$v)
                  },
                  expression: "form.establishment_id"
                }
              },
              _vm._l(_vm.establishments, function(item) {
                return _c("el-option", {
                  key: item.id,
                  attrs: { label: item.description, value: item.id }
                })
              }),
              1
            )
          ],
          1
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
              attrs: { disabled: _vm.loading_submit },
              on: { click: _vm.close }
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
              },
              on: { click: _vm.submit }
            },
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
    require("vue-hot-reload-api")      .rerender("data-v-57591e1e", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6dcfd6a1\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/whatsapp_modal.vue":
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
        title: "Enviar documento por whatsapp",
        width: "40%",
        visible: _vm.showDialog
      },
      on: { open: _vm.open }
    },
    [
      _c("div", { staticClass: "card " }, [
        _c("div", { staticClass: "row d-flex align-items-center" }, [
          _c(
            "div",
            { staticClass: "col-8" },
            [
              _c("el-input", {
                attrs: { placeholder: "tlf: 999999999" },
                model: {
                  value: _vm.number,
                  callback: function($$v) {
                    _vm.number = $$v
                  },
                  expression: "number"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-4" },
            [
              _c(
                "el-checkbox",
                {
                  attrs: {
                    disabled:
                      _vm.documentTypeId == "80" || _vm.documentTypeId == "COT"
                  },
                  model: {
                    value: _vm.withXml,
                    callback: function($$v) {
                      _vm.withXml = $$v
                    },
                    expression: "withXml"
                  }
                },
                [_vm._v("\n                    Adjuntar XML\n                ")]
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "d-flex justify-content-end p-2" },
          [
            _c(
              "el-button",
              { attrs: { type: "primary" }, on: { click: _vm.sendFiles } },
              [_vm._v("Enviar")]
            ),
            _vm._v(" "),
            _c("el-button", { on: { click: _vm.close } }, [
              _vm._v("\n                Cerrar\n            ")
            ])
          ],
          1
        )
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6dcfd6a1", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-a8f565a2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Inventory/Resources/assets/js/series/reporteSeriesSell.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _vm._m(0),
    _vm._v(" "),
    _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
      _c("div", { staticClass: "card mb-0" }, [
        _vm._m(1),
        _vm._v(" "),
        _c("div", { staticClass: "card-body" }, [
          _c("div", { staticClass: "col-md-12 col-lg-12 col-xl-12" }, [
            _c("div", { staticClass: "row mt-2" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Almacen")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        attrs: { clearable: "", filterable: "" },
                        model: {
                          value: _vm.form.establishment_id,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "establishment_id", $$v)
                          },
                          expression: "form.establishment_id"
                        }
                      },
                      _vm._l(_vm.warehouses, function(option) {
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
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-2" }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Fecha Inicio")
                    ]),
                    _vm._v(" "),
                    _c("el-date-picker", {
                      staticStyle: { width: "100%" },
                      attrs: { "value-format": "yyyy-MM-dd" },
                      model: {
                        value: _vm.form.date_start,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "date_start", $$v)
                        },
                        expression: "form.date_start"
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-2" }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Fecha Final")
                    ]),
                    _vm._v(" "),
                    _c("el-date-picker", {
                      staticStyle: { width: "100%" },
                      attrs: { "value-format": "yyyy-MM-dd" },
                      model: {
                        value: _vm.form.date_end,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "date_end", $$v)
                        },
                        expression: "form.date_end"
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-2" }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Cliente")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        attrs: { clearable: "", filterable: "" },
                        model: {
                          value: _vm.form.personas,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "personas", $$v)
                          },
                          expression: "form.personas"
                        }
                      },
                      _vm._l(_vm.ListPersonas, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.degres_desc }
                        })
                      }),
                      1
                    )
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "\n              col-lg-8 col-md-8 col-md-8 col-sm-12\n              d-flex\n              align-items-end\n            "
                },
                [
                  _c(
                    "el-button",
                    {
                      staticClass: "submit",
                      attrs: {
                        type: "primary",
                        loading: _vm.loading_submit,
                        icon: "el-icon-search"
                      },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.getRecordsByFilter.apply(null, arguments)
                        }
                      }
                    },
                    [_vm._v("Buscar")]
                  ),
                  _vm._v(" "),
                  _vm.records.length > 0 || _vm.NotasDeventas.length > 0
                    ? [
                        _c(
                          "el-button",
                          {
                            staticClass: "submit",
                            staticStyle: { "background-color": "#217346" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.clickDownload("excel")
                              }
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "fa fa-file-excel",
                              staticStyle: { color: "white" }
                            }),
                            _vm._v(" "),
                            _c("span", { staticStyle: { color: "white" } }, [
                              _vm._v("EXCEL")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "el-button",
                          {
                            staticClass: "submit",
                            attrs: { type: "success" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.openWhastappForm()
                              }
                            }
                          },
                          [
                            _c("i", { staticClass: "icofont-brand-whatsapp" }),
                            _vm._v(
                              "\n                                    WHATSAPP"
                            )
                          ]
                        )
                      ]
                    : _vm._e()
                ],
                2
              )
            ])
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-12" },
            [
              _c(
                "el-tabs",
                {
                  attrs: { type: "card", "tab-position": "top" },
                  model: {
                    value: _vm.activeName,
                    callback: function($$v) {
                      _vm.activeName = $$v
                    },
                    expression: "activeName"
                  }
                },
                [
                  _c(
                    "el-tab-pane",
                    {
                      attrs: { label: "Facturas - Boletas", name: "documents" }
                    },
                    [
                      _c(
                        "div",
                        { staticClass: "row" },
                        [
                          _c("el-pagination", {
                            attrs: {
                              layout: "total, prev, pager, next",
                              total: _vm.pagination.documents.total,
                              "current-page":
                                _vm.pagination.documents.current_page,
                              "page-size": _vm.pagination.documents.per_page
                            },
                            on: {
                              "current-change": _vm.getRecordsByFilter,
                              "update:currentPage": function($event) {
                                return _vm.$set(
                                  _vm.pagination.documents,
                                  "current_page",
                                  $event
                                )
                              },
                              "update:current-page": function($event) {
                                return _vm.$set(
                                  _vm.pagination.documents,
                                  "current_page",
                                  $event
                                )
                              }
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "table-responsive" }, [
                        _c(
                          "table",
                          {
                            staticClass:
                              "table table-hover table-striped table-condensed  table-responsive",
                            staticStyle: {
                              width: "100%",
                              "white-space": "nowrap"
                            }
                          },
                          [
                            _c("thead", [
                              _c(
                                "tr",
                                { attrs: { slot: "heading" }, slot: "heading" },
                                [
                                  _c("th", [_vm._v("#")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("Almacen")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("COD. INTERNO")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("PRODUCTO")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("SERIE")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("CLIENTE")]),
                                  _vm._v(" "),
                                  _c("th"),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("NR. DOC.")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("F. VENTA")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("P. VENTA")])
                                ]
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "tbody",
                              _vm._l(_vm.records, function(row, index) {
                                return _c("tr", { key: index }, [
                                  _c("td", [_vm._v(_vm._s(index + 1))]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.establish_description) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.codigoInterno) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.descripcion) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.series) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.pers_name) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    [
                                      _c(
                                        "el-button",
                                        {
                                          attrs: {
                                            type: "success",
                                            size: "mini"
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.openWhastappForm(row)
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass:
                                              "icofont-brand-whatsapp"
                                          })
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "el-button",
                                        {
                                          attrs: {
                                            size: "mini",
                                            type: "primary"
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.printDocument(row)
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "icofont-print"
                                          })
                                        ]
                                      )
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.docSeries) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.docDate) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", { staticClass: "text-center" }, [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(
                                          Number(row.itemValue).toFixed(2)
                                        ) +
                                        "\n                                            "
                                    )
                                  ])
                                ])
                              }),
                              0
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div")
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-tab-pane",
                    {
                      attrs: { label: "Notas De ventas ", name: "SalesNotes" }
                    },
                    [
                      _c(
                        "div",
                        { staticClass: "row" },
                        [
                          _c("el-pagination", {
                            attrs: {
                              layout: "total, prev, pager, next",
                              total: _vm.pagination.saleNotes.total,
                              "current-page":
                                _vm.pagination.saleNotes.current_page,
                              "page-size": _vm.pagination.saleNotes.per_page
                            },
                            on: {
                              "current-change": _vm.getRecordsByFilter,
                              "update:currentPage": function($event) {
                                return _vm.$set(
                                  _vm.pagination.saleNotes,
                                  "current_page",
                                  $event
                                )
                              },
                              "update:current-page": function($event) {
                                return _vm.$set(
                                  _vm.pagination.saleNotes,
                                  "current_page",
                                  $event
                                )
                              }
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "table-responsive" }, [
                        _c(
                          "table",
                          {
                            staticClass:
                              "table table-hover table-striped table-condensed  table-responsive",
                            staticStyle: {
                              width: "100%",
                              "white-space": "nowrap"
                            }
                          },
                          [
                            _c("thead", [
                              _c(
                                "tr",
                                { attrs: { slot: "heading" }, slot: "heading" },
                                [
                                  _c("th", [_vm._v("#")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("Almacen")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("COD. INTERNO")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("PRODUCTO")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("SERIE")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("CLIENTE")]),
                                  _vm._v(" "),
                                  _c("th"),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("NR. DOC.")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("F. VENTA")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("P. VENTA")])
                                ]
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "tbody",
                              _vm._l(_vm.NotasDeventas, function(row, index) {
                                return _c("tr", { key: index }, [
                                  _c("td", [_vm._v(_vm._s(index + 1))]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.establish_description) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.codigoInterno) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.descripcion) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.series) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.pers_name) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    [
                                      _c(
                                        "el-button",
                                        {
                                          attrs: {
                                            type: "success",
                                            size: "mini"
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.openWhastappForm(row)
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass:
                                              "icofont-brand-whatsapp"
                                          })
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "el-button",
                                        {
                                          attrs: {
                                            size: "mini",
                                            type: "primary"
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.printDocument(row)
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "icofont-print"
                                          })
                                        ]
                                      )
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.docSeries) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(row.docDate) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", { staticClass: "text-center" }, [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(
                                          Number(row.itemValue).toFixed(2)
                                        ) +
                                        "\n                                            "
                                    )
                                  ])
                                ])
                              }),
                              0
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div")
                      ])
                    ]
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-dialog",
                {
                  attrs: {
                    title: "Enviar Reporte Por Whastapp",
                    visible: _vm.showWhatsappForm,
                    width: "30%"
                  },
                  on: {
                    "update:visible": function($event) {
                      _vm.showWhatsappForm = $event
                    },
                    close: function($event) {
                      _vm.showWhatsappForm = false
                    }
                  }
                },
                [
                  _c(
                    "div",
                    { staticClass: "row col-12" },
                    [
                      _c(
                        "el-input",
                        {
                          staticClass: "mt-3",
                          attrs: {
                            placeholder: "ingrese numero para enviar ",
                            size: "small",
                            clearable: ""
                          },
                          model: {
                            value: _vm.numeroWhatsapp,
                            callback: function($$v) {
                              _vm.numeroWhatsapp = $$v
                            },
                            expression: "numeroWhatsapp"
                          }
                        },
                        [
                          _vm._v(
                            "Numero a enviar\n                            "
                          )
                        ]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "span",
                    { attrs: { slot: "footer" }, slot: "footer" },
                    [
                      _c(
                        "el-button",
                        {
                          on: {
                            click: function($event) {
                              _vm.showWhatsappForm = false
                            }
                          }
                        },
                        [_vm._v("Cancel")]
                      ),
                      _vm._v(" "),
                      _c(
                        "el-button",
                        {
                          attrs: {
                            loading: _vm.loadbuttonwhats,
                            type: "primary"
                          },
                          on: {
                            click: function($event) {
                              return _vm.SendReportWhasapp()
                            }
                          }
                        },
                        [_vm._v("Enviar")]
                      )
                    ],
                    1
                  )
                ]
              ),
              _vm._v(" "),
              _c("whatsapp-modal", {
                attrs: {
                  company: _vm.company,
                  documentId: _vm.documentId,
                  documentTypeId: _vm.documentTypeId,
                  documentNumber: _vm.documentNumber,
                  sender: _vm.sender,
                  establishment: _vm.establishment,
                  showDialog: _vm.showModalWhatsapp
                },
                on: {
                  "update:showDialog": function($event) {
                    _vm.showModalWhatsapp = $event
                  },
                  "update:show-dialog": function($event) {
                    _vm.showModalWhatsapp = $event
                  }
                }
              })
            ],
            1
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
      _c("div", { staticClass: "page-header" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-sm-6" }, [
            _c("h6", [_c("span", [_vm._v("Reporte de Series Vendidas")])]),
            _vm._v(" "),
            _c("ol", { staticClass: "breadcrumb" }, [
              _c("li", { staticClass: "breadcrumb-item" }, [
                _c("a", { attrs: { href: "/dashboard" } }, [
                  _vm._v("Dashboard")
                ])
              ]),
              _vm._v(" "),
              _c("li", { staticClass: "breadcrumb-item active" }, [
                _c("span", { staticClass: "text-muted" }, [
                  _vm._v("Reporte de Series Vendidas")
                ])
              ])
            ])
          ])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header bg-primary" }, [
      _c("h6", { staticClass: "my-0 text-white" }, [_vm._v("Series Vendidas")])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-a8f565a2", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/sellers/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/sellers/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-57591e1e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/sellers/form.vue")
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
Component.options.__file = "resources/js/views/sellers/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-57591e1e", Component.options)
  } else {
    hotAPI.reload("data-v-57591e1e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/sellers/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/sellers/index.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0b2a4c30\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/sellers/index.vue")
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
Component.options.__file = "resources/js/views/sellers/index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0b2a4c30", Component.options)
  } else {
    hotAPI.reload("data-v-0b2a4c30", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=reporte-series-vendidas.js.map