webpackJsonp([59],{

/***/ "./modules/Restaurant/Resources/assets/js/views/configuration/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/configuration/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-07de1de4\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/configuration/form.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/configuration/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-07de1de4", Component.options)
  } else {
    hotAPI.reload("data-v-07de1de4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./modules/Restaurant/Resources/assets/js/views/configuration/items.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/configuration/items.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-c38a0634\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/configuration/items.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/configuration/items.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-c38a0634", Component.options)
  } else {
    hotAPI.reload("data-v-c38a0634", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/configuration/form.vue":
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["showDialog", "recordId", "type", "areas", "statusTable", "configurations"],
  data: function data() {
    return {
      loading_submit: false,
      titleDialog: null,
      resource: this.type,
      errors: {},
      form: {},
      options: []
    };
  },
  created: function created() {
    this.initForm();
  },
  methods: {
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        id: null,
        description: null,
        printer: null,
        copies: null,
        active: 1
      };
    },
    create: function create() {
      var _this = this;

      this.titleDialog = this.recordId ? "Modificar Registro" : "Nuevo Registro";
      console.log("this.recordId", this.recordId);
      this.initForm();

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this.form = response.data.data;
        });
      }
    },
    submit: function submit() {
      var _this2 = this;

      this.loading_submit = true;
      this.$http.post("/".concat(this.resource), this.form).then(function (response) {
        if (response.data.success) {
          _this2.$toast.success(response.data.message);

          _this2.$eventHub.$emit("reloadData");

          _this2.close();
        } else {
          _this2.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this2.errors = error.response.data;
        } else {
          console.log(error);
        }
      }).then(function () {
        _this2.loading_submit = false;
      });
    },
    close: function close() {
      this.$emit("update:showDialog", false);
      this.initForm();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/configuration/items.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__form_vue__ = __webpack_require__("./modules/Restaurant/Resources/assets/js/views/configuration/form.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__form_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__form_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__resources_js_components_DataTable_vue__ = __webpack_require__("./resources/js/components/DataTable.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__resources_js_components_DataTable_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__resources_js_components_DataTable_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__resources_js_mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_query_string__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

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




/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["type", "title", "configurations"],
  mixins: [__WEBPACK_IMPORTED_MODULE_3__resources_js_mixins_deletable__["a" /* deletable */]],
  components: {
    DataTable: __WEBPACK_IMPORTED_MODULE_2__resources_js_components_DataTable_vue___default.a,
    CreateForm: __WEBPACK_IMPORTED_MODULE_1__form_vue___default.a
  },
  data: function data() {
    return {
      showDialog: false,
      resource: this.type,
      recordId: null,
      areas: [],
      statusTable: [],
      ascending: false,
      sortColumn: "",
      search: {
        column: null,
        value: null
      },
      active_column: "",
      columns: [],
      records: [],
      pagination: {},
      loading_data: false,
      disabled_next: false,
      disabled_previos: false,
      myOptions: ["op1", "op2", "op3"]
    };
  },
  created: function created() {
    var _this = this;

    if (this.type == "restaurant/tables") {
      this.getTables();
    } // this.getData();


    this.$eventHub.$on("reloadData", function () {
      _this.getData(); //   this.recordId =null

    });
  },
  methods: {
    getQueryParameters: function getQueryParameters() {
      return __WEBPACK_IMPORTED_MODULE_4_query_string___default.a.stringify(_objectSpread({
        page: this.pagination.current_page,
        limit: this.limit
      }, this.search));
    },
    getData: function getData() {
      var _arguments = arguments,
          _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var page;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                page = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : 1;
                _this2.pagination.current_page = parseInt(page);
                _this2.pagination.per_page = parseInt(page);
                _this2.loading_data = true;
                return _context.abrupt("return", _this2.$http.get("/".concat(_this2.resource, "/records?").concat(_this2.getQueryParameters())).then(function (response) {
                  _this2.records = response.data.data;
                  _this2.pagination = response.data.meta;
                  _this2.pagination.per_page = parseInt(response.data.meta.per_page);
                  _this2.loading_data = false;
                }));

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getTables: function getTables() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this3.$http.get("/restaurant/areas/records?column=description&page=1&value");

              case 2:
                response = _context2.sent;
                _this3.areas = response.data.data;
                _context2.next = 6;
                return _this3.$http.get("/restaurant/status-tables/records?column=description&page=1&value");

              case 6:
                response = _context2.sent;
                _this3.statusTable = response.data.data;

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    updateSearchPrint: function updateSearchPrint(row) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.prev = 0;
                _this4.loading_data = true;
                _context3.next = 4;
                return _this4.$http.post("/".concat(_this4.resource), row);

              case 4:
                response = _context3.sent;

                if (response.status == 200) {
                  _this4.$toast.success("Area actualizada");
                } else {
                  _this4.$toast.warning("Ocurrió un error");
                }

                _context3.next = 12;
                break;

              case 8:
                _context3.prev = 8;
                _context3.t0 = _context3["catch"](0);
                console.log(_context3.t0);

                _this4.$toast.error("error");

              case 12:
                _context3.prev = 12;
                _this4.loading_data = false;
                return _context3.finish(12);

              case 15:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[0, 8, 12, 15]]);
      }))();
    },
    clickCreate: function clickCreate() {
      var recordId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.recordId = recordId;
      this.showDialog = true;
    },
    clickDelete: function clickDelete(id) {
      var _this5 = this;

      this.destroy("/".concat(this.resource, "/").concat(id)).then(function () {
        return _this5.$eventHub.$emit("reloadData");
      });
    }
  }
});

