webpackJsonp([37,165],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/DataTable.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_moment__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_query_string__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }



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


/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    sellers: {
      type: Array,
      "default": function _default() {
        return [];
      }
    },
    resource: String,
    applyFilter: {
      type: Boolean,
      "default": true,
      required: false
    },
    fromAdmin: {
      type: Boolean,
      "default": false,
      required: false
    },
    config: Object
  },
  data: function data() {
    return {
      search: {
        column: null,
        value: null
      },
      columns: [],
      records: [],
      pagination: {},
      array_district: [],
      time: null
    };
  },
  computed: {},
  created: function created() {
    var _this = this;

    this.$eventHub.$on("reloadData", function () {
      _this.getRecords();
    });
  },
  mounted: function mounted() {
    var _this2 = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      var column_resource;
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              column_resource = _this2.resource; // _.split(this.resource, '/')

              _context.next = 3;
              return _this2.$http.get("/".concat(_this2.resource, "/columns")).then(function (response) {
                _this2.columns = response.data;
                _this2.search.column = _.head(Object.keys(_this2.columns));
              });

            case 3:
              _context.next = 5;
              return _this2.getRecords();

            case 5:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    clickDownload: function clickDownload() {
      this.$emit("clickReport", this.search);
    },
    customIndex: function customIndex(index) {
      return this.pagination.per_page * (this.pagination.current_page - 1) + index + 1;
    },
    getRecords: function getRecords() {
      var _this3 = this;

      if (this.time) {
        clearTimeout(this.time);
      } //   this.$http.get(`/filtrar_distritos/records`)
      // .then(response => {
      //     this.array_district = response.data.district
      // })


      this.time = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var url;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                url = "/".concat(_this3.resource, "/records?").concat(_this3.getQueryParameters());

                if (_this3.fromAdmin) {
                  url = "/".concat(_this3.resource, "/records?").concat(_this3.getQueryParameters(), "&fromAdmin=true");
                }

                return _context2.abrupt("return", _this3.$http.get(url).then(function (response) {
                  _this3.records = response.data.data;
                  _this3.pagination = response.data.meta;
                  _this3.pagination.per_page = parseInt(response.data.meta.per_page);
                }));

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      })), 350);
    },
    getQueryParameters: function getQueryParameters() {
      if (this.search.column == "date" && this.search.value && _typeof(this.search.value) == "object") {
        this.search.value = this.search.value.join(",");
      }

      return __WEBPACK_IMPORTED_MODULE_2_query_string___default.a.stringify({
        page: this.pagination.current_page,
        limit: this.limit,
        value: this.search.value,
        column: this.search.column,
        end_date: this.search.end_date
      });
    },
    changeClearInput: function changeClearInput() {
      this.search.value = "";
      this.getRecords();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/quotations/index.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__partials_options_vue__ = __webpack_require__("./resources/js/views/quotations/partials/options.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__partials_options_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__partials_options_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__partials_options_pdf_vue__ = __webpack_require__("./resources/js/views/quotations/partials/options_pdf.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__partials_options_pdf_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__partials_options_pdf_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_DataTable_vue__ = __webpack_require__("./resources/js/components/DataTable.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_DataTable_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__components_DataTable_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");


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




/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["typeUser", "soapCompany"],
  mixins: [__WEBPACK_IMPORTED_MODULE_4__mixins_deletable__["a" /* deletable */]],
  components: {
    DataTable: __WEBPACK_IMPORTED_MODULE_3__components_DataTable_vue___default.a,
    QuotationOptions: __WEBPACK_IMPORTED_MODULE_1__partials_options_vue___default.a,
    QuotationOptionsPdf: __WEBPACK_IMPORTED_MODULE_2__partials_options_pdf_vue___default.a
  },
  data: function data() {
    return {
      resource: "quotations",
      recordId: null,
      showDialogOptions: false,
      showDialogOptionsPdf: false,
      state_types: [],
      sellers: [],
      columns: {
        total_exportation: {
          title: "T.Exportación",
          visible: false
        },
        total_unaffected: {
          title: "T.Inafecto",
          visible: false
        },
        total_exonerated: {
          title: "T.Exonerado",
          visible: false
        },
        total_free: {
          title: "T.Gratuito",
          visible: false
        },
        contract: {
          title: "Contrato",
          visible: false
        },
        delivery_date: {
          title: "F.Entrega",
          visible: false
        }
      }
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
              return _this.filter();

            case 2:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    changeStateType: function changeStateType(row) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this2.updateStateType("/".concat(_this2.resource, "/state-type/").concat(row.state_type_id, "/").concat(row.id)).then(function () {
                  return _this2.$eventHub.$emit("reloadData");
                });

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    filter: function filter() {
      var _this3 = this;

      this.$http.get("/".concat(this.resource, "/filter")).then(function (response) {
        _this3.state_types = response.data.state_types;
        _this3.sellers = response.data.sellers;
      });
    },
    clickEdit: function clickEdit(id) {
      this.recordId = id;
      this.showDialogFormEdit = true;
    },
    clickOptions: function clickOptions() {
      var recordId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.recordId = recordId;
      this.showDialogOptions = true;
    },
    clickOptionsPdf: function clickOptionsPdf() {
      var recordId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.recordId = recordId;
      this.showDialogOptionsPdf = true;
    },
    clickAnulate: function clickAnulate(id) {
      var _this4 = this;

      this.anular("/".concat(this.resource, "/anular/").concat(id)).then(function () {
        return _this4.$eventHub.$emit("reloadData");
      });
    },
    duplicate: function duplicate(id) {
      var _this5 = this;

      this.$http.post("".concat(this.resource, "/duplicate"), {
        id: id
      }).then(function (response) {
        if (response.data.success) {
          _this5.$message.success("Se guardaron los cambios correctamente.");

          _this5.$eventHub.$emit("reloadData");
        } else {
          _this5.$message.error("No se guardaron los cambios");
        }
      })["catch"](function (error) {});
      this.$eventHub.$emit("reloadData");
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/quotations/partials/options.vue":
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
var DocumentOptions = function DocumentOptions() {
  return __webpack_require__.e/* import() */(169).then(__webpack_require__.bind(null, "./resources/js/views/documents/partials/options.vue"));
}; // import DocumentOptions from "../../documents/partials/options.vue";


var SaleNoteOptions = function SaleNoteOptions() {
  return __webpack_require__.e/* import() */(164).then(__webpack_require__.bind(null, "./resources/js/views/sale_notes/partials/options.vue"));
}; // import SaleNoteOptions from "../../sale_notes/partials/options.vue";


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    DocumentOptions: DocumentOptions,
    SaleNoteOptions: SaleNoteOptions
  },
  props: ["showDialog", "recordId", "showClose", "showGenerate", "type", "typeUser"],
  data: function data() {
    return {
      customer_email: "",
      titleDialog: null,
      loading: false,
      resource: "quotations",
      resource_documents: "documents",
      errors: {},
      form: {},
      document: {},
      document_types: [],
      all_document_types: [],
      all_series: [],
      series: [],
      customers: [],
      generate: false,
      loading_submit: false,
      showDialogDocumentOptions: false,
      showDialogSaleNoteOptions: false,
      documentNewId: null,
      is_document_type_invoice: true,
      payment_destinations: [],
      loading_search: false,
      payment_method_types: [],
      configuration: {}
    };
  },
  created: function created() {
    this.initForm();
    this.initDocument();
    this.clickAddPayment();
  },
  methods: {
    clickCancel: function clickCancel(index) {
      this.document.payments.splice(index, 1);
    },
    clickAddPayment: function clickAddPayment() {
      this.document.payments.push({
        id: null,
        document_id: null,
        date_of_payment: moment().format("YYYY-MM-DD"),
        payment_method_type_id: "01",
        payment_destination_id: "cash",
        reference: null,
        payment: 0
      });
    },
    initForm: function initForm() {
      this.generate = this.showGenerate ? true : false;
      this.errors = {};
      this.form = {
        id: null,
        external_id: null,
        identifier: null,
        date_of_issue: null,
        quotation: null
      };
    },
    getCustomer: function getCustomer() {
      var _this = this;

      this.$http.get("/".concat(this.resource_documents, "/search/customer/").concat(this.form.quotation.customer_id)).then(function (response) {
        _this.customers = response.data.customers;
        _this.document.customer_id = _this.form.quotation.customer_id;

        _this.changeCustomer();
      });
    },
    changeCustomer: function changeCustomer() {
      this.validateIdentityDocumentType();
    },
    searchRemoteCustomers: function searchRemoteCustomers(input) {
      var _this2 = this;

      if (input.length > 0) {
        this.loading_search = true;
        var parameters = "input=".concat(input, "&document_type_id=").concat(this.form.document_type_id, "&operation_type_id=").concat(this.form.operation_type_id);
        this.$http.get("/".concat(this.resource, "/search/customers?").concat(parameters)).then(function (response) {
          _this2.customers = response.data.customers;
          _this2.loading_search = false;
        });
      }
    },
    initDocument: function initDocument() {
      this.document = {
        document_type_id: null,
        series_id: null,
        establishment_id: null,
        number: "#",
        date_of_issue: moment().format("YYYY-MM-DD"),
        time_of_issue: null,
        customer_id: null,
        currency_type_id: null,
        purchase_order: null,
        exchange_rate_sale: 0,
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
        operation_type_id: null,
        date_of_due: moment().format("YYYY-MM-DD"),
        items: [],
        charges: [],
        discounts: [],
        attributes: [],
        guides: [],
        additional_information: null,
        actions: {
          format_pdf: "a4"
        },
        quotation_id: null,
        is_receivable: false,
        payments: [],
        hotel: {}
      };
    },
    changeDateOfIssue: function changeDateOfIssue() {
      this.document.date_of_due = this.document.date_of_issue;
    },
    resetDocument: function resetDocument() {
      this.generate = this.showGenerate ? true : false;
      this.initDocument();
      this.document.document_type_id = this.document_types.length > 0 ? this.document_types[0].id : null;
      this.changeDocumentType();
    },
    submit: function submit() {
      var _this3 = this;

      this.loading_submit = true;
      this.assignDocument();

      if (this.document.document_type_id === "nv") {
        this.document.prefix = "NV";
        this.resource_documents = "sale-notes";
      } else {
        this.document.prefix = null;
        this.resource_documents = "documents";
      }

      this.$http.post("/".concat(this.resource_documents), this.document).then(function (response) {
        if (response.data.success) {
          _this3.documentNewId = response.data.data.id;

          _this3.$http.get("/".concat(_this3.resource, "/changed/").concat(_this3.form.id)).then(function () {
            _this3.$eventHub.$emit("reloadData");
          }); // console.log(this.document.document_type_id)


          if (_this3.document.document_type_id === "nv") {
            _this3.showDialogSaleNoteOptions = true;
          } else {
            _this3.showDialogDocumentOptions = true;
          }

          _this3.$eventHub.$emit("reloadData");

          _this3.resetDocument();

          _this3.document.customer_id = _this3.form.quotation.customer_id;

          _this3.changeCustomer();

          _this3.clickClose();
        } else {
          _this3.$message.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this3.errors = error.response.data;
        } else {
          _this3.$message.error(error.response.data.message);
        }
      }).then(function () {
        _this3.loading_submit = false;
      });
    },
    assignDocument: function assignDocument() {
      var q = this.form.quotation;
      this.document.establishment_id = q.establishment_id; // this.document.date_of_issue = q.date_of_issue

      this.document.time_of_issue = moment().format("HH:mm:ss"); // this.document.customer_id = q.customer_id

      this.document.currency_type_id = q.currency_type_id;
      this.document.purchase_order = null;
      this.document.exchange_rate_sale = q.exchange_rate_sale;
      this.document.total_prepayment = q.total_prepayment;
      this.document.total_charge = q.total_charge;
      this.document.total_discount = q.total_discount;
      this.document.total_exportation = q.total_exportation;
      this.document.total_free = q.total_free;
      this.document.total_taxed = q.total_taxed;
      this.document.total_unaffected = q.total_unaffected;
      this.document.total_exonerated = q.total_exonerated;
      this.document.total_igv = q.total_igv;
      this.document.total_base_isc = q.total_base_isc;
      this.document.total_isc = q.total_isc;
      this.document.total_base_other_taxes = q.total_base_other_taxes;
      this.document.total_other_taxes = q.total_other_taxes;
      this.document.total_taxes = q.total_taxes;
      this.document.total_value = q.total_value;
      this.document.total = q.total;
      this.document.seller_id = q.seller_id;
      this.document.operation_type_id = "0101"; // this.document.date_of_due = q.date_of_issue

      this.document.items = q.items;
      this.document.charges = q.charges;
      this.document.discounts = q.discounts;
      this.document.attributes = []; // this.document.payments = q.payments;

      this.document.guides = q.guides;
      this.document.additional_information = null;
      this.document.actions = {
        format_pdf: "a4"
      };
      this.document.quotation_id = this.form.id;
    },
    create: function create() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this4.$http.get("/".concat(_this4.resource, "/option/tables")).then(function (response) {
                  _this4.all_document_types = response.data.document_types_invoice;
                  _this4.all_series = response.data.series;
                  _this4.payment_destinations = response.data.payment_destinations;
                  _this4.payment_method_types = response.data.payment_method_types; // this.document.document_type_id = (this.all_document_types.length > 0)?this.all_document_types[0].id:null
                  // this.changeDocumentType()
                });

              case 2:
                _context.next = 4;
                return _this4.$http.get("/".concat(_this4.resource, "/record2/").concat(_this4.recordId)).then(function (response) {
                  _this4.form = response.data.data;
                  _this4.document.payments = response.data.data.quotation.payments; // console.log(this.form)
                  // this.validateIdentityDocumentType()

                  // console.log(this.form)
                  // this.validateIdentityDocumentType()
                  _this4.getCustomer();

                  var type = _this4.type == "edit" ? "editada" : "registrada";
                  _this4.titleDialog = "Cotizaci\xF3n ".concat(type, ": ") + _this4.form.identifier;
                });

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    changeDocumentType: function changeDocumentType() {
      // this.filterSeries()
      this.document.is_receivable = false;
      this.series = [];
      this.filterSeries();
    },
    validateIdentityDocumentType: function validateIdentityDocumentType() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var identity_document_types, customer;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                identity_document_types = ["0", "1"]; // console.log(this.document)

                customer = _.find(_this5.customers, {
                  id: _this5.document.customer_id
                });

                if (identity_document_types.includes(customer.identity_document_type_id)) {
                  _this5.document_types = _.filter(_this5.all_document_types, {
                    id: "03"
                  });
                } else {
                  _this5.document_types = _this5.all_document_types;
                }

                _this5.document.document_type_id = _this5.document_types.length > 0 ? _this5.document_types[0].id : null;
                _context2.next = 6;
                return _this5.changeDocumentType();

              case 6:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    filterSeries: function filterSeries() {
      this.document.series_id = null;
      this.series = _.filter(this.all_series, {
        document_type_id: this.document.document_type_id
      });
      this.document.series_id = this.series.length > 0 ? this.series[0].id : null;
    },
    clickFinalize: function clickFinalize() {
      location.href = "/".concat(this.resource);
    },
    clickNewQuotation: function clickNewQuotation() {
      this.clickClose();
    },
    clickClose: function clickClose() {
      this.$emit("update:showDialog", false);
      this.initForm();
      this.resetDocument();
    },
    clickToPrint: function clickToPrint(format) {
      window.open("/".concat(this.resource, "/print/").concat(this.form.external_id, "/").concat(format), "_blank");
    },
    clickSendEmail: function clickSendEmail() {
      var _this6 = this;

      this.loading = true;
      this.$http.post("/".concat(this.resource, "/email"), {
        customer_email: this.customer_email,
        id: this.form.id,
        customer_id: this.form.quotation.customer_id
      }).then(function (response) {
        if (response.data.success) {
          _this6.$message.success("El correo fue enviado satisfactoriamente");
        } else {
          _this6.$message.error("Error al enviar el correo");
        }
      })["catch"](function (error) {
        _this6.$message.error("Error al enviar el correo");
      }).then(function () {
        _this6.loading = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/quotations/partials/options_pdf.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['showDialog', 'recordId', 'showClose'],
  data: function data() {
    return {
      titleDialog: null,
      resource: 'quotations',
      form: {},
      loading: false
    };
  },
  created: function created() {
    this.initForm();
  },
  methods: {
    initForm: function initForm() {
      this.form = {
        id: null,
        external_id: null
      };
    },
    create: function create() {
      var _this = this;

      this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
        _this.form = response.data.data;
        _this.titleDialog = "Cotizaci\xF3n registrada: ".concat(_this.form.identifier);
      });
    },
    clickClose: function clickClose() {
      this.$emit('update:showDialog', false);
      this.initForm();
    },
    clickToPrint: function clickToPrint(format) {
      window.open("/".concat(this.resource, "/print/").concat(this.form.external_id, "/").concat(format), '_blank');
    },
    clickDownload: function clickDownload(format) {
      window.open("/".concat(this.resource, "/download/").concat(this.form.external_id, "/").concat(format), '_blank');
    },
    clickSendEmail: function clickSendEmail() {
      var _this2 = this;

      this.loading = true;
      this.$http.post("/".concat(this.resource, "/email"), {
        customer_email: this.customer_email,
        id: this.form.id,
        customer_id: this.form.quotation.customer_id
      }).then(function (response) {
        if (response.data.success) {
          _this2.$message.success('El correo fue enviado satisfactoriamente');
        } else {
          _this2.$message.error('Error al enviar el correo');
        }
      })["catch"](function (error) {
        _this2.$message.error('Error al enviar el correo');
      }).then(function () {
        _this2.loading = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0816d5ae\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/quotations/index.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.anulate_color[data-v-0816d5ae] {\r\n    color: red;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/resources/js/views/quotations/resources/js/views/quotations/index.vue"],"names":[],"mappings":";AA4WA;IACA,WAAA;CACA","file":"index.vue","sourcesContent":["<template>\r\n    <div>\r\n        <div class=\"container-fluid p-l-0 p-r-0\">\r\n            <div class=\"page-header\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-sm-6\">\r\n                        <h6><span>Cotizaciones</span></h6>\r\n                        <ol class=\"breadcrumb\">\r\n                            <li class=\"breadcrumb-item\">\r\n                                <a href=\"/dashboard\">Dashboard</a>\r\n                            </li>\r\n                            <li class=\"breadcrumb-item active\">\r\n                                <span class=\"text-muted\">Cotizaciones</span>\r\n                            </li>\r\n                        </ol>\r\n                    </div>\r\n                    <div\r\n                        class=\"col-12 col-md-6 d-flex align-items-start justify-content-end\"\r\n                    >\r\n                        <a\r\n                            :href=\"`/${resource}/create`\"\r\n                            class=\"btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto\"\r\n                        >\r\n                            <i class=\"icofont-plus-circle\"></i>\r\n                            <span>Nuevo</span>\r\n                        </a>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <div class=\"container-fluid p-l-0 p-r-0\">\r\n            <div class=\"card mb-0\">\r\n                <div class=\"data-table-visible-columns\">\r\n                    <el-dropdown :hide-on-click=\"false\">\r\n                        <el-button type=\"primary\">\r\n                            Mostrar/Ocultar columnas<i\r\n                                class=\"el-icon-arrow-down el-icon--right\"\r\n                            ></i>\r\n                        </el-button>\r\n                        <el-dropdown-menu slot=\"dropdown\">\r\n                            <el-dropdown-item\r\n                                v-for=\"(column, index) in columns\"\r\n                                :key=\"index\"\r\n                            >\r\n                                <el-checkbox v-model=\"column.visible\">{{\r\n                                    column.title\r\n                                }}</el-checkbox>\r\n                            </el-dropdown-item>\r\n                        </el-dropdown-menu>\r\n                    </el-dropdown>\r\n                </div>\r\n                <div class=\"card-body\">\r\n                    <data-table :resource=\"resource\"\r\n                    :sellers=\"sellers\"\r\n                    >\r\n                        <tr slot=\"heading\">\r\n                            <th>#</th>\r\n                            <th class=\"text-end\">Acciones</th>\r\n                            <th class=\"text-center\">Fecha Emisión</th>\r\n                            <th\r\n                                class=\"text-center\"\r\n                                v-if=\"columns.delivery_date.visible\"\r\n                            >\r\n                                Fecha Entrega\r\n                            </th>\r\n                            <th>Vendedor</th>\r\n                            <th>Cliente</th>\r\n                            <th>Estado</th>\r\n                            <th>Cotización</th>\r\n                            <th>Comprobantes</th>\r\n                            <th>Nota de venta</th>\r\n                            <th>Oportunidad Venta</th>\r\n                            <th v-if=\"columns.contract.visible\">Contrato</th>\r\n                            <!-- <th>Estado</th> -->\r\n                            <th class=\"text-center\">Moneda</th>\r\n                            <th\r\n                                class=\"text-end\"\r\n                                v-if=\"columns.total_exportation.visible\"\r\n                            >\r\n                                T.Exportación\r\n                            </th>\r\n                            <th\r\n                                class=\"text-end\"\r\n                                v-if=\"columns.total_free.visible\"\r\n                            >\r\n                                T.Gratuito\r\n                            </th>\r\n                            <th\r\n                                class=\"text-end\"\r\n                                v-if=\"columns.total_unaffected.visible\"\r\n                            >\r\n                                T.Inafecta\r\n                            </th>\r\n                            <th\r\n                                class=\"text-end\"\r\n                                v-if=\"columns.total_exonerated.visible\"\r\n                            >\r\n                                T.Exonerado\r\n                            </th>\r\n                            <th class=\"text-end\">T.Gravado</th>\r\n                            <th class=\"text-end\">T.Igv</th>\r\n                            <th class=\"text-end\">Total</th>\r\n                            <th class=\"text-center\">PDF</th>\r\n                        </tr>\r\n\r\n                        <tr></tr>\r\n                        <tr\r\n                            slot-scope=\"{ index, row }\"\r\n                            :class=\"{\r\n                                anulate_color: row.state_type_id == '11'\r\n                            }\"\r\n                        >\r\n                            <td>{{ index }}</td>\r\n\r\n                            <td class=\"text-end\">\r\n                                <div class=\"d-flex flex-wrap\">\r\n                                      <button\r\n                            \r\n                                    v-if=\"\r\n                                        row.state_type_id != '11' &&\r\n                                            row.btn_generate &&\r\n                                            (typeUser == 'admin' ||\r\n                                                typeUser == 'superadmin') &&\r\n                                            soapCompany != '03'\r\n                                    \"\r\n                                    type=\"button\"\r\n                                    class=\"m-1 btn waves-effect waves-light btn-sm btn-info\"\r\n                                    @click.prevent=\"clickOptions(row.id)\"\r\n                                >\r\n                                    Generar comprobante\r\n                                </button>\r\n\r\n                                <a\r\n                                    v-if=\"\r\n                                        row.documents.length == 0 &&\r\n                                            row.state_type_id != '11'\r\n                                    \"\r\n                                    :href=\"`/${resource}/edit/${row.id}`\"\r\n                                    type=\"button\"\r\n                                    class=\"m-1 btn waves-effect waves-light  btn-sm btn-info\"\r\n                                    >Editar</a\r\n                                >\r\n                                <button\r\n                                    v-if=\"\r\n                                        row.documents.length == 0 &&\r\n                                            row.state_type_id != '11'\r\n                                    \"\r\n                                    type=\"button\"\r\n                                    class=\"m-1 btn waves-effect waves-light btn-sm btn-danger\"\r\n                                    @click.prevent=\"clickAnulate(row.id)\"\r\n                                >\r\n                                    Anular\r\n                                </button>\r\n                                <button\r\n                                    @click=\"duplicate(row.id)\"\r\n                                    type=\"button\"\r\n                                    class=\"m-1 btn waves-effect waves-light btn-sm btn-info\"\r\n                                >\r\n                                    Duplicar\r\n                                </button>\r\n                                <a\r\n                                    v-if=\"\r\n                                        row.btn_generate_cnt &&\r\n                                            row.state_type_id != '11'\r\n                                    \"\r\n                                    :href=\"\r\n                                        `/contracts/generate-quotation/${row.id}`\r\n                                    \"\r\n                                    class=\"m-1 btn waves-effect waves-light btn-sm btn-primary m-1__2\"\r\n                                    >Generar contrato</a\r\n                                >\r\n                                </div>\r\n                            </td>\r\n                            <td class=\"text-center\">{{ row.date_of_issue }}</td>\r\n                            <td\r\n                                class=\"text-center\"\r\n                                v-if=\"columns.delivery_date.visible\"\r\n                            >\r\n                                {{ row.delivery_date }}\r\n                            </td>\r\n                            <td>{{ row.user_name }}</td>\r\n                            <td>\r\n                                {{ row.customer_name }}<br /><small\r\n                                    v-text=\"row.customer_number\"\r\n                                ></small>\r\n                            </td>\r\n                            <td>\r\n                                <template v-if=\"row.state_type_id == '11'\">\r\n                                    {{ row.state_type_description }}\r\n                                </template>\r\n                                <template v-else>\r\n                                    <el-select\r\n                                        v-model=\"row.state_type_id\"\r\n                                        @change=\"changeStateType(row)\"\r\n                                        style=\"width:120px !important\"\r\n                                    >\r\n                                        <el-option\r\n                                            v-for=\"option in state_types\"\r\n                                            :key=\"option.id\"\r\n                                            :value=\"option.id\"\r\n                                            :label=\"option.description\"\r\n                                        ></el-option>\r\n                                    </el-select>\r\n                                </template>\r\n                            </td>\r\n                            <td>{{ row.identifier }}</td>\r\n                            <td>\r\n                                <template\r\n                                    v-for=\"(document, i) in row.documents\"\r\n                                >\r\n                                    <label\r\n                                        :key=\"i\"\r\n                                        v-text=\"document.number_full\"\r\n                                        class=\"d-block\"\r\n                                    ></label>\r\n                                </template>\r\n                            </td>\r\n                            <td>\r\n                                <template\r\n                                    v-for=\"(sale_note, i) in row.sale_notes\"\r\n                                >\r\n                                    <label\r\n                                        :key=\"i\"\r\n                                        v-text=\"sale_note.identifier\"\r\n                                        class=\"d-block\"\r\n                                    ></label>\r\n                                </template>\r\n                            </td>\r\n                            <td>\r\n                                <!-- {{ row.sale_opportunity_number_full }} -->\r\n\r\n                                <el-popover\r\n                                    placement=\"right\"\r\n                                    v-if=\"row.sale_opportunity\"\r\n                                    width=\"400\"\r\n                                    trigger=\"click\"\r\n                                >\r\n                                    <div class=\"col-md-12 mt-4\">\r\n                                        <table>\r\n                                            <tr>\r\n                                                <td>\r\n                                                    <strong>O. Venta: </strong>\r\n                                                </td>\r\n                                                <td>\r\n                                                    <strong>{{\r\n                                                        row.sale_opportunity_number_full\r\n                                                    }}</strong>\r\n                                                </td>\r\n                                            </tr>\r\n                                            <tr class=\"mt-4 mb-4\">\r\n                                                <td>\r\n                                                    <strong>F. Emisión:</strong>\r\n                                                </td>\r\n                                                <td>\r\n                                                    <strong>{{\r\n                                                        row.date_of_issue\r\n                                                    }}</strong>\r\n                                                </td>\r\n                                            </tr>\r\n                                        </table>\r\n\r\n                                        <div class=\"table-responsive mt-4\">\r\n                                            <table class=\"table\">\r\n                                                <thead>\r\n                                                    <tr>\r\n                                                        <th>#</th>\r\n                                                        <th>Descripción</th>\r\n                                                        <th>Cantidad</th>\r\n                                                        <th>Total</th>\r\n                                                    </tr>\r\n                                                </thead>\r\n                                                <tbody>\r\n                                                    <tr\r\n                                                        v-for=\"(row,\r\n                                                        index) in row\r\n                                                            .sale_opportunity\r\n                                                            .items\"\r\n                                                        :key=\"index\"\r\n                                                    >\r\n                                                        <td>{{ index + 1 }}</td>\r\n                                                        <td>\r\n                                                            {{\r\n                                                                row.item\r\n                                                                    .description\r\n                                                            }}\r\n                                                        </td>\r\n                                                        <td>\r\n                                                            {{ row.quantity }}\r\n                                                        </td>\r\n                                                        <td>{{ row.total }}</td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                        </div>\r\n                                    </div>\r\n                                    <el-button slot=\"reference\">\r\n                                        <i class=\"fa fa-eye\"></i\r\n                                    ></el-button>\r\n                                </el-popover>\r\n                            </td>\r\n                            <!-- <td>{{ row.state_type_description }}</td> -->\r\n                            <td v-if=\"columns.contract.visible\">\r\n                                {{ row.contract_number_full }}\r\n                            </td>\r\n                            <td class=\"text-center\">\r\n                                {{ row.currency_type_id }}\r\n                            </td>\r\n                            <td\r\n                                class=\"text-end\"\r\n                                v-if=\"columns.total_exportation.visible\"\r\n                            >\r\n                                {{ row.total_exportation }}\r\n                            </td>\r\n                            <td\r\n                                class=\"text-end\"\r\n                                v-if=\"columns.total_free.visible\"\r\n                            >\r\n                                {{ row.total_free }}\r\n                            </td>\r\n                            <td\r\n                                class=\"text-end\"\r\n                                v-if=\"columns.total_unaffected.visible\"\r\n                            >\r\n                                {{ row.total_unaffected }}\r\n                            </td>\r\n                            <td\r\n                                class=\"text-end\"\r\n                                v-if=\"columns.total_exonerated.visible\"\r\n                            >\r\n                                {{ row.total_exonerated }}\r\n                            </td>\r\n                            <td class=\"text-end\">{{ row.total_taxed }}</td>\r\n                            <td class=\"text-end\">{{ row.total_igv }}</td>\r\n                            <td class=\"text-end\">{{ row.total }}</td>\r\n                            <td class=\"text-end\">\r\n                                <button\r\n                                    type=\"button\"\r\n                                    class=\"btn waves-effect waves-light btn-xs btn-info\"\r\n                                    @click.prevent=\"clickOptionsPdf(row.id)\"\r\n                                >\r\n                                    PDF\r\n                                </button>\r\n                            </td>\r\n                        </tr>\r\n                    </data-table>\r\n                </div>\r\n\r\n                <quotation-options\r\n                    :showDialog.sync=\"showDialogOptions\"\r\n                    :recordId=\"recordId\"\r\n                    :showGenerate=\"true\"\r\n                    :showClose=\"true\"\r\n                ></quotation-options>\r\n\r\n                <quotation-options-pdf\r\n                    :showDialog.sync=\"showDialogOptionsPdf\"\r\n                    :recordId=\"recordId\"\r\n                    :showClose=\"true\"\r\n                ></quotation-options-pdf>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</template>\r\n<style scoped>\r\n.anulate_color {\r\n    color: red;\r\n}\r\n</style>\r\n<script>\r\nimport QuotationOptions from \"./partials/options.vue\";\r\nimport QuotationOptionsPdf from \"./partials/options_pdf.vue\";\r\nimport DataTable from \"../../components/DataTable.vue\";\r\nimport { deletable } from \"../../mixins/deletable\";\r\n\r\nexport default {\r\n    props: [\"typeUser\", \"soapCompany\"],\r\n    mixins: [deletable],\r\n    components: { DataTable, QuotationOptions, QuotationOptionsPdf },\r\n    data() {\r\n        return {\r\n            resource: \"quotations\",\r\n            recordId: null,\r\n            showDialogOptions: false,\r\n            showDialogOptionsPdf: false,\r\n            state_types: [],\r\n            sellers:[],\r\n            columns: {\r\n                total_exportation: {\r\n                    title: \"T.Exportación\",\r\n                    visible: false\r\n                },\r\n                total_unaffected: {\r\n                    title: \"T.Inafecto\",\r\n                    visible: false\r\n                },\r\n                total_exonerated: {\r\n                    title: \"T.Exonerado\",\r\n                    visible: false\r\n                },\r\n                total_free: {\r\n                    title: \"T.Gratuito\",\r\n                    visible: false\r\n                },\r\n                contract: {\r\n                    title: \"Contrato\",\r\n                    visible: false\r\n                },\r\n                delivery_date: {\r\n                    title: \"F.Entrega\",\r\n                    visible: false\r\n                }\r\n            }\r\n        };\r\n    },\r\n    async created() {\r\n        await this.filter();\r\n    },\r\n    methods: {\r\n        async changeStateType(row) {\r\n            await this.updateStateType(\r\n                `/${this.resource}/state-type/${row.state_type_id}/${row.id}`\r\n            ).then(() => this.$eventHub.$emit(\"reloadData\"));\r\n        },\r\n        filter() {\r\n            this.$http.get(`/${this.resource}/filter`).then(response => {\r\n                this.state_types = response.data.state_types;\r\n                this.sellers = response.data.sellers;\r\n            });\r\n        },\r\n        clickEdit(id) {\r\n            this.recordId = id;\r\n            this.showDialogFormEdit = true;\r\n        },\r\n        clickOptions(recordId = null) {\r\n            this.recordId = recordId;\r\n            this.showDialogOptions = true;\r\n        },\r\n        clickOptionsPdf(recordId = null) {\r\n            this.recordId = recordId;\r\n            this.showDialogOptionsPdf = true;\r\n        },\r\n        clickAnulate(id) {\r\n            this.anular(`/${this.resource}/anular/${id}`).then(() =>\r\n                this.$eventHub.$emit(\"reloadData\")\r\n            );\r\n        },\r\n        duplicate(id) {\r\n            this.$http\r\n                .post(`${this.resource}/duplicate`, { id })\r\n                .then(response => {\r\n                    if (response.data.success) {\r\n                        this.$message.success(\r\n                            \"Se guardaron los cambios correctamente.\"\r\n                        );\r\n                        this.$eventHub.$emit(\"reloadData\");\r\n                    } else {\r\n                        this.$message.error(\"No se guardaron los cambios\");\r\n                    }\r\n                })\r\n                .catch(error => {});\r\n            this.$eventHub.$emit(\"reloadData\");\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0816d5ae\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/quotations/index.vue":
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
          _c(
            "div",
            {
              staticClass:
                "col-12 col-md-6 d-flex align-items-start justify-content-end"
            },
            [
              _c(
                "a",
                {
                  staticClass:
                    "btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto",
                  attrs: { href: "/" + _vm.resource + "/create" }
                },
                [
                  _c("i", { staticClass: "icofont-plus-circle" }),
                  _vm._v(" "),
                  _c("span", [_vm._v("Nuevo")])
                ]
              )
            ]
          )
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
      _c(
        "div",
        { staticClass: "card mb-0" },
        [
          _c(
            "div",
            { staticClass: "data-table-visible-columns" },
            [
              _c(
                "el-dropdown",
                { attrs: { "hide-on-click": false } },
                [
                  _c("el-button", { attrs: { type: "primary" } }, [
                    _vm._v(
                      "\n                        Mostrar/Ocultar columnas"
                    ),
                    _c("i", {
                      staticClass: "el-icon-arrow-down el-icon--right"
                    })
                  ]),
                  _vm._v(" "),
                  _c(
                    "el-dropdown-menu",
                    { attrs: { slot: "dropdown" }, slot: "dropdown" },
                    _vm._l(_vm.columns, function(column, index) {
                      return _c(
                        "el-dropdown-item",
                        { key: index },
                        [
                          _c(
                            "el-checkbox",
                            {
                              model: {
                                value: column.visible,
                                callback: function($$v) {
                                  _vm.$set(column, "visible", $$v)
                                },
                                expression: "column.visible"
                              }
                            },
                            [_vm._v(_vm._s(column.title))]
                          )
                        ],
                        1
                      )
                    }),
                    1
                  )
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "card-body" },
            [
              _c(
                "data-table",
                {
                  attrs: { resource: _vm.resource, sellers: _vm.sellers },
                  scopedSlots: _vm._u([
                    {
                      key: "default",
                      fn: function(ref) {
                        var index = ref.index
                        var row = ref.row
                        return _c(
                          "tr",
                          {
                            class: {
                              anulate_color: row.state_type_id == "11"
                            }
                          },
                          [
                            _c("td", [_vm._v(_vm._s(index))]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-end" }, [
                              _c("div", { staticClass: "d-flex flex-wrap" }, [
                                row.state_type_id != "11" &&
                                row.btn_generate &&
                                (_vm.typeUser == "admin" ||
                                  _vm.typeUser == "superadmin") &&
                                _vm.soapCompany != "03"
                                  ? _c(
                                      "button",
                                      {
                                        staticClass:
                                          "m-1 btn waves-effect waves-light btn-sm btn-info",
                                        attrs: { type: "button" },
                                        on: {
                                          click: function($event) {
                                            $event.preventDefault()
                                            return _vm.clickOptions(row.id)
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                Generar comprobante\n                            "
                                        )
                                      ]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                row.documents.length == 0 &&
                                row.state_type_id != "11"
                                  ? _c(
                                      "a",
                                      {
                                        staticClass:
                                          "m-1 btn waves-effect waves-light  btn-sm btn-info",
                                        attrs: {
                                          href:
                                            "/" +
                                            _vm.resource +
                                            "/edit/" +
                                            row.id,
                                          type: "button"
                                        }
                                      },
                                      [_vm._v("Editar")]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                row.documents.length == 0 &&
                                row.state_type_id != "11"
                                  ? _c(
                                      "button",
                                      {
                                        staticClass:
                                          "m-1 btn waves-effect waves-light btn-sm btn-danger",
                                        attrs: { type: "button" },
                                        on: {
                                          click: function($event) {
                                            $event.preventDefault()
                                            return _vm.clickAnulate(row.id)
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                Anular\n                            "
                                        )
                                      ]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                _c(
                                  "button",
                                  {
                                    staticClass:
                                      "m-1 btn waves-effect waves-light btn-sm btn-info",
                                    attrs: { type: "button" },
                                    on: {
                                      click: function($event) {
                                        return _vm.duplicate(row.id)
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                Duplicar\n                            "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                row.btn_generate_cnt &&
                                row.state_type_id != "11"
                                  ? _c(
                                      "a",
                                      {
                                        staticClass:
                                          "m-1 btn waves-effect waves-light btn-sm btn-primary m-1__2",
                                        attrs: {
                                          href:
                                            "/contracts/generate-quotation/" +
                                            row.id
                                        }
                                      },
                                      [_vm._v("Generar contrato")]
                                    )
                                  : _vm._e()
                              ])
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-center" }, [
                              _vm._v(_vm._s(row.date_of_issue))
                            ]),
                            _vm._v(" "),
                            _vm.columns.delivery_date.visible
                              ? _c("td", { staticClass: "text-center" }, [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(row.delivery_date) +
                                      "\n                        "
                                  )
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(row.user_name))]),
                            _vm._v(" "),
                            _c("td", [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(row.customer_name)
                              ),
                              _c("br"),
                              _c("small", {
                                domProps: {
                                  textContent: _vm._s(row.customer_number)
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c(
                              "td",
                              [
                                row.state_type_id == "11"
                                  ? [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(row.state_type_description) +
                                          "\n                            "
                                      )
                                    ]
                                  : [
                                      _c(
                                        "el-select",
                                        {
                                          staticStyle: {
                                            width: "120px !important"
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.changeStateType(row)
                                            }
                                          },
                                          model: {
                                            value: row.state_type_id,
                                            callback: function($$v) {
                                              _vm.$set(
                                                row,
                                                "state_type_id",
                                                $$v
                                              )
                                            },
                                            expression: "row.state_type_id"
                                          }
                                        },
                                        _vm._l(_vm.state_types, function(
                                          option
                                        ) {
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
                                    ]
                              ],
                              2
                            ),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(row.identifier))]),
                            _vm._v(" "),
                            _c(
                              "td",
                              [
                                _vm._l(row.documents, function(document, i) {
                                  return [
                                    _c("label", {
                                      key: i,
                                      staticClass: "d-block",
                                      domProps: {
                                        textContent: _vm._s(
                                          document.number_full
                                        )
                                      }
                                    })
                                  ]
                                })
                              ],
                              2
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              [
                                _vm._l(row.sale_notes, function(sale_note, i) {
                                  return [
                                    _c("label", {
                                      key: i,
                                      staticClass: "d-block",
                                      domProps: {
                                        textContent: _vm._s(
                                          sale_note.identifier
                                        )
                                      }
                                    })
                                  ]
                                })
                              ],
                              2
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              [
                                row.sale_opportunity
                                  ? _c(
                                      "el-popover",
                                      {
                                        attrs: {
                                          placement: "right",
                                          width: "400",
                                          trigger: "click"
                                        }
                                      },
                                      [
                                        _c(
                                          "div",
                                          { staticClass: "col-md-12 mt-4" },
                                          [
                                            _c("table", [
                                              _c("tr", [
                                                _c("td", [
                                                  _c("strong", [
                                                    _vm._v("O. Venta: ")
                                                  ])
                                                ]),
                                                _vm._v(" "),
                                                _c("td", [
                                                  _c("strong", [
                                                    _vm._v(
                                                      _vm._s(
                                                        row.sale_opportunity_number_full
                                                      )
                                                    )
                                                  ])
                                                ])
                                              ]),
                                              _vm._v(" "),
                                              _c(
                                                "tr",
                                                { staticClass: "mt-4 mb-4" },
                                                [
                                                  _c("td", [
                                                    _c("strong", [
                                                      _vm._v("F. Emisión:")
                                                    ])
                                                  ]),
                                                  _vm._v(" "),
                                                  _c("td", [
                                                    _c("strong", [
                                                      _vm._v(
                                                        _vm._s(
                                                          row.date_of_issue
                                                        )
                                                      )
                                                    ])
                                                  ])
                                                ]
                                              )
                                            ]),
                                            _vm._v(" "),
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "table-responsive mt-4"
                                              },
                                              [
                                                _c(
                                                  "table",
                                                  { staticClass: "table" },
                                                  [
                                                    _c("thead", [
                                                      _c("tr", [
                                                        _c("th", [_vm._v("#")]),
                                                        _vm._v(" "),
                                                        _c("th", [
                                                          _vm._v("Descripción")
                                                        ]),
                                                        _vm._v(" "),
                                                        _c("th", [
                                                          _vm._v("Cantidad")
                                                        ]),
                                                        _vm._v(" "),
                                                        _c("th", [
                                                          _vm._v("Total")
                                                        ])
                                                      ])
                                                    ]),
                                                    _vm._v(" "),
                                                    _c(
                                                      "tbody",
                                                      _vm._l(
                                                        row.sale_opportunity
                                                          .items,
                                                        function(row, index) {
                                                          return _c(
                                                            "tr",
                                                            { key: index },
                                                            [
                                                              _c("td", [
                                                                _vm._v(
                                                                  _vm._s(
                                                                    index + 1
                                                                  )
                                                                )
                                                              ]),
                                                              _vm._v(" "),
                                                              _c("td", [
                                                                _vm._v(
                                                                  "\n                                                        " +
                                                                    _vm._s(
                                                                      row.item
                                                                        .description
                                                                    ) +
                                                                    "\n                                                    "
                                                                )
                                                              ]),
                                                              _vm._v(" "),
                                                              _c("td", [
                                                                _vm._v(
                                                                  "\n                                                        " +
                                                                    _vm._s(
                                                                      row.quantity
                                                                    ) +
                                                                    "\n                                                    "
                                                                )
                                                              ]),
                                                              _vm._v(" "),
                                                              _c("td", [
                                                                _vm._v(
                                                                  _vm._s(
                                                                    row.total
                                                                  )
                                                                )
                                                              ])
                                                            ]
                                                          )
                                                        }
                                                      ),
                                                      0
                                                    )
                                                  ]
                                                )
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "el-button",
                                          {
                                            attrs: { slot: "reference" },
                                            slot: "reference"
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-eye"
                                            })
                                          ]
                                        )
                                      ],
                                      1
                                    )
                                  : _vm._e()
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _vm.columns.contract.visible
                              ? _c("td", [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(row.contract_number_full) +
                                      "\n                        "
                                  )
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-center" }, [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(row.currency_type_id) +
                                  "\n                        "
                              )
                            ]),
                            _vm._v(" "),
                            _vm.columns.total_exportation.visible
                              ? _c("td", { staticClass: "text-end" }, [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(row.total_exportation) +
                                      "\n                        "
                                  )
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.columns.total_free.visible
                              ? _c("td", { staticClass: "text-end" }, [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(row.total_free) +
                                      "\n                        "
                                  )
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.columns.total_unaffected.visible
                              ? _c("td", { staticClass: "text-end" }, [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(row.total_unaffected) +
                                      "\n                        "
                                  )
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.columns.total_exonerated.visible
                              ? _c("td", { staticClass: "text-end" }, [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(row.total_exonerated) +
                                      "\n                        "
                                  )
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-end" }, [
                              _vm._v(_vm._s(row.total_taxed))
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-end" }, [
                              _vm._v(_vm._s(row.total_igv))
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-end" }, [
                              _vm._v(_vm._s(row.total))
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-end" }, [
                              _c(
                                "button",
                                {
                                  staticClass:
                                    "btn waves-effect waves-light btn-xs btn-info",
                                  attrs: { type: "button" },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.clickOptionsPdf(row.id)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                                PDF\n                            "
                                  )
                                ]
                              )
                            ])
                          ]
                        )
                      }
                    }
                  ])
                },
                [
                  _c("tr", { attrs: { slot: "heading" }, slot: "heading" }, [
                    _c("th", [_vm._v("#")]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-end" }, [_vm._v("Acciones")]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-center" }, [
                      _vm._v("Fecha Emisión")
                    ]),
                    _vm._v(" "),
                    _vm.columns.delivery_date.visible
                      ? _c("th", { staticClass: "text-center" }, [
                          _vm._v(
                            "\n                            Fecha Entrega\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _c("th", [_vm._v("Vendedor")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Cliente")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Estado")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Cotización")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Comprobantes")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Nota de venta")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Oportunidad Venta")]),
                    _vm._v(" "),
                    _vm.columns.contract.visible
                      ? _c("th", [_vm._v("Contrato")])
                      : _vm._e(),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-center" }, [
                      _vm._v("Moneda")
                    ]),
                    _vm._v(" "),
                    _vm.columns.total_exportation.visible
                      ? _c("th", { staticClass: "text-end" }, [
                          _vm._v(
                            "\n                            T.Exportación\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.columns.total_free.visible
                      ? _c("th", { staticClass: "text-end" }, [
                          _vm._v(
                            "\n                            T.Gratuito\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.columns.total_unaffected.visible
                      ? _c("th", { staticClass: "text-end" }, [
                          _vm._v(
                            "\n                            T.Inafecta\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.columns.total_exonerated.visible
                      ? _c("th", { staticClass: "text-end" }, [
                          _vm._v(
                            "\n                            T.Exonerado\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-end" }, [
                      _vm._v("T.Gravado")
                    ]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-end" }, [_vm._v("T.Igv")]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-end" }, [_vm._v("Total")]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-center" }, [_vm._v("PDF")])
                  ]),
                  _vm._v(" "),
                  _c("tr")
                ]
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("quotation-options", {
            attrs: {
              showDialog: _vm.showDialogOptions,
              recordId: _vm.recordId,
              showGenerate: true,
              showClose: true
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogOptions = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogOptions = $event
              }
            }
          }),
          _vm._v(" "),
          _c("quotation-options-pdf", {
            attrs: {
              showDialog: _vm.showDialogOptionsPdf,
              recordId: _vm.recordId,
              showClose: true
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogOptionsPdf = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogOptionsPdf = $event
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
      _c("h6", [_c("span", [_vm._v("Cotizaciones")])]),
      _vm._v(" "),
      _c("ol", { staticClass: "breadcrumb" }, [
        _c("li", { staticClass: "breadcrumb-item" }, [
          _c("a", { attrs: { href: "/dashboard" } }, [_vm._v("Dashboard")])
        ]),
        _vm._v(" "),
        _c("li", { staticClass: "breadcrumb-item active" }, [
          _c("span", { staticClass: "text-muted" }, [_vm._v("Cotizaciones")])
        ])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0816d5ae", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0d92229a\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/quotations/partials/options.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "el-dialog",
        {
          attrs: {
            "append-to-body": "",
            title: _vm.titleDialog,
            visible: _vm.showDialog,
            width: "650px",
            "close-on-click-modal": false,
            "close-on-press-escape": false,
            "show-close": false
          },
          on: { open: _vm.create, close: _vm.clickClose }
        },
        [
          _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: !_vm.showGenerate,
                  expression: "!showGenerate"
                }
              ],
              staticClass: "row"
            },
            [
              _c(
                "div",
                {
                  staticClass:
                    "col-lg-4 col-md-4 col-sm-4 text-center font-weight-bold"
                },
                [
                  _c("p", [_vm._v("Imprimir A4")]),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass:
                        "btn btn-lg btn-info waves-effect waves-light",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          return _vm.clickToPrint("a4")
                        }
                      }
                    },
                    [_c("i", { staticClass: "fa fa-file-alt" })]
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "col-lg-4 col-md-4 col-sm-4 text-center font-weight-bold"
                },
                [
                  _c("p", [_vm._v("Imprimir A5")]),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass:
                        "btn btn-lg btn-info waves-effect waves-light",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          return _vm.clickToPrint("a5")
                        }
                      }
                    },
                    [_c("i", { staticClass: "fa fa-file-alt" })]
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "col-lg-4 col-md-4 col-sm-4 text-center font-weight-bold"
                },
                [
                  _c("p", [_vm._v("Imprimir Ticket")]),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass:
                        "btn btn-lg btn-info waves-effect waves-light",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          return _vm.clickToPrint("ticket")
                        }
                      }
                    },
                    [_c("i", { staticClass: "fa fa-receipt" })]
                  )
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c("br"),
          _vm._v(" "),
          _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: !_vm.showGenerate,
                  expression: "!showGenerate"
                }
              ],
              staticClass: "row"
            },
            [
              _c(
                "div",
                { staticClass: "col-md-12" },
                [
                  _c(
                    "el-input",
                    {
                      model: {
                        value: _vm.customer_email,
                        callback: function($$v) {
                          _vm.customer_email = $$v
                        },
                        expression: "customer_email"
                      }
                    },
                    [
                      _c(
                        "el-button",
                        {
                          attrs: {
                            slot: "append",
                            icon: "el-icon-message",
                            loading: _vm.loading
                          },
                          on: { click: _vm.clickSendEmail },
                          slot: "append"
                        },
                        [_vm._v("Enviar")]
                      ),
                      _vm._v(" "),
                      _c("i", {
                        staticClass: "el-icon-edit-outline",
                        attrs: { slot: "prefix" },
                        slot: "prefix"
                      })
                    ],
                    1
                  )
                ],
                1
              )
            ]
          ),
          _vm._v(" "),
          _c("br"),
          _vm._v(" "),
          _vm.typeUser == "admin"
            ? _c("div", { staticClass: "row" }, [
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: !_vm.showGenerate,
                        expression: "!showGenerate"
                      }
                    ],
                    staticClass: "col-md-9"
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "form-group" },
                      [
                        _c(
                          "el-checkbox",
                          {
                            model: {
                              value: _vm.generate,
                              callback: function($$v) {
                                _vm.generate = $$v
                              },
                              expression: "generate"
                            }
                          },
                          [_vm._v("Generar comprobante electrónico")]
                        )
                      ],
                      1
                    )
                  ]
                )
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.generate
            ? _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-lg-12 pb-2" }, [
                  _c(
                    "div",
                    { staticClass: "form-group" },
                    [
                      _c(
                        "label",
                        {
                          staticClass:
                            "control-label font-weight-bold text-primary"
                        },
                        [
                          _vm._v(
                            "\n                        Cliente\n                        "
                          )
                        ]
                      ),
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
                          on: { change: _vm.changeCustomer },
                          model: {
                            value: _vm.document.customer_id,
                            callback: function($$v) {
                              _vm.$set(_vm.document, "customer_id", $$v)
                            },
                            expression: "document.customer_id"
                          }
                        },
                        _vm._l(_vm.customers, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.customer_id
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(_vm.errors.customer_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-8" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.document_type_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Tipo comprobante")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          staticClass: "border-left rounded-left border-info",
                          attrs: {
                            "popper-class": "el-select-document_type",
                            dusk: "document_type_id"
                          },
                          on: { change: _vm.changeDocumentType },
                          model: {
                            value: _vm.document.document_type_id,
                            callback: function($$v) {
                              _vm.$set(_vm.document, "document_type_id", $$v)
                            },
                            expression: "document.document_type_id"
                          }
                        },
                        [
                          _vm._l(_vm.document_types, function(option) {
                            return _c("el-option", {
                              key: option.id,
                              attrs: {
                                value: option.id,
                                label: option.description
                              }
                            })
                          }),
                          _vm._v(" "),
                          _c("el-option", {
                            key: "nv",
                            attrs: { value: "80", label: "NOTA DE VENTA" }
                          })
                        ],
                        2
                      ),
                      _vm._v(" "),
                      _vm.errors.document_type_id
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(
                                _vm.errors.document_type_id[0]
                              )
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.series_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Serie")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          model: {
                            value: _vm.document.series_id,
                            callback: function($$v) {
                              _vm.$set(_vm.document, "series_id", $$v)
                            },
                            expression: "document.series_id"
                          }
                        },
                        _vm._l(_vm.series, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: { value: option.id, label: option.number }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.series_id
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(_vm.errors.series_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-6" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.date_of_issue }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Fecha de emisión")
                      ]),
                      _vm._v(" "),
                      _c("el-date-picker", {
                        attrs: {
                          readonly: "",
                          type: "date",
                          "value-format": "yyyy-MM-dd",
                          clearable: false
                        },
                        on: { change: _vm.changeDateOfIssue },
                        model: {
                          value: _vm.document.date_of_issue,
                          callback: function($$v) {
                            _vm.$set(_vm.document, "date_of_issue", $$v)
                          },
                          expression: "document.date_of_issue"
                        }
                      }),
                      _vm._v(" "),
                      _vm.errors.date_of_issue
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(_vm.errors.date_of_issue[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-6" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.date_of_issue }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Fecha de vencimiento")
                      ]),
                      _vm._v(" "),
                      _c("el-date-picker", {
                        attrs: {
                          type: "date",
                          "value-format": "yyyy-MM-dd",
                          clearable: false
                        },
                        model: {
                          value: _vm.document.date_of_due,
                          callback: function($$v) {
                            _vm.$set(_vm.document, "date_of_due", $$v)
                          },
                          expression: "document.date_of_due"
                        }
                      }),
                      _vm._v(" "),
                      _vm.errors.date_of_due
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(_vm.errors.date_of_due[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("br"),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-4" }, [
                  _c(
                    "div",
                    {
                      directives: [
                        {
                          name: "show",
                          rawName: "v-show",
                          value: _vm.document.document_type_id == "03",
                          expression: "document.document_type_id == '03'"
                        }
                      ],
                      staticClass: "form-group"
                    },
                    [
                      _c(
                        "el-checkbox",
                        {
                          staticClass: "font-weight-bold",
                          model: {
                            value: _vm.document.is_receivable,
                            callback: function($$v) {
                              _vm.$set(_vm.document, "is_receivable", $$v)
                            },
                            expression: "document.is_receivable"
                          }
                        },
                        [_vm._v("¿Es venta por cobrar?")]
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("br"),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.is_document_type_invoice,
                        expression: "is_document_type_invoice"
                      }
                    ],
                    staticClass: "col-lg-12"
                  },
                  [
                    _c("table", [
                      _c("thead", [
                        _c("tr", { attrs: { width: "100%" } }, [
                          _vm.document.payments.length > 0
                            ? _c("th", [
                                _vm._v(
                                  "\n                                M.Pago\n                            "
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.document.payments.length > 0
                            ? _c("th", [
                                _vm._v(
                                  "\n                                Destino\n                            "
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.document.payments.length > 0
                            ? _c("th", [
                                _vm._v(
                                  "\n                                Referencia\n                            "
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.document.payments.length > 0
                            ? _c("th", [
                                _vm._v(
                                  "\n                                Monto\n                            "
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _c("th", { attrs: { width: "5%" } }, [
                            _c(
                              "a",
                              {
                                staticClass:
                                  "text-center font-weight-bold text-center text-info",
                                staticStyle: { "font-size": "18px" },
                                attrs: { href: "#" },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.clickAddPayment.apply(
                                      null,
                                      arguments
                                    )
                                  }
                                }
                              },
                              [_vm._v("[+]")]
                            )
                          ])
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        _vm._l(_vm.document.payments, function(row, index) {
                          return _c("tr", { key: index }, [
                            _c("td", [
                              _c(
                                "div",
                                { staticClass: "form-group mb-2 mr-2" },
                                [
                                  _c(
                                    "el-select",
                                    {
                                      model: {
                                        value: row.payment_method_type_id,
                                        callback: function($$v) {
                                          _vm.$set(
                                            row,
                                            "payment_method_type_id",
                                            $$v
                                          )
                                        },
                                        expression: "row.payment_method_type_id"
                                      }
                                    },
                                    _vm._l(_vm.payment_method_types, function(
                                      option
                                    ) {
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
                              )
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c(
                                "div",
                                { staticClass: "form-group mb-2 mr-2" },
                                [
                                  _c(
                                    "el-select",
                                    {
                                      attrs: {
                                        filterable: "",
                                        disabled:
                                          row.payment_destination_disabled
                                      },
                                      model: {
                                        value: row.payment_destination_id,
                                        callback: function($$v) {
                                          _vm.$set(
                                            row,
                                            "payment_destination_id",
                                            $$v
                                          )
                                        },
                                        expression: "row.payment_destination_id"
                                      }
                                    },
                                    _vm._l(_vm.payment_destinations, function(
                                      option
                                    ) {
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
                              )
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c(
                                "div",
                                { staticClass: "form-group mb-2 mr-2" },
                                [
                                  _c(
                                    "el-input",
                                    {
                                      model: {
                                        value: row.reference,
                                        callback: function($$v) {
                                          _vm.$set(row, "reference", $$v)
                                        },
                                        expression: "row.reference"
                                      }
                                    },
                                    [
                                      _c("i", {
                                        staticClass: "el-icon-edit-outline",
                                        attrs: { slot: "prefix" },
                                        slot: "prefix"
                                      })
                                    ]
                                  )
                                ],
                                1
                              )
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c(
                                "div",
                                { staticClass: "form-group mb-2 mr-2" },
                                [
                                  _c(
                                    "el-input",
                                    {
                                      model: {
                                        value: row.payment,
                                        callback: function($$v) {
                                          _vm.$set(row, "payment", $$v)
                                        },
                                        expression: "row.payment"
                                      }
                                    },
                                    [
                                      _c("i", {
                                        staticClass: "el-icon-edit-outline",
                                        attrs: { slot: "prefix" },
                                        slot: "prefix"
                                      })
                                    ]
                                  )
                                ],
                                1
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "td",
                              {
                                staticClass: "series-table-actions text-center"
                              },
                              [
                                _c(
                                  "button",
                                  {
                                    staticClass:
                                      "btn waves-effect waves-light btn-xs btn-danger",
                                    attrs: { type: "button" },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.clickCancel(index)
                                      }
                                    }
                                  },
                                  [_c("i", { staticClass: "fa fa-trash" })]
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c("br")
                          ])
                        }),
                        0
                      )
                    ])
                  ]
                )
              ])
            : _vm._e(),
          _vm._v(" "),
          _c(
            "span",
            {
              staticClass: "dialog-footer",
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
              _vm.showClose
                ? [
                    _c("el-button", { on: { click: _vm.clickClose } }, [
                      _vm._v("Cerrar")
                    ]),
                    _vm._v(" "),
                    _vm.generate
                      ? _c(
                          "el-button",
                          {
                            staticClass: "submit",
                            attrs: {
                              type: "primary",
                              loading: _vm.loading_submit
                            },
                            on: { click: _vm.submit }
                          },
                          [_vm._v("Generar")]
                        )
                      : _vm._e()
                  ]
                : [
                    _vm.generate
                      ? _c(
                          "el-button",
                          {
                            staticClass: "submit",
                            attrs: {
                              type: "primary",
                              plain: "",
                              loading: _vm.loading_submit
                            },
                            on: { click: _vm.submit }
                          },
                          [_vm._v("Generar comprobante")]
                        )
                      : _c("el-button", { on: { click: _vm.clickFinalize } }, [
                          _vm._v("Ir al listado")
                        ]),
                    _vm._v(" "),
                    _c(
                      "el-button",
                      {
                        attrs: { type: "primary" },
                        on: { click: _vm.clickNewQuotation }
                      },
                      [_vm._v("Nueva cotización")]
                    )
                  ]
            ],
            2
          )
        ]
      ),
      _vm._v(" "),
      _c("document-options", {
        attrs: {
          showDialog: _vm.showDialogDocumentOptions,
          recordId: _vm.documentNewId,
          isContingency: false,
          showClose: true
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogDocumentOptions = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogDocumentOptions = $event
          }
        }
      }),
      _vm._v(" "),
      _c("sale-note-options", {
        attrs: {
          configuration: _vm.configuration,
          showDialog: _vm.showDialogSaleNoteOptions,
          recordId: _vm.documentNewId,
          showClose: true
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogSaleNoteOptions = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogSaleNoteOptions = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-0d92229a", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4b997e69\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/DataTable.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "row " }, [
      _c("div", { staticClass: "col-md-12 col-lg-12 col-xl-12 " }, [
        _vm.applyFilter
          ? _c("div", { staticClass: "row" }, [
              _c(
                "div",
                { staticClass: "col-lg-4 col-md-4 col-sm-12 pb-2" },
                [
                  _c("label", { staticStyle: { width: "100%" } }, [
                    _vm._v(
                      "\n                            Filtrar por:\n                        "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      attrs: { placeholder: "Select" },
                      on: { change: _vm.changeClearInput },
                      model: {
                        value: _vm.search.column,
                        callback: function($$v) {
                          _vm.$set(_vm.search, "column", $$v)
                        },
                        expression: "search.column"
                      }
                    },
                    _vm._l(_vm.columns, function(label, key) {
                      return _c("el-option", {
                        key: key,
                        attrs: { value: key, label: label }
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
                { staticClass: "col-lg-3 col-md-4 col-sm-12 pb-2" },
                [
                  _c("label", { attrs: { for: "value" } }, [
                    _vm._v(
                      "\n                        Buscar\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _vm.search.column == "date_of_issue" ||
                  _vm.search.column == "date_of_due" ||
                  _vm.search.column == "date_of_payment" ||
                  _vm.search.column == "delivery_date" ||
                  _vm.search.column == "date"
                    ? [
                        _vm.resource != "caja/worker/expenses"
                          ? [
                              _c("el-date-picker", {
                                staticStyle: { width: "100%" },
                                attrs: {
                                  type: "date",
                                  placeholder: "Buscar",
                                  "value-format": "yyyy-MM-dd"
                                },
                                on: { change: _vm.getRecords },
                                model: {
                                  value: _vm.search.value,
                                  callback: function($$v) {
                                    _vm.$set(_vm.search, "value", $$v)
                                  },
                                  expression: "search.value"
                                }
                              })
                            ]
                          : [
                              _c("el-date-picker", {
                                attrs: {
                                  type: "daterange",
                                  "range-separator": "A",
                                  "start-placeholder": "Desde",
                                  "value-format": "yyyy-MM-dd",
                                  "end-placeholder": "Hasta"
                                },
                                on: { change: _vm.getRecords },
                                model: {
                                  value: _vm.search.value,
                                  callback: function($$v) {
                                    _vm.$set(_vm.search, "value", $$v)
                                  },
                                  expression: "search.value"
                                }
                              })
                            ]
                      ]
                    : _vm.search.column == "district_id"
                    ? [
                        _c(
                          "el-select",
                          {
                            attrs: { placeholder: "Seleccione el Distrito" },
                            on: { change: _vm.getRecords },
                            model: {
                              value: _vm.search.value,
                              callback: function($$v) {
                                _vm.$set(_vm.search, "value", $$v)
                              },
                              expression: "search.value"
                            }
                          },
                          _vm._l(_vm.array_district, function(item) {
                            return _c("el-option", {
                              key: item.id,
                              attrs: { label: item.description, value: item.id }
                            })
                          }),
                          1
                        )
                      ]
                    : _vm.search.column == "seller_id"
                    ? [
                        _c(
                          "el-select",
                          {
                            attrs: { placeholder: "Seleccione el vendedor" },
                            on: { change: _vm.getRecords },
                            model: {
                              value: _vm.search.value,
                              callback: function($$v) {
                                _vm.$set(_vm.search, "value", $$v)
                              },
                              expression: "search.value"
                            }
                          },
                          _vm._l(_vm.sellers, function(item, idx) {
                            return _c("el-option", {
                              key: idx,
                              attrs: { label: item.name, value: item.id }
                            })
                          }),
                          1
                        )
                      ]
                    : [
                        _c("el-input", {
                          staticStyle: { width: "100%" },
                          attrs: {
                            placeholder: "Buscar",
                            "prefix-icon": "el-icon-search"
                          },
                          on: { input: _vm.getRecords },
                          model: {
                            value: _vm.search.value,
                            callback: function($$v) {
                              _vm.$set(_vm.search, "value", $$v)
                            },
                            expression: "search.value"
                          }
                        })
                      ]
                ],
                2
              ),
              _vm._v(" "),
              _vm.search.column == "date_of_issue" ||
              _vm.search.column == "date_of_due" ||
              _vm.search.column == "date_of_payment" ||
              _vm.search.column == "delivery_date" ||
              (_vm.search.column == "date" &&
                _vm.resource == "purchases" &&
                _vm.search.value)
                ? _c(
                    "div",
                    { staticClass: "col-lg-3 col-md-4 col-sm-12 pb-2" },
                    [
                      _c("label", { attrs: { for: "value" } }, [
                        _vm._v(
                          "\n                        Hasta\n                    "
                        )
                      ]),
                      _vm._v(" "),
                      _c("el-date-picker", {
                        staticStyle: { width: "100%" },
                        attrs: {
                          type: "date",
                          placeholder: "Buscar",
                          "value-format": "yyyy-MM-dd"
                        },
                        on: { change: _vm.getRecords },
                        model: {
                          value: _vm.search.end_date,
                          callback: function($$v) {
                            _vm.$set(_vm.search, "end_date", $$v)
                          },
                          expression: "search.end_date"
                        }
                      })
                    ],
                    1
                  )
                : _vm._e()
            ])
          : _vm._e()
      ]),
      _vm._v(" "),
      _vm.resource == "caja/worker/expenses" ||
      ("purchases" && _vm.records.length != 0)
        ? _c("div", { staticClass: "row" }, [
            _vm.resource == "caja/worker/expenses"
              ? _c(
                  "div",
                  { staticClass: "col-md-3" },
                  [
                    _c(
                      "el-button",
                      {
                        staticClass: "submit",
                        attrs: { type: "danger", icon: "el-icon-tickets" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.clickDownload("pdf")
                          }
                        }
                      },
                      [_vm._v("Exportar PDF")]
                    )
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-3" },
              [
                _c(
                  "el-button",
                  {
                    staticClass: "submit",
                    attrs: { type: "success", icon: "el-icon-tickets" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.clickDownload("excel")
                      }
                    }
                  },
                  [_vm._v("Exportar Excel")]
                )
              ],
              1
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-12" }, [
        _c("div", { staticClass: "table-responsive" }, [
          _c("table", { staticClass: "table" }, [
            _c("thead", [_vm._t("heading")], 2),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.records, function(row, index) {
                  return _vm._t("default", null, {
                    row: row,
                    index: _vm.customIndex(index)
                  })
                })
              ],
              2
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            [
              _c("el-pagination", {
                attrs: {
                  layout: "total, prev, pager, next",
                  total: _vm.pagination.total,
                  "current-page": _vm.pagination.current_page,
                  "page-size": _vm.pagination.per_page
                },
                on: {
                  "current-change": _vm.getRecords,
                  "update:currentPage": function($event) {
                    return _vm.$set(_vm.pagination, "current_page", $event)
                  },
                  "update:current-page": function($event) {
                    return _vm.$set(_vm.pagination, "current_page", $event)
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
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4b997e69", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6401e04d\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/quotations/partials/options_pdf.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "el-dialog",
        {
          attrs: {
            title: _vm.titleDialog,
            visible: _vm.showDialog,
            width: "30%"
          },
          on: { open: _vm.create }
        },
        [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              {
                staticClass:
                  "col-lg-4 col-md-4 col-sm-4 text-center font-weight-bold"
              },
              [
                _c("p", [_vm._v("Imprimir A4")]),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-lg btn-info waves-effect waves-light",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.clickToPrint("a4")
                      }
                    }
                  },
                  [_c("i", { staticClass: "fa fa-print" })]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "col-lg-4 col-md-4 col-sm-4 text-center font-weight-bold"
              },
              [
                _c("p", [_vm._v("Imprimir Ticket")]),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-lg btn-info waves-effect waves-light",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.clickToPrint("ticket")
                      }
                    }
                  },
                  [_c("i", { staticClass: "fa fa-print" })]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "col-lg-4 col-md-4 col-sm-4 text-center font-weight-bold"
              },
              [
                _c("p", [_vm._v("Imprimir A5")]),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-lg btn-info waves-effect waves-light",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.clickToPrint("a5")
                      }
                    }
                  },
                  [_c("i", { staticClass: "fa fa-print" })]
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c("br"),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              {
                staticClass:
                  "col-lg-6 col-md-6 col-sm-6 text-center font-weight-bold"
              },
              [
                _c("p", [_vm._v("Descargar A4")]),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-lg btn-info waves-effect waves-light",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.clickDownload("a4")
                      }
                    }
                  },
                  [_c("i", { staticClass: "fa fa-download" })]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "col-lg-6 col-md-6 col-sm-6 text-center font-weight-bold"
              },
              [
                _c("p", [_vm._v("Descargar Ticket")]),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-lg btn-info waves-effect waves-light",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.clickDownload("ticket")
                      }
                    }
                  },
                  [_c("i", { staticClass: "fa fa-download" })]
                )
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
              _c("el-button", { on: { click: _vm.clickClose } }, [
                _vm._v("Cerrar")
              ])
            ],
            1
          )
        ]
      )
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
    require("vue-hot-reload-api")      .rerender("data-v-6401e04d", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0816d5ae\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/quotations/index.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0816d5ae\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/quotations/index.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("56304144", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js?sourceMap!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0816d5ae\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./index.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js?sourceMap!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0816d5ae\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./index.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/js/components/DataTable.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/DataTable.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4b997e69\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/DataTable.vue")
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
Component.options.__file = "resources/js/components/DataTable.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4b997e69", Component.options)
  } else {
    hotAPI.reload("data-v-4b997e69", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/quotations/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0816d5ae\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/quotations/index.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/quotations/index.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0816d5ae\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/quotations/index.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-0816d5ae"
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
Component.options.__file = "resources/js/views/quotations/index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0816d5ae", Component.options)
  } else {
    hotAPI.reload("data-v-0816d5ae", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/quotations/partials/options.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/quotations/partials/options.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0d92229a\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/quotations/partials/options.vue")
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
Component.options.__file = "resources/js/views/quotations/partials/options.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0d92229a", Component.options)
  } else {
    hotAPI.reload("data-v-0d92229a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/quotations/partials/options_pdf.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/quotations/partials/options_pdf.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6401e04d\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/quotations/partials/options_pdf.vue")
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
Component.options.__file = "resources/js/views/quotations/partials/options_pdf.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6401e04d", Component.options)
  } else {
    hotAPI.reload("data-v-6401e04d", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=tenant-quotations-index.js.map