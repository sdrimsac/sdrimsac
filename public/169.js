webpackJsonp([169],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/documents/partials/payments.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");


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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "documentId", "external"],
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_deletable__["a" /* deletable */]],
  data: function data() {
    return {
      title: null,
      resource: "document_payments",
      records: [],
      payment_destinations: [],
      headers: headers_token,
      fileList: [],
      payment_method_types: [],
      showAddButton: true,
      document: {},
      index_file: null
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
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
              _context.next = 4;
              return _this.initForm();

            case 4:
              _context.next = 6;
              return _this.$http.get("/".concat(_this.resource, "/tables")).then(function (response) {
                _this.payment_method_types = response.data.payment_method_types;
                _this.payment_destinations = response.data.payment_destinations; //this.initDocumentTypes()
              });

            case 6:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    clickPrintPos: function clickPrintPos(printerName, formatoPdf) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this2.$confirm("Elija una de las opciones", "Imprimir", {
                  confirmButtonText: "Impresión directa",
                  cancelButtonText: "Descargar PDF",
                  type: "warning"
                }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
                  var paperConfig, config, data;
                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
                    while (1) {
                      switch (_context2.prev = _context2.next) {
                        case 0:
                          _context2.prev = 0;
                          paperConfig = {
                            scaleContent: false
                          };
                          config = qz.configs.create(printerName, paperConfig);

                          if (qz.websocket.isActive()) {
                            _context2.next = 6;
                            break;
                          }

                          _context2.next = 6;
                          return qz.websocket.connect(config);

                        case 6:
                          data = [{
                            type: "pdf",
                            format: "file",
                            data: formatoPdf
                          }];
                          qz.print(config, data)["catch"](function (e) {
                            _this2.$toast.error(e.message);
                          });
                          _context2.next = 13;
                          break;

                        case 10:
                          _context2.prev = 10;
                          _context2.t0 = _context2["catch"](0);

                          _this2.$toast.error(_context2.t0.message);

                        case 13:
                        case "end":
                          return _context2.stop();
                      }
                    }
                  }, _callee2, null, [[0, 10]]);
                })))["catch"](function () {
                  window.open(formatoPdf, "_blank");

                  _this2.clickClose();
                });

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    clickReceipt: function clickReceipt(receipt, printer) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this3.clickPrintPos(printer, receipt);

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    clickDownloadFile: function clickDownloadFile(filename) {
      window.open("/finances/payment-file/download-file/".concat(filename, "/documents"), "_blank");
    },
    onSuccess: function onSuccess(response, file, fileList) {
      // console.log(response, file, fileList)
      this.fileList = fileList;

      if (response.success) {
        this.index_file = response.data.index;
        this.records[this.index_file].filename = response.data.filename;
        this.records[this.index_file].temp_path = response.data.temp_path;
      } else {
        this.$toast.error(response.message);
      } // console.log(this.records)

    },
    handleRemove: function handleRemove(file, fileList) {
      this.records[this.index_file].filename = null;
      this.records[this.index_file].temp_path = null;
      this.fileList = [];
      this.index_file = null;
    },
    initForm: function initForm() {
      this.records = [];
      this.fileList = [];
      this.showAddButton = true;
    },
    getData: function getData() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this4.initForm();

                _context5.next = 3;
                return _this4.$http.get("/".concat(_this4.resource, "/document/").concat(_this4.documentId)).then(function (response) {
                  _this4.document = response.data;
                  _this4.title = "Pagos del comprobante: " + _this4.document.number_full;
                });

              case 3:
                _context5.next = 5;
                return _this4.$http.get("/".concat(_this4.resource, "/records/").concat(_this4.documentId)).then(function (response) {
                  _this4.records = response.data.data;
                  console.log("🚀 ~ file: payments.vue:262 ~ getData ~ this.records:", _this4.records);
                });

              case 5:
                _this4.$eventHub.$emit("reloadDataUnpaid");

              case 6:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    clickAddRow: function clickAddRow() {
      this.records.push({
        id: null,
        date_of_payment: moment().format("YYYY-MM-DD"),
        payment_method_type_id: "01",
        payment_destination_id: "cash",
        reference: null,
        filename: null,
        temp_path: null,
        payment: 0,
        errors: {},
        loading: false
      });
      this.showAddButton = false;
    },
    clickCancel: function clickCancel(index) {
      this.records.splice(index, 1);
      this.fileList = [];
      this.showAddButton = true;
    },
    clickSubmit: function clickSubmit(index) {
      var _this5 = this;

      if (this.records[index].payment > parseFloat(this.document.total_difference)) {
        this.$toast.error("El monto ingresado supera al monto pendiente de pago, verifique.");
        return;
      }

      var form = {
        id: this.records[index].id,
        document_id: this.documentId,
        date_of_payment: this.records[index].date_of_payment,
        payment_method_type_id: this.records[index].payment_method_type_id,
        payment_destination_id: this.records[index].payment_destination_id,
        reference: this.records[index].reference,
        filename: this.records[index].filename,
        temp_path: this.records[index].temp_path,
        payment: this.records[index].payment
      };
      this.$http.post("/".concat(this.resource), form).then(function (response) {
        if (response.data.success) {
          _this5.$toast.success(response.data.message);

          _this5.getData(); // this.initDocumentTypes()


          _this5.showAddButton = true;

          _this5.$eventHub.$emit("reloadData");

          if (_this5.external) {
            _this5.$emit("getRecords");
          }
        } else {
          _this5.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this5.records[index].errors = error.response.data;
        } else {
          console.log(error);
        }
      });
    },
    // filterDocumentType(row){
    //
    //     if(row.contingency){
    //         this.document_types = _.filter(this.all_document_types, item => (item.id == '01' || item.id =='03'))
    //         row.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null
    //     }else{
    //         row.document_type_id = null
    //         this.document_types = this.all_document_types
    //     }
    // },
    // initDocumentTypes(){
    //     this.document_types = (this.all_document_types.length > 0) ? this.all_document_types : []
    // },
    close: function close() {
      this.$emit("update:showDialog", false); // this.initDocumentTypes()
      // this.initForm()
    },
    clickDelete: function clickDelete(id) {
      var _this6 = this;

      this.destroy("/".concat(this.resource, "/").concat(id)).then(function () {
        _this6.getData();

        _this6.$eventHub.$emit("reloadData"); // this.initDocumentTypes()

      });
    },
    clickDownloadReport: function clickDownloadReport(id) {
      window.open("/".concat(this.resource, "/report/").concat(this.documentId), "_blank");
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-52081a44\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/documents/partials/payments.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        title: _vm.title,
        visible: _vm.showDialog,
        width: "65%",
        "append-to-body": ""
      },
      on: { close: _vm.close, open: _vm.getData }
    },
    [
      _c("div", { staticClass: "form-body" }, [
        _c("div", { staticClass: "row" }, [
          _vm.records.length > 0
            ? _c("div", { staticClass: "col-md-12" }, [
                _c("div", { staticClass: "table-responsive" }, [
                  _c("table", { staticClass: "table" }, [
                    _c("thead", [
                      _c("tr", [
                        _c("th", [_vm._v("#")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Fecha de pago")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Método de pago")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Destino")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Referencia")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Archivo")]),
                        _vm._v(" "),
                        _c("th", { staticClass: "text-end" }, [
                          _vm._v("Monto")
                        ]),
                        _vm._v(" "),
                        _c("th")
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      _vm._l(_vm.records, function(row, index) {
                        return _c(
                          "tr",
                          { key: index },
                          [
                            row.id
                              ? [
                                  _c(
                                    "td",
                                    [
                                      row.receipt
                                        ? [
                                            _vm._v(
                                              "\n                                            " +
                                                _vm._s(row.receipt) +
                                                "\n                                        "
                                            )
                                          ]
                                        : [
                                            _vm._v(
                                              "\n                                            PAGO-" +
                                                _vm._s(row.id) +
                                                "\n                                        "
                                            )
                                          ]
                                    ],
                                    2
                                  ),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(_vm._s(row.date_of_payment))
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                        " +
                                        _vm._s(
                                          row.payment_method_type_description
                                        ) +
                                        "\n                                    "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                        " +
                                        _vm._s(row.destination_description) +
                                        "\n                                    "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [_vm._v(_vm._s(row.reference))]),
                                  _vm._v(" "),
                                  _c("td", { staticClass: "text-center" }, [
                                    row.filename
                                      ? _c(
                                          "button",
                                          {
                                            staticClass:
                                              "btn waves-effect waves-light btn-sm btn-primary",
                                            attrs: { type: "button" },
                                            on: {
                                              click: function($event) {
                                                $event.preventDefault()
                                                return _vm.clickDownloadFile(
                                                  row.filename
                                                )
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass:
                                                "fas fa-file-download"
                                            })
                                          ]
                                        )
                                      : _vm._e()
                                  ]),
                                  _vm._v(" "),
                                  _c("td", { staticClass: "text-end" }, [
                                    _vm._v(
                                      "\n                                        " +
                                        _vm._s(row.payment) +
                                        "\n                                    "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    {
                                      staticClass:
                                        "series-table-actions text-end"
                                    },
                                    [
                                      row.receipt_file
                                        ? _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn waves-effect waves-light btn-sm btn-success",
                                              attrs: { type: "button" },
                                              on: {
                                                click: function($event) {
                                                  $event.preventDefault()
                                                  return _vm.clickReceipt(
                                                    row.receipt_file,
                                                    row.printer
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                            Recibo\n                                        "
                                              )
                                            ]
                                          )
                                        : _vm._e(),
                                      _vm._v(" "),
                                      _c(
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
                                            "\n                                            Eliminar\n                                        "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                ]
                              : [
                                  _c("td"),
                                  _vm._v(" "),
                                  _c("td", [
                                    _c(
                                      "div",
                                      {
                                        staticClass: "form-group mb-0",
                                        class: {
                                          "has-danger":
                                            row.errors.date_of_payment
                                        }
                                      },
                                      [
                                        _c("el-date-picker", {
                                          attrs: {
                                            type: "date",
                                            clearable: false,
                                            format: "dd/MM/yyyy",
                                            "value-format": "yyyy-MM-dd"
                                          },
                                          model: {
                                            value: row.date_of_payment,
                                            callback: function($$v) {
                                              _vm.$set(
                                                row,
                                                "date_of_payment",
                                                $$v
                                              )
                                            },
                                            expression:
                                              "\n                                                    row.date_of_payment\n                                                "
                                          }
                                        }),
                                        _vm._v(" "),
                                        row.errors.date_of_payment
                                          ? _c("small", {
                                              staticClass:
                                                "form-control-feedback",
                                              domProps: {
                                                textContent: _vm._s(
                                                  row.errors.date_of_payment[0]
                                                )
                                              }
                                            })
                                          : _vm._e()
                                      ],
                                      1
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _c(
                                      "div",
                                      {
                                        staticClass: "form-group mb-0",
                                        class: {
                                          "has-danger":
                                            row.errors.payment_method_type_id
                                        }
                                      },
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
                                              expression:
                                                "\n                                                    row.payment_method_type_id\n                                                "
                                            }
                                          },
                                          _vm._l(
                                            _vm.payment_method_types,
                                            function(option) {
                                              return _c("el-option", {
                                                key: option.id,
                                                attrs: {
                                                  value: option.id,
                                                  label: option.description
                                                }
                                              })
                                            }
                                          ),
                                          1
                                        ),
                                        _vm._v(" "),
                                        row.errors.payment_method_type_id
                                          ? _c("small", {
                                              staticClass:
                                                "form-control-feedback",
                                              domProps: {
                                                textContent: _vm._s(
                                                  row.errors
                                                    .payment_method_type_id[0]
                                                )
                                              }
                                            })
                                          : _vm._e()
                                      ],
                                      1
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _c(
                                      "div",
                                      {
                                        staticClass: "form-group mb-0",
                                        class: {
                                          "has-danger":
                                            row.errors.payment_destination_id
                                        }
                                      },
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
                                              expression:
                                                "\n                                                    row.payment_destination_id\n                                                "
                                            }
                                          },
                                          _vm._l(
                                            _vm.payment_destinations,
                                            function(option) {
                                              return _c("el-option", {
                                                key: option.id,
                                                attrs: {
                                                  value: option.id,
                                                  label: option.description
                                                }
                                              })
                                            }
                                          ),
                                          1
                                        ),
                                        _vm._v(" "),
                                        row.errors.payment_destination_id
                                          ? _c("small", {
                                              staticClass:
                                                "form-control-feedback",
                                              domProps: {
                                                textContent: _vm._s(
                                                  row.errors
                                                    .payment_destination_id[0]
                                                )
                                              }
                                            })
                                          : _vm._e()
                                      ],
                                      1
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _c(
                                      "div",
                                      {
                                        staticClass: "form-group mb-0",
                                        class: {
                                          "has-danger": row.errors.reference
                                        }
                                      },
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
                                              staticClass:
                                                "el-icon-edit-outline",
                                              attrs: { slot: "prefix" },
                                              slot: "prefix"
                                            })
                                          ]
                                        ),
                                        _vm._v(" "),
                                        row.errors.reference
                                          ? _c("small", {
                                              staticClass:
                                                "form-control-feedback",
                                              domProps: {
                                                textContent: _vm._s(
                                                  row.errors.reference[0]
                                                )
                                              }
                                            })
                                          : _vm._e()
                                      ],
                                      1
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _c(
                                      "div",
                                      { staticClass: "form-group mb-0" },
                                      [
                                        _c(
                                          "el-upload",
                                          {
                                            attrs: {
                                              data: { index: index },
                                              headers: _vm.headers,
                                              multiple: false,
                                              "on-remove": _vm.handleRemove,
                                              action:
                                                "/finances/payment-file/upload",
                                              "show-file-list": true,
                                              "file-list": _vm.fileList,
                                              "on-success": _vm.onSuccess,
                                              limit: 1
                                            }
                                          },
                                          [
                                            _c(
                                              "el-button",
                                              {
                                                attrs: {
                                                  slot: "trigger",
                                                  type: "primary"
                                                },
                                                slot: "trigger"
                                              },
                                              [
                                                _vm._v(
                                                  "Seleccione un\n                                                    archivo"
                                                )
                                              ]
                                            )
                                          ],
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
                                      {
                                        staticClass: "form-group mb-0",
                                        class: {
                                          "has-danger": row.errors.payment
                                        }
                                      },
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
                                              staticClass:
                                                "el-icon-edit-outline",
                                              attrs: { slot: "prefix" },
                                              slot: "prefix"
                                            })
                                          ]
                                        ),
                                        _vm._v(" "),
                                        row.errors.payment
                                          ? _c("small", {
                                              staticClass:
                                                "form-control-feedback",
                                              domProps: {
                                                textContent: _vm._s(
                                                  row.errors.payment[0]
                                                )
                                              }
                                            })
                                          : _vm._e()
                                      ],
                                      1
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    {
                                      staticClass:
                                        "series-table-actions text-end"
                                    },
                                    [
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "btn waves-effect waves-light btn-sm btn-info",
                                          attrs: { type: "button" },
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              return _vm.clickSubmit(index)
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fa fa-check"
                                          })
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "btn waves-effect waves-light btn-sm btn-danger",
                                          attrs: { type: "button" },
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              return _vm.clickCancel(index)
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fa fa-trash"
                                          })
                                        ]
                                      )
                                    ]
                                  )
                                ]
                          ],
                          2
                        )
                      }),
                      0
                    ),
                    _vm._v(" "),
                    _c("tfoot", [
                      _c("tr", [
                        _c(
                          "td",
                          { staticClass: "text-end", attrs: { colspan: "6" } },
                          [
                            _vm._v(
                              "\n                                    TOTAL PAGADO\n                                "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-end" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(_vm.document.total_paid) +
                              "\n                                "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td")
                      ]),
                      _vm._v(" "),
                      _c("tr", [
                        _c(
                          "td",
                          { staticClass: "text-end", attrs: { colspan: "6" } },
                          [
                            _vm._v(
                              "\n                                    TOTAL A PAGAR\n                                "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-end" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(_vm.document.total) +
                              "\n                                "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td")
                      ]),
                      _vm._v(" "),
                      _c("tr", [
                        _c(
                          "td",
                          { staticClass: "text-end", attrs: { colspan: "6" } },
                          [
                            _vm._v(
                              "\n                                    PENDIENTE DE PAGO\n                                "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-end" }, [
                          _vm._v(
                            "\n                                    " +
                              _vm._s(_vm.document.total_difference) +
                              "\n                                "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td")
                      ])
                    ])
                  ])
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.showAddButton && _vm.document.total_difference > 0
            ? _c(
                "div",
                { staticClass: "col-md-12 text-center pt-2" },
                [
                  _c(
                    "el-button",
                    {
                      attrs: { type: "primary", icon: "el-icon-plus" },
                      on: { click: _vm.clickAddRow }
                    },
                    [_vm._v("Nuevo")]
                  )
                ],
                1
              )
            : _vm._e()
        ])
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
    require("vue-hot-reload-api")      .rerender("data-v-52081a44", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/documents/partials/payments.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/documents/partials/payments.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-52081a44\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/documents/partials/payments.vue")
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
Component.options.__file = "resources/js/views/documents/partials/payments.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-52081a44", Component.options)
  } else {
    hotAPI.reload("data-v-52081a44", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=169.js.map