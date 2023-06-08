<<<<<<< HEAD
<<<<<<< HEAD
webpackJsonp([21],{"8H/M":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["showDialog","row"],data:function(){return{total:0}},created:function(){this.getTotal()},methods:{open:function(){this.getTotal()},close:function(){this.$emit("update:showDialog",!1)},getTotal:function(){this.row.document&&(this.total=this.row.document.total),this.row.sale_note&&(this.total=this.row.sale_note.total)}}}},BEQ0:function(t,e,n){"use strict";var r=Object.getOwnPropertySymbols,a=Object.prototype.hasOwnProperty,o=Object.prototype.propertyIsEnumerable;t.exports=function(){try{if(!Object.assign)return!1;var t=new String("abc");if(t[5]="de","5"===Object.getOwnPropertyNames(t)[0])return!1;for(var e={},n=0;n<10;n++)e["_"+String.fromCharCode(n)]=n;if("0123456789"!==Object.getOwnPropertyNames(e).map(function(t){return e[t]}).join(""))return!1;var r={};return"abcdefghijklmnopqrst".split("").forEach(function(t){r[t]=t}),"abcdefghijklmnopqrst"===Object.keys(Object.assign({},r)).join("")}catch(t){return!1}}()?Object.assign:function(t,e){for(var n,s,i=function(t){if(null===t||void 0===t)throw new TypeError("Object.assign cannot be called with null or undefined");return Object(t)}(t),c=1;c<arguments.length;c++){for(var l in n=Object(arguments[c]))a.call(n,l)&&(i[l]=n[l]);if(r){s=r(n);for(var u=0;u<s.length;u++)o.call(n,s[u])&&(i[s[u]]=n[s[u]])}}return i}},En79:function(t,e,n){t.exports=n("FS69")},FS69:function(t,e,n){var r=function(t){"use strict";var e,n=Object.prototype,r=n.hasOwnProperty,a="function"==typeof Symbol?Symbol:{},o=a.iterator||"@@iterator",s=a.asyncIterator||"@@asyncIterator",i=a.toStringTag||"@@toStringTag";function c(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{c({},"")}catch(t){c=function(t,e,n){return t[e]=n}}function l(t,e,n,r){var a=e&&e.prototype instanceof g?e:g,o=Object.create(a.prototype),s=new E(r||[]);return o._invoke=function(t,e,n){var r=d;return function(a,o){if(r===h)throw new Error("Generator is already running");if(r===p){if("throw"===a)throw o;return k()}for(n.method=a,n.arg=o;;){var s=n.delegate;if(s){var i=j(s,n);if(i){if(i===v)continue;return i}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if(r===d)throw r=p,n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r=h;var c=u(t,e,n);if("normal"===c.type){if(r=n.done?p:f,c.arg===v)continue;return{value:c.arg,done:n.done}}"throw"===c.type&&(r=p,n.method="throw",n.arg=c.arg)}}}(t,n,s),o}function u(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=l;var d="suspendedStart",f="suspendedYield",h="executing",p="completed",v={};function g(){}function m(){}function _(){}var y={};c(y,o,function(){return this});var b=Object.getPrototypeOf,w=b&&b(b(F([])));w&&w!==n&&r.call(w,o)&&(y=w);var x=_.prototype=g.prototype=Object.create(y);function C(t){["next","throw","return"].forEach(function(e){c(t,e,function(t){return this._invoke(e,t)})})}function D(t,e){var n;this._invoke=function(a,o){function s(){return new e(function(n,s){!function n(a,o,s,i){var c=u(t[a],t,o);if("throw"!==c.type){var l=c.arg,d=l.value;return d&&"object"==typeof d&&r.call(d,"__await")?e.resolve(d.__await).then(function(t){n("next",t,s,i)},function(t){n("throw",t,s,i)}):e.resolve(d).then(function(t){l.value=t,s(l)},function(t){return n("throw",t,s,i)})}i(c.arg)}(a,o,n,s)})}return n=n?n.then(s,s):s()}}function j(t,n){var r=t.iterator[n.method];if(r===e){if(n.delegate=null,"throw"===n.method){if(t.iterator.return&&(n.method="return",n.arg=e,j(t,n),"throw"===n.method))return v;n.method="throw",n.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var a=u(r,t.iterator,n.arg);if("throw"===a.type)return n.method="throw",n.arg=a.arg,n.delegate=null,v;var o=a.arg;return o?o.done?(n[t.resultName]=o.value,n.next=t.nextLoc,"return"!==n.method&&(n.method="next",n.arg=e),n.delegate=null,v):o:(n.method="throw",n.arg=new TypeError("iterator result is not an object"),n.delegate=null,v)}function $(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function O(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function E(t){this.tryEntries=[{tryLoc:"root"}],t.forEach($,this),this.reset(!0)}function F(t){if(t){var n=t[o];if(n)return n.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var a=-1,s=function n(){for(;++a<t.length;)if(r.call(t,a))return n.value=t[a],n.done=!1,n;return n.value=e,n.done=!0,n};return s.next=s}}return{next:k}}function k(){return{value:e,done:!0}}return m.prototype=_,c(x,"constructor",_),c(_,"constructor",m),m.displayName=c(_,i,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===m||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,_):(t.__proto__=_,c(t,i,"GeneratorFunction")),t.prototype=Object.create(x),t},t.awrap=function(t){return{__await:t}},C(D.prototype),c(D.prototype,s,function(){return this}),t.AsyncIterator=D,t.async=function(e,n,r,a,o){void 0===o&&(o=Promise);var s=new D(l(e,n,r,a),o);return t.isGeneratorFunction(n)?s:s.next().then(function(t){return t.done?t.value:s.next()})},C(x),c(x,i,"Generator"),c(x,o,function(){return this}),c(x,"toString",function(){return"[object Generator]"}),t.keys=function(t){var e=[];for(var n in t)e.push(n);return e.reverse(),function n(){for(;e.length;){var r=e.pop();if(r in t)return n.value=r,n.done=!1,n}return n.done=!0,n}},t.values=F,E.prototype={constructor:E,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(O),!t)for(var n in this)"t"===n.charAt(0)&&r.call(this,n)&&!isNaN(+n.slice(1))&&(this[n]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var n=this;function a(r,a){return i.type="throw",i.arg=t,n.next=r,a&&(n.method="next",n.arg=e),!!a}for(var o=this.tryEntries.length-1;o>=0;--o){var s=this.tryEntries[o],i=s.completion;if("root"===s.tryLoc)return a("end");if(s.tryLoc<=this.prev){var c=r.call(s,"catchLoc"),l=r.call(s,"finallyLoc");if(c&&l){if(this.prev<s.catchLoc)return a(s.catchLoc,!0);if(this.prev<s.finallyLoc)return a(s.finallyLoc)}else if(c){if(this.prev<s.catchLoc)return a(s.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<s.finallyLoc)return a(s.finallyLoc)}}}},abrupt:function(t,e){for(var n=this.tryEntries.length-1;n>=0;--n){var a=this.tryEntries[n];if(a.tryLoc<=this.prev&&r.call(a,"finallyLoc")&&this.prev<a.finallyLoc){var o=a;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var s=o?o.completion:{};return s.type=t,s.arg=e,o?(this.method="next",this.next=o.finallyLoc,v):this.complete(s)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),v},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),O(n),v}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var a=r.arg;O(n)}return a}}throw new Error("illegal catch attempt")},delegateYield:function(t,n,r){return this.delegate={iterator:F(t),resultName:n,nextLoc:r},"next"===this.method&&(this.arg=e),v}},t}(t.exports);try{regeneratorRuntime=r}catch(t){"object"==typeof globalThis?globalThis.regeneratorRuntime=r:Function("r","regeneratorRuntime = r")(r)}},Gew1:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"row"},[n("el-dialog",{attrs:{title:"Platos Atendidos",visible:t.showDialogFoods,"before-close":t.closeDialog},on:{"update:visible":function(e){t.showDialogFoods=e}}},[n("span",[n("form",{attrs:{autocomplete:"off"},on:{submit:function(e){return e.preventDefault(),t.submit.apply(null,arguments)}}},[n("div",{staticClass:"form-body"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"row"},[n("div",{staticClass:"col-md-12"},[t.listFoods.length>0?[n("table",{staticClass:"table table-responsive"},[n("thead",[n("tr",[n("th",{staticClass:"text-center"},[t._v("Cantidad")]),t._v(" "),n("th",[t._v("Producto")])])]),t._v(" "),n("tbody",t._l(t.listFoods,function(e,r){return n("tr",{key:r},[n("td",{staticClass:"text-center"},[t._v(t._s(e.move_quantity))]),t._v(" "),n("td",[t._v(t._s(e.description))])])}),0)])]:[t._v("\n                                        No hay Productos\n                            ")]],2)])])])]),t._v(" "),n("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{on:{click:function(e){return t.closeDialog()}}},[t._v("Cerrar")])],1)])],1)])},staticRenderFns:[]}},LDRt:function(t,e,n){var r=n("VU/8")(n("8H/M"),n("jkq4"),!1,null,null,null);t.exports=r.exports},LuTv:function(t,e,n){var r=n("VU/8")(n("dAt/"),n("Gew1"),!1,null,null,null);t.exports=r.exports},MFz4:function(t,e,n){var r=n("bzq8");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("7c32884c",r,!0,{})},OAwv:function(t,e,n){"use strict";var r=n("rprB"),a=n("BEQ0");function o(t,e){return e.encode?e.strict?r(t):encodeURIComponent(t):t}e.extract=function(t){return t.split("?")[1]||""},e.parse=function(t,e){var n=function(t){var e;switch(t.arrayFormat){case"index":return function(t,n,r){e=/\[(\d*)\]$/.exec(t),t=t.replace(/\[\d*\]$/,""),e?(void 0===r[t]&&(r[t]={}),r[t][e[1]]=n):r[t]=n};case"bracket":return function(t,n,r){e=/(\[\])$/.exec(t),t=t.replace(/\[\]$/,""),e?void 0!==r[t]?r[t]=[].concat(r[t],n):r[t]=[n]:r[t]=n};default:return function(t,e,n){void 0!==n[t]?n[t]=[].concat(n[t],e):n[t]=e}}}(e=a({arrayFormat:"none"},e)),r=Object.create(null);return"string"!=typeof t?r:(t=t.trim().replace(/^(\?|#|&)/,""))?(t.split("&").forEach(function(t){var e=t.replace(/\+/g," ").split("="),a=e.shift(),o=e.length>0?e.join("="):void 0;o=void 0===o?null:decodeURIComponent(o),n(decodeURIComponent(a),o,r)}),Object.keys(r).sort().reduce(function(t,e){var n=r[e];return Boolean(n)&&"object"==typeof n&&!Array.isArray(n)?t[e]=function t(e){return Array.isArray(e)?e.sort():"object"==typeof e?t(Object.keys(e)).sort(function(t,e){return Number(t)-Number(e)}).map(function(t){return e[t]}):e}(n):t[e]=n,t},Object.create(null))):r},e.stringify=function(t,e){var n=function(t){switch(t.arrayFormat){case"index":return function(e,n,r){return null===n?[o(e,t),"[",r,"]"].join(""):[o(e,t),"[",o(r,t),"]=",o(n,t)].join("")};case"bracket":return function(e,n){return null===n?o(e,t):[o(e,t),"[]=",o(n,t)].join("")};default:return function(e,n){return null===n?o(e,t):[o(e,t),"=",o(n,t)].join("")}}}(e=a({encode:!0,strict:!0,arrayFormat:"none"},e));return t?Object.keys(t).sort().map(function(r){var a=t[r];if(void 0===a)return"";if(null===a)return o(r,e);if(Array.isArray(a)){var s=[];return a.slice().forEach(function(t){void 0!==t&&s.push(n(r,t,s.length))}),s.join("&")}return o(r,e)+"="+o(a,e)}).filter(function(t){return t.length>0}).join("&"):""}},"VG/v":function(t,e,n){var r=n("VU/8")(n("lpA3"),n("nVAT"),!1,function(t){n("MFz4")},"data-v-5495888b",null);t.exports=r.exports},bzq8:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".file1[data-v-5495888b]{visibility:hidden;position:absolute}",""])},"dAt/":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["showDialogFoods","listFoods"],data:function(){return{showDialog:!1,open_cash:!0,errors:{},resource:"restaurant/worker/cash",date_closed:moment().format("YYYY-MM-DD"),date_start:moment().format("YYYY-MM-DD"),month_start:moment().format("YYYY-MM"),final_balance:0,cash:null,loading:!1}},methods:{closeDialog:function(){this.$emit("update:showDialogFoods",!1)}}}},jkq4:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("el-dialog",{attrs:{visible:t.showDialog,title:"Detalle Orden N° "+t.row.id},on:{open:t.open,close:t.close}},[t._l(t.row.orden_items,function(e,r){return n("div",{key:r,staticClass:"row"},[n("div",{staticClass:"col-2 text-center"},[t._v("\n            "+t._s(e.quantity)+"\n        ")]),t._v(" "),n("div",{staticClass:"col-5 text-start"},[t._v("\n            "+t._s(e.food.description)+"\n        ")]),t._v(" "),n("div",{staticClass:"col-2 text-end"},[t._v("\n            "+t._s(e.food.price)+"\n        ")]),t._v(" "),n("div",{staticClass:"col-3 text-end"},[t._v("\n            "+t._s((e.food.price*e.quantity).toFixed(2))+"\n        ")])])}),t._v(" "),n("div",{staticClass:"row"},[n("hr")]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-9"}),t._v(" "),n("div",{staticClass:"col-3 text-end"},[t._v("S/ "+t._s(this.total))])])],2)},staticRenderFns:[]}},lpA3:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n("En79"),a=n.n(r),o=n("OAwv"),s=n.n(o),i=n("LuTv"),c=n.n(i),l=n("mu74"),u=n("LDRt"),d=n.n(u),f=n("PJh5"),h=n.n(f);function p(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),n.push.apply(n,r)}return n}function v(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function g(t,e,n,r,a,o,s){try{var i=t[o](s),c=i.value}catch(t){return void n(t)}i.done?e(c):Promise.resolve(c).then(r,a)}function m(t){return function(){var e=this,n=arguments;return new Promise(function(r,a){var o=t.apply(e,n);function s(t){g(o,r,a,s,i,"next",t)}function i(t){g(o,r,a,s,i,"throw",t)}s(void 0)})}}e.default={components:{ViewItems:d.a,ListFood:c.a},mixins:[l.a],props:["configuration"],data:function(){return{allRecords:[],listFoods:{},columns:[{id:1,value:"id",label:"Número de orden"},{id:2,value:"date",label:"Fecha"},{id:3,value:"client",label:"Cliente (DNI / RUC)"}],search:{column:"date",value:h()().format("YYYY-MM-DD")},date_start:h()().format("YYYY-MM-DD"),loading:!1,showDialog:!1,resource:"ordens",currentRow:null,showImage:!1,currentRecord:null,currentImage:null,areas:[],pagination:{},statusTable:[],records:[],totals_notas:0,totals_facturas:0,totals_efectivos:0,showDialogFoods:!1}},created:function(){var t=this;this.$eventHub.$on("reloadData",function(){t.getData()}),this.getData()},methods:{viewItems:function(t){this.currentRow=t,this.showDialog=!0},anular_command:function(t){var e=this;this.anular_comanda("/restaurant/worker/destroyorden/".concat(t),t).then(function(){return e.$eventHub.$emit("reloadData")})},DataFoods:function(){var t=this;return m(a.a.mark(function e(){var n;return a.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$http.get("".concat(t.resource,"/listfoods/").concat(t.search.value));case 2:n=e.sent,t.listFoods=n.data,t.showDialogFoods=!0;case 5:case"end":return e.stop()}},e)}))()},viewFile:function(t){var e="";if(t.document){var n=t.document.external_id;e="/downloads/document/pdf/".concat(n)}if(t.sale_note){var r=t.sale_note.external_id;e="/sale-notes/print/".concat(r,"/a4")}window.open(e,"_blank")},total:function(t){return t.document?t.document.total:t.sale_note?t.sale_note.total:0},getQueryParameters:function(){return s.a.stringify(function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?p(Object(n),!0).forEach(function(e){v(t,e,n[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):p(Object(n)).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))})}return t}({page:this.pagination.current_page,limit:this.limit},this.search))},reset:function(){this.search.value=""},Totals:function(){var t=_.filter(this.records,{document_type_id:"01"}),e=_.filter(this.records,{document_type_id:"80"});console.log("notas_venta",e),console.log("facturas",t),console.log("this.records",this.records),this.totals_facturas=_.sumBy(t,function(t){return parseFloat(t.total)}),this.totals_notas=_.sumBy(e,function(t){return parseFloat(t.total)}),this.totals_efectivos=_.round(this.totals_facturas+this.totals_notas,2)},getData:function(){var t=this;return m(a.a.mark(function e(){var n;return a.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.loading=!0,e.next=3,t.$http.get("".concat(t.resource,"/records?").concat(t.getQueryParameters()));case 3:n=e.sent,t.pagination=n.data.meta,t.pagination.per_page=parseInt(n.data.meta.per_page),t.records=n.data.data,t.loading=!1,t.Totals();case 9:case"end":return e.stop()}},e)}))()},clickDelete:function(t){var e=this;this.destroy("/".concat(this.resource,"/").concat(t)).then(function(){return e.$eventHub.$emit("reloadData")})}}}},mu74:function(t,e,n){"use strict";n.d(e,"a",function(){return r});var r={methods:{anular_comanda:function(t,e){var n=this;return new Promise(function(r){n.$confirm("¿Desea anular Comanda "+e+" seleccionada?","Eliminar",{confirmButtonText:"Eliminar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){n.$http.get(t).then(function(t){t.data.success?(n.$message.success(t.data.message),r()):(n.$message.error(t.data.message),r())}).catch(function(t){500===t.response.status?n.$message.error("Error al intentar eliminar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},destroy:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea eliminar el registro?","Eliminar",{confirmButtonText:"Eliminar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.delete(t).then(function(t){console.log(t),t.data.success?(e.$message.success(t.data.message),n()):(e.$message.error(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar eliminar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},anular:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea anular el registro?","Anular",{confirmButtonText:"Anular",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success&&(e.$message.success("Se anuló correctamente el registro"),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar anular"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},delete:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea eliminar permanentemente el registro?","Anular",{confirmButtonText:"Eliminar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success&&(e.$message.success("Se anuló correctamente el registro"),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar anular"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},disable:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea inhabilitar el registro?","Inhabilitar",{confirmButtonText:"Inhabilitar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success?(e.$message.success(t.data.message),n()):(e.$message.error(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar inhabilitar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},enable:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea habilitar el registro?","Habilitar",{confirmButtonText:"Habilitar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success?(e.$message.success(t.data.message),n()):(e.$message.error(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar habilitar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},voided:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea anular el registro?","Anular",{confirmButtonText:"Anular",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success&&(e.$message.success(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar anular"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},updateStateType:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea modificar el estado del registro?","Modificar",{confirmButtonText:"Modificar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success&&(e.$message.success(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar modificar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t),e.$eventHub.$emit("reloadData")})})}}}},nVAT:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t._m(0),t._v(" "),n("div",{staticClass:"container-fluid p-l-0 p-r-0"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"card"},[t._m(1),t._v(" "),n("div",{staticClass:"card-body"},[n("div",{staticClass:"col-md-12 col-lg-12 col-xl-12 mb-2"},[n("div",{staticClass:"row"},[n("div",{staticClass:"col-md-4 col col-lg-4"},[n("label",{staticClass:"control-label"},[t._v("Buscar por")]),t._v(" "),n("el-select",{key:1,on:{change:t.reset},model:{value:t.search.column,callback:function(e){t.$set(t.search,"column",e)},expression:"search.column"}},t._l(t.columns,function(t,e){return n("el-option",{key:e,attrs:{label:t.label,value:t.value}})}),1)],1),t._v(" "),"date"!==t.search.column?n("div",{staticClass:"col-md-4 col col-lg-4 d-flex align-items-end"},[n("el-input",{attrs:{placeholder:"orden"==t.search.column?"N° de orden":"Nombre / N° documento del cliente"},model:{value:t.search.value,callback:function(e){t.$set(t.search,"value",e)},expression:"search.value"}},[n("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1):t._e(),t._v(" "),"date"==t.search.column?n("div",{staticClass:"col-md-4 col col-lg-4 d-flex align-items-end"},[n("el-date-picker",{staticClass:"w-100",attrs:{format:"d/MM/yy","value-format":"yyyy-MM-dd",type:"date"},model:{value:t.search.value,callback:function(e){t.$set(t.search,"value",e)},expression:"search.value"}})],1):t._e(),t._v(" "),n("div",{staticClass:"col-md-4 col col-lg-4 d-flex align-items-end"},[n("button",{staticClass:"btn btn-primary btn-sm",attrs:{loading:t.loading},on:{click:t.getData}},[t._v("\n                                Buscar\n                            ")]),t._v(" "),n("button",{staticClass:"btn btn-success btn-sm",attrs:{loading:t.loading},on:{click:t.DataFoods}},[t._v("\n                                Platos atentidos\n                            ")])])])]),t._v(" "),n("div",{staticClass:"table-responsive"},[n("div",[n("el-pagination",{attrs:{layout:"total, prev, pager, next",total:t.pagination.total,"current-page":t.pagination.current_page,"page-size":t.pagination.per_page},on:{"current-change":t.getData,"update:currentPage":function(e){return t.$set(t.pagination,"current_page",e)},"update:current-page":function(e){return t.$set(t.pagination,"current_page",e)}}})],1),t._v(" "),n("table",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"table"},[t._m(2),t._v(" "),n("tbody",t._l(t.records,function(e,r){return n("tr",{key:r,class:{"bg bg-dark":"1"===e.status_orden_id,"bg bg-secondary":"2"===e.status_orden_id,"bg bg-warning":"3"===e.status_orden_id,"bg-success":"4"===e.status_orden_id,"bg bg-danger":"5"===e.status_orden_id}},[n("td",{staticClass:"text-center"},[t._v(t._s(r+1))]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.id)+"\n                                ")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.customer)+"\n                                ")]),t._v(" "),n("td",{staticClass:"text-center"},[n("button",{staticClass:"btn btn-sm btn-primary",on:{click:function(n){return t.viewItems(e)}}},[n("i",{staticClass:"fas fa-list"})])]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.document_type)),n("br"),t._v(" "),n("span",{staticClass:"badge rounded-pill  text-dark"},[t._v("\n                                        "+t._s(e.document_number))]),n("br"),t._v(" "),4==e.status_orden_id?n("button",{staticClass:"btn btn-sm btn-success",on:{click:function(n){return t.viewFile(e)}}},[n("i",{staticClass:"fas fa-file"}),t._v("\n                                        Descargar\n                                    ")]):t._e()]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.status)+"\n                                ")]),t._v(" "),n("td",{staticClass:"text-center"},[1==e.status_id||2==e.status_id?n("el-button",{attrs:{type:"danger"},on:{click:function(n){return t.anular_command(e.id)}}},[t._v("\n                                        Anular")]):t._e()],1),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(t.total(e))+"\n                                ")])])}),0),t._v(" "),n("tr",[n("td",{staticClass:"text-end",attrs:{colspan:"7"}},[t._v("\n                                Total de Nota de Venta\n                            ")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                "+t._s(t.totals_notas.toFixed(2))+"\n                            ")])]),t._v(" "),n("tr",[n("td",{staticClass:"text-end",attrs:{colspan:"7"}},[t._v("\n                                Total de Boletas - Facturas\n                            ")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                "+t._s(t.totals_facturas.toFixed(2))+"\n                            ")])]),t._v(" "),n("tr",[n("td",{staticClass:"text-end",attrs:{colspan:"7"}},[t._v("Total")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                "+t._s(t.totals_efectivos.toFixed(2))+"\n                            ")])])]),t._v(" "),n("div",[n("el-pagination",{attrs:{layout:"total, prev, pager, next",total:t.pagination.total,"current-page":t.pagination.current_page,"page-size":t.pagination.per_page},on:{"current-change":t.getData,"update:currentPage":function(e){return t.$set(t.pagination,"current_page",e)},"update:current-page":function(e){return t.$set(t.pagination,"current_page",e)}}})],1)])]),t._v(" "),t.currentRow?n("view-items",{attrs:{row:t.currentRow,showDialog:t.showDialog},on:{"update:showDialog":function(e){t.showDialog=e},"update:show-dialog":function(e){t.showDialog=e}}}):t._e(),t._v(" "),n("ListFood",{attrs:{showDialogFoods:t.showDialogFoods,listFoods:t.listFoods},on:{"update:showDialogFoods":function(e){t.showDialogFoods=e},"update:show-dialog-foods":function(e){t.showDialogFoods=e},"update:listFoods":function(e){t.listFoods=e},"update:list-foods":function(e){t.listFoods=e}}})],1)])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"container-fluid p-l-0 p-r-0"},[e("div",{staticClass:"page-header"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col-sm-6"},[e("h6",[e("span",[this._v("Lista de Ordenes atentidas")])]),this._v(" "),e("ol",{staticClass:"breadcrumb"},[e("li",{staticClass:"breadcrumb-item"},[e("a",{attrs:{href:"/dashboard"}},[this._v("Dashboard")])]),this._v(" "),e("li",{staticClass:"breadcrumb-item active"},[e("span",{staticClass:"text-muted"},[this._v("Lista de Ordenes atentidas")])])])])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"card-header bg-primary"},[e("h6",{staticClass:"my-0 text-white"},[this._v("Lista de Ordenes atentidas")])])},function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("thead",[n("tr",[n("th",{staticClass:"text-center"},[t._v("#")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("N° de Comanda")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Cliente")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Detalle")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Documento")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Estado")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Acciones")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Total Pagado")])])])}]}},rjj0:function(t,e,n){var r="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!r)throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var a=n("tTVk"),o={},s=r&&(document.head||document.getElementsByTagName("head")[0]),i=null,c=0,l=!1,u=function(){},d=null,f="data-vue-ssr-id",h="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());function p(t){for(var e=0;e<t.length;e++){var n=t[e],r=o[n.id];if(r){r.refs++;for(var a=0;a<r.parts.length;a++)r.parts[a](n.parts[a]);for(;a<n.parts.length;a++)r.parts.push(g(n.parts[a]));r.parts.length>n.parts.length&&(r.parts.length=n.parts.length)}else{var s=[];for(a=0;a<n.parts.length;a++)s.push(g(n.parts[a]));o[n.id]={id:n.id,refs:1,parts:s}}}}function v(){var t=document.createElement("style");return t.type="text/css",s.appendChild(t),t}function g(t){var e,n,r=document.querySelector("style["+f+'~="'+t.id+'"]');if(r){if(l)return u;r.parentNode.removeChild(r)}if(h){var a=c++;r=i||(i=v()),e=y.bind(null,r,a,!1),n=y.bind(null,r,a,!0)}else r=v(),e=function(t,e){var n=e.css,r=e.media,a=e.sourceMap;r&&t.setAttribute("media",r);d.ssrId&&t.setAttribute(f,e.id);a&&(n+="\n/*# sourceURL="+a.sources[0]+" */",n+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(a))))+" */");if(t.styleSheet)t.styleSheet.cssText=n;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(n))}}.bind(null,r),n=function(){r.parentNode.removeChild(r)};return e(t),function(r){if(r){if(r.css===t.css&&r.media===t.media&&r.sourceMap===t.sourceMap)return;e(t=r)}else n()}}t.exports=function(t,e,n,r){l=n,d=r||{};var s=a(t,e);return p(s),function(e){for(var n=[],r=0;r<s.length;r++){var i=s[r];(c=o[i.id]).refs--,n.push(c)}e?p(s=a(t,e)):s=[];for(r=0;r<n.length;r++){var c;if(0===(c=n[r]).refs){for(var l=0;l<c.parts.length;l++)c.parts[l]();delete o[c.id]}}}};var m,_=(m=[],function(t,e){return m[t]=e,m.filter(Boolean).join("\n")});function y(t,e,n,r){var a=n?"":r.css;if(t.styleSheet)t.styleSheet.cssText=_(e,a);else{var o=document.createTextNode(a),s=t.childNodes;s[e]&&t.removeChild(s[e]),s.length?t.insertBefore(o,s[e]):t.appendChild(o)}}},rprB:function(t,e,n){"use strict";t.exports=function(t){return encodeURIComponent(t).replace(/[!'()*]/g,function(t){return"%"+t.charCodeAt(0).toString(16).toUpperCase()})}},tTVk:function(t,e){t.exports=function(t,e){for(var n=[],r={},a=0;a<e.length;a++){var o=e[a],s=o[0],i={id:t+":"+a,css:o[1],media:o[2],sourceMap:o[3]};r[s]?r[s].parts.push(i):n.push(r[s]={id:s,parts:[i]})}return n}}});
=======
webpackJsonp([21],{

/***/ "./modules/Restaurant/Resources/assets/js/views/ordens/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7645ebbd\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/index.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/index.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7645ebbd\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/index.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-7645ebbd"
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/ordens/index.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7645ebbd", Component.options)
  } else {
    hotAPI.reload("data-v-7645ebbd", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./modules/Restaurant/Resources/assets/js/views/ordens/items.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/items.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-27d383ab\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/items.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/ordens/items.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-27d383ab", Component.options)
  } else {
    hotAPI.reload("data-v-27d383ab", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./modules/Restaurant/Resources/assets/js/views/ordens/listFoods.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/listFoods.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-50e168c2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/listFoods.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/ordens/listFoods.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-50e168c2", Component.options)
  } else {
    hotAPI.reload("data-v-50e168c2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/@babel/runtime/node_modules/regenerator-runtime/runtime.js":
/***/ (function(module, exports, __webpack_require__) {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
    return obj[key];
  }
  try {
    // IE 8 has a broken Object.defineProperty that only works on DOM objects.
    define({}, "");
  } catch (err) {
    define = function(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  define(IteratorPrototype, iteratorSymbol, function () {
    return this;
  });

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = GeneratorFunctionPrototype;
  define(Gp, "constructor", GeneratorFunctionPrototype);
  define(GeneratorFunctionPrototype, "constructor", GeneratorFunction);
  GeneratorFunction.displayName = define(
    GeneratorFunctionPrototype,
    toStringTagSymbol,
    "GeneratorFunction"
  );

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      define(prototype, method, function(arg) {
        return this._invoke(method, arg);
      });
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      define(genFun, toStringTagSymbol, "GeneratorFunction");
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return PromiseImpl.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return PromiseImpl.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  define(AsyncIterator.prototype, asyncIteratorSymbol, function () {
    return this;
  });
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    if (PromiseImpl === void 0) PromiseImpl = Promise;

    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList),
      PromiseImpl
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  define(Gp, toStringTagSymbol, "Generator");

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  define(Gp, iteratorSymbol, function() {
    return this;
  });

  define(Gp, "toString", function() {
    return "[object Generator]";
  });

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : {}
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, in modern engines
  // we can explicitly access globalThis. In older engines we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  if (typeof globalThis === "object") {
    globalThis.regeneratorRuntime = runtime;
  } else {
    Function("r", "regeneratorRuntime = r")(runtime);
  }
}


/***/ }),

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./node_modules/@babel/runtime/node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/index.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_query_string__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__listFoods_vue__ = __webpack_require__("./modules/Restaurant/Resources/assets/js/views/ordens/listFoods.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__listFoods_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__listFoods_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__resources_js_mixins_deletable__ = __webpack_require__("./resources/js/mixins/deletable.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__items_vue__ = __webpack_require__("./modules/Restaurant/Resources/assets/js/views/ordens/items.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__items_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__items_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_moment__);
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    ViewItems: __WEBPACK_IMPORTED_MODULE_4__items_vue___default.a,
    ListFood: __WEBPACK_IMPORTED_MODULE_2__listFoods_vue___default.a
  },
  mixins: [__WEBPACK_IMPORTED_MODULE_3__resources_js_mixins_deletable__["a" /* deletable */]],
  props: ["configuration"],
  data: function data() {
    return {
      allRecords: [],
      listFoods: {},
      columns: [{
        id: 1,
        value: "id",
        label: "Número de orden"
      }, {
        id: 2,
        value: "date",
        label: "Fecha"
      }, {
        id: 3,
        value: "client",
        label: "Cliente (DNI / RUC)"
      }],
      search: {
        column: "date",
        value: __WEBPACK_IMPORTED_MODULE_5_moment___default()().format("YYYY-MM-DD")
      },
      date_start: __WEBPACK_IMPORTED_MODULE_5_moment___default()().format("YYYY-MM-DD"),
      loading: false,
      showDialog: false,
      resource: "ordens",
      currentRow: null,
      showImage: false,
      currentRecord: null,
      currentImage: null,
      areas: [],
      pagination: {},
      statusTable: [],
      records: [],
      totals_notas: 0,
      totals_facturas: 0,
      totals_efectivos: 0,
      showDialogFoods: false
    };
  },
  created: function created() {
    var _this = this;

    this.$eventHub.$on("reloadData", function () {
      _this.getData();
    });
    this.getData();
  },
  methods: {
    viewItems: function viewItems(row) {
      this.currentRow = row;
      this.showDialog = true;
    },
    anular_command: function anular_command(id) {
      var _this2 = this;

      this.anular_comanda("/restaurant/worker/destroyorden/".concat(id), id).then(function () {
        return _this2.$eventHub.$emit("reloadData");
      });
    },
    DataFoods: function DataFoods() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this3.$http.get("".concat(_this3.resource, "/listfoods/").concat(_this3.search.value));

              case 2:
                response = _context.sent;
                _this3.listFoods = response.data;
                _this3.showDialogFoods = true;

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    viewFile: function viewFile(row) {
      var url = "";

      if (row.document) {
        var external_id = row.document.external_id;
        url = "/downloads/document/pdf/".concat(external_id);
      }

      if (row.sale_note) {
        var _external_id = row.sale_note.external_id;
        url = "/sale-notes/print/".concat(_external_id, "/a4");
      }

      window.open(url, "_blank");
    },
    total: function total(row) {
      if (row.document) {
        return row.document.total;
      }

      if (row.sale_note) {
        return row.sale_note.total;
      }

      return 0.0;
    },
    getQueryParameters: function getQueryParameters() {
      return __WEBPACK_IMPORTED_MODULE_1_query_string___default.a.stringify(_objectSpread({
        page: this.pagination.current_page,
        limit: this.limit
      }, this.search));
    },
    reset: function reset() {
      this.search.value = "";
    },
    Totals: function Totals() {
      var facturas = _.filter(this.records, {
        document_type_id: "01"
      });

      var notas_venta = _.filter(this.records, {
        document_type_id: "80"
      });

      console.log("notas_venta", notas_venta);
      console.log("facturas", facturas);
      console.log("this.records", this.records);
      this.totals_facturas = _.sumBy(facturas, function (it) {
        return parseFloat(it.total);
      });
      this.totals_notas = _.sumBy(notas_venta, function (it) {
        return parseFloat(it.total);
      });
      this.totals_efectivos = _.round(this.totals_facturas + this.totals_notas, 2);
    },
    getData: function getData() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this4.loading = true; //let query = queryString.stringify(this.search);

                _context2.next = 3;
                return _this4.$http.get("".concat(_this4.resource, "/records?").concat(_this4.getQueryParameters()));

              case 3:
                response = _context2.sent;
                _this4.pagination = response.data.meta;
                _this4.pagination.per_page = parseInt(response.data.meta.per_page);
                _this4.records = response.data.data;
                _this4.loading = false;

                _this4.Totals();

              case 9:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
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

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/items.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "row"],
  data: function data() {
    return {
      total: 0.0
    };
  },
  created: function created() {
    this.getTotal();
  },
  methods: {
    open: function open() {
      this.getTotal();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    getTotal: function getTotal() {
      if (this.row.document) {
        this.total = this.row.document.total;
      }

      if (this.row.sale_note) {
        this.total = this.row.sale_note.total;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/listFoods.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['showDialogFoods', "listFoods"],
  data: function data() {
    return {
      showDialog: false,
      open_cash: true,
      errors: {},
      resource: 'restaurant/worker/cash',
      date_closed: moment().format('YYYY-MM-DD'),
      date_start: moment().format('YYYY-MM-DD'),
      month_start: moment().format('YYYY-MM'),
      final_balance: 0,
      cash: null,
      loading: false
    };
  },
  methods: {
    closeDialog: function closeDialog() {
      this.$emit('update:showDialogFoods', false);
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7645ebbd\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/index.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.file1[data-v-7645ebbd] {\r\n    visibility: hidden;\r\n    position: absolute;\n}\r\n", "", {"version":3,"sources":["C:/laragon/www/finalrestobar/modules/Restaurant/Resources/assets/js/views/ordens/modules/Restaurant/Resources/assets/js/views/ordens/index.vue"],"names":[],"mappings":";AA4PA;IACA,mBAAA;IACA,mBAAA;CACA","file":"index.vue","sourcesContent":["<template>\r\n    <div>\r\n        <div class=\"container-fluid p-l-0 p-r-0\">\r\n            <div class=\"page-header\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-sm-6\">\r\n                        <h6><span>Lista de Ordenes atentidas</span></h6>\r\n                        <ol class=\"breadcrumb\">\r\n                            <li class=\"breadcrumb-item\">\r\n                                <a href=\"/dashboard\">Dashboard</a>\r\n                            </li>\r\n                            <li class=\"breadcrumb-item active\">\r\n                                <span class=\"text-muted\"\r\n                                    >Lista de Ordenes atentidas</span\r\n                                >\r\n                            </li>\r\n                        </ol>\r\n                    </div>\r\n                    <!-- <div class=\"col-12 col-md-6 d-flex align-items-start justify-content-end\">\r\n                 <button type=\"button\" class=\"btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto\" @click.prevent=\"clickCreate()\">\r\n                <i class=\"icofont-plus-circle\"></i>\r\n                <span>Nuevo</span>\r\n                </button>\r\n             </div> -->\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <div class=\"container-fluid p-l-0 p-r-0\">\r\n            <div class=\"card\" v-loading=\"loading\">\r\n                <div class=\"card-header bg-primary\">\r\n                    <h6 class=\"my-0 text-white\">Lista de Ordenes atentidas</h6>\r\n                </div>\r\n                <div class=\"card-body\">\r\n                    <div class=\"col-md-12 col-lg-12 col-xl-12 mb-2\">\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-4 col col-lg-4\">\r\n                                <label class=\"control-label\">Buscar por</label>\r\n                                <el-select\r\n                                    @change=\"reset\"\r\n                                    v-model=\"search.column\"\r\n                                    :key=\"1\"\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"(data, index) in columns\"\r\n                                        :key=\"index\"\r\n                                        :label=\"data.label\"\r\n                                        :value=\"data.value\"\r\n                                    ></el-option>\r\n                                </el-select>\r\n                            </div>\r\n                            <div\r\n                                v-if=\"search.column !== 'date'\"\r\n                                class=\"col-md-4 col col-lg-4 d-flex align-items-end\"\r\n                            >\r\n                                <el-input\r\n                                    :placeholder=\"\r\n                                        `${\r\n                                            search.column == 'orden'\r\n                                                ? 'N° de orden'\r\n                                                : 'Nombre / N° documento del cliente'\r\n                                        }`\r\n                                    \"\r\n                                    v-model=\"search.value\"\r\n                                >\r\n                                    <i\r\n                                        slot=\"prefix\"\r\n                                        class=\"el-icon-edit-outline\"\r\n                                    ></i\r\n                                ></el-input>\r\n                            </div>\r\n                            <div\r\n                                v-if=\"search.column == 'date'\"\r\n                                class=\"col-md-4 col col-lg-4 d-flex align-items-end\"\r\n                            >\r\n                                <el-date-picker\r\n                                    class=\"w-100\"\r\n                                    format=\"d/MM/yy\"\r\n                                    value-format=\"yyyy-MM-dd\"\r\n                                    v-model=\"search.value\"\r\n                                    type=\"date\"\r\n                                >\r\n                                </el-date-picker>\r\n                            </div>\r\n                            <div\r\n                                class=\"col-md-4 col col-lg-4 d-flex align-items-end\"\r\n                            >\r\n                                <button\r\n                                    @click=\"getData\"\r\n                                    class=\"btn btn-primary btn-sm\"\r\n                                    :loading=\"loading\"\r\n                                >\r\n                                    Buscar\r\n                                </button>\r\n                                <button\r\n                                    @click=\"DataFoods\"\r\n                                    class=\"btn btn-success btn-sm\"\r\n                                    :loading=\"loading\"\r\n                                >\r\n                                    Platos atentidos\r\n                                </button>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"table-responsive\">\r\n                        <div>\r\n                            <el-pagination\r\n                                @current-change=\"getData\"\r\n                                layout=\"total, prev, pager, next\"\r\n                                :total=\"pagination.total\"\r\n                                :current-page.sync=\"pagination.current_page\"\r\n                                :page-size=\"pagination.per_page\"\r\n                            >\r\n                            </el-pagination>\r\n                        </div>\r\n                        <table class=\"table\" v-loading=\"loading\">\r\n                            <thead>\r\n                                <tr>\r\n                                    <th class=\"text-center\">#</th>\r\n                                    <th class=\"text-center\">N° de Comanda</th>\r\n                                    <th class=\"text-center\">Cliente</th>\r\n                                    <th class=\"text-center\">Detalle</th>\r\n                                    <th class=\"text-center\">Documento</th>\r\n                                    <th class=\"text-center\">Estado</th>\r\n                                    <th class=\"text-center\">Acciones</th>\r\n                                    <th class=\"text-center\">Total Pagado</th>\r\n                                </tr>\r\n                            </thead>\r\n                            <tbody>\r\n                                <tr\r\n                                    v-for=\"(row, index) in records\"\r\n                                    :key=\"index\"\r\n                                    :class=\"{\r\n                                        'bg bg-dark':\r\n                                            row.status_orden_id === '1',\r\n                                        'bg bg-secondary':\r\n                                            row.status_orden_id === '2',\r\n                                        'bg bg-warning':\r\n                                            row.status_orden_id === '3',\r\n                                        'bg-success':\r\n                                            row.status_orden_id === '4',\r\n                                        'bg bg-danger':\r\n                                            row.status_orden_id === '5'\r\n                                    }\"\r\n                                >\r\n                                    <td class=\"text-center\">{{ index + 1 }}</td>\r\n                                    <td class=\"text-center\">\r\n                                        {{ row.id }}\r\n                                    </td>\r\n\r\n                                    <td class=\"text-center\">\r\n                                        {{ row.customer }}\r\n                                    </td>\r\n\r\n                                    <td class=\"text-center\">\r\n                                        <button\r\n                                            class=\"btn btn-sm btn-primary\"\r\n                                            @click=\"viewItems(row)\"\r\n                                        >\r\n                                            <i class=\"fas fa-list\"></i>\r\n                                        </button>\r\n                                    </td>\r\n\r\n                                    <td class=\"text-center\">\r\n                                        {{ row.document_type }}<br />\r\n                                        <span\r\n                                            class=\"badge rounded-pill  text-dark\"\r\n                                        >\r\n                                            {{ row.document_number }}</span\r\n                                        ><br />\r\n\r\n                                        <button\r\n                                            class=\"btn btn-sm btn-success\"\r\n                                            @click=\"viewFile(row)\"\r\n                                            v-if=\"row.status_orden_id == 4\"\r\n                                        >\r\n                                            <i class=\"fas fa-file\"></i>\r\n                                            Descargar\r\n                                        </button>\r\n                                    </td>\r\n\r\n                                    <td class=\"text-center\">\r\n                                        {{ row.status }}\r\n                                    </td>\r\n\r\n                                    <td class=\"text-center\">\r\n                                        <el-button\r\n                                            v-if=\"\r\n                                                row.status_id == 1 ||\r\n                                                    row.status_id == 2\r\n                                            \"\r\n                                            type=\"danger\"\r\n                                            @click=\"anular_command(row.id)\"\r\n                                        >\r\n                                            Anular</el-button\r\n                                        >\r\n                                    </td>\r\n                                    <td class=\"text-center\">\r\n                                        {{ total(row) }}\r\n                                    </td>\r\n                                </tr>\r\n                            </tbody>\r\n                            <tr>\r\n                                <td colspan=\"7\" class=\"text-end\">\r\n                                    Total de Nota de Venta\r\n                                </td>\r\n                                <td class=\"text-center\">\r\n                                    {{ totals_notas.toFixed(2) }}\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"7\" class=\"text-end\">\r\n                                    Total de Boletas - Facturas\r\n                                </td>\r\n                                <td class=\"text-center\">\r\n                                    {{ totals_facturas.toFixed(2) }}\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"7\" class=\"text-end\">Total</td>\r\n                                <td class=\"text-center\">\r\n                                    {{ totals_efectivos.toFixed(2) }}\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n\r\n                        <div>\r\n                            <el-pagination\r\n                                @current-change=\"getData\"\r\n                                layout=\"total, prev, pager, next\"\r\n                                :total=\"pagination.total\"\r\n                                :current-page.sync=\"pagination.current_page\"\r\n                                :page-size=\"pagination.per_page\"\r\n                            >\r\n                            </el-pagination>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <view-items\r\n                    v-if=\"currentRow\"\r\n                    :row=\"currentRow\"\r\n                    :showDialog.sync=\"showDialog\"\r\n                >\r\n                </view-items>\r\n                <ListFood\r\n                    :showDialogFoods.sync=\"showDialogFoods\"\r\n                    :listFoods.sync=\"listFoods\"\r\n                ></ListFood>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</template>\r\n<style scoped>\r\n.file1 {\r\n    visibility: hidden;\r\n    position: absolute;\r\n}\r\n</style>\r\n<script>\r\nimport queryString from \"query-string\";\r\n\r\nimport ListFood from \"./listFoods.vue\";\r\nimport { deletable } from \"../../../../../../../resources/js/mixins/deletable\";\r\nimport ViewItems from \"./items.vue\";\r\nimport moment from \"moment\";\r\nexport default {\r\n    components: { ViewItems, ListFood },\r\n    mixins: [deletable],\r\n    props: [\"configuration\"],\r\n    data() {\r\n        return {\r\n            allRecords: [],\r\n            listFoods: {},\r\n            columns: [\r\n                {\r\n                    id: 1,\r\n                    value: \"id\",\r\n                    label: \"Número de orden\"\r\n                },\r\n                {\r\n                    id: 2,\r\n                    value: \"date\",\r\n                    label: \"Fecha\"\r\n                },\r\n                {\r\n                    id: 3,\r\n                    value: \"client\",\r\n                    label: \"Cliente (DNI / RUC)\"\r\n                }\r\n            ],\r\n            search: { column: \"date\", value: moment().format(\"YYYY-MM-DD\") },\r\n            date_start: moment().format(\"YYYY-MM-DD\"),\r\n            loading: false,\r\n            showDialog: false,\r\n            resource: \"ordens\",\r\n            currentRow: null,\r\n            showImage: false,\r\n            currentRecord: null,\r\n            currentImage: null,\r\n            areas: [],\r\n            pagination: {},\r\n            statusTable: [],\r\n            records: [],\r\n            totals_notas: 0,\r\n            totals_facturas: 0,\r\n            totals_efectivos: 0,\r\n            showDialogFoods: false\r\n        };\r\n    },\r\n    created() {\r\n        this.$eventHub.$on(\"reloadData\", () => {\r\n            this.getData();\r\n        });\r\n\r\n        this.getData();\r\n    },\r\n    methods: {\r\n        viewItems(row) {\r\n            this.currentRow = row;\r\n            this.showDialog = true;\r\n        },\r\n        anular_command(id) {\r\n            this.anular_comanda(\r\n                `/restaurant/worker/destroyorden/${id}`,\r\n                id\r\n            ).then(() => this.$eventHub.$emit(\"reloadData\"));\r\n        },\r\n        async DataFoods() {\r\n            const response = await this.$http.get(\r\n                `${this.resource}/listfoods/${this.search.value}`\r\n            );\r\n            this.listFoods = response.data;\r\n            this.showDialogFoods = true;\r\n        },\r\n        viewFile(row) {\r\n            let url = \"\";\r\n            if (row.document) {\r\n                let external_id = row.document.external_id;\r\n                url = `/downloads/document/pdf/${external_id}`;\r\n            }\r\n            if (row.sale_note) {\r\n                let external_id = row.sale_note.external_id;\r\n                url = `/sale-notes/print/${external_id}/a4`;\r\n            }\r\n            window.open(url, \"_blank\");\r\n        },\r\n        total(row) {\r\n            if (row.document) {\r\n                return row.document.total;\r\n            }\r\n            if (row.sale_note) {\r\n                return row.sale_note.total;\r\n            }\r\n            return 0.0;\r\n        },\r\n        getQueryParameters() {\r\n            return queryString.stringify({\r\n                page: this.pagination.current_page,\r\n                limit: this.limit,\r\n                ...this.search\r\n            });\r\n        },\r\n        reset() {\r\n            this.search.value = \"\";\r\n        },\r\n        Totals() {\r\n            let facturas = _.filter(this.records, { document_type_id: \"01\" });\r\n\r\n            let notas_venta = _.filter(this.records, {\r\n                document_type_id: \"80\"\r\n            });\r\n            console.log(\"notas_venta\", notas_venta);\r\n            console.log(\"facturas\", facturas);\r\n            console.log(\"this.records\", this.records);\r\n            this.totals_facturas = _.sumBy(facturas, it =>\r\n                parseFloat(it.total)\r\n            );\r\n            this.totals_notas = _.sumBy(notas_venta, it =>\r\n                parseFloat(it.total)\r\n            );\r\n            this.totals_efectivos = _.round(\r\n                this.totals_facturas + this.totals_notas,\r\n                2\r\n            );\r\n        },\r\n        async getData() {\r\n            this.loading = true;\r\n            //let query = queryString.stringify(this.search);\r\n            const response = await this.$http.get(\r\n                `${this.resource}/records?${this.getQueryParameters()}`\r\n            );\r\n            this.pagination = response.data.meta;\r\n            this.pagination.per_page = parseInt(response.data.meta.per_page);\r\n            this.records = response.data.data;\r\n            this.loading = false;\r\n            this.Totals();\r\n        },\r\n\r\n        clickDelete(id) {\r\n            this.destroy(`/${this.resource}/${id}`).then(() =>\r\n                this.$eventHub.$emit(\"reloadData\")\r\n            );\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-27d383ab\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/items.vue":
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
        title: "Detalle Orden N° " + _vm.row.id
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _vm._l(_vm.row.orden_items, function(data, idx) {
        return _c("div", { key: idx, staticClass: "row" }, [
          _c("div", { staticClass: "col-2 text-center" }, [
            _vm._v("\n            " + _vm._s(data.quantity) + "\n        ")
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-5 text-start" }, [
            _vm._v(
              "\n            " + _vm._s(data.food.description) + "\n        "
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-2 text-end" }, [
            _vm._v("\n            " + _vm._s(data.food.price) + "\n        ")
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-3 text-end" }, [
            _vm._v(
              "\n            " +
                _vm._s((data.food.price * data.quantity).toFixed(2)) +
                "\n        "
            )
          ])
        ])
      }),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [_c("hr")]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-9" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-3 text-end" }, [
          _vm._v("S/ " + _vm._s(this.total))
        ])
      ])
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-27d383ab", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-50e168c2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/listFoods.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "div",
      { staticClass: "row" },
      [
        _c(
          "el-dialog",
          {
            attrs: {
              title: "Platos Atendidos",
              visible: _vm.showDialogFoods,
              "before-close": _vm.closeDialog
            },
            on: {
              "update:visible": function($event) {
                _vm.showDialogFoods = $event
              }
            }
          },
          [
            _c("span", [
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
                      {
                        directives: [
                          {
                            name: "loading",
                            rawName: "v-loading",
                            value: _vm.loading,
                            expression: "loading"
                          }
                        ],
                        staticClass: "row"
                      },
                      [
                        _c(
                          "div",
                          { staticClass: "col-md-12" },
                          [
                            _vm.listFoods.length > 0
                              ? [
                                  _c(
                                    "table",
                                    { staticClass: "table table-responsive" },
                                    [
                                      _c("thead", [
                                        _c("tr", [
                                          _c(
                                            "th",
                                            { staticClass: "text-center" },
                                            [_vm._v("Cantidad")]
                                          ),
                                          _vm._v(" "),
                                          _c("th", [_vm._v("Producto")])
                                        ])
                                      ]),
                                      _vm._v(" "),
                                      _c(
                                        "tbody",
                                        _vm._l(_vm.listFoods, function(
                                          row,
                                          index
                                        ) {
                                          return _c("tr", { key: index }, [
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm._v(
                                                  _vm._s(row.move_quantity)
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c("td", [
                                              _vm._v(_vm._s(row.description))
                                            ])
                                          ])
                                        }),
                                        0
                                      )
                                    ]
                                  )
                                ]
                              : [
                                  _vm._v(
                                    "\n                                        No hay Productos\n                            "
                                  )
                                ]
                          ],
                          2
                        )
                      ]
                    )
                  ])
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
                _c(
                  "el-button",
                  {
                    on: {
                      click: function($event) {
                        return _vm.closeDialog()
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
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-50e168c2", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7645ebbd\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/index.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _vm._m(0),
    _vm._v(" "),
    _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
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
          staticClass: "card"
        },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("div", { staticClass: "card-body" }, [
            _c("div", { staticClass: "col-md-12 col-lg-12 col-xl-12 mb-2" }, [
              _c("div", { staticClass: "row" }, [
                _c(
                  "div",
                  { staticClass: "col-md-4 col col-lg-4" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Buscar por")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        key: 1,
                        on: { change: _vm.reset },
                        model: {
                          value: _vm.search.column,
                          callback: function($$v) {
                            _vm.$set(_vm.search, "column", $$v)
                          },
                          expression: "search.column"
                        }
                      },
                      _vm._l(_vm.columns, function(data, index) {
                        return _c("el-option", {
                          key: index,
                          attrs: { label: data.label, value: data.value }
                        })
                      }),
                      1
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _vm.search.column !== "date"
                  ? _c(
                      "div",
                      {
                        staticClass:
                          "col-md-4 col col-lg-4 d-flex align-items-end"
                      },
                      [
                        _c(
                          "el-input",
                          {
                            attrs: {
                              placeholder:
                                "" +
                                (_vm.search.column == "orden"
                                  ? "N° de orden"
                                  : "Nombre / N° documento del cliente")
                            },
                            model: {
                              value: _vm.search.value,
                              callback: function($$v) {
                                _vm.$set(_vm.search, "value", $$v)
                              },
                              expression: "search.value"
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
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.column == "date"
                  ? _c(
                      "div",
                      {
                        staticClass:
                          "col-md-4 col col-lg-4 d-flex align-items-end"
                      },
                      [
                        _c("el-date-picker", {
                          staticClass: "w-100",
                          attrs: {
                            format: "d/MM/yy",
                            "value-format": "yyyy-MM-dd",
                            type: "date"
                          },
                          model: {
                            value: _vm.search.value,
                            callback: function($$v) {
                              _vm.$set(_vm.search, "value", $$v)
                            },
                            expression: "search.value"
                          }
                        })
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "col-md-4 col col-lg-4 d-flex align-items-end"
                  },
                  [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-primary btn-sm",
                        attrs: { loading: _vm.loading },
                        on: { click: _vm.getData }
                      },
                      [
                        _vm._v(
                          "\n                                Buscar\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-success btn-sm",
                        attrs: { loading: _vm.loading },
                        on: { click: _vm.DataFoods }
                      },
                      [
                        _vm._v(
                          "\n                                Platos atentidos\n                            "
                        )
                      ]
                    )
                  ]
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "table-responsive" }, [
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
                      "current-change": _vm.getData,
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
              ),
              _vm._v(" "),
              _c(
                "table",
                {
                  directives: [
                    {
                      name: "loading",
                      rawName: "v-loading",
                      value: _vm.loading,
                      expression: "loading"
                    }
                  ],
                  staticClass: "table"
                },
                [
                  _vm._m(2),
                  _vm._v(" "),
                  _c(
                    "tbody",
                    _vm._l(_vm.records, function(row, index) {
                      return _c(
                        "tr",
                        {
                          key: index,
                          class: {
                            "bg bg-dark": row.status_orden_id === "1",
                            "bg bg-secondary": row.status_orden_id === "2",
                            "bg bg-warning": row.status_orden_id === "3",
                            "bg-success": row.status_orden_id === "4",
                            "bg bg-danger": row.status_orden_id === "5"
                          }
                        },
                        [
                          _c("td", { staticClass: "text-center" }, [
                            _vm._v(_vm._s(index + 1))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center" }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(row.id) +
                                "\n                                "
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center" }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(row.customer) +
                                "\n                                "
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center" }, [
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-sm btn-primary",
                                on: {
                                  click: function($event) {
                                    return _vm.viewItems(row)
                                  }
                                }
                              },
                              [_c("i", { staticClass: "fas fa-list" })]
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center" }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(row.document_type)
                            ),
                            _c("br"),
                            _vm._v(" "),
                            _c(
                              "span",
                              { staticClass: "badge rounded-pill  text-dark" },
                              [
                                _vm._v(
                                  "\n                                        " +
                                    _vm._s(row.document_number)
                                )
                              ]
                            ),
                            _c("br"),
                            _vm._v(" "),
                            row.status_orden_id == 4
                              ? _c(
                                  "button",
                                  {
                                    staticClass: "btn btn-sm btn-success",
                                    on: {
                                      click: function($event) {
                                        return _vm.viewFile(row)
                                      }
                                    }
                                  },
                                  [
                                    _c("i", { staticClass: "fas fa-file" }),
                                    _vm._v(
                                      "\n                                        Descargar\n                                    "
                                    )
                                  ]
                                )
                              : _vm._e()
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center" }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(row.status) +
                                "\n                                "
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "text-center" },
                            [
                              row.status_id == 1 || row.status_id == 2
                                ? _c(
                                    "el-button",
                                    {
                                      attrs: { type: "danger" },
                                      on: {
                                        click: function($event) {
                                          return _vm.anular_command(row.id)
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                        Anular"
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center" }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(_vm.total(row)) +
                                "\n                                "
                            )
                          ])
                        ]
                      )
                    }),
                    0
                  ),
                  _vm._v(" "),
                  _c("tr", [
                    _c(
                      "td",
                      { staticClass: "text-end", attrs: { colspan: "7" } },
                      [
                        _vm._v(
                          "\n                                Total de Nota de Venta\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _vm._v(
                        "\n                                " +
                          _vm._s(_vm.totals_notas.toFixed(2)) +
                          "\n                            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c(
                      "td",
                      { staticClass: "text-end", attrs: { colspan: "7" } },
                      [
                        _vm._v(
                          "\n                                Total de Boletas - Facturas\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _vm._v(
                        "\n                                " +
                          _vm._s(_vm.totals_facturas.toFixed(2)) +
                          "\n                            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c(
                      "td",
                      { staticClass: "text-end", attrs: { colspan: "7" } },
                      [_vm._v("Total")]
                    ),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _vm._v(
                        "\n                                " +
                          _vm._s(_vm.totals_efectivos.toFixed(2)) +
                          "\n                            "
                      )
                    ])
                  ])
                ]
              ),
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
                      "current-change": _vm.getData,
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
          ]),
          _vm._v(" "),
          _vm.currentRow
            ? _c("view-items", {
                attrs: { row: _vm.currentRow, showDialog: _vm.showDialog },
                on: {
                  "update:showDialog": function($event) {
                    _vm.showDialog = $event
                  },
                  "update:show-dialog": function($event) {
                    _vm.showDialog = $event
                  }
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _c("ListFood", {
            attrs: {
              showDialogFoods: _vm.showDialogFoods,
              listFoods: _vm.listFoods
            },
            on: {
              "update:showDialogFoods": function($event) {
                _vm.showDialogFoods = $event
              },
              "update:show-dialog-foods": function($event) {
                _vm.showDialogFoods = $event
              },
              "update:listFoods": function($event) {
                _vm.listFoods = $event
              },
              "update:list-foods": function($event) {
                _vm.listFoods = $event
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
    return _c("div", { staticClass: "container-fluid p-l-0 p-r-0" }, [
      _c("div", { staticClass: "page-header" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-sm-6" }, [
            _c("h6", [_c("span", [_vm._v("Lista de Ordenes atentidas")])]),
            _vm._v(" "),
            _c("ol", { staticClass: "breadcrumb" }, [
              _c("li", { staticClass: "breadcrumb-item" }, [
                _c("a", { attrs: { href: "/dashboard" } }, [
                  _vm._v("Dashboard")
                ])
              ]),
              _vm._v(" "),
              _c("li", { staticClass: "breadcrumb-item active" }, [
                _c("span", { staticClass: "text-muted" }, [
                  _vm._v("Lista de Ordenes atentidas")
                ])
              ])
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
    return _c("div", { staticClass: "card-header bg-primary" }, [
      _c("h6", { staticClass: "my-0 text-white" }, [
        _vm._v("Lista de Ordenes atentidas")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center" }, [_vm._v("#")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("N° de Comanda")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Cliente")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Detalle")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Documento")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Estado")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Acciones")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Total Pagado")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7645ebbd", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7645ebbd\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/index.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7645ebbd\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/ordens/index.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("4cef2b83", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7645ebbd\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./index.vue", function() {
     var newContent = require("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7645ebbd\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./index.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./node_modules/vue-style-loader/lib/addStylesClient.js":
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__("./node_modules/vue-style-loader/lib/listToStyles.js")

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ "./node_modules/vue-style-loader/lib/listToStyles.js":
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


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
>>>>>>> 9e668b2669ffac68d0bedbf4cb93000cf993617f
=======
webpackJsonp([21],{"8H/M":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["showDialog","row"],data:function(){return{total:0}},created:function(){this.getTotal()},methods:{open:function(){this.getTotal()},close:function(){this.$emit("update:showDialog",!1)},getTotal:function(){this.row.document&&(this.total=this.row.document.total),this.row.sale_note&&(this.total=this.row.sale_note.total)}}}},BEQ0:function(t,e,n){"use strict";var a=Object.getOwnPropertySymbols,s=Object.prototype.hasOwnProperty,r=Object.prototype.propertyIsEnumerable;t.exports=function(){try{if(!Object.assign)return!1;var t=new String("abc");if(t[5]="de","5"===Object.getOwnPropertyNames(t)[0])return!1;for(var e={},n=0;n<10;n++)e["_"+String.fromCharCode(n)]=n;if("0123456789"!==Object.getOwnPropertyNames(e).map(function(t){return e[t]}).join(""))return!1;var a={};return"abcdefghijklmnopqrst".split("").forEach(function(t){a[t]=t}),"abcdefghijklmnopqrst"===Object.keys(Object.assign({},a)).join("")}catch(t){return!1}}()?Object.assign:function(t,e){for(var n,o,i=function(t){if(null===t||void 0===t)throw new TypeError("Object.assign cannot be called with null or undefined");return Object(t)}(t),c=1;c<arguments.length;c++){for(var l in n=Object(arguments[c]))s.call(n,l)&&(i[l]=n[l]);if(a){o=a(n);for(var u=0;u<o.length;u++)r.call(n,o[u])&&(i[o[u]]=n[o[u]])}}return i}},Kjn5:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"row"},[n("el-dialog",{attrs:{title:"Platos Atendidos",visible:t.showDialogFoods,"before-close":t.closeDialog},on:{"update:visible":function(e){t.showDialogFoods=e}}},[n("span",[n("form",{attrs:{autocomplete:"off"},on:{submit:function(e){return e.preventDefault(),t.submit.apply(null,arguments)}}},[n("div",{staticClass:"form-body"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"row"},[n("div",{staticClass:"col-md-12"},[t.listFoods.length>0?[n("table",{staticClass:"table table-responsive"},[n("thead",[n("tr",[n("th",{staticClass:"text-center"},[t._v("Cantidad")]),t._v(" "),n("th",[t._v("Producto")])])]),t._v(" "),n("tbody",t._l(t.listFoods,function(e,a){return n("tr",{key:a},[n("td",{staticClass:"text-center"},[t._v(t._s(e.move_quantity))]),t._v(" "),n("td",[t._v(t._s(e.description))])])}),0)])]:[t._v("\n                                        No hay Productos\n                            ")]],2)])])])]),t._v(" "),n("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{on:{click:function(e){return t.closeDialog()}}},[t._v("Cerrar")])],1)])],1)])},staticRenderFns:[]}},LDRt:function(t,e,n){var a=n("VU/8")(n("8H/M"),n("jkq4"),!1,null,null,null);t.exports=a.exports},LuTv:function(t,e,n){var a=n("VU/8")(n("dAt/"),n("Kjn5"),!1,null,null,null);t.exports=a.exports},MFz4:function(t,e,n){var a=n("bzq8");"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);n("rjj0")("7c32884c",a,!0,{})},OAwv:function(t,e,n){"use strict";var a=n("rprB"),s=n("BEQ0");function r(t,e){return e.encode?e.strict?a(t):encodeURIComponent(t):t}e.extract=function(t){return t.split("?")[1]||""},e.parse=function(t,e){var n=function(t){var e;switch(t.arrayFormat){case"index":return function(t,n,a){e=/\[(\d*)\]$/.exec(t),t=t.replace(/\[\d*\]$/,""),e?(void 0===a[t]&&(a[t]={}),a[t][e[1]]=n):a[t]=n};case"bracket":return function(t,n,a){e=/(\[\])$/.exec(t),t=t.replace(/\[\]$/,""),e?void 0!==a[t]?a[t]=[].concat(a[t],n):a[t]=[n]:a[t]=n};default:return function(t,e,n){void 0!==n[t]?n[t]=[].concat(n[t],e):n[t]=e}}}(e=s({arrayFormat:"none"},e)),a=Object.create(null);return"string"!=typeof t?a:(t=t.trim().replace(/^(\?|#|&)/,""))?(t.split("&").forEach(function(t){var e=t.replace(/\+/g," ").split("="),s=e.shift(),r=e.length>0?e.join("="):void 0;r=void 0===r?null:decodeURIComponent(r),n(decodeURIComponent(s),r,a)}),Object.keys(a).sort().reduce(function(t,e){var n=a[e];return Boolean(n)&&"object"==typeof n&&!Array.isArray(n)?t[e]=function t(e){return Array.isArray(e)?e.sort():"object"==typeof e?t(Object.keys(e)).sort(function(t,e){return Number(t)-Number(e)}).map(function(t){return e[t]}):e}(n):t[e]=n,t},Object.create(null))):a},e.stringify=function(t,e){var n=function(t){switch(t.arrayFormat){case"index":return function(e,n,a){return null===n?[r(e,t),"[",a,"]"].join(""):[r(e,t),"[",r(a,t),"]=",r(n,t)].join("")};case"bracket":return function(e,n){return null===n?r(e,t):[r(e,t),"[]=",r(n,t)].join("")};default:return function(e,n){return null===n?r(e,t):[r(e,t),"=",r(n,t)].join("")}}}(e=s({encode:!0,strict:!0,arrayFormat:"none"},e));return t?Object.keys(t).sort().map(function(a){var s=t[a];if(void 0===s)return"";if(null===s)return r(a,e);if(Array.isArray(s)){var o=[];return s.slice().forEach(function(t){void 0!==t&&o.push(n(a,t,o.length))}),o.join("&")}return r(a,e)+"="+r(s,e)}).filter(function(t){return t.length>0}).join("&"):""}},"VG/v":function(t,e,n){var a=n("VU/8")(n("lpA3"),n("nVAT"),!1,function(t){n("MFz4")},"data-v-5495888b",null);t.exports=a.exports},bzq8:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".file1[data-v-5495888b]{visibility:hidden;position:absolute}",""])},"dAt/":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["showDialogFoods","listFoods"],data:function(){return{showDialog:!1,open_cash:!0,errors:{},resource:"restaurant/worker/cash",date_closed:moment().format("YYYY-MM-DD"),date_start:moment().format("YYYY-MM-DD"),month_start:moment().format("YYYY-MM"),final_balance:0,cash:null,loading:!1}},methods:{closeDialog:function(){this.$emit("update:showDialogFoods",!1)}}}},jkq4:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("el-dialog",{attrs:{visible:t.showDialog,title:"Detalle Orden N° "+t.row.id},on:{open:t.open,close:t.close}},[t._l(t.row.orden_items,function(e,a){return n("div",{key:a,staticClass:"row"},[n("div",{staticClass:"col-2 text-center"},[t._v("\n            "+t._s(e.quantity)+"\n        ")]),t._v(" "),n("div",{staticClass:"col-5 text-start"},[t._v("\n            "+t._s(e.food.description)+"\n        ")]),t._v(" "),n("div",{staticClass:"col-2 text-end"},[t._v("\n            "+t._s(e.food.price)+"\n        ")]),t._v(" "),n("div",{staticClass:"col-3 text-end"},[t._v("\n            "+t._s((e.food.price*e.quantity).toFixed(2))+"\n        ")])])}),t._v(" "),n("div",{staticClass:"row"},[n("hr")]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-9"}),t._v(" "),n("div",{staticClass:"col-3 text-end"},[t._v("S/ "+t._s(this.total))])])],2)},staticRenderFns:[]}},lpA3:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("En79"),s=n.n(a),r=n("OAwv"),o=n.n(r),i=n("LuTv"),c=n.n(i),l=n("mu74"),u=n("LDRt"),d=n.n(u),f=n("PJh5"),p=n.n(f);function v(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),n.push.apply(n,a)}return n}function g(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function m(t,e,n,a,s,r,o){try{var i=t[r](o),c=i.value}catch(t){return void n(t)}i.done?e(c):Promise.resolve(c).then(a,s)}function h(t){return function(){var e=this,n=arguments;return new Promise(function(a,s){var r=t.apply(e,n);function o(t){m(r,a,s,o,i,"next",t)}function i(t){m(r,a,s,o,i,"throw",t)}o(void 0)})}}e.default={components:{ViewItems:d.a,ListFood:c.a},mixins:[l.a],props:["configuration"],data:function(){return{allRecords:[],listFoods:{},columns:[{id:1,value:"id",label:"Número de orden"},{id:2,value:"date",label:"Fecha"},{id:3,value:"client",label:"Cliente (DNI / RUC)"}],search:{column:"date",value:p()().format("YYYY-MM-DD")},date_start:p()().format("YYYY-MM-DD"),loading:!1,showDialog:!1,resource:"ordens",currentRow:null,showImage:!1,currentRecord:null,currentImage:null,areas:[],pagination:{},statusTable:[],records:[],totals_notas:0,totals_facturas:0,totals_efectivos:0,showDialogFoods:!1}},created:function(){var t=this;this.$eventHub.$on("reloadData",function(){t.getData()}),this.getData()},methods:{viewItems:function(t){this.currentRow=t,this.showDialog=!0},anular_command:function(t){var e=this;this.anular_comanda("/restaurant/worker/destroyorden/".concat(t),t).then(function(){return e.$eventHub.$emit("reloadData")})},DataFoods:function(){var t=this;return h(s.a.mark(function e(){var n;return s.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$http.get("".concat(t.resource,"/listfoods/").concat(t.search.value));case 2:n=e.sent,t.listFoods=n.data,t.showDialogFoods=!0;case 5:case"end":return e.stop()}},e)}))()},viewFile:function(t){var e="";if(t.document){var n=t.document.external_id;e="/downloads/document/pdf/".concat(n)}if(t.sale_note){var a=t.sale_note.external_id;e="/sale-notes/print/".concat(a,"/a4")}window.open(e,"_blank")},total:function(t){return t.document?t.document.total:t.sale_note?t.sale_note.total:0},getQueryParameters:function(){return o.a.stringify(function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?v(Object(n),!0).forEach(function(e){g(t,e,n[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):v(Object(n)).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))})}return t}({page:this.pagination.current_page,limit:this.limit},this.search))},reset:function(){this.search.value=""},Totals:function(){var t=_.filter(this.records,{document_type_id:"01"}),e=_.filter(this.records,{document_type_id:"80"});console.log("notas_venta",e),console.log("facturas",t),console.log("this.records",this.records),this.totals_facturas=_.sumBy(t,function(t){return parseFloat(t.total)}),this.totals_notas=_.sumBy(e,function(t){return parseFloat(t.total)}),this.totals_efectivos=_.round(this.totals_facturas+this.totals_notas,2)},getData:function(){var t=this;return h(s.a.mark(function e(){var n;return s.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.loading=!0,e.next=3,t.$http.get("".concat(t.resource,"/records?").concat(t.getQueryParameters()));case 3:n=e.sent,t.pagination=n.data.meta,t.pagination.per_page=parseInt(n.data.meta.per_page),t.records=n.data.data,t.loading=!1,t.Totals();case 9:case"end":return e.stop()}},e)}))()},clickDelete:function(t){var e=this;this.destroy("/".concat(this.resource,"/").concat(t)).then(function(){return e.$eventHub.$emit("reloadData")})}}}},mu74:function(t,e,n){"use strict";n.d(e,"a",function(){return a});var a={methods:{anular_comanda:function(t,e){var n=this;return new Promise(function(a){n.$confirm("¿Desea anular Comanda "+e+" seleccionada?","Eliminar",{confirmButtonText:"Eliminar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){n.$http.get(t).then(function(t){t.data.success?(n.$message.success(t.data.message),a()):(n.$message.error(t.data.message),a())}).catch(function(t){500===t.response.status?n.$message.error("Error al intentar eliminar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},destroy:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea eliminar el registro?","Eliminar",{confirmButtonText:"Eliminar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.delete(t).then(function(t){console.log(t),t.data.success?(e.$message.success(t.data.message),n()):(e.$message.error(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar eliminar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},anular:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea anular el registro?","Anular",{confirmButtonText:"Anular",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success&&(e.$message.success("Se anuló correctamente el registro"),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar anular"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},delete:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea eliminar permanentemente el registro?","Anular",{confirmButtonText:"Eliminar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success&&(e.$message.success("Se anuló correctamente el registro"),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar anular"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},disable:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea inhabilitar el registro?","Inhabilitar",{confirmButtonText:"Inhabilitar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success?(e.$message.success(t.data.message),n()):(e.$message.error(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar inhabilitar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},enable:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea habilitar el registro?","Habilitar",{confirmButtonText:"Habilitar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success?(e.$message.success(t.data.message),n()):(e.$message.error(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar habilitar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},voided:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea anular el registro?","Anular",{confirmButtonText:"Anular",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success&&(e.$message.success(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar anular"):console.log(t.response.data.message)})}).catch(function(t){console.log(t)})})},updateStateType:function(t){var e=this;return new Promise(function(n){e.$confirm("¿Desea modificar el estado del registro?","Modificar",{confirmButtonText:"Modificar",cancelButtonText:"Cancelar",type:"warning"}).then(function(){e.$http.get(t).then(function(t){t.data.success&&(e.$message.success(t.data.message),n())}).catch(function(t){500===t.response.status?e.$message.error("Error al intentar modificar"):console.log(t.response.data.message)})}).catch(function(t){console.log(t),e.$eventHub.$emit("reloadData")})})}}}},nVAT:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t._m(0),t._v(" "),n("div",{staticClass:"container-fluid p-l-0 p-r-0"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"card"},[t._m(1),t._v(" "),n("div",{staticClass:"card-body"},[n("div",{staticClass:"col-md-12 col-lg-12 col-xl-12 mb-2"},[n("div",{staticClass:"row"},[n("div",{staticClass:"col-md-4 col col-lg-4"},[n("label",{staticClass:"control-label"},[t._v("Buscar por")]),t._v(" "),n("el-select",{key:1,on:{change:t.reset},model:{value:t.search.column,callback:function(e){t.$set(t.search,"column",e)},expression:"search.column"}},t._l(t.columns,function(t,e){return n("el-option",{key:e,attrs:{label:t.label,value:t.value}})}),1)],1),t._v(" "),"date"!==t.search.column?n("div",{staticClass:"col-md-4 col col-lg-4 d-flex align-items-end"},[n("el-input",{attrs:{placeholder:"orden"==t.search.column?"N° de orden":"Nombre / N° documento del cliente"},model:{value:t.search.value,callback:function(e){t.$set(t.search,"value",e)},expression:"search.value"}},[n("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1):t._e(),t._v(" "),"date"==t.search.column?n("div",{staticClass:"col-md-4 col col-lg-4 d-flex align-items-end"},[n("el-date-picker",{staticClass:"w-100",attrs:{format:"d/MM/yy","value-format":"yyyy-MM-dd",type:"date"},model:{value:t.search.value,callback:function(e){t.$set(t.search,"value",e)},expression:"search.value"}})],1):t._e(),t._v(" "),n("div",{staticClass:"col-md-4 col col-lg-4 d-flex align-items-end"},[n("button",{staticClass:"btn btn-primary btn-sm",attrs:{loading:t.loading},on:{click:t.getData}},[t._v("\n                                Buscar\n                            ")]),t._v(" "),n("button",{staticClass:"btn btn-success btn-sm",attrs:{loading:t.loading},on:{click:t.DataFoods}},[t._v("\n                                Platos atentidos\n                            ")])])])]),t._v(" "),n("div",{staticClass:"table-responsive"},[n("div",[n("el-pagination",{attrs:{layout:"total, prev, pager, next",total:t.pagination.total,"current-page":t.pagination.current_page,"page-size":t.pagination.per_page},on:{"current-change":t.getData,"update:currentPage":function(e){return t.$set(t.pagination,"current_page",e)},"update:current-page":function(e){return t.$set(t.pagination,"current_page",e)}}})],1),t._v(" "),n("table",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"table"},[t._m(2),t._v(" "),n("tbody",t._l(t.records,function(e,a){return n("tr",{key:a,class:{"bg bg-dark":"1"===e.status_orden_id,"bg bg-secondary":"2"===e.status_orden_id,"bg bg-warning":"3"===e.status_orden_id,"bg-success":"4"===e.status_orden_id,"bg bg-danger":"5"===e.status_orden_id}},[n("td",{staticClass:"text-center"},[t._v(t._s(a+1))]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.id)+"\n                                ")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.customer)+"\n                                ")]),t._v(" "),n("td",{staticClass:"text-center"},[n("button",{staticClass:"btn btn-sm btn-primary",on:{click:function(n){return t.viewItems(e)}}},[n("i",{staticClass:"fas fa-list"})])]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.document_type)),n("br"),t._v(" "),n("span",{staticClass:"badge rounded-pill  text-dark"},[t._v("\n                                        "+t._s(e.document_number))]),n("br"),t._v(" "),4==e.status_orden_id?n("button",{staticClass:"btn btn-sm btn-success",on:{click:function(n){return t.viewFile(e)}}},[n("i",{staticClass:"fas fa-file"}),t._v("\n                                        Descargar\n                                    ")]):t._e()]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.status)+"\n                                ")]),t._v(" "),n("td",{staticClass:"text-center"},[1==e.status_id||2==e.status_id?n("el-button",{attrs:{type:"danger"},on:{click:function(n){return t.anular_command(e.id)}}},[t._v("\n                                        Anular")]):t._e()],1),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(t.total(e))+"\n                                ")])])}),0),t._v(" "),n("tr",[n("td",{staticClass:"text-end",attrs:{colspan:"7"}},[t._v("\n                                Total de Nota de Venta\n                            ")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                "+t._s(t.totals_notas.toFixed(2))+"\n                            ")])]),t._v(" "),n("tr",[n("td",{staticClass:"text-end",attrs:{colspan:"7"}},[t._v("\n                                Total de Boletas - Facturas\n                            ")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                "+t._s(t.totals_facturas.toFixed(2))+"\n                            ")])]),t._v(" "),n("tr",[n("td",{staticClass:"text-end",attrs:{colspan:"7"}},[t._v("Total")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                                "+t._s(t.totals_efectivos.toFixed(2))+"\n                            ")])])]),t._v(" "),n("div",[n("el-pagination",{attrs:{layout:"total, prev, pager, next",total:t.pagination.total,"current-page":t.pagination.current_page,"page-size":t.pagination.per_page},on:{"current-change":t.getData,"update:currentPage":function(e){return t.$set(t.pagination,"current_page",e)},"update:current-page":function(e){return t.$set(t.pagination,"current_page",e)}}})],1)])]),t._v(" "),t.currentRow?n("view-items",{attrs:{row:t.currentRow,showDialog:t.showDialog},on:{"update:showDialog":function(e){t.showDialog=e},"update:show-dialog":function(e){t.showDialog=e}}}):t._e(),t._v(" "),n("ListFood",{attrs:{showDialogFoods:t.showDialogFoods,listFoods:t.listFoods},on:{"update:showDialogFoods":function(e){t.showDialogFoods=e},"update:show-dialog-foods":function(e){t.showDialogFoods=e},"update:listFoods":function(e){t.listFoods=e},"update:list-foods":function(e){t.listFoods=e}}})],1)])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"container-fluid p-l-0 p-r-0"},[e("div",{staticClass:"page-header"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col-sm-6"},[e("h6",[e("span",[this._v("Lista de Ordenes atentidas")])]),this._v(" "),e("ol",{staticClass:"breadcrumb"},[e("li",{staticClass:"breadcrumb-item"},[e("a",{attrs:{href:"/dashboard"}},[this._v("Dashboard")])]),this._v(" "),e("li",{staticClass:"breadcrumb-item active"},[e("span",{staticClass:"text-muted"},[this._v("Lista de Ordenes atentidas")])])])])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"card-header bg-primary"},[e("h6",{staticClass:"my-0 text-white"},[this._v("Lista de Ordenes atentidas")])])},function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("thead",[n("tr",[n("th",{staticClass:"text-center"},[t._v("#")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("N° de Comanda")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Cliente")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Detalle")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Documento")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Estado")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Acciones")]),t._v(" "),n("th",{staticClass:"text-center"},[t._v("Total Pagado")])])])}]}},rjj0:function(t,e,n){var a="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!a)throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var s=n("tTVk"),r={},o=a&&(document.head||document.getElementsByTagName("head")[0]),i=null,c=0,l=!1,u=function(){},d=null,f="data-vue-ssr-id",p="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());function v(t){for(var e=0;e<t.length;e++){var n=t[e],a=r[n.id];if(a){a.refs++;for(var s=0;s<a.parts.length;s++)a.parts[s](n.parts[s]);for(;s<n.parts.length;s++)a.parts.push(m(n.parts[s]));a.parts.length>n.parts.length&&(a.parts.length=n.parts.length)}else{var o=[];for(s=0;s<n.parts.length;s++)o.push(m(n.parts[s]));r[n.id]={id:n.id,refs:1,parts:o}}}}function g(){var t=document.createElement("style");return t.type="text/css",o.appendChild(t),t}function m(t){var e,n,a=document.querySelector("style["+f+'~="'+t.id+'"]');if(a){if(l)return u;a.parentNode.removeChild(a)}if(p){var s=c++;a=i||(i=g()),e=b.bind(null,a,s,!1),n=b.bind(null,a,s,!0)}else a=g(),e=function(t,e){var n=e.css,a=e.media,s=e.sourceMap;a&&t.setAttribute("media",a);d.ssrId&&t.setAttribute(f,e.id);s&&(n+="\n/*# sourceURL="+s.sources[0]+" */",n+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(s))))+" */");if(t.styleSheet)t.styleSheet.cssText=n;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(n))}}.bind(null,a),n=function(){a.parentNode.removeChild(a)};return e(t),function(a){if(a){if(a.css===t.css&&a.media===t.media&&a.sourceMap===t.sourceMap)return;e(t=a)}else n()}}t.exports=function(t,e,n,a){l=n,d=a||{};var o=s(t,e);return v(o),function(e){for(var n=[],a=0;a<o.length;a++){var i=o[a];(c=r[i.id]).refs--,n.push(c)}e?v(o=s(t,e)):o=[];for(a=0;a<n.length;a++){var c;if(0===(c=n[a]).refs){for(var l=0;l<c.parts.length;l++)c.parts[l]();delete r[c.id]}}}};var h,_=(h=[],function(t,e){return h[t]=e,h.filter(Boolean).join("\n")});function b(t,e,n,a){var s=n?"":a.css;if(t.styleSheet)t.styleSheet.cssText=_(e,s);else{var r=document.createTextNode(s),o=t.childNodes;o[e]&&t.removeChild(o[e]),o.length?t.insertBefore(r,o[e]):t.appendChild(r)}}},rprB:function(t,e,n){"use strict";t.exports=function(t){return encodeURIComponent(t).replace(/[!'()*]/g,function(t){return"%"+t.charCodeAt(0).toString(16).toUpperCase()})}},tTVk:function(t,e){t.exports=function(t,e){for(var n=[],a={},s=0;s<e.length;s++){var r=e[s],o=r[0],i={id:t+":"+s,css:r[1],media:r[2],sourceMap:r[3]};a[o]?a[o].parts.push(i):n.push(a[o]={id:o,parts:[i]})}return n}}});
>>>>>>> copiaFeatureMaster
//# sourceMappingURL=21.js.map