webpackJsonp([138],{

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
//
//
//
//
//
var DocumentOptions = function DocumentOptions() {
  return __webpack_require__.e/* import() */(171).then(__webpack_require__.bind(null, "./resources/js/views/documents/partials/options.vue"));
}; // import DocumentOptions from "../../documents/partials/options.vue";


var SaleNoteOptions = function SaleNoteOptions() {
  return __webpack_require__.e/* import() */(167).then(__webpack_require__.bind(null, "./resources/js/views/sale_notes/partials/options.vue"));
}; // import SaleNoteOptions from "../../sale_notes/partials/options.vue";


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    DocumentOptions: DocumentOptions,
    SaleNoteOptions: SaleNoteOptions
  },
  props: ["external", "showDialog", "recordId", "showClose", "showGenerate", "type", "typeUser"],
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

      if (this.external) {
        this.$emit("close");
      }

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
              !_vm.external
                ? [
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
                            : _c(
                                "el-button",
                                { on: { click: _vm.clickFinalize } },
                                [_vm._v("Ir al listado")]
                              ),
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
                  ]
                : [
                    _c("el-button", { on: { click: _vm.clickClose } }, [
                      _vm._v("Cerrar")
                    ])
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


/***/ })

});
//# sourceMappingURL=138.js.map