webpackJsonp([127],{

/***/ "./modules/College/Resources/assets/js/components/payment_college.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-89779052\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/components/payment_college.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/payment_college.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-89779052\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/payment_college.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/components/payment_college.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-89779052", Component.options)
  } else {
    hotAPI.reload("data-v-89779052", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/payment_college.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_lodash__ = __webpack_require__("./node_modules/lodash/lodash.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_lodash___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_lodash__);
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }



function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
// import * as shajs from 'sha.js';


var RegisterForm = function RegisterForm() {
  return __webpack_require__.e/* import() */(130/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/views/classrooms/register_form.vue"));
};

var ServiceForm = function ServiceForm() {
  return __webpack_require__.e/* import() */(225).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/service_form.vue"));
};

var IncompleteForm = function IncompleteForm() {
  return __webpack_require__.e/* import() */(226).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/payment_incomplete.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    RegisterForm: RegisterForm,
    ServiceForm: ServiceForm,
    IncompleteForm: IncompleteForm
  },
  props: ["record", "title", "customer_default", "is_payment", "member", "configuration", "desarrollador", "personalWhatsapp", "type", "student", "classroomId", "plan", "register", "services", "payable"],
  watch: {
    all_customers: function all_customers(newCustomer, _) {
      this.customers = newCustomer.filter(function (n) {
        return n.number != "88888888";
      });
    }
  },
  data: function data() {
    var _ref;

    return _ref = {
      incomplete: false,
      cash_id: null,
      documentId: null,
      registerId: null,
      showDialog: false,
      series: [],
      affectationIgvTypes: [],
      establishments: null,
      methodPayment: [],
      currencyTypes: [],
      documentsType: [],
      variation: null,
      form: {
        college: true,
        afectar_caja: true,
        orden_id: null,
        customer_telephone: null,
        restaurant: true,
        total_rounded: 0.0,
        total_payment: 0.0,
        establishment_id: null,
        series_id: null,
        prefix: null,
        number: "#",
        date_of_issue: moment().format("YYYY-MM-DD"),
        time_of_issue: moment().format("HH:mm:ss"),
        currency_type_id: "PEN",
        purchase_order: null,
        exchange_rate_sale: 1,
        total_prepayment: 0,
        total_charge: 0,
        total_discount: 0,
        total_exportation: 0,
        total_free: 0,
        total_taxed: 0,
        total_unaffected: 0,
        total_exonerated: 0,
        total_igv: 0,
        total_base_isc: 0,
        total_isc: 0,
        total_base_other_taxes: 0,
        total_other_taxes: 0,
        total_taxes: 0,
        total_value: 0,
        total: 0,
        operation_type_id: "0101",
        date_of_due: moment().format("YYYY-MM-DD"),
        items: [],
        charges: [],
        discounts: [],
        attributes: [],
        guides: [],
        payments: [],
        hotel: {},
        additional_information: null,
        payment_condition_id: "01",
        printerOn: false,
        actions: {
          format_pdf: "a4"
        },
        difference: 0.0,
        enter_amount: 0.0,
        method_pay: "Efectivo",
        commands_fisico: null,
        to_carry: false,
        document_type_id: "01" //  customer_id: 1

      },
      user: null,
      company: null,
      categories: [],
      observation: null,
      percentage_igv: 18,
      started: true,
      refCustomer: null,
      currentDocumentsType: [],
      time: null,
      splitPayments: [],
      splitProducts: [],
      isInterno: false,
      showSplitPayment: false,
      currencyTypeActive: {
        symbol: "S/ "
      },
      currentPayments: [],
      input_person: {},
      customer: null,
      value: null,
      paymentsValue: {
        "01": "Efectivo",
        "02": "Culqui",
        "03": "Yape",
        "04": "PLIN",
        "05": "TARJETA: IZYPAY",
        "06": "TARJETA: NIUBIZ"
      },
      last_number: {},
      showDialogNewPerson: false,
      loading: false,
      enabled_discount: false,
      discount_amount: 0,
      loading_submit: false,
      showDialogOptions: false,
      showDialogMultiplePayment: false,
      showDialogSaleNote: false,
      showDialogNewCardBrand: false,
      documentNewId: null,
      saleNotesNewId: null,
      resource_options: null,
      has_card: false,
      method_payments: "01",
      number: null,
      resource: "pos",
      resource_documents: "documents",
      resource_payments: "document_payments",
      amount: 0,
      printerOn: 0,
      button_payment: false,
      input_item: "",
      form_payment: {}
    }, _defineProperty(_ref, "series", []), _defineProperty(_ref, "cards_brand", []), _defineProperty(_ref, "cancel", false), _defineProperty(_ref, "form_cash_document", {}), _defineProperty(_ref, "formRegister", null), _defineProperty(_ref, "statusDocument", {}), _defineProperty(_ref, "cashes", []), _defineProperty(_ref, "payment_method_types", []), _defineProperty(_ref, "last_date", null), _defineProperty(_ref, "customers", []), _defineProperty(_ref, "datEmision", {
      disabledDate: function disabledDate(time) {
        return time.getTime() > moment();
      }
    }), _defineProperty(_ref, "activeColo", "black"), _defineProperty(_ref, "socket", null), _ref;
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
              _this.loading = true;
              _this.currentDocumentsType = _this.documentsType;
              _this.form.identity_document_type_id = _this.currentDocumentsType[0].id; // this.form.customer_id = this.establishments.customer_id;
              // this.value = this.establishments.customer_id;

              _this.isInterno = _this.company.soap_type_id == "03"; // await this.date_of_issue();
              // await this.getLastNumbersDocument();

              _context.next = 8;
              return _this.initFormPayment();

            case 8:
              _context.next = 10;
              return _this.getFormPosLocalStorage();

            case 10:
              qz.security.setCertificatePromise(function (resolve, reject) {
                _this.$http.get("/api/qz/crt/override", {
                  responseType: "text"
                }).then(function (response) {
                  resolve(response.data);
                })["catch"](function (error) {
                  reject(error.data);
                });
              });
              qz.security.setSignaturePromise(function (toSign) {
                return function (resolve, reject) {
                  _this.$http.post("/api/qz/signing", {
                    request: toSign
                  }).then(function (response) {
                    resolve(response.data);
                  })["catch"](function (error) {
                    reject(error.data);
                  });
                };
              });

              _this.setAmountCash(_this.form.total); // this.filterSeries();


              _this.loading = false;

              _this.socketWhatsappConfig();

            case 15:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    changePrice: function changePrice(price) {
      //45
      //
      var countItems = this.form.items.length;
      var div = Math.floor(price / countItems);
      this.form.items = this.form.items.map(function (i) {
        return _objectSpread(_objectSpread({}, i), {}, {
          sale_unit_price: div,
          total: div,
          total_base_igv: div,
          total_value: div,
          unit_price: div,
          unit_price_value: div,
          unit_value: div
        });
      });
      var newTotalItems = div * countItems;
      var diff = price - newTotalItems;

      if (diff != 0) {
        var _price = this.form.items[0].total + diff;

        this.form.items[0] = _objectSpread(_objectSpread({}, this.form.items[0]), {}, {
          sale_unit_price: _price,
          total: _price,
          total_base_igv: _price,
          total_value: _price,
          unit_price: _price,
          unit_price_value: _price,
          unit_value: _price
        });
      }
    },
    getFile: function getFile(_ref2) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var documentId, documentTypeId, number, message, response, _response$data, pdf, xml, name, basicMessage, msg, _response;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                documentId = _ref2.documentId, documentTypeId = _ref2.documentTypeId, number = _ref2.number, message = _ref2.message;
                _context2.prev = 1;
                _context2.next = 4;
                return _this2.$http.post("/whatsapp/get-file", {
                  document_id: documentId,
                  document_type_id: documentTypeId
                });

              case 4:
                response = _context2.sent;
                _response$data = response.data, pdf = _response$data.pdf, xml = _response$data.xml, name = _response$data.name;
                basicMessage = "Su comprobante de pago electrónico " + name + " de *" + _this2.company.name + "*, ha sido generado correctamente a través del facturador electrónico de" + "*" + _this2.$desarrollador + "*";

                if (message) {
                  basicMessage += "\n" + message;
                }

                _this2.socket.emit("basicMessage", {
                  message: basicMessage,
                  sender: _this2.sender,
                  number: "51".concat(number)
                }); // file, name, number, sender }


                _this2.socket.emit("sendFile", {
                  file: pdf,
                  name: "".concat(name, ".pdf"),
                  number: "51".concat(number),
                  sender: _this2.sender
                });

                if (xml) {
                  _this2.socket.emit("sendFile", {
                    file: xml,
                    name: "".concat(name, ".xml"),
                    number: "51".concat(number),
                    sender: _this2.sender
                  });
                }

                _context2.next = 19;
                break;

              case 13:
                _context2.prev = 13;
                _context2.t0 = _context2["catch"](1);
                msg = "Ocurrió un error";

                if (_context2.t0.response) {
                  _response = _context2.t0.response;

                  if (_response.status == 404) {
                    msg = "No se encontró la ruta";
                  } else {
                    msg = _response.data.message;
                  }
                }

                _this2.$toast.error(msg);

                console.log(_context2.t0);

              case 19:
                _context2.prev = 19;
                return _context2.finish(19);

              case 21:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[1, 13, 19, 21]]);
      }))();
    },
    socketWhatsappConfig: function socketWhatsappConfig() {
      var _this3 = this;

      var hostName = window.location.hostname;
      var url = "https://".concat(hostName);
      this.sender = hostName.replace(/https?\:\/\//, "").replace("/", "").split(".").join("");

      try {
        this.socket = io.connect(this.$socketUrl);
      } catch (e) {
        console.log(e);
      }

      this.socket.on("connected", function (_ref3) {
        var message = _ref3.message;

        _this3.$toast.success(message);

        _this3.socket.emit("getStatus", url);
      });
      this.socket.on("setStatus", function (_ref4) {
        var status = _ref4.status,
            sender = _ref4.sender;

        if (!status) {
          _this3.sender = "sdrimsac";

          _this3.$toast.warning("Sesión iniciada con SDRIMSAC");
        } else {
          _this3.sender = sender;

          _this3.$toast.success("Whatsapp Listo!");
        }
      }); //MessageResponse

      this.socket.on("MessageResponse", function (_ref5) {
        var success = _ref5.success,
            message = _ref5.message;

        if (success) {
          _this3.$toast.success(message);
        } else {
          _this3.$toast.error(message);
        }
      });
    },
    updateCustomer: function updateCustomer(person) {
      console.log(person);
      this.form.customer = person;
      this.form.customer_id = person.id;
      this.form.customer_telephone = person.telephone;
    },
    updateObservation: function updateObservation(obs) {
      this.observation = obs;
      this.$forceUpdate();
    },
    open: function open() {
      var _this4 = this;

      this.incomplete = false;
      this.currentPayments = [];
      this.form.total = 0;
      this.form.customer_telephone = null;
      this.form.enter_amount = undefined;
      this.form.difference = 0;
      this.observation = null;
      this.documentId = null;
      this.registerId = null;
      setTimeout(function () {
        if (_this4.type == "service") {
          var _this4$$refs$service;

          (_this4$$refs$service = _this4.$refs.service) === null || _this4$$refs$service === void 0 ? void 0 : _this4$$refs$service.getTables();
        } else if (_this4.type == "register") {
          var _this4$$refs$register;

          (_this4$$refs$register = _this4.$refs.register) === null || _this4$$refs$register === void 0 ? void 0 : _this4$$refs$register.getTables();
        } else {
          var _this4$$refs$incomple;

          (_this4$$refs$incomple = _this4.$refs.incomplete) === null || _this4$$refs$incomple === void 0 ? void 0 : _this4$$refs$incomple.getTables();
        }
      }, 250);

      if (this.type == "incomplete") {
        this.form.items = this.services.map(function (s) {
          s.item.sale_unit_price = s.price;
          s.item.percentage_igv = 18;
          return s.item;
        });
      } // this.form = { ...this.paymentForm };

    },
    createFormIncomplete: function createFormIncomplete(register) {
      this.formRegister = register;
    },
    createFormRegister: function createFormRegister(register) {
      register.classroom_id = this.record.id;
      this.formRegister = register;
    },
    createFormService: function createFormService(register) {
      register.classroom_id = this.classroomId;
      this.formRegister = register;
    },
    updateTotal: function updateTotal(total) {
      this.form.total = total;
    },
    updateItems: function updateItems(items) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this5.form.items = items;

                _this5.formatItems();

                _this5.reCalculateTotal();

                _this5.form.enter_amount = _this5.form.total;
                _context3.next = 6;
                return _this5.$refs.enter_amount.$el.getElementsByTa;

              case 6:
                _context3.next = 8;
                return _this5.$refs.enter_amount.$el.getElementsByTagName("input")[0].select();

              case 8:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getTables: function getTables() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response, _response$data2, affectation_igv_types, establishment, method_payment, currency_types, documents_type, series, user, company, categories, cash_id;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.prev = 0;
                _this6.loading = true;
                _context4.next = 4;
                return _this6.$http.get("/college/registers/payment_tables");

              case 4:
                response = _context4.sent;
                _response$data2 = response.data, affectation_igv_types = _response$data2.affectation_igv_types, establishment = _response$data2.establishment, method_payment = _response$data2.method_payment, currency_types = _response$data2.currency_types, documents_type = _response$data2.documents_type, series = _response$data2.series, user = _response$data2.user, company = _response$data2.company, categories = _response$data2.categories, cash_id = _response$data2.cash_id;
                _this6.cash_id = cash_id;
                _this6.affectationIgvTypes = affectation_igv_types;
                _this6.establishments = establishment;
                _this6.methodPayment = method_payment;
                _this6.currencyTypes = currency_types;
                _this6.series = series;
                _this6.documentsType = documents_type;
                _this6.user = user;
                _this6.company = company;
                _this6.categories = categories;
                _this6.form.user_id = _this6.user.id;
                _this6.form.establishment_id = _this6.establishments.id;
                _context4.next = 24;
                break;

              case 20:
                _context4.prev = 20;
                _context4.t0 = _context4["catch"](0);
                console.log(_context4.t0);

                _this6.$toast.error("Ocurrió un problema");

              case 24:
                _context4.prev = 24;
                _this6.loading = false;
                return _context4.finish(24);

              case 27:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, null, [[0, 20, 24, 27]]);
      }))();
    },
    existNumber: function existNumber() {
      var number = this.form.customer_telephone;

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
    createClient: function createClient() {
      this.value = null;
      this.form.document_type_id;
      this.form.customer_id = null;
      this.showDialogNewPerson = true;
    },
    reloadDataCustomers: function reloadDataCustomers(customer_id) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _this7.$http.get("/pos/table/customers").then( /*#__PURE__*/function () {
                  var _ref6 = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5(response) {
                    return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
                      while (1) {
                        switch (_context5.prev = _context5.next) {
                          case 0:
                            _context5.next = 2;
                            return _this7.$emit("update:all_customers", response.data);

                          case 2:
                            _this7.value = customer_id;
                            _this7.form.customer_id = customer_id;

                            _this7.changeCustomer();

                          case 5:
                          case "end":
                            return _context5.stop();
                        }
                      }
                    }, _callee5);
                  }));

                  return function (_x) {
                    return _ref6.apply(this, arguments);
                  };
                }());

              case 1:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    totalItemSelected: function totalItemSelected(products) {
      var total = 0;
      products.forEach(function (p) {
        total += p.quantity * p.price;
      });
      return __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total, 2);
    },
    receivePayments: function receivePayments(payments) {
      this.splitPayments = payments;
    },
    receiveProducts: function receiveProducts(payments) {
      this.splitProducts = payments;
    },
    removePayment: function removePayment(id) {
      this.currentPayments = this.currentPayments.filter(function (c) {
        return c.id != id;
      });
      this.enterAmount();
    },
    addPayment: function addPayment() {
      var id = this.currentPayments.length + 1;
      var method = this.paymentsValue[this.method_payments];

      if (this.form.enter_amount != "" && !isNaN(this.form.enter_amount) && this.form.enter_amount != undefined) {
        this.currentPayments.push({
          id: id,
          method_payment_id: this.method_payments,
          method: method,
          amount: this.form.enter_amount
        });
      }
    },
    customerForm: function customerForm(isNew) {
      if (isNew) {
        this.form.customer_id = undefined;
      } else {
        this.form.customer_id = this.value;
      }

      this.showDialogNewPerson = true;
    },
    add_customer: function add_customer(value) {},
    reloadDataPersons: function reloadDataPersons() {},
    keyupCustomer: function keyupCustomer(e) {
      var _this8 = this;

      //buscar
      if (this.time) {
        clearTimeout(this.time);
      }

      this.time = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee7() {
        var response, persons;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _this8.input_person.number = _this8.$refs.select_person.$el.getElementsByTagName("input")[0].value;
                _context7.next = 3;
                return _this8.$http("/caja/search_customers?value=".concat(_this8.input_person.number));

              case 3:
                response = _context7.sent;
                persons = response.data.persons;
                _this8.customers = persons.filter(function (n) {
                  return n.number != "88888888";
                });

                _this8.updateAllCustomers(_this8.customers);

              case 7:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      })), 500);
    },
    updateAllCustomers: function updateAllCustomers(personsFromServer) {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee8() {
        var ids, persons, _iterator, _step, _loop, newData;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                ids = _this9.all_customers.map(function (c) {
                  return c.id;
                });
                persons = [];
                _iterator = _createForOfIteratorHelper(personsFromServer);

                try {
                  _loop = function _loop() {
                    var person = _step.value;
                    var existInList = ids.find(function (p) {
                      return p == person.id;
                    });

                    if (existInList == undefined) {
                      persons.push(person);
                    }
                  };

                  for (_iterator.s(); !(_step = _iterator.n()).done;) {
                    _loop();
                  }
                } catch (err) {
                  _iterator.e(err);
                } finally {
                  _iterator.f();
                }

                newData = [].concat(_toConsumableArray(_this9.all_customers), persons);

                if (!(persons.length != 0)) {
                  _context8.next = 8;
                  break;
                }

                _context8.next = 8;
                return _this9.$emit("update:all_customers", newData);

              case 8:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    changeCustomer: function changeCustomer() {
      this.form.customer_id = this.value;

      var customer = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.customers, {
        id: this.form.customer_id
      });

      if (customer != null) {
        this.customer = customer;

        if (this.form.document_type_id != "80") {
          if (customer.identity_document_type_id == "1" || customer.identity_document_type_id == "4") {
            this.form.document_type_id = "03";
          } else {
            this.form.document_type_id = "01";
          }
        }

        this.form.customer_telephone = customer.phone;
        this.setLocalStorageIndex("customer", this.customer);
      }

      this.setSeries();
    },
    setLocalStorageIndex: function setLocalStorageIndex(key, obj) {
      localStorage.setItem(key, JSON.stringify(obj));
    },
    getLastNumbersDocument: function getLastNumbersDocument() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee9() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                _context9.next = 2;
                return _this10.$http.post("".concat(_this10.resource, "/last_number_documents"), {
                  series: _this10.all_series,
                  ordenId: _this10.idOrden
                });

              case 2:
                response = _context9.sent;

                if (response.status == 200) {
                  _this10.last_number = response.data.result;
                  _this10.refCustomer = response.data.customer;

                  if (_this10.refCustomer != null) {
                    _this10.refCustomer.description = "".concat(_this10.refCustomer.number, " - ").concat(_this10.refCustomer.name);
                    _this10.customers = [_this10.refCustomer].concat(_toConsumableArray(_this10.customers.filter(function (f) {
                      return f.id != _this10.refCustomer.id && f.number != "88888888";
                    })));
                    _this10.value = _this10.refCustomer.id;
                  }
                }

              case 4:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    changeEnabledDiscount: function changeEnabledDiscount() {
      if (!this.enabled_discount) {
        this.discount_amount = 0;
        this.deleteDiscountGlobal();
        this.reCalculateTotal();
      }
    },
    teclasInit: function teclasInit() {
      var _this11 = this;

      document.onkeydown = function (e) {
        var key = e.key;

        if (key == "F4") {//Agregar cliente
          // this.clickPayment();
        }

        if (key == "F6") {//Agregar Producto
          //this.clickAddItemInvoice()
          //return false;
        }

        if (key == "F7" && _this11.form.items.length > 0) {//Guardar
          // this.submit()
        }

        if (key == "F8") {//Cancelar
          // this.close()
        }
      };
    },
    date_of_issue: function date_of_issue() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee10() {
        var form_efectivo, response_efectivo;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                // this.form.customer_id
                _this12.customers = _this12.all_customers.filter(function (n) {
                  return n.number != "88888888";
                });
                _this12.customers = [].concat(_toConsumableArray(_this12.customers.filter(function (c) {
                  return c.id != _this12.customer_default.id;
                })), [_this12.customer_default]);

                if (_this12.establishments.customer_id) {
                  _this12.value = _this12.establishments.customer_id;
                  _this12.form.customer_id = _this12.establishments.customer_id;
                }

                form_efectivo = {
                  enter_amount: 0,
                  difference: 0
                };
                _context10.next = 6;
                return _this12.$http.post("/efectivo", form_efectivo);

              case 6:
                response_efectivo = _context10.sent;

              case 7:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    Printer: function Printer(_Printer, linkpdf, copies) {
      var _arguments = arguments,
          _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee11() {
        var auth, multiple_boxes, config, data, _index, _config, _data, _index2;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                auth = _arguments.length > 3 && _arguments[3] !== undefined ? _arguments[3] : null;
                multiple_boxes = _arguments.length > 4 && _arguments[4] !== undefined ? _arguments[4] : false;
                qz.security.setCertificatePromise(function (resolve, reject) {
                  _this13.$http.get("/api/qz/crt/override", {
                    responseType: "text"
                  }).then(function (response) {
                    resolve(response.data);
                  })["catch"](function (error) {
                    reject(error.data);
                  });
                });
                qz.security.setSignaturePromise(function (toSign) {
                  return function (resolve, reject) {
                    _this13.$http.post("/api/qz/signing", {
                      request: toSign
                    }).then(function (response) {
                      resolve(response.data);
                    })["catch"](function (error) {
                      reject(error.data);
                    });
                  };
                });

                if (!(_this13.printerOn == 1)) {
                  _context11.next = 22;
                  break;
                }

                if (!(multiple_boxes == true)) {
                  _context11.next = 14;
                  break;
                }

                if (false) {
                  _context11.next = 14;
                  break;
                }

                config = qz.configs.create(_Printer, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context11.next = 11;
                  break;
                }

                _context11.next = 11;
                return qz.websocket.connect(config);

              case 11:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: linkpdf
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this13.$toast.error(e.message);
                });

                for (_index = 0; _index < copies; _index++) {
                  qz.print(config, data)["catch"](function (e) {
                    _this13.$toast.error(e.message);
                  });
                }

              case 14:
                if (!(multiple_boxes == false)) {
                  _context11.next = 22;
                  break;
                }

                _config = qz.configs.create(_Printer, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context11.next = 19;
                  break;
                }

                _context11.next = 19;
                return qz.websocket.connect(_config);

              case 19:
                _data = [{
                  type: "pdf",
                  format: "file",
                  data: linkpdf
                }];
                qz.print(_config, _data)["catch"](function (e) {
                  _this13.$toast.error(e.message);
                });

                for (_index2 = 0; _index2 < copies; _index2++) {
                  qz.print(_config, _data)["catch"](function (e) {
                    _this13.$toast.error(e.message);
                  });
                }

              case 22:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    clickSendWhatsapp: function clickSendWhatsapp(document_type_id, document_id, number) {
      var _arguments2 = arguments,
          _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee12() {
        var form, formWhatsapp, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                form = _arguments2.length > 3 && _arguments2[3] !== undefined ? _arguments2[3] : {};

                if (!(form.customer_telephone != null)) {
                  _context12.next = 23;
                  break;
                }

                formWhatsapp = {
                  id: _this14.recordId,
                  document_id: document_id,
                  document_type_id: document_type_id,
                  customer_telephone: form.customer_telephone,
                  sender: "sdrimsac",
                  mensaje: "Su comprobante de pago electrónico " + number + " de *" + _this14.company.name + "*, ha sido generado correctamente a través del facturador electrónico de " + "*" + _this14.$desarrollador + "*"
                };
                _context12.prev = 3;
                _this14.loading = true;
                _context12.next = 7;
                return _this14.$http.post("/whatsapp", formWhatsapp);

              case 7:
                response = _context12.sent;

                if (response.data.success == true) {
                  _this14.$toast.success(response.data.message);

                  _this14.loading = false;
                }

                if (!(_this14.configuration.xml_whatsapp && document_type_id != "80")) {
                  _context12.next = 15;
                  break;
                }

                formWhatsapp.xml = true;
                _context12.next = 13;
                return _this14.$http.post("/whatsapp", formWhatsapp);

              case 13:
                response = _context12.sent;

                if (response.data.success == true) {
                  _this14.$toast.success(response.data.message);

                  _this14.loading = false;
                }

              case 15:
                _context12.next = 20;
                break;

              case 17:
                _context12.prev = 17;
                _context12.t0 = _context12["catch"](3);
                console.log(_context12.t0, " error");

              case 20:
                _context12.prev = 20;
                _this14.loading = false;
                return _context12.finish(20);

              case 23:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12, null, [[3, 17, 20, 23]]);
      }))();
    },
    changeDateOfIssue: function changeDateOfIssue() {
      var _this15 = this;

      this.form.date_of_due = this.form.date_of_issue;

      if (moment(this.form.date_of_issue) < moment().day(-1) && this.configuration.restrict_receipt_date) {
        this.$toast.error("No puede seleccionar una fecha menor a 6 días.");
        this.dateValid = false;
      } else {
        this.dateValid = true;
      }

      this.form.date_of_due = this.form.date_of_issue;
      this.searchExchangeRateByDate(this.form.date_of_issue).then(function (response) {
        _this15.form.exchange_rate_sale = response;
      });
      this.form.exchange_rate_sale = 1;
    },
    NuevaVenta: function NuevaVenta() {
      this.$parent.nueva_venta();
    },
    setInitialAmount: function setInitialAmount() {
      var _this16 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee13() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                _this16.enter_amount = _this16.form.total;
                _this16.form.payments = [];
                _context13.next = 4;
                return _this16.$refs.enter_amount.$el.getElementsByTagName("input")[0].focus();

              case 4:
                _context13.next = 6;
                return _this16.$refs.enter_amount.$el.getElementsByTagName("input")[0].select();

              case 6:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    inputDiscountAmount: function inputDiscountAmount() {
      if (this.enabled_discount) {
        if (this.discount_amount && !isNaN(this.discount_amount) && parseFloat(this.discount_amount) > 0) {
          if (this.discount_amount >= this.form.total) return this.$toast.error("El monto de descuento debe ser menor al total de venta");
          this.reCalculateTotal();
        } else {
          this.deleteDiscountGlobal();
          this.reCalculateTotal();
        }
      }
    },
    discountGlobal: function discountGlobal() {
      var global_discount = parseFloat(this.discount_amount);
      var base = parseFloat(this.form.total);
      var amount = parseFloat(global_discount);

      var factor = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount / base, 4);

      var discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.form.discounts, {
        discount_type_id: "03"
      });

      if (global_discount > 0 && !discount) {
        this.form.total_discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount, 2);
        this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total - amount, 2);
        this.form.total_value = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total / (1 + this.percentage_igv / 100), 2);
        this.form.total_taxed = this.form.total_value;
        this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total_value * (this.percentage_igv / 100), 2);
        this.form.total_taxes = this.form.total_igv;
        this.form.discounts.push({
          discount_type_id: "03",
          description: "Descuentos globales que no afectan la base imponible del IGV/IVAP",
          factor: factor,
          amount: amount,
          base: base
        });
      } else {
        var _index3 = this.form.discounts.indexOf(discount);

        if (_index3 > -1) {
          this.form.total_discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount, 2);
          this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total - amount, 2);
          this.form.total_value = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total / (1 + this.percentage_igv / 100), 2);
          this.form.total_taxed = this.form.total_value;
          this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total_value * (this.percentage_igv / 100), 2);
          this.form.total_taxes = this.form.total_igv;
          this.form.discounts[_index3].base = base;
          this.form.discounts[_index3].amount = amount;
          this.form.discounts[_index3].factor = factor;
        }
      }
    },
    method_payment: function method_payment(method_pay) {
      this.form.payment_condition_id = "01";
      this.form.method_pay = method_pay;
      this.form.afectar_caja = true;
    },
    reCalculateTotal: function reCalculateTotal() {
      var total_discount = 0;
      var total_charge = 0;
      var total_exportation = 0;
      var total_taxed = 0;
      var total_exonerated = 0;
      var total_unaffected = 0;
      var total_free = 0;
      var total_igv = 0;
      var total_value = 0;
      var total = 0;
      var total_plastic_bag_taxes = 0;
      console.log(this.form.items);
      this.form.items.forEach(function (row) {
        total_discount += parseFloat(row.total_discount);
        total_charge += parseFloat(row.total_charge);

        if (row.affectation_igv_type_id === "10") {
          total_taxed += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "20") {
          total_exonerated += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "30") {
          total_unaffected += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "40") {
          total_exportation += parseFloat(row.total_value);
        }

        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) < 0) {
          total_free += parseFloat(row.total_value);
        }

        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) > -1) {
          total_igv += parseFloat(row.total_igv);
          total += parseFloat(row.total);
        }

        total_value += parseFloat(row.total_value);
        total_plastic_bag_taxes += isNaN(parseFloat(row.total_plastic_bag_taxes)) ? 0.0 : parseFloat(row.total_plastic_bag_taxes);
      });
      this.form.total_exportation = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_exportation, 2);
      this.form.total_taxed = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_taxed, 2);
      this.form.total_exonerated = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_exonerated, 2);
      this.form.total_unaffected = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_unaffected, 2);
      this.form.total_free = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_free, 2);
      this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_igv, 2);
      this.form.total_value = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_value, 2);
      this.form.total_taxes = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_igv, 2);
      this.form.total_plastic_bag_taxes = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_plastic_bag_taxes, 2);
      this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total, 2); // this.form.total = _.round(
      //     total + this.form.total_plastic_bag_taxes,
      //     2
      // );
      // this.discountGlobal();
      // this.form.difference =
      //     this.form.total - (this.form.enter_amount || 0);
    },
    deleteDiscountGlobal: function deleteDiscountGlobal() {
      var discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.form.discounts, {
        discount_type_id: "03"
      });

      var index = this.form.discounts.indexOf(discount);

      if (index > -1) {
        this.form.discounts.splice(index, 1);
        this.form.total_discount = 0;
      }
    },
    getFormPosLocalStorage: function getFormPosLocalStorage() {
      var form_pos = localStorage.getItem("form_pos");
      form_pos = JSON.parse(form_pos);

      if (form_pos) {
        this.form.payments = form_pos.payments;
      }
    },
    clickAddPayment: function clickAddPayment() {
      this.showDialogMultiplePayment = true;
    },
    reloadDataCardBrands: function reloadDataCardBrands(card_brand_id) {
      var _this17 = this;

      this.$http.get("/".concat(this.resource, "/table/card_brands")).then(function (response) {
        _this17.cards_brand = response.data;
        _this17.form_payment.card_brand_id = card_brand_id;

        _this17.changePaymentMethodType();
      });
    },
    getDescriptionPaymentMethodType: function getDescriptionPaymentMethodType(id) {
      var payment_method_type = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.payment_method_types, {
        id: id
      });

      return payment_method_type ? payment_method_type.description : "";
    },
    changePaymentMethodType: function changePaymentMethodType() {
      var payment_method_type = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.payment_method_types, {
        id: this.form_payment.payment_method_type_id
      });

      this.has_card = payment_method_type.has_card;
      this.form_payment.card_brand_id = payment_method_type.has_card ? this.form_payment.card_brand_id : null;
    },
    addRow: function addRow(payments) {
      this.form.payments = payments;
      var acum_payment = 0;
      this.form.payments.forEach(function (item) {
        acum_payment += parseFloat(item.payment);
      }); // this.amount = acum_payment

      this.setAmount(acum_payment); // console.log(this.form.payments)
    },
    setAmount: function setAmount(amount) {
      // this.amount = parseFloat(this.amount) + parseFloat(amount)
      this.form.enter_amount = amount;
      this.amount = parseFloat(amount); //+ parseFloat(amount)
      //   this.form.enter_amount =  parseFloat(amount) //+ parseFloat(amount)

      this.inputAmount(amount);
    },
    setAmountCash: function setAmountCash(amount) {
      this.setAmount(amount);
    },
    diferen: function diferen() {
      var _this18 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee14() {
        var differen;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                differen = (parseFloat(_this18.form.enter_amount) || 0) + _this18.totalPayments() - parseFloat(_this18.form.total);

                if (differen < 0) {// this.$toast.error(
                  //     "El monto de efectivo es menor al total de venta"
                  // );
                }

              case 2:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    totalPayments: function totalPayments() {
      if (this.currentPayments.length != 0) {
        var enter_amount = 0.0;
        this.currentPayments.forEach(function (cp) {
          enter_amount += parseFloat(cp.amount);
        });
        return enter_amount;
      }

      return 0;
    },
    enterAmount: function enterAmount() {
      var _arguments3 = arguments,
          _this19 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee15() {
        var amount, enter_amount, differen;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                amount = _arguments3.length > 0 && _arguments3[0] !== undefined ? _arguments3[0] : 0;
                _this19.amount = amount;
                enter_amount = parseFloat(_this19.form.enter_amount) || 0; // +this.totalPayments();

                differen = enter_amount - parseFloat(_this19.form.total);
                _this19.form.difference = parseFloat(differen);

                if (_this19.form.difference < 0) {
                  // this.button_payment = true;
                  _this19.form.difference = differen;
                } else if (_this19.form.difference >= 0) {
                  _this19.button_payment = false;
                  parseFloat(_this19.form.enter_amount) - parseFloat(_this19.form.total);
                } else {// this.button_payment = true;
                } //this.form.difference = _.round(this.form.difference, 2);
                // this.$eventHub.$emit("eventSetFormPosLocalStorage", this.form);
                // this.setAmountCash(amount)


              case 6:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15);
      }))();
    },
    getLocalStoragePayment: function getLocalStoragePayment(key) {
      var re_default = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      var ls_obj = localStorage.getItem(key);
      ls_obj = JSON.parse(ls_obj);

      if (ls_obj) {
        return ls_obj;
      }

      return re_default;
    },
    setLocalStoragePayment: function setLocalStoragePayment(key, obj) {
      return localStorage.setItem(key, JSON.stringify(obj));
    },
    inputAmount: function inputAmount() {
      var amount = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.enterAmount(amount);
      this.form.difference = this.form.enter_amount - this.form.total;

      if (isNaN(this.form.difference)) {
        // this.button_payment = true;
        this.form.difference = "-";
      } else if (this.form.difference >= 0) {
        this.button_payment = false;
        this.form.difference = this.amount - this.form.total;
      } else {// this.button_payment = true;
      }

      this.$eventHub.$emit("eventSetFormPosLocalStorage", this.form);
    },
    lStoPayment: function lStoPayment() {
      this.setLocalStoragePayment("enter_amount", this.form.enter_amount);
      this.setLocalStoragePayment("amount", this.amount == 0 ? this.form.total : this.amount);
      this.setLocalStoragePayment("difference", this.amount == 0 ? this.form.total - this.amount : 0);
    },
    initFormPayment: function initFormPayment() {
      this.form.difference = 15; //this.form.total - this.form.enter_amount;

      this.form_payment = {
        id: null,
        date_of_payment: moment().format("YYYY-MM-DD"),
        payment_method_type_id: "01",
        reference: null,
        card_brand_id: null,
        document_id: null,
        sale_note_id: null,
        payment: this.form.total
      };
      this.form_cash_document = {
        document_id: null,
        sale_note_id: null
      };
    },
    cleanLocalStoragePayment: function cleanLocalStoragePayment() {
      this.setLocalStoragePayment("form_pos", null);
      this.setLocalStoragePayment("amount", null);
      this.setLocalStoragePayment("enter_amount", null);
      this.setLocalStoragePayment("difference", null);
    },
    sleep: function sleep(ms) {
      return new Promise(function (resolve) {
        return setTimeout(resolve, ms);
      });
    },
    passBoxes: function passBoxes(total, boxes) {
      var amounts = boxes.reduce(function (a, b) {
        return a + b.amount;
      }, 0);
      var rest = amounts - total;
      var plus = false;

      if (rest < 0) {
        plus = true;
        rest *= -1;
      }

      var newBoxes = _toConsumableArray(boxes);

      if (rest != 0) {
        for (var i = 0; i < newBoxes.length; i++) {
          var box = newBoxes[i];

          if (plus) {
            box.amount += rest;
            rest = 0;
          } else {
            if (box.amount - rest > 0) {
              box.amount -= rest;
              rest = 0;
            }
          }

          if (rest == 0) {
            break;
          }
        }
      }

      return newBoxes;
    },
    sendPayment: function sendPayment($event) {
      var _arguments4 = arguments,
          _this20 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee16() {
        var form, payIncomplete, different, newPrice, registered, payed;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee16$(_context16) {
          while (1) {
            switch (_context16.prev = _context16.next) {
              case 0:
                form = _arguments4.length > 1 && _arguments4[1] !== undefined ? _arguments4[1] : null;

                if (_this20.cash_id) {
                  _context16.next = 4;
                  break;
                }

                _this20.$toast.error("Seleccione o abra una caja.");

                return _context16.abrupt("return");

              case 4:
                payIncomplete = false;
                different = parseFloat(_this20.form.enter_amount) - parseFloat(_this20.form.total);

                if (!(different < 0)) {
                  _context16.next = 16;
                  break;
                }

                _context16.prev = 7;
                _context16.next = 10;
                return _this20.$confirm("Hay un saldo por cobrar de ".concat(different * -1), "Saldo", {
                  distinguishCancelAndClose: true,
                  confirmButtonText: "Pagar",
                  cancelButtonText: "Cambiar cantidad"
                });

              case 10:
                payIncomplete = true;
                _context16.next = 16;
                break;

              case 13:
                _context16.prev = 13;
                _context16.t0 = _context16["catch"](7);
                return _context16.abrupt("return");

              case 16:
                if (payIncomplete) {
                  _this20.incomplete = true;
                  newPrice = isNaN(parseFloat(_this20.form.enter_amount)) ? 0 : parseFloat(_this20.form.enter_amount); //45

                  _this20.changePrice(newPrice);

                  _this20.reCalculateTotal();
                }

                if (!(_this20.form.total == 0)) {
                  _context16.next = 20;
                  break;
                }

                _this20.$toast.error("Monto inválido.");

                return _context16.abrupt("return");

              case 20:
                if (_this20.form.total) _this20.form.cash_id = _this20.cash_id;

                if (!form) {
                  form = _this20.form;
                }

                form.printerOn = _this20.printerOn == 1 ? true : false;
                registered = true;

                if (!(_this20.type != "incomplete")) {
                  _context16.next = 30;
                  break;
                }

                _context16.next = 27;
                return _this20.sendRegister();

              case 27:
                registered = _context16.sent;
                _context16.next = 31;
                break;

              case 30:
                _this20.registerId = _this20.register.id;

              case 31:
                if (!registered) {
                  _context16.next = 38;
                  break;
                }

                _context16.next = 34;
                return _this20.clickPayment(form);

              case 34:
                payed = _context16.sent;

                if (!payed) {
                  _context16.next = 38;
                  break;
                }

                _context16.next = 38;
                return _this20.sendCollegePayment();

              case 38:
              case "end":
                return _context16.stop();
            }
          }
        }, _callee16, null, [[7, 13]]);
      }))();
    },
    sendCollegePayment: function sendCollegePayment() {
      var _this21 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee17() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee17$(_context17) {
          while (1) {
            switch (_context17.prev = _context17.next) {
              case 0:
                _context17.prev = 0;
                _this21.loading = true;
                _context17.next = 4;
                return _this21.$http.post("/college/payments", {
                  document_id: _this21.documentId,
                  register_id: _this21.registerId,
                  months: _this21.type == "incomplete" ? [] : _this21.formRegister.months,
                  active: 1,
                  type: _this21.incomplete ? "incomplete" : "complete",
                  details: _this21.formRegister.detail
                });

              case 4:
                response = _context17.sent;

                _this21.$emit("getRecords");

                _context17.next = 11;
                break;

              case 8:
                _context17.prev = 8;
                _context17.t0 = _context17["catch"](0);
                console.log(_context17.t0);

              case 11:
                _context17.prev = 11;
                _this21.loading = false;
                return _context17.finish(11);

              case 14:
              case "end":
                return _context17.stop();
            }
          }
        }, _callee17, null, [[0, 8, 11, 14]]);
      }))();
    },
    sendRegister: function sendRegister() {
      var _this22 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee18() {
        var response, id;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee18$(_context18) {
          while (1) {
            switch (_context18.prev = _context18.next) {
              case 0:
                if (_this22.formRegister) {
                  _context18.next = 3;
                  break;
                }

                _this22.$toast.error("Seleccione un plan/estudiante");

                return _context18.abrupt("return", false);

              case 3:
                _context18.prev = 3;
                _this22.loading = true;
                console.log(_this22.formRegister);
                _context18.next = 8;
                return _this22.$http.post("/college/registers", _this22.formRegister);

              case 8:
                response = _context18.sent;
                id = response.data.id;
                _this22.registerId = id;
                return _context18.abrupt("return", true);

              case 14:
                _context18.prev = 14;
                _context18.t0 = _context18["catch"](3);
                console.log(_context18.t0);

                _this22.$toast.error("Ocurrió un error");

                return _context18.abrupt("return", false);

              case 19:
                _context18.prev = 19;
                _this22.loading = false;
                return _context18.finish(19);

              case 22:
              case "end":
                return _context18.stop();
            }
          }
        }, _callee18, null, [[3, 14, 19, 22]]);
      }))();
    },
    formatItems: function formatItems() {
      var _this23 = this;

      this.form.items = this.form.items.map(function (i) {
        var _objectSpread2;

        i.quantity = 1;
        return _objectSpread(_objectSpread({}, i), {}, (_objectSpread2 = {
          warehouse_id: null,
          item: i,
          item_id: i.id,
          unit_value: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price / (1 + _this23.percentage_igv / 100) : i.sale_unit_price,
          quantity: i.quantity,
          aux_quantity: i.quantity,
          total_base_igv: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this23.percentage_igv / 100) : i.sale_unit_price * i.quantity,
          percentage_igv: _this23.percentage_igv,
          total_igv: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this23.percentage_igv / 100) * (_this23.percentage_igv / 100) : 0,
          total_base_isc: 0.0,
          percentage_isc: 0.0,
          total_isc: 0.0,
          total_base_other_taxes: 0.0,
          percentage_other_taxes: 0.0,
          total_other_taxes: 0.0,
          total_taxes: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this23.percentage_igv / 100) * (_this23.percentage_igv / 100) : 0,
          total_value: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this23.percentage_igv / 100) : i.quantity * i.sale_unit_price,
          total_charge: 0.0,
          total_discount: 0.0,
          total: i.sale_unit_price * i.quantity,
          price_type_id: "01",
          unit_price: i.sale_unit_price,
          unit_price_value: i.sale_unit_price,
          has_igv: i.has_igv,
          affectation_igv_type_id: i.sale_affectation_igv_type_id
        }, _defineProperty(_objectSpread2, "unit_price", i.sale_unit_price), _defineProperty(_objectSpread2, "presentation", null), _defineProperty(_objectSpread2, "charges", []), _defineProperty(_objectSpread2, "discounts", []), _defineProperty(_objectSpread2, "attributes", []), _defineProperty(_objectSpread2, "affectation_igv_type", i.sale_affectation_igv_type_id), _objectSpread2));
      }).filter(function (i) {
        return i.total > 0;
      });
    },
    clickPayment: function clickPayment(form) {
      var _this24 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee19() {
        var customer, serie, response, _response2, message;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee19$(_context19) {
          while (1) {
            switch (_context19.prev = _context19.next) {
              case 0:
                if (_this24.form.cash_id) {
                  _context19.next = 3;
                  break;
                }

                _this24.$toast.error("Seleccione o abra una caja.");

                return _context19.abrupt("return");

              case 3:
                customer = form.customer;

                if (customer.identity_document_type_id == "1" || customer.identity_document_type_id == "F") {
                  form.document_type_id = "03";
                } else {
                  form.document_type_id = "01";
                }

                serie = _this24.series.find(function (s) {
                  return s.document_type_id == form.document_type_id;
                });
                _this24.form.series_id = serie.id;

                if (!(form.customer_telephone != null && form.customer_telephone != "")) {
                  _context19.next = 13;
                  break;
                }

                console.log(form.customer_telephone);
                console.log(form.customer_telephone.length);

                if (_this24.existNumber()) {
                  _context19.next = 13;
                  break;
                }

                _this24.$toast.error("Número para envío whatsapp inválido");

                return _context19.abrupt("return");

              case 13:
                if (!(form.customer_id == null || form.customer_id == "")) {
                  _context19.next = 15;
                  break;
                }

                return _context19.abrupt("return", _this24.$toast.error("Elija un cliente"));

              case 15:
                if (!(customer.identity_document_type_id == "1" && form.document_type_id == "01")) {
                  _context19.next = 17;
                  break;
                }

                return _context19.abrupt("return", _this24.$toast.error("No puede emitir Factura con DNI"));

              case 17:
                if (form.series_id) {
                  _context19.next = 19;
                  break;
                }

                return _context19.abrupt("return", _this24.$toast.warning("El establecimiento no tiene series disponibles para el comprobante"));

              case 19:
                form.prefix = null;
                _this24.resource_documents = "documents";
                _this24.resource_payments = "document_payments";
                _this24.resource_options = _this24.resource_documents;
                form.advances = 0.0;
                form.total_advances = 0.0;
                form.total_payment = form.total;
                form.payments = [{
                  payment_method_type_id: "01",
                  date_of_payment: form.date_of_issue,
                  payment: form.total
                }];
                form.boxes = _this24.currentPayments;

                _this24.addPayment();

                _this24.form.observation = _this24.observation;
                _this24.loading_submit = true;
                _context19.prev = 31;
                form.orden_id = null;
                _context19.next = 35;
                return _this24.$http.post("/".concat(_this24.resource_documents), form);

              case 35:
                response = _context19.sent;

                if (!(response.status == 200)) {
                  _context19.next = 60;
                  break;
                }

                if (!(response.data.success == true)) {
                  _context19.next = 58;
                  break;
                }

                _this24.documentId = response.data.data.id;
                _this24.form_cash_document.document_id = response.data.data.id;
                _this24.number = response.data.data.number;
                _this24.documentNewId = response.data.data.id;

                if (!(response.data.success == true)) {
                  _context19.next = 57;
                  break;
                }

                if (!_this24.form.customer_telephone) {
                  _context19.next = 55;
                  break;
                }

                if (!_this24.personalWhatsapp) {
                  _context19.next = 49;
                  break;
                }

                _context19.next = 47;
                return _this24.getFile({
                  documentId: _this24.documentNewId,
                  documentTypeId: form.document_type_id,
                  number: _this24.form.customer_telephone,
                  message: _this24.form.message
                });

              case 47:
                _context19.next = 51;
                break;

              case 49:
                _context19.next = 51;
                return _this24.clickSendWhatsapp(form.document_type_id, _this24.documentNewId, _this24.number, form);

              case 51:
                _this24.loading_submit = false;

                _this24.back(true);

                _context19.next = 57;
                break;

              case 55:
                _this24.loading_submit = false;

                _this24.back(true);

              case 57:
                return _context19.abrupt("return", true);

              case 58:
                _context19.next = 63;
                break;

              case 60:
                _this24.loading_submit = true;

                _this24.$alert("<strong>Ocurrio un error </strong>" + response.statusCode + "<br>" + _this24.resource_documents, "HTML String", {
                  dangerouslyUseHTMLString: true
                });

                return _context19.abrupt("return", false);

              case 63:
                _context19.next = 72;
                break;

              case 65:
                _context19.prev = 65;
                _context19.t0 = _context19["catch"](31);
                console.log(_context19.t0);
                _response2 = _context19.t0.response;
                message = _response2.data.message;

                _this24.$toast.error(message || "Ocurrió un error");

                return _context19.abrupt("return", false);

              case 72:
                _context19.prev = 72;
                _this24.loading_submit = false;
                return _context19.finish(72);

              case 75:
              case "end":
                return _context19.stop();
            }
          }
        }, _callee19, null, [[31, 65, 72, 75]]);
      }))();
    },
    clickPrintPos: function clickPrintPos(printerName, formatoPdf) {
      var _arguments5 = arguments,
          _this25 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee20() {
        var userId, config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee20$(_context20) {
          while (1) {
            switch (_context20.prev = _context20.next) {
              case 0:
                userId = _arguments5.length > 2 && _arguments5[2] !== undefined ? _arguments5[2] : null;
                _context20.prev = 1;
                config = qz.configs.create(printerName, {
                  legacy: true
                }, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context20.next = 6;
                  break;
                }

                _context20.next = 6;
                return qz.websocket.connect(config);

              case 6:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: formatoPdf
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this25.$toast.error(e.message);
                });
                _context20.next = 13;
                break;

              case 10:
                _context20.prev = 10;
                _context20.t0 = _context20["catch"](1);

                _this25.$toast.error(_context20.t0.message);

              case 13:
              case "end":
                return _context20.stop();
            }
          }
        }, _callee20, null, [[1, 10]]);
      }))();
    },
    saveCashDocument: function saveCashDocument() {
      var _this26 = this;

      this.$http.post("/cash/cash_document", this.form_cash_document).then(function (response) {
        if (response.data.success) {} else {
          _this26.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        console.log(error);
      });
    },
    savePaymentMethod: function savePaymentMethod() {
      var _this27 = this;

      this.$http.post("/".concat(this.resource_payments), this.form_payment).then(function (response) {
        if (response.data.success) {// console.log(response)
        } else {
          _this27.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this27.records[index].errors = error.response.data;
        } else {
          console.log(error);
        }
      });
    },
    clickCancel: function clickCancel() {
      var _this28 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee21() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee21$(_context21) {
          while (1) {
            switch (_context21.prev = _context21.next) {
              case 0:
                _this28.loading_submit = true;
                _this28.loading_submit = false;

                _this28.cleanLocalStoragePayment();

                _this28.$eventHub.$emit("cancelSale");

              case 4:
              case "end":
                return _context21.stop();
            }
          }
        }, _callee21);
      }))();
    },
    back: function back() {
      var val = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

      if (this.type == "service") {
        this.$refs.service.initForm();
      } else if (this.type == "register") {
        this.$refs.register.initForm();
      } else if (this.type == "incomplete") {
        this.$refs.incomplete.initForm();
      } else {
        console.log("object");
      }

      this.splitPayments = []; //this.$emit("limpiarForm");

      if (!val) {
        this.$emit("openDrawer");
      }

      this.$emit("update:is_payment", false);
    },
    initLStoPayment: function initLStoPayment() {
      var _this29 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee22() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee22$(_context22) {
          while (1) {
            switch (_context22.prev = _context22.next) {
              case 0:
                _context22.next = 2;
                return _this29.getLocalStoragePayment("amount", _this29.form.total);

              case 2:
                _this29.amount = _context22.sent;
                _context22.next = 5;
                return _this29.getLocalStoragePayment("enter_amount", _this29.form.total);

              case 5:
                _this29.form.enter_amount = _context22.sent;
                _context22.next = 8;
                return _this29.getLocalStoragePayment("difference", _this29.form.total - _this29.form.enter_amount);

              case 8:
                _this29.form.difference = _context22.sent;

              case 9:
              case "end":
                return _context22.stop();
            }
          }
        }, _callee22);
      }))();
    },
    checkCustomers: function checkCustomers() {
      if (this.form.document_type_id == "01") {
        return this.customers.some(function (c) {
          return c.identity_document_type_id == "6";
        });
      } else {
        return this.customers.some(function (c) {
          return c.identity_document_type_id == "1";
        });
      }
    },
    setSeries: function setSeries() {
      var _this30 = this;

      this.form.series_id = null;
      this.series = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.filter(this.all_series, {
        document_type_id: this.form.document_type_id
      });
      this.series.forEach(function (s) {
        s.full_number = "".concat(s.number, "-").concat(_this30.last_number[s.number] || "1") || s.number;
      });
      this.form.series_id = this.series.length > 0 ? this.series[0].id : null;
    },
    filterSeries: function filterSeries() {
      var check = this.checkCustomers();

      if (!check && !this.started) {
        var dcto = "DNI";

        if (this.form.document_type_id == "01") {
          dcto = "RUC";
          this.form.document_type_id = "03";
        } else {
          this.form.document_type_id = "01";
        }

        this.$toast.warning("Digite el n\xFAmero de ".concat(dcto));
        this.setSeries();
        return;
      }

      this.started = false;

      if (this.form.document_type_id == "01") {
        this.currentDocumentsType = _toConsumableArray(this.documentsType.filter(function (f) {
          return f.description == "RUC";
        }));
        this.form.identity_document_type_id = this.currentDocumentsType[0].id;
      } else {
        this.currentDocumentsType = this.documentsType;
      }

      this.setSeries();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-89779052\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/components/payment_college.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.algunaClase .el-dialog .el-dialog__header .el-dialog__title {\r\n    font-size: 35px !important;\n}\n.el-scrollbar {\r\n    z-index: 2000 !important;\n}\n.c-width {\r\n    width: 80px !important;\r\n    padding: 0 !important;\r\n    margin-right: 0 !important;\n}\n.control-label,\r\nh4,\r\nh5,\r\nlabel {\r\n    color: #000;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/modules/College/Resources/assets/js/components/modules/College/Resources/assets/js/components/payment_college.vue"],"names":[],"mappings":";AA00BA;IACA,2BAAA;CACA;AACA;IACA,yBAAA;CACA;AACA;IACA,uBAAA;IACA,sBAAA;IACA,2BAAA;CACA;AACA;;;;IAIA,YAAA;CACA","file":"payment_college.vue","sourcesContent":["<template>\r\n    <el-dialog\r\n        :visible=\"is_payment\"\r\n        :close-on-click-modal=\"false\"\r\n        :close-on-press-escape=\"false\"\r\n        :modal-append-to-body=\"true\"\r\n        :show-close=\"false\"\r\n        :append-to-body=\"true\"\r\n        @open=\"open\"\r\n        width=\"770px\"\r\n        top=\"2vh\"\r\n        :title=\"title || 'MODULO DE CAJA'\"\r\n        class=\"algunaClase\"\r\n    >\r\n        <div v-loading=\"loading\" class=\"mb-0\">\r\n            <div class=\"pt-1\" v-loading=\"loading_submit\">\r\n                <div class=\"row\">\r\n                    <template v-if=\"type == 'incomplete'\">\r\n                        <incomplete-form\r\n                            :payable.sync=\"payable\"\r\n                            ref=\"incomplete\"\r\n                            @updateItems=\"updateItems\"\r\n                            @updateObservation=\"updateObservation\"\r\n                            @createFormRegister=\"createFormIncomplete\"\r\n                            @updateCustomer=\"updateCustomer\"\r\n                            :services=\"services\"\r\n                            :plan=\"plan\"\r\n                            :member.sync=\"member\"\r\n                            :register=\"register\"\r\n                        >\r\n                        </incomplete-form>\r\n                    </template>\r\n                    <template v-if=\"type == 'service'\">\r\n                        <service-form\r\n                            ref=\"service\"\r\n                            @updateTotal=\"updateTotal\"\r\n                            @updateItems=\"updateItems\"\r\n                            @updateObservation=\"updateObservation\"\r\n                            @updateCustomer=\"updateCustomer\"\r\n                            @createFormRegister=\"createFormService\"\r\n                            :member.sync=\"member\"\r\n                        ></service-form>\r\n                    </template>\r\n                    <template v-if=\"type == 'register'\">\r\n                        <register-form\r\n                            @updateTotal=\"updateTotal\"\r\n                            @updateItems=\"updateItems\"\r\n                            @updateObservation=\"updateObservation\"\r\n                            @updateCustomer=\"updateCustomer\"\r\n                            @createFormRegister=\"createFormRegister\"\r\n                            :record=\"record\"\r\n                            ref=\"register\"\r\n                        ></register-form>\r\n                    </template>\r\n                </div>\r\n                <div class=\"row pt-2\">\r\n                    <div class=\"col-lg-12\">\r\n                        <div class=\"mb-2\">\r\n                            <div class=\"card bg-light\">\r\n                                <div class=\"row col-lg-6 col-xl-12\">\r\n                                    <div class=\"form-group\">\r\n                                        <label class=\"control-label\"\r\n                                            >Observaciones</label\r\n                                        >\r\n                                        <el-input\r\n                                            type=\"textarea\"\r\n                                            :rows=\"2\"\r\n                                            v-model=\"observation\"\r\n                                        ></el-input>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n\r\n                    <div class=\"col-lg-12\">\r\n                        <div class=\"mb-2\">\r\n                            <div class=\"text-center text-dark card bg-light\">\r\n                                <div class=\"row\">\r\n                                    <div class=\"col-lg-12\">\r\n                                        <div class=\"align-items-start\">\r\n                                            <label class=\"control-label\"\r\n                                                >Medios de Pago</label\r\n                                            >\r\n                                            <label\r\n                                                role=\"button\"\r\n                                                class=\"text-primary control-label\"\r\n                                            ></label>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"radio-tile-group2 flex-wrap\"\r\n                                        >\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"cash\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"01\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'Efectivo'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"\r\n                            background-image: url('../../images/botonEfectivo.png');\r\n                            background-size: contain;\r\n                            background-repeat: no-repeat;\r\n                          \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon walk-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"cash\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"culqui\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"02\"\r\n                                                    @change=\"\r\n                                                        method_payment('Culqui')\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"\r\n                            background-image: url('../../images/CulquiIcon.png');\r\n                            background-size: contain;\r\n                            background-repeat: no-repeat;\r\n                          \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"05\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'TARJETA: IZYPAY'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"\r\n                            background-image: url('../../images/botonIzipay.png');\r\n                            background-size: contain;\r\n                            background-repeat: no-repeat;\r\n                          \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"06\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'TARJETA: NIUBIZ'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"\r\n                            background-image: url('../../images/botonNiubiz.png');\r\n                            background-size: contain;\r\n                            background-repeat: no-repeat;\r\n                          \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"yape\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"03\"\r\n                                                    @change=\"\r\n                                                        method_payment('Yape')\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"\r\n                            background-image: url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png');\r\n                            background-size: contain;\r\n                            background-repeat: no-repeat;\r\n                          \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"04\"\r\n                                                    @change=\"\r\n                                                        method_payment('PLIN')\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"\r\n                            background-image: url('../../images/plin-logo-0C4106153C-seeklogo.com.png');\r\n                            background-size: contain;\r\n                            background-repeat: no-repeat;\r\n                          \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"row col-md-12\">\r\n                                            <div class=\"row\">\r\n                                                <label\r\n                                                    class=\"control-label text-center\"\r\n                                                    >Emision de\r\n                                                    comprobante</label\r\n                                                >\r\n                                            </div>\r\n                                            <div class=\"row\">\r\n                                                <div\r\n                                                    class=\"col-lg-2 col-md-5 col-xl-6\"\r\n                                                >\r\n                                                    <label\r\n                                                        class=\"\r\n                              control-label\r\n                              text-left\r\n                              d-flex\r\n                              align-items-start\r\n                              justify-content-start\r\n                            \"\r\n                                                    >\r\n                                                        Ingrese Nro Celular\r\n                                                    </label>\r\n                                                    <el-input\r\n                                                        v-model=\"\r\n                                                            form.customer_telephone\r\n                                                        \"\r\n                                                    >\r\n                                                        <template slot=\"prepend\"\r\n                                                            ><i\r\n                                                                class=\"fab fa-whatsapp fa-2x\"\r\n                                                            ></i>\r\n                                                        </template>\r\n                                                    </el-input>\r\n                                                </div>\r\n                                                <div\r\n                                                    class=\"radio-tile-group2 col-lg-6 col-xl-6 d\"\r\n                                                    style=\"padding-top: 12px\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"input-container2 border rounded-sm col-lg-3\"\r\n                                                    >\r\n                                                        <input\r\n                                                            id=\"imprimir\"\r\n                                                            v-model=\"printerOn\"\r\n                                                            class=\"radio-button2\"\r\n                                                            type=\"radio\"\r\n                                                            name=\"imprimir\"\r\n                                                            value=\"1\"\r\n                                                        />\r\n                                                        <div\r\n                                                            class=\"radio-tile2\"\r\n                                                        >\r\n                                                            <div\r\n                                                                class=\"icon walk-icon\"\r\n                                                            >\r\n                                                                <i\r\n                                                                    class=\"fa fa-print\"\r\n                                                                ></i>\r\n                                                            </div>\r\n                                                            <label\r\n                                                                for=\"cash\"\r\n                                                                class=\"radio-tile-label2\"\r\n                                                                >Imprimir</label\r\n                                                            >\r\n                                                        </div>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"input-container2 border rounded-sm col-lg-3\"\r\n                                                    >\r\n                                                        <input\r\n                                                            id=\"noimprimir\"\r\n                                                            v-model=\"printerOn\"\r\n                                                            class=\"radio-button2\"\r\n                                                            type=\"radio\"\r\n                                                            name=\"noimprimir\"\r\n                                                            value=\"0\"\r\n                                                        />\r\n                                                        <div\r\n                                                            class=\"radio-tile2\"\r\n                                                        >\r\n                                                            <div\r\n                                                                class=\"icon bike-icon\"\r\n                                                            >\r\n                                                                <i\r\n                                                                    class=\"fa fa-print\"\r\n                                                                ></i>\r\n                                                            </div>\r\n                                                            <label\r\n                                                                for=\"Tarjeta\"\r\n                                                                class=\"radio-tile-label2\"\r\n                                                                >No\r\n                                                                Imprimir</label\r\n                                                            >\r\n                                                        </div>\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n\r\n                                        <div class=\"row\">\r\n                                            <div\r\n                                                class=\"col-lg-8 d-flex flex-row align-items-end\"\r\n                                            ></div>\r\n                                            <div\r\n                                                class=\"d-flex flex-column\"\r\n                                            ></div>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"row d-flex justify-content-start\"\r\n                                        >\r\n                                            <table\r\n                                                class=\"table\"\r\n                                                v-if=\"\r\n                                                    currentPayments.length != 0\r\n                                                \"\r\n                                            >\r\n                                                <thead>\r\n                                                    <tr>\r\n                                                        <th\r\n                                                            colspan=\"4\"\r\n                                                            class=\"text-left\"\r\n                                                        >\r\n                                                            Pagos\r\n                                                        </th>\r\n                                                    </tr>\r\n                                                </thead>\r\n                                                <tbody>\r\n                                                    <tr\r\n                                                        v-for=\"(paymnt,\r\n                                                        idx) in currentPayments\"\r\n                                                        :key=\"idx\"\r\n                                                    >\r\n                                                        <td>{{ idx + 1 }}</td>\r\n                                                        <td>\r\n                                                            {{ paymnt.method }}\r\n                                                        </td>\r\n                                                        <td>\r\n                                                            <strong>{{\r\n                                                                paymnt.amount\r\n                                                            }}</strong>\r\n                                                        </td>\r\n                                                        <td>\r\n                                                            <label\r\n                                                                for=\"\"\r\n                                                                role=\"button\"\r\n                                                                @click=\"\r\n                                                                    removePayment(\r\n                                                                        paymnt.id\r\n                                                                    )\r\n                                                                \"\r\n                                                                class=\"text-danger\"\r\n                                                            >\r\n                                                                <i\r\n                                                                    class=\"fa fa-trash\"\r\n                                                                ></i\r\n                                                            ></label>\r\n                                                        </td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                        </div>\r\n                                    </div>\r\n\r\n                                    <div class=\"card bg-light col-lg-12\"></div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-lg-12\">\r\n                            <div class=\"mb-2\">\r\n                                <div class=\"card bg-light\">\r\n                                    <div class=\"row\">\r\n                                        <div\r\n                                            class=\"col-xl-4\"\r\n                                            style=\"margin-top: 10px; padding-top: 5px\"\r\n                                            :class=\"{\r\n                                                'has-danger':\r\n                                                    form.difference < 0\r\n                                            }\"\r\n                                        >\r\n                                            <label class=\"control-label h1\"\r\n                                                >Total a cobrar: </label\r\n                                            ><br />\r\n                                            <span\r\n                                                class=\"\r\n                          control-label\r\n                          font-weight-semibold\r\n                          text-center\r\n                          h3\r\n                        \"\r\n                                            >\r\n                                                S/ {{ \" \" + form.total }}\r\n                                            </span>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"col-xl-8\"\r\n                                            v-if=\"\r\n                                                form_payment.payment_method_type_id ==\r\n                                                    '01'\r\n                                            \"\r\n                                        >\r\n                                            <div\r\n                                                class=\"\r\n                          btn-group btn-group-square\r\n                          m-0\r\n                          flex-wrap\r\n                          justify-content-around\r\n                        \"\r\n                                                role=\"group\"\r\n                                                style=\"padding-top: 12px\"\r\n                                            >\r\n                                                <label class=\"control-label\"\r\n                                                    >Ingrese monto</label\r\n                                                >\r\n                                                <div class=\"row col-12\">\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2 col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    10\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}10\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2 col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    20\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}20\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2 col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    50\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}50\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2 col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    100\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}100\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2 col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    200\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}200\r\n                                                        </button>\r\n                                                    </div>\r\n                                                </div>\r\n                                                <div\r\n                                                    class=\"row col-xl-12 col-12\"\r\n                                                >\r\n                                                    <div class=\"col-xl-6 col-3\">\r\n                                                        <el-input\r\n                                                            id=\"inputTotal\"\r\n                                                            ref=\"enter_amount\"\r\n                                                            :disabled=\"\r\n                                                                form.total == 0\r\n                                                            \"\r\n                                                            v-model=\"\r\n                                                                form.enter_amount\r\n                                                            \"\r\n                                                            @blur=\"diferen()\"\r\n                                                            @input=\"\r\n                                                                enterAmount()\r\n                                                            \"\r\n                                                            @keyup.enter.native=\"\r\n                                                                sendPayment();\r\n                                                                inputAmount(\r\n                                                                    form.enter_amount\r\n                                                                );\r\n                                                            \"\r\n                                                        >\r\n                                                            <template\r\n                                                                slot=\"prepend\"\r\n                                                                >{{\r\n                                                                    currencyTypeActive.symbol\r\n                                                                }}\r\n                                                            </template>\r\n                                                        </el-input>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"m-2 col-xl-2 col-2\"\r\n                                                    >\r\n                                                        <el-button\r\n                                                            type=\"primary\"\r\n                                                            @click=\"addPayment\"\r\n                                                            >Agregar</el-button\r\n                                                        >\r\n                                                    </div>\r\n                                                    <!-- <div\r\n                                                        class=\"m-2 col-xl-3 col-3 \"\r\n                                                    >\r\n                                                        <el-button\r\n                                                            type=\"success\"\r\n                                                            @click=\"\r\n                                                                showSplitPayment = true\r\n                                                            \"\r\n                                                            >Dividir\r\n                                                            pago</el-button\r\n                                                        >\r\n                                                    </div> -->\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"row col-xl-4\">\r\n                                            <div\r\n                                                class=\"col-xl-5\"\r\n                                                style=\"margin-bottom: 10px\"\r\n                                            ></div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-md-6 col-12\"></div>\r\n                                        <div\r\n                                            class=\"col-md-6 col-12 d-flex justify-content-end\"\r\n                                        >\r\n                                            <div\r\n                                                class=\"form-group d-flex flex-row align-items-end\"\r\n                                                :class=\"{\r\n                                                    'has-danger':\r\n                                                        form.difference < 0\r\n                                                }\"\r\n                                            >\r\n                                                <label\r\n                                                    class=\"control-label display-4\"\r\n                                                    v-text=\"\r\n                                                        form.difference < 0\r\n                                                            ? 'A cuenta: '\r\n                                                            : 'Vuelto: '\r\n                                                    \"\r\n                                                ></label>\r\n                                                <span\r\n                                                    class=\"\r\n                            control-label\r\n                            font-weight-semibold\r\n                            text-center\r\n                            display-3\r\n                          \"\r\n                                                >\r\n                                                    {{\r\n                                                        currencyTypeActive.symbol\r\n                                                    }}\r\n                                                    {{\r\n                                                        form.difference.toFixed(\r\n                                                            2\r\n                                                        )\r\n                                                    }}\r\n                                                </span>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div\r\n                    v-if=\"splitPayments.length != 0\"\r\n                    class=\"row m-1 p-2 bg-light rounded\"\r\n                >\r\n                    <span style=\"margin-bottom: 5px\">Pagos divididos</span>\r\n                    <div class=\"d-flex flex-wrap\">\r\n                        <div\r\n                            v-for=\"(payment, idx) in splitPayments\"\r\n                            :key=\"idx\"\r\n                            class=\"col-2\"\r\n                        >\r\n                            Pago {{ idx + 1 }}:\r\n                            <strong>S/. {{ payment.amount }}</strong>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div\r\n                    v-if=\"splitProducts.length != 0\"\r\n                    class=\"row m-1 p-2 bg-light rounded\"\r\n                >\r\n                    <span style=\"margin-bottom: 5px\"\r\n                        >Pagos divididos por producto</span\r\n                    >\r\n                    <div class=\"d-flex flex-wrap\">\r\n                        <div\r\n                            v-for=\"(payment, idx) in splitProducts\"\r\n                            :key=\"idx\"\r\n                            class=\"col-3 m-1\"\r\n                        >\r\n                            <table\r\n                                v-if=\"\r\n                                    payment.products &&\r\n                                        payment.products.length > 0\r\n                                \"\r\n                                class=\"col-12\"\r\n                            >\r\n                                <thead>\r\n                                    <tr\r\n                                        role=\"button\"\r\n                                        @click=\"selectAccount(idx)\"\r\n                                        :class=\"\r\n                                            'bg-primary text-white border rounded-top'\r\n                                        \"\r\n                                    >\r\n                                        <th class=\"text-center\" colspan=\"3\">\r\n                                            <b> CUENTA {{ idx + 1 }} </b>\r\n                                        </th>\r\n                                    </tr>\r\n                                </thead>\r\n                                <tbody\r\n                                    class=\"border rounded-top\"\r\n                                    v-if=\"\r\n                                        payment.products &&\r\n                                            payment.products.length > 0\r\n                                    \"\r\n                                >\r\n                                    <tr\r\n                                        v-for=\"(product,\r\n                                        idx) in payment.products\"\r\n                                        :key=\"idx\"\r\n                                    >\r\n                                        <td>\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                {{ product.quantity }}\r\n                                            </h3>\r\n                                        </td>\r\n                                        <td>\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                {{ product.description }}\r\n                                            </h3>\r\n                                        </td>\r\n                                        <td style=\"text-align: right\">\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                {{\r\n                                                    product.price *\r\n                                                        product.quantity\r\n                                                }}\r\n                                            </h3>\r\n                                        </td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td\r\n                                            colspan=\"2\"\r\n                                            class=\"text-muted text-small\"\r\n                                            style=\"text-align: right\"\r\n                                        >\r\n                                            <b> Total</b>\r\n                                        </td>\r\n                                        <td class=\"text-muted text-small\">\r\n                                            S/.\r\n                                            {{\r\n                                                totalItemSelected(\r\n                                                    payment.products\r\n                                                )\r\n                                            }}\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                                <tbody v-else class=\"border\">\r\n                                    <tr>\r\n                                        <td colspan=\"3\" class=\"text-center\">\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                Sin productos seleccionados\r\n                                            </h3>\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"p-3\">\r\n                    <div class=\"row\">\r\n                        <!-- <div class=\"col-md-4 col-12\">\r\n                            <label class=\"label-control\"> Elija Caja </label>\r\n                            <el-select v-model=\"cash_id\">\r\n                                <el-option\r\n                                    v-for=\"(cash, idx) in cashes\"\r\n                                    :key=\"idx\"\r\n                                    :value=\"cash.id\"\r\n                                    :label=\"cash.reference_number\"\r\n                                ></el-option>\r\n                            </el-select>\r\n                        </div> -->\r\n                        <div class=\"col-md-6 col-12 d-flex align-items-end\">\r\n                            <div\r\n                                class=\"btn-group btn-group-square\"\r\n                                role=\"group\"\r\n                            >\r\n                                <button\r\n                                    class=\"btn btn-block btn-primary mr-3\"\r\n                                    @click=\"sendPayment\"\r\n                                    :disabled=\"button_payment\"\r\n                                >\r\n                                    <i class=\"fas fa-money-bill-alt\"></i>\r\n                                    PAGAR\r\n                                </button>\r\n                                <button\r\n                                    class=\"btn btn-block btn-dark\"\r\n                                    @click=\"back(false)\"\r\n                                >\r\n                                    <i class=\"fa fa-reply\"></i> Cerrar\r\n                                </button>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </el-dialog>\r\n</template>\r\n\r\n<style>\r\n.algunaClase .el-dialog .el-dialog__header .el-dialog__title {\r\n    font-size: 35px !important;\r\n}\r\n.el-scrollbar {\r\n    z-index: 2000 !important;\r\n}\r\n.c-width {\r\n    width: 80px !important;\r\n    padding: 0 !important;\r\n    margin-right: 0 !important;\r\n}\r\n.control-label,\r\nh4,\r\nh5,\r\nlabel {\r\n    color: #000;\r\n}\r\n</style>\r\n\r\n<script>\r\n// import * as shajs from 'sha.js';\r\nimport _ from \"lodash\";\r\nconst RegisterForm = () => import(\"../views/classrooms/register_form.vue\");\r\nconst ServiceForm = () => import(\"../../js/components/service_form.vue\");\r\nconst IncompleteForm = () =>\r\n    import(\"../../js/components/payment_incomplete.vue\");\r\n\r\nexport default {\r\n    components: { RegisterForm, ServiceForm, IncompleteForm },\r\n\r\n    props: [\r\n        \"record\",\r\n        \"title\",\r\n        \"customer_default\",\r\n        \"is_payment\",\r\n        \"member\",\r\n        \"configuration\",\r\n        \"desarrollador\",\r\n        \"personalWhatsapp\",\r\n        \"type\",\r\n        \"student\",\r\n        \"classroomId\",\r\n        \"plan\",\r\n        \"register\",\r\n        \"services\",\r\n        \"payable\"\r\n    ],\r\n    watch: {\r\n        all_customers(newCustomer, _) {\r\n            this.customers = newCustomer.filter(n => n.number != \"88888888\");\r\n        }\r\n    },\r\n    data() {\r\n        return {\r\n            incomplete: false,\r\n            cash_id: null,\r\n            documentId: null,\r\n            registerId: null,\r\n            showDialog: false,\r\n            series: [],\r\n            affectationIgvTypes: [],\r\n            establishments: null,\r\n            methodPayment: [],\r\n            currencyTypes: [],\r\n            documentsType: [],\r\n            variation: null,\r\n            form: {\r\n                college: true,\r\n                afectar_caja: true,\r\n                orden_id: null,\r\n                customer_telephone: null,\r\n                restaurant: true,\r\n                total_rounded: 0.0,\r\n                total_payment: 0.0,\r\n                establishment_id: null,\r\n                series_id: null,\r\n                prefix: null,\r\n                number: \"#\",\r\n                date_of_issue: moment().format(\"YYYY-MM-DD\"),\r\n                time_of_issue: moment().format(\"HH:mm:ss\"),\r\n                currency_type_id: \"PEN\",\r\n                purchase_order: null,\r\n                exchange_rate_sale: 1,\r\n                total_prepayment: 0,\r\n                total_charge: 0,\r\n                total_discount: 0,\r\n                total_exportation: 0,\r\n                total_free: 0,\r\n                total_taxed: 0,\r\n                total_unaffected: 0,\r\n                total_exonerated: 0,\r\n                total_igv: 0,\r\n                total_base_isc: 0,\r\n                total_isc: 0,\r\n                total_base_other_taxes: 0,\r\n                total_other_taxes: 0,\r\n                total_taxes: 0,\r\n                total_value: 0,\r\n                total: 0,\r\n                operation_type_id: \"0101\",\r\n                date_of_due: moment().format(\"YYYY-MM-DD\"),\r\n                items: [],\r\n                charges: [],\r\n                discounts: [],\r\n                attributes: [],\r\n                guides: [],\r\n                payments: [],\r\n                hotel: {},\r\n                additional_information: null,\r\n                payment_condition_id: \"01\",\r\n                printerOn: false,\r\n                actions: {\r\n                    format_pdf: \"a4\"\r\n                },\r\n                difference: 0.0,\r\n                enter_amount: 0.0,\r\n                method_pay: \"Efectivo\",\r\n                commands_fisico: null,\r\n                to_carry: false,\r\n                document_type_id: \"01\"\r\n                //  customer_id: 1\r\n            },\r\n            user: null,\r\n            company: null,\r\n            categories: [],\r\n            observation: null,\r\n            percentage_igv: 18,\r\n            started: true,\r\n            refCustomer: null,\r\n            currentDocumentsType: [],\r\n            time: null,\r\n            splitPayments: [],\r\n            splitProducts: [],\r\n            isInterno: false,\r\n            showSplitPayment: false,\r\n            currencyTypeActive: {\r\n                symbol: \"S/ \"\r\n            },\r\n            currentPayments: [],\r\n            input_person: {},\r\n            customer: null,\r\n            value: null,\r\n            paymentsValue: {\r\n                \"01\": \"Efectivo\",\r\n                \"02\": \"Culqui\",\r\n                \"03\": \"Yape\",\r\n                \"04\": \"PLIN\",\r\n                \"05\": \"TARJETA: IZYPAY\",\r\n                \"06\": \"TARJETA: NIUBIZ\"\r\n            },\r\n            last_number: {},\r\n            showDialogNewPerson: false,\r\n            loading: false,\r\n            enabled_discount: false,\r\n            discount_amount: 0,\r\n            loading_submit: false,\r\n            showDialogOptions: false,\r\n            showDialogMultiplePayment: false,\r\n            showDialogSaleNote: false,\r\n            showDialogNewCardBrand: false,\r\n            documentNewId: null,\r\n            saleNotesNewId: null,\r\n            resource_options: null,\r\n            has_card: false,\r\n            method_payments: \"01\",\r\n            number: null,\r\n            resource: \"pos\",\r\n            resource_documents: \"documents\",\r\n            resource_payments: \"document_payments\",\r\n            amount: 0,\r\n            printerOn: 0,\r\n            button_payment: false,\r\n            input_item: \"\",\r\n            form_payment: {},\r\n            series: [],\r\n            cards_brand: [],\r\n            cancel: false,\r\n            form_cash_document: {},\r\n            formRegister: null,\r\n            statusDocument: {},\r\n            cashes: [],\r\n            payment_method_types: [],\r\n            last_date: null,\r\n            customers: [],\r\n            datEmision: {\r\n                disabledDate(time) {\r\n                    return time.getTime() > moment();\r\n                }\r\n            },\r\n            activeColo: \"black\",\r\n            socket: null\r\n        };\r\n    },\r\n\r\n    async created() {\r\n        await this.getTables();\r\n        this.loading = true;\r\n        this.currentDocumentsType = this.documentsType;\r\n        this.form.identity_document_type_id = this.currentDocumentsType[0].id;\r\n        // this.form.customer_id = this.establishments.customer_id;\r\n        // this.value = this.establishments.customer_id;\r\n        this.isInterno = this.company.soap_type_id == \"03\";\r\n\r\n        // await this.date_of_issue();\r\n        // await this.getLastNumbersDocument();\r\n        await this.initFormPayment();\r\n        //    await this.setInitialAmount();\r\n\r\n        await this.getFormPosLocalStorage();\r\n\r\n        qz.security.setCertificatePromise((resolve, reject) => {\r\n            this.$http\r\n                .get(\"/api/qz/crt/override\", {\r\n                    responseType: \"text\"\r\n                })\r\n                .then(response => {\r\n                    resolve(response.data);\r\n                })\r\n                .catch(error => {\r\n                    reject(error.data);\r\n                });\r\n        });\r\n\r\n        qz.security.setSignaturePromise(toSign => {\r\n            return (resolve, reject) => {\r\n                this.$http\r\n                    .post(\"/api/qz/signing\", { request: toSign })\r\n                    .then(response => {\r\n                        resolve(response.data);\r\n                    })\r\n                    .catch(error => {\r\n                        reject(error.data);\r\n                    });\r\n            };\r\n        });\r\n\r\n        this.setAmountCash(this.form.total);\r\n\r\n        // this.filterSeries();\r\n        this.loading = false;\r\n        this.socketWhatsappConfig();\r\n    },\r\n\r\n    methods: {\r\n        changePrice(price) {\r\n            //45\r\n            //\r\n            let countItems = this.form.items.length;\r\n            let div = Math.floor(price / countItems);\r\n            this.form.items = this.form.items.map(i => ({\r\n                ...i,\r\n                sale_unit_price: div,\r\n                total: div,\r\n                total_base_igv: div,\r\n                total_value: div,\r\n                unit_price: div,\r\n                unit_price_value: div,\r\n                unit_value: div\r\n            }));\r\n\r\n            let newTotalItems = div * countItems;\r\n            let diff = price - newTotalItems;\r\n            if (diff != 0) {\r\n                let price = this.form.items[0].total + diff;\r\n                this.form.items[0] = {\r\n                    ...this.form.items[0],\r\n                    sale_unit_price: price,\r\n                    total: price,\r\n                    total_base_igv: price,\r\n                    total_value: price,\r\n                    unit_price: price,\r\n                    unit_price_value: price,\r\n                    unit_value: price\r\n                };\r\n            }\r\n        },\r\n        async getFile({ documentId, documentTypeId, number, message }) {\r\n            try {\r\n                const response = await this.$http.post(\r\n                    \"/whatsapp/get-file\",\r\n\r\n                    {\r\n                        document_id: documentId,\r\n                        document_type_id: documentTypeId\r\n                    }\r\n                );\r\n                const { pdf, xml, name } = response.data;\r\n                let basicMessage =\r\n                    \"Su comprobante de pago electrónico \" +\r\n                    name +\r\n                    \" de *\" +\r\n                    this.company.name +\r\n                    \"*, ha sido generado correctamente a través del facturador electrónico de\"+\"*\"+this.$desarrollador+\"*\";\r\n                if (message) {\r\n                    basicMessage += \"\\n\" + message;\r\n                }\r\n                this.socket.emit(\"basicMessage\", {\r\n                    message: basicMessage,\r\n                    sender: this.sender,\r\n                    number: `51${number}`\r\n                });\r\n\r\n                // file, name, number, sender }\r\n                this.socket.emit(\"sendFile\", {\r\n                    file: pdf,\r\n                    name: `${name}.pdf`,\r\n                    number: `51${number}`,\r\n                    sender: this.sender\r\n                });\r\n\r\n                if (xml) {\r\n                    this.socket.emit(\"sendFile\", {\r\n                        file: xml,\r\n                        name: `${name}.xml`,\r\n                        number: `51${number}`,\r\n                        sender: this.sender\r\n                    });\r\n                }\r\n            } catch (e) {\r\n                let msg = \"Ocurrió un error\";\r\n                if (e.response) {\r\n                    const { response } = e;\r\n                    if (response.status == 404) {\r\n                        msg = \"No se encontró la ruta\";\r\n                    } else {\r\n                        msg = response.data.message;\r\n                    }\r\n                }\r\n                this.$toast.error(msg);\r\n                console.log(e);\r\n            } finally {\r\n            }\r\n        },\r\n        socketWhatsappConfig() {\r\n            let hostName = window.location.hostname;\r\n            let url = `https://${hostName}`;\r\n            this.sender = hostName\r\n                .replace(/https?\\:\\/\\//, \"\")\r\n                .replace(\"/\", \"\")\r\n                .split(\".\")\r\n                .join(\"\");\r\n            try {\r\n                this.socket = io.connect(this.$socketUrl);\r\n            } catch (e) {\r\n                console.log(e);\r\n            }\r\n\r\n            this.socket.on(\"connected\", ({ message }) => {\r\n                this.$toast.success(message);\r\n\r\n                this.socket.emit(\"getStatus\", url);\r\n            });\r\n            this.socket.on(\"setStatus\", ({ status, sender }) => {\r\n                if (!status) {\r\n                    this.sender = \"sdrimsac\";\r\n                    this.$toast.warning(\"Sesión iniciada con SDRIMSAC\");\r\n                } else {\r\n                    this.sender = sender;\r\n                    this.$toast.success(\"Whatsapp Listo!\");\r\n                }\r\n            });\r\n            //MessageResponse\r\n            this.socket.on(\"MessageResponse\", ({ success, message }) => {\r\n                if (success) {\r\n                    this.$toast.success(message);\r\n                } else {\r\n                    this.$toast.error(message);\r\n                }\r\n            });\r\n        },\r\n        updateCustomer(person) {\r\n            console.log(person);\r\n            this.form.customer = person;\r\n            this.form.customer_id = person.id;\r\n            this.form.customer_telephone = person.telephone;\r\n        },\r\n        updateObservation(obs) {\r\n            this.observation = obs;\r\n            this.$forceUpdate();\r\n        },\r\n        open() {\r\n            this.incomplete = false;\r\n            this.currentPayments = [];\r\n            this.form.total = 0;\r\n            this.form.customer_telephone = null;\r\n            this.form.enter_amount = undefined;\r\n            this.form.difference = 0;\r\n            this.observation = null;\r\n            this.documentId = null;\r\n            this.registerId = null;\r\n            setTimeout(() => {\r\n                if (this.type == \"service\") {\r\n                    this.$refs.service?.getTables();\r\n                } else if (this.type == \"register\") {\r\n                    this.$refs.register?.getTables();\r\n                } else {\r\n                    this.$refs.incomplete?.getTables();\r\n                }\r\n            }, 250);\r\n\r\n            if (this.type == \"incomplete\") {\r\n                this.form.items = this.services.map(s => {\r\n                    s.item.sale_unit_price = s.price;\r\n                    s.item.percentage_igv = 18;\r\n\r\n                    return s.item;\r\n                });\r\n            }\r\n            // this.form = { ...this.paymentForm };\r\n        },\r\n        createFormIncomplete(register) {\r\n            this.formRegister = register;\r\n        },\r\n        createFormRegister(register) {\r\n            register.classroom_id = this.record.id;\r\n            this.formRegister = register;\r\n        },\r\n        createFormService(register) {\r\n            register.classroom_id = this.classroomId;\r\n            this.formRegister = register;\r\n        },\r\n        updateTotal(total) {\r\n            this.form.total = total;\r\n        },\r\n\r\n        async updateItems(items) {\r\n            this.form.items = items;\r\n            this.formatItems();\r\n            this.reCalculateTotal();\r\n            this.form.enter_amount = this.form.total;\r\n            await this.$refs.enter_amount.$el.getElementsByTa;\r\n            await this.$refs.enter_amount.$el\r\n                .getElementsByTagName(\"input\")[0]\r\n                .select();\r\n        },\r\n        async getTables() {\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.get(\r\n                    `/college/registers/payment_tables`\r\n                );\r\n                const {\r\n                    affectation_igv_types,\r\n                    establishment,\r\n                    method_payment,\r\n                    currency_types,\r\n                    documents_type,\r\n                    series,\r\n                    user,\r\n                    company,\r\n                    categories,\r\n                    cash_id\r\n                } = response.data;\r\n                this.cash_id = cash_id;\r\n                this.affectationIgvTypes = affectation_igv_types;\r\n                this.establishments = establishment;\r\n                this.methodPayment = method_payment;\r\n                this.currencyTypes = currency_types;\r\n                this.series = series;\r\n                this.documentsType = documents_type;\r\n                this.user = user;\r\n                this.company = company;\r\n                this.categories = categories;\r\n                this.form.user_id = this.user.id;\r\n                this.form.establishment_id = this.establishments.id;\r\n            } catch (e) {\r\n                console.log(e);\r\n                this.$toast.error(\"Ocurrió un problema\");\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        existNumber() {\r\n            let number = this.form.customer_telephone;\r\n            if (!number.startsWith(\"9\")) {\r\n                return false;\r\n            }\r\n            if (number.length != 9) {\r\n                return false;\r\n            }\r\n            if (isNaN(Number(number))) {\r\n                return false;\r\n            }\r\n            return true;\r\n        },\r\n        createClient() {\r\n            this.value = null;\r\n            this.form.document_type_id;\r\n            this.form.customer_id = null;\r\n            this.showDialogNewPerson = true;\r\n        },\r\n        async reloadDataCustomers(customer_id) {\r\n            this.$http.get(`/pos/table/customers`).then(async response => {\r\n                await this.$emit(\"update:all_customers\", response.data);\r\n                this.value = customer_id;\r\n                this.form.customer_id = customer_id;\r\n                this.changeCustomer();\r\n            });\r\n        },\r\n        totalItemSelected(products) {\r\n            let total = 0;\r\n            products.forEach(p => {\r\n                total += p.quantity * p.price;\r\n            });\r\n\r\n            return _.round(total, 2);\r\n        },\r\n        receivePayments(payments) {\r\n            this.splitPayments = payments;\r\n        },\r\n        receiveProducts(payments) {\r\n            this.splitProducts = payments;\r\n        },\r\n        removePayment(id) {\r\n            this.currentPayments = this.currentPayments.filter(c => c.id != id);\r\n            this.enterAmount();\r\n        },\r\n        addPayment() {\r\n            let id = this.currentPayments.length + 1;\r\n\r\n            let method = this.paymentsValue[this.method_payments];\r\n\r\n            if (\r\n                this.form.enter_amount != \"\" &&\r\n                !isNaN(this.form.enter_amount) &&\r\n                this.form.enter_amount != undefined\r\n            ) {\r\n                this.currentPayments.push({\r\n                    id,\r\n                    method_payment_id: this.method_payments,\r\n                    method,\r\n                    amount: this.form.enter_amount\r\n                });\r\n            }\r\n        },\r\n        customerForm(isNew) {\r\n            if (isNew) {\r\n                this.form.customer_id = undefined;\r\n            } else {\r\n                this.form.customer_id = this.value;\r\n            }\r\n            this.showDialogNewPerson = true;\r\n        },\r\n        add_customer(value) {},\r\n        reloadDataPersons() {},\r\n        keyupCustomer(e) {\r\n            //buscar\r\n            if (this.time) {\r\n                clearTimeout(this.time);\r\n            }\r\n            this.time = setTimeout(async () => {\r\n                this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(\r\n                    \"input\"\r\n                )[0].value;\r\n                const response = await this.$http(\r\n                    `/caja/search_customers?value=${this.input_person.number}`\r\n                );\r\n                const { persons } = response.data;\r\n\r\n                this.customers = persons.filter(n => n.number != \"88888888\");\r\n                this.updateAllCustomers(this.customers);\r\n            }, 500);\r\n        },\r\n        async updateAllCustomers(personsFromServer) {\r\n            let ids = this.all_customers.map(c => c.id);\r\n            let persons = [];\r\n\r\n            for (let person of personsFromServer) {\r\n                let existInList = ids.find(p => p == person.id);\r\n                if (existInList == undefined) {\r\n                    persons.push(person);\r\n                }\r\n            }\r\n            let newData = [...this.all_customers, ...persons];\r\n\r\n            if (persons.length != 0) {\r\n                await this.$emit(\"update:all_customers\", newData);\r\n            }\r\n        },\r\n        changeCustomer() {\r\n            this.form.customer_id = this.value;\r\n            let customer = _.find(this.customers, {\r\n                id: this.form.customer_id\r\n            });\r\n\r\n            if (customer != null) {\r\n                this.customer = customer;\r\n                if (this.form.document_type_id != \"80\") {\r\n                    if (\r\n                        customer.identity_document_type_id == \"1\" ||\r\n                        customer.identity_document_type_id == \"4\"\r\n                    ) {\r\n                        this.form.document_type_id = \"03\";\r\n                    } else {\r\n                        this.form.document_type_id = \"01\";\r\n                    }\r\n                }\r\n\r\n                this.form.customer_telephone = customer.phone;\r\n                this.setLocalStorageIndex(\"customer\", this.customer);\r\n            }\r\n            this.setSeries();\r\n        },\r\n        setLocalStorageIndex(key, obj) {\r\n            localStorage.setItem(key, JSON.stringify(obj));\r\n        },\r\n        async getLastNumbersDocument() {\r\n            const response = await this.$http.post(\r\n                `${this.resource}/last_number_documents`,\r\n                { series: this.all_series, ordenId: this.idOrden }\r\n            );\r\n            if (response.status == 200) {\r\n                this.last_number = response.data.result;\r\n                this.refCustomer = response.data.customer;\r\n                if (this.refCustomer != null) {\r\n                    this.refCustomer.description = `${this.refCustomer.number} - ${this.refCustomer.name}`;\r\n                    this.customers = [\r\n                        this.refCustomer,\r\n                        ...this.customers.filter(\r\n                            f =>\r\n                                f.id != this.refCustomer.id &&\r\n                                f.number != \"88888888\"\r\n                        )\r\n                    ];\r\n\r\n                    this.value = this.refCustomer.id;\r\n                }\r\n            }\r\n        },\r\n        changeEnabledDiscount() {\r\n            if (!this.enabled_discount) {\r\n                this.discount_amount = 0;\r\n                this.deleteDiscountGlobal();\r\n                this.reCalculateTotal();\r\n            }\r\n        },\r\n        teclasInit() {\r\n            document.onkeydown = e => {\r\n                const key = e.key;\r\n\r\n                if (key == \"F4\") {\r\n                    //Agregar cliente\r\n                    // this.clickPayment();\r\n                }\r\n                if (key == \"F6\") {\r\n                    //Agregar Producto\r\n                    //this.clickAddItemInvoice()\r\n                    //return false;\r\n                }\r\n                if (key == \"F7\" && this.form.items.length > 0) {\r\n                    //Guardar\r\n                    // this.submit()\r\n                }\r\n                if (key == \"F8\") {\r\n                    //Cancelar\r\n                    // this.close()\r\n                }\r\n            };\r\n        },\r\n        async date_of_issue() {\r\n            // this.form.customer_id\r\n\r\n            this.customers = this.all_customers.filter(\r\n                n => n.number != \"88888888\"\r\n            );\r\n            this.customers = [\r\n                ...this.customers.filter(c => c.id != this.customer_default.id),\r\n                this.customer_default\r\n            ];\r\n\r\n            if (this.establishments.customer_id) {\r\n                this.value = this.establishments.customer_id;\r\n                this.form.customer_id = this.establishments.customer_id;\r\n            }\r\n\r\n            let form_efectivo = {\r\n                enter_amount: 0,\r\n                difference: 0\r\n            };\r\n            const response_efectivo = await this.$http.post(\r\n                `/efectivo`,\r\n                form_efectivo\r\n            );\r\n        },\r\n        async Printer(\r\n            Printer,\r\n            linkpdf,\r\n            copies,\r\n            auth = null,\r\n            multiple_boxes = false\r\n        ) {\r\n            qz.security.setCertificatePromise((resolve, reject) => {\r\n                this.$http\r\n                    .get(\"/api/qz/crt/override\", {\r\n                        responseType: \"text\"\r\n                    })\r\n                    .then(response => {\r\n                        resolve(response.data);\r\n                    })\r\n                    .catch(error => {\r\n                        reject(error.data);\r\n                    });\r\n            });\r\n            qz.security.setSignaturePromise(toSign => {\r\n                return (resolve, reject) => {\r\n                    this.$http\r\n                        .post(\"/api/qz/signing\", {\r\n                            request: toSign\r\n                        })\r\n                        .then(response => {\r\n                            resolve(response.data);\r\n                        })\r\n                        .catch(error => {\r\n                            reject(error.data);\r\n                        });\r\n                };\r\n            });\r\n            if (this.printerOn == 1) {\r\n                if (multiple_boxes == true) {\r\n                    if (true) {\r\n                        let config = qz.configs.create(Printer, {\r\n                            scaleContent: false\r\n                        });\r\n                        if (!qz.websocket.isActive()) {\r\n                            await qz.websocket.connect(config);\r\n                        }\r\n                        let data = [\r\n                            {\r\n                                type: \"pdf\",\r\n                                format: \"file\",\r\n                                data: linkpdf\r\n                            }\r\n                        ];\r\n                        qz.print(config, data).catch(e => {\r\n                            this.$toast.error(e.message);\r\n                        });\r\n                        for (let index = 0; index < copies; index++) {\r\n                            qz.print(config, data).catch(e => {\r\n                                this.$toast.error(e.message);\r\n                            });\r\n                        }\r\n                    }\r\n                }\r\n                if (multiple_boxes == false) {\r\n                    let config = qz.configs.create(Printer, {\r\n                        scaleContent: false\r\n                    });\r\n                    if (!qz.websocket.isActive()) {\r\n                        await qz.websocket.connect(config);\r\n                    }\r\n                    let data = [\r\n                        {\r\n                            type: \"pdf\",\r\n                            format: \"file\",\r\n                            data: linkpdf\r\n                        }\r\n                    ];\r\n\r\n                    qz.print(config, data).catch(e => {\r\n                        this.$toast.error(e.message);\r\n                    });\r\n                    for (let index = 0; index < copies; index++) {\r\n                        qz.print(config, data).catch(e => {\r\n                            this.$toast.error(e.message);\r\n                        });\r\n                    }\r\n                }\r\n            }\r\n        },\r\n        async clickSendWhatsapp(\r\n            document_type_id,\r\n            document_id,\r\n            number,\r\n            form = {}\r\n        ) {\r\n            if (form.customer_telephone != null) {\r\n                let formWhatsapp = {\r\n                    id: this.recordId,\r\n                    document_id: document_id,\r\n                    document_type_id: document_type_id,\r\n                    customer_telephone: form.customer_telephone,\r\n                    sender: \"sdrimsac\",\r\n                    mensaje:\r\n                        \"Su comprobante de pago electrónico \" +\r\n                        number +\r\n                        \" de *\" +\r\n                        this.company.name +\r\n                        \"*, ha sido generado correctamente a través del facturador electrónico de \"+\"*\"+this.$desarrollador+\"*\"\r\n                };\r\n                try {\r\n                    this.loading = true;\r\n                    let response = await this.$http.post(\r\n                        `/whatsapp`,\r\n                        formWhatsapp\r\n                    );\r\n                    if (response.data.success == true) {\r\n                        this.$toast.success(response.data.message);\r\n                        this.loading = false;\r\n                    }\r\n\r\n                    if (\r\n                        this.configuration.xml_whatsapp &&\r\n                        document_type_id != \"80\"\r\n                    ) {\r\n                        formWhatsapp.xml = true;\r\n                        response = await this.$http.post(\r\n                            `/whatsapp`,\r\n                            formWhatsapp\r\n                        );\r\n                        if (response.data.success == true) {\r\n                            this.$toast.success(response.data.message);\r\n                            this.loading = false;\r\n                        }\r\n                    }\r\n                } catch (e) {\r\n                    console.log(e, \" error\");\r\n                } finally {\r\n                    this.loading = false;\r\n                }\r\n            }\r\n        },\r\n        changeDateOfIssue() {\r\n            this.form.date_of_due = this.form.date_of_issue;\r\n            if (\r\n                moment(this.form.date_of_issue) < moment().day(-1) &&\r\n                this.configuration.restrict_receipt_date\r\n            ) {\r\n                this.$toast.error(\r\n                    \"No puede seleccionar una fecha menor a 6 días.\"\r\n                );\r\n                this.dateValid = false;\r\n            } else {\r\n                this.dateValid = true;\r\n            }\r\n            this.form.date_of_due = this.form.date_of_issue;\r\n            this.searchExchangeRateByDate(this.form.date_of_issue).then(\r\n                response => {\r\n                    this.form.exchange_rate_sale = response;\r\n                }\r\n            );\r\n            this.form.exchange_rate_sale = 1;\r\n        },\r\n        NuevaVenta() {\r\n            this.$parent.nueva_venta();\r\n        },\r\n\r\n        async setInitialAmount() {\r\n            this.enter_amount = this.form.total;\r\n            this.form.payments = [];\r\n            await this.$refs.enter_amount.$el\r\n                .getElementsByTagName(\"input\")[0]\r\n                .focus();\r\n            await this.$refs.enter_amount.$el\r\n                .getElementsByTagName(\"input\")[0]\r\n                .select();\r\n        },\r\n        inputDiscountAmount() {\r\n            if (this.enabled_discount) {\r\n                if (\r\n                    this.discount_amount &&\r\n                    !isNaN(this.discount_amount) &&\r\n                    parseFloat(this.discount_amount) > 0\r\n                ) {\r\n                    if (this.discount_amount >= this.form.total)\r\n                        return this.$toast.error(\r\n                            \"El monto de descuento debe ser menor al total de venta\"\r\n                        );\r\n\r\n                    this.reCalculateTotal();\r\n                } else {\r\n                    this.deleteDiscountGlobal();\r\n                    this.reCalculateTotal();\r\n                }\r\n            }\r\n        },\r\n        discountGlobal() {\r\n            let global_discount = parseFloat(this.discount_amount);\r\n            let base = parseFloat(this.form.total);\r\n            let amount = parseFloat(global_discount);\r\n            let factor = _.round(amount / base, 4);\r\n\r\n            let discount = _.find(this.form.discounts, {\r\n                discount_type_id: \"03\"\r\n            });\r\n\r\n            if (global_discount > 0 && !discount) {\r\n                this.form.total_discount = _.round(amount, 2);\r\n\r\n                this.form.total = _.round(this.form.total - amount, 2);\r\n\r\n                this.form.total_value = _.round(\r\n                    this.form.total / (1 + this.percentage_igv / 100),\r\n                    2\r\n                );\r\n                this.form.total_taxed = this.form.total_value;\r\n\r\n                this.form.total_igv = _.round(\r\n                    this.form.total_value * (this.percentage_igv / 100),\r\n                    2\r\n                );\r\n                this.form.total_taxes = this.form.total_igv;\r\n\r\n                this.form.discounts.push({\r\n                    discount_type_id: \"03\",\r\n                    description:\r\n                        \"Descuentos globales que no afectan la base imponible del IGV/IVAP\",\r\n                    factor: factor,\r\n                    amount: amount,\r\n                    base: base\r\n                });\r\n            } else {\r\n                let index = this.form.discounts.indexOf(discount);\r\n\r\n                if (index > -1) {\r\n                    this.form.total_discount = _.round(amount, 2);\r\n                    this.form.total = _.round(this.form.total - amount, 2);\r\n                    this.form.total_value = _.round(\r\n                        this.form.total / (1 + this.percentage_igv / 100),\r\n                        2\r\n                    );\r\n                    this.form.total_taxed = this.form.total_value;\r\n                    this.form.total_igv = _.round(\r\n                        this.form.total_value * (this.percentage_igv / 100),\r\n                        2\r\n                    );\r\n                    this.form.total_taxes = this.form.total_igv;\r\n\r\n                    this.form.discounts[index].base = base;\r\n                    this.form.discounts[index].amount = amount;\r\n                    this.form.discounts[index].factor = factor;\r\n                }\r\n            }\r\n        },\r\n        method_payment(method_pay) {\r\n            this.form.payment_condition_id = \"01\";\r\n            this.form.method_pay = method_pay;\r\n            this.form.afectar_caja = true;\r\n        },\r\n        reCalculateTotal() {\r\n            let total_discount = 0;\r\n            let total_charge = 0;\r\n            let total_exportation = 0;\r\n            let total_taxed = 0;\r\n            let total_exonerated = 0;\r\n            let total_unaffected = 0;\r\n            let total_free = 0;\r\n            let total_igv = 0;\r\n            let total_value = 0;\r\n            let total = 0;\r\n            let total_plastic_bag_taxes = 0;\r\n            console.log(this.form.items);\r\n            this.form.items.forEach(row => {\r\n                total_discount += parseFloat(row.total_discount);\r\n                total_charge += parseFloat(row.total_charge);\r\n\r\n                if (row.affectation_igv_type_id === \"10\") {\r\n                    total_taxed += parseFloat(row.total_value);\r\n                }\r\n                if (row.affectation_igv_type_id === \"20\") {\r\n                    total_exonerated += parseFloat(row.total_value);\r\n                }\r\n                if (row.affectation_igv_type_id === \"30\") {\r\n                    total_unaffected += parseFloat(row.total_value);\r\n                }\r\n                if (row.affectation_igv_type_id === \"40\") {\r\n                    total_exportation += parseFloat(row.total_value);\r\n                }\r\n                if (\r\n                    [\"10\", \"20\", \"30\", \"40\"].indexOf(\r\n                        row.affectation_igv_type_id\r\n                    ) < 0\r\n                ) {\r\n                    total_free += parseFloat(row.total_value);\r\n                }\r\n                if (\r\n                    [\"10\", \"20\", \"30\", \"40\"].indexOf(\r\n                        row.affectation_igv_type_id\r\n                    ) > -1\r\n                ) {\r\n                    total_igv += parseFloat(row.total_igv);\r\n                    total += parseFloat(row.total);\r\n                }\r\n                total_value += parseFloat(row.total_value);\r\n                total_plastic_bag_taxes += isNaN(\r\n                    parseFloat(row.total_plastic_bag_taxes)\r\n                )\r\n                    ? 0.0\r\n                    : parseFloat(row.total_plastic_bag_taxes);\r\n            });\r\n\r\n            this.form.total_exportation = _.round(total_exportation, 2);\r\n            this.form.total_taxed = _.round(total_taxed, 2);\r\n            this.form.total_exonerated = _.round(total_exonerated, 2);\r\n            this.form.total_unaffected = _.round(total_unaffected, 2);\r\n            this.form.total_free = _.round(total_free, 2);\r\n            this.form.total_igv = _.round(total_igv, 2);\r\n            this.form.total_value = _.round(total_value, 2);\r\n            this.form.total_taxes = _.round(total_igv, 2);\r\n            this.form.total_plastic_bag_taxes = _.round(\r\n                total_plastic_bag_taxes,\r\n                2\r\n            );\r\n            this.form.total = _.round(total, 2);\r\n\r\n            // this.form.total = _.round(\r\n            //     total + this.form.total_plastic_bag_taxes,\r\n            //     2\r\n            // );\r\n\r\n            // this.discountGlobal();\r\n\r\n            // this.form.difference =\r\n            //     this.form.total - (this.form.enter_amount || 0);\r\n        },\r\n        deleteDiscountGlobal() {\r\n            let discount = _.find(this.form.discounts, {\r\n                discount_type_id: \"03\"\r\n            });\r\n            let index = this.form.discounts.indexOf(discount);\r\n\r\n            if (index > -1) {\r\n                this.form.discounts.splice(index, 1);\r\n                this.form.total_discount = 0;\r\n            }\r\n        },\r\n\r\n        getFormPosLocalStorage() {\r\n            let form_pos = localStorage.getItem(\"form_pos\");\r\n            form_pos = JSON.parse(form_pos);\r\n            if (form_pos) {\r\n                this.form.payments = form_pos.payments;\r\n            }\r\n        },\r\n        clickAddPayment() {\r\n            this.showDialogMultiplePayment = true;\r\n        },\r\n        reloadDataCardBrands(card_brand_id) {\r\n            this.$http\r\n                .get(`/${this.resource}/table/card_brands`)\r\n                .then(response => {\r\n                    this.cards_brand = response.data;\r\n                    this.form_payment.card_brand_id = card_brand_id;\r\n                    this.changePaymentMethodType();\r\n                });\r\n        },\r\n        getDescriptionPaymentMethodType(id) {\r\n            let payment_method_type = _.find(this.payment_method_types, {\r\n                id: id\r\n            });\r\n            return payment_method_type ? payment_method_type.description : \"\";\r\n        },\r\n        changePaymentMethodType() {\r\n            let payment_method_type = _.find(this.payment_method_types, {\r\n                id: this.form_payment.payment_method_type_id\r\n            });\r\n            this.has_card = payment_method_type.has_card;\r\n            this.form_payment.card_brand_id = payment_method_type.has_card\r\n                ? this.form_payment.card_brand_id\r\n                : null;\r\n        },\r\n        addRow(payments) {\r\n            this.form.payments = payments;\r\n            let acum_payment = 0;\r\n\r\n            this.form.payments.forEach(item => {\r\n                acum_payment += parseFloat(item.payment);\r\n            });\r\n            // this.amount = acum_payment\r\n            this.setAmount(acum_payment);\r\n\r\n            // console.log(this.form.payments)\r\n        },\r\n        setAmount(amount) {\r\n            // this.amount = parseFloat(this.amount) + parseFloat(amount)\r\n            this.form.enter_amount = amount;\r\n            this.amount = parseFloat(amount); //+ parseFloat(amount)\r\n            //   this.form.enter_amount =  parseFloat(amount) //+ parseFloat(amount)\r\n            this.inputAmount(amount);\r\n        },\r\n        setAmountCash(amount) {\r\n            this.setAmount(amount);\r\n        },\r\n        async diferen() {\r\n            let differen =\r\n                (parseFloat(this.form.enter_amount) || 0) +\r\n                this.totalPayments() -\r\n                parseFloat(this.form.total);\r\n            if (differen < 0) {\r\n                // this.$toast.error(\r\n                //     \"El monto de efectivo es menor al total de venta\"\r\n                // );\r\n            }\r\n        },\r\n        totalPayments() {\r\n            if (this.currentPayments.length != 0) {\r\n                let enter_amount = 0.0;\r\n                this.currentPayments.forEach(cp => {\r\n                    enter_amount += parseFloat(cp.amount);\r\n                });\r\n                return enter_amount;\r\n            }\r\n            return 0;\r\n        },\r\n        async enterAmount(amount = 0) {\r\n            this.amount = amount;\r\n\r\n            let enter_amount = parseFloat(this.form.enter_amount) || 0;\r\n            // +this.totalPayments();\r\n\r\n            let differen = enter_amount - parseFloat(this.form.total);\r\n\r\n            this.form.difference = parseFloat(differen);\r\n\r\n            if (this.form.difference < 0) {\r\n                // this.button_payment = true;\r\n                this.form.difference = differen;\r\n            } else if (this.form.difference >= 0) {\r\n                this.button_payment = false;\r\n                parseFloat(this.form.enter_amount) -\r\n                    parseFloat(this.form.total);\r\n            } else {\r\n                // this.button_payment = true;\r\n            }\r\n            //this.form.difference = _.round(this.form.difference, 2);\r\n\r\n            // this.$eventHub.$emit(\"eventSetFormPosLocalStorage\", this.form);\r\n            // this.setAmountCash(amount)\r\n        },\r\n        getLocalStoragePayment(key, re_default = null) {\r\n            let ls_obj = localStorage.getItem(key);\r\n            ls_obj = JSON.parse(ls_obj);\r\n\r\n            if (ls_obj) {\r\n                return ls_obj;\r\n            }\r\n\r\n            return re_default;\r\n        },\r\n        setLocalStoragePayment(key, obj) {\r\n            return localStorage.setItem(key, JSON.stringify(obj));\r\n        },\r\n        inputAmount(amount = null) {\r\n            this.enterAmount(amount);\r\n            this.form.difference = this.form.enter_amount - this.form.total;\r\n            if (isNaN(this.form.difference)) {\r\n                // this.button_payment = true;\r\n                this.form.difference = \"-\";\r\n            } else if (this.form.difference >= 0) {\r\n                this.button_payment = false;\r\n                this.form.difference = this.amount - this.form.total;\r\n            } else {\r\n                // this.button_payment = true;\r\n            }\r\n            this.$eventHub.$emit(\"eventSetFormPosLocalStorage\", this.form);\r\n        },\r\n        lStoPayment() {\r\n            this.setLocalStoragePayment(\"enter_amount\", this.form.enter_amount);\r\n            this.setLocalStoragePayment(\r\n                \"amount\",\r\n                this.amount == 0 ? this.form.total : this.amount\r\n            );\r\n            this.setLocalStoragePayment(\r\n                \"difference\",\r\n                this.amount == 0 ? this.form.total - this.amount : 0\r\n            );\r\n        },\r\n        initFormPayment() {\r\n            this.form.difference = 15; //this.form.total - this.form.enter_amount;\r\n            this.form_payment = {\r\n                id: null,\r\n                date_of_payment: moment().format(\"YYYY-MM-DD\"),\r\n                payment_method_type_id: \"01\",\r\n                reference: null,\r\n                card_brand_id: null,\r\n                document_id: null,\r\n                sale_note_id: null,\r\n                payment: this.form.total\r\n            };\r\n\r\n            this.form_cash_document = {\r\n                document_id: null,\r\n                sale_note_id: null\r\n            };\r\n        },\r\n\r\n        cleanLocalStoragePayment() {\r\n            this.setLocalStoragePayment(\"form_pos\", null);\r\n            this.setLocalStoragePayment(\"amount\", null);\r\n            this.setLocalStoragePayment(\"enter_amount\", null);\r\n            this.setLocalStoragePayment(\"difference\", null);\r\n        },\r\n        sleep(ms) {\r\n            return new Promise(resolve => setTimeout(resolve, ms));\r\n        },\r\n        passBoxes(total, boxes) {\r\n            let amounts = boxes.reduce((a, b) => a + b.amount, 0);\r\n            let rest = amounts - total;\r\n            let plus = false;\r\n            if (rest < 0) {\r\n                plus = true;\r\n                rest *= -1;\r\n            }\r\n            let newBoxes = [...boxes];\r\n\r\n            if (rest != 0) {\r\n                for (let i = 0; i < newBoxes.length; i++) {\r\n                    let box = newBoxes[i];\r\n                    if (plus) {\r\n                        box.amount += rest;\r\n                        rest = 0;\r\n                    } else {\r\n                        if (box.amount - rest > 0) {\r\n                            box.amount -= rest;\r\n                            rest = 0;\r\n                        }\r\n                    }\r\n\r\n                    if (rest == 0) {\r\n                        break;\r\n                    }\r\n                }\r\n            }\r\n            return newBoxes;\r\n        },\r\n        async sendPayment($event, form = null) {\r\n            if (!this.cash_id) {\r\n                this.$toast.error(\"Seleccione o abra una caja.\");\r\n                return;\r\n            }\r\n\r\n            let payIncomplete = false;\r\n            let different =\r\n                parseFloat(this.form.enter_amount) -\r\n                parseFloat(this.form.total);\r\n            if (different < 0) {\r\n                try {\r\n                    await this.$confirm(\r\n                        `Hay un saldo por cobrar de ${different * -1}`,\r\n                        \"Saldo\",\r\n                        {\r\n                            distinguishCancelAndClose: true,\r\n                            confirmButtonText: \"Pagar\",\r\n                            cancelButtonText: \"Cambiar cantidad\"\r\n                        }\r\n                    );\r\n                    payIncomplete = true;\r\n                } catch (e) {\r\n                    return;\r\n                }\r\n            }\r\n\r\n            if (payIncomplete) {\r\n                this.incomplete = true;\r\n                let newPrice = isNaN(parseFloat(this.form.enter_amount))\r\n                    ? 0\r\n                    : parseFloat(this.form.enter_amount);\r\n                //45\r\n\r\n                this.changePrice(newPrice);\r\n                this.reCalculateTotal();\r\n            }\r\n            if (this.form.total == 0) {\r\n                this.$toast.error(\"Monto inválido.\");\r\n                return;\r\n            }\r\n            if (this.form.total) this.form.cash_id = this.cash_id;\r\n            if (!form) {\r\n                form = this.form;\r\n            }\r\n\r\n            form.printerOn = this.printerOn == 1 ? true : false;\r\n            let registered = true;\r\n            if (this.type != \"incomplete\") {\r\n                registered = await this.sendRegister();\r\n            } else {\r\n                this.registerId = this.register.id;\r\n            }\r\n\r\n            if (registered) {\r\n                let payed = await this.clickPayment(form);\r\n                if (payed) {\r\n                    await this.sendCollegePayment();\r\n                }\r\n            }\r\n        },\r\n        async sendCollegePayment() {\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.post(`/college/payments`, {\r\n                    document_id: this.documentId,\r\n                    register_id: this.registerId,\r\n                    months:\r\n                        this.type == \"incomplete\"\r\n                            ? []\r\n                            : this.formRegister.months,\r\n                    active: 1,\r\n                    type: this.incomplete ? \"incomplete\" : \"complete\",\r\n                    details: this.formRegister.detail\r\n                });\r\n\r\n                this.$emit(\"getRecords\");\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        async sendRegister() {\r\n            if (!this.formRegister) {\r\n                this.$toast.error(\"Seleccione un plan/estudiante\");\r\n                return false;\r\n            }\r\n            try {\r\n                this.loading = true;\r\n                console.log(this.formRegister);\r\n                const response = await this.$http.post(\r\n                    `/college/registers`,\r\n                    this.formRegister\r\n                );\r\n                const { id } = response.data;\r\n                this.registerId = id;\r\n                return true;\r\n            } catch (e) {\r\n                console.log(e);\r\n                this.$toast.error(\"Ocurrió un error\");\r\n                return false;\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        formatItems() {\r\n            this.form.items = this.form.items\r\n                .map(i => {\r\n                    i.quantity = 1;\r\n\r\n                    return {\r\n                        ...i,\r\n\r\n                        warehouse_id: null,\r\n                        item: i,\r\n                        item_id: i.id,\r\n                        unit_value:\r\n                            i.sale_affectation_igv_type_id == 10\r\n                                ? i.sale_unit_price /\r\n                                  (1 + this.percentage_igv / 100)\r\n                                : i.sale_unit_price,\r\n                        quantity: i.quantity,\r\n                        aux_quantity: i.quantity,\r\n                        total_base_igv:\r\n                            i.sale_affectation_igv_type_id == 10\r\n                                ? (i.sale_unit_price * i.quantity) /\r\n                                  (1 + this.percentage_igv / 100)\r\n                                : i.sale_unit_price * i.quantity,\r\n                        percentage_igv: this.percentage_igv,\r\n                        total_igv:\r\n                            i.sale_affectation_igv_type_id == 10\r\n                                ? ((i.sale_unit_price * i.quantity) /\r\n                                      (1 + this.percentage_igv / 100)) *\r\n                                  (this.percentage_igv / 100)\r\n                                : 0,\r\n                        total_base_isc: 0.0,\r\n                        percentage_isc: 0.0,\r\n                        total_isc: 0.0,\r\n                        total_base_other_taxes: 0.0,\r\n                        percentage_other_taxes: 0.0,\r\n                        total_other_taxes: 0.0,\r\n                        total_taxes:\r\n                            i.sale_affectation_igv_type_id == 10\r\n                                ? ((i.sale_unit_price * i.quantity) /\r\n                                      (1 + this.percentage_igv / 100)) *\r\n                                  (this.percentage_igv / 100)\r\n                                : 0,\r\n                        total_value:\r\n                            i.sale_affectation_igv_type_id == 10\r\n                                ? (i.sale_unit_price * i.quantity) /\r\n                                  (1 + this.percentage_igv / 100)\r\n                                : i.quantity * i.sale_unit_price,\r\n                        total_charge: 0.0,\r\n                        total_discount: 0.0,\r\n                        total: i.sale_unit_price * i.quantity,\r\n                        price_type_id: \"01\",\r\n                        unit_price: i.sale_unit_price,\r\n                        unit_price_value: i.sale_unit_price,\r\n                        has_igv: i.has_igv,\r\n                        affectation_igv_type_id: i.sale_affectation_igv_type_id,\r\n                        unit_price: i.sale_unit_price,\r\n                        presentation: null,\r\n                        charges: [],\r\n                        discounts: [],\r\n                        attributes: [],\r\n                        affectation_igv_type: i.sale_affectation_igv_type_id\r\n                    };\r\n                })\r\n                .filter(i => i.total > 0);\r\n        },\r\n        async clickPayment(form) {\r\n            //identity_document_type_id\r\n            //\r\n            if (!this.form.cash_id) {\r\n                this.$toast.error(\"Seleccione o abra una caja.\");\r\n                return;\r\n            }\r\n            let customer = form.customer;\r\n            if (\r\n                customer.identity_document_type_id == \"1\" ||\r\n                customer.identity_document_type_id == \"F\"\r\n            ) {\r\n                form.document_type_id = \"03\";\r\n            } else {\r\n                form.document_type_id = \"01\";\r\n            }\r\n\r\n            let serie = this.series.find(\r\n                s => s.document_type_id == form.document_type_id\r\n            );\r\n            this.form.series_id = serie.id;\r\n            if (\r\n                form.customer_telephone != null &&\r\n                form.customer_telephone != \"\"\r\n            ) {\r\n                console.log(form.customer_telephone);\r\n                console.log(form.customer_telephone.length);\r\n                if (!this.existNumber()) {\r\n                    this.$toast.error(\"Número para envío whatsapp inválido\");\r\n                    return;\r\n                }\r\n            }\r\n            if (form.customer_id == null || form.customer_id == \"\") {\r\n                return this.$toast.error(\"Elija un cliente\");\r\n            }\r\n            if (\r\n                customer.identity_document_type_id == \"1\" &&\r\n                form.document_type_id == \"01\"\r\n            ) {\r\n                return this.$toast.error(\"No puede emitir Factura con DNI\");\r\n            }\r\n            if (!form.series_id) {\r\n                return this.$toast.warning(\r\n                    \"El establecimiento no tiene series disponibles para el comprobante\"\r\n                );\r\n            }\r\n\r\n            form.prefix = null;\r\n            this.resource_documents = \"documents\";\r\n            this.resource_payments = \"document_payments\";\r\n            this.resource_options = this.resource_documents;\r\n\r\n            form.advances = 0.0;\r\n            form.total_advances = 0.0;\r\n            form.total_payment = form.total;\r\n            form.payments = [\r\n                {\r\n                    payment_method_type_id: \"01\",\r\n                    date_of_payment: form.date_of_issue,\r\n                    payment: form.total\r\n                }\r\n            ];\r\n\r\n            form.boxes = this.currentPayments;\r\n            this.addPayment();\r\n            this.form.observation = this.observation;\r\n            this.loading_submit = true;\r\n\r\n            try {\r\n                form.orden_id = null;\r\n\r\n                const response = await this.$http.post(\r\n                    `/${this.resource_documents}`,\r\n                    form\r\n                );\r\n\r\n                if (response.status == 200) {\r\n                    if (response.data.success == true) {\r\n                        this.documentId = response.data.data.id;\r\n                        this.form_cash_document.document_id =\r\n                            response.data.data.id;\r\n                        this.number = response.data.data.number;\r\n                        this.documentNewId = response.data.data.id;\r\n\r\n                        if (response.data.success == true) {\r\n                            if (this.form.customer_telephone) {\r\n                                if (this.personalWhatsapp) {\r\n                                    await this.getFile({\r\n                                        documentId: this.documentNewId,\r\n                                        documentTypeId: form.document_type_id,\r\n                                        number: this.form.customer_telephone,\r\n                                        message: this.form.message\r\n                                    });\r\n                                } else {\r\n                                    await this.clickSendWhatsapp(\r\n                                        form.document_type_id,\r\n                                        this.documentNewId,\r\n                                        this.number,\r\n                                        form\r\n                                    );\r\n                                }\r\n                                this.loading_submit = false;\r\n                                this.back(true);\r\n                            } else {\r\n                                this.loading_submit = false;\r\n                                this.back(true);\r\n                            }\r\n                        }\r\n                        return true;\r\n                    }\r\n                } else {\r\n                    this.loading_submit = true;\r\n                    this.$alert(\r\n                        \"<strong>Ocurrio un error </strong>\" +\r\n                            response.statusCode +\r\n                            \"<br>\" +\r\n                            this.resource_documents,\r\n                        \"HTML String\",\r\n                        {\r\n                            dangerouslyUseHTMLString: true\r\n                        }\r\n                    );\r\n                    return false;\r\n                }\r\n            } catch (error) {\r\n                console.log(error);\r\n                const response = error.response;\r\n                let {\r\n                    data: { message }\r\n                } = response;\r\n\r\n                this.$toast.error(message || \"Ocurrió un error\");\r\n\r\n                return false;\r\n            } finally {\r\n                this.loading_submit = false;\r\n            }\r\n        },\r\n\r\n        async clickPrintPos(printerName, formatoPdf, userId = null) {\r\n            try {\r\n                let config = qz.configs.create(\r\n                    printerName,\r\n                    { legacy: true },\r\n                    { scaleContent: false }\r\n                );\r\n                if (!qz.websocket.isActive()) {\r\n                    await qz.websocket.connect(config);\r\n                }\r\n                let data = [\r\n                    {\r\n                        type: \"pdf\",\r\n                        format: \"file\",\r\n                        data: formatoPdf\r\n                    }\r\n                ];\r\n                qz.print(config, data).catch(e => {\r\n                    this.$toast.error(e.message);\r\n                });\r\n            } catch (e) {\r\n                this.$toast.error(e.message);\r\n            }\r\n        },\r\n        saveCashDocument() {\r\n            this.$http\r\n                .post(`/cash/cash_document`, this.form_cash_document)\r\n                .then(response => {\r\n                    if (response.data.success) {\r\n                    } else {\r\n                        this.$toast.error(response.data.message);\r\n                    }\r\n                })\r\n                .catch(error => {\r\n                    console.log(error);\r\n                });\r\n        },\r\n        savePaymentMethod() {\r\n            this.$http\r\n                .post(`/${this.resource_payments}`, this.form_payment)\r\n                .then(response => {\r\n                    if (response.data.success) {\r\n                        // console.log(response)\r\n                    } else {\r\n                        this.$toast.error(response.data.message);\r\n                    }\r\n                })\r\n                .catch(error => {\r\n                    if (error.response.status === 422) {\r\n                        this.records[index].errors = error.response.data;\r\n                    } else {\r\n                        console.log(error);\r\n                    }\r\n                });\r\n        },\r\n\r\n        async clickCancel() {\r\n            this.loading_submit = true;\r\n\r\n            this.loading_submit = false;\r\n            this.cleanLocalStoragePayment();\r\n            this.$eventHub.$emit(\"cancelSale\");\r\n        },\r\n        back(val = false) {\r\n            if (this.type == \"service\") {\r\n                this.$refs.service.initForm();\r\n            } else if (this.type == \"register\") {\r\n                this.$refs.register.initForm();\r\n            } else if (this.type == \"incomplete\") {\r\n                this.$refs.incomplete.initForm();\r\n            } else {\r\n                console.log(\"object\");\r\n            }\r\n\r\n            this.splitPayments = [];\r\n            //this.$emit(\"limpiarForm\");\r\n            if (!val) {\r\n                this.$emit(\"openDrawer\");\r\n            }\r\n            this.$emit(\"update:is_payment\", false);\r\n        },\r\n        async initLStoPayment() {\r\n            this.amount = await this.getLocalStoragePayment(\r\n                \"amount\",\r\n                this.form.total\r\n            );\r\n            this.form.enter_amount = await this.getLocalStoragePayment(\r\n                \"enter_amount\",\r\n                this.form.total\r\n            );\r\n            this.form.difference = await this.getLocalStoragePayment(\r\n                \"difference\",\r\n                this.form.total - this.form.enter_amount\r\n            );\r\n        },\r\n        checkCustomers() {\r\n            if (this.form.document_type_id == \"01\") {\r\n                return this.customers.some(\r\n                    c => c.identity_document_type_id == \"6\"\r\n                );\r\n            } else {\r\n                return this.customers.some(\r\n                    c => c.identity_document_type_id == \"1\"\r\n                );\r\n            }\r\n        },\r\n        setSeries() {\r\n            this.form.series_id = null;\r\n            this.series = _.filter(this.all_series, {\r\n                document_type_id: this.form.document_type_id\r\n            });\r\n            this.series.forEach(s => {\r\n                s.full_number =\r\n                    `${s.number}-${this.last_number[s.number] || \"1\"}` ||\r\n                    s.number;\r\n            });\r\n            this.form.series_id =\r\n                this.series.length > 0 ? this.series[0].id : null;\r\n        },\r\n\r\n        filterSeries() {\r\n            let check = this.checkCustomers();\r\n            if (!check && !this.started) {\r\n                let dcto = \"DNI\";\r\n                if (this.form.document_type_id == \"01\") {\r\n                    dcto = \"RUC\";\r\n                    this.form.document_type_id = \"03\";\r\n                } else {\r\n                    this.form.document_type_id = \"01\";\r\n                }\r\n                this.$toast.warning(`Digite el número de ${dcto}`);\r\n\r\n                this.setSeries();\r\n                return;\r\n            }\r\n            this.started = false;\r\n\r\n            if (this.form.document_type_id == \"01\") {\r\n                this.currentDocumentsType = [\r\n                    ...this.documentsType.filter(f => f.description == \"RUC\")\r\n                ];\r\n                this.form.identity_document_type_id = this.currentDocumentsType[0].id;\r\n            } else {\r\n                this.currentDocumentsType = this.documentsType;\r\n            }\r\n            this.setSeries();\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-89779052\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/payment_college.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      staticClass: "algunaClase",
      attrs: {
        visible: _vm.is_payment,
        "close-on-click-modal": false,
        "close-on-press-escape": false,
        "modal-append-to-body": true,
        "show-close": false,
        "append-to-body": true,
        width: "770px",
        top: "2vh",
        title: _vm.title || "MODULO DE CAJA"
      },
      on: { open: _vm.open }
    },
    [
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
          staticClass: "mb-0"
        },
        [
          _c(
            "div",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading_submit,
                  expression: "loading_submit"
                }
              ],
              staticClass: "pt-1"
            },
            [
              _c(
                "div",
                { staticClass: "row" },
                [
                  _vm.type == "incomplete"
                    ? [
                        _c("incomplete-form", {
                          ref: "incomplete",
                          attrs: {
                            payable: _vm.payable,
                            services: _vm.services,
                            plan: _vm.plan,
                            member: _vm.member,
                            register: _vm.register
                          },
                          on: {
                            "update:payable": function($event) {
                              _vm.payable = $event
                            },
                            updateItems: _vm.updateItems,
                            updateObservation: _vm.updateObservation,
                            createFormRegister: _vm.createFormIncomplete,
                            updateCustomer: _vm.updateCustomer,
                            "update:member": function($event) {
                              _vm.member = $event
                            }
                          }
                        })
                      ]
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.type == "service"
                    ? [
                        _c("service-form", {
                          ref: "service",
                          attrs: { member: _vm.member },
                          on: {
                            updateTotal: _vm.updateTotal,
                            updateItems: _vm.updateItems,
                            updateObservation: _vm.updateObservation,
                            updateCustomer: _vm.updateCustomer,
                            createFormRegister: _vm.createFormService,
                            "update:member": function($event) {
                              _vm.member = $event
                            }
                          }
                        })
                      ]
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.type == "register"
                    ? [
                        _c("register-form", {
                          ref: "register",
                          attrs: { record: _vm.record },
                          on: {
                            updateTotal: _vm.updateTotal,
                            updateItems: _vm.updateItems,
                            updateObservation: _vm.updateObservation,
                            updateCustomer: _vm.updateCustomer,
                            createFormRegister: _vm.createFormRegister
                          }
                        })
                      ]
                    : _vm._e()
                ],
                2
              ),
              _vm._v(" "),
              _c("div", { staticClass: "row pt-2" }, [
                _c("div", { staticClass: "col-lg-12" }, [
                  _c("div", { staticClass: "mb-2" }, [
                    _c("div", { staticClass: "card bg-light" }, [
                      _c("div", { staticClass: "row col-lg-6 col-xl-12" }, [
                        _c(
                          "div",
                          { staticClass: "form-group" },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Observaciones")
                            ]),
                            _vm._v(" "),
                            _c("el-input", {
                              attrs: { type: "textarea", rows: 2 },
                              model: {
                                value: _vm.observation,
                                callback: function($$v) {
                                  _vm.observation = $$v
                                },
                                expression: "observation"
                              }
                            })
                          ],
                          1
                        )
                      ])
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-12" }, [
                  _c("div", { staticClass: "mb-2" }, [
                    _c(
                      "div",
                      { staticClass: "text-center text-dark card bg-light" },
                      [
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "col-lg-12" }, [
                            _c("div", { staticClass: "align-items-start" }, [
                              _c("label", { staticClass: "control-label" }, [
                                _vm._v("Medios de Pago")
                              ]),
                              _vm._v(" "),
                              _c("label", {
                                staticClass: "text-primary control-label",
                                attrs: { role: "button" }
                              })
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "radio-tile-group2 flex-wrap" },
                              [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "cash",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "01"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "01"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "01"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "Efectivo"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonEfectivo.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon walk-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "cash" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "culqui",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "02"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "02"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "02"
                                          },
                                          function($event) {
                                            return _vm.method_payment("Culqui")
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/CulquiIcon.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "05"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "05"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "05"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "TARJETA: IZYPAY"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonIzipay.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "06"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "06"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "06"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "TARJETA: NIUBIZ"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonNiubiz.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "yape",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "03"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "03"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "03"
                                          },
                                          function($event) {
                                            return _vm.method_payment("Yape")
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "04"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "04"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "04"
                                          },
                                          function($event) {
                                            return _vm.method_payment("PLIN")
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/plin-logo-0C4106153C-seeklogo.com.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c("div", { staticClass: "row col-md-12" }, [
                              _c("div", { staticClass: "row" }, [
                                _c(
                                  "label",
                                  { staticClass: "control-label text-center" },
                                  [
                                    _vm._v(
                                      "Emision de\n                                                comprobante"
                                    )
                                  ]
                                )
                              ]),
                              _vm._v(" "),
                              _c("div", { staticClass: "row" }, [
                                _c(
                                  "div",
                                  { staticClass: "col-lg-2 col-md-5 col-xl-6" },
                                  [
                                    _c(
                                      "label",
                                      {
                                        staticClass:
                                          "\n                          control-label\n                          text-left\n                          d-flex\n                          align-items-start\n                          justify-content-start\n                        "
                                      },
                                      [
                                        _vm._v(
                                          "\n                                                    Ingrese Nro Celular\n                                                "
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "el-input",
                                      {
                                        model: {
                                          value: _vm.form.customer_telephone,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.form,
                                              "customer_telephone",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "\n                                                        form.customer_telephone\n                                                    "
                                        }
                                      },
                                      [
                                        _c("template", { slot: "prepend" }, [
                                          _c("i", {
                                            staticClass: "fab fa-whatsapp fa-2x"
                                          })
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
                                    staticClass:
                                      "radio-tile-group2 col-lg-6 col-xl-6 d",
                                    staticStyle: { "padding-top": "12px" }
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "input-container2 border rounded-sm col-lg-3"
                                      },
                                      [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: _vm.printerOn,
                                              expression: "printerOn"
                                            }
                                          ],
                                          staticClass: "radio-button2",
                                          attrs: {
                                            id: "imprimir",
                                            type: "radio",
                                            name: "imprimir",
                                            value: "1"
                                          },
                                          domProps: {
                                            checked: _vm._q(_vm.printerOn, "1")
                                          },
                                          on: {
                                            change: function($event) {
                                              _vm.printerOn = "1"
                                            }
                                          }
                                        }),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          { staticClass: "radio-tile2" },
                                          [
                                            _c(
                                              "div",
                                              { staticClass: "icon walk-icon" },
                                              [
                                                _c("i", {
                                                  staticClass: "fa fa-print"
                                                })
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "label",
                                              {
                                                staticClass:
                                                  "radio-tile-label2",
                                                attrs: { for: "cash" }
                                              },
                                              [_vm._v("Imprimir")]
                                            )
                                          ]
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "input-container2 border rounded-sm col-lg-3"
                                      },
                                      [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: _vm.printerOn,
                                              expression: "printerOn"
                                            }
                                          ],
                                          staticClass: "radio-button2",
                                          attrs: {
                                            id: "noimprimir",
                                            type: "radio",
                                            name: "noimprimir",
                                            value: "0"
                                          },
                                          domProps: {
                                            checked: _vm._q(_vm.printerOn, "0")
                                          },
                                          on: {
                                            change: function($event) {
                                              _vm.printerOn = "0"
                                            }
                                          }
                                        }),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          { staticClass: "radio-tile2" },
                                          [
                                            _c(
                                              "div",
                                              { staticClass: "icon bike-icon" },
                                              [
                                                _c("i", {
                                                  staticClass: "fa fa-print"
                                                })
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "label",
                                              {
                                                staticClass:
                                                  "radio-tile-label2",
                                                attrs: { for: "Tarjeta" }
                                              },
                                              [
                                                _vm._v(
                                                  "No\n                                                            Imprimir"
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ])
                            ]),
                            _vm._v(" "),
                            _c("div", { staticClass: "row" }, [
                              _c("div", {
                                staticClass:
                                  "col-lg-8 d-flex flex-row align-items-end"
                              }),
                              _vm._v(" "),
                              _c("div", { staticClass: "d-flex flex-column" })
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass: "row d-flex justify-content-start"
                              },
                              [
                                _vm.currentPayments.length != 0
                                  ? _c("table", { staticClass: "table" }, [
                                      _c("thead", [
                                        _c("tr", [
                                          _c(
                                            "th",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "4" }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        Pagos\n                                                    "
                                              )
                                            ]
                                          )
                                        ])
                                      ]),
                                      _vm._v(" "),
                                      _c(
                                        "tbody",
                                        _vm._l(_vm.currentPayments, function(
                                          paymnt,
                                          idx
                                        ) {
                                          return _c("tr", { key: idx }, [
                                            _c("td", [_vm._v(_vm._s(idx + 1))]),
                                            _vm._v(" "),
                                            _c("td", [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(paymnt.method) +
                                                  "\n                                                    "
                                              )
                                            ]),
                                            _vm._v(" "),
                                            _c("td", [
                                              _c("strong", [
                                                _vm._v(_vm._s(paymnt.amount))
                                              ])
                                            ]),
                                            _vm._v(" "),
                                            _c("td", [
                                              _c(
                                                "label",
                                                {
                                                  staticClass: "text-danger",
                                                  attrs: {
                                                    for: "",
                                                    role: "button"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.removePayment(
                                                        paymnt.id
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass: "fa fa-trash"
                                                  })
                                                ]
                                              )
                                            ])
                                          ])
                                        }),
                                        0
                                      )
                                    ])
                                  : _vm._e()
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "card bg-light col-lg-12" })
                        ])
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-12" }, [
                    _c("div", { staticClass: "mb-2" }, [
                      _c("div", { staticClass: "card bg-light" }, [
                        _c("div", { staticClass: "row" }, [
                          _c(
                            "div",
                            {
                              staticClass: "col-xl-4",
                              class: {
                                "has-danger": _vm.form.difference < 0
                              },
                              staticStyle: {
                                "margin-top": "10px",
                                "padding-top": "5px"
                              }
                            },
                            [
                              _c("label", { staticClass: "control-label h1" }, [
                                _vm._v("Total a cobrar: ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "span",
                                {
                                  staticClass:
                                    "\n                      control-label\n                      font-weight-semibold\n                      text-center\n                      h3\n                    "
                                },
                                [
                                  _vm._v(
                                    "\n                                            S/ " +
                                      _vm._s(" " + _vm.form.total) +
                                      "\n                                        "
                                  )
                                ]
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _vm.form_payment.payment_method_type_id == "01"
                            ? _c("div", { staticClass: "col-xl-8" }, [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "\n                      btn-group btn-group-square\n                      m-0\n                      flex-wrap\n                      justify-content-around\n                    ",
                                    staticStyle: { "padding-top": "12px" },
                                    attrs: { role: "group" }
                                  },
                                  [
                                    _c(
                                      "label",
                                      { staticClass: "control-label" },
                                      [_vm._v("Ingrese monto")]
                                    ),
                                    _vm._v(" "),
                                    _c("div", { staticClass: "row col-12" }, [
                                      _c(
                                        "div",
                                        {
                                          staticClass: "col-2 col-md-2 col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(10)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "10\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass: "col-2 col-md-2 col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(20)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "20\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass: "col-2 col-md-2 col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(50)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "50\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass: "col-2 col-md-2 col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(100)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "100\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass: "col-2 col-md-2 col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(200)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "200\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      { staticClass: "row col-xl-12 col-12" },
                                      [
                                        _c(
                                          "div",
                                          { staticClass: "col-xl-6 col-3" },
                                          [
                                            _c(
                                              "el-input",
                                              {
                                                ref: "enter_amount",
                                                attrs: {
                                                  id: "inputTotal",
                                                  disabled: _vm.form.total == 0
                                                },
                                                on: {
                                                  blur: function($event) {
                                                    return _vm.diferen()
                                                  },
                                                  input: function($event) {
                                                    return _vm.enterAmount()
                                                  }
                                                },
                                                nativeOn: {
                                                  keyup: function($event) {
                                                    if (
                                                      !$event.type.indexOf(
                                                        "key"
                                                      ) &&
                                                      _vm._k(
                                                        $event.keyCode,
                                                        "enter",
                                                        13,
                                                        $event.key,
                                                        "Enter"
                                                      )
                                                    ) {
                                                      return null
                                                    }
                                                    _vm.sendPayment()
                                                    _vm.inputAmount(
                                                      _vm.form.enter_amount
                                                    )
                                                  }
                                                },
                                                model: {
                                                  value: _vm.form.enter_amount,
                                                  callback: function($$v) {
                                                    _vm.$set(
                                                      _vm.form,
                                                      "enter_amount",
                                                      $$v
                                                    )
                                                  },
                                                  expression:
                                                    "\n                                                            form.enter_amount\n                                                        "
                                                }
                                              },
                                              [
                                                _c(
                                                  "template",
                                                  { slot: "prepend" },
                                                  [
                                                    _vm._v(
                                                      _vm._s(
                                                        _vm.currencyTypeActive
                                                          .symbol
                                                      ) +
                                                        "\n                                                        "
                                                    )
                                                  ]
                                                )
                                              ],
                                              2
                                            )
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          { staticClass: "m-2 col-xl-2 col-2" },
                                          [
                                            _c(
                                              "el-button",
                                              {
                                                attrs: { type: "primary" },
                                                on: { click: _vm.addPayment }
                                              },
                                              [_vm._v("Agregar")]
                                            )
                                          ],
                                          1
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _c("div", { staticClass: "row col-xl-4" }, [
                            _c("div", {
                              staticClass: "col-xl-5",
                              staticStyle: { "margin-bottom": "10px" }
                            })
                          ])
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "col-md-6 col-12" }),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "col-md-6 col-12 d-flex justify-content-end"
                            },
                            [
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "form-group d-flex flex-row align-items-end",
                                  class: {
                                    "has-danger": _vm.form.difference < 0
                                  }
                                },
                                [
                                  _c("label", {
                                    staticClass: "control-label display-4",
                                    domProps: {
                                      textContent: _vm._s(
                                        _vm.form.difference < 0
                                          ? "A cuenta: "
                                          : "Vuelto: "
                                      )
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c(
                                    "span",
                                    {
                                      staticClass:
                                        "\n                        control-label\n                        font-weight-semibold\n                        text-center\n                        display-3\n                      "
                                    },
                                    [
                                      _vm._v(
                                        "\n                                                " +
                                          _vm._s(
                                            _vm.currencyTypeActive.symbol
                                          ) +
                                          "\n                                                " +
                                          _vm._s(
                                            _vm.form.difference.toFixed(2)
                                          ) +
                                          "\n                                            "
                                      )
                                    ]
                                  )
                                ]
                              )
                            ]
                          )
                        ])
                      ])
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _vm.splitPayments.length != 0
                ? _c("div", { staticClass: "row m-1 p-2 bg-light rounded" }, [
                    _c("span", { staticStyle: { "margin-bottom": "5px" } }, [
                      _vm._v("Pagos divididos")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "d-flex flex-wrap" },
                      _vm._l(_vm.splitPayments, function(payment, idx) {
                        return _c("div", { key: idx, staticClass: "col-2" }, [
                          _vm._v(
                            "\n                        Pago " +
                              _vm._s(idx + 1) +
                              ":\n                        "
                          ),
                          _c("strong", [
                            _vm._v("S/. " + _vm._s(payment.amount))
                          ])
                        ])
                      }),
                      0
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.splitProducts.length != 0
                ? _c("div", { staticClass: "row m-1 p-2 bg-light rounded" }, [
                    _c("span", { staticStyle: { "margin-bottom": "5px" } }, [
                      _vm._v("Pagos divididos por producto")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "d-flex flex-wrap" },
                      _vm._l(_vm.splitProducts, function(payment, idx) {
                        return _c(
                          "div",
                          { key: idx, staticClass: "col-3 m-1" },
                          [
                            payment.products && payment.products.length > 0
                              ? _c("table", { staticClass: "col-12" }, [
                                  _c("thead", [
                                    _c(
                                      "tr",
                                      {
                                        class:
                                          "bg-primary text-white border rounded-top",
                                        attrs: { role: "button" },
                                        on: {
                                          click: function($event) {
                                            return _vm.selectAccount(idx)
                                          }
                                        }
                                      },
                                      [
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            attrs: { colspan: "3" }
                                          },
                                          [
                                            _c("b", [
                                              _vm._v(
                                                " CUENTA " +
                                                  _vm._s(idx + 1) +
                                                  " "
                                              )
                                            ])
                                          ]
                                        )
                                      ]
                                    )
                                  ]),
                                  _vm._v(" "),
                                  payment.products &&
                                  payment.products.length > 0
                                    ? _c(
                                        "tbody",
                                        { staticClass: "border rounded-top" },
                                        [
                                          _vm._l(payment.products, function(
                                            product,
                                            idx
                                          ) {
                                            return _c("tr", { key: idx }, [
                                              _c("td", [
                                                _c(
                                                  "h3",
                                                  {
                                                    staticClass:
                                                      "text-muted text-small"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(
                                                          product.quantity
                                                        ) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]),
                                              _vm._v(" "),
                                              _c("td", [
                                                _c(
                                                  "h3",
                                                  {
                                                    staticClass:
                                                      "text-muted text-small"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(
                                                          product.description
                                                        ) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]),
                                              _vm._v(" "),
                                              _c(
                                                "td",
                                                {
                                                  staticStyle: {
                                                    "text-align": "right"
                                                  }
                                                },
                                                [
                                                  _c(
                                                    "h3",
                                                    {
                                                      staticClass:
                                                        "text-muted text-small"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            product.price *
                                                              product.quantity
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  )
                                                ]
                                              )
                                            ])
                                          }),
                                          _vm._v(" "),
                                          _c("tr", [
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-muted text-small",
                                                staticStyle: {
                                                  "text-align": "right"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [_c("b", [_vm._v(" Total")])]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-muted text-small"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                        S/.\n                                        " +
                                                    _vm._s(
                                                      _vm.totalItemSelected(
                                                        payment.products
                                                      )
                                                    ) +
                                                    "\n                                    "
                                                )
                                              ]
                                            )
                                          ])
                                        ],
                                        2
                                      )
                                    : _c("tbody", { staticClass: "border" }, [
                                        _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              attrs: { colspan: "3" }
                                            },
                                            [
                                              _c(
                                                "h3",
                                                {
                                                  staticClass:
                                                    "text-muted text-small"
                                                },
                                                [
                                                  _vm._v(
                                                    "\n                                            Sin productos seleccionados\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      ])
                                ])
                              : _vm._e()
                          ]
                        )
                      }),
                      0
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c("div", { staticClass: "p-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "col-md-6 col-12 d-flex align-items-end" },
                    [
                      _c(
                        "div",
                        {
                          staticClass: "btn-group btn-group-square",
                          attrs: { role: "group" }
                        },
                        [
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-block btn-primary mr-3",
                              attrs: { disabled: _vm.button_payment },
                              on: { click: _vm.sendPayment }
                            },
                            [
                              _c("i", { staticClass: "fas fa-money-bill-alt" }),
                              _vm._v(
                                "\n                                PAGAR\n                            "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-block btn-dark",
                              on: {
                                click: function($event) {
                                  return _vm.back(false)
                                }
                              }
                            },
                            [
                              _c("i", { staticClass: "fa fa-reply" }),
                              _vm._v(" Cerrar\n                            ")
                            ]
                          )
                        ]
                      )
                    ]
                  )
                ])
              ])
            ]
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
    require("vue-hot-reload-api")      .rerender("data-v-89779052", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-89779052\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/components/payment_college.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-89779052\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/components/payment_college.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("305d4438", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-89779052\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./payment_college.vue", function() {
     var newContent = require("!!../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-89779052\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./payment_college.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=127.js.map