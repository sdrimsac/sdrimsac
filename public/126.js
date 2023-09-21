webpackJsonp([126],{

/***/ "./modules/College/Resources/assets/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/views/persons/form.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/persons/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-bf046f30\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/persons/form.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/views/persons/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-bf046f30", Component.options)
  } else {
    hotAPI.reload("data-v-bf046f30", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/persons/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
var PersonForm = function PersonForm() {
  return __webpack_require__.e/* import() */(124/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/views/persons/form.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "recordId", "extern", "fromPerson"],
  components: {
    PersonForm: PersonForm
  },
  data: function data() {
    return {
      identityDocuments: [],
      tab: "parent",
      title: "Nuevo registro",
      loading: false,
      showDialogNewPerson: false,
      loading_search: false,
      children: [],
      form: {},
      resource: "college/persons",
      documentNumber: null,
      documentNumberChildren: null,
      documentTypeChildren: null,
      departments: [],
      provinces: [],
      currentPersonId: null,
      form_attorney: {
        add: false
      },
      countries: [],
      districts: [],
      all_departments: [],
      all_provinces: [],
      all_countries: [],
      all_districts: [],
      errors: {},
      types: [],
      form_children: {
        name: ""
      },
      timer: null
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
              return _this.getTables();

            case 2:
              _context.next = 4;
              return _this.getAttorneyTypes();

            case 4:
              _this.initForm();

              _this.$eventHub.$on("reloadData", function () {
                _this.open();
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
    editPerson: function editPerson(child) {
      this.currentPersonId = child.id;
      this.showDialogNewPerson = true;
    },
    updateAll: function updateAll() {
      this.$forceUpdate();
    },
    sendData: function sendData() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, _response$data, success, message;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!_this2.validForm()) {
                  _context2.next = 2;
                  break;
                }

                return _context2.abrupt("return");

              case 2:
                _this2.form.children = _this2.children;
                _this2.form.number = _this2.documentNumber;
                _context2.prev = 4;
                _this2.loading = true;
                _context2.next = 8;
                return _this2.$http.post("/".concat(_this2.resource).concat(_this2.recordId ? "/update" : ""), _this2.form);

              case 8:
                response = _context2.sent;

                if (response.status == 200) {
                  _response$data = response.data, success = _response$data.success, message = _response$data.message;

                  if (success) {
                    _this2.$toast.success(message);

                    _this2.$emit("memberCreated", _this2.form.number);

                    _this2.close();
                  } else {
                    _this2.$toast.error(message);
                  }
                }

                _context2.next = 16;
                break;

              case 12:
                _context2.prev = 12;
                _context2.t0 = _context2["catch"](4);

                _this2.$toast.error("Ocurrió un error");

                console.log(_context2.t0);

              case 16:
                _context2.prev = 16;
                _this2.loading = false;
                return _context2.finish(16);

              case 19:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[4, 12, 16, 19]]);
      }))();
    },
    getDocumentType: function getDocumentType(id) {
      return this.identityDocuments.find(function (i) {
        return i.id == id;
      }).description;
    },
    initForm: function initForm() {
      this.form = {
        country_id: "PE",
        identity_document_type_id: "1",
        type: "mother"
      };
      this.children = [];
      this.documentTypeChildren = "1";
      this.documentNumber = null;
      this.documentNumber = null;
      this.documentNumberChildren = null;
      this.form_children.name = null;
    },
    validForm: function validForm() {
      var error = false;
      var _this$form = this.form,
          name = _this$form.name,
          department_id = _this$form.department_id,
          province_id = _this$form.province_id,
          district_id = _this$form.district_id,
          address = _this$form.address,
          phone = _this$form.phone,
          attorney_id = _this$form.attorney_id,
          type = _this$form.type;

      if (!name) {
        error = true;
        this.$toast.error("El nombre es obligatorio");
      }

      if (!this.documentNumber) {
        error = true;
        this.$toast.error("El documento es obligatorio");
      }

      if (!department_id) {
        error = true;
        this.$toast.error("El departamento es obligatorio");
      }

      if (!province_id) {
        error = true;
        this.$toast.error("La provincia es obligatorio");
      }

      if (!district_id) {
        error = true;
        this.$toast.error("El distrito es obligatorio");
      }

      if (!address) {
        error = true;
        this.$toast.error("La dirección es obligatorio");
      }

      if (!phone) {
        error = true;
        this.$toast.error("El teléfono es obligatorio");
      }

      if (type == "attorney") {
        if (!attorney_id) {
          error = true;
          this.$toast.error("Elija un parentezco");
        }
      }

      if (this.children.length == 0) {
        error = true;
        this.$toast.error("Debe registrar al menos un estudiante");
      }

      return error;
    },
    addChildren: function addChildren() {
      var _this3 = this;

      if (!this.documentNumberChildren) {
        return this.$toast.error("Documento obligatorio");
      }

      if (!this.form_children.name) {
        return this.$toast.error("Nombre obligatorio");
      }

      this.children = [].concat(_toConsumableArray(this.children.filter(function (c) {
        return c.number != _this3.documentNumberChildren;
      })), [_objectSpread(_objectSpread({}, this.form_children), {}, {
        identity_document_type_id: this.documentTypeChildren,
        number: this.documentNumberChildren,
        id: null
      })]);
      this.form_children.name = "";
      this.documentNumberChildren = null;
    },
    deleteChild: function deleteChild(child) {
      var number = child.number,
          id = child.id;

      if (id) {
        console.log("No se puede borrar");
      } else {
        this.children = _toConsumableArray(this.children.filter(function (c) {
          return c.number != number;
        }));
      }
    },
    searchType: function searchType() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                if (_this4.timer) {
                  clearTimeout(_this4.timer);
                }

                _this4.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
                    while (1) {
                      switch (_context3.prev = _context3.next) {
                        case 0:
                          _context3.next = 2;
                          return _this4.getAttorneyTypes();

                        case 2:
                        case "end":
                          return _context3.stop();
                      }
                    }
                  }, _callee3);
                })), 250);

              case 2:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getAttorneyTypes: function getAttorneyTypes() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var response, records;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _context5.prev = 0;
                _this5.loading = true;
                _context5.next = 4;
                return _this5.$http.get("/".concat(_this5.resource, "/attorney/records?description=").concat(_this5.form_attorney.name ? _this5.form_attorney.name : ""));

              case 4:
                response = _context5.sent;

                if (response.status == 200) {
                  records = response.data.records;
                  _this5.types = records;
                }

                _context5.next = 11;
                break;

              case 8:
                _context5.prev = 8;
                _context5.t0 = _context5["catch"](0);
                console.log(_context5.t0);

              case 11:
                _context5.prev = 11;
                _this5.loading = false;
                return _context5.finish(11);

              case 14:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, null, [[0, 8, 11, 14]]);
      }))();
    },
    saveType: function saveType() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        var response, _response$data2, id, message, success;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _context6.prev = 0;
                _this6.loading = true;
                _context6.next = 4;
                return _this6.$http.post("/".concat(_this6.resource, "/attorney"), {
                  description: _this6.form_attorney.name
                });

              case 4:
                response = _context6.sent;

                if (response.status == 200) {
                  _response$data2 = response.data, id = _response$data2.id, message = _response$data2.message, success = _response$data2.success;

                  if (success) {
                    _this6.form.attorney_id = id;

                    _this6.$toast.success(message);

                    _this6.getAttorneyTypes();

                    _this6.form_attorney.add = false;
                    _this6.form_attorney.name = null;
                  } else {
                    _this6.$toast.error(message);
                  }
                }

                _context6.next = 11;
                break;

              case 8:
                _context6.prev = 8;
                _context6.t0 = _context6["catch"](0);
                console.log(_context6.t0);

              case 11:
                _context6.prev = 11;
                _this6.loading = false;
                return _context6.finish(11);

              case 14:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6, null, [[0, 8, 11, 14]]);
      }))();
    },
    getTables: function getTables() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee7() {
        var response, _response$data3, departments, provinces, countries, districts, identity_documents;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _context7.prev = 0;
                _this7.loading = true;
                _context7.next = 4;
                return _this7.$http("/".concat(_this7.resource, "/tables"));

              case 4:
                response = _context7.sent;

                if (response.status == 200) {
                  _response$data3 = response.data, departments = _response$data3.departments, provinces = _response$data3.provinces, countries = _response$data3.countries, districts = _response$data3.districts, identity_documents = _response$data3.identity_documents;
                  _this7.all_departments = departments;
                  _this7.all_provinces = provinces;
                  _this7.all_countries = countries;
                  _this7.all_districts = districts;
                  _this7.identityDocuments = identity_documents;
                  _this7.departments = departments;
                  _this7.provinces = provinces;
                  _this7.countries = countries;
                  _this7.districts = districts;
                }

                _this7.form.identity_document_type_id = "1"; // this.form_children.identity_document_type_id = "1";

                _this7.documentTypeChildren = "1";
                _context7.next = 13;
                break;

              case 10:
                _context7.prev = 10;
                _context7.t0 = _context7["catch"](0);
                console.log(_context7.t0);

              case 13:
                _context7.prev = 13;
                _this7.loading = false;
                return _context7.finish(13);

              case 16:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7, null, [[0, 10, 13, 16]]);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    open: function open() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee8() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                _this8.initForm();

                _this8.recordId && (_this8.title = "Editar registro");

                if (!_this8.recordId) {
                  _context8.next = 21;
                  break;
                }

                _context8.prev = 3;
                _this8.loading = true;
                _context8.next = 7;
                return _this8.$http("/".concat(_this8.resource, "/update/").concat(_this8.recordId, "?from_person=").concat(_this8.fromPerson ? 1 : ""));

              case 7:
                response = _context8.sent;
                data = response.data.data;
                _this8.form = data;
                _this8.documentNumber = _this8.form.number;
                _this8.children = _this8.form.children;
                _context8.next = 18;
                break;

              case 14:
                _context8.prev = 14;
                _context8.t0 = _context8["catch"](3);
                console.log(_context8.t0);

                _this8.$toast.error("Ocurrió un error al obtener el registro");

              case 18:
                _context8.prev = 18;
                _this8.loading = false;
                return _context8.finish(18);

              case 21:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8, null, [[3, 14, 18, 21]]);
      }))();
    },
    searchCustomer: function searchCustomer() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee10() {
        var documentNumber;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                documentNumber = _this9.tab == "parent" ? _this9.documentNumber : _this9.documentNumberChildren;

                if (!(documentNumber == null || documentNumber == "")) {
                  _context10.next = 3;
                  break;
                }

                return _context10.abrupt("return");

              case 3:
                if (!(documentNumber.length != 8 && documentNumber.length != 11)) {
                  _context10.next = 6;
                  break;
                }

                _this9.$toast.error("Ingrese un documento válido");

                return _context10.abrupt("return");

              case 6:
                if (_this9.timer) {
                  clearTimeout(_this9.timer);
                }

                _this9.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee9() {
                  var response, data, _data$ubigeo, department, province, district;

                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee9$(_context9) {
                    while (1) {
                      switch (_context9.prev = _context9.next) {
                        case 0:
                          _context9.prev = 0;
                          _this9.currentCustomer = null;
                          _this9.loading_search = true;
                          _context9.next = 5;
                          return _this9.$http("/".concat(_this9.resource, "/").concat(documentNumber, "?type=").concat(_this9.tab == "parent" ? "parent" : "student"));

                        case 5:
                          response = _context9.sent;

                          if (response.status == 200) {
                            data = response.data;

                            if (data.numero || data.ruc) {
                              if (_this9.tab == "parent") {
                                if (documentNumber.length == 8) {
                                  _this9.form.name = data.nombre_completo;
                                } else {
                                  _this9.form.name = data.nombre_o_razon_social;
                                  _this9.form.state = data.estado;
                                  _this9.form.condition = data.condicion;
                                }

                                _this9.form.address = data.direccion_completa;

                                if (data.ubigeo.length == 3) {
                                  _data$ubigeo = _slicedToArray(data.ubigeo, 3), department = _data$ubigeo[0], province = _data$ubigeo[1], district = _data$ubigeo[2];
                                  _this9.form.department_id = department;
                                  _this9.form.province_id = province;
                                  _this9.form.district_id = district;
                                }
                              } else {
                                _this9.form_children.name = data.nombre_completo;
                              }
                            } else {
                              _this9.$toast.error(data.message || "No se encontró el documento");
                            }
                          } else {
                            _this9.$toast.error("No se pudo obtener los datos");
                          }

                          _context9.next = 12;
                          break;

                        case 9:
                          _context9.prev = 9;
                          _context9.t0 = _context9["catch"](0);

                          _this9.$toast.error("No se pudo obtener los datos");

                        case 12:
                          _context9.prev = 12;
                          _this9.loading_search = false;
                          return _context9.finish(12);

                        case 15:
                        case "end":
                          return _context9.stop();
                      }
                    }
                  }, _callee9, null, [[0, 9, 12, 15]]);
                })), 250);

              case 8:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    filterProvince: function filterProvince() {
      this.form.province_id = null;
      this.form.district_id = null;
      this.filterProvinces();
    },
    filterProvinces: function filterProvinces() {
      var _this10 = this;

      this.provinces = this.all_provinces.filter(function (f) {
        return f.department_id === _this10.form.department_id;
      });
    },
    filterDistrict: function filterDistrict() {
      this.form.district_id = null;
      this.filterDistricts();
    },
    filterDistricts: function filterDistricts() {
      var _this11 = this;

      this.districts = this.all_districts.filter(function (f) {
        return f.province_id === _this11.form.province_id;
      });
    },
    closeProperty: function closeProperty() {
      this.form.state = null;
      this.form.condition = null;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.to_left .el-input .el-input__inner {\r\n    text-align: left !important;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/modules/College/Resources/assets/js/views/persons/modules/College/Resources/assets/js/views/persons/form.vue"],"names":[],"mappings":";AA4dA;IACA,4BAAA;CACA","file":"form.vue","sourcesContent":["<template>\r\n    <el-dialog\r\n        :visible=\"showDialog\"\r\n        append-to-body\r\n        @close=\"close\"\r\n        @open=\"open\"\r\n        :title=\"title\"\r\n    >\r\n        <div class=\"form-body\" v-loading=\"loading\">\r\n            <el-tabs tab-position=\"top\" v-model=\"tab\">\r\n                <el-tab-pane name=\"parent\" label=\"Datos del Cliente\">\r\n                    <div class=\"card\">\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Tipo de documento</label\r\n                                >\r\n                                <el-select\r\n                                    @change=\"closeProperty\"\r\n                                    style=\"width:100%;\"\r\n                                    v-model=\"form.identity_document_type_id\"\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"option in identityDocuments\"\r\n                                        :key=\"option.id\"\r\n                                        :value=\"option.id\"\r\n                                        :label=\"option.description\"\r\n                                    >\r\n                                    </el-option>\r\n                                </el-select>\r\n                            </div>\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Documento</label\r\n                                >\r\n                                <el-input\r\n                                    class=\"to_left\"\r\n                                    style=\"width:100%;\"\r\n                                    v-model=\"documentNumber\"\r\n                                    @input=\"closeProperty\"\r\n                                    :controls=\"false\"\r\n                                >\r\n                                    <el-button\r\n                                        v-if=\"\r\n                                            form.identity_document_type_id ==\r\n                                                1 ||\r\n                                                form.identity_document_type_id ==\r\n                                                    6\r\n                                        \"\r\n                                        slot=\"append\"\r\n                                        :loading=\"loading_search\"\r\n                                        icon=\"el-icon-search\"\r\n                                        @click.prevent=\"searchCustomer\"\r\n                                    ></el-button>\r\n                                </el-input>\r\n                            </div>\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Nombres</label\r\n                                >\r\n                                <el-input v-model=\"form.name\"> </el-input>\r\n                            </div>\r\n                        </div>\r\n                        <div\r\n                            class=\"row mt-2\"\r\n                            v-if=\"form.state && form.condition\"\r\n                        >\r\n                            <div class=\"col-md-6 col-12\"></div>\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <el-alert\r\n                                    :title=\"form.state\"\r\n                                    :type=\"\r\n                                        `${\r\n                                            form.state == 'ACTIVO'\r\n                                                ? 'success'\r\n                                                : 'error'\r\n                                        }`\r\n                                    \"\r\n                                >\r\n                                </el-alert>\r\n                            </div>\r\n                            <div class=\"col-md-3\">\r\n                                <el-alert\r\n                                    :title=\"form.condition\"\r\n                                    :type=\"\r\n                                        `${\r\n                                            form.condition == 'HABIDO'\r\n                                                ? 'success'\r\n                                                : 'error'\r\n                                        }`\r\n                                    \"\r\n                                >\r\n                                </el-alert>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row mt-2\">\r\n                            <div class=\"col-md-4\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{ 'has-danger': errors.country_id }\"\r\n                                >\r\n                                    <label class=\"control-label\">País</label>\r\n                                    <el-select\r\n                                        v-model=\"form.country_id\"\r\n                                        filterable\r\n                                        dusk=\"country_id\"\r\n                                        disabled\r\n                                    >\r\n                                        <el-option\r\n                                            v-for=\"option in countries\"\r\n                                            :key=\"option.id\"\r\n                                            :value=\"option.id\"\r\n                                            :label=\"option.description\"\r\n                                        ></el-option>\r\n                                    </el-select>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.country_id\"\r\n                                        v-text=\"errors.country_id[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-4\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{\r\n                                        'has-danger': errors.department_id\r\n                                    }\"\r\n                                >\r\n                                    <label class=\"control-label\"\r\n                                        >Departamento</label\r\n                                    >\r\n                                    <el-select\r\n                                        v-model=\"form.department_id\"\r\n                                        filterable\r\n                                        @change=\"filterProvince\"\r\n                                        popper-class=\"el-select-departments\"\r\n                                        dusk=\"department_id\"\r\n                                    >\r\n                                        <el-option\r\n                                            v-for=\"option in departments\"\r\n                                            :key=\"option.id\"\r\n                                            :value=\"option.id\"\r\n                                            :label=\"option.description\"\r\n                                        ></el-option>\r\n                                    </el-select>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.department_id\"\r\n                                        v-text=\"errors.department_id[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-4\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{\r\n                                        'has-danger': errors.province_id\r\n                                    }\"\r\n                                >\r\n                                    <label class=\"control-label\"\r\n                                        >Provincia</label\r\n                                    >\r\n                                    <el-select\r\n                                        v-model=\"form.province_id\"\r\n                                        filterable\r\n                                        @change=\"filterDistrict\"\r\n                                        popper-class=\"el-select-provinces\"\r\n                                        dusk=\"province_id\"\r\n                                    >\r\n                                        <el-option\r\n                                            v-for=\"option in provinces\"\r\n                                            :key=\"option.id\"\r\n                                            :value=\"option.id\"\r\n                                            :label=\"option.description\"\r\n                                        ></el-option>\r\n                                    </el-select>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.province_id\"\r\n                                        v-text=\"errors.province_id[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-4\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{\r\n                                        'has-danger': errors.district_id\r\n                                    }\"\r\n                                >\r\n                                    <label class=\"control-label\"\r\n                                        >Distrito</label\r\n                                    >\r\n                                    <el-select\r\n                                        @change=\"updateAll\"\r\n                                        v-model=\"form.district_id\"\r\n                                        filterable\r\n                                        popper-class=\"el-select-districts\"\r\n                                        dusk=\"district_id\"\r\n                                    >\r\n                                        <el-option\r\n                                            v-for=\"option in districts\"\r\n                                            :key=\"option.id\"\r\n                                            :value=\"option.id\"\r\n                                            :label=\"option.description\"\r\n                                        ></el-option>\r\n                                    </el-select>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.district_id\"\r\n                                        v-text=\"errors.district_id[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-8\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{ 'has-danger': errors.address }\"\r\n                                >\r\n                                    <label class=\"control-label\"\r\n                                        >Dirección</label\r\n                                    >\r\n                                    <el-input\r\n                                        v-model=\"form.address\"\r\n                                        dusk=\"address\"\r\n                                    >\r\n                                        <i\r\n                                            slot=\"prefix\"\r\n                                            class=\"el-icon-edit-outline\"\r\n                                        ></i\r\n                                    ></el-input>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.address\"\r\n                                        v-text=\"errors.address[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Teléfono</label\r\n                                >\r\n                                <el-input v-model=\"form.phone\"> </el-input>\r\n                            </div>\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Correo</label\r\n                                >\r\n                                <el-input v-model=\"form.email\"> </el-input>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row mt-2\">\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Teléfono secundario</label\r\n                                >\r\n                                <el-input v-model=\"form.extra_phone\">\r\n                                </el-input>\r\n                            </div>\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Relacion</label\r\n                                >\r\n                                <el-select v-model=\"form.type\">\r\n                                    <el-option\r\n                                        value=\"mother\"\r\n                                        label=\"Madre\"\r\n                                    ></el-option>\r\n                                    <el-option\r\n                                        value=\"father\"\r\n                                        label=\"Padre\"\r\n                                    ></el-option>\r\n                                    <el-option\r\n                                        value=\"attorney\"\r\n                                        label=\"Apoderado\"\r\n                                    ></el-option>\r\n                                </el-select>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row mt-2\">\r\n                            <div\r\n                                v-if=\"form.type == 'attorney'\"\r\n                                class=\"col-md-6 col-12\"\r\n                            >\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Tipo de apoderado</label\r\n                                >\r\n\r\n                                <a\r\n                                    href=\"#\"\r\n                                    v-if=\"form_attorney.add == false\"\r\n                                    class=\"control-label font-weight-bold text-info\"\r\n                                    @click=\"form_attorney.add = true\"\r\n                                >\r\n                                    [ + Nuevo]</a\r\n                                >\r\n                                <a\r\n                                    href=\"#\"\r\n                                    v-if=\"form_attorney.add == true\"\r\n                                    class=\"control-label font-weight-bold text-info\"\r\n                                    @click=\"saveType()\"\r\n                                >\r\n                                    [ + Guardar]</a\r\n                                >\r\n                                <a\r\n                                    href=\"#\"\r\n                                    v-if=\"form_attorney.add == true\"\r\n                                    class=\"control-label font-weight-bold text-danger\"\r\n                                    @click=\"form_attorney.add = false\"\r\n                                >\r\n                                    [ Cancelar]</a\r\n                                >\r\n                                <el-input\r\n                                    v-if=\"form_attorney.add == true\"\r\n                                    v-model=\"form_attorney.name\"\r\n                                    dusk=\"item_code\"\r\n                                    @input=\"searchType\"\r\n                                    style=\"margin-bottom:1.5%;\"\r\n                                >\r\n                                    <i\r\n                                        slot=\"prefix\"\r\n                                        class=\"el-icon-edit-outline\"\r\n                                    ></i\r\n                                ></el-input>\r\n\r\n                                <el-select\r\n                                    v-if=\"form_attorney.add == false\"\r\n                                    v-model=\"form.attorney_id\"\r\n                                    filterable\r\n                                    clearable\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"option in types\"\r\n                                        :key=\"option.id\"\r\n                                        :value=\"option.id\"\r\n                                        :label=\"option.description\"\r\n                                    ></el-option>\r\n                                </el-select>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </el-tab-pane>\r\n                <el-tab-pane name=\"children\" label=\"Datos de los estudiantes\">\r\n                    <div class=\"card\">\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Tipo de documento</label\r\n                                >\r\n                                <el-select\r\n                                    style=\"\r\n                    width:100%;\"\r\n                                    v-model=\"documentTypeChildren\"\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"option in identityDocuments\"\r\n                                        :key=\"option.id\"\r\n                                        :value=\"option.id\"\r\n                                        :label=\"option.description\"\r\n                                    >\r\n                                    </el-option>\r\n                                </el-select>\r\n                            </div>\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Documento</label\r\n                                >\r\n                                <el-input\r\n                                    class=\"to_left\"\r\n                                    style=\"\r\n                    width:100%;\"\r\n                                    v-model=\"documentNumberChildren\"\r\n                                    :controls=\"false\"\r\n                                >\r\n                                    <el-button\r\n                                        v-if=\"documentTypeChildren == '1'\"\r\n                                        slot=\"append\"\r\n                                        :loading=\"loading_search\"\r\n                                        icon=\"el-icon-search\"\r\n                                        @click.prevent=\"searchCustomer\"\r\n                                    ></el-button>\r\n                                </el-input>\r\n                            </div>\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Nombres</label\r\n                                >\r\n                                <el-input v-model=\"form_children.name\">\r\n                                </el-input>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row justify-content-end\">\r\n                            <div\r\n                                class=\"col-md-3 col-12 align-self-end d-flex justify-content-end\"\r\n                            >\r\n                                <el-button\r\n                                    class=\" mt-2\"\r\n                                    type=\"primary\"\r\n                                    @click=\"addChildren\"\r\n                                >\r\n                                    Agregar\r\n                                </el-button>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row mt-2 p-2\">\r\n                            <table class=\"table\">\r\n                                <thead>\r\n                                    <tr>\r\n                                        <th>#</th>\r\n                                        <th>Nombre</th>\r\n                                        <th>Documento</th>\r\n                                        <th></th>\r\n                                    </tr>\r\n                                </thead>\r\n                                <tbody>\r\n                                    <tr\r\n                                        v-for=\"(child, idx) in children\"\r\n                                        :key=\"idx\"\r\n                                    >\r\n                                        <td>{{ idx + 1 }}</td>\r\n                                        <td>{{ child.name }}</td>\r\n                                        <td>\r\n                                            {{ child.number }}\r\n\r\n                                            <br />\r\n                                            <small>\r\n                                                {{\r\n                                                    getDocumentType(\r\n                                                        child.identity_document_type_id\r\n                                                    )\r\n                                                }}\r\n                                            </small>\r\n                                        </td>\r\n                                        <td>\r\n                                              <el-button\r\n                                                v-if=\"child.edit\"\r\n                                                type=\"success\"\r\n                                                size=\"mini\"\r\n                                                icon=\"el-icon-edit\"\r\n                                                circle\r\n                                                @click=\"editPerson(child)\"\r\n                                            ></el-button>\r\n                                            <el-button\r\n                                                v-if=\"!child.id\"\r\n                                                type=\"danger\"\r\n                                                size=\"mini\"\r\n                                                icon=\"el-icon-delete\"\r\n                                                circle\r\n                                                @click=\"deleteChild(child)\"\r\n                                            ></el-button>\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                </el-tab-pane>\r\n            </el-tabs>\r\n        </div>\r\n        <div slot=\"footer\" class=\"dialog-footer\">\r\n            <el-button @click=\"close\">Cancelar</el-button>\r\n            <el-button type=\"primary\" @click=\"sendData\">Guardar</el-button>\r\n        </div>\r\n             <person-form\r\n                :external=\"false\"\r\n                :recordId=\"currentPersonId\"\r\n                :showDialog.sync=\"showDialogNewPerson\"\r\n            ></person-form>\r\n    </el-dialog>\r\n</template>\r\n<style>\r\n.to_left .el-input .el-input__inner {\r\n    text-align: left !important;\r\n}\r\n</style>\r\n<script>\r\nconst PersonForm = () =>\r\n    import(\"../../../../../../../resources/js/views/persons/form.vue\");\r\nexport default {\r\n    props: [\"showDialog\", \"recordId\", \"extern\", \"fromPerson\"],\r\n    components: {\r\n        PersonForm\r\n    },\r\n    data() {\r\n        return {\r\n            identityDocuments: [],\r\n            tab: \"parent\",\r\n            title: \"Nuevo registro\",\r\n            loading: false,\r\nshowDialogNewPerson:false,\r\n            loading_search: false,\r\n            children: [],\r\n            form: {},\r\n            resource: \"college/persons\",\r\n            documentNumber: null,\r\n            documentNumberChildren: null,\r\n            documentTypeChildren: null,\r\n            departments: [],\r\n            provinces: [],\r\n            currentPersonId:null,\r\n            form_attorney: {\r\n                add: false\r\n            },\r\n            countries: [],\r\n            districts: [],\r\n            all_departments: [],\r\n            all_provinces: [],\r\n            all_countries: [],\r\n            all_districts: [],\r\n            errors: {},\r\n            types: [],\r\n            form_children: {\r\n                name: \"\"\r\n            },\r\n            timer: null\r\n        };\r\n    },\r\n    async created() {\r\n        await this.getTables();\r\n        await this.getAttorneyTypes();\r\n        this.initForm();\r\n        this.$eventHub.$on(\"reloadData\", () => {\r\n            this.open();\r\n        });\r\n    },\r\n    methods: {\r\n        editPerson(child){\r\n            this.currentPersonId = child.id;\r\n            this.showDialogNewPerson = true;\r\n        },\r\n        updateAll() {\r\n            this.$forceUpdate();\r\n        },\r\n        async sendData() {\r\n            if (this.validForm()) {\r\n                return;\r\n            }\r\n            this.form.children = this.children;\r\n            this.form.number = this.documentNumber;\r\n\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.post(\r\n                    `/${this.resource}${this.recordId ? \"/update\" : \"\"}`,\r\n                    this.form\r\n                );\r\n                if (response.status == 200) {\r\n                    let { success, message } = response.data;\r\n                    if (success) {\r\n                        this.$toast.success(message);\r\n                        this.$emit(\"memberCreated\", this.form.number);\r\n                        this.close();\r\n                    } else {\r\n                        this.$toast.error(message);\r\n                    }\r\n                }\r\n            } catch (e) {\r\n                this.$toast.error(\"Ocurrió un error\");\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        getDocumentType(id) {\r\n            return this.identityDocuments.find(i => i.id == id).description;\r\n        },\r\n        initForm() {\r\n            this.form = {\r\n                country_id: \"PE\",\r\n                identity_document_type_id: \"1\",\r\n                type: \"mother\"\r\n            };\r\n            this.children = [];\r\n            this.documentTypeChildren = \"1\";\r\n            this.documentNumber = null;\r\n            this.documentNumber = null;\r\n            this.documentNumberChildren = null;\r\n            this.form_children.name = null;\r\n        },\r\n        validForm() {\r\n            let error = false;\r\n            let {\r\n                name,\r\n                department_id,\r\n                province_id,\r\n                district_id,\r\n                address,\r\n                phone,\r\n\r\n                attorney_id,\r\n                type\r\n            } = this.form;\r\n            if (!name) {\r\n                error = true;\r\n                this.$toast.error(\"El nombre es obligatorio\");\r\n            }\r\n            if (!this.documentNumber) {\r\n                error = true;\r\n                this.$toast.error(\"El documento es obligatorio\");\r\n            }\r\n\r\n            if (!department_id) {\r\n                error = true;\r\n                this.$toast.error(\"El departamento es obligatorio\");\r\n            }\r\n            if (!province_id) {\r\n                error = true;\r\n                this.$toast.error(\"La provincia es obligatorio\");\r\n            }\r\n            if (!district_id) {\r\n                error = true;\r\n                this.$toast.error(\"El distrito es obligatorio\");\r\n            }\r\n            if (!address) {\r\n                error = true;\r\n                this.$toast.error(\"La dirección es obligatorio\");\r\n            }\r\n            if (!phone) {\r\n                error = true;\r\n                this.$toast.error(\"El teléfono es obligatorio\");\r\n            }\r\n\r\n            if (type == \"attorney\") {\r\n                if (!attorney_id) {\r\n                    error = true;\r\n                    this.$toast.error(\"Elija un parentezco\");\r\n                }\r\n            }\r\n\r\n            if (this.children.length == 0) {\r\n                error = true;\r\n                this.$toast.error(\"Debe registrar al menos un estudiante\");\r\n            }\r\n\r\n            return error;\r\n        },\r\n        addChildren() {\r\n            if (!this.documentNumberChildren) {\r\n                return this.$toast.error(\"Documento obligatorio\");\r\n            }\r\n\r\n            if (!this.form_children.name) {\r\n                return this.$toast.error(\"Nombre obligatorio\");\r\n            }\r\n            this.children = [\r\n                ...this.children.filter(\r\n                    c => c.number != this.documentNumberChildren\r\n                ),\r\n                {\r\n                    ...this.form_children,\r\n                    identity_document_type_id: this.documentTypeChildren,\r\n                    number: this.documentNumberChildren,\r\n                    id: null\r\n                }\r\n            ];\r\n\r\n            this.form_children.name = \"\";\r\n            this.documentNumberChildren = null;\r\n        },\r\n        deleteChild(child) {\r\n            let { number, id } = child;\r\n            if (id) {\r\n                console.log(\"No se puede borrar\");\r\n            } else {\r\n                this.children = [\r\n                    ...this.children.filter(c => c.number != number)\r\n                ];\r\n            }\r\n        },\r\n        async searchType() {\r\n            if (this.timer) {\r\n                clearTimeout(this.timer);\r\n            }\r\n\r\n            this.timer = setTimeout(async () => {\r\n                await this.getAttorneyTypes();\r\n            }, 250);\r\n        },\r\n\r\n        async getAttorneyTypes() {\r\n            //persons/attorney/record\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.get(\r\n                    `/${this.resource}/attorney/records?description=${\r\n                        this.form_attorney.name ? this.form_attorney.name : \"\"\r\n                    }`\r\n                );\r\n\r\n                if (response.status == 200) {\r\n                    let { records } = response.data;\r\n                    this.types = records;\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        async saveType() {\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.post(\r\n                    `/${this.resource}/attorney`,\r\n                    { description: this.form_attorney.name }\r\n                );\r\n\r\n                if (response.status == 200) {\r\n                    let { id, message, success } = response.data;\r\n                    if (success) {\r\n                        this.form.attorney_id = id;\r\n                        this.$toast.success(message);\r\n                        this.getAttorneyTypes();\r\n                        this.form_attorney.add = false;\r\n                        this.form_attorney.name = null;\r\n                    } else {\r\n                        this.$toast.error(message);\r\n                    }\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        async getTables() {\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http(`/${this.resource}/tables`);\r\n                if (response.status == 200) {\r\n                    let {\r\n                        departments,\r\n                        provinces,\r\n                        countries,\r\n                        districts,\r\n                        identity_documents\r\n                    } = response.data;\r\n\r\n                    this.all_departments = departments;\r\n                    this.all_provinces = provinces;\r\n                    this.all_countries = countries;\r\n                    this.all_districts = districts;\r\n                    this.identityDocuments = identity_documents;\r\n                    this.departments = departments;\r\n                    this.provinces = provinces;\r\n                    this.countries = countries;\r\n                    this.districts = districts;\r\n                }\r\n\r\n                this.form.identity_document_type_id = \"1\";\r\n                // this.form_children.identity_document_type_id = \"1\";\r\n                this.documentTypeChildren = \"1\";\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        close() {\r\n            this.$emit(\"update:showDialog\", false);\r\n        },\r\n        async open() {\r\n            this.initForm();\r\n            this.recordId && (this.title = \"Editar registro\");\r\n\r\n            if (this.recordId) {\r\n                try {\r\n                    this.loading = true;\r\n                    const response = await this.$http(\r\n                        `/${this.resource}/update/${\r\n                            this.recordId\r\n                        }?from_person=${this.fromPerson ? 1 : \"\"}`\r\n                    );\r\n                    const { data } = response.data;\r\n                    this.form = data;\r\n                    this.documentNumber = this.form.number;\r\n                    this.children = this.form.children;\r\n                } catch (e) {\r\n                    console.log(e);\r\n                    this.$toast.error(\r\n                        \"Ocurrió un error al obtener el registro\"\r\n                    );\r\n                } finally {\r\n                    this.loading = false;\r\n                }\r\n            }\r\n        },\r\n        async searchCustomer() {\r\n            let documentNumber =\r\n                this.tab == \"parent\"\r\n                    ? this.documentNumber\r\n                    : this.documentNumberChildren;\r\n            if (documentNumber == null || documentNumber == \"\") return;\r\n            if (documentNumber.length != 8 && documentNumber.length != 11) {\r\n                this.$toast.error(\"Ingrese un documento válido\");\r\n                return;\r\n            }\r\n            if (this.timer) {\r\n                clearTimeout(this.timer);\r\n            }\r\n            this.timer = setTimeout(async () => {\r\n                try {\r\n                    this.currentCustomer = null;\r\n                    this.loading_search = true;\r\n                    const response = await this.$http(\r\n                        `/${this.resource}/${documentNumber}?type=${\r\n                            this.tab == \"parent\" ? \"parent\" : \"student\"\r\n                        }`\r\n                    );\r\n                    if (response.status == 200) {\r\n                        const { data } = response;\r\n                        if (data.numero || data.ruc) {\r\n                            if (this.tab == \"parent\") {\r\n                                if (documentNumber.length == 8) {\r\n                                    this.form.name = data.nombre_completo;\r\n                                } else {\r\n                                    this.form.name = data.nombre_o_razon_social;\r\n                                    this.form.state = data.estado;\r\n                                    this.form.condition = data.condicion;\r\n                                }\r\n\r\n                                this.form.address = data.direccion_completa;\r\n                                if (data.ubigeo.length == 3) {\r\n                                    let [\r\n                                        department,\r\n                                        province,\r\n                                        district\r\n                                    ] = data.ubigeo;\r\n                                    this.form.department_id = department;\r\n                                    this.form.province_id = province;\r\n                                    this.form.district_id = district;\r\n                                }\r\n                            } else {\r\n                                this.form_children.name = data.nombre_completo;\r\n                            }\r\n                        } else {\r\n                            this.$toast.error(\r\n                                data.message || \"No se encontró el documento\"\r\n                            );\r\n                        }\r\n                    } else {\r\n                        this.$toast.error(\"No se pudo obtener los datos\");\r\n                    }\r\n                } catch (e) {\r\n                    this.$toast.error(\"No se pudo obtener los datos\");\r\n                } finally {\r\n                    this.loading_search = false;\r\n                }\r\n            }, 250);\r\n        },\r\n        filterProvince() {\r\n            this.form.province_id = null;\r\n            this.form.district_id = null;\r\n            this.filterProvinces();\r\n        },\r\n        filterProvinces() {\r\n            this.provinces = this.all_provinces.filter(f => {\r\n                return f.department_id === this.form.department_id;\r\n            });\r\n        },\r\n        filterDistrict() {\r\n            this.form.district_id = null;\r\n            this.filterDistricts();\r\n        },\r\n        filterDistricts() {\r\n            this.districts = this.all_districts.filter(f => {\r\n                return f.province_id === this.form.province_id;\r\n            });\r\n        },\r\n        closeProperty() {\r\n            this.form.state = null;\r\n            this.form.condition = null;\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-bf046f30\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/persons/form.vue":
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
      on: { close: _vm.close, open: _vm.open }
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
          staticClass: "form-body"
        },
        [
          _c(
            "el-tabs",
            {
              attrs: { "tab-position": "top" },
              model: {
                value: _vm.tab,
                callback: function($$v) {
                  _vm.tab = $$v
                },
                expression: "tab"
              }
            },
            [
              _c(
                "el-tab-pane",
                { attrs: { name: "parent", label: "Datos del Cliente" } },
                [
                  _c("div", { staticClass: "card" }, [
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "div",
                        { staticClass: "col-md-3 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Tipo de documento")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              staticStyle: { width: "100%" },
                              on: { change: _vm.closeProperty },
                              model: {
                                value: _vm.form.identity_document_type_id,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.form,
                                    "identity_document_type_id",
                                    $$v
                                  )
                                },
                                expression: "form.identity_document_type_id"
                              }
                            },
                            _vm._l(_vm.identityDocuments, function(option) {
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
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-md-3 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Documento")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-input",
                            {
                              staticClass: "to_left",
                              staticStyle: { width: "100%" },
                              attrs: { controls: false },
                              on: { input: _vm.closeProperty },
                              model: {
                                value: _vm.documentNumber,
                                callback: function($$v) {
                                  _vm.documentNumber = $$v
                                },
                                expression: "documentNumber"
                              }
                            },
                            [
                              _vm.form.identity_document_type_id == 1 ||
                              _vm.form.identity_document_type_id == 6
                                ? _c("el-button", {
                                    attrs: {
                                      slot: "append",
                                      loading: _vm.loading_search,
                                      icon: "el-icon-search"
                                    },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.searchCustomer.apply(
                                          null,
                                          arguments
                                        )
                                      }
                                    },
                                    slot: "append"
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
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Nombres")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
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
                      )
                    ]),
                    _vm._v(" "),
                    _vm.form.state && _vm.form.condition
                      ? _c("div", { staticClass: "row mt-2" }, [
                          _c("div", { staticClass: "col-md-6 col-12" }),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "col-md-3 col-12" },
                            [
                              _c("el-alert", {
                                attrs: {
                                  title: _vm.form.state,
                                  type:
                                    "" +
                                    (_vm.form.state == "ACTIVO"
                                      ? "success"
                                      : "error")
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "col-md-3" },
                            [
                              _c("el-alert", {
                                attrs: {
                                  title: _vm.form.condition,
                                  type:
                                    "" +
                                    (_vm.form.condition == "HABIDO"
                                      ? "success"
                                      : "error")
                                }
                              })
                            ],
                            1
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _c("div", { staticClass: "row mt-2" }, [
                      _c("div", { staticClass: "col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: { "has-danger": _vm.errors.country_id }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("País")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  dusk: "country_id",
                                  disabled: ""
                                },
                                model: {
                                  value: _vm.form.country_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "country_id", $$v)
                                  },
                                  expression: "form.country_id"
                                }
                              },
                              _vm._l(_vm.countries, function(option) {
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
                            _vm.errors.country_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.country_id[0]
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
                            class: {
                              "has-danger": _vm.errors.department_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Departamento")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  "popper-class": "el-select-departments",
                                  dusk: "department_id"
                                },
                                on: { change: _vm.filterProvince },
                                model: {
                                  value: _vm.form.department_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "department_id", $$v)
                                  },
                                  expression: "form.department_id"
                                }
                              },
                              _vm._l(_vm.departments, function(option) {
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
                            _vm.errors.department_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.department_id[0]
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
                            class: {
                              "has-danger": _vm.errors.province_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Provincia")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  "popper-class": "el-select-provinces",
                                  dusk: "province_id"
                                },
                                on: { change: _vm.filterDistrict },
                                model: {
                                  value: _vm.form.province_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "province_id", $$v)
                                  },
                                  expression: "form.province_id"
                                }
                              },
                              _vm._l(_vm.provinces, function(option) {
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
                            _vm.errors.province_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.province_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c("div", { staticClass: "col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.district_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Distrito")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  "popper-class": "el-select-districts",
                                  dusk: "district_id"
                                },
                                on: { change: _vm.updateAll },
                                model: {
                                  value: _vm.form.district_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "district_id", $$v)
                                  },
                                  expression: "form.district_id"
                                }
                              },
                              _vm._l(_vm.districts, function(option) {
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
                            _vm.errors.district_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.district_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-8" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: { "has-danger": _vm.errors.address }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Dirección")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-input",
                              {
                                attrs: { dusk: "address" },
                                model: {
                                  value: _vm.form.address,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "address", $$v)
                                  },
                                  expression: "form.address"
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
                            _vm.errors.address
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(_vm.errors.address[0])
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "div",
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Teléfono")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form.phone,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "phone", $$v)
                              },
                              expression: "form.phone"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Correo")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form.email,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "email", $$v)
                              },
                              expression: "form.email"
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
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Teléfono secundario")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form.extra_phone,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "extra_phone", $$v)
                              },
                              expression: "form.extra_phone"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Relacion")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              model: {
                                value: _vm.form.type,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "type", $$v)
                                },
                                expression: "form.type"
                              }
                            },
                            [
                              _c("el-option", {
                                attrs: { value: "mother", label: "Madre" }
                              }),
                              _vm._v(" "),
                              _c("el-option", {
                                attrs: { value: "father", label: "Padre" }
                              }),
                              _vm._v(" "),
                              _c("el-option", {
                                attrs: { value: "attorney", label: "Apoderado" }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row mt-2" }, [
                      _vm.form.type == "attorney"
                        ? _c(
                            "div",
                            { staticClass: "col-md-6 col-12" },
                            [
                              _c(
                                "label",
                                {
                                  staticClass: "control-label",
                                  attrs: { for: "number" }
                                },
                                [_vm._v("Tipo de apoderado")]
                              ),
                              _vm._v(" "),
                              _vm.form_attorney.add == false
                                ? _c(
                                    "a",
                                    {
                                      staticClass:
                                        "control-label font-weight-bold text-info",
                                      attrs: { href: "#" },
                                      on: {
                                        click: function($event) {
                                          _vm.form_attorney.add = true
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                [ + Nuevo]"
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.form_attorney.add == true
                                ? _c(
                                    "a",
                                    {
                                      staticClass:
                                        "control-label font-weight-bold text-info",
                                      attrs: { href: "#" },
                                      on: {
                                        click: function($event) {
                                          return _vm.saveType()
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                [ + Guardar]"
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.form_attorney.add == true
                                ? _c(
                                    "a",
                                    {
                                      staticClass:
                                        "control-label font-weight-bold text-danger",
                                      attrs: { href: "#" },
                                      on: {
                                        click: function($event) {
                                          _vm.form_attorney.add = false
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                [ Cancelar]"
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.form_attorney.add == true
                                ? _c(
                                    "el-input",
                                    {
                                      staticStyle: { "margin-bottom": "1.5%" },
                                      attrs: { dusk: "item_code" },
                                      on: { input: _vm.searchType },
                                      model: {
                                        value: _vm.form_attorney.name,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.form_attorney,
                                            "name",
                                            $$v
                                          )
                                        },
                                        expression: "form_attorney.name"
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
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.form_attorney.add == false
                                ? _c(
                                    "el-select",
                                    {
                                      attrs: { filterable: "", clearable: "" },
                                      model: {
                                        value: _vm.form.attorney_id,
                                        callback: function($$v) {
                                          _vm.$set(_vm.form, "attorney_id", $$v)
                                        },
                                        expression: "form.attorney_id"
                                      }
                                    },
                                    _vm._l(_vm.types, function(option) {
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
                                : _vm._e()
                            ],
                            1
                          )
                        : _vm._e()
                    ])
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "el-tab-pane",
                {
                  attrs: { name: "children", label: "Datos de los estudiantes" }
                },
                [
                  _c("div", { staticClass: "card" }, [
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "div",
                        { staticClass: "col-md-3 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Tipo de documento")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              staticStyle: { width: "100%" },
                              model: {
                                value: _vm.documentTypeChildren,
                                callback: function($$v) {
                                  _vm.documentTypeChildren = $$v
                                },
                                expression: "documentTypeChildren"
                              }
                            },
                            _vm._l(_vm.identityDocuments, function(option) {
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
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-md-3 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Documento")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-input",
                            {
                              staticClass: "to_left",
                              staticStyle: { width: "100%" },
                              attrs: { controls: false },
                              model: {
                                value: _vm.documentNumberChildren,
                                callback: function($$v) {
                                  _vm.documentNumberChildren = $$v
                                },
                                expression: "documentNumberChildren"
                              }
                            },
                            [
                              _vm.documentTypeChildren == "1"
                                ? _c("el-button", {
                                    attrs: {
                                      slot: "append",
                                      loading: _vm.loading_search,
                                      icon: "el-icon-search"
                                    },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.searchCustomer.apply(
                                          null,
                                          arguments
                                        )
                                      }
                                    },
                                    slot: "append"
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
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Nombres")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form_children.name,
                              callback: function($$v) {
                                _vm.$set(_vm.form_children, "name", $$v)
                              },
                              expression: "form_children.name"
                            }
                          })
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row justify-content-end" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-md-3 col-12 align-self-end d-flex justify-content-end"
                        },
                        [
                          _c(
                            "el-button",
                            {
                              staticClass: " mt-2",
                              attrs: { type: "primary" },
                              on: { click: _vm.addChildren }
                            },
                            [
                              _vm._v(
                                "\n                                Agregar\n                            "
                              )
                            ]
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row mt-2 p-2" }, [
                      _c("table", { staticClass: "table" }, [
                        _c("thead", [
                          _c("tr", [
                            _c("th", [_vm._v("#")]),
                            _vm._v(" "),
                            _c("th", [_vm._v("Nombre")]),
                            _vm._v(" "),
                            _c("th", [_vm._v("Documento")]),
                            _vm._v(" "),
                            _c("th")
                          ])
                        ]),
                        _vm._v(" "),
                        _c(
                          "tbody",
                          _vm._l(_vm.children, function(child, idx) {
                            return _c("tr", { key: idx }, [
                              _c("td", [_vm._v(_vm._s(idx + 1))]),
                              _vm._v(" "),
                              _c("td", [_vm._v(_vm._s(child.name))]),
                              _vm._v(" "),
                              _c("td", [
                                _vm._v(
                                  "\n                                        " +
                                    _vm._s(child.number) +
                                    "\n\n                                        "
                                ),
                                _c("br"),
                                _vm._v(" "),
                                _c("small", [
                                  _vm._v(
                                    "\n                                            " +
                                      _vm._s(
                                        _vm.getDocumentType(
                                          child.identity_document_type_id
                                        )
                                      ) +
                                      "\n                                        "
                                  )
                                ])
                              ]),
                              _vm._v(" "),
                              _c(
                                "td",
                                [
                                  child.edit
                                    ? _c("el-button", {
                                        attrs: {
                                          type: "success",
                                          size: "mini",
                                          icon: "el-icon-edit",
                                          circle: ""
                                        },
                                        on: {
                                          click: function($event) {
                                            return _vm.editPerson(child)
                                          }
                                        }
                                      })
                                    : _vm._e(),
                                  _vm._v(" "),
                                  !child.id
                                    ? _c("el-button", {
                                        attrs: {
                                          type: "danger",
                                          size: "mini",
                                          icon: "el-icon-delete",
                                          circle: ""
                                        },
                                        on: {
                                          click: function($event) {
                                            return _vm.deleteChild(child)
                                          }
                                        }
                                      })
                                    : _vm._e()
                                ],
                                1
                              )
                            ])
                          }),
                          0
                        )
                      ])
                    ])
                  ])
                ]
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
        {
          staticClass: "dialog-footer",
          attrs: { slot: "footer" },
          slot: "footer"
        },
        [
          _c("el-button", { on: { click: _vm.close } }, [_vm._v("Cancelar")]),
          _vm._v(" "),
          _c(
            "el-button",
            { attrs: { type: "primary" }, on: { click: _vm.sendData } },
            [_vm._v("Guardar")]
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("person-form", {
        attrs: {
          external: false,
          recordId: _vm.currentPersonId,
          showDialog: _vm.showDialogNewPerson
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogNewPerson = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogNewPerson = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-bf046f30", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/views/persons/form.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("6f8e682d", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./form.vue", function() {
     var newContent = require("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=126.js.map