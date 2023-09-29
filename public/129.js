webpackJsonp([129],{

/***/ "./modules/College/Resources/assets/js/views/classrooms/register_form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/classrooms/register_form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-363a89f8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/classrooms/register_form.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/views/classrooms/register_form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-363a89f8", Component.options)
  } else {
    hotAPI.reload("data-v-363a89f8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/classrooms/register_form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_moment__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }



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


var CreateForm = function CreateForm() {
  return __webpack_require__.e/* import() */(127/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/views/persons/form.vue"));
};

var PaymentForm = function PaymentForm() {
  return __webpack_require__.e/* import() */(126/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/payment_college.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "record"],
  components: {
    CreateForm: CreateForm,
    PaymentForm: PaymentForm
  },
  data: function data() {
    return {
      currentParent: null,
      testForm: {
        document_type_id: "01",
        difference: 16,
        customer_id: 1
      },
      showPaymentForm: false,
      showCreateMemberForm: false,
      title: "Crear nuevo",
      loading: false,
      resource: "registers",
      form: {},
      periods: [],
      tab: "plan",
      students: [],
      items: [],
      loading_search_item: false,
      timer: null,
      parents: [],
      plans: [],
      members: [],
      price: null,
      percentage_igv: 18,
      affectationIgvTypes: [],
      establishment: null,
      methodPayment: null,
      user: null,
      currencyTypes: [],
      documentsType: [],
      company: null,
      categories: []
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
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    initForm: function initForm() {
      this.form = {};
    },
    updateTotal: function updateTotal() {
      var _this2 = this;

      if (!this.form.plan_id || !this.form.parent_id || !this.form.member_id) {
        return;
      }

      var plan = this.plans.find(function (p) {
        return p.id == _this2.form.plan_id;
      });
      var items = [];

      if (plan) {
        items = plan.services.map(function (s) {
          s.item.sale_unit_price = s.price;
          s.item.percentage_igv = 18;
          return s.item;
        });
      }

      var name = plan.name,
          description = plan.description;

      var _this$members$find = this.members.find(function (m) {
        return m.id == _this2.form.member_id;
      }),
          id = _this$members$find.id,
          parent = _this$members$find.parent,
          person = _this$members$find.person;

      var form = {
        member_id: id,
        plan_id: plan.id,
        first_pay: "2023-01-30",
        last_pay: "2023-01-30",
        payment_count: 1,
        active: 1,
        detail: {
          items: items
        }
      };
      this.$emit("createFormRegister", form);
      var observation = "".concat(name, " - ").concat(description, " ").toUpperCase();
      this.$emit("updateItems", items);
      this.$emit("updateObservation", observation);
      this.$emit("updateCustomer", parent.person); //member_id, plan_id, classroom_id, first_pay, last_pay, payment_count, active
      // this.$emit("updateTotal", total);
    },
    typeParent: function typeParent(type) {
      var types = {
        mother: "Madre:",
        father: "Padre:",
        attorney: "Apoderado:"
      };
      return types[type];
    },
    memberCreated: function memberCreated(number) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this3.searchRemoteParent(number);

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    editMember: function editMember() {
      this.currentParent = this.form.parent_id;
      this.showCreateMemberForm = true;
    },
    openCreateMember: function openCreateMember() {
      this.currentParent = null;
      this.showCreateMemberForm = true;
    },
    searchRemoteParent: function searchRemoteParent(input) {
      var _this4 = this;

      if (input.length > 2) {
        if (this.timer) {
          clearTimeout(this.timer);
        }

        this.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
          var parameters, response, _this4$parents, parent;

          return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
            while (1) {
              switch (_context4.prev = _context4.next) {
                case 0:
                  _context4.prev = 0;
                  parameters = "description=".concat(input);
                  _this4.loading_search = true;
                  _context4.next = 5;
                  return _this4.$http.get("/college/registers/parents?".concat(parameters));

                case 5:
                  response = _context4.sent;
                  _this4.parents = response.data;

                  if (_this4.parents.length != 0) {
                    _this4$parents = _slicedToArray(_this4.parents, 1), parent = _this4$parents[0];
                    setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
                      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
                        while (1) {
                          switch (_context3.prev = _context3.next) {
                            case 0:
                              _this4.form.parent_id = parent.id;
                              _context3.next = 3;
                              return _this4.getMember();

                            case 3:
                            case "end":
                              return _context3.stop();
                          }
                        }
                      }, _callee3);
                    })));
                  }

                  _context4.next = 13;
                  break;

                case 10:
                  _context4.prev = 10;
                  _context4.t0 = _context4["catch"](0);
                  console.log(_context4.t0);

                case 13:
                  _context4.prev = 13;
                  _this4.loading_search = false;
                  return _context4.finish(13);

                case 16:
                case "end":
                  return _context4.stop();
              }
            }
          }, _callee4, null, [[0, 10, 13, 16]]);
        })), 250);
      }
    },
    getMember: function getMember() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var response, _this5$members, member;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                if (_this5.form.parent_id) {
                  _context5.next = 3;
                  break;
                }

                _this5.form.member_id = null;
                return _context5.abrupt("return");

              case 3:
                _context5.prev = 3;
                _this5.loading = true;
                _context5.next = 7;
                return _this5.$http.get("/college/persons/member/".concat(_this5.form.parent_id));

              case 7:
                response = _context5.sent;
                _this5.members = response.data;

                if (_this5.members.length != 0) {
                  _this5$members = _slicedToArray(_this5.members, 1), member = _this5$members[0];
                  _this5.form.member_id = member.id;
                } else {
                  _this5.form.member_id = null;
                }

                _this5.updateTotal();

                _context5.next = 16;
                break;

              case 13:
                _context5.prev = 13;
                _context5.t0 = _context5["catch"](3);
                console.log(_context5.t0);

              case 16:
                _context5.prev = 16;
                _this5.loading = false;
                return _context5.finish(16);

              case 19:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, null, [[3, 13, 16, 19]]);
      }))();
    },
    initItemForm: function initItemForm() {
      this.form.item_id = null;
      this.form.disabled = false;
      this.price = null;
    },
    deleteService: function deleteService(id) {
      this.services = this.services.filter(function (s) {
        return s.item_id != id;
      });
    },
    changeItem: function changeItem() {
      var _this6 = this;

      var item = this.items.find(function (i) {
        return i.id == _this6.form.item_id;
      });
      var sale_unit_price = item.sale_unit_price;
      this.price = Number(sale_unit_price).toFixed(2);
    },
    addItem: function addItem() {
      var _this7 = this;

      var item = this.items.find(function (i) {
        return i.id == _this7.form.item_id;
      });
      var id = item.id;

      if (this.services.some(function (s) {
        return s.item_id == id;
      })) {
        return this.$toast.error("Ya agregó ese servicio");
      }

      this.services = [].concat(_toConsumableArray(this.services), [{
        price: this.price,
        item: item,
        item_id: item.id
      }]);
      this.initItemForm();
    },
    searchRemoteItems: function searchRemoteItems(input) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee7() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                if (input.length > 2) {
                  if (_this8.timer) {
                    clearTimeout(_this8.timer);
                  }

                  _this8.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
                    var parameters, response;
                    return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
                      while (1) {
                        switch (_context6.prev = _context6.next) {
                          case 0:
                            _context6.prev = 0;
                            parameters = "input=".concat(input);
                            _this8.loading_search = true;
                            _context6.next = 5;
                            return _this8.$http.get("/documents/data-table/items?series=1&".concat(parameters));

                          case 5:
                            response = _context6.sent;
                            _this8.items = response.data;
                            _context6.next = 12;
                            break;

                          case 9:
                            _context6.prev = 9;
                            _context6.t0 = _context6["catch"](0);
                            console.log(_context6.t0);

                          case 12:
                            _context6.prev = 12;
                            _this8.loading_search = false;
                            return _context6.finish(12);

                          case 15:
                          case "end":
                            return _context6.stop();
                        }
                      }
                    }, _callee6, null, [[0, 9, 12, 15]]);
                  })), 250);
                }

              case 1:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    getTables: function getTables() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee8() {
        var response, _response$data, plans, parents;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                _context8.prev = 0;
                _this9.loading = true;
                _context8.next = 4;
                return _this9.$http.get("/college/".concat(_this9.resource, "/tables?register=1"));

              case 4:
                response = _context8.sent;
                _response$data = response.data, plans = _response$data.plans, parents = _response$data.parents;
                _this9.plans = plans.map(function (r) {
                  return _objectSpread(_objectSpread({}, r), {}, {
                    total: r.services.reduce(function (a, b) {
                      return a + Number(b.price);
                    }, 0)
                  });
                });
                _this9.parents = parents;
                _context8.next = 14;
                break;

              case 10:
                _context8.prev = 10;
                _context8.t0 = _context8["catch"](0);
                console.log(_context8.t0);

                _this9.$toast.error("Ocurrió un problema");

              case 14:
                _context8.prev = 14;
                _this9.loading = false;
                return _context8.finish(14);

              case 17:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8, null, [[0, 10, 14, 17]]);
      }))();
    },
    open: function open() {
      this.form = {
        year: __WEBPACK_IMPORTED_MODULE_1_moment___default()().year()
      };

      if (this.record) {
        var record = this.record;
        this.title = "Matricula ".concat(record.level, " | ").concat(record.degree, "-").concat(record.section, " | ").concat(record.turn);
      } else {
        this.title = "Crear nuevo sal\xF3n";
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-363a89f8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/classrooms/register_form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
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
          staticClass: "card bg-light"
        },
        [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-md-6 col-12" },
              [
                _c("label", { staticClass: "label-control w-100" }, [
                  _vm._v("Apoderado\n                    "),
                  _c(
                    "a",
                    {
                      staticClass: "control-label font-weight-bold text-info",
                      attrs: { href: "#" },
                      on: { click: _vm.openCreateMember }
                    },
                    [_vm._v("\n                        [ + Nuevo]")]
                  ),
                  _vm._v(" "),
                  _vm.form.parent_id
                    ? _c(
                        "a",
                        {
                          staticClass:
                            "control-label font-weight-bold text-info",
                          attrs: { href: "#" },
                          on: { click: _vm.openCreateMember }
                        },
                        [_vm._v("\n                        [ Editar]")]
                      )
                    : _vm._e()
                ]),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      filterable: "",
                      remote: "",
                      placeholder: "Nombre o código interno",
                      "remote-method": _vm.searchRemoteParent,
                      loading: _vm.loading_search_item
                    },
                    on: { change: _vm.getMember },
                    model: {
                      value: _vm.form.parent_id,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "parent_id", $$v)
                      },
                      expression: "form.parent_id"
                    }
                  },
                  _vm._l(_vm.parents, function(parent, idx) {
                    return _c("el-option", {
                      key: idx,
                      attrs: { label: parent.person.name, value: parent.id }
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
              { staticClass: "col-md-6 col-12" },
              [
                _c("label", { staticClass: "label-control w-100" }, [
                  _vm._v("Estudiante")
                ]),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    attrs: { disabled: !_vm.form.parent_id },
                    on: { change: _vm.updateTotal },
                    model: {
                      value: _vm.form.member_id,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "member_id", $$v)
                      },
                      expression: "form.member_id"
                    }
                  },
                  _vm._l(_vm.members, function(member, idx) {
                    return _c("el-option", {
                      key: idx,
                      attrs: { label: member.person.name, value: member.id }
                    })
                  }),
                  1
                )
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mt-2" }, [
            _c(
              "div",
              { staticClass: "col-12" },
              [
                _c("label", { staticClass: "label-control w-100" }, [
                  _vm._v("Plan")
                ]),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    attrs: { slot: "prepend" },
                    on: { change: _vm.updateTotal },
                    slot: "prepend",
                    model: {
                      value: _vm.form.plan_id,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "plan_id", $$v)
                      },
                      expression: "form.plan_id"
                    }
                  },
                  _vm._l(_vm.plans, function(plan, idx) {
                    return _c(
                      "el-tooltip",
                      {
                        key: idx,
                        attrs: {
                          placement: "left",
                          disabled: !plan.validity_date
                        }
                      },
                      [
                        _c(
                          "div",
                          { attrs: { slot: "content" }, slot: "content" },
                          [
                            _vm._v(
                              "\n                            Vence: " +
                                _vm._s(plan.validity_date) +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("el-option", {
                          attrs: {
                            label:
                              plan.name +
                              " " +
                              plan.description +
                              " S/" +
                              plan.total,
                            value: plan.id
                          }
                        })
                      ],
                      1
                    )
                  }),
                  1
                )
              ],
              1
            )
          ])
        ]
      ),
      _vm._v(" "),
      _c("create-form", {
        attrs: {
          showDialog: _vm.showCreateMemberForm,
          extern: true,
          recordId: _vm.form.parent_id
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showCreateMemberForm = $event
          },
          "update:show-dialog": function($event) {
            _vm.showCreateMemberForm = $event
          },
          memberCreated: _vm.memberCreated
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
    require("vue-hot-reload-api")      .rerender("data-v-363a89f8", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=129.js.map