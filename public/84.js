<<<<<<< HEAD
webpackJsonp([84],{F19N:function(t,n){t.exports={render:function(){var t=this,n=t.$createElement,s=t._self._c||n;return s("div",{staticClass:"mt-5"},[s("div",{staticClass:"row d-flex justify-content-center mb-3"},[s("div",{staticClass:"col-md-4"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.maskPin,expression:"maskPin"}],staticClass:"form-control",staticStyle:{"text-align":"center","letter-spacing":"1rem"},attrs:{type:"text",size:"2",name:"listeanzahl",value:"10"},domProps:{value:t.maskPin},on:{input:function(n){n.target.composing||(t.maskPin=n.target.value)}}})])]),t._v(" "),s("div",{staticClass:"container d-flex justify-content-center"},[s("div",{staticClass:"row justify-content-center"},[s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(1)}}},[t._v("\n          1\n        ")])]),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(2)}}},[t._v("\n          2\n        ")])]),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(3)}}},[t._v("\n          3\n        ")])]),t._v(" "),s("div",{staticClass:"w-100"}),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(4)}}},[t._v("\n          4\n        ")])]),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(5)}}},[t._v("\n          5\n        ")])]),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(6)}}},[t._v("\n          6\n        ")])]),t._v(" "),s("div",{staticClass:"w-100"}),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(7)}}},[t._v("\n          7\n        ")])]),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(8)}}},[t._v("\n          8\n        ")])]),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(9)}}},[t._v("\n          9\n        ")])]),t._v(" "),s("div",{staticClass:"w-100"}),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-primary btn-block",on:{click:function(n){return t.getOption(0)}}},[t._v("\n          0\n        ")])]),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-danger btn-block",on:{click:function(n){return t.getOption("delete")}}},[t._v("\n          Eliminar\n        ")])]),t._v(" "),s("div",{staticClass:"col-4 col-sm-4 col-md-4 p-1"},[s("button",{staticClass:"btn btn-success btn-block",on:{click:t.enter}},[t._v("\n          Ingresar\n        ")])])])])])},staticRenderFns:[]}},IB0k:function(t,n,s){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var i=s("j0x6"),o=s.n(i);n.default={components:{Pad:o.a},data:function(){return{user:"tesctiyo"}},created:function(){console.log("creado")}}},"M/O0":function(t,n,s){var i=s("VU/8")(s("IB0k"),s("mX3q"),!1,null,null,null);t.exports=i.exports},apQD:function(t,n,s){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var i=s("En79"),o=s.n(i);function e(t,n,s,i,o,e,c){try{var a=t[e](c),l=a.value}catch(t){return void s(t)}a.done?n(l):Promise.resolve(l).then(i,o)}n.default={data:function(){return{maskPin:null,pinHide:"",person:null,persons:["Administrador","Mozo","Cocinero"]}},methods:{getOption:function(t){if("delete"==t)return this.pinHide="",void(this.maskPin=null);this.pinHide&&4==this.pinHide.length||(this.pinHide+=t.toString(),this.maskPin="*".repeat(this.pinHide.length))},enter:function(){var t,n=this;return(t=o.a.mark(function t(){var s,i,e,c,a;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,n.$http.post("login",{pin:n.pinHide});case 2:s=t.sent,i=s.data,e=i.success,c=i.kitchen,a=i.pos,e?(n.$toast.success("Sesión exitosa. Bienvenido/a ."),window.location.href=c?"worker/dashboard-kitchen":a?"worker/dashboard-pos":"worker/dashboard"):(n.$toast.error("El PIN no existe. Vuelva a intentarlo."),n.pinHide="",n.maskPin=null);case 5:case"end":return t.stop()}},t)}),function(){var n=this,s=arguments;return new Promise(function(i,o){var c=t.apply(n,s);function a(t){e(c,i,o,a,l,"next",t)}function l(t){e(c,i,o,a,l,"throw",t)}a(void 0)})})()}}}},j0x6:function(t,n,s){var i=s("VU/8")(s("apQD"),s("F19N"),!1,null,null,null);t.exports=i.exports},mX3q:function(t,n){t.exports={render:function(){var t=this.$createElement,n=this._self._c||t;return n("div",{staticClass:"col-md-12 text-center"},[n("pad")],1)},staticRenderFns:[]}}});
=======
webpackJsonp([84],{

/***/ "./modules/Internet/Resources/assets/js/view/pos/partials/document_print_detail.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
<<<<<<< HEAD
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/document_print_detail.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1bfeb81a\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/document_print_detail.vue")
=======
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/login/login.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0814b47c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/login/login.vue")
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
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
<<<<<<< HEAD
Component.options.__file = "modules/Internet/Resources/assets/js/view/pos/partials/document_print_detail.vue"
=======
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/login/login.vue"
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
<<<<<<< HEAD
    hotAPI.createRecord("data-v-1bfeb81a", Component.options)
  } else {
    hotAPI.reload("data-v-1bfeb81a", Component.options)
=======
    hotAPI.createRecord("data-v-0814b47c", Component.options)
  } else {
    hotAPI.reload("data-v-0814b47c", Component.options)
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
<<<<<<< HEAD
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-c9ff31dc\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-c9ff31dc\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
=======
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/login/pad.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7de5de2c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/login/pad.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
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
<<<<<<< HEAD
Component.options.__file = "modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue"
=======
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/login/pad.vue"
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
<<<<<<< HEAD
    hotAPI.createRecord("data-v-c9ff31dc", Component.options)
  } else {
    hotAPI.reload("data-v-c9ff31dc", Component.options)
=======
    hotAPI.createRecord("data-v-7de5de2c", Component.options)
  } else {
    hotAPI.reload("data-v-7de5de2c", Component.options)
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./modules/Internet/Resources/assets/js/view/pos/partials/whatsapp_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/whatsapp_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-08ff58c4\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/whatsapp_modal.vue")
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
Component.options.__file = "modules/Internet/Resources/assets/js/view/pos/partials/whatsapp_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-08ff58c4", Component.options)
  } else {
    hotAPI.reload("data-v-08ff58c4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/document_print_detail.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
<<<<<<< HEAD
<<<<<<< HEAD
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__whatsapp_modal_vue__ = __webpack_require__("./modules/Internet/Resources/assets/js/view/pos/partials/whatsapp_modal.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__whatsapp_modal_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__whatsapp_modal_vue__);


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
=======
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__pad_vue__ = __webpack_require__("./modules/Restaurant/Resources/assets/js/views/login/pad.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__pad_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__pad_vue__);
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
<<<<<<< HEAD
    whatsappModal: __WEBPACK_IMPORTED_MODULE_1__whatsapp_modal_vue___default.a
  },
  props: ["records", "pagination", "type", "company", "sender"],
  data: function data() {
    return {
      loading: false,
      showWhatsappModal: false,
      currentId: null,
      currentType: null,
      currentNumber: null
    };
  },
  methods: {
    clickOpenWhatsapp: function clickOpenWhatsapp(record) {
      this.showWhatsappModal = true;
      this.currentId = record.id;
      this.currentType = record.document_type_id;

      if (this.type == "saleNotes") {
        this.currentNumber = record.full_number;
      } else {
        this.currentNumber = record.number;
      }
    },
    clickSendOnline: function clickSendOnline(document_id) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _this.loading = true;
                _context.next = 4;
                return _this.$http.get("/documents/send/".concat(document_id));

              case 4:
                response = _context.sent;

                if (response.data.success) {
                  _this.$toast.success("Se envio satisfactoriamente el comprobante.");

                  _this.$eventHub.$emit("reloadData"); // this.clickCheckOnline(document_id);

                } else {
                  _this.$toast.error(response.data.message);
                }

                _context.next = 11;
                break;

              case 8:
                _context.prev = 8;
                _context.t0 = _context["catch"](0);

                _this.$toast.error(_context.t0.response.data.message);

              case 11:
                _context.prev = 11;
                _this.loading = false;
                return _context.finish(11);

              case 14:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 8, 11, 14]]);
      }))();
    },
    clickReStore: function clickReStore(document_id) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _this2.loading = true;
                _context2.next = 4;
                return _this2.$http.get("/documents/re_store/".concat(document_id));

              case 4:
                response = _context2.sent;
                console.log(response);

                if (response.data.success) {
                  _this2.$toast.success(response.data.message);
                } else {
                  _this2.$toast.error(response.data.message);
                }

                _context2.next = 12;
                break;

              case 9:
                _context2.prev = 9;
                _context2.t0 = _context2["catch"](0);

                _this2.$toast.error(_context2.t0.response.data.message);

              case 12:
                _context2.prev = 12;
                _this2.loading = false;
                return _context2.finish(12);

              case 15:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[0, 9, 12, 15]]);
      }))();
    },
    clickValidarCpe: function clickValidarCpe(document_id) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.prev = 0;
                _this3.loading = true;
                _context3.next = 4;
                return _this3.$http.get("/documents/validate/".concat(document_id));

              case 4:
                response = _context3.sent;

                if (response.data.success) {
                  _this3.$toast.success(response.data.message);

                  _this3.$emit("getRecords", _this3.pagination.current_page);
                } else {
                  _this3.$toast.error(response.data.message);
                }

                _context3.next = 11;
                break;

              case 8:
                _context3.prev = 8;
                _context3.t0 = _context3["catch"](0);

                _this3.$toast.error(_context3.t0.response.data.message);

              case 11:
                _context3.prev = 11;
                _this3.loading = false;
                return _context3.finish(11);

              case 14:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[0, 8, 11, 14]]);
      }))();
    },
    getRecords: function getRecords() {
      this.$emit("getRecords", this.pagination.current_page);
    },
    print: function print(external_id, type) {
      this.$emit("printData", external_id, type);
    }
  }
});
=======
eval("Object.defineProperty(__webpack_exports__, \"__esModule\", { value: true });\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__pad_vue__ = __webpack_require__(\"./modules/Restaurant/Resources/assets/js/views/login/pad.vue\");\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__pad_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__pad_vue__);\nfunction _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }\n\nfunction _nonIterableSpread() { throw new TypeError(\"Invalid attempt to spread non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _iterableToArray(iter) { if (typeof Symbol !== \"undefined\" && iter[Symbol.iterator] != null || iter[\"@@iterator\"] != null) return Array.from(iter); }\n\nfunction _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\n//\n//\n//\n//\n//\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  components: {\n    Pad: __WEBPACK_IMPORTED_MODULE_0__pad_vue___default.a\n  },\n  data: function data() {\n    return {\n      user: \"tesctiyo\"\n    };\n  },\n  created: function created() {\n    var _console;\n\n    /* eslint-disable */\n    (_console = console).log.apply(_console, _toConsumableArray(oo_oo(\"a6f74cb3_0\", \"creado\")));\n  }\n});\n/* eslint-disable */\n\n;\n\nfunction oo_cm() {\n  try {\n    return (0, eval)(\"globalThis._console_ninja\") || (0, eval)(\"/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x584fdf=_0x461e;(function(_0x18e9eb,_0x293457){var _0x329386=_0x461e,_0x105281=_0x18e9eb();while(!![]){try{var _0x58fec4=-parseInt(_0x329386(0x20c))/0x1*(-parseInt(_0x329386(0x208))/0x2)+parseInt(_0x329386(0x1f5))/0x3*(parseInt(_0x329386(0x2bf))/0x4)+parseInt(_0x329386(0x22a))/0x5+parseInt(_0x329386(0x278))/0x6+-parseInt(_0x329386(0x275))/0x7*(parseInt(_0x329386(0x243))/0x8)+parseInt(_0x329386(0x230))/0x9+-parseInt(_0x329386(0x2b0))/0xa;if(_0x58fec4===_0x293457)break;else _0x105281['push'](_0x105281['shift']());}catch(_0x164d76){_0x105281['push'](_0x105281['shift']());}}}(_0x1197,0x20f9c));var ue=Object[_0x584fdf(0x261)],te=Object[_0x584fdf(0x2ae)],he=Object['getOwnPropertyDescriptor'],le=Object[_0x584fdf(0x1f8)],fe=Object['getPrototypeOf'],_e=Object['prototype'][_0x584fdf(0x2b2)],pe=(_0x2092dd,_0x4c6506,_0x11ab6b,_0x318924)=>{var _0x5ac11b=_0x584fdf;if(_0x4c6506&&typeof _0x4c6506==_0x5ac11b(0x231)||typeof _0x4c6506==_0x5ac11b(0x225)){for(let _0x57dd03 of le(_0x4c6506))!_e[_0x5ac11b(0x25b)](_0x2092dd,_0x57dd03)&&_0x57dd03!==_0x11ab6b&&te(_0x2092dd,_0x57dd03,{'get':()=>_0x4c6506[_0x57dd03],'enumerable':!(_0x318924=he(_0x4c6506,_0x57dd03))||_0x318924[_0x5ac11b(0x283)]});}return _0x2092dd;},ne=(_0x58a200,_0x2f07f5,_0xaf6f72)=>(_0xaf6f72=_0x58a200!=null?ue(fe(_0x58a200)):{},pe(_0x2f07f5||!_0x58a200||!_0x58a200[_0x584fdf(0x2c9)]?te(_0xaf6f72,_0x584fdf(0x299),{'value':_0x58a200,'enumerable':!0x0}):_0xaf6f72,_0x58a200)),Q=class{constructor(_0x462b11,_0x4af76c,_0x28984d,_0x2f820b){var _0x41975f=_0x584fdf;this[_0x41975f(0x1f3)]=_0x462b11,this['host']=_0x4af76c,this[_0x41975f(0x27d)]=_0x28984d,this[_0x41975f(0x260)]=_0x2f820b,this[_0x41975f(0x288)]=!0x0,this['_allowedToConnectOnSend']=!0x0,this[_0x41975f(0x21e)]=!0x1,this[_0x41975f(0x213)]=!0x1,this['_inBrowser']=!!this['global'][_0x41975f(0x291)],this['_WebSocketClass']=null,this[_0x41975f(0x2b5)]=0x0,this['_maxConnectAttemptCount']=0x14,this[_0x41975f(0x2c1)]=this['_inBrowser']?'Console\\\\x20Ninja\\\\x20failed\\\\x20to\\\\x20send\\\\x20logs,\\\\x20refreshing\\\\x20the\\\\x20page\\\\x20may\\\\x20help':'Console\\\\x20Ninja\\\\x20failed\\\\x20to\\\\x20send\\\\x20logs,\\\\x20restarting\\\\x20the\\\\x20process\\\\x20may\\\\x20help';}async[_0x584fdf(0x237)](){var _0x3fe900=_0x584fdf;if(this['_WebSocketClass'])return this[_0x3fe900(0x2c8)];let _0x3b90df;if(this[_0x3fe900(0x29f)])_0x3b90df=this[_0x3fe900(0x1f3)]['WebSocket'];else{if(this['global']['process']?.[_0x3fe900(0x20a)])_0x3b90df=this[_0x3fe900(0x1f3)][_0x3fe900(0x262)]?.[_0x3fe900(0x20a)];else try{let _0x2d9ee6=await import(_0x3fe900(0x20b));_0x3b90df=(await import((await import(_0x3fe900(0x296)))[_0x3fe900(0x235)](_0x2d9ee6[_0x3fe900(0x298)](this[_0x3fe900(0x260)],_0x3fe900(0x259)))[_0x3fe900(0x203)]()))[_0x3fe900(0x299)];}catch{try{_0x3b90df=require(require(_0x3fe900(0x20b))[_0x3fe900(0x298)](this[_0x3fe900(0x260)],'ws'));}catch{throw new Error(_0x3fe900(0x2c0));}}}return this['_WebSocketClass']=_0x3b90df,_0x3b90df;}[_0x584fdf(0x1fa)](){var _0x154f2c=_0x584fdf;this[_0x154f2c(0x213)]||this[_0x154f2c(0x21e)]||this[_0x154f2c(0x2b5)]>=this[_0x154f2c(0x2ad)]||(this[_0x154f2c(0x20d)]=!0x1,this[_0x154f2c(0x213)]=!0x0,this['_connectAttemptCount']++,this['_ws']=new Promise((_0x34578b,_0x476de8)=>{var _0x15b04f=_0x154f2c;this[_0x15b04f(0x237)]()[_0x15b04f(0x26b)](_0x292c87=>{var _0x3775bf=_0x15b04f;let _0x134844=new _0x292c87(_0x3775bf(0x24f)+this[_0x3775bf(0x273)]+':'+this[_0x3775bf(0x27d)]);_0x134844[_0x3775bf(0x210)]=()=>{var _0x5c7329=_0x3775bf;this[_0x5c7329(0x288)]=!0x1,this[_0x5c7329(0x23a)](_0x134844),this[_0x5c7329(0x2a0)](),_0x476de8(new Error(_0x5c7329(0x256)));},_0x134844[_0x3775bf(0x1ec)]=()=>{var _0x4b7a1e=_0x3775bf;this[_0x4b7a1e(0x29f)]||_0x134844[_0x4b7a1e(0x28e)]&&_0x134844[_0x4b7a1e(0x28e)][_0x4b7a1e(0x238)]&&_0x134844[_0x4b7a1e(0x28e)]['unref'](),_0x34578b(_0x134844);},_0x134844[_0x3775bf(0x23f)]=()=>{var _0x4ce235=_0x3775bf;this[_0x4ce235(0x20d)]=!0x0,this[_0x4ce235(0x23a)](_0x134844),this[_0x4ce235(0x2a0)]();},_0x134844[_0x3775bf(0x24e)]=_0x52be5e=>{var _0x1fa936=_0x3775bf;try{_0x52be5e&&_0x52be5e[_0x1fa936(0x219)]&&this[_0x1fa936(0x29f)]&&JSON[_0x1fa936(0x2c2)](_0x52be5e['data'])[_0x1fa936(0x2b3)]===_0x1fa936(0x26f)&&this[_0x1fa936(0x1f3)][_0x1fa936(0x21b)]['reload']();}catch{}};})[_0x15b04f(0x26b)](_0x22d91c=>(this[_0x15b04f(0x21e)]=!0x0,this[_0x15b04f(0x213)]=!0x1,this[_0x15b04f(0x20d)]=!0x1,this['_allowedToSend']=!0x0,this[_0x15b04f(0x2b5)]=0x0,_0x22d91c))[_0x15b04f(0x22e)](_0x38ffe4=>(this[_0x15b04f(0x21e)]=!0x1,this[_0x15b04f(0x213)]=!0x1,_0x476de8(new Error(_0x15b04f(0x248)+(_0x38ffe4&&_0x38ffe4['message'])))));}));}[_0x584fdf(0x23a)](_0x34e69a){var _0x241a4b=_0x584fdf;this[_0x241a4b(0x21e)]=!0x1,this[_0x241a4b(0x213)]=!0x1;try{_0x34e69a[_0x241a4b(0x23f)]=null,_0x34e69a[_0x241a4b(0x210)]=null,_0x34e69a[_0x241a4b(0x1ec)]=null;}catch{}try{_0x34e69a[_0x241a4b(0x218)]<0x2&&_0x34e69a[_0x241a4b(0x267)]();}catch{}}[_0x584fdf(0x2a0)](){var _0xb05bd3=_0x584fdf;clearTimeout(this[_0xb05bd3(0x2ac)]),!(this['_connectAttemptCount']>=this['_maxConnectAttemptCount'])&&(this[_0xb05bd3(0x2ac)]=setTimeout(()=>{var _0x10965c=_0xb05bd3;this[_0x10965c(0x21e)]||this[_0x10965c(0x213)]||(this[_0x10965c(0x1fa)](),this['_ws']?.[_0x10965c(0x22e)](()=>this['_attemptToReconnectShortly']()));},0x1f4),this['_reconnectTimeout'][_0xb05bd3(0x238)]&&this[_0xb05bd3(0x2ac)][_0xb05bd3(0x238)]());}async[_0x584fdf(0x245)](_0x43f342){var _0x165481=_0x584fdf;try{if(!this[_0x165481(0x288)])return;this[_0x165481(0x20d)]&&this[_0x165481(0x1fa)](),(await this[_0x165481(0x282)])[_0x165481(0x245)](JSON[_0x165481(0x234)](_0x43f342));}catch(_0x216eab){console[_0x165481(0x272)](this[_0x165481(0x2c1)]+':\\\\x20'+(_0x216eab&&_0x216eab[_0x165481(0x214)])),this[_0x165481(0x288)]=!0x1,this[_0x165481(0x2a0)]();}}};function V(_0x56d6cc,_0x54dacc,_0x24971e,_0x20b3a9,_0x19f3b9){var _0x531ab7=_0x584fdf;let _0x819c33=_0x24971e[_0x531ab7(0x247)](',')[_0x531ab7(0x280)](_0xaf9460=>{var _0x528e99=_0x531ab7;try{_0x56d6cc['_console_ninja_session']||((_0x19f3b9===_0x528e99(0x295)||_0x19f3b9===_0x528e99(0x271))&&(_0x19f3b9+=_0x56d6cc[_0x528e99(0x262)]?.[_0x528e99(0x1f4)]?.['node']?_0x528e99(0x290):'\\\\x20browser'),_0x56d6cc[_0x528e99(0x252)]={'id':+new Date(),'tool':_0x19f3b9});let _0x255f9f=new Q(_0x56d6cc,_0x54dacc,_0xaf9460,_0x20b3a9);return _0x255f9f[_0x528e99(0x245)][_0x528e99(0x27f)](_0x255f9f);}catch(_0x5eff41){return console[_0x528e99(0x272)](_0x528e99(0x20f),_0x5eff41&&_0x5eff41['message']),()=>{};}});return _0x141af6=>_0x819c33['forEach'](_0x1969f3=>_0x1969f3(_0x141af6));}function _0x1197(){var _0x27be4e=['indexOf','_console_ninja','String',[\\\"localhost\\\",\\\"127.0.0.1\\\",\\\"example.cypress.io\\\",\\\"DESKTOP-PJKITJI\\\",\\\"http://127.0.0.1:5500\\\",\\\"http://127.0.0.1\\\",\\\"192.168.1.8\\\"],'_objectToString','_sortProps','_addProperty','556TIbHWq','failed\\\\x20to\\\\x20find\\\\x20and\\\\x20load\\\\x20WebSocket','_sendErrorMessage','parse','type','rootExpression','[object\\\\x20Map]','array','Set','_WebSocketClass','__es'+'Module','string','resolveGetters','onopen','_setNodeId','depth','_processTreeNodeResult','capped','hits','getOwnPropertySymbols','global','versions','4254xHRNIj','time','_additionalMetadata','getOwnPropertyNames','_undefined','_connectToHostNow','test','hostname','funcName','timeStamp','_p_','value','negativeZero','_treeNodePropertiesBeforeFullValue','toString','nuxt','1.0.0','_keyStrRegExp','elements','254QpgDUp','_addObjectProperty','_WebSocket','path','259Iwhkdb','_allowedToConnectOnSend','_getOwnPropertyNames','logger\\\\x20failed\\\\x20to\\\\x20connect\\\\x20to\\\\x20host','onerror','root_exp','_setNodeExpandableState','_connecting','message',\\\"c:\\\\\\\\Users\\\\\\\\carlo\\\\\\\\.vscode\\\\\\\\extensions\\\\\\\\wallabyjs.console-ninja-0.0.111\\\\\\\\node_modules\\\",'substr','concat','readyState','data','trace','location','date','[object\\\\x20Array]','_connected','constructor','_getOwnPropertyDescriptor','_blacklistedProperty','replace','_Symbol','_quotedRegExp','function','_propertyName','_isUndefined','unknown','bigint','871525asWNrg','level','timeEnd','now','catch','noFunctions','798165AXOrWd','object','reduceLimits','Buffer','stringify','pathToFileURL','_setNodePermissions','getWebSocketClass','unref','perf_hooks','_disposeWebsocket','negativeInfinity','length','autoExpandLimit','autoExpandMaxDepth','onclose','autoExpandPreviousObjects','includes','get','44216AVnXtk','allStrLength','send','serialize','split','failed\\\\x20to\\\\x20connect\\\\x20to\\\\x20host:\\\\x20','index','_isPrimitiveWrapperType','node','autoExpand','1682548355546','onmessage','ws://','stackTraceLimit','_dateToString','_console_ninja_session','console','slice','root_exp_id','logger\\\\x20websocket\\\\x20error','expId','valueOf','ws/index.js','_property','call','elapsed','_numberRegExp','error','HTMLAllCollection','nodeModules','create','process','_isNegativeZero','number','RegExp','sortProps','close','_isSet','Map','props','then','POSITIVE_INFINITY','_setNodeExpressionPath','log','reload','_getOwnPropertySymbols','remix','warn','host','parent','231APJnIl','prototype','Number','612402KgmSrr','autoExpandPropertyCount','count','stack','_cleanNode','port','_isPrimitiveType','bind','map','_setNodeLabel','_ws','enumerable','_hasSymbolPropertyOnItsPath','NEGATIVE_INFINITY','null','toLowerCase','_allowedToSend','...','set','_hasMapOnItsPath','_propertyAccessor','_addLoadNode','_socket','Error','\\\\x20server','WebSocket','push','_type','argumentResolutionError','next.js','url','performance','join','default',':logPointId:','current','forEach','_addFunctionsNode','','_inBrowser','_attemptToReconnectShortly','_isMap','_HTMLAllCollection','_capIfString','symbol','isExpressionToEvaluate','_treeNodePropertiesAfterFullValue','setter','_consoleNinjaAllowedToStart','name','Symbol','undefined','_reconnectTimeout','_maxConnectAttemptCount','defineProperty','_p_length','2775930FCeSzP','strLength','hasOwnProperty','method','cappedElements','_connectAttemptCount','getter','_setNodeQueryPath'];_0x1197=function(){return _0x27be4e;};return _0x1197();}function _0x461e(_0x21d1af,_0x3a21e1){var _0x11978a=_0x1197();return _0x461e=function(_0x461ed2,_0x1ee704){_0x461ed2=_0x461ed2-0x1ec;var _0x25afde=_0x11978a[_0x461ed2];return _0x25afde;},_0x461e(_0x21d1af,_0x3a21e1);}function H(_0x5a0c17){var _0x1d787b=_0x584fdf;let _0x55b572=function(_0x4ca8ef,_0x3e141f){return _0x3e141f-_0x4ca8ef;},_0x3eeb77;if(_0x5a0c17[_0x1d787b(0x297)])_0x3eeb77=function(){var _0x2bdcfe=_0x1d787b;return _0x5a0c17[_0x2bdcfe(0x297)][_0x2bdcfe(0x22d)]();};else{if(_0x5a0c17[_0x1d787b(0x262)]&&_0x5a0c17[_0x1d787b(0x262)]['hrtime'])_0x3eeb77=function(){var _0x534d16=_0x1d787b;return _0x5a0c17[_0x534d16(0x262)]['hrtime']();},_0x55b572=function(_0x2d0263,_0x21743e){return 0x3e8*(_0x21743e[0x0]-_0x2d0263[0x0])+(_0x21743e[0x1]-_0x2d0263[0x1])/0xf4240;};else try{let {performance:_0x4bf3cd}=require(_0x1d787b(0x239));_0x3eeb77=function(){return _0x4bf3cd['now']();};}catch{_0x3eeb77=function(){return+new Date();};}}return{'elapsed':_0x55b572,'timeStamp':_0x3eeb77,'now':()=>Date['now']()};}function X(_0x283b5c,_0x1b5eb1,_0x4fddc1){var _0x4a9765=_0x584fdf;if(_0x283b5c[_0x4a9765(0x2a8)]!==void 0x0)return _0x283b5c[_0x4a9765(0x2a8)];let _0x3acac3=_0x283b5c[_0x4a9765(0x262)]?.[_0x4a9765(0x1f4)]?.[_0x4a9765(0x24b)];return _0x3acac3&&_0x4fddc1===_0x4a9765(0x204)?_0x283b5c[_0x4a9765(0x2a8)]=!0x1:_0x283b5c[_0x4a9765(0x2a8)]=_0x3acac3||!_0x1b5eb1||_0x283b5c[_0x4a9765(0x21b)]?.['hostname']&&_0x1b5eb1[_0x4a9765(0x241)](_0x283b5c[_0x4a9765(0x21b)][_0x4a9765(0x1fc)]),_0x283b5c[_0x4a9765(0x2a8)];}((_0xa67ae3,_0x37389e,_0x51b77d,_0x25b630,_0x139821,_0x35c265,_0x507b7f,_0x36a717,_0x6c8a1c)=>{var _0x1d2333=_0x584fdf;if(_0xa67ae3['_console_ninja'])return _0xa67ae3[_0x1d2333(0x2b9)];if(!X(_0xa67ae3,_0x36a717,_0x139821))return _0xa67ae3[_0x1d2333(0x2b9)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0xa67ae3[_0x1d2333(0x2b9)];let _0x84b2b4={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x442bae={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2},_0x27190f=H(_0xa67ae3),_0x3c3278=_0x27190f[_0x1d2333(0x25c)],_0x23bc7a=_0x27190f[_0x1d2333(0x1fe)],_0x222c15=_0x27190f['now'],_0x48b520={'hits':{},'ts':{}},_0x2515cc=_0x5ddf2b=>{_0x48b520['ts'][_0x5ddf2b]=_0x23bc7a();},_0x43ca3a=(_0x4abd1c,_0x3908cf)=>{var _0x51706d=_0x1d2333;let _0x243232=_0x48b520['ts'][_0x3908cf];if(delete _0x48b520['ts'][_0x3908cf],_0x243232){let _0x3d0046=_0x3c3278(_0x243232,_0x23bc7a());_0x3c9226(_0x462b92(_0x51706d(0x1f6),_0x4abd1c,_0x222c15(),_0x131e0b,[_0x3d0046],_0x3908cf));}},_0x3fbbd5=_0x1e3ba1=>_0x424970=>{var _0x5bedb8=_0x1d2333;try{_0x2515cc(_0x424970),_0x1e3ba1(_0x424970);}finally{_0xa67ae3[_0x5bedb8(0x253)]['time']=_0x1e3ba1;}},_0x72181b=_0x18c4ac=>_0x4ee8fa=>{var _0xb66095=_0x1d2333;try{let [_0x4c31dd,_0x45ba32]=_0x4ee8fa['split'](_0xb66095(0x29a));_0x43ca3a(_0x45ba32,_0x4c31dd),_0x18c4ac(_0x4c31dd);}finally{_0xa67ae3['console'][_0xb66095(0x22c)]=_0x18c4ac;}};_0xa67ae3[_0x1d2333(0x2b9)]={'consoleLog':(_0x404cc4,_0x4e9f2b)=>{var _0x47b9a1=_0x1d2333;_0xa67ae3[_0x47b9a1(0x253)]['log']['name']!=='disabledLog'&&_0x3c9226(_0x462b92('log',_0x404cc4,_0x222c15(),_0x131e0b,_0x4e9f2b));},'consoleTrace':(_0x43c815,_0x1e2c5e)=>{var _0x5f59b8=_0x1d2333;_0xa67ae3[_0x5f59b8(0x253)][_0x5f59b8(0x26e)][_0x5f59b8(0x2a9)]!=='disabledTrace'&&_0x3c9226(_0x462b92(_0x5f59b8(0x21a),_0x43c815,_0x222c15(),_0x131e0b,_0x1e2c5e));},'consoleTime':()=>{var _0x431a01=_0x1d2333;_0xa67ae3[_0x431a01(0x253)][_0x431a01(0x1f6)]=_0x3fbbd5(_0xa67ae3['console'][_0x431a01(0x1f6)]);},'consoleTimeEnd':()=>{var _0x422774=_0x1d2333;_0xa67ae3[_0x422774(0x253)]['timeEnd']=_0x72181b(_0xa67ae3[_0x422774(0x253)]['timeEnd']);},'autoLog':(_0x4c1d58,_0x2af658)=>{var _0x3fd846=_0x1d2333;_0x3c9226(_0x462b92(_0x3fd846(0x26e),_0x2af658,_0x222c15(),_0x131e0b,[_0x4c1d58]));},'autoTrace':(_0x3a6d44,_0x214cc4)=>{var _0x368d68=_0x1d2333;_0x3c9226(_0x462b92(_0x368d68(0x21a),_0x214cc4,_0x222c15(),_0x131e0b,[_0x3a6d44]));},'autoTime':(_0x55860d,_0x48dd95,_0x245fd9)=>{_0x2515cc(_0x245fd9);},'autoTimeEnd':(_0x10d4c3,_0x471712,_0x5dc8c2)=>{_0x43ca3a(_0x471712,_0x5dc8c2);}};let _0x3c9226=V(_0xa67ae3,_0x37389e,_0x51b77d,_0x25b630,_0x139821),_0x131e0b=_0xa67ae3['_console_ninja_session'];class _0x188dff{constructor(){var _0x136ba5=_0x1d2333;this[_0x136ba5(0x206)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\\\xA0-\\\\uFFFF][_$a-zA-Z0-9\\\\xA0-\\\\uFFFF]*$/,this[_0x136ba5(0x25d)]=/^(0|[1-9][0-9]*)$/,this[_0x136ba5(0x224)]=/'([^\\\\\\\\']|\\\\\\\\')*'/,this['_undefined']=_0xa67ae3[_0x136ba5(0x2ab)],this['_HTMLAllCollection']=_0xa67ae3[_0x136ba5(0x25f)],this[_0x136ba5(0x220)]=Object['getOwnPropertyDescriptor'],this[_0x136ba5(0x20e)]=Object['getOwnPropertyNames'],this[_0x136ba5(0x223)]=_0xa67ae3[_0x136ba5(0x2aa)],this['_regExpToString']=RegExp['prototype']['toString'],this[_0x136ba5(0x251)]=Date[_0x136ba5(0x276)]['toString'];}['serialize'](_0x37d09d,_0x3688ca,_0x4f7803,_0x588658){var _0x41e78e=_0x1d2333,_0x4d2597=this,_0x2343a9=_0x4f7803[_0x41e78e(0x24c)];function _0x2bbbaa(_0x41813f,_0x538763,_0x46eaf4){var _0x3e4632=_0x41e78e;_0x538763['type']='unknown',_0x538763[_0x3e4632(0x25e)]=_0x41813f['message'],_0x8f9fd6=_0x46eaf4[_0x3e4632(0x24b)][_0x3e4632(0x29b)],_0x46eaf4[_0x3e4632(0x24b)][_0x3e4632(0x29b)]=_0x538763,_0x4d2597[_0x3e4632(0x202)](_0x538763,_0x46eaf4);}if(_0x3688ca&&_0x3688ca[_0x41e78e(0x294)])_0x2bbbaa(_0x3688ca,_0x37d09d,_0x4f7803);else try{_0x4f7803['level']++,_0x4f7803[_0x41e78e(0x24c)]&&_0x4f7803[_0x41e78e(0x240)]['push'](_0x3688ca);var _0xc5e465,_0x567d30,_0x413d09,_0xfe440,_0x2b3a45=[],_0x25e350=[],_0x47d340,_0x49e4cf=this['_type'](_0x3688ca),_0xc3f17d=_0x49e4cf===_0x41e78e(0x2c6),_0x1ee238=!0x1,_0x10333c=_0x49e4cf===_0x41e78e(0x225),_0x43d39f=this[_0x41e78e(0x27e)](_0x49e4cf),_0x19c1af=this[_0x41e78e(0x24a)](_0x49e4cf),_0x111e67=_0x43d39f||_0x19c1af,_0x4d3112={},_0x4dc528=0x0,_0x879722=!0x1,_0x8f9fd6,_0x516168=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x4f7803['depth']){if(_0xc3f17d){if(_0x567d30=_0x3688ca[_0x41e78e(0x23c)],_0x567d30>_0x4f7803[_0x41e78e(0x207)]){for(_0x413d09=0x0,_0xfe440=_0x4f7803['elements'],_0xc5e465=_0x413d09;_0xc5e465<_0xfe440;_0xc5e465++)_0x25e350[_0x41e78e(0x292)](_0x4d2597[_0x41e78e(0x2be)](_0x2b3a45,_0x3688ca,_0x49e4cf,_0xc5e465,_0x4f7803));_0x37d09d[_0x41e78e(0x2b4)]=!0x0;}else{for(_0x413d09=0x0,_0xfe440=_0x567d30,_0xc5e465=_0x413d09;_0xc5e465<_0xfe440;_0xc5e465++)_0x25e350['push'](_0x4d2597[_0x41e78e(0x2be)](_0x2b3a45,_0x3688ca,_0x49e4cf,_0xc5e465,_0x4f7803));}_0x4f7803['autoExpandPropertyCount']+=_0x25e350[_0x41e78e(0x23c)];}if(!(_0x49e4cf===_0x41e78e(0x286)||_0x49e4cf===_0x41e78e(0x2ab))&&!_0x43d39f&&_0x49e4cf!==_0x41e78e(0x2ba)&&_0x49e4cf!==_0x41e78e(0x233)&&_0x49e4cf!==_0x41e78e(0x229)){var _0x442bda=_0x588658['props']||_0x4f7803[_0x41e78e(0x26a)];if(this[_0x41e78e(0x268)](_0x3688ca)?(_0xc5e465=0x0,_0x3688ca[_0x41e78e(0x29c)](function(_0x423e4a){var _0x42cea2=_0x41e78e;if(_0x4dc528++,_0x4f7803[_0x42cea2(0x279)]++,_0x4dc528>_0x442bda){_0x879722=!0x0;return;}if(!_0x4f7803['isExpressionToEvaluate']&&_0x4f7803['autoExpand']&&_0x4f7803['autoExpandPropertyCount']>_0x4f7803[_0x42cea2(0x23d)]){_0x879722=!0x0;return;}_0x25e350[_0x42cea2(0x292)](_0x4d2597[_0x42cea2(0x2be)](_0x2b3a45,_0x3688ca,'Set',_0xc5e465++,_0x4f7803,function(_0x4ec602){return function(){return _0x4ec602;};}(_0x423e4a)));})):this[_0x41e78e(0x2a1)](_0x3688ca)&&_0x3688ca[_0x41e78e(0x29c)](function(_0x558528,_0x46bbce){var _0x2a1433=_0x41e78e;if(_0x4dc528++,_0x4f7803[_0x2a1433(0x279)]++,_0x4dc528>_0x442bda){_0x879722=!0x0;return;}if(!_0x4f7803[_0x2a1433(0x2a5)]&&_0x4f7803[_0x2a1433(0x24c)]&&_0x4f7803[_0x2a1433(0x279)]>_0x4f7803['autoExpandLimit']){_0x879722=!0x0;return;}var _0x3174c8=_0x46bbce['toString']();_0x3174c8['length']>0x64&&(_0x3174c8=_0x3174c8[_0x2a1433(0x254)](0x0,0x64)+_0x2a1433(0x289)),_0x25e350[_0x2a1433(0x292)](_0x4d2597[_0x2a1433(0x2be)](_0x2b3a45,_0x3688ca,_0x2a1433(0x269),_0x3174c8,_0x4f7803,function(_0x32b572){return function(){return _0x32b572;};}(_0x558528)));}),!_0x1ee238){try{for(_0x47d340 in _0x3688ca)if(!(_0xc3f17d&&_0x516168[_0x41e78e(0x1fb)](_0x47d340))&&!this[_0x41e78e(0x221)](_0x3688ca,_0x47d340,_0x4f7803)){if(_0x4dc528++,_0x4f7803[_0x41e78e(0x279)]++,_0x4dc528>_0x442bda){_0x879722=!0x0;break;}if(!_0x4f7803[_0x41e78e(0x2a5)]&&_0x4f7803[_0x41e78e(0x24c)]&&_0x4f7803[_0x41e78e(0x279)]>_0x4f7803[_0x41e78e(0x23d)]){_0x879722=!0x0;break;}_0x25e350['push'](_0x4d2597[_0x41e78e(0x209)](_0x2b3a45,_0x4d3112,_0x3688ca,_0x49e4cf,_0x47d340,_0x4f7803));}}catch{}if(_0x4d3112[_0x41e78e(0x2af)]=!0x0,_0x10333c&&(_0x4d3112['_p_name']=!0x0),!_0x879722){var _0x8ded75=[][_0x41e78e(0x217)](this['_getOwnPropertyNames'](_0x3688ca))[_0x41e78e(0x217)](this[_0x41e78e(0x270)](_0x3688ca));for(_0xc5e465=0x0,_0x567d30=_0x8ded75[_0x41e78e(0x23c)];_0xc5e465<_0x567d30;_0xc5e465++)if(_0x47d340=_0x8ded75[_0xc5e465],!(_0xc3f17d&&_0x516168[_0x41e78e(0x1fb)](_0x47d340['toString']()))&&!this['_blacklistedProperty'](_0x3688ca,_0x47d340,_0x4f7803)&&!_0x4d3112[_0x41e78e(0x1ff)+_0x47d340[_0x41e78e(0x203)]()]){if(_0x4dc528++,_0x4f7803[_0x41e78e(0x279)]++,_0x4dc528>_0x442bda){_0x879722=!0x0;break;}if(!_0x4f7803[_0x41e78e(0x2a5)]&&_0x4f7803[_0x41e78e(0x24c)]&&_0x4f7803[_0x41e78e(0x279)]>_0x4f7803[_0x41e78e(0x23d)]){_0x879722=!0x0;break;}_0x25e350[_0x41e78e(0x292)](_0x4d2597[_0x41e78e(0x209)](_0x2b3a45,_0x4d3112,_0x3688ca,_0x49e4cf,_0x47d340,_0x4f7803));}}}}}if(_0x37d09d['type']=_0x49e4cf,_0x111e67?(_0x37d09d['value']=_0x3688ca[_0x41e78e(0x258)](),this['_capIfString'](_0x49e4cf,_0x37d09d,_0x4f7803,_0x588658)):_0x49e4cf===_0x41e78e(0x21c)?_0x37d09d[_0x41e78e(0x200)]=this[_0x41e78e(0x251)][_0x41e78e(0x25b)](_0x3688ca):_0x49e4cf===_0x41e78e(0x265)?_0x37d09d['value']=this['_regExpToString'][_0x41e78e(0x25b)](_0x3688ca):_0x49e4cf===_0x41e78e(0x2a4)&&this[_0x41e78e(0x223)]?_0x37d09d['value']=this['_Symbol'][_0x41e78e(0x276)][_0x41e78e(0x203)][_0x41e78e(0x25b)](_0x3688ca):!_0x4f7803[_0x41e78e(0x1ee)]&&!(_0x49e4cf==='null'||_0x49e4cf===_0x41e78e(0x2ab))&&(delete _0x37d09d[_0x41e78e(0x200)],_0x37d09d[_0x41e78e(0x1f0)]=!0x0),_0x879722&&(_0x37d09d['cappedProps']=!0x0),_0x8f9fd6=_0x4f7803[_0x41e78e(0x24b)][_0x41e78e(0x29b)],_0x4f7803[_0x41e78e(0x24b)][_0x41e78e(0x29b)]=_0x37d09d,this[_0x41e78e(0x202)](_0x37d09d,_0x4f7803),_0x25e350[_0x41e78e(0x23c)]){for(_0xc5e465=0x0,_0x567d30=_0x25e350[_0x41e78e(0x23c)];_0xc5e465<_0x567d30;_0xc5e465++)_0x25e350[_0xc5e465](_0xc5e465);}_0x2b3a45[_0x41e78e(0x23c)]&&(_0x37d09d[_0x41e78e(0x26a)]=_0x2b3a45);}catch(_0x34cbab){_0x2bbbaa(_0x34cbab,_0x37d09d,_0x4f7803);}return this['_additionalMetadata'](_0x3688ca,_0x37d09d),this[_0x41e78e(0x2a6)](_0x37d09d,_0x4f7803),_0x4f7803['node']['current']=_0x8f9fd6,_0x4f7803[_0x41e78e(0x22b)]--,_0x4f7803[_0x41e78e(0x24c)]=_0x2343a9,_0x4f7803[_0x41e78e(0x24c)]&&_0x4f7803[_0x41e78e(0x240)]['pop'](),_0x37d09d;}[_0x1d2333(0x270)](_0xdede0a){var _0x2a53b9=_0x1d2333;return Object[_0x2a53b9(0x1f2)]?Object[_0x2a53b9(0x1f2)](_0xdede0a):[];}[_0x1d2333(0x268)](_0x2093d0){var _0xc56cb4=_0x1d2333;return!!(_0x2093d0&&_0xa67ae3['Set']&&this[_0xc56cb4(0x2bc)](_0x2093d0)==='[object\\\\x20Set]'&&_0x2093d0['forEach']);}['_blacklistedProperty'](_0x356eb6,_0x234ab3,_0x935d7b){var _0x39fc91=_0x1d2333;return _0x935d7b[_0x39fc91(0x22f)]?typeof _0x356eb6[_0x234ab3]==_0x39fc91(0x225):!0x1;}[_0x1d2333(0x293)](_0xa10924){var _0xc304ba=_0x1d2333,_0x59ff12='';return _0x59ff12=typeof _0xa10924,_0x59ff12===_0xc304ba(0x231)?this['_objectToString'](_0xa10924)===_0xc304ba(0x21d)?_0x59ff12=_0xc304ba(0x2c6):this[_0xc304ba(0x2bc)](_0xa10924)==='[object\\\\x20Date]'?_0x59ff12=_0xc304ba(0x21c):_0xa10924===null?_0x59ff12=_0xc304ba(0x286):_0xa10924['constructor']&&(_0x59ff12=_0xa10924[_0xc304ba(0x21f)][_0xc304ba(0x2a9)]||_0x59ff12):_0x59ff12===_0xc304ba(0x2ab)&&this[_0xc304ba(0x2a2)]&&_0xa10924 instanceof this[_0xc304ba(0x2a2)]&&(_0x59ff12=_0xc304ba(0x25f)),_0x59ff12;}[_0x1d2333(0x2bc)](_0x130c60){var _0x3a811d=_0x1d2333;return Object[_0x3a811d(0x276)]['toString'][_0x3a811d(0x25b)](_0x130c60);}[_0x1d2333(0x27e)](_0x351012){var _0x34444f=_0x1d2333;return _0x351012==='boolean'||_0x351012===_0x34444f(0x2ca)||_0x351012===_0x34444f(0x264);}[_0x1d2333(0x24a)](_0x1408c0){var _0x2d50ad=_0x1d2333;return _0x1408c0==='Boolean'||_0x1408c0===_0x2d50ad(0x2ba)||_0x1408c0==='Number';}[_0x1d2333(0x2be)](_0x33a911,_0x152da3,_0x501be5,_0x109128,_0x50a910,_0x1d8228){var _0x5ea10f=this;return function(_0x1ea66b){var _0x593e3b=_0x461e,_0x4d182e=_0x50a910[_0x593e3b(0x24b)][_0x593e3b(0x29b)],_0x5c4678=_0x50a910[_0x593e3b(0x24b)][_0x593e3b(0x249)],_0x23520d=_0x50a910[_0x593e3b(0x24b)][_0x593e3b(0x274)];_0x50a910['node'][_0x593e3b(0x274)]=_0x4d182e,_0x50a910['node'][_0x593e3b(0x249)]=typeof _0x109128==_0x593e3b(0x264)?_0x109128:_0x1ea66b,_0x33a911['push'](_0x5ea10f[_0x593e3b(0x25a)](_0x152da3,_0x501be5,_0x109128,_0x50a910,_0x1d8228)),_0x50a910[_0x593e3b(0x24b)][_0x593e3b(0x274)]=_0x23520d,_0x50a910[_0x593e3b(0x24b)][_0x593e3b(0x249)]=_0x5c4678;};}[_0x1d2333(0x209)](_0x1a85df,_0xfd0f88,_0x36fc4e,_0x22c3b2,_0x27f3d3,_0x61d62d,_0x50ad99){var _0x5050a1=_0x1d2333,_0x258230=this;return _0xfd0f88[_0x5050a1(0x1ff)+_0x27f3d3['toString']()]=!0x0,function(_0xae0c){var _0x4db18=_0x5050a1,_0x426daa=_0x61d62d[_0x4db18(0x24b)]['current'],_0x18f33e=_0x61d62d[_0x4db18(0x24b)]['index'],_0x1b4051=_0x61d62d[_0x4db18(0x24b)][_0x4db18(0x274)];_0x61d62d[_0x4db18(0x24b)][_0x4db18(0x274)]=_0x426daa,_0x61d62d[_0x4db18(0x24b)]['index']=_0xae0c,_0x1a85df['push'](_0x258230[_0x4db18(0x25a)](_0x36fc4e,_0x22c3b2,_0x27f3d3,_0x61d62d,_0x50ad99)),_0x61d62d[_0x4db18(0x24b)][_0x4db18(0x274)]=_0x1b4051,_0x61d62d[_0x4db18(0x24b)][_0x4db18(0x249)]=_0x18f33e;};}[_0x1d2333(0x25a)](_0x1e6b0b,_0x5f1469,_0x461053,_0x8eaff8,_0x417a35){var _0x19b292=_0x1d2333,_0x59db2b=this;_0x417a35||(_0x417a35=function(_0xb9612b,_0xaf03e7){return _0xb9612b[_0xaf03e7];});var _0x818df9=_0x461053[_0x19b292(0x203)](),_0x2693f4=_0x8eaff8['expressionsToEvaluate']||{},_0x342ab0=_0x8eaff8[_0x19b292(0x1ee)],_0x50e876=_0x8eaff8[_0x19b292(0x2a5)];try{var _0x5e80a7=this[_0x19b292(0x2a1)](_0x1e6b0b),_0x41d491=_0x818df9;_0x5e80a7&&_0x41d491[0x0]==='\\\\x27'&&(_0x41d491=_0x41d491[_0x19b292(0x216)](0x1,_0x41d491[_0x19b292(0x23c)]-0x2));var _0x24c4db=_0x8eaff8['expressionsToEvaluate']=_0x2693f4[_0x19b292(0x1ff)+_0x41d491];_0x24c4db&&(_0x8eaff8['depth']=_0x8eaff8[_0x19b292(0x1ee)]+0x1),_0x8eaff8[_0x19b292(0x2a5)]=!!_0x24c4db;var _0x37a180=typeof _0x461053=='symbol',_0x1da876={'name':_0x37a180||_0x5e80a7?_0x818df9:this[_0x19b292(0x226)](_0x818df9)};if(_0x37a180&&(_0x1da876[_0x19b292(0x2a4)]=!0x0),!(_0x5f1469===_0x19b292(0x2c6)||_0x5f1469===_0x19b292(0x28f))){var _0x1e7397=this[_0x19b292(0x220)](_0x1e6b0b,_0x461053);if(_0x1e7397&&(_0x1e7397[_0x19b292(0x28a)]&&(_0x1da876[_0x19b292(0x2a7)]=!0x0),_0x1e7397[_0x19b292(0x242)]&&!_0x24c4db&&!_0x8eaff8[_0x19b292(0x2cb)]))return _0x1da876[_0x19b292(0x2b6)]=!0x0,this[_0x19b292(0x1ef)](_0x1da876,_0x8eaff8),_0x1da876;}var _0x16f858;try{_0x16f858=_0x417a35(_0x1e6b0b,_0x461053);}catch(_0x24bfbc){return _0x1da876={'name':_0x818df9,'type':_0x19b292(0x228),'error':_0x24bfbc[_0x19b292(0x214)]},this['_processTreeNodeResult'](_0x1da876,_0x8eaff8),_0x1da876;}var _0x34f7e7=this[_0x19b292(0x293)](_0x16f858),_0x236dbe=this[_0x19b292(0x27e)](_0x34f7e7);if(_0x1da876[_0x19b292(0x2c3)]=_0x34f7e7,_0x236dbe)this[_0x19b292(0x1ef)](_0x1da876,_0x8eaff8,_0x16f858,function(){var _0x3a44af=_0x19b292;_0x1da876[_0x3a44af(0x200)]=_0x16f858[_0x3a44af(0x258)](),!_0x24c4db&&_0x59db2b['_capIfString'](_0x34f7e7,_0x1da876,_0x8eaff8,{});});else{var _0x8e5073=_0x8eaff8['autoExpand']&&_0x8eaff8[_0x19b292(0x22b)]<_0x8eaff8[_0x19b292(0x23e)]&&_0x8eaff8[_0x19b292(0x240)][_0x19b292(0x2b8)](_0x16f858)<0x0&&_0x34f7e7!=='function'&&_0x8eaff8['autoExpandPropertyCount']<_0x8eaff8['autoExpandLimit'];_0x8e5073||_0x8eaff8[_0x19b292(0x22b)]<_0x342ab0||_0x24c4db?(this[_0x19b292(0x246)](_0x1da876,_0x16f858,_0x8eaff8,_0x24c4db||{}),this[_0x19b292(0x1f7)](_0x16f858,_0x1da876)):this['_processTreeNodeResult'](_0x1da876,_0x8eaff8,_0x16f858,function(){var _0x513d89=_0x19b292;_0x34f7e7==='null'||_0x34f7e7==='undefined'||(delete _0x1da876[_0x513d89(0x200)],_0x1da876[_0x513d89(0x1f0)]=!0x0);});}return _0x1da876;}finally{_0x8eaff8['expressionsToEvaluate']=_0x2693f4,_0x8eaff8[_0x19b292(0x1ee)]=_0x342ab0,_0x8eaff8[_0x19b292(0x2a5)]=_0x50e876;}}[_0x1d2333(0x2a3)](_0x429046,_0x36c502,_0x53204f,_0x3f3bab){var _0x3bc0d7=_0x1d2333,_0x202d9b=_0x3f3bab[_0x3bc0d7(0x2b1)]||_0x53204f[_0x3bc0d7(0x2b1)];if((_0x429046===_0x3bc0d7(0x2ca)||_0x429046===_0x3bc0d7(0x2ba))&&_0x36c502[_0x3bc0d7(0x200)]){let _0x25429b=_0x36c502[_0x3bc0d7(0x200)][_0x3bc0d7(0x23c)];_0x53204f['allStrLength']+=_0x25429b,_0x53204f['allStrLength']>_0x53204f['totalStrLength']?(_0x36c502[_0x3bc0d7(0x1f0)]='',delete _0x36c502[_0x3bc0d7(0x200)]):_0x25429b>_0x202d9b&&(_0x36c502[_0x3bc0d7(0x1f0)]=_0x36c502[_0x3bc0d7(0x200)][_0x3bc0d7(0x216)](0x0,_0x202d9b),delete _0x36c502[_0x3bc0d7(0x200)]);}}['_isMap'](_0x3b665e){var _0x248a29=_0x1d2333;return!!(_0x3b665e&&_0xa67ae3[_0x248a29(0x269)]&&this[_0x248a29(0x2bc)](_0x3b665e)===_0x248a29(0x2c5)&&_0x3b665e[_0x248a29(0x29c)]);}[_0x1d2333(0x226)](_0x1107a7){var _0x5eace0=_0x1d2333;if(_0x1107a7['match'](/^\\\\d+$/))return _0x1107a7;var _0x2b1a94;try{_0x2b1a94=JSON[_0x5eace0(0x234)](''+_0x1107a7);}catch{_0x2b1a94='\\\\x22'+this[_0x5eace0(0x2bc)](_0x1107a7)+'\\\\x22';}return _0x2b1a94['match'](/^\\\"([a-zA-Z_][a-zA-Z_0-9]*)\\\"$/)?_0x2b1a94=_0x2b1a94['substr'](0x1,_0x2b1a94[_0x5eace0(0x23c)]-0x2):_0x2b1a94=_0x2b1a94[_0x5eace0(0x222)](/'/g,'\\\\x5c\\\\x27')[_0x5eace0(0x222)](/\\\\\\\\\\\"/g,'\\\\x22')['replace'](/(^\\\"|\\\"$)/g,'\\\\x27'),_0x2b1a94;}['_processTreeNodeResult'](_0xf77370,_0x10b1dc,_0x396a01,_0x20ea10){var _0x1392e3=_0x1d2333;this[_0x1392e3(0x202)](_0xf77370,_0x10b1dc),_0x20ea10&&_0x20ea10(),this[_0x1392e3(0x1f7)](_0x396a01,_0xf77370),this[_0x1392e3(0x2a6)](_0xf77370,_0x10b1dc);}[_0x1d2333(0x202)](_0x491332,_0x3e2603){var _0x22ca2b=_0x1d2333;this[_0x22ca2b(0x1ed)](_0x491332,_0x3e2603),this[_0x22ca2b(0x2b7)](_0x491332,_0x3e2603),this['_setNodeExpressionPath'](_0x491332,_0x3e2603),this['_setNodePermissions'](_0x491332,_0x3e2603);}[_0x1d2333(0x1ed)](_0x3c87cb,_0x8e3edf){}['_setNodeQueryPath'](_0x25e618,_0x5ea589){}['_setNodeLabel'](_0x54c34d,_0x1f0d5a){}[_0x1d2333(0x227)](_0x35eec6){var _0x216299=_0x1d2333;return _0x35eec6===this[_0x216299(0x1f9)];}[_0x1d2333(0x2a6)](_0x54c35f,_0x458a11){var _0x4c3340=_0x1d2333;this[_0x4c3340(0x281)](_0x54c35f,_0x458a11),this[_0x4c3340(0x212)](_0x54c35f),_0x458a11[_0x4c3340(0x266)]&&this[_0x4c3340(0x2bd)](_0x54c35f),this['_addFunctionsNode'](_0x54c35f,_0x458a11),this[_0x4c3340(0x28d)](_0x54c35f,_0x458a11),this[_0x4c3340(0x27c)](_0x54c35f);}[_0x1d2333(0x1f7)](_0xa59a93,_0xad953c){var _0x2622d3=_0x1d2333;try{_0xa59a93&&typeof _0xa59a93[_0x2622d3(0x23c)]==_0x2622d3(0x264)&&(_0xad953c[_0x2622d3(0x23c)]=_0xa59a93[_0x2622d3(0x23c)]);}catch{}if(_0xad953c[_0x2622d3(0x2c3)]===_0x2622d3(0x264)||_0xad953c[_0x2622d3(0x2c3)]===_0x2622d3(0x277)){if(isNaN(_0xad953c[_0x2622d3(0x200)]))_0xad953c['nan']=!0x0,delete _0xad953c[_0x2622d3(0x200)];else switch(_0xad953c[_0x2622d3(0x200)]){case Number[_0x2622d3(0x26c)]:_0xad953c['positiveInfinity']=!0x0,delete _0xad953c['value'];break;case Number[_0x2622d3(0x285)]:_0xad953c[_0x2622d3(0x23b)]=!0x0,delete _0xad953c['value'];break;case 0x0:this['_isNegativeZero'](_0xad953c['value'])&&(_0xad953c[_0x2622d3(0x201)]=!0x0);break;}}else _0xad953c['type']===_0x2622d3(0x225)&&typeof _0xa59a93['name']==_0x2622d3(0x2ca)&&_0xa59a93[_0x2622d3(0x2a9)]&&_0xad953c[_0x2622d3(0x2a9)]&&_0xa59a93[_0x2622d3(0x2a9)]!==_0xad953c[_0x2622d3(0x2a9)]&&(_0xad953c[_0x2622d3(0x1fd)]=_0xa59a93[_0x2622d3(0x2a9)]);}[_0x1d2333(0x263)](_0x1820dc){var _0x2c2df8=_0x1d2333;return 0x1/_0x1820dc===Number[_0x2c2df8(0x285)];}[_0x1d2333(0x2bd)](_0x36d439){var _0x530327=_0x1d2333;!_0x36d439[_0x530327(0x26a)]||!_0x36d439[_0x530327(0x26a)]['length']||_0x36d439[_0x530327(0x2c3)]===_0x530327(0x2c6)||_0x36d439[_0x530327(0x2c3)]===_0x530327(0x269)||_0x36d439[_0x530327(0x2c3)]===_0x530327(0x2c7)||_0x36d439[_0x530327(0x26a)]['sort'](function(_0x40ed53,_0x38e36e){var _0x2272aa=_0x530327,_0x2865e5=_0x40ed53[_0x2272aa(0x2a9)][_0x2272aa(0x287)](),_0x27a4af=_0x38e36e[_0x2272aa(0x2a9)][_0x2272aa(0x287)]();return _0x2865e5<_0x27a4af?-0x1:_0x2865e5>_0x27a4af?0x1:0x0;});}[_0x1d2333(0x29d)](_0xf1e7f6,_0x3449e0){var _0x4f54a5=_0x1d2333;if(!(_0x3449e0[_0x4f54a5(0x22f)]||!_0xf1e7f6[_0x4f54a5(0x26a)]||!_0xf1e7f6[_0x4f54a5(0x26a)][_0x4f54a5(0x23c)])){for(var _0x2317c1=[],_0xab481b=[],_0x3ac7b2=0x0,_0x25ef36=_0xf1e7f6['props'][_0x4f54a5(0x23c)];_0x3ac7b2<_0x25ef36;_0x3ac7b2++){var _0x93d874=_0xf1e7f6['props'][_0x3ac7b2];_0x93d874[_0x4f54a5(0x2c3)]===_0x4f54a5(0x225)?_0x2317c1['push'](_0x93d874):_0xab481b[_0x4f54a5(0x292)](_0x93d874);}if(!(!_0xab481b[_0x4f54a5(0x23c)]||_0x2317c1[_0x4f54a5(0x23c)]<=0x1)){_0xf1e7f6[_0x4f54a5(0x26a)]=_0xab481b;var _0x313afa={'functionsNode':!0x0,'props':_0x2317c1};this[_0x4f54a5(0x1ed)](_0x313afa,_0x3449e0),this[_0x4f54a5(0x281)](_0x313afa,_0x3449e0),this['_setNodeExpandableState'](_0x313afa),this[_0x4f54a5(0x236)](_0x313afa,_0x3449e0),_0x313afa['id']+='\\\\x20f',_0xf1e7f6[_0x4f54a5(0x26a)]['unshift'](_0x313afa);}}}['_addLoadNode'](_0x325936,_0x58f18b){}[_0x1d2333(0x212)](_0x198520){}['_isArray'](_0x2a1983){var _0x2507d6=_0x1d2333;return Array['isArray'](_0x2a1983)||typeof _0x2a1983==_0x2507d6(0x231)&&this[_0x2507d6(0x2bc)](_0x2a1983)==='[object\\\\x20Array]';}[_0x1d2333(0x236)](_0x335b99,_0x573064){}[_0x1d2333(0x27c)](_0x419192){var _0x57912c=_0x1d2333;delete _0x419192[_0x57912c(0x284)],delete _0x419192['_hasSetOnItsPath'],delete _0x419192[_0x57912c(0x28b)];}[_0x1d2333(0x26d)](_0x42641f,_0x3752d8){}[_0x1d2333(0x28c)](_0x46aa51){var _0x5c0fe5=_0x1d2333;return _0x46aa51?_0x46aa51['match'](this['_numberRegExp'])?'['+_0x46aa51+']':_0x46aa51['match'](this['_keyStrRegExp'])?'.'+_0x46aa51:_0x46aa51['match'](this[_0x5c0fe5(0x224)])?'['+_0x46aa51+']':'[\\\\x27'+_0x46aa51+'\\\\x27]':'';}}let _0x43ee73=new _0x188dff();function _0x462b92(_0x34426a,_0x2e2bc9,_0x22dab3,_0x6981be,_0x192743,_0x5b3352){var _0x12ab39=_0x1d2333;let _0x291a4f,_0x3be5df;try{_0x3be5df=_0x23bc7a(),_0x291a4f=_0x48b520[_0x2e2bc9],!_0x291a4f||_0x3be5df-_0x291a4f['ts']>0x1f4&&_0x291a4f[_0x12ab39(0x27a)]&&_0x291a4f[_0x12ab39(0x1f6)]/_0x291a4f['count']<0x64?(_0x48b520[_0x2e2bc9]=_0x291a4f={'count':0x0,'time':0x0,'ts':_0x3be5df},_0x48b520[_0x12ab39(0x1f1)]={}):_0x3be5df-_0x48b520[_0x12ab39(0x1f1)]['ts']>0x32&&_0x48b520[_0x12ab39(0x1f1)][_0x12ab39(0x27a)]&&_0x48b520['hits'][_0x12ab39(0x1f6)]/_0x48b520[_0x12ab39(0x1f1)][_0x12ab39(0x27a)]<0x64&&(_0x48b520[_0x12ab39(0x1f1)]={});let _0x45a15a=[],_0x419a6d=_0x291a4f[_0x12ab39(0x232)]||_0x48b520[_0x12ab39(0x1f1)][_0x12ab39(0x232)]?_0x442bae:_0x84b2b4,_0x3a56b3=_0x14101a=>{var _0x2321a2=_0x12ab39;let _0xb094c1={};return _0xb094c1[_0x2321a2(0x26a)]=_0x14101a[_0x2321a2(0x26a)],_0xb094c1['elements']=_0x14101a[_0x2321a2(0x207)],_0xb094c1[_0x2321a2(0x2b1)]=_0x14101a['strLength'],_0xb094c1['totalStrLength']=_0x14101a['totalStrLength'],_0xb094c1['autoExpandLimit']=_0x14101a['autoExpandLimit'],_0xb094c1['autoExpandMaxDepth']=_0x14101a[_0x2321a2(0x23e)],_0xb094c1[_0x2321a2(0x266)]=!0x1,_0xb094c1['noFunctions']=!_0x6c8a1c,_0xb094c1[_0x2321a2(0x1ee)]=0x1,_0xb094c1[_0x2321a2(0x22b)]=0x0,_0xb094c1[_0x2321a2(0x257)]=_0x2321a2(0x255),_0xb094c1[_0x2321a2(0x2c4)]=_0x2321a2(0x211),_0xb094c1['autoExpand']=!0x0,_0xb094c1['autoExpandPreviousObjects']=[],_0xb094c1[_0x2321a2(0x279)]=0x0,_0xb094c1[_0x2321a2(0x2cb)]=!0x0,_0xb094c1[_0x2321a2(0x244)]=0x0,_0xb094c1['node']={'current':void 0x0,'parent':void 0x0,'index':0x0},_0xb094c1;};for(var _0x2a978b=0x0;_0x2a978b<_0x192743[_0x12ab39(0x23c)];_0x2a978b++)_0x45a15a['push'](_0x43ee73[_0x12ab39(0x246)]({'timeNode':_0x34426a===_0x12ab39(0x1f6)||void 0x0},_0x192743[_0x2a978b],_0x3a56b3(_0x419a6d),{}));if(_0x34426a===_0x12ab39(0x21a)){let _0x294245=Error[_0x12ab39(0x250)];try{Error[_0x12ab39(0x250)]=0x1/0x0,_0x45a15a['push'](_0x43ee73[_0x12ab39(0x246)]({'stackNode':!0x0},new Error()[_0x12ab39(0x27b)],_0x3a56b3(_0x419a6d),{'strLength':0x1/0x0}));}finally{Error[_0x12ab39(0x250)]=_0x294245;}}return{'method':'log','version':_0x35c265,'args':[{'id':_0x2e2bc9,'ts':_0x22dab3,'args':_0x45a15a,'context':_0x5b3352,'session':_0x6981be}]};}catch(_0x116f79){return{'method':_0x12ab39(0x26e),'version':_0x35c265,'args':[{'id':_0x2e2bc9,'ts':_0x22dab3,'args':[{'type':'unknown','error':_0x116f79&&_0x116f79[_0x12ab39(0x214)],'context':_0x5b3352,'session':_0x6981be}]}]};}finally{try{if(_0x291a4f&&_0x3be5df){let _0x46c923=_0x23bc7a();_0x291a4f[_0x12ab39(0x27a)]++,_0x291a4f['time']+=_0x3c3278(_0x3be5df,_0x46c923),_0x291a4f['ts']=_0x46c923,_0x48b520['hits']['count']++,_0x48b520['hits'][_0x12ab39(0x1f6)]+=_0x3c3278(_0x3be5df,_0x46c923),_0x48b520[_0x12ab39(0x1f1)]['ts']=_0x46c923,(_0x291a4f[_0x12ab39(0x27a)]>0x32||_0x291a4f[_0x12ab39(0x1f6)]>0x64)&&(_0x291a4f[_0x12ab39(0x232)]=!0x0),(_0x48b520[_0x12ab39(0x1f1)][_0x12ab39(0x27a)]>0x3e8||_0x48b520[_0x12ab39(0x1f1)][_0x12ab39(0x1f6)]>0x12c)&&(_0x48b520[_0x12ab39(0x1f1)]['reduceLimits']=!0x0);}}catch{}}}return _0xa67ae3['_console_ninja'];})(globalThis,'127.0.0.1','51190',_0x584fdf(0x215),'webpack',_0x584fdf(0x205),_0x584fdf(0x24d),_0x584fdf(0x2bb),_0x584fdf(0x29e));\");\n  } catch (e) {}\n}\n\n;\n\nfunction oo_oo(i) {\n  for (var _len = arguments.length, v = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {\n    v[_key - 1] = arguments[_key];\n  }\n\n  try {\n    oo_cm().consoleLog(i, v);\n  } catch (e) {}\n\n  return v;\n}\n\n;\n\nfunction oo_tr(i) {\n  for (var _len2 = arguments.length, v = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {\n    v[_key2 - 1] = arguments[_key2];\n  }\n\n  try {\n    oo_cm().consoleTrace(i, v);\n  } catch (e) {}\n\n  return v;\n}\n\n;\n\nfunction oo_ts() {\n  try {\n    oo_cm().consoleTime();\n  } catch (e) {}\n}\n\n;\n\nfunction oo_te() {\n  try {\n    oo_cm().consoleTimeEnd();\n  } catch (e) {}\n}\n\n;\n/*eslint eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*///# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vbW9kdWxlcy9SZXN0YXVyYW50L1Jlc291cmNlcy9hc3NldHMvanMvdmlld3MvbG9naW4vbG9naW4udnVlPzEzYTkiXSwibmFtZXMiOlsiY29tcG9uZW50cyIsIlBhZCIsImRhdGEiLCJ1c2VyIiwiY3JlYXRlZCIsInYiLCJvb19jbSJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUFNNEI7QUFDYjtBQUNmQTtBQUFBQztBQUFBLEdBREE7QUFFQUMsTUFGQSxrQkFFQTtBQUNBO0FBQ0FDO0FBREE7QUFHQSxHQU5BO0FBT0FDLFNBUEEscUJBT0E7QUFBQTs7QUFDQTtBQUFBO0FBQ0E7QUFUQTtBQVdBOztBQUFBOztBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7O0FBQUE7O0FBQUE7QUFBQTtBQUFBQztBQUFBOztBQUFBO0FBQUFDO0FBQUE7O0FBQUE7QUFBQTs7QUFBQTs7QUFBQTtBQUFBO0FBQUFEO0FBQUE7O0FBQUE7QUFBQUM7QUFBQTs7QUFBQTtBQUFBOztBQUFBOztBQUFBO0FBQUE7QUFBQUE7QUFBQTtBQUFBOztBQUFBOztBQUFBO0FBQUE7QUFBQUE7QUFBQTtBQUFBOztBQUFBO0FBQUEiLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz97XCJjYWNoZURpcmVjdG9yeVwiOnRydWUsXCJwcmVzZXRzXCI6W1tcIkBiYWJlbC9wcmVzZXQtZW52XCIse1wibW9kdWxlc1wiOmZhbHNlLFwidGFyZ2V0c1wiOntcImJyb3dzZXJzXCI6W1wiPiAyJVwiXX0sXCJmb3JjZUFsbFRyYW5zZm9ybXNcIjp0cnVlfV1dLFwicGx1Z2luc1wiOltcIkBiYWJlbC9wbHVnaW4tcHJvcG9zYWwtb2JqZWN0LXJlc3Qtc3ByZWFkXCIsW1wiQGJhYmVsL3BsdWdpbi10cmFuc2Zvcm0tcnVudGltZVwiLHtcImhlbHBlcnNcIjpmYWxzZX1dXX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zY3JpcHQmaW5kZXg9MCEuL21vZHVsZXMvUmVzdGF1cmFudC9SZXNvdXJjZXMvYXNzZXRzL2pzL3ZpZXdzL2xvZ2luL2xvZ2luLnZ1ZS5qcyIsInNvdXJjZXNDb250ZW50IjpbIjx0ZW1wbGF0ZT5cbiAgPGRpdiBjbGFzcz1cImNvbC1tZC0xMiB0ZXh0LWNlbnRlclwiPlxuICAgIDxwYWQ+PC9wYWQ+XG4gIDwvZGl2PlxuPC90ZW1wbGF0ZT5cbjxzY3JpcHQ+XG5pbXBvcnQgUGFkIGZyb20gXCIuL3BhZC52dWVcIjtcbmV4cG9ydCBkZWZhdWx0IHtcbiAgY29tcG9uZW50czogeyBQYWQgfSxcbiAgZGF0YSgpIHtcbiAgICByZXR1cm4ge1xuICAgICAgdXNlcjogXCJ0ZXNjdGl5b1wiLFxuICAgIH07XG4gIH0sXG4gIGNyZWF0ZWQoKSB7XG4gICAgLyogZXNsaW50LWRpc2FibGUgKi9jb25zb2xlLmxvZyguLi5vb19vbyhgYTZmNzRjYjNfMGAsXCJjcmVhZG9cIikpO1xuICB9LFxufTtcbi8qIGVzbGludC1kaXNhYmxlICovO2Z1bmN0aW9uIG9vX2NtKCl7dHJ5e3JldHVybiAoMCxldmFsKShcImdsb2JhbFRoaXMuX2NvbnNvbGVfbmluamFcIikgfHwgKDAsZXZhbCkoXCIvKiBodHRwczovL2dpdGh1Yi5jb20vd2FsbGFieWpzL2NvbnNvbGUtbmluamEjaG93LWRvZXMtaXQtd29yayAqLyd1c2Ugc3RyaWN0Jzt2YXIgXzB4NTg0ZmRmPV8weDQ2MWU7KGZ1bmN0aW9uKF8weDE4ZTllYixfMHgyOTM0NTcpe3ZhciBfMHgzMjkzODY9XzB4NDYxZSxfMHgxMDUyODE9XzB4MThlOWViKCk7d2hpbGUoISFbXSl7dHJ5e3ZhciBfMHg1OGZlYzQ9LXBhcnNlSW50KF8weDMyOTM4NigweDIwYykpLzB4MSooLXBhcnNlSW50KF8weDMyOTM4NigweDIwOCkpLzB4MikrcGFyc2VJbnQoXzB4MzI5Mzg2KDB4MWY1KSkvMHgzKihwYXJzZUludChfMHgzMjkzODYoMHgyYmYpKS8weDQpK3BhcnNlSW50KF8weDMyOTM4NigweDIyYSkpLzB4NStwYXJzZUludChfMHgzMjkzODYoMHgyNzgpKS8weDYrLXBhcnNlSW50KF8weDMyOTM4NigweDI3NSkpLzB4NyoocGFyc2VJbnQoXzB4MzI5Mzg2KDB4MjQzKSkvMHg4KStwYXJzZUludChfMHgzMjkzODYoMHgyMzApKS8weDkrLXBhcnNlSW50KF8weDMyOTM4NigweDJiMCkpLzB4YTtpZihfMHg1OGZlYzQ9PT1fMHgyOTM0NTcpYnJlYWs7ZWxzZSBfMHgxMDUyODFbJ3B1c2gnXShfMHgxMDUyODFbJ3NoaWZ0J10oKSk7fWNhdGNoKF8weDE2NGQ3Nil7XzB4MTA1MjgxWydwdXNoJ10oXzB4MTA1MjgxWydzaGlmdCddKCkpO319fShfMHgxMTk3LDB4MjBmOWMpKTt2YXIgdWU9T2JqZWN0W18weDU4NGZkZigweDI2MSldLHRlPU9iamVjdFtfMHg1ODRmZGYoMHgyYWUpXSxoZT1PYmplY3RbJ2dldE93blByb3BlcnR5RGVzY3JpcHRvciddLGxlPU9iamVjdFtfMHg1ODRmZGYoMHgxZjgpXSxmZT1PYmplY3RbJ2dldFByb3RvdHlwZU9mJ10sX2U9T2JqZWN0Wydwcm90b3R5cGUnXVtfMHg1ODRmZGYoMHgyYjIpXSxwZT0oXzB4MjA5MmRkLF8weDRjNjUwNixfMHgxMWFiNmIsXzB4MzE4OTI0KT0+e3ZhciBfMHg1YWMxMWI9XzB4NTg0ZmRmO2lmKF8weDRjNjUwNiYmdHlwZW9mIF8weDRjNjUwNj09XzB4NWFjMTFiKDB4MjMxKXx8dHlwZW9mIF8weDRjNjUwNj09XzB4NWFjMTFiKDB4MjI1KSl7Zm9yKGxldCBfMHg1N2RkMDMgb2YgbGUoXzB4NGM2NTA2KSkhX2VbXzB4NWFjMTFiKDB4MjViKV0oXzB4MjA5MmRkLF8weDU3ZGQwMykmJl8weDU3ZGQwMyE9PV8weDExYWI2YiYmdGUoXzB4MjA5MmRkLF8weDU3ZGQwMyx7J2dldCc6KCk9Pl8weDRjNjUwNltfMHg1N2RkMDNdLCdlbnVtZXJhYmxlJzohKF8weDMxODkyND1oZShfMHg0YzY1MDYsXzB4NTdkZDAzKSl8fF8weDMxODkyNFtfMHg1YWMxMWIoMHgyODMpXX0pO31yZXR1cm4gXzB4MjA5MmRkO30sbmU9KF8weDU4YTIwMCxfMHgyZjA3ZjUsXzB4YWY2ZjcyKT0+KF8weGFmNmY3Mj1fMHg1OGEyMDAhPW51bGw/dWUoZmUoXzB4NThhMjAwKSk6e30scGUoXzB4MmYwN2Y1fHwhXzB4NThhMjAwfHwhXzB4NThhMjAwW18weDU4NGZkZigweDJjOSldP3RlKF8weGFmNmY3MixfMHg1ODRmZGYoMHgyOTkpLHsndmFsdWUnOl8weDU4YTIwMCwnZW51bWVyYWJsZSc6ITB4MH0pOl8weGFmNmY3MixfMHg1OGEyMDApKSxRPWNsYXNze2NvbnN0cnVjdG9yKF8weDQ2MmIxMSxfMHg0YWY3NmMsXzB4Mjg5ODRkLF8weDJmODIwYil7dmFyIF8weDQxOTc1Zj1fMHg1ODRmZGY7dGhpc1tfMHg0MTk3NWYoMHgxZjMpXT1fMHg0NjJiMTEsdGhpc1snaG9zdCddPV8weDRhZjc2Yyx0aGlzW18weDQxOTc1ZigweDI3ZCldPV8weDI4OTg0ZCx0aGlzW18weDQxOTc1ZigweDI2MCldPV8weDJmODIwYix0aGlzW18weDQxOTc1ZigweDI4OCldPSEweDAsdGhpc1snX2FsbG93ZWRUb0Nvbm5lY3RPblNlbmQnXT0hMHgwLHRoaXNbXzB4NDE5NzVmKDB4MjFlKV09ITB4MSx0aGlzW18weDQxOTc1ZigweDIxMyldPSEweDEsdGhpc1snX2luQnJvd3NlciddPSEhdGhpc1snZ2xvYmFsJ11bXzB4NDE5NzVmKDB4MjkxKV0sdGhpc1snX1dlYlNvY2tldENsYXNzJ109bnVsbCx0aGlzW18weDQxOTc1ZigweDJiNSldPTB4MCx0aGlzWydfbWF4Q29ubmVjdEF0dGVtcHRDb3VudCddPTB4MTQsdGhpc1tfMHg0MTk3NWYoMHgyYzEpXT10aGlzWydfaW5Ccm93c2VyJ10/J0NvbnNvbGVcXFxceDIwTmluamFcXFxceDIwZmFpbGVkXFxcXHgyMHRvXFxcXHgyMHNlbmRcXFxceDIwbG9ncyxcXFxceDIwcmVmcmVzaGluZ1xcXFx4MjB0aGVcXFxceDIwcGFnZVxcXFx4MjBtYXlcXFxceDIwaGVscCc6J0NvbnNvbGVcXFxceDIwTmluamFcXFxceDIwZmFpbGVkXFxcXHgyMHRvXFxcXHgyMHNlbmRcXFxceDIwbG9ncyxcXFxceDIwcmVzdGFydGluZ1xcXFx4MjB0aGVcXFxceDIwcHJvY2Vzc1xcXFx4MjBtYXlcXFxceDIwaGVscCc7fWFzeW5jW18weDU4NGZkZigweDIzNyldKCl7dmFyIF8weDNmZTkwMD1fMHg1ODRmZGY7aWYodGhpc1snX1dlYlNvY2tldENsYXNzJ10pcmV0dXJuIHRoaXNbXzB4M2ZlOTAwKDB4MmM4KV07bGV0IF8weDNiOTBkZjtpZih0aGlzW18weDNmZTkwMCgweDI5ZildKV8weDNiOTBkZj10aGlzW18weDNmZTkwMCgweDFmMyldWydXZWJTb2NrZXQnXTtlbHNle2lmKHRoaXNbJ2dsb2JhbCddWydwcm9jZXNzJ10/LltfMHgzZmU5MDAoMHgyMGEpXSlfMHgzYjkwZGY9dGhpc1tfMHgzZmU5MDAoMHgxZjMpXVtfMHgzZmU5MDAoMHgyNjIpXT8uW18weDNmZTkwMCgweDIwYSldO2Vsc2UgdHJ5e2xldCBfMHgyZDllZTY9YXdhaXQgaW1wb3J0KF8weDNmZTkwMCgweDIwYikpO18weDNiOTBkZj0oYXdhaXQgaW1wb3J0KChhd2FpdCBpbXBvcnQoXzB4M2ZlOTAwKDB4Mjk2KSkpW18weDNmZTkwMCgweDIzNSldKF8weDJkOWVlNltfMHgzZmU5MDAoMHgyOTgpXSh0aGlzW18weDNmZTkwMCgweDI2MCldLF8weDNmZTkwMCgweDI1OSkpKVtfMHgzZmU5MDAoMHgyMDMpXSgpKSlbXzB4M2ZlOTAwKDB4Mjk5KV07fWNhdGNoe3RyeXtfMHgzYjkwZGY9cmVxdWlyZShyZXF1aXJlKF8weDNmZTkwMCgweDIwYikpW18weDNmZTkwMCgweDI5OCldKHRoaXNbXzB4M2ZlOTAwKDB4MjYwKV0sJ3dzJykpO31jYXRjaHt0aHJvdyBuZXcgRXJyb3IoXzB4M2ZlOTAwKDB4MmMwKSk7fX19cmV0dXJuIHRoaXNbJ19XZWJTb2NrZXRDbGFzcyddPV8weDNiOTBkZixfMHgzYjkwZGY7fVtfMHg1ODRmZGYoMHgxZmEpXSgpe3ZhciBfMHgxNTRmMmM9XzB4NTg0ZmRmO3RoaXNbXzB4MTU0ZjJjKDB4MjEzKV18fHRoaXNbXzB4MTU0ZjJjKDB4MjFlKV18fHRoaXNbXzB4MTU0ZjJjKDB4MmI1KV0+PXRoaXNbXzB4MTU0ZjJjKDB4MmFkKV18fCh0aGlzW18weDE1NGYyYygweDIwZCldPSEweDEsdGhpc1tfMHgxNTRmMmMoMHgyMTMpXT0hMHgwLHRoaXNbJ19jb25uZWN0QXR0ZW1wdENvdW50J10rKyx0aGlzWydfd3MnXT1uZXcgUHJvbWlzZSgoXzB4MzQ1NzhiLF8weDQ3NmRlOCk9Pnt2YXIgXzB4MTViMDRmPV8weDE1NGYyYzt0aGlzW18weDE1YjA0ZigweDIzNyldKClbXzB4MTViMDRmKDB4MjZiKV0oXzB4MjkyYzg3PT57dmFyIF8weDM3NzViZj1fMHgxNWIwNGY7bGV0IF8weDEzNDg0ND1uZXcgXzB4MjkyYzg3KF8weDM3NzViZigweDI0ZikrdGhpc1tfMHgzNzc1YmYoMHgyNzMpXSsnOicrdGhpc1tfMHgzNzc1YmYoMHgyN2QpXSk7XzB4MTM0ODQ0W18weDM3NzViZigweDIxMCldPSgpPT57dmFyIF8weDVjNzMyOT1fMHgzNzc1YmY7dGhpc1tfMHg1YzczMjkoMHgyODgpXT0hMHgxLHRoaXNbXzB4NWM3MzI5KDB4MjNhKV0oXzB4MTM0ODQ0KSx0aGlzW18weDVjNzMyOSgweDJhMCldKCksXzB4NDc2ZGU4KG5ldyBFcnJvcihfMHg1YzczMjkoMHgyNTYpKSk7fSxfMHgxMzQ4NDRbXzB4Mzc3NWJmKDB4MWVjKV09KCk9Pnt2YXIgXzB4NGI3YTFlPV8weDM3NzViZjt0aGlzW18weDRiN2ExZSgweDI5ZildfHxfMHgxMzQ4NDRbXzB4NGI3YTFlKDB4MjhlKV0mJl8weDEzNDg0NFtfMHg0YjdhMWUoMHgyOGUpXVtfMHg0YjdhMWUoMHgyMzgpXSYmXzB4MTM0ODQ0W18weDRiN2ExZSgweDI4ZSldWyd1bnJlZiddKCksXzB4MzQ1NzhiKF8weDEzNDg0NCk7fSxfMHgxMzQ4NDRbXzB4Mzc3NWJmKDB4MjNmKV09KCk9Pnt2YXIgXzB4NGNlMjM1PV8weDM3NzViZjt0aGlzW18weDRjZTIzNSgweDIwZCldPSEweDAsdGhpc1tfMHg0Y2UyMzUoMHgyM2EpXShfMHgxMzQ4NDQpLHRoaXNbXzB4NGNlMjM1KDB4MmEwKV0oKTt9LF8weDEzNDg0NFtfMHgzNzc1YmYoMHgyNGUpXT1fMHg1MmJlNWU9Pnt2YXIgXzB4MWZhOTM2PV8weDM3NzViZjt0cnl7XzB4NTJiZTVlJiZfMHg1MmJlNWVbXzB4MWZhOTM2KDB4MjE5KV0mJnRoaXNbXzB4MWZhOTM2KDB4MjlmKV0mJkpTT05bXzB4MWZhOTM2KDB4MmMyKV0oXzB4NTJiZTVlWydkYXRhJ10pW18weDFmYTkzNigweDJiMyldPT09XzB4MWZhOTM2KDB4MjZmKSYmdGhpc1tfMHgxZmE5MzYoMHgxZjMpXVtfMHgxZmE5MzYoMHgyMWIpXVsncmVsb2FkJ10oKTt9Y2F0Y2h7fX07fSlbXzB4MTViMDRmKDB4MjZiKV0oXzB4MjJkOTFjPT4odGhpc1tfMHgxNWIwNGYoMHgyMWUpXT0hMHgwLHRoaXNbXzB4MTViMDRmKDB4MjEzKV09ITB4MSx0aGlzW18weDE1YjA0ZigweDIwZCldPSEweDEsdGhpc1snX2FsbG93ZWRUb1NlbmQnXT0hMHgwLHRoaXNbXzB4MTViMDRmKDB4MmI1KV09MHgwLF8weDIyZDkxYykpW18weDE1YjA0ZigweDIyZSldKF8weDM4ZmZlND0+KHRoaXNbXzB4MTViMDRmKDB4MjFlKV09ITB4MSx0aGlzW18weDE1YjA0ZigweDIxMyldPSEweDEsXzB4NDc2ZGU4KG5ldyBFcnJvcihfMHgxNWIwNGYoMHgyNDgpKyhfMHgzOGZmZTQmJl8weDM4ZmZlNFsnbWVzc2FnZSddKSkpKSk7fSkpO31bXzB4NTg0ZmRmKDB4MjNhKV0oXzB4MzRlNjlhKXt2YXIgXzB4MjQxYTRiPV8weDU4NGZkZjt0aGlzW18weDI0MWE0YigweDIxZSldPSEweDEsdGhpc1tfMHgyNDFhNGIoMHgyMTMpXT0hMHgxO3RyeXtfMHgzNGU2OWFbXzB4MjQxYTRiKDB4MjNmKV09bnVsbCxfMHgzNGU2OWFbXzB4MjQxYTRiKDB4MjEwKV09bnVsbCxfMHgzNGU2OWFbXzB4MjQxYTRiKDB4MWVjKV09bnVsbDt9Y2F0Y2h7fXRyeXtfMHgzNGU2OWFbXzB4MjQxYTRiKDB4MjE4KV08MHgyJiZfMHgzNGU2OWFbXzB4MjQxYTRiKDB4MjY3KV0oKTt9Y2F0Y2h7fX1bXzB4NTg0ZmRmKDB4MmEwKV0oKXt2YXIgXzB4YjA1YmQzPV8weDU4NGZkZjtjbGVhclRpbWVvdXQodGhpc1tfMHhiMDViZDMoMHgyYWMpXSksISh0aGlzWydfY29ubmVjdEF0dGVtcHRDb3VudCddPj10aGlzWydfbWF4Q29ubmVjdEF0dGVtcHRDb3VudCddKSYmKHRoaXNbXzB4YjA1YmQzKDB4MmFjKV09c2V0VGltZW91dCgoKT0+e3ZhciBfMHgxMDk2NWM9XzB4YjA1YmQzO3RoaXNbXzB4MTA5NjVjKDB4MjFlKV18fHRoaXNbXzB4MTA5NjVjKDB4MjEzKV18fCh0aGlzW18weDEwOTY1YygweDFmYSldKCksdGhpc1snX3dzJ10/LltfMHgxMDk2NWMoMHgyMmUpXSgoKT0+dGhpc1snX2F0dGVtcHRUb1JlY29ubmVjdFNob3J0bHknXSgpKSk7fSwweDFmNCksdGhpc1snX3JlY29ubmVjdFRpbWVvdXQnXVtfMHhiMDViZDMoMHgyMzgpXSYmdGhpc1tfMHhiMDViZDMoMHgyYWMpXVtfMHhiMDViZDMoMHgyMzgpXSgpKTt9YXN5bmNbXzB4NTg0ZmRmKDB4MjQ1KV0oXzB4NDNmMzQyKXt2YXIgXzB4MTY1NDgxPV8weDU4NGZkZjt0cnl7aWYoIXRoaXNbXzB4MTY1NDgxKDB4Mjg4KV0pcmV0dXJuO3RoaXNbXzB4MTY1NDgxKDB4MjBkKV0mJnRoaXNbXzB4MTY1NDgxKDB4MWZhKV0oKSwoYXdhaXQgdGhpc1tfMHgxNjU0ODEoMHgyODIpXSlbXzB4MTY1NDgxKDB4MjQ1KV0oSlNPTltfMHgxNjU0ODEoMHgyMzQpXShfMHg0M2YzNDIpKTt9Y2F0Y2goXzB4MjE2ZWFiKXtjb25zb2xlW18weDE2NTQ4MSgweDI3MildKHRoaXNbXzB4MTY1NDgxKDB4MmMxKV0rJzpcXFxceDIwJysoXzB4MjE2ZWFiJiZfMHgyMTZlYWJbXzB4MTY1NDgxKDB4MjE0KV0pKSx0aGlzW18weDE2NTQ4MSgweDI4OCldPSEweDEsdGhpc1tfMHgxNjU0ODEoMHgyYTApXSgpO319fTtmdW5jdGlvbiBWKF8weDU2ZDZjYyxfMHg1NGRhY2MsXzB4MjQ5NzFlLF8weDIwYjNhOSxfMHgxOWYzYjkpe3ZhciBfMHg1MzFhYjc9XzB4NTg0ZmRmO2xldCBfMHg4MTljMzM9XzB4MjQ5NzFlW18weDUzMWFiNygweDI0NyldKCcsJylbXzB4NTMxYWI3KDB4MjgwKV0oXzB4YWY5NDYwPT57dmFyIF8weDUyOGU5OT1fMHg1MzFhYjc7dHJ5e18weDU2ZDZjY1snX2NvbnNvbGVfbmluamFfc2Vzc2lvbiddfHwoKF8weDE5ZjNiOT09PV8weDUyOGU5OSgweDI5NSl8fF8weDE5ZjNiOT09PV8weDUyOGU5OSgweDI3MSkpJiYoXzB4MTlmM2I5Kz1fMHg1NmQ2Y2NbXzB4NTI4ZTk5KDB4MjYyKV0/LltfMHg1MjhlOTkoMHgxZjQpXT8uWydub2RlJ10/XzB4NTI4ZTk5KDB4MjkwKTonXFxcXHgyMGJyb3dzZXInKSxfMHg1NmQ2Y2NbXzB4NTI4ZTk5KDB4MjUyKV09eydpZCc6K25ldyBEYXRlKCksJ3Rvb2wnOl8weDE5ZjNiOX0pO2xldCBfMHgyNTVmOWY9bmV3IFEoXzB4NTZkNmNjLF8weDU0ZGFjYyxfMHhhZjk0NjAsXzB4MjBiM2E5KTtyZXR1cm4gXzB4MjU1ZjlmW18weDUyOGU5OSgweDI0NSldW18weDUyOGU5OSgweDI3ZildKF8weDI1NWY5Zik7fWNhdGNoKF8weDVlZmY0MSl7cmV0dXJuIGNvbnNvbGVbXzB4NTI4ZTk5KDB4MjcyKV0oXzB4NTI4ZTk5KDB4MjBmKSxfMHg1ZWZmNDEmJl8weDVlZmY0MVsnbWVzc2FnZSddKSwoKT0+e307fX0pO3JldHVybiBfMHgxNDFhZjY9Pl8weDgxOWMzM1snZm9yRWFjaCddKF8weDE5NjlmMz0+XzB4MTk2OWYzKF8weDE0MWFmNikpO31mdW5jdGlvbiBfMHgxMTk3KCl7dmFyIF8weDI3YmU0ZT1bJ2luZGV4T2YnLCdfY29uc29sZV9uaW5qYScsJ1N0cmluZycsW1xcXCJsb2NhbGhvc3RcXFwiLFxcXCIxMjcuMC4wLjFcXFwiLFxcXCJleGFtcGxlLmN5cHJlc3MuaW9cXFwiLFxcXCJERVNLVE9QLVBKS0lUSklcXFwiLFxcXCJodHRwOi8vMTI3LjAuMC4xOjU1MDBcXFwiLFxcXCJodHRwOi8vMTI3LjAuMC4xXFxcIixcXFwiMTkyLjE2OC4xLjhcXFwiXSwnX29iamVjdFRvU3RyaW5nJywnX3NvcnRQcm9wcycsJ19hZGRQcm9wZXJ0eScsJzU1NlRJYkhXcScsJ2ZhaWxlZFxcXFx4MjB0b1xcXFx4MjBmaW5kXFxcXHgyMGFuZFxcXFx4MjBsb2FkXFxcXHgyMFdlYlNvY2tldCcsJ19zZW5kRXJyb3JNZXNzYWdlJywncGFyc2UnLCd0eXBlJywncm9vdEV4cHJlc3Npb24nLCdbb2JqZWN0XFxcXHgyME1hcF0nLCdhcnJheScsJ1NldCcsJ19XZWJTb2NrZXRDbGFzcycsJ19fZXMnKydNb2R1bGUnLCdzdHJpbmcnLCdyZXNvbHZlR2V0dGVycycsJ29ub3BlbicsJ19zZXROb2RlSWQnLCdkZXB0aCcsJ19wcm9jZXNzVHJlZU5vZGVSZXN1bHQnLCdjYXBwZWQnLCdoaXRzJywnZ2V0T3duUHJvcGVydHlTeW1ib2xzJywnZ2xvYmFsJywndmVyc2lvbnMnLCc0MjU0eEhSTklqJywndGltZScsJ19hZGRpdGlvbmFsTWV0YWRhdGEnLCdnZXRPd25Qcm9wZXJ0eU5hbWVzJywnX3VuZGVmaW5lZCcsJ19jb25uZWN0VG9Ib3N0Tm93JywndGVzdCcsJ2hvc3RuYW1lJywnZnVuY05hbWUnLCd0aW1lU3RhbXAnLCdfcF8nLCd2YWx1ZScsJ25lZ2F0aXZlWmVybycsJ190cmVlTm9kZVByb3BlcnRpZXNCZWZvcmVGdWxsVmFsdWUnLCd0b1N0cmluZycsJ251eHQnLCcxLjAuMCcsJ19rZXlTdHJSZWdFeHAnLCdlbGVtZW50cycsJzI1NFFwZ0RVcCcsJ19hZGRPYmplY3RQcm9wZXJ0eScsJ19XZWJTb2NrZXQnLCdwYXRoJywnMjU5SXdoa2RiJywnX2FsbG93ZWRUb0Nvbm5lY3RPblNlbmQnLCdfZ2V0T3duUHJvcGVydHlOYW1lcycsJ2xvZ2dlclxcXFx4MjBmYWlsZWRcXFxceDIwdG9cXFxceDIwY29ubmVjdFxcXFx4MjB0b1xcXFx4MjBob3N0Jywnb25lcnJvcicsJ3Jvb3RfZXhwJywnX3NldE5vZGVFeHBhbmRhYmxlU3RhdGUnLCdfY29ubmVjdGluZycsJ21lc3NhZ2UnLFxcXCJjOlxcXFxcXFxcVXNlcnNcXFxcXFxcXGNhcmxvXFxcXFxcXFwudnNjb2RlXFxcXFxcXFxleHRlbnNpb25zXFxcXFxcXFx3YWxsYWJ5anMuY29uc29sZS1uaW5qYS0wLjAuMTExXFxcXFxcXFxub2RlX21vZHVsZXNcXFwiLCdzdWJzdHInLCdjb25jYXQnLCdyZWFkeVN0YXRlJywnZGF0YScsJ3RyYWNlJywnbG9jYXRpb24nLCdkYXRlJywnW29iamVjdFxcXFx4MjBBcnJheV0nLCdfY29ubmVjdGVkJywnY29uc3RydWN0b3InLCdfZ2V0T3duUHJvcGVydHlEZXNjcmlwdG9yJywnX2JsYWNrbGlzdGVkUHJvcGVydHknLCdyZXBsYWNlJywnX1N5bWJvbCcsJ19xdW90ZWRSZWdFeHAnLCdmdW5jdGlvbicsJ19wcm9wZXJ0eU5hbWUnLCdfaXNVbmRlZmluZWQnLCd1bmtub3duJywnYmlnaW50JywnODcxNTI1YXNXTnJnJywnbGV2ZWwnLCd0aW1lRW5kJywnbm93JywnY2F0Y2gnLCdub0Z1bmN0aW9ucycsJzc5ODE2NUFYT3JXZCcsJ29iamVjdCcsJ3JlZHVjZUxpbWl0cycsJ0J1ZmZlcicsJ3N0cmluZ2lmeScsJ3BhdGhUb0ZpbGVVUkwnLCdfc2V0Tm9kZVBlcm1pc3Npb25zJywnZ2V0V2ViU29ja2V0Q2xhc3MnLCd1bnJlZicsJ3BlcmZfaG9va3MnLCdfZGlzcG9zZVdlYnNvY2tldCcsJ25lZ2F0aXZlSW5maW5pdHknLCdsZW5ndGgnLCdhdXRvRXhwYW5kTGltaXQnLCdhdXRvRXhwYW5kTWF4RGVwdGgnLCdvbmNsb3NlJywnYXV0b0V4cGFuZFByZXZpb3VzT2JqZWN0cycsJ2luY2x1ZGVzJywnZ2V0JywnNDQyMTZBVm5YdGsnLCdhbGxTdHJMZW5ndGgnLCdzZW5kJywnc2VyaWFsaXplJywnc3BsaXQnLCdmYWlsZWRcXFxceDIwdG9cXFxceDIwY29ubmVjdFxcXFx4MjB0b1xcXFx4MjBob3N0OlxcXFx4MjAnLCdpbmRleCcsJ19pc1ByaW1pdGl2ZVdyYXBwZXJUeXBlJywnbm9kZScsJ2F1dG9FeHBhbmQnLCcxNjgyNTQ4MzU1NTQ2Jywnb25tZXNzYWdlJywnd3M6Ly8nLCdzdGFja1RyYWNlTGltaXQnLCdfZGF0ZVRvU3RyaW5nJywnX2NvbnNvbGVfbmluamFfc2Vzc2lvbicsJ2NvbnNvbGUnLCdzbGljZScsJ3Jvb3RfZXhwX2lkJywnbG9nZ2VyXFxcXHgyMHdlYnNvY2tldFxcXFx4MjBlcnJvcicsJ2V4cElkJywndmFsdWVPZicsJ3dzL2luZGV4LmpzJywnX3Byb3BlcnR5JywnY2FsbCcsJ2VsYXBzZWQnLCdfbnVtYmVyUmVnRXhwJywnZXJyb3InLCdIVE1MQWxsQ29sbGVjdGlvbicsJ25vZGVNb2R1bGVzJywnY3JlYXRlJywncHJvY2VzcycsJ19pc05lZ2F0aXZlWmVybycsJ251bWJlcicsJ1JlZ0V4cCcsJ3NvcnRQcm9wcycsJ2Nsb3NlJywnX2lzU2V0JywnTWFwJywncHJvcHMnLCd0aGVuJywnUE9TSVRJVkVfSU5GSU5JVFknLCdfc2V0Tm9kZUV4cHJlc3Npb25QYXRoJywnbG9nJywncmVsb2FkJywnX2dldE93blByb3BlcnR5U3ltYm9scycsJ3JlbWl4Jywnd2FybicsJ2hvc3QnLCdwYXJlbnQnLCcyMzFBUEpuSWwnLCdwcm90b3R5cGUnLCdOdW1iZXInLCc2MTI0MDJLZ21TcnInLCdhdXRvRXhwYW5kUHJvcGVydHlDb3VudCcsJ2NvdW50Jywnc3RhY2snLCdfY2xlYW5Ob2RlJywncG9ydCcsJ19pc1ByaW1pdGl2ZVR5cGUnLCdiaW5kJywnbWFwJywnX3NldE5vZGVMYWJlbCcsJ193cycsJ2VudW1lcmFibGUnLCdfaGFzU3ltYm9sUHJvcGVydHlPbkl0c1BhdGgnLCdORUdBVElWRV9JTkZJTklUWScsJ251bGwnLCd0b0xvd2VyQ2FzZScsJ19hbGxvd2VkVG9TZW5kJywnLi4uJywnc2V0JywnX2hhc01hcE9uSXRzUGF0aCcsJ19wcm9wZXJ0eUFjY2Vzc29yJywnX2FkZExvYWROb2RlJywnX3NvY2tldCcsJ0Vycm9yJywnXFxcXHgyMHNlcnZlcicsJ1dlYlNvY2tldCcsJ3B1c2gnLCdfdHlwZScsJ2FyZ3VtZW50UmVzb2x1dGlvbkVycm9yJywnbmV4dC5qcycsJ3VybCcsJ3BlcmZvcm1hbmNlJywnam9pbicsJ2RlZmF1bHQnLCc6bG9nUG9pbnRJZDonLCdjdXJyZW50JywnZm9yRWFjaCcsJ19hZGRGdW5jdGlvbnNOb2RlJywnJywnX2luQnJvd3NlcicsJ19hdHRlbXB0VG9SZWNvbm5lY3RTaG9ydGx5JywnX2lzTWFwJywnX0hUTUxBbGxDb2xsZWN0aW9uJywnX2NhcElmU3RyaW5nJywnc3ltYm9sJywnaXNFeHByZXNzaW9uVG9FdmFsdWF0ZScsJ190cmVlTm9kZVByb3BlcnRpZXNBZnRlckZ1bGxWYWx1ZScsJ3NldHRlcicsJ19jb25zb2xlTmluamFBbGxvd2VkVG9TdGFydCcsJ25hbWUnLCdTeW1ib2wnLCd1bmRlZmluZWQnLCdfcmVjb25uZWN0VGltZW91dCcsJ19tYXhDb25uZWN0QXR0ZW1wdENvdW50JywnZGVmaW5lUHJvcGVydHknLCdfcF9sZW5ndGgnLCcyNzc1OTMwRkNlU3pQJywnc3RyTGVuZ3RoJywnaGFzT3duUHJvcGVydHknLCdtZXRob2QnLCdjYXBwZWRFbGVtZW50cycsJ19jb25uZWN0QXR0ZW1wdENvdW50JywnZ2V0dGVyJywnX3NldE5vZGVRdWVyeVBhdGgnXTtfMHgxMTk3PWZ1bmN0aW9uKCl7cmV0dXJuIF8weDI3YmU0ZTt9O3JldHVybiBfMHgxMTk3KCk7fWZ1bmN0aW9uIF8weDQ2MWUoXzB4MjFkMWFmLF8weDNhMjFlMSl7dmFyIF8weDExOTc4YT1fMHgxMTk3KCk7cmV0dXJuIF8weDQ2MWU9ZnVuY3Rpb24oXzB4NDYxZWQyLF8weDFlZTcwNCl7XzB4NDYxZWQyPV8weDQ2MWVkMi0weDFlYzt2YXIgXzB4MjVhZmRlPV8weDExOTc4YVtfMHg0NjFlZDJdO3JldHVybiBfMHgyNWFmZGU7fSxfMHg0NjFlKF8weDIxZDFhZixfMHgzYTIxZTEpO31mdW5jdGlvbiBIKF8weDVhMGMxNyl7dmFyIF8weDFkNzg3Yj1fMHg1ODRmZGY7bGV0IF8weDU1YjU3Mj1mdW5jdGlvbihfMHg0Y2E4ZWYsXzB4M2UxNDFmKXtyZXR1cm4gXzB4M2UxNDFmLV8weDRjYThlZjt9LF8weDNlZWI3NztpZihfMHg1YTBjMTdbXzB4MWQ3ODdiKDB4Mjk3KV0pXzB4M2VlYjc3PWZ1bmN0aW9uKCl7dmFyIF8weDJiZGNmZT1fMHgxZDc4N2I7cmV0dXJuIF8weDVhMGMxN1tfMHgyYmRjZmUoMHgyOTcpXVtfMHgyYmRjZmUoMHgyMmQpXSgpO307ZWxzZXtpZihfMHg1YTBjMTdbXzB4MWQ3ODdiKDB4MjYyKV0mJl8weDVhMGMxN1tfMHgxZDc4N2IoMHgyNjIpXVsnaHJ0aW1lJ10pXzB4M2VlYjc3PWZ1bmN0aW9uKCl7dmFyIF8weDUzNGQxNj1fMHgxZDc4N2I7cmV0dXJuIF8weDVhMGMxN1tfMHg1MzRkMTYoMHgyNjIpXVsnaHJ0aW1lJ10oKTt9LF8weDU1YjU3Mj1mdW5jdGlvbihfMHgyZDAyNjMsXzB4MjE3NDNlKXtyZXR1cm4gMHgzZTgqKF8weDIxNzQzZVsweDBdLV8weDJkMDI2M1sweDBdKSsoXzB4MjE3NDNlWzB4MV0tXzB4MmQwMjYzWzB4MV0pLzB4ZjQyNDA7fTtlbHNlIHRyeXtsZXQge3BlcmZvcm1hbmNlOl8weDRiZjNjZH09cmVxdWlyZShfMHgxZDc4N2IoMHgyMzkpKTtfMHgzZWViNzc9ZnVuY3Rpb24oKXtyZXR1cm4gXzB4NGJmM2NkWydub3cnXSgpO307fWNhdGNoe18weDNlZWI3Nz1mdW5jdGlvbigpe3JldHVybituZXcgRGF0ZSgpO307fX1yZXR1cm57J2VsYXBzZWQnOl8weDU1YjU3MiwndGltZVN0YW1wJzpfMHgzZWViNzcsJ25vdyc6KCk9PkRhdGVbJ25vdyddKCl9O31mdW5jdGlvbiBYKF8weDI4M2I1YyxfMHgxYjVlYjEsXzB4NGZkZGMxKXt2YXIgXzB4NGE5NzY1PV8weDU4NGZkZjtpZihfMHgyODNiNWNbXzB4NGE5NzY1KDB4MmE4KV0hPT12b2lkIDB4MClyZXR1cm4gXzB4MjgzYjVjW18weDRhOTc2NSgweDJhOCldO2xldCBfMHgzYWNhYzM9XzB4MjgzYjVjW18weDRhOTc2NSgweDI2MildPy5bXzB4NGE5NzY1KDB4MWY0KV0/LltfMHg0YTk3NjUoMHgyNGIpXTtyZXR1cm4gXzB4M2FjYWMzJiZfMHg0ZmRkYzE9PT1fMHg0YTk3NjUoMHgyMDQpP18weDI4M2I1Y1tfMHg0YTk3NjUoMHgyYTgpXT0hMHgxOl8weDI4M2I1Y1tfMHg0YTk3NjUoMHgyYTgpXT1fMHgzYWNhYzN8fCFfMHgxYjVlYjF8fF8weDI4M2I1Y1tfMHg0YTk3NjUoMHgyMWIpXT8uWydob3N0bmFtZSddJiZfMHgxYjVlYjFbXzB4NGE5NzY1KDB4MjQxKV0oXzB4MjgzYjVjW18weDRhOTc2NSgweDIxYildW18weDRhOTc2NSgweDFmYyldKSxfMHgyODNiNWNbXzB4NGE5NzY1KDB4MmE4KV07fSgoXzB4YTY3YWUzLF8weDM3Mzg5ZSxfMHg1MWI3N2QsXzB4MjViNjMwLF8weDEzOTgyMSxfMHgzNWMyNjUsXzB4NTA3YjdmLF8weDM2YTcxNyxfMHg2YzhhMWMpPT57dmFyIF8weDFkMjMzMz1fMHg1ODRmZGY7aWYoXzB4YTY3YWUzWydfY29uc29sZV9uaW5qYSddKXJldHVybiBfMHhhNjdhZTNbXzB4MWQyMzMzKDB4MmI5KV07aWYoIVgoXzB4YTY3YWUzLF8weDM2YTcxNyxfMHgxMzk4MjEpKXJldHVybiBfMHhhNjdhZTNbXzB4MWQyMzMzKDB4MmI5KV09eydjb25zb2xlTG9nJzooKT0+e30sJ2NvbnNvbGVUcmFjZSc6KCk9Pnt9LCdjb25zb2xlVGltZSc6KCk9Pnt9LCdjb25zb2xlVGltZUVuZCc6KCk9Pnt9LCdhdXRvTG9nJzooKT0+e30sJ2F1dG9UcmFjZSc6KCk9Pnt9LCdhdXRvVGltZSc6KCk9Pnt9LCdhdXRvVGltZUVuZCc6KCk9Pnt9fSxfMHhhNjdhZTNbXzB4MWQyMzMzKDB4MmI5KV07bGV0IF8weDg0YjJiND17J3Byb3BzJzoweDY0LCdlbGVtZW50cyc6MHg2NCwnc3RyTGVuZ3RoJzoweDQwMCoweDMyLCd0b3RhbFN0ckxlbmd0aCc6MHg0MDAqMHgzMiwnYXV0b0V4cGFuZExpbWl0JzoweDEzODgsJ2F1dG9FeHBhbmRNYXhEZXB0aCc6MHhhfSxfMHg0NDJiYWU9eydwcm9wcyc6MHg1LCdlbGVtZW50cyc6MHg1LCdzdHJMZW5ndGgnOjB4MTAwLCd0b3RhbFN0ckxlbmd0aCc6MHgxMDAqMHgzLCdhdXRvRXhwYW5kTGltaXQnOjB4MWUsJ2F1dG9FeHBhbmRNYXhEZXB0aCc6MHgyfSxfMHgyNzE5MGY9SChfMHhhNjdhZTMpLF8weDNjMzI3OD1fMHgyNzE5MGZbXzB4MWQyMzMzKDB4MjVjKV0sXzB4MjNiYzdhPV8weDI3MTkwZltfMHgxZDIzMzMoMHgxZmUpXSxfMHgyMjJjMTU9XzB4MjcxOTBmWydub3cnXSxfMHg0OGI1MjA9eydoaXRzJzp7fSwndHMnOnt9fSxfMHgyNTE1Y2M9XzB4NWRkZjJiPT57XzB4NDhiNTIwWyd0cyddW18weDVkZGYyYl09XzB4MjNiYzdhKCk7fSxfMHg0M2NhM2E9KF8weDRhYmQxYyxfMHgzOTA4Y2YpPT57dmFyIF8weDUxNzA2ZD1fMHgxZDIzMzM7bGV0IF8weDI0MzIzMj1fMHg0OGI1MjBbJ3RzJ11bXzB4MzkwOGNmXTtpZihkZWxldGUgXzB4NDhiNTIwWyd0cyddW18weDM5MDhjZl0sXzB4MjQzMjMyKXtsZXQgXzB4M2QwMDQ2PV8weDNjMzI3OChfMHgyNDMyMzIsXzB4MjNiYzdhKCkpO18weDNjOTIyNihfMHg0NjJiOTIoXzB4NTE3MDZkKDB4MWY2KSxfMHg0YWJkMWMsXzB4MjIyYzE1KCksXzB4MTMxZTBiLFtfMHgzZDAwNDZdLF8weDM5MDhjZikpO319LF8weDNmYmJkNT1fMHgxZTNiYTE9Pl8weDQyNDk3MD0+e3ZhciBfMHg1YmVkYjg9XzB4MWQyMzMzO3RyeXtfMHgyNTE1Y2MoXzB4NDI0OTcwKSxfMHgxZTNiYTEoXzB4NDI0OTcwKTt9ZmluYWxseXtfMHhhNjdhZTNbXzB4NWJlZGI4KDB4MjUzKV1bJ3RpbWUnXT1fMHgxZTNiYTE7fX0sXzB4NzIxODFiPV8weDE4YzRhYz0+XzB4NGVlOGZhPT57dmFyIF8weGI2NjA5NT1fMHgxZDIzMzM7dHJ5e2xldCBbXzB4NGMzMWRkLF8weDQ1YmEzMl09XzB4NGVlOGZhWydzcGxpdCddKF8weGI2NjA5NSgweDI5YSkpO18weDQzY2EzYShfMHg0NWJhMzIsXzB4NGMzMWRkKSxfMHgxOGM0YWMoXzB4NGMzMWRkKTt9ZmluYWxseXtfMHhhNjdhZTNbJ2NvbnNvbGUnXVtfMHhiNjYwOTUoMHgyMmMpXT1fMHgxOGM0YWM7fX07XzB4YTY3YWUzW18weDFkMjMzMygweDJiOSldPXsnY29uc29sZUxvZyc6KF8weDQwNGNjNCxfMHg0ZTlmMmIpPT57dmFyIF8weDQ3YjlhMT1fMHgxZDIzMzM7XzB4YTY3YWUzW18weDQ3YjlhMSgweDI1MyldWydsb2cnXVsnbmFtZSddIT09J2Rpc2FibGVkTG9nJyYmXzB4M2M5MjI2KF8weDQ2MmI5MignbG9nJyxfMHg0MDRjYzQsXzB4MjIyYzE1KCksXzB4MTMxZTBiLF8weDRlOWYyYikpO30sJ2NvbnNvbGVUcmFjZSc6KF8weDQzYzgxNSxfMHgxZTJjNWUpPT57dmFyIF8weDVmNTliOD1fMHgxZDIzMzM7XzB4YTY3YWUzW18weDVmNTliOCgweDI1MyldW18weDVmNTliOCgweDI2ZSldW18weDVmNTliOCgweDJhOSldIT09J2Rpc2FibGVkVHJhY2UnJiZfMHgzYzkyMjYoXzB4NDYyYjkyKF8weDVmNTliOCgweDIxYSksXzB4NDNjODE1LF8weDIyMmMxNSgpLF8weDEzMWUwYixfMHgxZTJjNWUpKTt9LCdjb25zb2xlVGltZSc6KCk9Pnt2YXIgXzB4NDMxYTAxPV8weDFkMjMzMztfMHhhNjdhZTNbXzB4NDMxYTAxKDB4MjUzKV1bXzB4NDMxYTAxKDB4MWY2KV09XzB4M2ZiYmQ1KF8weGE2N2FlM1snY29uc29sZSddW18weDQzMWEwMSgweDFmNildKTt9LCdjb25zb2xlVGltZUVuZCc6KCk9Pnt2YXIgXzB4NDIyNzc0PV8weDFkMjMzMztfMHhhNjdhZTNbXzB4NDIyNzc0KDB4MjUzKV1bJ3RpbWVFbmQnXT1fMHg3MjE4MWIoXzB4YTY3YWUzW18weDQyMjc3NCgweDI1MyldWyd0aW1lRW5kJ10pO30sJ2F1dG9Mb2cnOihfMHg0YzFkNTgsXzB4MmFmNjU4KT0+e3ZhciBfMHgzZmQ4NDY9XzB4MWQyMzMzO18weDNjOTIyNihfMHg0NjJiOTIoXzB4M2ZkODQ2KDB4MjZlKSxfMHgyYWY2NTgsXzB4MjIyYzE1KCksXzB4MTMxZTBiLFtfMHg0YzFkNThdKSk7fSwnYXV0b1RyYWNlJzooXzB4M2E2ZDQ0LF8weDIxNGNjNCk9Pnt2YXIgXzB4MzY4ZDY4PV8weDFkMjMzMztfMHgzYzkyMjYoXzB4NDYyYjkyKF8weDM2OGQ2OCgweDIxYSksXzB4MjE0Y2M0LF8weDIyMmMxNSgpLF8weDEzMWUwYixbXzB4M2E2ZDQ0XSkpO30sJ2F1dG9UaW1lJzooXzB4NTU4NjBkLF8weDQ4ZGQ5NSxfMHgyNDVmZDkpPT57XzB4MjUxNWNjKF8weDI0NWZkOSk7fSwnYXV0b1RpbWVFbmQnOihfMHgxMGQ0YzMsXzB4NDcxNzEyLF8weDVkYzhjMik9PntfMHg0M2NhM2EoXzB4NDcxNzEyLF8weDVkYzhjMik7fX07bGV0IF8weDNjOTIyNj1WKF8weGE2N2FlMyxfMHgzNzM4OWUsXzB4NTFiNzdkLF8weDI1YjYzMCxfMHgxMzk4MjEpLF8weDEzMWUwYj1fMHhhNjdhZTNbJ19jb25zb2xlX25pbmphX3Nlc3Npb24nXTtjbGFzcyBfMHgxODhkZmZ7Y29uc3RydWN0b3IoKXt2YXIgXzB4MTM2YmE1PV8weDFkMjMzMzt0aGlzW18weDEzNmJhNSgweDIwNildPS9eKD8hKD86ZG98aWZ8aW58Zm9yfGxldHxuZXd8dHJ5fHZhcnxjYXNlfGVsc2V8ZW51bXxldmFsfGZhbHNlfG51bGx8dGhpc3x0cnVlfHZvaWR8d2l0aHxicmVha3xjYXRjaHxjbGFzc3xjb25zdHxzdXBlcnx0aHJvd3x3aGlsZXx5aWVsZHxkZWxldGV8ZXhwb3J0fGltcG9ydHxwdWJsaWN8cmV0dXJufHN0YXRpY3xzd2l0Y2h8dHlwZW9mfGRlZmF1bHR8ZXh0ZW5kc3xmaW5hbGx5fHBhY2thZ2V8cHJpdmF0ZXxjb250aW51ZXxkZWJ1Z2dlcnxmdW5jdGlvbnxhcmd1bWVudHN8aW50ZXJmYWNlfHByb3RlY3RlZHxpbXBsZW1lbnRzfGluc3RhbmNlb2YpJClbXyRhLXpBLVpcXFxceEEwLVxcXFx1RkZGRl1bXyRhLXpBLVowLTlcXFxceEEwLVxcXFx1RkZGRl0qJC8sdGhpc1tfMHgxMzZiYTUoMHgyNWQpXT0vXigwfFsxLTldWzAtOV0qKSQvLHRoaXNbXzB4MTM2YmE1KDB4MjI0KV09LycoW15cXFxcXFxcXCddfFxcXFxcXFxcJykqJy8sdGhpc1snX3VuZGVmaW5lZCddPV8weGE2N2FlM1tfMHgxMzZiYTUoMHgyYWIpXSx0aGlzWydfSFRNTEFsbENvbGxlY3Rpb24nXT1fMHhhNjdhZTNbXzB4MTM2YmE1KDB4MjVmKV0sdGhpc1tfMHgxMzZiYTUoMHgyMjApXT1PYmplY3RbJ2dldE93blByb3BlcnR5RGVzY3JpcHRvciddLHRoaXNbXzB4MTM2YmE1KDB4MjBlKV09T2JqZWN0WydnZXRPd25Qcm9wZXJ0eU5hbWVzJ10sdGhpc1tfMHgxMzZiYTUoMHgyMjMpXT1fMHhhNjdhZTNbXzB4MTM2YmE1KDB4MmFhKV0sdGhpc1snX3JlZ0V4cFRvU3RyaW5nJ109UmVnRXhwWydwcm90b3R5cGUnXVsndG9TdHJpbmcnXSx0aGlzW18weDEzNmJhNSgweDI1MSldPURhdGVbXzB4MTM2YmE1KDB4Mjc2KV1bJ3RvU3RyaW5nJ107fVsnc2VyaWFsaXplJ10oXzB4MzdkMDlkLF8weDM2ODhjYSxfMHg0Zjc4MDMsXzB4NTg4NjU4KXt2YXIgXzB4NDFlNzhlPV8weDFkMjMzMyxfMHg0ZDI1OTc9dGhpcyxfMHgyMzQzYTk9XzB4NGY3ODAzW18weDQxZTc4ZSgweDI0YyldO2Z1bmN0aW9uIF8weDJiYmJhYShfMHg0MTgxM2YsXzB4NTM4NzYzLF8weDQ2ZWFmNCl7dmFyIF8weDNlNDYzMj1fMHg0MWU3OGU7XzB4NTM4NzYzWyd0eXBlJ109J3Vua25vd24nLF8weDUzODc2M1tfMHgzZTQ2MzIoMHgyNWUpXT1fMHg0MTgxM2ZbJ21lc3NhZ2UnXSxfMHg4ZjlmZDY9XzB4NDZlYWY0W18weDNlNDYzMigweDI0YildW18weDNlNDYzMigweDI5YildLF8weDQ2ZWFmNFtfMHgzZTQ2MzIoMHgyNGIpXVtfMHgzZTQ2MzIoMHgyOWIpXT1fMHg1Mzg3NjMsXzB4NGQyNTk3W18weDNlNDYzMigweDIwMildKF8weDUzODc2MyxfMHg0NmVhZjQpO31pZihfMHgzNjg4Y2EmJl8weDM2ODhjYVtfMHg0MWU3OGUoMHgyOTQpXSlfMHgyYmJiYWEoXzB4MzY4OGNhLF8weDM3ZDA5ZCxfMHg0Zjc4MDMpO2Vsc2UgdHJ5e18weDRmNzgwM1snbGV2ZWwnXSsrLF8weDRmNzgwM1tfMHg0MWU3OGUoMHgyNGMpXSYmXzB4NGY3ODAzW18weDQxZTc4ZSgweDI0MCldWydwdXNoJ10oXzB4MzY4OGNhKTt2YXIgXzB4YzVlNDY1LF8weDU2N2QzMCxfMHg0MTNkMDksXzB4ZmU0NDAsXzB4MmIzYTQ1PVtdLF8weDI1ZTM1MD1bXSxfMHg0N2QzNDAsXzB4NDllNGNmPXRoaXNbJ190eXBlJ10oXzB4MzY4OGNhKSxfMHhjM2YxN2Q9XzB4NDllNGNmPT09XzB4NDFlNzhlKDB4MmM2KSxfMHgxZWUyMzg9ITB4MSxfMHgxMDMzM2M9XzB4NDllNGNmPT09XzB4NDFlNzhlKDB4MjI1KSxfMHg0M2QzOWY9dGhpc1tfMHg0MWU3OGUoMHgyN2UpXShfMHg0OWU0Y2YpLF8weDE5YzFhZj10aGlzW18weDQxZTc4ZSgweDI0YSldKF8weDQ5ZTRjZiksXzB4MTExZTY3PV8weDQzZDM5Znx8XzB4MTljMWFmLF8weDRkMzExMj17fSxfMHg0ZGM1Mjg9MHgwLF8weDg3OTcyMj0hMHgxLF8weDhmOWZkNixfMHg1MTYxNjg9L14oKFsxLTldezF9WzAtOV0qKXwwKSQvO2lmKF8weDRmNzgwM1snZGVwdGgnXSl7aWYoXzB4YzNmMTdkKXtpZihfMHg1NjdkMzA9XzB4MzY4OGNhW18weDQxZTc4ZSgweDIzYyldLF8weDU2N2QzMD5fMHg0Zjc4MDNbXzB4NDFlNzhlKDB4MjA3KV0pe2ZvcihfMHg0MTNkMDk9MHgwLF8weGZlNDQwPV8weDRmNzgwM1snZWxlbWVudHMnXSxfMHhjNWU0NjU9XzB4NDEzZDA5O18weGM1ZTQ2NTxfMHhmZTQ0MDtfMHhjNWU0NjUrKylfMHgyNWUzNTBbXzB4NDFlNzhlKDB4MjkyKV0oXzB4NGQyNTk3W18weDQxZTc4ZSgweDJiZSldKF8weDJiM2E0NSxfMHgzNjg4Y2EsXzB4NDllNGNmLF8weGM1ZTQ2NSxfMHg0Zjc4MDMpKTtfMHgzN2QwOWRbXzB4NDFlNzhlKDB4MmI0KV09ITB4MDt9ZWxzZXtmb3IoXzB4NDEzZDA5PTB4MCxfMHhmZTQ0MD1fMHg1NjdkMzAsXzB4YzVlNDY1PV8weDQxM2QwOTtfMHhjNWU0NjU8XzB4ZmU0NDA7XzB4YzVlNDY1KyspXzB4MjVlMzUwWydwdXNoJ10oXzB4NGQyNTk3W18weDQxZTc4ZSgweDJiZSldKF8weDJiM2E0NSxfMHgzNjg4Y2EsXzB4NDllNGNmLF8weGM1ZTQ2NSxfMHg0Zjc4MDMpKTt9XzB4NGY3ODAzWydhdXRvRXhwYW5kUHJvcGVydHlDb3VudCddKz1fMHgyNWUzNTBbXzB4NDFlNzhlKDB4MjNjKV07fWlmKCEoXzB4NDllNGNmPT09XzB4NDFlNzhlKDB4Mjg2KXx8XzB4NDllNGNmPT09XzB4NDFlNzhlKDB4MmFiKSkmJiFfMHg0M2QzOWYmJl8weDQ5ZTRjZiE9PV8weDQxZTc4ZSgweDJiYSkmJl8weDQ5ZTRjZiE9PV8weDQxZTc4ZSgweDIzMykmJl8weDQ5ZTRjZiE9PV8weDQxZTc4ZSgweDIyOSkpe3ZhciBfMHg0NDJiZGE9XzB4NTg4NjU4Wydwcm9wcyddfHxfMHg0Zjc4MDNbXzB4NDFlNzhlKDB4MjZhKV07aWYodGhpc1tfMHg0MWU3OGUoMHgyNjgpXShfMHgzNjg4Y2EpPyhfMHhjNWU0NjU9MHgwLF8weDM2ODhjYVtfMHg0MWU3OGUoMHgyOWMpXShmdW5jdGlvbihfMHg0MjNlNGEpe3ZhciBfMHg0MmNlYTI9XzB4NDFlNzhlO2lmKF8weDRkYzUyOCsrLF8weDRmNzgwM1tfMHg0MmNlYTIoMHgyNzkpXSsrLF8weDRkYzUyOD5fMHg0NDJiZGEpe18weDg3OTcyMj0hMHgwO3JldHVybjt9aWYoIV8weDRmNzgwM1snaXNFeHByZXNzaW9uVG9FdmFsdWF0ZSddJiZfMHg0Zjc4MDNbJ2F1dG9FeHBhbmQnXSYmXzB4NGY3ODAzWydhdXRvRXhwYW5kUHJvcGVydHlDb3VudCddPl8weDRmNzgwM1tfMHg0MmNlYTIoMHgyM2QpXSl7XzB4ODc5NzIyPSEweDA7cmV0dXJuO31fMHgyNWUzNTBbXzB4NDJjZWEyKDB4MjkyKV0oXzB4NGQyNTk3W18weDQyY2VhMigweDJiZSldKF8weDJiM2E0NSxfMHgzNjg4Y2EsJ1NldCcsXzB4YzVlNDY1KyssXzB4NGY3ODAzLGZ1bmN0aW9uKF8weDRlYzYwMil7cmV0dXJuIGZ1bmN0aW9uKCl7cmV0dXJuIF8weDRlYzYwMjt9O30oXzB4NDIzZTRhKSkpO30pKTp0aGlzW18weDQxZTc4ZSgweDJhMSldKF8weDM2ODhjYSkmJl8weDM2ODhjYVtfMHg0MWU3OGUoMHgyOWMpXShmdW5jdGlvbihfMHg1NTg1MjgsXzB4NDZiYmNlKXt2YXIgXzB4MmExNDMzPV8weDQxZTc4ZTtpZihfMHg0ZGM1MjgrKyxfMHg0Zjc4MDNbXzB4MmExNDMzKDB4Mjc5KV0rKyxfMHg0ZGM1Mjg+XzB4NDQyYmRhKXtfMHg4Nzk3MjI9ITB4MDtyZXR1cm47fWlmKCFfMHg0Zjc4MDNbXzB4MmExNDMzKDB4MmE1KV0mJl8weDRmNzgwM1tfMHgyYTE0MzMoMHgyNGMpXSYmXzB4NGY3ODAzW18weDJhMTQzMygweDI3OSldPl8weDRmNzgwM1snYXV0b0V4cGFuZExpbWl0J10pe18weDg3OTcyMj0hMHgwO3JldHVybjt9dmFyIF8weDMxNzRjOD1fMHg0NmJiY2VbJ3RvU3RyaW5nJ10oKTtfMHgzMTc0YzhbJ2xlbmd0aCddPjB4NjQmJihfMHgzMTc0Yzg9XzB4MzE3NGM4W18weDJhMTQzMygweDI1NCldKDB4MCwweDY0KStfMHgyYTE0MzMoMHgyODkpKSxfMHgyNWUzNTBbXzB4MmExNDMzKDB4MjkyKV0oXzB4NGQyNTk3W18weDJhMTQzMygweDJiZSldKF8weDJiM2E0NSxfMHgzNjg4Y2EsXzB4MmExNDMzKDB4MjY5KSxfMHgzMTc0YzgsXzB4NGY3ODAzLGZ1bmN0aW9uKF8weDMyYjU3Mil7cmV0dXJuIGZ1bmN0aW9uKCl7cmV0dXJuIF8weDMyYjU3Mjt9O30oXzB4NTU4NTI4KSkpO30pLCFfMHgxZWUyMzgpe3RyeXtmb3IoXzB4NDdkMzQwIGluIF8weDM2ODhjYSlpZighKF8weGMzZjE3ZCYmXzB4NTE2MTY4W18weDQxZTc4ZSgweDFmYildKF8weDQ3ZDM0MCkpJiYhdGhpc1tfMHg0MWU3OGUoMHgyMjEpXShfMHgzNjg4Y2EsXzB4NDdkMzQwLF8weDRmNzgwMykpe2lmKF8weDRkYzUyOCsrLF8weDRmNzgwM1tfMHg0MWU3OGUoMHgyNzkpXSsrLF8weDRkYzUyOD5fMHg0NDJiZGEpe18weDg3OTcyMj0hMHgwO2JyZWFrO31pZighXzB4NGY3ODAzW18weDQxZTc4ZSgweDJhNSldJiZfMHg0Zjc4MDNbXzB4NDFlNzhlKDB4MjRjKV0mJl8weDRmNzgwM1tfMHg0MWU3OGUoMHgyNzkpXT5fMHg0Zjc4MDNbXzB4NDFlNzhlKDB4MjNkKV0pe18weDg3OTcyMj0hMHgwO2JyZWFrO31fMHgyNWUzNTBbJ3B1c2gnXShfMHg0ZDI1OTdbXzB4NDFlNzhlKDB4MjA5KV0oXzB4MmIzYTQ1LF8weDRkMzExMixfMHgzNjg4Y2EsXzB4NDllNGNmLF8weDQ3ZDM0MCxfMHg0Zjc4MDMpKTt9fWNhdGNoe31pZihfMHg0ZDMxMTJbXzB4NDFlNzhlKDB4MmFmKV09ITB4MCxfMHgxMDMzM2MmJihfMHg0ZDMxMTJbJ19wX25hbWUnXT0hMHgwKSwhXzB4ODc5NzIyKXt2YXIgXzB4OGRlZDc1PVtdW18weDQxZTc4ZSgweDIxNyldKHRoaXNbJ19nZXRPd25Qcm9wZXJ0eU5hbWVzJ10oXzB4MzY4OGNhKSlbXzB4NDFlNzhlKDB4MjE3KV0odGhpc1tfMHg0MWU3OGUoMHgyNzApXShfMHgzNjg4Y2EpKTtmb3IoXzB4YzVlNDY1PTB4MCxfMHg1NjdkMzA9XzB4OGRlZDc1W18weDQxZTc4ZSgweDIzYyldO18weGM1ZTQ2NTxfMHg1NjdkMzA7XzB4YzVlNDY1KyspaWYoXzB4NDdkMzQwPV8weDhkZWQ3NVtfMHhjNWU0NjVdLCEoXzB4YzNmMTdkJiZfMHg1MTYxNjhbXzB4NDFlNzhlKDB4MWZiKV0oXzB4NDdkMzQwWyd0b1N0cmluZyddKCkpKSYmIXRoaXNbJ19ibGFja2xpc3RlZFByb3BlcnR5J10oXzB4MzY4OGNhLF8weDQ3ZDM0MCxfMHg0Zjc4MDMpJiYhXzB4NGQzMTEyW18weDQxZTc4ZSgweDFmZikrXzB4NDdkMzQwW18weDQxZTc4ZSgweDIwMyldKCldKXtpZihfMHg0ZGM1MjgrKyxfMHg0Zjc4MDNbXzB4NDFlNzhlKDB4Mjc5KV0rKyxfMHg0ZGM1Mjg+XzB4NDQyYmRhKXtfMHg4Nzk3MjI9ITB4MDticmVhazt9aWYoIV8weDRmNzgwM1tfMHg0MWU3OGUoMHgyYTUpXSYmXzB4NGY3ODAzW18weDQxZTc4ZSgweDI0YyldJiZfMHg0Zjc4MDNbXzB4NDFlNzhlKDB4Mjc5KV0+XzB4NGY3ODAzW18weDQxZTc4ZSgweDIzZCldKXtfMHg4Nzk3MjI9ITB4MDticmVhazt9XzB4MjVlMzUwW18weDQxZTc4ZSgweDI5MildKF8weDRkMjU5N1tfMHg0MWU3OGUoMHgyMDkpXShfMHgyYjNhNDUsXzB4NGQzMTEyLF8weDM2ODhjYSxfMHg0OWU0Y2YsXzB4NDdkMzQwLF8weDRmNzgwMykpO319fX19aWYoXzB4MzdkMDlkWyd0eXBlJ109XzB4NDllNGNmLF8weDExMWU2Nz8oXzB4MzdkMDlkWyd2YWx1ZSddPV8weDM2ODhjYVtfMHg0MWU3OGUoMHgyNTgpXSgpLHRoaXNbJ19jYXBJZlN0cmluZyddKF8weDQ5ZTRjZixfMHgzN2QwOWQsXzB4NGY3ODAzLF8weDU4ODY1OCkpOl8weDQ5ZTRjZj09PV8weDQxZTc4ZSgweDIxYyk/XzB4MzdkMDlkW18weDQxZTc4ZSgweDIwMCldPXRoaXNbXzB4NDFlNzhlKDB4MjUxKV1bXzB4NDFlNzhlKDB4MjViKV0oXzB4MzY4OGNhKTpfMHg0OWU0Y2Y9PT1fMHg0MWU3OGUoMHgyNjUpP18weDM3ZDA5ZFsndmFsdWUnXT10aGlzWydfcmVnRXhwVG9TdHJpbmcnXVtfMHg0MWU3OGUoMHgyNWIpXShfMHgzNjg4Y2EpOl8weDQ5ZTRjZj09PV8weDQxZTc4ZSgweDJhNCkmJnRoaXNbXzB4NDFlNzhlKDB4MjIzKV0/XzB4MzdkMDlkWyd2YWx1ZSddPXRoaXNbJ19TeW1ib2wnXVtfMHg0MWU3OGUoMHgyNzYpXVtfMHg0MWU3OGUoMHgyMDMpXVtfMHg0MWU3OGUoMHgyNWIpXShfMHgzNjg4Y2EpOiFfMHg0Zjc4MDNbXzB4NDFlNzhlKDB4MWVlKV0mJiEoXzB4NDllNGNmPT09J251bGwnfHxfMHg0OWU0Y2Y9PT1fMHg0MWU3OGUoMHgyYWIpKSYmKGRlbGV0ZSBfMHgzN2QwOWRbXzB4NDFlNzhlKDB4MjAwKV0sXzB4MzdkMDlkW18weDQxZTc4ZSgweDFmMCldPSEweDApLF8weDg3OTcyMiYmKF8weDM3ZDA5ZFsnY2FwcGVkUHJvcHMnXT0hMHgwKSxfMHg4ZjlmZDY9XzB4NGY3ODAzW18weDQxZTc4ZSgweDI0YildW18weDQxZTc4ZSgweDI5YildLF8weDRmNzgwM1tfMHg0MWU3OGUoMHgyNGIpXVtfMHg0MWU3OGUoMHgyOWIpXT1fMHgzN2QwOWQsdGhpc1tfMHg0MWU3OGUoMHgyMDIpXShfMHgzN2QwOWQsXzB4NGY3ODAzKSxfMHgyNWUzNTBbXzB4NDFlNzhlKDB4MjNjKV0pe2ZvcihfMHhjNWU0NjU9MHgwLF8weDU2N2QzMD1fMHgyNWUzNTBbXzB4NDFlNzhlKDB4MjNjKV07XzB4YzVlNDY1PF8weDU2N2QzMDtfMHhjNWU0NjUrKylfMHgyNWUzNTBbXzB4YzVlNDY1XShfMHhjNWU0NjUpO31fMHgyYjNhNDVbXzB4NDFlNzhlKDB4MjNjKV0mJihfMHgzN2QwOWRbXzB4NDFlNzhlKDB4MjZhKV09XzB4MmIzYTQ1KTt9Y2F0Y2goXzB4MzRjYmFiKXtfMHgyYmJiYWEoXzB4MzRjYmFiLF8weDM3ZDA5ZCxfMHg0Zjc4MDMpO31yZXR1cm4gdGhpc1snX2FkZGl0aW9uYWxNZXRhZGF0YSddKF8weDM2ODhjYSxfMHgzN2QwOWQpLHRoaXNbXzB4NDFlNzhlKDB4MmE2KV0oXzB4MzdkMDlkLF8weDRmNzgwMyksXzB4NGY3ODAzWydub2RlJ11bJ2N1cnJlbnQnXT1fMHg4ZjlmZDYsXzB4NGY3ODAzW18weDQxZTc4ZSgweDIyYildLS0sXzB4NGY3ODAzW18weDQxZTc4ZSgweDI0YyldPV8weDIzNDNhOSxfMHg0Zjc4MDNbXzB4NDFlNzhlKDB4MjRjKV0mJl8weDRmNzgwM1tfMHg0MWU3OGUoMHgyNDApXVsncG9wJ10oKSxfMHgzN2QwOWQ7fVtfMHgxZDIzMzMoMHgyNzApXShfMHhkZWRlMGEpe3ZhciBfMHgyYTUzYjk9XzB4MWQyMzMzO3JldHVybiBPYmplY3RbXzB4MmE1M2I5KDB4MWYyKV0/T2JqZWN0W18weDJhNTNiOSgweDFmMildKF8weGRlZGUwYSk6W107fVtfMHgxZDIzMzMoMHgyNjgpXShfMHgyMDkzZDApe3ZhciBfMHhjNTZjYjQ9XzB4MWQyMzMzO3JldHVybiEhKF8weDIwOTNkMCYmXzB4YTY3YWUzWydTZXQnXSYmdGhpc1tfMHhjNTZjYjQoMHgyYmMpXShfMHgyMDkzZDApPT09J1tvYmplY3RcXFxceDIwU2V0XScmJl8weDIwOTNkMFsnZm9yRWFjaCddKTt9WydfYmxhY2tsaXN0ZWRQcm9wZXJ0eSddKF8weDM1NmViNixfMHgyMzRhYjMsXzB4OTM1ZDdiKXt2YXIgXzB4MzlmYzkxPV8weDFkMjMzMztyZXR1cm4gXzB4OTM1ZDdiW18weDM5ZmM5MSgweDIyZildP3R5cGVvZiBfMHgzNTZlYjZbXzB4MjM0YWIzXT09XzB4MzlmYzkxKDB4MjI1KTohMHgxO31bXzB4MWQyMzMzKDB4MjkzKV0oXzB4YTEwOTI0KXt2YXIgXzB4YzMwNGJhPV8weDFkMjMzMyxfMHg1OWZmMTI9Jyc7cmV0dXJuIF8weDU5ZmYxMj10eXBlb2YgXzB4YTEwOTI0LF8weDU5ZmYxMj09PV8weGMzMDRiYSgweDIzMSk/dGhpc1snX29iamVjdFRvU3RyaW5nJ10oXzB4YTEwOTI0KT09PV8weGMzMDRiYSgweDIxZCk/XzB4NTlmZjEyPV8weGMzMDRiYSgweDJjNik6dGhpc1tfMHhjMzA0YmEoMHgyYmMpXShfMHhhMTA5MjQpPT09J1tvYmplY3RcXFxceDIwRGF0ZV0nP18weDU5ZmYxMj1fMHhjMzA0YmEoMHgyMWMpOl8weGExMDkyND09PW51bGw/XzB4NTlmZjEyPV8weGMzMDRiYSgweDI4Nik6XzB4YTEwOTI0Wydjb25zdHJ1Y3RvciddJiYoXzB4NTlmZjEyPV8weGExMDkyNFtfMHhjMzA0YmEoMHgyMWYpXVtfMHhjMzA0YmEoMHgyYTkpXXx8XzB4NTlmZjEyKTpfMHg1OWZmMTI9PT1fMHhjMzA0YmEoMHgyYWIpJiZ0aGlzW18weGMzMDRiYSgweDJhMildJiZfMHhhMTA5MjQgaW5zdGFuY2VvZiB0aGlzW18weGMzMDRiYSgweDJhMildJiYoXzB4NTlmZjEyPV8weGMzMDRiYSgweDI1ZikpLF8weDU5ZmYxMjt9W18weDFkMjMzMygweDJiYyldKF8weDEzMGM2MCl7dmFyIF8weDNhODExZD1fMHgxZDIzMzM7cmV0dXJuIE9iamVjdFtfMHgzYTgxMWQoMHgyNzYpXVsndG9TdHJpbmcnXVtfMHgzYTgxMWQoMHgyNWIpXShfMHgxMzBjNjApO31bXzB4MWQyMzMzKDB4MjdlKV0oXzB4MzUxMDEyKXt2YXIgXzB4MzQ0NDRmPV8weDFkMjMzMztyZXR1cm4gXzB4MzUxMDEyPT09J2Jvb2xlYW4nfHxfMHgzNTEwMTI9PT1fMHgzNDQ0NGYoMHgyY2EpfHxfMHgzNTEwMTI9PT1fMHgzNDQ0NGYoMHgyNjQpO31bXzB4MWQyMzMzKDB4MjRhKV0oXzB4MTQwOGMwKXt2YXIgXzB4MmQ1MGFkPV8weDFkMjMzMztyZXR1cm4gXzB4MTQwOGMwPT09J0Jvb2xlYW4nfHxfMHgxNDA4YzA9PT1fMHgyZDUwYWQoMHgyYmEpfHxfMHgxNDA4YzA9PT0nTnVtYmVyJzt9W18weDFkMjMzMygweDJiZSldKF8weDMzYTkxMSxfMHgxNTJkYTMsXzB4NTAxYmU1LF8weDEwOTEyOCxfMHg1MGE5MTAsXzB4MWQ4MjI4KXt2YXIgXzB4NWVhMTBmPXRoaXM7cmV0dXJuIGZ1bmN0aW9uKF8weDFlYTY2Yil7dmFyIF8weDU5M2UzYj1fMHg0NjFlLF8weDRkMTgyZT1fMHg1MGE5MTBbXzB4NTkzZTNiKDB4MjRiKV1bXzB4NTkzZTNiKDB4MjliKV0sXzB4NWM0Njc4PV8weDUwYTkxMFtfMHg1OTNlM2IoMHgyNGIpXVtfMHg1OTNlM2IoMHgyNDkpXSxfMHgyMzUyMGQ9XzB4NTBhOTEwW18weDU5M2UzYigweDI0YildW18weDU5M2UzYigweDI3NCldO18weDUwYTkxMFsnbm9kZSddW18weDU5M2UzYigweDI3NCldPV8weDRkMTgyZSxfMHg1MGE5MTBbJ25vZGUnXVtfMHg1OTNlM2IoMHgyNDkpXT10eXBlb2YgXzB4MTA5MTI4PT1fMHg1OTNlM2IoMHgyNjQpP18weDEwOTEyODpfMHgxZWE2NmIsXzB4MzNhOTExWydwdXNoJ10oXzB4NWVhMTBmW18weDU5M2UzYigweDI1YSldKF8weDE1MmRhMyxfMHg1MDFiZTUsXzB4MTA5MTI4LF8weDUwYTkxMCxfMHgxZDgyMjgpKSxfMHg1MGE5MTBbXzB4NTkzZTNiKDB4MjRiKV1bXzB4NTkzZTNiKDB4Mjc0KV09XzB4MjM1MjBkLF8weDUwYTkxMFtfMHg1OTNlM2IoMHgyNGIpXVtfMHg1OTNlM2IoMHgyNDkpXT1fMHg1YzQ2Nzg7fTt9W18weDFkMjMzMygweDIwOSldKF8weDFhODVkZixfMHhmZDBmODgsXzB4MzZmYzRlLF8weDIyYzNiMixfMHgyN2YzZDMsXzB4NjFkNjJkLF8weDUwYWQ5OSl7dmFyIF8weDUwNTBhMT1fMHgxZDIzMzMsXzB4MjU4MjMwPXRoaXM7cmV0dXJuIF8weGZkMGY4OFtfMHg1MDUwYTEoMHgxZmYpK18weDI3ZjNkM1sndG9TdHJpbmcnXSgpXT0hMHgwLGZ1bmN0aW9uKF8weGFlMGMpe3ZhciBfMHg0ZGIxOD1fMHg1MDUwYTEsXzB4NDI2ZGFhPV8weDYxZDYyZFtfMHg0ZGIxOCgweDI0YildWydjdXJyZW50J10sXzB4MThmMzNlPV8weDYxZDYyZFtfMHg0ZGIxOCgweDI0YildWydpbmRleCddLF8weDFiNDA1MT1fMHg2MWQ2MmRbXzB4NGRiMTgoMHgyNGIpXVtfMHg0ZGIxOCgweDI3NCldO18weDYxZDYyZFtfMHg0ZGIxOCgweDI0YildW18weDRkYjE4KDB4Mjc0KV09XzB4NDI2ZGFhLF8weDYxZDYyZFtfMHg0ZGIxOCgweDI0YildWydpbmRleCddPV8weGFlMGMsXzB4MWE4NWRmWydwdXNoJ10oXzB4MjU4MjMwW18weDRkYjE4KDB4MjVhKV0oXzB4MzZmYzRlLF8weDIyYzNiMixfMHgyN2YzZDMsXzB4NjFkNjJkLF8weDUwYWQ5OSkpLF8weDYxZDYyZFtfMHg0ZGIxOCgweDI0YildW18weDRkYjE4KDB4Mjc0KV09XzB4MWI0MDUxLF8weDYxZDYyZFtfMHg0ZGIxOCgweDI0YildW18weDRkYjE4KDB4MjQ5KV09XzB4MThmMzNlO307fVtfMHgxZDIzMzMoMHgyNWEpXShfMHgxZTZiMGIsXzB4NWYxNDY5LF8weDQ2MTA1MyxfMHg4ZWFmZjgsXzB4NDE3YTM1KXt2YXIgXzB4MTliMjkyPV8weDFkMjMzMyxfMHg1OWRiMmI9dGhpcztfMHg0MTdhMzV8fChfMHg0MTdhMzU9ZnVuY3Rpb24oXzB4Yjk2MTJiLF8weGFmMDNlNyl7cmV0dXJuIF8weGI5NjEyYltfMHhhZjAzZTddO30pO3ZhciBfMHg4MThkZjk9XzB4NDYxMDUzW18weDE5YjI5MigweDIwMyldKCksXzB4MjY5M2Y0PV8weDhlYWZmOFsnZXhwcmVzc2lvbnNUb0V2YWx1YXRlJ118fHt9LF8weDM0MmFiMD1fMHg4ZWFmZjhbXzB4MTliMjkyKDB4MWVlKV0sXzB4NTBlODc2PV8weDhlYWZmOFtfMHgxOWIyOTIoMHgyYTUpXTt0cnl7dmFyIF8weDVlODBhNz10aGlzW18weDE5YjI5MigweDJhMSldKF8weDFlNmIwYiksXzB4NDFkNDkxPV8weDgxOGRmOTtfMHg1ZTgwYTcmJl8weDQxZDQ5MVsweDBdPT09J1xcXFx4MjcnJiYoXzB4NDFkNDkxPV8weDQxZDQ5MVtfMHgxOWIyOTIoMHgyMTYpXSgweDEsXzB4NDFkNDkxW18weDE5YjI5MigweDIzYyldLTB4MikpO3ZhciBfMHgyNGM0ZGI9XzB4OGVhZmY4WydleHByZXNzaW9uc1RvRXZhbHVhdGUnXT1fMHgyNjkzZjRbXzB4MTliMjkyKDB4MWZmKStfMHg0MWQ0OTFdO18weDI0YzRkYiYmKF8weDhlYWZmOFsnZGVwdGgnXT1fMHg4ZWFmZjhbXzB4MTliMjkyKDB4MWVlKV0rMHgxKSxfMHg4ZWFmZjhbXzB4MTliMjkyKDB4MmE1KV09ISFfMHgyNGM0ZGI7dmFyIF8weDM3YTE4MD10eXBlb2YgXzB4NDYxMDUzPT0nc3ltYm9sJyxfMHgxZGE4NzY9eyduYW1lJzpfMHgzN2ExODB8fF8weDVlODBhNz9fMHg4MThkZjk6dGhpc1tfMHgxOWIyOTIoMHgyMjYpXShfMHg4MThkZjkpfTtpZihfMHgzN2ExODAmJihfMHgxZGE4NzZbXzB4MTliMjkyKDB4MmE0KV09ITB4MCksIShfMHg1ZjE0Njk9PT1fMHgxOWIyOTIoMHgyYzYpfHxfMHg1ZjE0Njk9PT1fMHgxOWIyOTIoMHgyOGYpKSl7dmFyIF8weDFlNzM5Nz10aGlzW18weDE5YjI5MigweDIyMCldKF8weDFlNmIwYixfMHg0NjEwNTMpO2lmKF8weDFlNzM5NyYmKF8weDFlNzM5N1tfMHgxOWIyOTIoMHgyOGEpXSYmKF8weDFkYTg3NltfMHgxOWIyOTIoMHgyYTcpXT0hMHgwKSxfMHgxZTczOTdbXzB4MTliMjkyKDB4MjQyKV0mJiFfMHgyNGM0ZGImJiFfMHg4ZWFmZjhbXzB4MTliMjkyKDB4MmNiKV0pKXJldHVybiBfMHgxZGE4NzZbXzB4MTliMjkyKDB4MmI2KV09ITB4MCx0aGlzW18weDE5YjI5MigweDFlZildKF8weDFkYTg3NixfMHg4ZWFmZjgpLF8weDFkYTg3Njt9dmFyIF8weDE2Zjg1ODt0cnl7XzB4MTZmODU4PV8weDQxN2EzNShfMHgxZTZiMGIsXzB4NDYxMDUzKTt9Y2F0Y2goXzB4MjRiZmJjKXtyZXR1cm4gXzB4MWRhODc2PXsnbmFtZSc6XzB4ODE4ZGY5LCd0eXBlJzpfMHgxOWIyOTIoMHgyMjgpLCdlcnJvcic6XzB4MjRiZmJjW18weDE5YjI5MigweDIxNCldfSx0aGlzWydfcHJvY2Vzc1RyZWVOb2RlUmVzdWx0J10oXzB4MWRhODc2LF8weDhlYWZmOCksXzB4MWRhODc2O312YXIgXzB4MzRmN2U3PXRoaXNbXzB4MTliMjkyKDB4MjkzKV0oXzB4MTZmODU4KSxfMHgyMzZkYmU9dGhpc1tfMHgxOWIyOTIoMHgyN2UpXShfMHgzNGY3ZTcpO2lmKF8weDFkYTg3NltfMHgxOWIyOTIoMHgyYzMpXT1fMHgzNGY3ZTcsXzB4MjM2ZGJlKXRoaXNbXzB4MTliMjkyKDB4MWVmKV0oXzB4MWRhODc2LF8weDhlYWZmOCxfMHgxNmY4NTgsZnVuY3Rpb24oKXt2YXIgXzB4M2E0NGFmPV8weDE5YjI5MjtfMHgxZGE4NzZbXzB4M2E0NGFmKDB4MjAwKV09XzB4MTZmODU4W18weDNhNDRhZigweDI1OCldKCksIV8weDI0YzRkYiYmXzB4NTlkYjJiWydfY2FwSWZTdHJpbmcnXShfMHgzNGY3ZTcsXzB4MWRhODc2LF8weDhlYWZmOCx7fSk7fSk7ZWxzZXt2YXIgXzB4OGU1MDczPV8weDhlYWZmOFsnYXV0b0V4cGFuZCddJiZfMHg4ZWFmZjhbXzB4MTliMjkyKDB4MjJiKV08XzB4OGVhZmY4W18weDE5YjI5MigweDIzZSldJiZfMHg4ZWFmZjhbXzB4MTliMjkyKDB4MjQwKV1bXzB4MTliMjkyKDB4MmI4KV0oXzB4MTZmODU4KTwweDAmJl8weDM0ZjdlNyE9PSdmdW5jdGlvbicmJl8weDhlYWZmOFsnYXV0b0V4cGFuZFByb3BlcnR5Q291bnQnXTxfMHg4ZWFmZjhbJ2F1dG9FeHBhbmRMaW1pdCddO18weDhlNTA3M3x8XzB4OGVhZmY4W18weDE5YjI5MigweDIyYildPF8weDM0MmFiMHx8XzB4MjRjNGRiPyh0aGlzW18weDE5YjI5MigweDI0NildKF8weDFkYTg3NixfMHgxNmY4NTgsXzB4OGVhZmY4LF8weDI0YzRkYnx8e30pLHRoaXNbXzB4MTliMjkyKDB4MWY3KV0oXzB4MTZmODU4LF8weDFkYTg3NikpOnRoaXNbJ19wcm9jZXNzVHJlZU5vZGVSZXN1bHQnXShfMHgxZGE4NzYsXzB4OGVhZmY4LF8weDE2Zjg1OCxmdW5jdGlvbigpe3ZhciBfMHg1MTNkODk9XzB4MTliMjkyO18weDM0ZjdlNz09PSdudWxsJ3x8XzB4MzRmN2U3PT09J3VuZGVmaW5lZCd8fChkZWxldGUgXzB4MWRhODc2W18weDUxM2Q4OSgweDIwMCldLF8weDFkYTg3NltfMHg1MTNkODkoMHgxZjApXT0hMHgwKTt9KTt9cmV0dXJuIF8weDFkYTg3Njt9ZmluYWxseXtfMHg4ZWFmZjhbJ2V4cHJlc3Npb25zVG9FdmFsdWF0ZSddPV8weDI2OTNmNCxfMHg4ZWFmZjhbXzB4MTliMjkyKDB4MWVlKV09XzB4MzQyYWIwLF8weDhlYWZmOFtfMHgxOWIyOTIoMHgyYTUpXT1fMHg1MGU4NzY7fX1bXzB4MWQyMzMzKDB4MmEzKV0oXzB4NDI5MDQ2LF8weDM2YzUwMixfMHg1MzIwNGYsXzB4M2YzYmFiKXt2YXIgXzB4M2JjMGQ3PV8weDFkMjMzMyxfMHgyMDJkOWI9XzB4M2YzYmFiW18weDNiYzBkNygweDJiMSldfHxfMHg1MzIwNGZbXzB4M2JjMGQ3KDB4MmIxKV07aWYoKF8weDQyOTA0Nj09PV8weDNiYzBkNygweDJjYSl8fF8weDQyOTA0Nj09PV8weDNiYzBkNygweDJiYSkpJiZfMHgzNmM1MDJbXzB4M2JjMGQ3KDB4MjAwKV0pe2xldCBfMHgyNTQyOWI9XzB4MzZjNTAyW18weDNiYzBkNygweDIwMCldW18weDNiYzBkNygweDIzYyldO18weDUzMjA0ZlsnYWxsU3RyTGVuZ3RoJ10rPV8weDI1NDI5YixfMHg1MzIwNGZbJ2FsbFN0ckxlbmd0aCddPl8weDUzMjA0ZlsndG90YWxTdHJMZW5ndGgnXT8oXzB4MzZjNTAyW18weDNiYzBkNygweDFmMCldPScnLGRlbGV0ZSBfMHgzNmM1MDJbXzB4M2JjMGQ3KDB4MjAwKV0pOl8weDI1NDI5Yj5fMHgyMDJkOWImJihfMHgzNmM1MDJbXzB4M2JjMGQ3KDB4MWYwKV09XzB4MzZjNTAyW18weDNiYzBkNygweDIwMCldW18weDNiYzBkNygweDIxNildKDB4MCxfMHgyMDJkOWIpLGRlbGV0ZSBfMHgzNmM1MDJbXzB4M2JjMGQ3KDB4MjAwKV0pO319WydfaXNNYXAnXShfMHgzYjY2NWUpe3ZhciBfMHgyNDhhMjk9XzB4MWQyMzMzO3JldHVybiEhKF8weDNiNjY1ZSYmXzB4YTY3YWUzW18weDI0OGEyOSgweDI2OSldJiZ0aGlzW18weDI0OGEyOSgweDJiYyldKF8weDNiNjY1ZSk9PT1fMHgyNDhhMjkoMHgyYzUpJiZfMHgzYjY2NWVbXzB4MjQ4YTI5KDB4MjljKV0pO31bXzB4MWQyMzMzKDB4MjI2KV0oXzB4MTEwN2E3KXt2YXIgXzB4NWVhY2UwPV8weDFkMjMzMztpZihfMHgxMTA3YTdbJ21hdGNoJ10oL15cXFxcZCskLykpcmV0dXJuIF8weDExMDdhNzt2YXIgXzB4MmIxYTk0O3RyeXtfMHgyYjFhOTQ9SlNPTltfMHg1ZWFjZTAoMHgyMzQpXSgnJytfMHgxMTA3YTcpO31jYXRjaHtfMHgyYjFhOTQ9J1xcXFx4MjInK3RoaXNbXzB4NWVhY2UwKDB4MmJjKV0oXzB4MTEwN2E3KSsnXFxcXHgyMic7fXJldHVybiBfMHgyYjFhOTRbJ21hdGNoJ10oL15cXFwiKFthLXpBLVpfXVthLXpBLVpfMC05XSopXFxcIiQvKT9fMHgyYjFhOTQ9XzB4MmIxYTk0WydzdWJzdHInXSgweDEsXzB4MmIxYTk0W18weDVlYWNlMCgweDIzYyldLTB4Mik6XzB4MmIxYTk0PV8weDJiMWE5NFtfMHg1ZWFjZTAoMHgyMjIpXSgvJy9nLCdcXFxceDVjXFxcXHgyNycpW18weDVlYWNlMCgweDIyMildKC9cXFxcXFxcXFxcXCIvZywnXFxcXHgyMicpWydyZXBsYWNlJ10oLyheXFxcInxcXFwiJCkvZywnXFxcXHgyNycpLF8weDJiMWE5NDt9WydfcHJvY2Vzc1RyZWVOb2RlUmVzdWx0J10oXzB4Zjc3MzcwLF8weDEwYjFkYyxfMHgzOTZhMDEsXzB4MjBlYTEwKXt2YXIgXzB4MTM5MmUzPV8weDFkMjMzMzt0aGlzW18weDEzOTJlMygweDIwMildKF8weGY3NzM3MCxfMHgxMGIxZGMpLF8weDIwZWExMCYmXzB4MjBlYTEwKCksdGhpc1tfMHgxMzkyZTMoMHgxZjcpXShfMHgzOTZhMDEsXzB4Zjc3MzcwKSx0aGlzW18weDEzOTJlMygweDJhNildKF8weGY3NzM3MCxfMHgxMGIxZGMpO31bXzB4MWQyMzMzKDB4MjAyKV0oXzB4NDkxMzMyLF8weDNlMjYwMyl7dmFyIF8weDIyY2EyYj1fMHgxZDIzMzM7dGhpc1tfMHgyMmNhMmIoMHgxZWQpXShfMHg0OTEzMzIsXzB4M2UyNjAzKSx0aGlzW18weDIyY2EyYigweDJiNyldKF8weDQ5MTMzMixfMHgzZTI2MDMpLHRoaXNbJ19zZXROb2RlRXhwcmVzc2lvblBhdGgnXShfMHg0OTEzMzIsXzB4M2UyNjAzKSx0aGlzWydfc2V0Tm9kZVBlcm1pc3Npb25zJ10oXzB4NDkxMzMyLF8weDNlMjYwMyk7fVtfMHgxZDIzMzMoMHgxZWQpXShfMHgzYzg3Y2IsXzB4OGUzZWRmKXt9Wydfc2V0Tm9kZVF1ZXJ5UGF0aCddKF8weDI1ZTYxOCxfMHg1ZWE1ODkpe31bJ19zZXROb2RlTGFiZWwnXShfMHg1NGMzNGQsXzB4MWYwZDVhKXt9W18weDFkMjMzMygweDIyNyldKF8weDM1ZWVjNil7dmFyIF8weDIxNjI5OT1fMHgxZDIzMzM7cmV0dXJuIF8weDM1ZWVjNj09PXRoaXNbXzB4MjE2Mjk5KDB4MWY5KV07fVtfMHgxZDIzMzMoMHgyYTYpXShfMHg1NGMzNWYsXzB4NDU4YTExKXt2YXIgXzB4NGMzMzQwPV8weDFkMjMzMzt0aGlzW18weDRjMzM0MCgweDI4MSldKF8weDU0YzM1ZixfMHg0NThhMTEpLHRoaXNbXzB4NGMzMzQwKDB4MjEyKV0oXzB4NTRjMzVmKSxfMHg0NThhMTFbXzB4NGMzMzQwKDB4MjY2KV0mJnRoaXNbXzB4NGMzMzQwKDB4MmJkKV0oXzB4NTRjMzVmKSx0aGlzWydfYWRkRnVuY3Rpb25zTm9kZSddKF8weDU0YzM1ZixfMHg0NThhMTEpLHRoaXNbXzB4NGMzMzQwKDB4MjhkKV0oXzB4NTRjMzVmLF8weDQ1OGExMSksdGhpc1tfMHg0YzMzNDAoMHgyN2MpXShfMHg1NGMzNWYpO31bXzB4MWQyMzMzKDB4MWY3KV0oXzB4YTU5YTkzLF8weGFkOTUzYyl7dmFyIF8weDI2MjJkMz1fMHgxZDIzMzM7dHJ5e18weGE1OWE5MyYmdHlwZW9mIF8weGE1OWE5M1tfMHgyNjIyZDMoMHgyM2MpXT09XzB4MjYyMmQzKDB4MjY0KSYmKF8weGFkOTUzY1tfMHgyNjIyZDMoMHgyM2MpXT1fMHhhNTlhOTNbXzB4MjYyMmQzKDB4MjNjKV0pO31jYXRjaHt9aWYoXzB4YWQ5NTNjW18weDI2MjJkMygweDJjMyldPT09XzB4MjYyMmQzKDB4MjY0KXx8XzB4YWQ5NTNjW18weDI2MjJkMygweDJjMyldPT09XzB4MjYyMmQzKDB4Mjc3KSl7aWYoaXNOYU4oXzB4YWQ5NTNjW18weDI2MjJkMygweDIwMCldKSlfMHhhZDk1M2NbJ25hbiddPSEweDAsZGVsZXRlIF8weGFkOTUzY1tfMHgyNjIyZDMoMHgyMDApXTtlbHNlIHN3aXRjaChfMHhhZDk1M2NbXzB4MjYyMmQzKDB4MjAwKV0pe2Nhc2UgTnVtYmVyW18weDI2MjJkMygweDI2YyldOl8weGFkOTUzY1sncG9zaXRpdmVJbmZpbml0eSddPSEweDAsZGVsZXRlIF8weGFkOTUzY1sndmFsdWUnXTticmVhaztjYXNlIE51bWJlcltfMHgyNjIyZDMoMHgyODUpXTpfMHhhZDk1M2NbXzB4MjYyMmQzKDB4MjNiKV09ITB4MCxkZWxldGUgXzB4YWQ5NTNjWyd2YWx1ZSddO2JyZWFrO2Nhc2UgMHgwOnRoaXNbJ19pc05lZ2F0aXZlWmVybyddKF8weGFkOTUzY1sndmFsdWUnXSkmJihfMHhhZDk1M2NbXzB4MjYyMmQzKDB4MjAxKV09ITB4MCk7YnJlYWs7fX1lbHNlIF8weGFkOTUzY1sndHlwZSddPT09XzB4MjYyMmQzKDB4MjI1KSYmdHlwZW9mIF8weGE1OWE5M1snbmFtZSddPT1fMHgyNjIyZDMoMHgyY2EpJiZfMHhhNTlhOTNbXzB4MjYyMmQzKDB4MmE5KV0mJl8weGFkOTUzY1tfMHgyNjIyZDMoMHgyYTkpXSYmXzB4YTU5YTkzW18weDI2MjJkMygweDJhOSldIT09XzB4YWQ5NTNjW18weDI2MjJkMygweDJhOSldJiYoXzB4YWQ5NTNjW18weDI2MjJkMygweDFmZCldPV8weGE1OWE5M1tfMHgyNjIyZDMoMHgyYTkpXSk7fVtfMHgxZDIzMzMoMHgyNjMpXShfMHgxODIwZGMpe3ZhciBfMHgyYzJkZjg9XzB4MWQyMzMzO3JldHVybiAweDEvXzB4MTgyMGRjPT09TnVtYmVyW18weDJjMmRmOCgweDI4NSldO31bXzB4MWQyMzMzKDB4MmJkKV0oXzB4MzZkNDM5KXt2YXIgXzB4NTMwMzI3PV8weDFkMjMzMzshXzB4MzZkNDM5W18weDUzMDMyNygweDI2YSldfHwhXzB4MzZkNDM5W18weDUzMDMyNygweDI2YSldWydsZW5ndGgnXXx8XzB4MzZkNDM5W18weDUzMDMyNygweDJjMyldPT09XzB4NTMwMzI3KDB4MmM2KXx8XzB4MzZkNDM5W18weDUzMDMyNygweDJjMyldPT09XzB4NTMwMzI3KDB4MjY5KXx8XzB4MzZkNDM5W18weDUzMDMyNygweDJjMyldPT09XzB4NTMwMzI3KDB4MmM3KXx8XzB4MzZkNDM5W18weDUzMDMyNygweDI2YSldWydzb3J0J10oZnVuY3Rpb24oXzB4NDBlZDUzLF8weDM4ZTM2ZSl7dmFyIF8weDIyNzJhYT1fMHg1MzAzMjcsXzB4Mjg2NWU1PV8weDQwZWQ1M1tfMHgyMjcyYWEoMHgyYTkpXVtfMHgyMjcyYWEoMHgyODcpXSgpLF8weDI3YTRhZj1fMHgzOGUzNmVbXzB4MjI3MmFhKDB4MmE5KV1bXzB4MjI3MmFhKDB4Mjg3KV0oKTtyZXR1cm4gXzB4Mjg2NWU1PF8weDI3YTRhZj8tMHgxOl8weDI4NjVlNT5fMHgyN2E0YWY/MHgxOjB4MDt9KTt9W18weDFkMjMzMygweDI5ZCldKF8weGYxZTdmNixfMHgzNDQ5ZTApe3ZhciBfMHg0ZjU0YTU9XzB4MWQyMzMzO2lmKCEoXzB4MzQ0OWUwW18weDRmNTRhNSgweDIyZildfHwhXzB4ZjFlN2Y2W18weDRmNTRhNSgweDI2YSldfHwhXzB4ZjFlN2Y2W18weDRmNTRhNSgweDI2YSldW18weDRmNTRhNSgweDIzYyldKSl7Zm9yKHZhciBfMHgyMzE3YzE9W10sXzB4YWI0ODFiPVtdLF8weDNhYzdiMj0weDAsXzB4MjVlZjM2PV8weGYxZTdmNlsncHJvcHMnXVtfMHg0ZjU0YTUoMHgyM2MpXTtfMHgzYWM3YjI8XzB4MjVlZjM2O18weDNhYzdiMisrKXt2YXIgXzB4OTNkODc0PV8weGYxZTdmNlsncHJvcHMnXVtfMHgzYWM3YjJdO18weDkzZDg3NFtfMHg0ZjU0YTUoMHgyYzMpXT09PV8weDRmNTRhNSgweDIyNSk/XzB4MjMxN2MxWydwdXNoJ10oXzB4OTNkODc0KTpfMHhhYjQ4MWJbXzB4NGY1NGE1KDB4MjkyKV0oXzB4OTNkODc0KTt9aWYoISghXzB4YWI0ODFiW18weDRmNTRhNSgweDIzYyldfHxfMHgyMzE3YzFbXzB4NGY1NGE1KDB4MjNjKV08PTB4MSkpe18weGYxZTdmNltfMHg0ZjU0YTUoMHgyNmEpXT1fMHhhYjQ4MWI7dmFyIF8weDMxM2FmYT17J2Z1bmN0aW9uc05vZGUnOiEweDAsJ3Byb3BzJzpfMHgyMzE3YzF9O3RoaXNbXzB4NGY1NGE1KDB4MWVkKV0oXzB4MzEzYWZhLF8weDM0NDllMCksdGhpc1tfMHg0ZjU0YTUoMHgyODEpXShfMHgzMTNhZmEsXzB4MzQ0OWUwKSx0aGlzWydfc2V0Tm9kZUV4cGFuZGFibGVTdGF0ZSddKF8weDMxM2FmYSksdGhpc1tfMHg0ZjU0YTUoMHgyMzYpXShfMHgzMTNhZmEsXzB4MzQ0OWUwKSxfMHgzMTNhZmFbJ2lkJ10rPSdcXFxceDIwZicsXzB4ZjFlN2Y2W18weDRmNTRhNSgweDI2YSldWyd1bnNoaWZ0J10oXzB4MzEzYWZhKTt9fX1bJ19hZGRMb2FkTm9kZSddKF8weDMyNTkzNixfMHg1OGYxOGIpe31bXzB4MWQyMzMzKDB4MjEyKV0oXzB4MTk4NTIwKXt9WydfaXNBcnJheSddKF8weDJhMTk4Myl7dmFyIF8weDI1MDdkNj1fMHgxZDIzMzM7cmV0dXJuIEFycmF5Wydpc0FycmF5J10oXzB4MmExOTgzKXx8dHlwZW9mIF8weDJhMTk4Mz09XzB4MjUwN2Q2KDB4MjMxKSYmdGhpc1tfMHgyNTA3ZDYoMHgyYmMpXShfMHgyYTE5ODMpPT09J1tvYmplY3RcXFxceDIwQXJyYXldJzt9W18weDFkMjMzMygweDIzNildKF8weDMzNWI5OSxfMHg1NzMwNjQpe31bXzB4MWQyMzMzKDB4MjdjKV0oXzB4NDE5MTkyKXt2YXIgXzB4NTc5MTJjPV8weDFkMjMzMztkZWxldGUgXzB4NDE5MTkyW18weDU3OTEyYygweDI4NCldLGRlbGV0ZSBfMHg0MTkxOTJbJ19oYXNTZXRPbkl0c1BhdGgnXSxkZWxldGUgXzB4NDE5MTkyW18weDU3OTEyYygweDI4YildO31bXzB4MWQyMzMzKDB4MjZkKV0oXzB4NDI2NDFmLF8weDM3NTJkOCl7fVtfMHgxZDIzMzMoMHgyOGMpXShfMHg0NmFhNTEpe3ZhciBfMHg1YzBmZTU9XzB4MWQyMzMzO3JldHVybiBfMHg0NmFhNTE/XzB4NDZhYTUxWydtYXRjaCddKHRoaXNbJ19udW1iZXJSZWdFeHAnXSk/J1snK18weDQ2YWE1MSsnXSc6XzB4NDZhYTUxWydtYXRjaCddKHRoaXNbJ19rZXlTdHJSZWdFeHAnXSk/Jy4nK18weDQ2YWE1MTpfMHg0NmFhNTFbJ21hdGNoJ10odGhpc1tfMHg1YzBmZTUoMHgyMjQpXSk/J1snK18weDQ2YWE1MSsnXSc6J1tcXFxceDI3JytfMHg0NmFhNTErJ1xcXFx4MjddJzonJzt9fWxldCBfMHg0M2VlNzM9bmV3IF8weDE4OGRmZigpO2Z1bmN0aW9uIF8weDQ2MmI5MihfMHgzNDQyNmEsXzB4MmUyYmM5LF8weDIyZGFiMyxfMHg2OTgxYmUsXzB4MTkyNzQzLF8weDViMzM1Mil7dmFyIF8weDEyYWIzOT1fMHgxZDIzMzM7bGV0IF8weDI5MWE0ZixfMHgzYmU1ZGY7dHJ5e18weDNiZTVkZj1fMHgyM2JjN2EoKSxfMHgyOTFhNGY9XzB4NDhiNTIwW18weDJlMmJjOV0sIV8weDI5MWE0Znx8XzB4M2JlNWRmLV8weDI5MWE0ZlsndHMnXT4weDFmNCYmXzB4MjkxYTRmW18weDEyYWIzOSgweDI3YSldJiZfMHgyOTFhNGZbXzB4MTJhYjM5KDB4MWY2KV0vXzB4MjkxYTRmWydjb3VudCddPDB4NjQ/KF8weDQ4YjUyMFtfMHgyZTJiYzldPV8weDI5MWE0Zj17J2NvdW50JzoweDAsJ3RpbWUnOjB4MCwndHMnOl8weDNiZTVkZn0sXzB4NDhiNTIwW18weDEyYWIzOSgweDFmMSldPXt9KTpfMHgzYmU1ZGYtXzB4NDhiNTIwW18weDEyYWIzOSgweDFmMSldWyd0cyddPjB4MzImJl8weDQ4YjUyMFtfMHgxMmFiMzkoMHgxZjEpXVtfMHgxMmFiMzkoMHgyN2EpXSYmXzB4NDhiNTIwWydoaXRzJ11bXzB4MTJhYjM5KDB4MWY2KV0vXzB4NDhiNTIwW18weDEyYWIzOSgweDFmMSldW18weDEyYWIzOSgweDI3YSldPDB4NjQmJihfMHg0OGI1MjBbXzB4MTJhYjM5KDB4MWYxKV09e30pO2xldCBfMHg0NWExNWE9W10sXzB4NDE5YTZkPV8weDI5MWE0ZltfMHgxMmFiMzkoMHgyMzIpXXx8XzB4NDhiNTIwW18weDEyYWIzOSgweDFmMSldW18weDEyYWIzOSgweDIzMildP18weDQ0MmJhZTpfMHg4NGIyYjQsXzB4M2E1NmIzPV8weDE0MTAxYT0+e3ZhciBfMHgyMzIxYTI9XzB4MTJhYjM5O2xldCBfMHhiMDk0YzE9e307cmV0dXJuIF8weGIwOTRjMVtfMHgyMzIxYTIoMHgyNmEpXT1fMHgxNDEwMWFbXzB4MjMyMWEyKDB4MjZhKV0sXzB4YjA5NGMxWydlbGVtZW50cyddPV8weDE0MTAxYVtfMHgyMzIxYTIoMHgyMDcpXSxfMHhiMDk0YzFbXzB4MjMyMWEyKDB4MmIxKV09XzB4MTQxMDFhWydzdHJMZW5ndGgnXSxfMHhiMDk0YzFbJ3RvdGFsU3RyTGVuZ3RoJ109XzB4MTQxMDFhWyd0b3RhbFN0ckxlbmd0aCddLF8weGIwOTRjMVsnYXV0b0V4cGFuZExpbWl0J109XzB4MTQxMDFhWydhdXRvRXhwYW5kTGltaXQnXSxfMHhiMDk0YzFbJ2F1dG9FeHBhbmRNYXhEZXB0aCddPV8weDE0MTAxYVtfMHgyMzIxYTIoMHgyM2UpXSxfMHhiMDk0YzFbXzB4MjMyMWEyKDB4MjY2KV09ITB4MSxfMHhiMDk0YzFbJ25vRnVuY3Rpb25zJ109IV8weDZjOGExYyxfMHhiMDk0YzFbXzB4MjMyMWEyKDB4MWVlKV09MHgxLF8weGIwOTRjMVtfMHgyMzIxYTIoMHgyMmIpXT0weDAsXzB4YjA5NGMxW18weDIzMjFhMigweDI1NyldPV8weDIzMjFhMigweDI1NSksXzB4YjA5NGMxW18weDIzMjFhMigweDJjNCldPV8weDIzMjFhMigweDIxMSksXzB4YjA5NGMxWydhdXRvRXhwYW5kJ109ITB4MCxfMHhiMDk0YzFbJ2F1dG9FeHBhbmRQcmV2aW91c09iamVjdHMnXT1bXSxfMHhiMDk0YzFbXzB4MjMyMWEyKDB4Mjc5KV09MHgwLF8weGIwOTRjMVtfMHgyMzIxYTIoMHgyY2IpXT0hMHgwLF8weGIwOTRjMVtfMHgyMzIxYTIoMHgyNDQpXT0weDAsXzB4YjA5NGMxWydub2RlJ109eydjdXJyZW50Jzp2b2lkIDB4MCwncGFyZW50Jzp2b2lkIDB4MCwnaW5kZXgnOjB4MH0sXzB4YjA5NGMxO307Zm9yKHZhciBfMHgyYTk3OGI9MHgwO18weDJhOTc4YjxfMHgxOTI3NDNbXzB4MTJhYjM5KDB4MjNjKV07XzB4MmE5NzhiKyspXzB4NDVhMTVhWydwdXNoJ10oXzB4NDNlZTczW18weDEyYWIzOSgweDI0NildKHsndGltZU5vZGUnOl8weDM0NDI2YT09PV8weDEyYWIzOSgweDFmNil8fHZvaWQgMHgwfSxfMHgxOTI3NDNbXzB4MmE5NzhiXSxfMHgzYTU2YjMoXzB4NDE5YTZkKSx7fSkpO2lmKF8weDM0NDI2YT09PV8weDEyYWIzOSgweDIxYSkpe2xldCBfMHgyOTQyNDU9RXJyb3JbXzB4MTJhYjM5KDB4MjUwKV07dHJ5e0Vycm9yW18weDEyYWIzOSgweDI1MCldPTB4MS8weDAsXzB4NDVhMTVhWydwdXNoJ10oXzB4NDNlZTczW18weDEyYWIzOSgweDI0NildKHsnc3RhY2tOb2RlJzohMHgwfSxuZXcgRXJyb3IoKVtfMHgxMmFiMzkoMHgyN2IpXSxfMHgzYTU2YjMoXzB4NDE5YTZkKSx7J3N0ckxlbmd0aCc6MHgxLzB4MH0pKTt9ZmluYWxseXtFcnJvcltfMHgxMmFiMzkoMHgyNTApXT1fMHgyOTQyNDU7fX1yZXR1cm57J21ldGhvZCc6J2xvZycsJ3ZlcnNpb24nOl8weDM1YzI2NSwnYXJncyc6W3snaWQnOl8weDJlMmJjOSwndHMnOl8weDIyZGFiMywnYXJncyc6XzB4NDVhMTVhLCdjb250ZXh0JzpfMHg1YjMzNTIsJ3Nlc3Npb24nOl8weDY5ODFiZX1dfTt9Y2F0Y2goXzB4MTE2Zjc5KXtyZXR1cm57J21ldGhvZCc6XzB4MTJhYjM5KDB4MjZlKSwndmVyc2lvbic6XzB4MzVjMjY1LCdhcmdzJzpbeydpZCc6XzB4MmUyYmM5LCd0cyc6XzB4MjJkYWIzLCdhcmdzJzpbeyd0eXBlJzondW5rbm93bicsJ2Vycm9yJzpfMHgxMTZmNzkmJl8weDExNmY3OVtfMHgxMmFiMzkoMHgyMTQpXSwnY29udGV4dCc6XzB4NWIzMzUyLCdzZXNzaW9uJzpfMHg2OTgxYmV9XX1dfTt9ZmluYWxseXt0cnl7aWYoXzB4MjkxYTRmJiZfMHgzYmU1ZGYpe2xldCBfMHg0NmM5MjM9XzB4MjNiYzdhKCk7XzB4MjkxYTRmW18weDEyYWIzOSgweDI3YSldKyssXzB4MjkxYTRmWyd0aW1lJ10rPV8weDNjMzI3OChfMHgzYmU1ZGYsXzB4NDZjOTIzKSxfMHgyOTFhNGZbJ3RzJ109XzB4NDZjOTIzLF8weDQ4YjUyMFsnaGl0cyddWydjb3VudCddKyssXzB4NDhiNTIwWydoaXRzJ11bXzB4MTJhYjM5KDB4MWY2KV0rPV8weDNjMzI3OChfMHgzYmU1ZGYsXzB4NDZjOTIzKSxfMHg0OGI1MjBbXzB4MTJhYjM5KDB4MWYxKV1bJ3RzJ109XzB4NDZjOTIzLChfMHgyOTFhNGZbXzB4MTJhYjM5KDB4MjdhKV0+MHgzMnx8XzB4MjkxYTRmW18weDEyYWIzOSgweDFmNildPjB4NjQpJiYoXzB4MjkxYTRmW18weDEyYWIzOSgweDIzMildPSEweDApLChfMHg0OGI1MjBbXzB4MTJhYjM5KDB4MWYxKV1bXzB4MTJhYjM5KDB4MjdhKV0+MHgzZTh8fF8weDQ4YjUyMFtfMHgxMmFiMzkoMHgxZjEpXVtfMHgxMmFiMzkoMHgxZjYpXT4weDEyYykmJihfMHg0OGI1MjBbXzB4MTJhYjM5KDB4MWYxKV1bJ3JlZHVjZUxpbWl0cyddPSEweDApO319Y2F0Y2h7fX19cmV0dXJuIF8weGE2N2FlM1snX2NvbnNvbGVfbmluamEnXTt9KShnbG9iYWxUaGlzLCcxMjcuMC4wLjEnLCc1MTE5MCcsXzB4NTg0ZmRmKDB4MjE1KSwnd2VicGFjaycsXzB4NTg0ZmRmKDB4MjA1KSxfMHg1ODRmZGYoMHgyNGQpLF8weDU4NGZkZigweDJiYiksXzB4NTg0ZmRmKDB4MjllKSk7XCIpO31jYXRjaChlKXt9fTtmdW5jdGlvbiBvb19vbyhpLC4uLnYpe3RyeXtvb19jbSgpLmNvbnNvbGVMb2coaSwgdik7fWNhdGNoKGUpe30gcmV0dXJuIHZ9O2Z1bmN0aW9uIG9vX3RyKGksLi4udil7dHJ5e29vX2NtKCkuY29uc29sZVRyYWNlKGksIHYpO31jYXRjaChlKXt9IHJldHVybiB2fTtmdW5jdGlvbiBvb190cygpe3RyeXtvb19jbSgpLmNvbnNvbGVUaW1lKCk7fWNhdGNoKGUpe319O2Z1bmN0aW9uIG9vX3RlKCl7dHJ5e29vX2NtKCkuY29uc29sZVRpbWVFbmQoKTt9Y2F0Y2goZSl7fX07Lyplc2xpbnQgZXNsaW50LWNvbW1lbnRzL2Rpc2FibGUtZW5hYmxlLXBhaXI6LGVzbGludC1jb21tZW50cy9uby11bmxpbWl0ZWQtZGlzYWJsZTosZXNsaW50LWNvbW1lbnRzL25vLWFnZ3JlZ2F0aW5nLWVuYWJsZTosZXNsaW50LWNvbW1lbnRzL25vLWR1cGxpY2F0ZS1kaXNhYmxlOixlc2xpbnQtY29tbWVudHMvbm8tdW51c2VkLWRpc2FibGU6LGVzbGludC1jb21tZW50cy9uby11bnVzZWQtZW5hYmxlOiwqLzwvc2NyaXB0PlxuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIG1vZHVsZXMvUmVzdGF1cmFudC9SZXNvdXJjZXMvYXNzZXRzL2pzL3ZpZXdzL2xvZ2luL2xvZ2luLnZ1ZSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/login/login.vue\n");
>>>>>>> 833d0a352a8b2fc1cec4e6504514f35d264db8c5
=======
    Pad: __WEBPACK_IMPORTED_MODULE_0__pad_vue___default.a
  },
  data: function data() {
    return {
      user: "tesctiyo"
    };
  },
  created: function created() {
    console.log("creado");
  }
});
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
<<<<<<< HEAD
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__document_print_detail_vue__ = __webpack_require__("./modules/Internet/Resources/assets/js/view/pos/partials/document_print_detail.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__document_print_detail_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__document_print_detail_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_query_string__);
=======
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82


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
<<<<<<< HEAD


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    DocumentPrintDetail: __WEBPACK_IMPORTED_MODULE_1__document_print_detail_vue___default.a
  },
  props: ["showDialog", "company", "sender", "config", "establishment"],
  data: function data() {
    return {
      time: null,
      loading: false,
      value: null,
      typeSearch: "document",
      saleNotes: [],
      documents: [],
      pagination: {
        saleNotes: {},
        documents: {}
      },
      printer: null,
      lastDocument: null,
      activeName: "documents"
    };
  },
  methods: {
    getRecordsInput: function getRecordsInput() {
      this.getRecords();
    },
    printEvent: function printEvent(url) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var paperConfig, partsUrl, document, isTicket, tipoBandejaImpresora, config, data;
=======
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  data: function data() {
    return {
      maskPin: null,
      pinHide: "",
      person: null,
      persons: ["Administrador", "Mozo", "Cocinero"]
    };
  },
  methods: {
    getOption: function getOption(option) {
      if (option == "delete") {
        this.pinHide = "";
        this.maskPin = null;
        return;
      }

      if (this.pinHide && this.pinHide.length == 4) {
        return;
      }

      this.pinHide += option.toString();
      this.maskPin = "*".repeat(this.pinHide.length);
    },
    enter: function enter() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, _response$data, success, kitchen, pos;

>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
<<<<<<< HEAD
                paperConfig = {
                  scaleContent: false
                };
                partsUrl = url.split("/");
                document = partsUrl[partsUrl.length - 1];
                isTicket = document.toLowerCase().includes("ticket");
                tipoBandejaImpresora = _this.config.new_old_printer;

                if (!isTicket && tipoBandejaImpresora == 1) {
                  //opciones que permiten hacer una impresion correcta en impresoras nuevas
                  paperConfig.density = 600;
                  paperConfig.orientation = 'portrait';
                  paperConfig.margins = {
                    left: 2
                  };
                } else if (!isTicket && tipoBandejaImpresora == 0) {
                  paperConfig.density = 350;
                  paperConfig.orientation = 'portrait';
                }

                _context.prev = 6;
                config = qz.configs.create(_this.printer, paperConfig);

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
                  data: url
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this.$toast.error(e.message);
                });
                _context.next = 17;
                break;

              case 15:
                _context.prev = 15;
                _context.t0 = _context["catch"](6);

              case 17:
