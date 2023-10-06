webpackJsonp([77],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/DataTablePersons.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_moment__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_query_string__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



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


/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    resource: String,
    applyFilter: {
      type: Boolean,
      "default": true,
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
      array_district: []
    };
  },
  computed: {},
  created: function created() {
    var _this = this;

    this.$eventHub.$on('reloadData', function () {
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
              column_resource = _.split(_this2.resource, "/"); // console.log(column_resource)

              _context.next = 3;
              return _this2.$http.get("/".concat(_.head(column_resource), "/columns")).then(function (response) {
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
    customIndex: function customIndex(index) {
      return this.pagination.per_page * (this.pagination.current_page - 1) + index + 1;
    },
    getRecords: function getRecords() {
      var _this3 = this;

      //   this.$http.get(`/filtrar_distritos/records`)
      // .then(response => {
      //     this.array_district = response.data.district
      // })
      return this.$http.get("/".concat(this.resource, "/records?").concat(this.getQueryParameters())).then(function (response) {
        _this3.records = response.data.data;
        _this3.pagination = response.data.meta;
        _this3.pagination.per_page = parseInt(response.data.meta.per_page);
      });
    },
    getQueryParameters: function getQueryParameters() {
      return __WEBPACK_IMPORTED_MODULE_2_query_string___default.a.stringify(_objectSpread({
        page: this.pagination.current_page,
        limit: this.limit
      }, this.search));
    },
    changeClearInput: function changeClearInput() {
      this.search.value = '';
      this.getRecords();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/commercial_treatment/index.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_DataTablePersons_vue__ = __webpack_require__("./resources/js/components/DataTablePersons.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_DataTablePersons_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_DataTablePersons_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
var CommercialTreatmentForm = function CommercialTreatmentForm() {
  return __webpack_require__.e/* import() */(172).then(__webpack_require__.bind(null, "./resources/js/views/commercial_treatment/form.vue"));
};

var Categories = function Categories() {
  return __webpack_require__.e/* import() */(173).then(__webpack_require__.bind(null, "./resources/js/views/commercial_treatment/categories.vue"));
};



/* harmony default export */ __webpack_exports__["default"] = ({
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_deletable__["a" /* deletable */]],
  props: ["type", "typeUser", "api_service_token"],
  components: {
    DataTable: __WEBPACK_IMPORTED_MODULE_0__components_DataTablePersons_vue___default.a,
    CommercialTreatmentForm: CommercialTreatmentForm,
    Categories: Categories
  },
  data: function data() {
    return {
      title: null,
      showDialog: false,
      showImportDialog: false,
      resource: "commercial_treatment",
      recordId: null,
      showDialogPrinter: false,
      showDialogCategories: false,
      commercialTreatment: null
    };
  },
  created: function created() {
    this.title = "Tratamientos comerciales"; //    console.log(resource+`/${this.type}`)
  },
  methods: {
    clickOpenCategories: function clickOpenCategories(row) {
      this.commercialTreatment = row;
      this.showDialogCategories = true;
    },
    clickCreate: function clickCreate() {
      var recordId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.recordId = recordId;
      this.showDialog = true;
    },
    clickImport: function clickImport() {
      this.showImportDialog = true;
    },
    clickDelete: function clickDelete(id) {
      var _this = this;

      this.destroy("/".concat(this.resource, "/").concat(id)).then(function () {
        return _this.$eventHub.$emit("reloadData");
      });
    },
    clickDisable: function clickDisable(id) {
      var _this2 = this;

      this.disable("/".concat(this.resource, "/enabled/", 0, "/").concat(id)).then(function () {
        return _this2.$eventHub.$emit("reloadData");
      });
    },
    clickPrint: function clickPrint() {
      this.showDialogPrinter = true;
    },
    clickEnable: function clickEnable(id) {
      var _this3 = this;

      this.enable("/".concat(this.resource, "/enabled/", 1, "/").concat(id)).then(function () {
        return _this3.$eventHub.$emit("reloadData");
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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-242e0a76\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/commercial_treatment/index.vue":
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
              _vm._m(0),
              _vm._v(" "),
              _c("li", { staticClass: "breadcrumb-item active" }, [
                _c("span", { staticClass: "text-muted" }, [
                  _vm._v(_vm._s(_vm.title))
                ])
              ])
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
              ),
              _vm._v(" "),
              _c("div", { staticClass: "ms-1" }, [
                _vm._m(1),
                _vm._v(" "),
                _c("div", { staticClass: "dropdown-menu dropdown-menu-end" }, [
                  _c(
                    "button",
                    {
                      staticClass: "dropdown-item",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.clickPrint()
                        }
                      }
                    },
                    [
                      _c("i", { staticClass: "icofont-printer" }),
                      _vm._v(" Imprimir\n                            ")
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "dropdown-item",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.clickImport("excel")
                        }
                      }
                    },
                    [
                      _c("i", { staticClass: "icofont-upload-alt" }),
                      _vm._v(" Importar\n                            ")
                    ]
                  )
                ])
              ])
            ]
          )
        ])
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "container-fluid p-l-0 p-r-0" },
      [
        _c("div", { staticClass: "card mb-0" }, [
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
                        return _c(
                          "tr",
                          { class: { disable_color: !row.active } },
                          [
                            _c("td", [_vm._v(_vm._s(index))]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(row.description))]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-end" }, [
                              _vm._v(
                                _vm._s(row.is_amount ? "Monto" : "Porcentaje")
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "td",
                              { staticClass: "text-end" },
                              [
                                _c(
                                  "el-button",
                                  {
                                    attrs: { size: "mini" },
                                    on: {
                                      click: function($event) {
                                        return _vm.clickOpenCategories(row)
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            Modificar\n                            "
                                    )
                                  ]
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              { staticClass: "text-end" },
                              [
                                row.active
                                  ? [
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
                                            "\n                                    Editar\n                                "
                                          )
                                        ]
                                      )
                                    ]
                                  : _vm._e(),
                                _vm._v(" "),
                                _vm.typeUser === "admin" ||
                                _vm.typeUser === "superadmin"
                                  ? [
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
                                            "\n                                    Eliminar\n                                "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      row.enabled
                                        ? _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn waves-effect waves-light btn-sm btn-danger",
                                              attrs: { type: "button" },
                                              on: {
                                                click: function($event) {
                                                  $event.preventDefault()
                                                  return _vm.clickDisable(
                                                    row.id
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                    Inhabilitar\n                                "
                                              )
                                            ]
                                          )
                                        : _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn waves-effect waves-light btn-sm btn-primary",
                                              attrs: { type: "button" },
                                              on: {
                                                click: function($event) {
                                                  $event.preventDefault()
                                                  return _vm.clickEnable(row.id)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                    Habilitar\n                                "
                                              )
                                            ]
                                          )
                                    ]
                                  : _vm._e()
                              ],
                              2
                            )
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
                    _c("th", [_vm._v("Descripción")]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-end" }, [
                      _vm._v("Afectación")
                    ]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-end" }, [
                      _vm._v("Categorias")
                    ]),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-end" }, [_vm._v("Acciones")])
                  ]),
                  _vm._v(" "),
                  _c("tr")
                ]
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("commercial-treatment-form", {
          attrs: { "record-id": _vm.recordId, showDialog: _vm.showDialog },
          on: {
            "update:showDialog": function($event) {
              _vm.showDialog = $event
            },
            "update:show-dialog": function($event) {
              _vm.showDialog = $event
            }
          }
        }),
        _vm._v(" "),
        _c("categories", {
          attrs: {
            showDialog: _vm.showDialogCategories,
            commercialTreatment: _vm.commercialTreatment
          },
          on: {
            "update:showDialog": function($event) {
              _vm.showDialogCategories = $event
            },
            "update:show-dialog": function($event) {
              _vm.showDialogCategories = $event
            }
          }
        })
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", { staticClass: "breadcrumb-item" }, [
      _c("a", { attrs: { href: "/dashboard" } }, [_vm._v("Dashboard")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "btn btn-outline-primary btn-icon btn-icon-only",
        attrs: {
          type: "button",
          "data-bs-offset": "0,3",
          "data-bs-toggle": "dropdown",
          "aria-haspopup": "true",
          "aria-expanded": "false",
          "data-submenu": ""
        }
      },
      [_c("i", { attrs: { "data-cs-icon": "more-horizontal" } })]
    )
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-242e0a76", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-72a2db76\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/DataTablePersons.vue":
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
                  _vm.search.column == "delivery_date"
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
    require("vue-hot-reload-api")      .rerender("data-v-72a2db76", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/components/DataTablePersons.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/DataTablePersons.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-72a2db76\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/DataTablePersons.vue")
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
Component.options.__file = "resources/js/components/DataTablePersons.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-72a2db76", Component.options)
  } else {
    hotAPI.reload("data-v-72a2db76", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/commercial_treatment/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/commercial_treatment/index.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-242e0a76\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/commercial_treatment/index.vue")
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
Component.options.__file = "resources/js/views/commercial_treatment/index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-242e0a76", Component.options)
  } else {
    hotAPI.reload("data-v-242e0a76", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=commercial_treatment.js.map