/***/ }),

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


/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
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
    }
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

      console.log(this.search);

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
        column: this.search.column
      });
    },
    changeClearInput: function changeClearInput() {
      this.search.value = "";
      this.getRecords();
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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-07de1de4\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/configuration/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: { title: _vm.titleDialog, visible: _vm.showDialog },
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
            _c(
              "div",
              { staticClass: "row" },
              [
                _vm.type !== "restaurant/tables"
                  ? _c("div", { staticClass: "col-md-12" }, [
                      _c(
                        "div",
                        {
                          staticClass: "form-group",
                          class: { "has-danger": _vm.errors.description }
                        },
                        [
                          _c("label", { staticClass: "control-label" }, [
                            _vm._v("Descripción")
                          ]),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form.description,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "description", $$v)
                              },
                              expression: "form.description"
                            }
                          }),
                          _vm._v(" "),
                          _vm.errors.description
                            ? _c("small", {
                                staticClass: "text-danger",
                                domProps: {
                                  textContent: _vm._s(_vm.errors.description[0])
                                }
                              })
                            : _vm._e()
                        ],
                        1
                      )
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.type == "restaurant/areas" &&
                _vm.configurations.multiple_boxes === 1
                  ? _c("div", { staticClass: "col-md-6" }, [
                      _c(
                        "div",
                        {
                          staticClass: "form-group",
                          class: { "has-danger": _vm.errors.printer }
                        },
                        [
                          _c("label", { staticClass: "control-label" }, [
                            _vm._v("Impresora")
                          ]),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form.printer,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "printer", $$v)
                              },
                              expression: "form.printer"
                            }
                          }),
                          _vm._v(" "),
                          _vm.errors.printer
                            ? _c("small", {
                                staticClass: "text-danger",
                                domProps: {
                                  textContent: _vm._s(_vm.errors.printer[0])
                                }
                              })
                            : _vm._e()
                        ],
                        1
                      )
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.type == "restaurant/areas" &&
                _vm.configurations.multiple_boxes === 1
                  ? _c("div", { staticClass: "col-md-6" }, [
                      _c(
                        "div",
                        {
                          staticClass: "form-group",
                          class: { "has-danger": _vm.errors.printer }
                        },
                        [
                          _c("label", { staticClass: "control-label" }, [
                            _vm._v("Nº COPIAS")
                          ]),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form.copies,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "copies", $$v)
                              },
                              expression: "form.copies"
                            }
                          }),
                          _vm._v(" "),
                          _vm.errors.copies
                            ? _c("small", {
                                staticClass: "text-danger",
                                domProps: {
                                  textContent: _vm._s(_vm.errors.copies[0])
                                }
                              })
                            : _vm._e()
                        ],
                        1
                      )
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.type == "restaurant/tables"
                  ? [
                      _c("div", { staticClass: "col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: { "has-danger": _vm.errors.number }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Número de mesa")
                            ]),
                            _vm._v(" "),
                            _c("el-input", {
                              model: {
                                value: _vm.form.number,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "number", $$v)
                                },
                                expression: "form.number"
                              }
                            }),
                            _vm._v(" "),
                            _vm.errors.number
                              ? _c("small", {
                                  staticClass: "form-control-feedback",
                                  domProps: {
                                    textContent: _vm._s(_vm.errors.number[0])
                                  }
                                })
                              : _vm._e()
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
                              "has-danger": _vm.errors.status_table_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Estado de mesa")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                model: {
                                  value: _vm.form.status_table_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "status_table_id", $$v)
                                  },
                                  expression: "form.status_table_id"
                                }
                              },
                              _vm._l(_vm.statusTable, function(data, index) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: {
                                    label: data.description,
                                    value: data.id
                                  }
                                })
                              }),
                              1
                            ),
                            _vm._v(" "),
                            _vm.errors.status_table_id
                              ? _c("small", {
                                  staticClass: "form-control-feedback",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.status_table_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
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
                            class: { "has-danger": _vm.errors.area_id }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Área de mesa")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                model: {
                                  value: _vm.form.area_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "area_id", $$v)
                                  },
                                  expression: "form.area_id"
                                }
                              },
                              _vm._l(_vm.areas, function(data, index) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: {
                                    label: data.description,
                                    value: data.id
                                  }
                                })
                              }),
                              1
                            ),
                            _vm._v(" "),
                            _vm.errors.area_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(_vm.errors.area_id[0])
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    ]
                  : _vm._e()
              ],
              2
            )
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
    require("vue-hot-reload-api")      .rerender("data-v-07de1de4", module.exports)
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
              _c("div", { staticClass: "col-lg-4 col-md-4 col-sm-12 pb-2" }, [
                _c(
                  "div",
                  { staticClass: "d-flex" },
                  [
                    _c("div", { staticStyle: { width: "100px" } }, [
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
                )
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-lg-3 col-md-4 col-sm-12 pb-2" },
                [
                  _vm.search.column == "date_of_issue" ||
                  _vm.search.column == "date_of_due" ||
                  _vm.search.column == "date_of_payment" ||
                  _vm.search.column == "delivery_date" ||
                  _vm.search.column == "date"
                    ? [
                        _vm.resource != "restaurant/worker/expenses"
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
              )
            ])
          : _vm._e()
      ]),
      _vm._v(" "),
      _vm.resource == "restaurant/worker/expenses" && _vm.records.length != 0
        ? _c("div", { staticClass: "row" }, [
            _c(
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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-c38a0634\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/configuration/items.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
      _c("div", { staticClass: "page-header" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-sm-6" }, [
            _c("h6", [_c("span", [_vm._v(_vm._s(_vm.title))])]),
            _vm._v(" "),
            _c("ol", { staticClass: "breadcrumb" }, [
              _c("li", { staticClass: "breadcrumb-item" }, [
                _c("a", { attrs: { href: "/dashboard" } }, [
                  _vm._v(_vm._s(_vm.title))
                ])
              ]),
              _vm._v(" "),
              _vm._m(0)
            ])
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "col-12 col-md-6 d-flex align-items-start justify-content-end"
            },
            [
              _c(
                "button",
                {
                  staticClass:
                    "btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto",
                  attrs: { type: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.clickCreate()
                    }
                  }
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
          _c("div", { staticClass: "card-header bg-primary" }, [
            _c("h6", { staticClass: "my-0 text-white" }, [
              _vm._v("Listado de " + _vm._s(_vm.title))
            ])
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "card-body" },
            [
              _c(
                "data-table",
                {
                  attrs: { resource: _vm.resource },
                  scopedSlots: _vm._u([
                    {
                      key: "default",
                      fn: function(ref) {
                        var index = ref.index
                        var row = ref.row
                        return _c("tr", {}, [
                          _c("td", [_vm._v(_vm._s(index))]),
                          _vm._v(" "),
                          _vm.type != "restaurant/tables"
                            ? _c("td", [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(row.description) +
                                    "\n                        "
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.type == "restaurant/tables"
                            ? _c("td", [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(row.number) +
                                    "\n                        "
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.type == "restaurant/tables"
                            ? _c("td", [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(row.area.description) +
                                    "\n                        "
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.type == "restaurant/areas"
                            ? _c("td", [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(row.printer) +
                                    "\n                        "
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.type == "restaurant/areas"
                            ? _c(
                                "td",
                                [
                                  row.printer == null
                                    ? _c("el-switch", {
                                        on: {
                                          change: function($event) {
                                            return _vm.updateSearchPrint(row)
                                          }
                                        },
                                        model: {
                                          value: row.search_print,
                                          callback: function($$v) {
                                            _vm.$set(row, "search_print", $$v)
                                          },
                                          expression: "row.search_print"
                                        }
                                      })
                                    : _vm._e()
                                ],
                                1
                              )
                            : _vm._e(),
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
                                  "\n                                Editar\n                            "
                                )
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
                                    return _vm.clickDelete(row.id)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                Eliminar\n                            "
                                )
                              ]
                            )
                          ])
                        ])
                      }
                    }
                  ])
                },
                [
                  _c("tr", { attrs: { slot: "heading" }, slot: "heading" }, [
                    _c("th", [_vm._v("#")]),
                    _vm._v(" "),
                    _vm.type != "restaurant/tables"
                      ? _c("th", [
                          _vm._v(
                            "\n                            Descripción\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.type == "restaurant/tables"
                      ? _c("th", [
                          _vm._v(
                            "\n                            Número\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.type == "restaurant/tables"
                      ? _c("th", [
                          _vm._v(
                            "\n                            Área\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.type == "restaurant/areas"
                      ? _c("th", [
                          _vm._v(
                            "\n                            Impresora\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.type == "restaurant/areas"
                      ? _c("th", [
                          _vm._v(
                            "\n                            Forzar impresión\n                        "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-end" }, [_vm._v("Acciones")])
                  ]),
                  _vm._v(" "),
                  _c("tr")
                ]
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("create-form", {
            attrs: {
              showDialog: _vm.showDialog,
              areas: _vm.areas,
              type: _vm.type,
              configurations: _vm.configurations,
              recordId: _vm.recordId,
              statusTable: _vm.statusTable
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialog = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialog = $event
              },
              "update:configurations": function($event) {
                _vm.configurations = $event
              },
              "update:recordId": function($event) {
                _vm.recordId = $event
              },
              "update:record-id": function($event) {
                _vm.recordId = $event
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
    return _c("li", { staticClass: "breadcrumb-item active" }, [
      _c("span", { staticClass: "text-muted" }, [_vm._v("Marcas")])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-c38a0634", module.exports)
  }
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

/***/ "./resources/js/mixins/deletable.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return deletable; });
var deletable = {
  methods: {
    anular_comanda: function anular_comanda(url, number) {
      var _this = this;

      return new Promise(function (resolve) {
        _this.$confirm("¿Desea anular Comanda " + number + " seleccionada?", "Eliminar", {
          confirmButtonText: "Eliminar",
          cancelButtonText: "Cancelar",
          type: "warning"
        }).then(function () {
          _this.$http.get(url).then(function (res) {
            if (res.data.success) {
              _this.$message.success(res.data.message);

              resolve();
            } else {
              _this.$message.error(res.data.message);

              resolve();
            }
          })["catch"](function (error) {
            if (error.response.status === 500) {
              _this.$message.error("Error al intentar eliminar");
            } else {
              console.log(error.response.data.message);
            }
          });
        })["catch"](function (error) {
          console.log(error);
        });
      });
    },
    destroy: function destroy(url) {
      var _this2 = this;

      return new Promise(function (resolve) {
        _this2.$confirm("¿Desea eliminar el registro?", "Eliminar", {
          confirmButtonText: "Eliminar",
          cancelButtonText: "Cancelar",
          type: "warning"
        }).then(function () {
          _this2.$http["delete"](url).then(function (res) {
            console.log(res);

            if (res.data.success) {
              _this2.$message.success(res.data.message);

              resolve();
            } else {
              _this2.$message.error(res.data.message);

              resolve();
            }
          })["catch"](function (error) {
            if (error.response.status === 500) {
              _this2.$message.error("Error al intentar eliminar");
            } else {
              console.log(error.response.data.message);
            }
          });
        })["catch"](function (error) {
          console.log(error);
        });
      });
    },
    anular: function anular(url) {
      var _this3 = this;

      return new Promise(function (resolve) {
        _this3.$confirm("¿Desea anular el registro?", "Anular", {
          confirmButtonText: "Anular",
          cancelButtonText: "Cancelar",
          type: "warning"
        }).then(function () {
          _this3.$http.get(url).then(function (res) {
            if (res.data.success) {
              _this3.$message.success("Se anuló correctamente el registro");

              resolve();
            }
          })["catch"](function (error) {
            if (error.response.status === 500) {
              _this3.$message.error("Error al intentar anular");
            } else {
              console.log(error.response.data.message);
            }
          });
        })["catch"](function (error) {
          console.log(error);
        });
      });
    },
    "delete": function _delete(url) {
      var _this4 = this;

      return new Promise(function (resolve) {
        _this4.$confirm("¿Desea eliminar permanentemente el registro?", "Anular", {
          confirmButtonText: "Eliminar",
          cancelButtonText: "Cancelar",
          type: "warning"
        }).then(function () {
          _this4.$http.get(url).then(function (res) {
            if (res.data.success) {
              _this4.$message.success("Se anuló correctamente el registro");

              resolve();
            }
          })["catch"](function (error) {
            if (error.response.status === 500) {
              _this4.$message.error("Error al intentar anular");
            } else {
              console.log(error.response.data.message);
            }
          });
        })["catch"](function (error) {
          console.log(error);
        });
      });
    },
    disable: function disable(url) {
      var _this5 = this;

      return new Promise(function (resolve) {
        _this5.$confirm("¿Desea inhabilitar el registro?", "Inhabilitar", {
          confirmButtonText: "Inhabilitar",
          cancelButtonText: "Cancelar",
          type: "warning"
        }).then(function () {
          _this5.$http.get(url).then(function (res) {
            if (res.data.success) {
              _this5.$message.success(res.data.message);

              resolve();
            } else {
              _this5.$message.error(res.data.message);

              resolve();
            }
          })["catch"](function (error) {
            if (error.response.status === 500) {
              _this5.$message.error("Error al intentar inhabilitar");
            } else {
              console.log(error.response.data.message);
            }
          });
        })["catch"](function (error) {
          console.log(error);
        });
      });
    },
    enable: function enable(url) {
      var _this6 = this;

      return new Promise(function (resolve) {
        _this6.$confirm("¿Desea habilitar el registro?", "Habilitar", {
          confirmButtonText: "Habilitar",
          cancelButtonText: "Cancelar",
          type: "warning"
        }).then(function () {
          _this6.$http.get(url).then(function (res) {
            if (res.data.success) {
              _this6.$message.success(res.data.message);

              resolve();
            } else {
              _this6.$message.error(res.data.message);

              resolve();
            }
          })["catch"](function (error) {
            if (error.response.status === 500) {
              _this6.$message.error("Error al intentar habilitar");
            } else {
              console.log(error.response.data.message);
            }
          });
        })["catch"](function (error) {
          console.log(error);
        });
      });
    },
    voided: function voided(url) {
      var _this7 = this;

      return new Promise(function (resolve) {
        _this7.$confirm("¿Desea anular el registro?", "Anular", {
          confirmButtonText: "Anular",
          cancelButtonText: "Cancelar",
          type: "warning"
        }).then(function () {
          _this7.$http.get(url).then(function (res) {
            if (res.data.success) {
              _this7.$message.success(res.data.message);

              resolve();
            }
          })["catch"](function (error) {
            if (error.response.status === 500) {
              _this7.$message.error("Error al intentar anular");
            } else {
              console.log(error.response.data.message);
            }
          });
        })["catch"](function (error) {
          console.log(error);
        });
      });
    },
    updateStateType: function updateStateType(url) {
      var _this8 = this;

      return new Promise(function (resolve) {
        _this8.$confirm("¿Desea modificar el estado del registro?", "Modificar", {
          confirmButtonText: "Modificar",
          cancelButtonText: "Cancelar",
          type: "warning"
        }).then(function () {
          _this8.$http.get(url).then(function (res) {
            if (res.data.success) {
              _this8.$message.success(res.data.message);

              resolve();
            }
          })["catch"](function (error) {
            if (error.response.status === 500) {
              _this8.$message.error("Error al intentar modificar");
            } else {
              console.log(error.response.data.message);
            }
          });
        })["catch"](function (error) {
          console.log(error);

          _this8.$eventHub.$emit("reloadData");
        });
      });
    }
  }
};

/***/ })

});
//# sourceMappingURL=59.js.map