=======
                _context.next = 2;
                return _this.$http.post("login", {
                  pin: _this.pinHide
                });

              case 2:
                response = _context.sent;
                _response$data = response.data, success = _response$data.success, kitchen = _response$data.kitchen, pos = _response$data.pos;

                if (success) {
                  _this.$toast.success("Sesión exitosa. Bienvenido/a .");

                  if (kitchen) {
                    window.location.href = "worker/dashboard-kitchen";
                  } else if (pos) {
                    window.location.href = "worker/dashboard-pos";
                  } else {
                    window.location.href = "worker/dashboard";
                  }
                } else {
                  _this.$toast.error("El PIN no existe. Vuelva a intentarlo.");

                  _this.pinHide = "";
                  _this.maskPin = null;
                }

              case 5:
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
              case "end":
                return _context.stop();
            }
          }
<<<<<<< HEAD
        }, _callee, null, [[6, 15]]);
      }))();
    },
    printData: function printData(external_id, type) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var typePrint, url;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                typePrint = _this2.establishment.format_printer;
                url = ""; //colocar una condicion para cada caso desde impresira de 80mm hasta las a4 y a5

                if (typePrint == '1') {
                  //tamaño a4
                  if (type == "80") {
                    url = "/sale-notes/print/".concat(external_id, "/a4");
                  } else {
                    url = "/print/document/".concat(external_id, "/a4");
                  }
                }

                if (typePrint == '2') {
                  //tamaño a5
                  if (type == "80") {
                    url = "/sale-notes/print/".concat(external_id, "/a5");
                  } else {
                    url = "/print/document/".concat(external_id, "/a5");
                  }
                }

                if (typePrint == '3') {
                  //tamaño 80mm
                  if (type == "80") {
                    url = "/sale-notes/print/".concat(external_id, "/ticket");
                  } else {
                    url = "/print/document/".concat(external_id, "/ticket");
                  }
                }

                if (typePrint == '4') {
                  //tamaño 50mm
                  if (type == "80") {
                    url = "/sale-notes/print/".concat(external_id, "/ticket_50");
                  } else {
                    url = "/print/document/".concat(external_id, "/ticket_50");
                  }
                }

                _context2.next = 8;
                return _this2.printEvent(url);

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getLastDocument: function getLastDocument() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response, document, filename;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.prev = 0;
                _this3.loading = true;
                _context3.next = 4;
                return _this3.$http("print_last_document");

              case 4:
                response = _context3.sent;

                if (response.status == 200) {
                  document = response.data.document;
                  _this3.lastDocument = document;
                  filename = _this3.lastDocument.filename.split("-");
                  _this3.lastDocument.numberPrint = filename[2] + "-" + filename[3];
                }

                _context3.next = 11;
                break;

              case 8:
                _context3.prev = 8;
                _context3.t0 = _context3["catch"](0);

                _this3.$toast.error("No se pudo obtener el ultimo documento");

              case 11:
                _context3.prev = 11;
                _this3.loading = false;
                return _context3.finish(11);

              case 14:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[0, 8, 11, 14]]);
      }))();
    },
    getPrinter: function getPrinter() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response, printer;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.next = 2;
                return _this4.$http("cash/get_printer/".concat(_this4.area_id));

              case 2:
                response = _context4.sent;
                printer = response.data.printer;
                _this4.printer = printer;

              case 5:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getRecords: function getRecords() {
      var _this5 = this;

      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;

      if (this.activeName == "saleNotes") {
        this.pagination.saleNotes.current_page = Number(page);
      } else {
        this.pagination.documents.current_page = Number(page);
      }

      if (this.time) {
        clearTimeout(this.time);
      }

      this.time = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _context5.next = 2;
                return _this5.getLastDocuments();

              case 2:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      })), 500);
    },
    getQueryParameters: function getQueryParameters() {
      var form = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var page = this.activeName == "saleNotes" ? this.pagination.saleNotes.current_page : this.pagination.documents.current_page;
      return __WEBPACK_IMPORTED_MODULE_2_query_string___default.a.stringify({
        page: this.activeName == "saleNotes" ? this.pagination.saleNotes.current_page : this.pagination.documents.current_page,
        isNote: this.activeName == "saleNotes",
        column: this.typeSearch,
        value: this.value // limit: this.limit

      });
    },
    handleClick: function handleClick() {
      if (this.saleNotes.length == 0 || this.documents.length == 0) {
        this.getLastDocuments();
      }
    },
    open: function open() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _context6.next = 2;
                return _this6.getLastDocument();

              case 2:
                _context6.next = 4;
                return _this6.getLastDocuments();

              case 4:
                _context6.next = 6;
                return _this6.getPrinter();

              case 6:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    getLastDocuments: function getLastDocuments() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee7() {
        var response, _response$data, data, meta;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _context7.prev = 0;
                _this7.loading = true;
                _context7.next = 4;
                return _this7.$http("cash/get_last_documents?".concat(_this7.getQueryParameters()));

              case 4:
                response = _context7.sent;

                if (response.status != 200) {
                  _this7.$toast.error("No se pudo imprimir");
                } else {
                  _response$data = response.data, data = _response$data.data, meta = _response$data.meta;

                  if (_this7.activeName == "saleNotes") {
                    _this7.saleNotes = data;
                    _this7.pagination.saleNotes = meta;
                  } else {
                    _this7.documents = data;
                    _this7.pagination.documents = meta;
                  }
                }

                _context7.next = 12;
                break;

              case 8:
                _context7.prev = 8;
                _context7.t0 = _context7["catch"](0);
                console.log(_context7.t0);

                _this7.$toast.error("No se pudo imprimir");

              case 12:
                _context7.prev = 12;
                _this7.loading = false;
                return _context7.finish(12);

              case 15:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7, null, [[0, 8, 12, 15]]);
