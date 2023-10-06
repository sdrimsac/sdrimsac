webpackJsonp([132],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/documents/partials/lots.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['showDialog', 'lots', 'stock', 'recordId'],
  data: function data() {
    return {
      titleDialog: 'Series',
      loading: false,
      errors: {},
      form: {},
      search: '',
      lots_: []
    };
  },
  created: function created() {
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
  watch: {
    lots: function lots(val) {
      this.lots_ = val;
    }
  },
  methods: {
    filter: function filter() {
      var _this = this;

      if (this.search) {
        // this.lots_ = this.lots.filter( x => x.series.toUpperCase().includes(this.search.toUpperCase()))
        this.lots_ = _.filter(this.lots, function (x) {
          return x.series.toUpperCase().includes(_this.search.toUpperCase());
        });
      } else {
        this.lots_ = this.lots;
      }
    },
    create: function create() {},
    submit: function submit() {// let val_lots = await this.validateLots()
      // if(!val_lots.success)
      //     return this.$toast.error(val_lots.message);
      // await this.$emit('addRowLot', this.lots);
      // await this.$emit('update:showDialog', false)

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    close: function close() {
      this.$emit('update:showDialog', false);
      this.$emit('addRowSelectLot', this.lots_);
    },
    clickCancelSubmit: function clickCancelSubmit() {// this.$emit('addRowLot', []);
      // await this.$emit('update:showDialog', false)

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
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

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/partials/stock.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__js_views_documents_partials_lots_vue__ = __webpack_require__("./resources/js/views/documents/partials/lots.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__js_views_documents_partials_lots_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__js_views_documents_partials_lots_vue__);


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

 //import OutputLotsForm from './partials/lots.vue'

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    OutputLotsForm: __WEBPACK_IMPORTED_MODULE_1__js_views_documents_partials_lots_vue___default.a,
    OutputLotsGroupForm: __WEBPACK_IMPORTED_MODULE_1__js_views_documents_partials_lots_vue___default.a
  },
  props: ["showDialog", "recordId", "config", "user"],
  data: function data() {
    return {
      loading_submit: false,
      titleDialog: null,
      showDialogLotsOutput: false,
      showDialogLotsGroup: false,
      resource: "inventory",
      errors: {},
      form: {},
      warehouses: [],
      lotsAll: [],
      lotsGroupAll: [],
      sender: null
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.initForm();

              _this.socketWhatsappConfig(); // await this.$http.get(`/${this.resource}/tables`).then(response => {
              //     this.warehouses = response.data.warehouses;
              // });


            case 2:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    socketWhatsappConfig: function socketWhatsappConfig() {
      var _this2 = this;

      var hostName = window.location.hostname;
      var url = "https://".concat(hostName);
      this.sender = hostName.replace(/https?\:\/\//, "").replace("/", "").split(".").join("");

      try {
        this.socket = io.connect(this.$socketUrl);
      } catch (e) {
        console.log(e);
      }

      this.socket.on("connected", function (_ref) {
        var message = _ref.message;

        _this2.$toast.success(message);

        _this2.socket.emit("getStatus", url);
      });
      this.socket.on("setStatus", function (_ref2) {
        var status = _ref2.status,
            sender = _ref2.sender;

        if (!status) {
          _this2.sender = "sdrimsac";

          _this2.$toast.warning("Sesión iniciada con SDRIMSAC");
        } else {
          _this2.sender = sender;

          _this2.$toast.success("Whatsapp Listo!");
        }
      }); //MessageResponse

      this.socket.on("MessageResponse", function (_ref3) {
        var success = _ref3.success,
            message = _ref3.message;

        if (success) {
          _this2.$toast.success(message);
        } else {
          _this2.$toast.error(message);
        }
      });
    },
    addRowOutputLot: function addRowOutputLot(lots) {
      this.form.lots = lots;
    },
    addRowLotGroup: function addRowLotGroup(id) {
      this.form.selected_lots_group = id;
    },
    clickLotcodeOutput: function clickLotcodeOutput() {
      this.showDialogLotsOutput = true;
    },
    clickSelectLotsGroup: function clickSelectLotsGroup() {
      this.showDialogLotsGroup = true;
    },
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        id: null,
        item_id: null,
        item_description: null,
        warehouse_id: null,
        warehouse_description: null,
        quantity: null,
        quantity_real: null,
        lots_enabled: false,
        series_enabled: false,
        lots: []
      };
    },
    create: function create() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this3.titleDialog = "Ajuste de stock";
                _context2.next = 3;
                return _this3.$http.get("/".concat(_this3.resource, "/record/").concat(_this3.recordId)).then(function (response) {
                  var data = response.data.data;
                  _this3.form = _.clone(data);
                  _this3.form.lots = [];
                  _this3.form.lots_group = []; //Object.values(response.data.data.lots)

                  //Object.values(response.data.data.lots)
                  _this3.lotsAll = data.lots;
                  _this3.lotsGroupAll = data.lots_group; //Object.values(response.data.data.lots);

                  //Object.values(response.data.data.lots);
                  _this3.form = Object.assign({}, _this3.form, {
                    quantity_real: 0
                  });
                });

              case 3:
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
                if (!(_this4.config.observation_translate && !_this4.form.detail)) {
                  _context3.next = 2;
                  break;
                }

                return _context3.abrupt("return", _this4.$toast.error("El comentario es obligatorio"));

              case 2:
                if (!_this4.form.series_enabled) {
                  _context3.next = 5;
                  break;
                }

                if (!(_this4.form.lots.length !== parseInt(_this4.form.quantity_real))) {
                  _context3.next = 5;
                  break;
                }

                return _context3.abrupt("return", _this4.$toast.error("La cantidad ingresada es diferente a las series seleccionadas"));

              case 5:
                _this4.loading_submit = true;
                _context3.next = 8;
                return _this4.$http.post("/".concat(_this4.resource, "/stock"), _this4.form).then(function (response) {
                  if (response.data.success) {
                    _this4.$toast.success(response.data.message);

                    _this4.$eventHub.$emit("reloadData");

                    if (_this4.config.number_activity && _this4.config.personal_phone) {
                      var message = _this4.createMessage();

                      _this4.socket.emit("basicMessage", {
                        message: message,
                        sender: _this4.sender,
                        number: "51".concat(_this4.config.number_activity)
                      });
                    }

                    _this4.close();
                  } else {
                    _this4.$toast.error(response.data.message);
                  }
                })["catch"](function (error) {
                  if (error.response.status === 422) {
                    _this4.errors = error.response.data.errors;
                  } else {
                    console.log(error);
                  }
                }).then(function () {
                  _this4.loading_submit = false;
                });

              case 8:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    createMessage: function createMessage() {
      var message = "El usuario *".concat(this.user.name, "* ha actualizado el stock del producto *").concat(this.form.item_description.trim(), "* a ").concat(this.form.quantity_real, " en el almac\xE9n *").concat(this.form.warehouse_description.trim(), "*");

      if (this.form.detail) {
        message += " con el comentario: *".concat(this.form.detail.trim(), "*");
      }

      return message;
    },
    close: function close() {
      this.$emit("update:showDialog", false);
      this.initForm();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/partials/warehouses.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__stock_vue__ = __webpack_require__("./resources/js/views/items/partials/stock.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__stock_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__stock_vue__);


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

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    InventoriesStock: __WEBPACK_IMPORTED_MODULE_1__stock_vue___default.a
  },
  props: ["user", "showDialog", "warehouses", "unit_type", "itemId", "hasSerie", "item", "config"],
  data: function data() {
    return {
      showDialogStock: false,
      showImportDialog: false,
      resource: "items",
      total: 0,
      recordId: null,
      titleDialog: "Stock de producto",
      series: null,
      loading: false,
      maxDescription: ""
    };
  },
  created: function created() {
    var _this = this;

    this.$eventHub.$on("reloadData", function () {
      _this.close();
    }); //console.log(this.typeUser)
  },
  methods: {
    stockMaxQuantity: function stockMaxQuantity() {
      var stock = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      var item = arguments.length > 1 ? arguments[1] : undefined;
      var max_quantity = item.max_quantity,
          unit_type_description = item.unit_type_description,
          max_quantity_description = item.max_quantity_description;
      stock = Number(stock);
      var general = Math.trunc(stock / max_quantity);
      var part = stock / max_quantity % 1;
      var text = "".concat(general, " ").concat(max_quantity_description);

      if (part != 0) {
        var new_part = part * max_quantity;
        new_part = new_part.toFixed(2);

        if (general > 0) {
          text += " ".concat(new_part, " ").concat(unit_type_description);
        } else {
          text = "".concat(new_part, " ").concat(unit_type_description);
        }
      }

      return text;
    },
    clickStock: function clickStock(record) {
      this.recordId = record.id;
      this.showDialogStock = true;
    },
    open: function open() {
      this.total = this.warehouses.reduce(function (a, b) {
        return a + Number(b.stock);
      }, 0);

      if (this.hasSerie) {
        this.getSeries();
      }
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    getSeries: function getSeries() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, message;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _this2.loading = true;
                _context.next = 4;
                return _this2.$http("/documents/get-series/".concat(_this2.itemId));

              case 4:
                response = _context.sent;
                _this2.series = response.data;
                _context.next = 13;
                break;

              case 8:
                _context.prev = 8;
                _context.t0 = _context["catch"](0);
                console.log(_context.t0);
                message = _context.t0.response.data.message;

                _this2.$toast.error(message);

              case 13:
                _context.prev = 13;
                _this2.loading = false;
                return _context.finish(13);

              case 16:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 8, 13, 16]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-168d9d6f\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/partials/warehouses.vue":
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
        title: _vm.titleDialog,
        visible: _vm.showDialog,
        "append-to-body": "",
        top: "7vh"
      },
      on: { close: _vm.close, open: _vm.open }
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
              _vm.warehouses && _vm.item
                ? _c("div", { staticClass: "col-md-12" }, [
                    _c("table", { staticClass: "table" }, [
                      _c("thead", [
                        _c("tr", [
                          _c("th", [_vm._v("Ubicación")]),
                          _vm._v(" "),
                          _c("th", { staticClass: "text-end" }, [
                            _vm._v("Stock")
                          ]),
                          _vm._v(" "),
                          _c("th")
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        [
                          _vm._l(_vm.warehouses, function(row, idx) {
                            return _c("tr", { key: idx }, [
                              _c("th", [
                                _vm._v(_vm._s(row.warehouse_description))
                              ]),
                              _vm._v(" "),
                              _c(
                                "th",
                                { staticClass: "text-end" },
                                [
                                  _vm.item.max_quantity
                                    ? [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              _vm.stockMaxQuantity(
                                                row.stock,
                                                _vm.item
                                              )
                                            ) +
                                            "\n                                    "
                                        )
                                      ]
                                    : [
                                        _vm.config && _vm.config.college
                                          ? [
                                              _vm._v(
                                                "\n                                            " +
                                                  _vm._s(parseInt(row.stock)) +
                                                  "\n                                        "
                                              )
                                            ]
                                          : [
                                              _vm._v(
                                                "\n                                            " +
                                                  _vm._s(row.stock) +
                                                  "\n                                        "
                                              )
                                            ]
                                      ]
                                ],
                                2
                              ),
                              _vm._v(" "),
                              _c("th", [
                                !_vm.hasSerie && _vm.config.item_adjustment
                                  ? _c(
                                      "button",
                                      {
                                        staticClass:
                                          "btn waves-effect waves-light btn-sm btn-warning",
                                        attrs: { type: "button" },
                                        on: {
                                          click: function($event) {
                                            $event.preventDefault()
                                            return _vm.clickStock(row)
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                        Ajuste\n                                        "
                                        ),
                                        _c(
                                          "el-tooltip",
                                          {
                                            staticClass: "item",
                                            attrs: {
                                              content:
                                                "Ajuste: stock del sistema no cuadre con el stock real",
                                              effect: "dark",
                                              placement: "top"
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-info-circle"
                                            })
                                          ]
                                        )
                                      ],
                                      1
                                    )
                                  : _vm._e()
                              ])
                            ])
                          }),
                          _vm._v(" "),
                          _c("tr", [
                            _c("td", [
                              _vm._v(
                                "\n                                    Total\n                                "
                              )
                            ]),
                            _vm._v(" "),
                            _vm.config && _vm.config.college
                              ? _c(
                                  "td",
                                  {
                                    staticClass: "text-end",
                                    attrs: { template: "" }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(parseInt(_vm.total)) +
                                        "\n                                "
                                    )
                                  ]
                                )
                              : _c(
                                  "td",
                                  { staticClass: "text-end" },
                                  [
                                    _vm.item && _vm.item.max_quantity
                                      ? [
                                          _vm._v(
                                            "\n                                    " +
                                              _vm._s(
                                                _vm.stockMaxQuantity(
                                                  _vm.total,
                                                  _vm.item
                                                )
                                              ) +
                                              "\n                                    "
                                          )
                                        ]
                                      : [
                                          _vm._v(
                                            "\n                                    " +
                                              _vm._s(_vm.total.toFixed(2)) +
                                              "\n                                    "
                                          )
                                        ]
                                  ],
                                  2
                                ),
                            _vm._v(" "),
                            _c("td")
                          ])
                        ],
                        2
                      )
                    ]),
                    _vm._v(" "),
                    _vm.hasSerie
                      ? _c("div", [
                          _c("table", { staticClass: "table" }, [
                            _c("tbody", [
                              _c("tr", [
                                _c("td", [
                                  _vm._v(
                                    "\n                                        Total de series activas:\n                                    "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-end" }, [
                                  _c("strong", [
                                    _vm._v(
                                      "\n                                            " +
                                        _vm._s(_vm.series) +
                                        "\n                                        "
                                    )
                                  ])
                                ])
                              ])
                            ])
                          ])
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.unit_type.length > 0
                      ? _c("div", [
                          _c("h6", [_vm._v("Lista de Precios Creados")]),
                          _vm._v(" "),
                          _c("table", { staticClass: "table" }, [
                            _c("thead", [
                              _c("tr", [
                                _c("th", [_vm._v("Unidad")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Description")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Cantidad")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Precio")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Total")])
                              ])
                            ]),
                            _vm._v(" "),
                            _c(
                              "tbody",
                              _vm._l(_vm.unit_type, function(row) {
                                return _c("tr", { key: row.id }, [
                                  _c("th", [_vm._v(_vm._s(row.unit_type_id))]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v(_vm._s(row.description))]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v(_vm._s(row.quantity_unit))]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v(_vm._s(row.price2))]),
                                  _vm._v(" "),
                                  _c("th", [
                                    _vm._v(
                                      "\n                                        " +
                                        _vm._s(
                                          Number(row.price2) *
                                            Number(row.quantity_unit)
                                        ) +
                                        "\n                                    "
                                    )
                                  ])
                                ])
                              }),
                              0
                            )
                          ])
                        ])
                      : _vm._e()
                  ])
                : _vm._e()
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
                [_vm._v("Cerrar")]
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _c("inventories-stock", {
        attrs: {
          user: _vm.user,
          showDialog: _vm.showDialogStock,
          recordId: _vm.recordId,
          config: _vm.config
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogStock = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogStock = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-168d9d6f", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-54961759\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/documents/partials/lots.vue":
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
        width: "40%",
        visible: _vm.showDialog,
        "close-on-click-modal": false,
        "close-on-press-escape": false,
        "append-to-body": "",
        "show-close": false
      },
      on: { open: _vm.create }
    },
    [
      _c("div", { staticClass: "form-body" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-lg-12 col-md-12 table-responsive" }, [
            _c(
              "div",
              { staticClass: "col-lg-5 col-md-5 col-sm-12 pb-2" },
              [
                _c(
                  "el-input",
                  {
                    staticStyle: { width: "100%" },
                    attrs: {
                      placeholder: "Buscar serie ...",
                      "prefix-icon": "el-icon-search"
                    },
                    on: { input: _vm.filter },
                    model: {
                      value: _vm.search,
                      callback: function($$v) {
                        _vm.search = $$v
                      },
                      expression: "search"
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
            ),
            _vm._v(" "),
            _c("table", { staticClass: "table", attrs: { width: "100%" } }, [
              _c("thead", [
                _c("tr", { attrs: { width: "100%" } }, [
                  _c("th", { staticClass: "text-center" }, [
                    _vm._v("Seleccionar")
                  ]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Cod. Lote")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Serie")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Fecha")])
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.lots_, function(row, index) {
                  return _c("tr", { key: index, attrs: { width: "100%" } }, [
                    _c(
                      "td",
                      { staticClass: "text-center" },
                      [
                        _c("el-checkbox", {
                          model: {
                            value: row.has_sale,
                            callback: function($$v) {
                              _vm.$set(row, "has_sale", $$v)
                            },
                            expression: "row.has_sale"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("td", [
                      _vm._v(
                        "\n                                " +
                          _vm._s(row.lot_code) +
                          "\n                            "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm._v(
                        "\n                                " +
                          _vm._s(row.series) +
                          "\n                            "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm._v(
                        "\n                                " +
                          _vm._s(row.date) +
                          "\n                            "
                      )
                    ]),
                    _vm._v(" "),
                    _c("br")
                  ])
                }),
                0
              )
            ])
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
            [_vm._v("Cerrar")]
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
    require("vue-hot-reload-api")      .rerender("data-v-54961759", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5c4c8cf2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/partials/stock.vue":
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
        "append-to-body": ""
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
              _c("div", { staticClass: "col-md-8" }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Producto")
                    ]),
                    _vm._v(" "),
                    _c("el-input", {
                      attrs: { readonly: true },
                      model: {
                        value: _vm.form.item_description,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "item_description", $$v)
                        },
                        expression: "form.item_description"
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
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Stock en el sistema")
                    ]),
                    _vm._v(" "),
                    _c("el-input", {
                      attrs: { readonly: true },
                      model: {
                        value: _vm.form.quantity,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "quantity", $$v)
                        },
                        expression: "form.quantity"
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-8" }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Almacén")
                    ]),
                    _vm._v(" "),
                    _c("el-input", {
                      attrs: { readonly: true },
                      model: {
                        value: _vm.form.warehouse_description,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "warehouse_description", $$v)
                        },
                        expression: "form.warehouse_description"
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
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Stock real")
                    ]),
                    _vm._v(" "),
                    _c("el-input", {
                      model: {
                        value: _vm.form.quantity_real,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "quantity_real", $$v)
                        },
                        expression: "form.quantity_real"
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _vm.form.item_id &&
              _vm.form.warehouse_id &&
              _vm.form.series_enabled
                ? _c("div", { staticClass: "col-md-4 mt-4" }, [
                    _c(
                      "a",
                      {
                        staticClass: "text-center font-weight-bold text-info",
                        attrs: { href: "#" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.clickLotcodeOutput.apply(null, arguments)
                          }
                        }
                      },
                      [_vm._v("[✔ Seleccionar series]")]
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.form.item_id && _vm.form.warehouse_id && _vm.form.lots_enabled
                ? _c("div", { staticClass: "col-md-4 mt-4" }, [
                    _c(
                      "a",
                      {
                        staticClass: "text-center font-weight-bold text-info",
                        attrs: { href: "#" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.clickSelectLotsGroup.apply(
                              null,
                              arguments
                            )
                          }
                        }
                      },
                      [_vm._v("[✔ Seleccionar lotes]")]
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.config.observation_translate
                ? _c("div", { staticClass: "col-12" }, [
                    _c(
                      "div",
                      { staticClass: "form-group" },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Comentario")
                        ]),
                        _vm._v(" "),
                        _c("el-input", {
                          attrs: { type: "textarea", maxlength: "191" },
                          model: {
                            value: _vm.form.detail,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "detail", $$v)
                            },
                            expression: "form.detail"
                          }
                        })
                      ],
                      1
                    )
                  ])
                : _vm._e()
            ])
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "form-actions text-end mt-4" },
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
                [_vm._v("Aceptar")]
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _c("output-lots-form", {
        attrs: {
          showDialog: _vm.showDialogLotsOutput,
          itemId: _vm.form.item_id,
          "lots-all": _vm.lotsAll,
          lots: _vm.form.lots,
          quantity: _vm.form.quantity_real,
          warehouseId: _vm.form.warehouse_id
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogLotsOutput = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogLotsOutput = $event
          },
          addRowOutputLot: _vm.addRowOutputLot
        }
      }),
      _vm._v(" "),
      _c("output-lots-group-form", {
        attrs: {
          showDialog: _vm.showDialogLotsGroup,
          itemId: _vm.form.item_id,
          "lots-group-all": _vm.lotsGroupAll,
          lots_group: _vm.form.lots_group,
          quantity: _vm.form.quantity_real,
          "compromise-all-quantity": true
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogLotsGroup = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogLotsGroup = $event
          },
          addRowLotGroup: _vm.addRowLotGroup
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
    require("vue-hot-reload-api")      .rerender("data-v-5c4c8cf2", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/documents/partials/lots.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/documents/partials/lots.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-54961759\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/documents/partials/lots.vue")
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
Component.options.__file = "resources/js/views/documents/partials/lots.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-54961759", Component.options)
  } else {
    hotAPI.reload("data-v-54961759", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/items/partials/stock.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/partials/stock.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5c4c8cf2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/partials/stock.vue")
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
Component.options.__file = "resources/js/views/items/partials/stock.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5c4c8cf2", Component.options)
  } else {
    hotAPI.reload("data-v-5c4c8cf2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/items/partials/warehouses.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/partials/warehouses.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-168d9d6f\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/partials/warehouses.vue")
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
Component.options.__file = "resources/js/views/items/partials/warehouses.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-168d9d6f", Component.options)
  } else {
    hotAPI.reload("data-v-168d9d6f", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=132.js.map