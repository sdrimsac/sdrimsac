webpackJsonp([6],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/check_stock.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["user"],
  data: function data() {
    return {
      linkpdf: "https://tunegocio.sdrimsac.pro/sale-notes/print/6e977e52-38c8-4c4d-a897-3bbb1fd77ca8/a5",
      printer: null,
      resource: "/items/check_stock",
      records: [],
      loading: false,
      pagination: {},
      config: {
        scaleContent: false,
        density: 350,
        orientation: "landscape",
        margins: {
          top: 0,
          left: 0,
          right: 0,
          bottom: 0
        }
      }
    };
  },
  created: function created() {
    var _this = this;

    // this.getRecords();
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
  },
  methods: {
    Printer: function Printer() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (_this2.printer) {
                  _context.next = 3;
                  break;
                }

                _this2.$toast.error("Debe ingresar una impresora");

                return _context.abrupt("return");

              case 3:
                if (!(!_this2.linkpdf || _this2.linkpdf == "" || _this2.linkpdf == null)) {
                  _context.next = 6;
                  break;
                }

                _this2.$toast.error("Debe ingresar una url");

                return _context.abrupt("return");

              case 6:
                // let linkpdf = "https://portal.sdrimsac.pro/sale-notes/print/c393face-938f-40d1-9c9d-6cd9e55fb791/a5";   
                config = qz.configs.create(_this2.printer, _this2.config);
                localStorage.setItem("printer", _this2.config);

                if (qz.websocket.isActive()) {
                  _context.next = 11;
                  break;
                }

                _context.next = 11;
                return qz.websocket.connect(config);

              case 11:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: _this2.linkpdf
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this2.$toast.error(e.message);
                });

              case 13:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getRecords: function getRecords() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _this3.loading = true;
                _context2.next = 4;
                return _this3.$http.get(_this3.resource);

              case 4:
                response = _context2.sent;
                _this3.records = response.data.data;
                _this3.pagination = response.data.meta;
                _this3.loading = false;
                _context2.next = 14;
                break;

              case 10:
                _context2.prev = 10;
                _context2.t0 = _context2["catch"](0);
                _this3.loading = false;
                console.log(_context2.t0);

              case 14:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[0, 10]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/registers/index.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_query_string__);


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