=======
        }, _callee);
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/whatsapp_modal.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

<<<<<<< HEAD
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "documentId", "documentTypeId", "company", "documentNumber", "sender"],
  data: function data() {
    return {
      number: null,
      withXml: false,
      loading: false
    };
  },
  methods: {
    close: function close() {
      this.$emit("update:showDialog", false);
      this.number = null;
      this.withXml = false;
    },
    existNumber: function existNumber() {
      var number = this.number;

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
    sendFiles: function sendFiles() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var formWhatsapp, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (_this.number) {
                  _context.next = 3;
                  break;
                }

                _this.$toast.warning("Ingrese un número");

                return _context.abrupt("return");

              case 3:
                if (_this.existNumber()) {
                  _context.next = 6;
                  break;
                }

                _this.$toast.error("Número para envío whatsapp inválido");

                return _context.abrupt("return");

              case 6:
                formWhatsapp = {
                  document_id: _this.documentId,
                  document_type_id: _this.documentTypeId,
                  customer_telephone: _this.number,
                  sender: _this.sender,
                  mensaje: "Su comprobante de pago electrónico " + _this.documentNumber + " de *" + _this.company.name + "*, ha sido generado correctamente a través del facturador electrónico de *Sdrimsac Solutions*"
                };
                _context.prev = 7;
                _this.loading = true;
                _context.next = 11;
                return _this.$http.post("/whatsapp", formWhatsapp);

              case 11:
                response = _context.sent;

                if (!_this.withXml) {
                  _context.next = 17;
                  break;
                }

                formWhatsapp.xml = true;
                _context.next = 16;
                return _this.$http.post("/whatsapp", formWhatsapp);

              case 16:
                response = _context.sent;

              case 17:
                if (response.status == 200) {
                  _this.$toast.success("El mensaje se envió correctamente");
                } else {
                  _this.$toast.error("Ocurrió un error en el envio");
                }

                _context.next = 23;
                break;

              case 20:
                _context.prev = 20;
                _context.t0 = _context["catch"](7);

                _this.$toast.error("Ocurrió un error en el envio");

              case 23:
                _context.prev = 23;
                _this.loading = false;

                _this.close();

                return _context.finish(23);

              case 27:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[7, 20, 23, 27]]);
      }))();
    }
  }
});
=======
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-md-12 text-center" }, [_c("pad")], 1)
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0814b47c", module.exports)
  }
}
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-c9ff31dc\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue":
/***/ (function(module, exports, __webpack_require__) {

<<<<<<< HEAD
exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.el-dialog__header {\n    background-color: var(--primary) !important;\n}\n.el-dialog__title {\n    color: var(--light-text) !important;\n}\n.el-dialog__headerbtn .el-dialog__close{\n    color:white !important;\n}\n", "", {"version":3,"sources":["D:/laragon/www/restobar/modules/Internet/Resources/assets/js/view/pos/partials/modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue"],"names":[],"mappings":";AAmDA;IACA,4CAAA;CACA;AACA;IACA,oCAAA;CACA;AACA;IACA,uBAAA;CACA","file":"documents_print.vue","sourcesContent":["<template>\r\n    <el-dialog :visible=\"showDialog\" append-to-body @close=\"close\" @open=\"open\" width=\"60%\" v-loading=\"loading\"  \r\n        title=\"Imprimir documento\">\r\n        <div class=\"card p-2\">\r\n            <div class=\"d-flex\">\r\n                <div class=\"col-6 p-1 col-md-3\">\r\n                    <el-select v-model=\"typeSearch\">\r\n                        <el-option value=\"document\" label=\"N° documento\">\r\n                        </el-option>\r\n                        <el-option value=\"client\" label=\"Cliente\"></el-option>\r\n                        <el-option value=\"date\" label=\"Fecha\"></el-option>\r\n                    </el-select>\r\n                </div>\r\n                <div class=\"col-6 p-1 col-md-3\">\r\n                    <el-input @input=\"getRecordsInput\" v-if=\"typeSearch != 'date'\" v-model=\"value\"></el-input>\r\n                    <el-date-picker value-format=\"yyyy-MM-dd\" @change=\"getRecordsInput\" v-else\r\n                        v-model=\"value\"></el-date-picker>\r\n                </div>\r\n            </div>\r\n            <div class=\"d-flex align-items-center justify-content-end\">\r\n                <span class=\"p-1\">Ultimo documento emitido:\r\n                    {{    lastDocument    ? lastDocument.numberPrint                    : \"No se encontró\"                    }}</span>\r\n                <el-button class=\"btn btn-primary\" @click=\"\r\n                    printData(\r\n                        lastDocument.external_id,\r\n                        lastDocument.document_type_id\r\n                    )\r\n                \">\r\n                    <i class=\"fas fa-print\"></i>\r\n                </el-button>\r\n            </div>\r\n            <div>\r\n                <el-tabs v-model=\"activeName\" @tab-click=\"handleClick\">\r\n                    <el-tab-pane label=\"Notas de venta\" name=\"saleNotes\">\r\n                        <document-print-detail :company=\"company\" @getRecords=\"getRecords\" @printData=\"printData\"\r\n                            :records.sync=\"saleNotes\" :pagination.sync=\"pagination.saleNotes\" :type=\"'saleNotes'\"\r\n                            :sender=\"sender\">\r\n                        </document-print-detail>\r\n                    </el-tab-pane>\r\n                    <el-tab-pane v-if=\"company.soap_type_id != '03'\" label=\"Facturas - Boletas\" name=\"documents\">\r\n                        <document-print-detail :sender=\"sender\" :company=\"company\" @getRecords=\"getRecords\"\r\n                            @printData=\"printData\" :records.sync=\"documents\" :pagination.sync=\"pagination.documents\"\r\n                            :type=\"'documents'\">\r\n                        </document-print-detail>\r\n                    </el-tab-pane>\r\n                </el-tabs>\r\n            </div>\r\n        </div>\r\n    </el-dialog>\r\n</template>\r\n<style>\r\n    .el-dialog__header {\r\n        background-color: var(--primary) !important; \r\n    }\r\n    .el-dialog__title {\r\n        color: var(--light-text) !important;\r\n    }\r\n    .el-dialog__headerbtn .el-dialog__close{\r\n        color:white !important;\r\n    }\r\n</style>\r\n<script>\r\nimport DocumentPrintDetail from \"./document_print_detail.vue\";\r\nimport queryString from \"query-string\";\r\nexport default {\r\n    components: { DocumentPrintDetail },\r\n    props: [\"showDialog\", \"company\", \"sender\",\"config\", \"establishment\"],\r\n    data() {\r\n        return {\r\n            time: null,\r\n            loading: false,\r\n            value: null,\r\n            typeSearch: \"document\",\r\n            saleNotes: [],\r\n            documents: [],\r\n            pagination: {\r\n                saleNotes: {},\r\n                documents: {}\r\n            },\r\n            printer: null,\r\n            lastDocument: null,\r\n            activeName: \"documents\"\r\n        };\r\n    },\r\n    methods: {\r\n        getRecordsInput() {\r\n            this.getRecords();\r\n        },\r\n        async printEvent(url) {\r\n            \r\n            let paperConfig = {\r\n                scaleContent: false     \r\n            };\r\n            let partsUrl = url.split(\"/\");\r\n            let document = partsUrl[partsUrl.length - 1];\r\n            let isTicket = document.toLowerCase().includes(\"ticket\")\r\n           \r\n            let tipoBandejaImpresora = this.config.new_old_printer;\r\n\r\n            if (!isTicket && tipoBandejaImpresora == 1) {//opciones que permiten hacer una impresion correcta en impresoras nuevas\r\n                paperConfig.density = 600 ;\r\n                paperConfig.orientation= 'portrait';\r\n                paperConfig.margins = {left: 2}\r\n                }else if(!isTicket && tipoBandejaImpresora == 0){\r\n                paperConfig.density = 350 ;\r\n                paperConfig.orientation= 'portrait';\r\n                \r\n            }\r\n\r\n            try {\r\n                let config = qz.configs.create(this.printer, paperConfig);\r\n                if (!qz.websocket.isActive()) {\r\n                    await qz.websocket.connect(config);\r\n                }\r\n                let data = [\r\n                    {\r\n                        type: \"pdf\",\r\n                        format: \"file\",\r\n                        data: url\r\n                    }\r\n                ];\r\n                qz.print(config, data).catch(e => {\r\n                    this.$toast.error(e.message);\r\n                });\r\n            } catch (e) { }\r\n        },\r\n        async printData(external_id, type) {\r\n            let typePrint = this.establishment.format_printer\r\n            let url = \"\";\r\n            //colocar una condicion para cada caso desde impresira de 80mm hasta las a4 y a5\r\n            if(typePrint == '1'){//tamaño a4\r\n                if (type == \"80\") {\r\n                    url = `/sale-notes/print/${external_id}/a4`;\r\n                } else {\r\n                    url = `/print/document/${external_id}/a4`;\r\n                }\r\n            }\r\n            if(typePrint == '2'){//tamaño a5\r\n                if (type == \"80\") {\r\n                    url = `/sale-notes/print/${external_id}/a5`;\r\n                } else {\r\n                    url = `/print/document/${external_id}/a5`;\r\n                }\r\n            }   \r\n            if(typePrint == '3'){//tamaño 80mm\r\n                if (type == \"80\") {\r\n                    url = `/sale-notes/print/${external_id}/ticket`;\r\n                } else {\r\n                    url = `/print/document/${external_id}/ticket`;\r\n                }\r\n            }\r\n            if(typePrint == '4'){//tamaño 50mm\r\n                if (type == \"80\") {\r\n                    url = `/sale-notes/print/${external_id}/ticket_50`;\r\n                } else {\r\n                    url = `/print/document/${external_id}/ticket_50`;\r\n                }\r\n            }\r\n\r\n            await this.printEvent(url);\r\n        },\r\n        async getLastDocument() {\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http(`print_last_document`);\r\n\r\n                if (response.status == 200) {\r\n                    const {\r\n                        data: { document }\r\n                    } = response;\r\n                    this.lastDocument = document;\r\n                    let filename = this.lastDocument.filename.split(\"-\");\r\n                    this.lastDocument.numberPrint =\r\n                        filename[2] + \"-\" + filename[3];\r\n                }\r\n            } catch (e) {\r\n                this.$toast.error(\"No se pudo obtener el ultimo documento\");\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        async getPrinter() {\r\n            const response = await this.$http(\r\n                `cash/get_printer/${this.area_id}`\r\n            );\r\n\r\n            let {\r\n                data: { printer }\r\n            } = response;\r\n            this.printer = printer;\r\n        },\r\n        getRecords(page = 1) {\r\n            if (this.activeName == \"saleNotes\") {\r\n                this.pagination.saleNotes.current_page = Number(page);\r\n            } else {\r\n                this.pagination.documents.current_page = Number(page);\r\n            }\r\n            if (this.time) {\r\n                clearTimeout(this.time);\r\n            }\r\n            this.time = setTimeout(async () => {\r\n                await this.getLastDocuments();\r\n            }, 500);\r\n        },\r\n        getQueryParameters(form = {}) {\r\n            let page =\r\n                this.activeName == \"saleNotes\"\r\n                    ? this.pagination.saleNotes.current_page\r\n                    : this.pagination.documents.current_page;\r\n            return queryString.stringify({\r\n                page:\r\n                    this.activeName == \"saleNotes\"\r\n                        ? this.pagination.saleNotes.current_page\r\n                        : this.pagination.documents.current_page,\r\n                isNote: this.activeName == \"saleNotes\",\r\n                column: this.typeSearch,\r\n                value: this.value\r\n\r\n                // limit: this.limit\r\n            });\r\n        },\r\n        handleClick() {\r\n            if (this.saleNotes.length == 0 || this.documents.length == 0) {\r\n                this.getLastDocuments();\r\n            }\r\n        },\r\n        async open() {\r\n            await this.getLastDocument();\r\n            await this.getLastDocuments();\r\n            await this.getPrinter();\r\n        },\r\n        close() {\r\n            this.$emit(\"update:showDialog\", false);\r\n        },\r\n\r\n        async getLastDocuments() {\r\n            //\"/sale-notes/print/{$doc->external_id}/ticket\r\n            //\"/print/document/{$doc->external_id}/ticket\";\r\n\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http(\r\n                    `cash/get_last_documents?${this.getQueryParameters()}`\r\n                );\r\n\r\n                if (response.status != 200) {\r\n                    this.$toast.error(\"No se pudo imprimir\");\r\n                } else {\r\n                    const { data, meta } = response.data;\r\n                    if (this.activeName == \"saleNotes\") {\r\n                        this.saleNotes = data;\r\n                        this.pagination.saleNotes = meta;\r\n                    } else {\r\n                        this.documents = data;\r\n                        this.pagination.documents = meta;\r\n                    }\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n                this.$toast.error(\"No se pudo imprimir\");\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-08ff58c4\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/whatsapp_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

=======
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
<<<<<<< HEAD
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
        "append-to-body": "",
        title: "Enviar documento por whatsapp",
        width: "40%",
        visible: _vm.showDialog
      }
    },
    [
      _c("div", { staticClass: "card " }, [
        _c("div", { staticClass: "row d-flex align-items-center" }, [
          _c(
            "div",
            { staticClass: "col-8" },
            [
              _c("el-input", {
                attrs: { placeholder: "tlf: 999999999" },
                model: {
                  value: _vm.number,
                  callback: function($$v) {
                    _vm.number = $$v
                  },
                  expression: "number"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-4" },
            [
              _c(
                "el-checkbox",
                {
                  attrs: { disabled: _vm.documentTypeId == "80" },
                  model: {
                    value: _vm.withXml,
                    callback: function($$v) {
                      _vm.withXml = $$v
                    },
                    expression: "withXml"
                  }
                },
                [_vm._v("\n                    Adjuntar XML\n                ")]
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "d-flex justify-content-end p-2" },
          [
            _c(
              "el-button",
              { attrs: { type: "primary" }, on: { click: _vm.sendFiles } },
              [_vm._v("Enviar")]
            ),
            _vm._v(" "),
            _c("el-button", { on: { click: _vm.close } }, [
              _vm._v("\n                Cerrar\n            ")
            ])
          ],
          1
        )
      ])
    ]
  )
=======
  return _c("div", { staticClass: "mt-5" }, [
    _c("div", { staticClass: "row d-flex justify-content-center mb-3" }, [
      _c("div", { staticClass: "col-md-4" }, [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.maskPin,
              expression: "maskPin"
            }
          ],
          staticClass: "form-control",
          staticStyle: { "text-align": "center", "letter-spacing": "1rem" },
          attrs: { type: "text", size: "2", name: "listeanzahl", value: "10" },
          domProps: { value: _vm.maskPin },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.maskPin = $event.target.value
            }
          }
        })
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "container d-flex justify-content-center" }, [
      _c("div", { staticClass: "row justify-content-center" }, [
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(1)
                }
              }
            },
            [_vm._v("\n          1\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(2)
                }
              }
            },
            [_vm._v("\n          2\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(3)
                }
              }
            },
            [_vm._v("\n          3\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "w-100" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(4)
                }
              }
            },
            [_vm._v("\n          4\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(5)
                }
              }
            },
            [_vm._v("\n          5\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(6)
                }
              }
            },
            [_vm._v("\n          6\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "w-100" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(7)
                }
              }
            },
            [_vm._v("\n          7\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(8)
                }
              }
            },
            [_vm._v("\n          8\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(9)
                }
              }
            },
            [_vm._v("\n          9\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "w-100" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption(0)
                }
              }
            },
            [_vm._v("\n          0\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-danger btn-block",
              on: {
                click: function($event) {
                  return _vm.getOption("delete")
                }
              }
            },
            [_vm._v("\n          Eliminar\n        ")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 col-sm-4 col-md-4 p-1" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-success btn-block",
              on: { click: _vm.enter }
            },
            [_vm._v("\n          Ingresar\n        ")]
          )
        ])
      ])
    ])
  ])
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
<<<<<<< HEAD
    require("vue-hot-reload-api")      .rerender("data-v-08ff58c4", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1bfeb81a\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/document_print_detail.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ]
    },
    [
      _c("div", { staticClass: "container table-responsive col-md-12" }, [
        _c(
          "table",
          {
            staticClass:
              "table table-hover table-striped table-condensed  table-responsive",
            staticStyle: { width: "100%", "white-space": "nowrap" }
          },
          [
            _c("thead", [
              _c("tr", [
                _vm.type == "documents"
                  ? _c("th", [_vm._v("SUNAT")])
                  : _vm._e(),
                _vm._v(" "),
                _c("th", [
                  _vm._v(
                    "\n                        Acciones\n                    "
                  )
                ]),
                _vm._v(" "),
                _c("th", [
                  _vm._v(
                    "\n                        Número\n                    "
                  )
                ]),
                _vm._v(" "),
                _c("th", [_vm._v("Fecha")]),
                _vm._v(" "),
                _c("th", [
                  _vm._v(
                    "\n                        Cliente\n                    "
                  )
                ]),
                _vm._v(" "),
                _vm.type == "documents"
                  ? _c("th", [
                      _vm._v(
                        "\n                        Estado\n                    "
                      )
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c("th", [
                  _vm._v(
                    "\n                        Monto\n                    "
                  )
                ])
              ])
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.records, function(data, idx) {
                return _c("tr", { key: idx }, [
                  _vm.type == "documents"
                    ? _c("td", [
                        _c(
                          "div",
                          {
                            staticClass: "dropdown-as-select d-inline-block",
                            attrs: { "data-childselector": "span" }
                          },
                          [
                            data.state_type_id != "11"
                              ? _c(
                                  "button",
                                  {
                                    staticClass: "btn p-0",
                                    attrs: {
                                      type: "button",
                                      "data-bs-toggle": "dropdown",
                                      "aria-haspopup": "true",
                                      "aria-expanded": "false"
                                    }
                                  },
                                  [_vm._m(0, true)]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass:
                                  "dropdown-menu dropdown-menu-end col-md-2 col-1"
                              },
                              [
                                _vm.type == "documents" &&
                                data.state_type_id != "11" &&
                                data.document_type_id == "01"
                                  ? _c(
                                      "el-button",
                                      {
                                        staticClass: "col-md-12 col-12",
                                        on: {
                                          click: function($event) {
                                            return _vm.clickReStore(data.id)
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                                Recrear\n                                            "
                                        )
                                      ]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                _vm.type == "documents" &&
                                data.state_type_id != "11" &&
                                data.document_type_id == "01"
                                  ? _c("br")
                                  : _vm._e(),
                                _vm._v(" "),
                                _vm.type == "documents" &&
                                data.document_type_id == "01" &&
                                data.state_type_id != "11"
                                  ? _c(
                                      "el-button",
                                      {
                                        staticClass: "col-md-12 col-12",
                                        attrs: { plain: "" },
                                        on: {
                                          click: function($event) {
                                            return _vm.clickSendOnline(data.id)
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                                Reenviar\n                                            "
                                        )
                                      ]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                _vm.type == "documents" &&
                                data.document_type_id == "01"
                                  ? _c("br")
                                  : _vm._e(),
                                _vm._v(" "),
                                _vm.type == "documents" &&
                                data.state_type_id != "11"
                                  ? _c(
                                      "el-button",
                                      {
                                        staticClass: "col-md-12 col-12",
                                        on: {
                                          click: function($event) {
                                            return _vm.clickValidarCpe(data.id)
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                                Validar cpe\n                                            "
                                        )
                                      ]
                                    )
                                  : _vm._e()
                              ],
                              1
                            )
                          ]
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c(
                    "td",
                    [
                      _c(
                        "el-button",
                        {
                          staticStyle: { "margin-bottom": "3px" },
                          attrs: { size: "mini", type: "success" },
                          on: {
                            click: function($event) {
                              return _vm.clickOpenWhatsapp(data)
                            }
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "fab fa-whatsapp",
                            attrs: { "aria-hidden": "true" }
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "el-button",
                        {
                          attrs: { size: "mini", plain: "" },
                          on: {
                            click: function($event) {
                              return _vm.print(
                                data.external_id,
                                data.document_type_id
                              )
                            }
                          }
                        },
                        [_c("i", { staticClass: "fas fa-print" })]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _vm.type == "saleNotes"
                    ? _c("td", [_vm._v(_vm._s(data.full_number))])
                    : _c("td", [_vm._v(_vm._s(data.number))]),
                  _vm._v(" "),
                  _c("td", [_vm._v(_vm._s(data.date_of_issue))]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(data.customer_name) +
                        " "
                    ),
                    _c("br"),
                    _vm._v(" "),
                    _c("span", { staticClass: "text-muted" }, [
                      _vm._v(_vm._s(data.customer_number))
                    ])
                  ]),
                  _vm._v(" "),
                  _vm.type == "documents"
                    ? _c(
                        "td",
                        {
                          class:
                            "" +
                            (data.state_type_description == "Aceptado"
                              ? "text-success"
                              : data.state_type_description == "Anulado"
                              ? "text-danger"
                              : data.state_type_description == "Enviado"
                              ? "text-primary"
                              : "text-black")
                        },
                        [
                          _c("b", [
                            _vm._v(" " + _vm._s(data.state_type_description))
                          ])
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(data.total) +
                        "\n                    "
                    )
                  ])
                ])
              }),
              0
            )
          ]
        )
      ]),
      _vm._v(" "),
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
      }),
      _vm._v(" "),
      _c("whatsapp-modal", {
        attrs: {
          documentNumber: _vm.currentNumber,
          company: _vm.company,
          documentId: _vm.currentId,
          documentTypeId: _vm.currentType,
          showDialog: _vm.showWhatsappModal,
          sender: _vm.sender
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showWhatsappModal = $event
          },
          "update:show-dialog": function($event) {
            _vm.showWhatsappModal = $event
          }
        }
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "span",
      {
        staticClass: "btn btn-primary dropdown-toggle",
        attrs: {
          "data-bs-toggle": "tooltip",
          "data-bs-placement": "top",
          "data-bs-delay": "0",
          title: "",
          "data-bs-original-title": "Item Count",
          "aria-label": "Item Count"
        }
      },
      [_c("i", { staticClass: "fas fa-list" })]
    )
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1bfeb81a", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-c9ff31dc\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue":
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
        visible: _vm.showDialog,
        "append-to-body": "",
        width: "60%",
        title: "Imprimir documento"
      },
      on: { close: _vm.close, open: _vm.open }
    },
    [
      _c("div", { staticClass: "card p-2" }, [
        _c("div", { staticClass: "d-flex" }, [
          _c(
            "div",
            { staticClass: "col-6 p-1 col-md-3" },
            [
              _c(
                "el-select",
                {
                  model: {
                    value: _vm.typeSearch,
                    callback: function($$v) {
                      _vm.typeSearch = $$v
                    },
                    expression: "typeSearch"
                  }
                },
                [
                  _c("el-option", {
                    attrs: { value: "document", label: "N° documento" }
                  }),
                  _vm._v(" "),
                  _c("el-option", {
                    attrs: { value: "client", label: "Cliente" }
                  }),
                  _vm._v(" "),
                  _c("el-option", { attrs: { value: "date", label: "Fecha" } })
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6 p-1 col-md-3" },
            [
              _vm.typeSearch != "date"
                ? _c("el-input", {
                    on: { input: _vm.getRecordsInput },
                    model: {
                      value: _vm.value,
                      callback: function($$v) {
                        _vm.value = $$v
                      },
                      expression: "value"
                    }
                  })
                : _c("el-date-picker", {
                    attrs: { "value-format": "yyyy-MM-dd" },
                    on: { change: _vm.getRecordsInput },
                    model: {
                      value: _vm.value,
                      callback: function($$v) {
                        _vm.value = $$v
                      },
                      expression: "value"
                    }
                  })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "d-flex align-items-center justify-content-end" },
          [
            _c("span", { staticClass: "p-1" }, [
              _vm._v(
                "Ultimo documento emitido:\n                " +
                  _vm._s(
                    _vm.lastDocument
                      ? _vm.lastDocument.numberPrint
                      : "No se encontró"
                  )
              )
            ]),
            _vm._v(" "),
            _c(
              "el-button",
              {
                staticClass: "btn btn-primary",
                on: {
                  click: function($event) {
                    return _vm.printData(
                      _vm.lastDocument.external_id,
                      _vm.lastDocument.document_type_id
                    )
                  }
                }
              },
              [_c("i", { staticClass: "fas fa-print" })]
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          [
            _c(
              "el-tabs",
              {
                on: { "tab-click": _vm.handleClick },
                model: {
                  value: _vm.activeName,
                  callback: function($$v) {
                    _vm.activeName = $$v
                  },
                  expression: "activeName"
                }
              },
              [
                _c(
                  "el-tab-pane",
                  { attrs: { label: "Notas de venta", name: "saleNotes" } },
                  [
                    _c("document-print-detail", {
                      attrs: {
                        company: _vm.company,
                        records: _vm.saleNotes,
                        pagination: _vm.pagination.saleNotes,
                        type: "saleNotes",
                        sender: _vm.sender
                      },
                      on: {
                        getRecords: _vm.getRecords,
                        printData: _vm.printData,
                        "update:records": function($event) {
                          _vm.saleNotes = $event
                        },
                        "update:pagination": function($event) {
                          return _vm.$set(_vm.pagination, "saleNotes", $event)
                        }
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _vm.company.soap_type_id != "03"
                  ? _c(
                      "el-tab-pane",
                      {
                        attrs: {
                          label: "Facturas - Boletas",
                          name: "documents"
                        }
                      },
                      [
                        _c("document-print-detail", {
                          attrs: {
                            sender: _vm.sender,
                            company: _vm.company,
                            records: _vm.documents,
                            pagination: _vm.pagination.documents,
                            type: "documents"
                          },
                          on: {
                            getRecords: _vm.getRecords,
                            printData: _vm.printData,
                            "update:records": function($event) {
                              _vm.documents = $event
                            },
                            "update:pagination": function($event) {
                              return _vm.$set(
                                _vm.pagination,
                                "documents",
                                $event
                              )
                            }
                          }
                        })
                      ],
                      1
                    )
                  : _vm._e()
              ],
              1
            )
          ],
          1
        )
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
    require("vue-hot-reload-api")      .rerender("data-v-c9ff31dc", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-c9ff31dc\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-c9ff31dc\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/documents_print.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("9336984a", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-c9ff31dc\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./documents_print.vue", function() {
     var newContent = require("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-c9ff31dc\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./documents_print.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}
=======
    require("vue-hot-reload-api")      .rerender("data-v-7de5de2c", module.exports)
  }
}
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82

/***/ })

});
<<<<<<< HEAD
>>>>>>> fee205d101915d29cde8b1d8852c8c8b4ddf149b
=======
>>>>>>> 51f1cce7a45d23731a50168e3513ce8497695d82
//# sourceMappingURL=84.js.map