/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["configuration", "user_type"],
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_deletable__["a" /* deletable */]],
  components: {},
  data: function data() {
    return {
      realTime: false,
      loading: false,
      records: [],
      recordsRealTime: [],
      users: [],
      resource: "registers",
      translatePros: {
        number: "Número",
        table: "Zona",
        area: "Área",
        customer: "Cliente",
        ref: "Referencia",
        total: "Total",
        food: "Pedido",
        quantity: "Cantidad",
        price: "Precio",
        observations: "Observaciones",
        method: "Método de pago",
        document: "Documento",
        amount: "Monto",
        description: "Descripción"
      },
      columns: [],
      pagination: {
        current_page: 1,
        per_page: 10,
        total: 0
      },
      search: {
        column: "",
        value: ""
      },
      events: {
        create: "Creación",
        update: "Actualización",
        "delete": "Eliminación"
      },
      models: {
        orden: "Orden",
        ordenItem: "Item de orden",
        table: "Mesa",
        document: "Documento",
        saleNote: "Nota de venta",
        box: "Caja"
      }
    };
  },
  created: function created() {
    this.getRecords();
    this.getColumns();
    this.getTables();
  },
  filters: {},
  methods: {
    formatValue: function formatValue(value, propertie) {
      if (propertie == 'price') {
        if (!isNaN(value)) {
          return parseFloat(value).toFixed(2);
        }
      }

      return value;
    },
    getTables: function getTables() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _context.next = 3;
                return _this.$http.get("/".concat(_this.resource, "/tables"));

              case 3:
                response = _context.sent;
                console.log(response);

                if (response.status === 200) {
                  _this.users = response.data.users;
                }

                _context.next = 11;
                break;

              case 8:
                _context.prev = 8;
                _context.t0 = _context["catch"](0);
                console.log(_context.t0);

              case 11:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 8]]);
      }))();
    },
    getQueryParameters: function getQueryParameters() {
      return __WEBPACK_IMPORTED_MODULE_2_query_string___default.a.stringify({
        page: this.pagination.current_page,
        limit: this.limit,
        value: this.search.value,
        column: this.search.column
      });
    },
    customIndex: function customIndex(index) {
      return this.pagination.per_page * (this.pagination.current_page - 1) + index + 1;
    },
    getColumns: function getColumns() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _context2.next = 3;
                return _this2.$http.get("/".concat(_this2.resource, "/columns"));

              case 3:
                response = _context2.sent;
                console.log(response);

                if (response.status === 200) {
                  _this2.columns = response.data;
                }

                _context2.next = 11;
                break;

              case 8:
                _context2.prev = 8;
                _context2.t0 = _context2["catch"](0);
                console.log(_context2.t0);

              case 11:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[0, 8]]);
      }))();
    },
    getRecords: function getRecords() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.realTime = false;
                _this3.recordsRealTime = [];
                _context3.prev = 2;
                _this3.loading = true;
                _context3.next = 6;
                return _this3.$http.get("/".concat(_this3.resource, "/records?").concat(_this3.getQueryParameters()));

              case 6:
                response = _context3.sent;

                if (response.status === 200) {
                  _this3.records = response.data.data;
                  _this3.pagination = response.data.meta;
                  _this3.pagination.per_page = parseInt(response.data.meta.per_page);
                }

                _context3.next = 13;
                break;

              case 10:
                _context3.prev = 10;
                _context3.t0 = _context3["catch"](2);
                console.log(_context3.t0);

              case 13:
                _context3.prev = 13;
                _this3.loading = false;
                return _context3.finish(13);

              case 16:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[2, 10, 13, 16]]);
      }))();
    }
  },
  mounted: function mounted() {
    var _this4 = this;

    Echo.channel("register").listen(".register-".concat(this.configuration.socket_channel), function (e) {
      console.log("imprimiendo", e);

      _this4.recordsRealTime.unshift(e.register);

      _this4.recordsRealTime = _this4.recordsRealTime.slice(0, 20);
    });
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-26710204\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/registers/index.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.detalles-wrap {\r\n    white-space: nowrap;\n}\n.detalle {\r\n    display: inline-block;\r\n    margin-right: 10px;\n}\n.registers_event td {\r\n    color: #fff !important;\n}\n.fade-enter-active,\r\n.fade-leave-active {\r\n    -webkit-transition: opacity 1s ease-in-out;\r\n    transition: opacity 1s ease-in-out;\n}\n.fade-enter,\r\n.fade-leave-to {\r\n    opacity: 0;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/resources/js/views/registers/resources/js/views/registers/index.vue"],"names":[],"mappings":";AAwTA;IACA,oBAAA;CACA;AAEA;IACA,sBAAA;IACA,mBAAA;CACA;AAEA;IACA,uBAAA;CACA;AACA;;IAEA,2CAAA;IAAA,mCAAA;CACA;AAEA;;IAEA,WAAA;CACA","file":"index.vue","sourcesContent":["<template>\r\n    <div>\r\n        <div class=\"container-fluid p-l-0 p-r-0\">\r\n            <div class=\"page-header\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-sm-6\">\r\n                        <h6><span>Registros de actividades</span></h6>\r\n                        <ol class=\"breadcrumb\">\r\n                            <li class=\"breadcrumb-item\">\r\n                                <a href=\"/dashboard\">Registros</a>\r\n                            </li>\r\n                            <li class=\"breadcrumb-item active\">\r\n                                <span class=\"text-muted\">Actividades</span>\r\n                            </li>\r\n                        </ol>\r\n                    </div>\r\n                    <div class=\"col-sm-6 d-flex justify-content-end\">\r\n                        <div class=\"bookmark\">\r\n                            <el-tooltip\r\n                                class=\"item\"\r\n                                effect=\"dark\"\r\n                                content=\"Operaciones\"\r\n                                placement=\"bottom-end\"\r\n                            >\r\n                                <template v-if=\"realTime\">\r\n                                    <button\r\n                                        @click=\"getRecords\"\r\n                                        class=\"btn btn-primary btn-icon btn-icon-start\"\r\n                                    >\r\n                                        Salir de tiempo real\r\n                                    </button>\r\n                                </template>\r\n                                <template v-else>\r\n                                    <button\r\n                                        @click=\"realTime = true\"\r\n                                        class=\"btn btn-success btn-icon btn-icon-start\"\r\n                                    >\r\n                                        Ver en tiempo real\r\n                                    </button>\r\n                                </template>\r\n                            </el-tooltip>\r\n                        </div>\r\n                        <!-- Bookmark Ends-->\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <!-- Container-fluid starts-->\r\n        <div class=\"container-fluid p-l-0 p-r-0\">\r\n            <div class=\"card mb-0\">\r\n                <div class=\"card-body container table-responsive col-md-12\">\r\n                    <div v-if=\"!realTime\" class=\"row\">\r\n                        <div class=\"col-md-3\">\r\n                            <label>Filtro</label>\r\n                            <el-select\r\n                                v-model=\"search.column\"\r\n                                placeholder=\"Seleccione el filtro\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"(value, key) in columns\"\r\n                                    :key=\"key\"\r\n                                    :label=\"value\"\r\n                                    :value=\"key\"\r\n                                >\r\n                                </el-option>\r\n                            </el-select>\r\n                        </div>\r\n                        <div class=\"col-md-3\">\r\n                            <template\r\n                                v-if=\"search.column == 'event_description'\"\r\n                            >\r\n                                <label>\r\n                                    <i class=\"fa fas-search\"></i>\r\n                                </label>\r\n                                <el-select\r\n                                    clearable\r\n                                    filterable\r\n                                    v-model=\"search.value\"\r\n                                    placeholder=\"Seleccione el evento\"\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"(value, key) in events\"\r\n                                        :key=\"key\"\r\n                                        :label=\"value\"\r\n                                        :value=\"key\"\r\n                                    >\r\n                                    </el-option>\r\n                                </el-select>\r\n                            </template>\r\n                            <template v-else-if=\"search.column == 'model'\">\r\n                                <label>\r\n                                    <i class=\"fa fas-search\"></i>\r\n                                </label>\r\n                                <el-select\r\n                                    clearable\r\n                                    filterable\r\n                                    v-model=\"search.value\"\r\n                                    placeholder=\"Seleccione el evento\"\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"(value, key) in models\"\r\n                                        :key=\"key\"\r\n                                        :label=\"value\"\r\n                                        :value=\"key\"\r\n                                    >\r\n                                    </el-option>\r\n                                </el-select>\r\n                            </template>\r\n                            <template v-else-if=\"search.column == 'user_id'\">\r\n                                <label>\r\n                                    <i class=\"fa fas-search\"></i>\r\n                                </label>\r\n                                <el-select\r\n                                    clearable\r\n                                    filterable\r\n                                    v-model=\"search.value\"\r\n                                    placeholder=\"Seleccione un usuario\"\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"(value, key) in users\"\r\n                                        :key=\"key\"\r\n                                        :label=\"value.name\"\r\n                                        :value=\"value.id\"\r\n                                    >\r\n                                    </el-option>\r\n                                </el-select>\r\n                            </template>\r\n                            <template v-else>\r\n                                <label>\r\n                                    <i class=\"fa fas-search\"></i>\r\n                                </label>\r\n                                <el-input v-model=\"search.value\"> </el-input>\r\n                            </template>\r\n                        </div>\r\n                        <div class=\"col-md-3 d-flex align-items-end\">\r\n                            <el-button type=\"primary\" @click=\"getRecords\">\r\n                                Buscar\r\n                            </el-button>\r\n                        </div>\r\n                    </div>\r\n                    <div v-if=\"!realTime\">\r\n                        <el-pagination\r\n                            @current-change=\"getRecords\"\r\n                            layout=\"total, prev, pager, next\"\r\n                            :total=\"pagination.total\"\r\n                            :current-page.sync=\"pagination.current_page\"\r\n                            :page-size=\"pagination.per_page\"\r\n                        >\r\n                        </el-pagination>\r\n                    </div>\r\n                    <template v-if=\"realTime\">\r\n                        <table class=\"table table-hover table-striped table-condensed  table-responsive\" style=\"width: 100%; white-space: nowrap;\">\r\n                            <thead>\r\n                                <tr>\r\n                                    <th>Fecha</th>\r\n                                    <th>Usuario</th>\r\n                                    <th>Descripción</th>\r\n                                    <th>Detalle</th>\r\n                                    <th>Registro</th>\r\n                                </tr>\r\n                            </thead>\r\n\r\n                            <transition-group name=\"fade\" tag=\"tbody\">\r\n                                <tr\r\n                                    class=\"registers_event\"\r\n                                    v-for=\"record in recordsRealTime\"\r\n                                    :key=\"record.id\"\r\n                                    :class=\"\r\n                                        record.event == 'create'\r\n                                            ? 'bg-success'\r\n                                            : record.event == 'update'\r\n                                            ? 'bg-primary'\r\n                                            : 'bg-danger'\r\n                                    \"\r\n                                >\r\n                                    <td>\r\n                                        <h6 class=\"text-white\">\r\n                                            {{ record.time_of_issue }}\r\n                                        </h6>\r\n                                        <h5 class=\"text-white\">\r\n                                            {{ record.date_of_issue }}\r\n                                        </h5>\r\n                                    </td>\r\n                                    <td>\r\n                                        {{ record.user }}\r\n                                        <template v-if=\"record.ip\"><br />\r\n                                            <strong>IP: {{ record.ip }}</strong>\r\n                                        </template>\r\n                                        <template v-if=\"record.system\">\r\n                                            <br />\r\n                                            <strong\r\n                                                >Sistema:\r\n                                                {{ record.system }}</strong\r\n                                            >\r\n                                        </template>\r\n                                    </td>\r\n                                    <td>\r\n                                        {{ record.description }}\r\n                                    </td>\r\n                                    <td>\r\n                                        <div class=\"detalles-wrap\">\r\n                                            <div\r\n                                                :key=\"key\"\r\n                                                class=\"detalle\"\r\n                                                v-for=\"(value,\r\n                                                key) in record.detail\"\r\n                                            >\r\n                                                <strong\r\n                                                    class=\"h5 text-white\"\r\n                                                    style=\"text-transform: uppercase; font-weight: bold \"\r\n                                                    >{{\r\n                                                        translatePros[key]\r\n                                                    }}:</strong\r\n                                                >\r\n                                                <span class=\"h6 text-white \">\r\n                                                    {{ formatValue(value,key) }}\r\n                                                </span>\r\n                                            </div>\r\n                                        </div>\r\n                                    </td>\r\n                                    <td>\r\n                                        {{ record.event_description }}\r\n                                    </td>\r\n                                </tr>\r\n                            </transition-group>\r\n                        </table>\r\n                    </template>\r\n                    <template v-else>\r\n                        <table class=\"table table-hover table-striped table-condensed  table-responsive\" style=\"width: 100%; white-space: nowrap;\">\r\n                            <thead>\r\n                                <tr>\r\n                                    <th>Fecha</th>\r\n                                    <th>Usuario</th>\r\n                                    <th>Descripción</th>\r\n                                    <th>Detalle</th>\r\n                                    <th>Registro</th>\r\n                                </tr>\r\n                            </thead>\r\n\r\n                            <tbody class=\"registers_event\">\r\n                                <tr\r\n                                    v-for=\"(record, index) in records\"\r\n                                    :key=\"index\"\r\n                                    :class=\"\r\n                                        record.event == 'create'\r\n                                            ? 'bg-success'\r\n                                            : record.event == 'update'\r\n                                            ? 'bg-primary'\r\n                                            : 'bg-danger'\r\n                                    \"\r\n                                >\r\n                                    <td>\r\n                                        <h6 class=\"text-white\">\r\n                                            {{ record.time_of_issue }}\r\n                                        </h6>\r\n                                        <h5 class=\"text-white\">\r\n                                            {{ record.date_of_issue }}\r\n                                        </h5>\r\n                                    </td>\r\n                                    <td>{{ record.user }}\r\n   <template v-if=\"record.ip\"\r\n                                            ><br />\r\n                                            <strong>IP: {{ record.ip }}</strong>\r\n                                        </template>\r\n                                        <template v-if=\"record.system\">\r\n                                            <br />\r\n                                            <strong\r\n                                                >\r\n                                                Sistema:\r\n                                                {{ record.system }}</strong\r\n                                            >\r\n                                        </template>\r\n\r\n                                    </td>\r\n                                    <td>\r\n                                        {{ record.description }}\r\n                                    </td>\r\n                                    <td>\r\n                                        <div class=\"detalles-wrap\">\r\n                                            <div\r\n                                                :key=\"key\"\r\n                                                class=\"detalle\"\r\n                                                v-for=\"(value,\r\n                                                key) in record.detail\"\r\n                                            >\r\n                                                <strong\r\n                                                    v-if=\"value\"\r\n                                                    class=\"h5 text-white\"\r\n                                                    style=\"text-transform: uppercase; font-weight: bold \"\r\n                                                    >{{\r\n                                                        translatePros[key]\r\n                                                    }}:</strong\r\n                                                >\r\n                                                <span class=\"h6 text-white \">\r\n                                                    {{ formatValue(value,key) }}\r\n                                                </span>\r\n                                            </div>\r\n                                        </div>\r\n                                    </td>\r\n                                    <td>\r\n                                        {{ record.event_description }}\r\n                                    </td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>\r\n                    </template>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</template>\r\n<style>\r\n.detalles-wrap {\r\n    white-space: nowrap;\r\n}\r\n\r\n.detalle {\r\n    display: inline-block;\r\n    margin-right: 10px;\r\n}\r\n\r\n.registers_event td {\r\n    color: #fff !important;\r\n}\r\n.fade-enter-active,\r\n.fade-leave-active {\r\n    transition: opacity 1s ease-in-out;\r\n}\r\n\r\n.fade-enter,\r\n.fade-leave-to {\r\n    opacity: 0;\r\n}\r\n</style>\r\n<script>\r\nimport { deletable } from \"../../mixins/deletable\";\r\nimport queryString from \"query-string\";\r\nexport default {\r\n    props: [\"configuration\", \"user_type\"],\r\n    mixins: [deletable],\r\n    components: {},\r\n    data() {\r\n        return {\r\n            realTime: false,\r\n            loading: false,\r\n            records: [],\r\n            recordsRealTime: [],\r\n            users: [],\r\n            resource: \"registers\",\r\n            translatePros: {\r\n                number: \"Número\",\r\n                table: \"Zona\",\r\n                area: \"Área\",\r\n                customer: \"Cliente\",\r\n                ref: \"Referencia\",\r\n                total: \"Total\",\r\n                food: \"Pedido\",\r\n                quantity: \"Cantidad\",\r\n                price: \"Precio\",\r\n                observations: \"Observaciones\",\r\n                method: \"Método de pago\",\r\n                document: \"Documento\",\r\n                amount: \"Monto\",\r\n                description: \"Descripción\"\r\n            },\r\n            columns: [],\r\n            pagination: {\r\n                current_page: 1,\r\n                per_page: 10,\r\n                total: 0\r\n            },\r\n            search: {\r\n                column: \"\",\r\n                value: \"\"\r\n            },\r\n            events: {\r\n                create: \"Creación\",\r\n                update: \"Actualización\",\r\n                delete: \"Eliminación\"\r\n            },\r\n            models: {\r\n                orden: \"Orden\",\r\n                ordenItem: \"Item de orden\",\r\n                table: \"Mesa\",\r\n                document: \"Documento\",\r\n                saleNote: \"Nota de venta\",\r\n                box: \"Caja\"\r\n            }\r\n        };\r\n    },\r\n    created() {\r\n        this.getRecords();\r\n        this.getColumns();\r\n        this.getTables();\r\n    },\r\n\r\n    filters: {},\r\n    methods: {\r\n        formatValue(value,propertie) {\r\n            if(propertie == 'price'){\r\n                 if (!isNaN(value)) {\r\n                return parseFloat(value).toFixed(2);\r\n            }\r\n            }\r\n            return value;\r\n        },\r\n        async getTables() {\r\n            try {\r\n                const response = await this.$http.get(\r\n                    `/${this.resource}/tables`\r\n                );\r\n                console.log(response);\r\n                if (response.status === 200) {\r\n                    this.users = response.data.users;\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n            }\r\n        },\r\n        getQueryParameters() {\r\n            return queryString.stringify({\r\n                page: this.pagination.current_page,\r\n                limit: this.limit,\r\n                value: this.search.value,\r\n                column: this.search.column\r\n            });\r\n        },\r\n        customIndex(index) {\r\n            return (\r\n                this.pagination.per_page * (this.pagination.current_page - 1) +\r\n                index +\r\n                1\r\n            );\r\n        },\r\n        async getColumns() {\r\n            try {\r\n                const response = await this.$http.get(\r\n                    `/${this.resource}/columns`\r\n                );\r\n                console.log(response);\r\n                if (response.status === 200) {\r\n                    this.columns = response.data;\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n            }\r\n        },\r\n        async getRecords() {\r\n            this.realTime = false;\r\n            this.recordsRealTime = [];\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.get(\r\n                    `/${this.resource}/records?${this.getQueryParameters()}`\r\n                );\r\n                if (response.status === 200) {\r\n                    this.records = response.data.data;\r\n                    this.pagination = response.data.meta;\r\n                    this.pagination.per_page = parseInt(\r\n                        response.data.meta.per_page\r\n                    );\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        }\r\n    },\r\n    mounted() {\r\n        Echo.channel(\"register\").listen(\r\n            `.register-${this.configuration.socket_channel}`,\r\n            e => {\r\n                console.log(\"imprimiendo\", e);\r\n\r\n                this.recordsRealTime.unshift(e.register);\r\n                this.recordsRealTime = this.recordsRealTime.slice(0, 20);\r\n            }\r\n        );\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-26710204\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/registers/index.vue":
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
                  "el-tooltip",
                  {
                    staticClass: "item",
                    attrs: {
                      effect: "dark",
                      content: "Operaciones",
                      placement: "bottom-end"
                    }
                  },
                  [
                    _vm.realTime
                      ? [
                          _c(
                            "button",
                            {
                              staticClass:
                                "btn btn-primary btn-icon btn-icon-start",
                              on: { click: _vm.getRecords }
                            },
                            [
                              _vm._v(
                                "\n                                     Salir de tiempo real\n                                 "
                              )
                            ]
                          )
                        ]
                      : [
                          _c(
                            "button",
                            {
                              staticClass:
                                "btn btn-success btn-icon btn-icon-start",
                              on: {
                                click: function($event) {
                                  _vm.realTime = true
                                }
                              }
                            },
                            [
                              _vm._v(
                                "\n                                     Ver en tiempo real\n                                 "
                              )
                            ]
                          )
                        ]
                  ],
                  2
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
      _c("div", { staticClass: "card mb-0" }, [
        _c(
          "div",
          { staticClass: "card-body container table-responsive col-md-12" },
          [
            !_vm.realTime
              ? _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "col-md-3" },
                    [
                      _c("label", [_vm._v("Filtro")]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: { placeholder: "Seleccione el filtro" },
                          model: {
                            value: _vm.search.column,
                            callback: function($$v) {
                              _vm.$set(_vm.search, "column", $$v)
                            },
                            expression: "search.column"
                          }
                        },
                        _vm._l(_vm.columns, function(value, key) {
                          return _c("el-option", {
                            key: key,
                            attrs: { label: value, value: key }
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
                    { staticClass: "col-md-3" },
                    [
                      _vm.search.column == "event_description"
                        ? [
                            _vm._m(1),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  clearable: "",
                                  filterable: "",
                                  placeholder: "Seleccione el evento"
                                },
                                model: {
                                  value: _vm.search.value,
                                  callback: function($$v) {
                                    _vm.$set(_vm.search, "value", $$v)
                                  },
                                  expression: "search.value"
                                }
                              },
                              _vm._l(_vm.events, function(value, key) {
                                return _c("el-option", {
                                  key: key,
                                  attrs: { label: value, value: key }
                                })
                              }),
                              1
                            )
                          ]
                        : _vm.search.column == "model"
                        ? [
                            _vm._m(2),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  clearable: "",
                                  filterable: "",
                                  placeholder: "Seleccione el evento"
                                },
                                model: {
                                  value: _vm.search.value,
                                  callback: function($$v) {
                                    _vm.$set(_vm.search, "value", $$v)
                                  },
                                  expression: "search.value"
                                }
                              },
                              _vm._l(_vm.models, function(value, key) {
                                return _c("el-option", {
                                  key: key,
                                  attrs: { label: value, value: key }
                                })
                              }),
                              1
                            )
                          ]
                        : _vm.search.column == "user_id"
                        ? [
                            _vm._m(3),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  clearable: "",
                                  filterable: "",
                                  placeholder: "Seleccione un usuario"
                                },
                                model: {
                                  value: _vm.search.value,
                                  callback: function($$v) {
                                    _vm.$set(_vm.search, "value", $$v)
                                  },
                                  expression: "search.value"
                                }
                              },
                              _vm._l(_vm.users, function(value, key) {
                                return _c("el-option", {
                                  key: key,
                                  attrs: { label: value.name, value: value.id }
                                })
                              }),
                              1
                            )
                          ]
                        : [
                            _vm._m(4),
                            _vm._v(" "),
                            _c("el-input", {
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
                  _c(
                    "div",
                    { staticClass: "col-md-3 d-flex align-items-end" },
                    [
                      _c(
                        "el-button",
                        {
                          attrs: { type: "primary" },
                          on: { click: _vm.getRecords }
                        },
                        [
                          _vm._v(
                            "\n                             Buscar\n                         "
                          )
                        ]
                      )
                    ],
                    1
                  )
                ])
              : _vm._e(),
            _vm._v(" "),
            !_vm.realTime
              ? _c(
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
                          return _vm.$set(
                            _vm.pagination,
                            "current_page",
                            $event
                          )
                        },
                        "update:current-page": function($event) {
                          return _vm.$set(
                            _vm.pagination,
                            "current_page",
                            $event
                          )
                        }
                      }
                    })
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.realTime
              ? [
                  _c(
                    "table",
                    {
                      staticClass:
                        "table table-hover table-striped table-condensed  table-responsive",
                      staticStyle: { width: "100%", "white-space": "nowrap" }
                    },
                    [
                      _vm._m(5),
                      _vm._v(" "),
                      _c(
                        "transition-group",
                        { attrs: { name: "fade", tag: "tbody" } },
                        _vm._l(_vm.recordsRealTime, function(record) {
                          return _c(
                            "tr",
                            {
                              key: record.id,
                              staticClass: "registers_event",
                              class:
                                record.event == "create"
                                  ? "bg-success"
                                  : record.event == "update"
                                  ? "bg-primary"
                                  : "bg-danger"
                            },
                            [
                              _c("td", [
                                _c("h6", { staticClass: "text-white" }, [
                                  _vm._v(
                                    "\n                                         " +
                                      _vm._s(record.time_of_issue) +
                                      "\n                                     "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("h5", { staticClass: "text-white" }, [
                                  _vm._v(
                                    "\n                                         " +
                                      _vm._s(record.date_of_issue) +
                                      "\n                                     "
                                  )
                                ])
                              ]),
                              _vm._v(" "),
                              _c(
                                "td",
                                [
                                  _vm._v(
                                    "\n                                     " +
                                      _vm._s(record.user) +
                                      "\n                                     "
                                  ),
                                  record.ip
                                    ? [
                                        _c("br"),
                                        _vm._v(" "),
                                        _c("strong", [
                                          _vm._v("IP: " + _vm._s(record.ip))
                                        ])
                                      ]
                                    : _vm._e(),
                                  _vm._v(" "),
                                  record.system
                                    ? [
                                        _c("br"),
                                        _vm._v(" "),
                                        _c("strong", [
                                          _vm._v(
                                            "Sistema:\n                                             " +
                                              _vm._s(record.system)
                                          )
                                        ])
                                      ]
                                    : _vm._e()
                                ],
                                2
                              ),
                              _vm._v(" "),
                              _c("td", [
                                _vm._v(
                                  "\n                                     " +
                                    _vm._s(record.description) +
                                    "\n                                 "
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c(
                                  "div",
                                  { staticClass: "detalles-wrap" },
                                  _vm._l(record.detail, function(value, key) {
                                    return _c(
                                      "div",
                                      { key: key, staticClass: "detalle" },
                                      [
                                        _c(
                                          "strong",
                                          {
                                            staticClass: "h5 text-white",
                                            staticStyle: {
                                              "text-transform": "uppercase",
                                              "font-weight": "bold"
                                            }
                                          },
                                          [
                                            _vm._v(
                                              _vm._s(_vm.translatePros[key]) +
                                                ":"
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "span",
                                          { staticClass: "h6 text-white " },
                                          [
                                            _vm._v(
                                              "\n                                                 " +
                                                _vm._s(
                                                  _vm.formatValue(value, key)
                                                ) +
                                                "\n                                             "
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  }),
                                  0
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _vm._v(
                                  "\n                                     " +
                                    _vm._s(record.event_description) +
                                    "\n                                 "
                                )
                              ])
                            ]
                          )
                        }),
                        0
                      )
                    ],
                    1
                  )
                ]
              : [
                  _c(
                    "table",
                    {
                      staticClass:
                        "table table-hover table-striped table-condensed  table-responsive",
                      staticStyle: { width: "100%", "white-space": "nowrap" }
                    },
                    [
                      _vm._m(6),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        { staticClass: "registers_event" },
                        _vm._l(_vm.records, function(record, index) {
                          return _c(
                            "tr",
                            {
                              key: index,
                              class:
                                record.event == "create"
                                  ? "bg-success"
                                  : record.event == "update"
                                  ? "bg-primary"
                                  : "bg-danger"
                            },
                            [
                              _c("td", [
                                _c("h6", { staticClass: "text-white" }, [
                                  _vm._v(
                                    "\n                                         " +
                                      _vm._s(record.time_of_issue) +
                                      "\n                                     "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("h5", { staticClass: "text-white" }, [
                                  _vm._v(
                                    "\n                                         " +
                                      _vm._s(record.date_of_issue) +
                                      "\n                                     "
                                  )
                                ])
                              ]),
                              _vm._v(" "),
                              _c(
                                "td",
                                [
                                  _vm._v(_vm._s(record.user) + "\n"),
                                  record.ip
                                    ? [
                                        _c("br"),
                                        _vm._v(" "),
                                        _c("strong", [
                                          _vm._v("IP: " + _vm._s(record.ip))
                                        ])
                                      ]
                                    : _vm._e(),
                                  _vm._v(" "),
                                  record.system
                                    ? [
                                        _c("br"),
                                        _vm._v(" "),
                                        _c("strong", [
                                          _vm._v(
                                            "\n                                             Sistema:\n                                             " +
                                              _vm._s(record.system)
                                          )
                                        ])
                                      ]
                                    : _vm._e()
                                ],
                                2
                              ),
                              _vm._v(" "),
                              _c("td", [
                                _vm._v(
                                  "\n                                     " +
                                    _vm._s(record.description) +
                                    "\n                                 "
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c(
                                  "div",
                                  { staticClass: "detalles-wrap" },
                                  _vm._l(record.detail, function(value, key) {
                                    return _c(
                                      "div",
                                      { key: key, staticClass: "detalle" },
                                      [
                                        value
                                          ? _c(
                                              "strong",
                                              {
                                                staticClass: "h5 text-white",
                                                staticStyle: {
                                                  "text-transform": "uppercase",
                                                  "font-weight": "bold"
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  _vm._s(
                                                    _vm.translatePros[key]
                                                  ) + ":"
                                                )
                                              ]
                                            )
                                          : _vm._e(),
                                        _vm._v(" "),
                                        _c(
                                          "span",
                                          { staticClass: "h6 text-white " },
                                          [
                                            _vm._v(
                                              "\n                                                 " +
                                                _vm._s(
                                                  _vm.formatValue(value, key)
                                                ) +
                                                "\n                                             "
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  }),
                                  0
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _vm._v(
                                  "\n                                     " +
                                    _vm._s(record.event_description) +
                                    "\n                                 "
                                )
                              ])
                            ]
                          )
                        }),
                        0
                      )
                    ]
                  )
                ]
          ],
          2
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6" }, [
      _c("h6", [_c("span", [_vm._v("Registros de actividades")])]),
      _vm._v(" "),
      _c("ol", { staticClass: "breadcrumb" }, [
        _c("li", { staticClass: "breadcrumb-item" }, [
          _c("a", { attrs: { href: "/dashboard" } }, [_vm._v("Registros")])
        ]),
        _vm._v(" "),
        _c("li", { staticClass: "breadcrumb-item active" }, [
          _c("span", { staticClass: "text-muted" }, [_vm._v("Actividades")])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("i", { staticClass: "fa fas-search" })])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("i", { staticClass: "fa fas-search" })])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("i", { staticClass: "fa fas-search" })])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("i", { staticClass: "fa fas-search" })])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("Fecha")]),
        _vm._v(" "),
        _c("th", [_vm._v("Usuario")]),
        _vm._v(" "),
        _c("th", [_vm._v("Descripción")]),
        _vm._v(" "),
        _c("th", [_vm._v("Detalle")]),
        _vm._v(" "),
        _c("th", [_vm._v("Registro")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("Fecha")]),
        _vm._v(" "),
        _c("th", [_vm._v("Usuario")]),
        _vm._v(" "),
        _c("th", [_vm._v("Descripción")]),
        _vm._v(" "),
        _c("th", [_vm._v("Detalle")]),
        _vm._v(" "),
        _c("th", [_vm._v("Registro")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-26710204", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-35cdae61\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/check_stock.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
      _c("div", { staticClass: "page-header" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-12" },
            [
              _c("label", { attrs: { for: "link" } }, [_vm._v("Url")]),
              _vm._v(" "),
              _c("el-input", {
                model: {
                  value: _vm.linkpdf,
                  callback: function($$v) {
                    _vm.linkpdf = $$v
                  },
                  expression: "linkpdf"
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-md-4", attrs: { "col-12": "" } },
            [
              _c("label", { attrs: { for: "density" } }, [_vm._v("Densidad")]),
              _vm._v(" "),
              _c("el-input", {
                attrs: { type: "number" },
                model: {
                  value: _vm.config.density,
                  callback: function($$v) {
                    _vm.$set(_vm.config, "density", $$v)
                  },
                  expression: "config.density"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 col-12" },
            [
              _c("label", { attrs: { for: "density" } }, [_vm._v("Impresora")]),
              _vm._v(" "),
              _c("el-input", {
                model: {
                  value: _vm.printer,
                  callback: function($$v) {
                    _vm.printer = $$v
                  },
                  expression: "printer"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 col-12" },
            [
              _c("label", { attrs: { for: "orientation" } }, [
                _vm._v("Orientación")
              ]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  model: {
                    value: _vm.config.orientation,
                    callback: function($$v) {
                      _vm.$set(_vm.config, "orientation", $$v)
                    },
                    expression: "config.orientation"
                  }
                },
                [
                  _c("el-option", {
                    attrs: { label: "Vertical", value: "portrait" }
                  }),
                  _vm._v(" "),
                  _c("el-option", {
                    attrs: { label: "Horizontal", value: "landscape" }
                  })
                ],
                1
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-md-3 col-12" },
            [
              _c("label", { attrs: { for: "top" } }, [_vm._v("Arriba")]),
              _vm._v(" "),
              _c("el-input", {
                attrs: { type: "number" },
                model: {
                  value: _vm.config.margins.top,
                  callback: function($$v) {
                    _vm.$set(_vm.config.margins, "top", $$v)
                  },
                  expression: "config.margins.top"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-3 col-12" },
            [
              _c("label", { attrs: { for: "left" } }, [_vm._v("Izquierda")]),
              _vm._v(" "),
              _c("el-input", {
                attrs: { type: "number" },
                model: {
                  value: _vm.config.margins.left,
                  callback: function($$v) {
                    _vm.$set(_vm.config.margins, "left", $$v)
                  },
                  expression: "config.margins.left"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-3 col-12" },
            [
              _c("label", { attrs: { for: "right" } }, [_vm._v("Derecha")]),
              _vm._v(" "),
              _c("el-input", {
                attrs: { type: "number" },
                model: {
                  value: _vm.config.margins.right,
                  callback: function($$v) {
                    _vm.$set(_vm.config.margins, "right", $$v)
                  },
                  expression: "config.margins.right"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-3 col-12" },
            [
              _c("label", { attrs: { for: "bottom" } }, [_vm._v("Abajo")]),
              _vm._v(" "),
              _c("el-input", {
                attrs: { type: "number" },
                model: {
                  value: _vm.config.margins.bottom,
                  callback: function($$v) {
                    _vm.$set(_vm.config.margins, "bottom", $$v)
                  },
                  expression: "config.margins.bottom"
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _c(
            "div",
            { staticClass: "col-md-3 col-12" },
            [
              _c(
                "el-button",
                {
                  attrs: { type: "primary" },
                  on: {
                    click: function($event) {
                      return _vm.Printer("zebra")
                    }
                  }
                },
                [_vm._v("\n                    Imprimir\n                ")]
              )
            ],
            1
          )
        ])
      ])
    ]),
    _vm._v(" "),
    _vm._m(1)
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-sm-6" }, [
        _c("h6", [_c("span", [_vm._v("Productos")])]),
        _vm._v(" "),
        _c("ol", { staticClass: "breadcrumb" }, [
          _c("li", { staticClass: "breadcrumb-item" }, [
            _c("a", { attrs: { href: "/dashboard" } }, [_vm._v("Dashboard")])
          ]),
          _vm._v(" "),
          _c("li", { staticClass: "breadcrumb-item active" }, [
            _c("span", { staticClass: "text-muted" }, [
              _vm._v("Verificar stock de Productos")
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
    return _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
      _c("table", { staticClass: "table table-responsive" })
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-35cdae61", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-26710204\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/registers/index.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-26710204\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/registers/index.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("81eae910", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js?sourceMap!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-26710204\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./index.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js?sourceMap!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-26710204\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./index.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/js/views/items/check_stock.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/check_stock.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-35cdae61\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/check_stock.vue")
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
Component.options.__file = "resources/js/views/items/check_stock.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-35cdae61", Component.options)
  } else {
    hotAPI.reload("data-v-35cdae61", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/registers/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-26710204\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/registers/index.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/registers/index.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-26710204\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/registers/index.vue")
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
Component.options.__file = "resources/js/views/registers/index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-26710204", Component.options)
  } else {
    hotAPI.reload("data-v-26710204", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=tenant-registers-index.js.map