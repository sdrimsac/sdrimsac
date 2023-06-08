<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
webpackJsonp([105],{"14+x":function(t,e,n){var a=n("a2ao");"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);n("rjj0")("63934cd5",a,!0,{})},a2ao:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".algunaClase .el-dialog .el-dialog__header .el-dialog__title{font-size:35px!important}.el-scrollbar{z-index:2000!important}.c-width{width:80px!important;padding:0!important;margin-right:0!important}.control-label,h4,h5,label{color:#000}",""])},gcqR:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("En79"),r=n.n(a),s=n("M4fF"),o=n.n(s);function i(t){return function(t){if(Array.isArray(t))return u(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||l(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function c(t,e){var n="undefined"!=typeof Symbol&&t[Symbol.iterator]||t["@@iterator"];if(!n){if(Array.isArray(t)||(n=l(t))||e&&t&&"number"==typeof t.length){n&&(t=n);var a=0,r=function(){};return{s:r,n:function(){return a>=t.length?{done:!0}:{done:!1,value:t[a++]}},e:function(t){throw t},f:r}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var s,o=!0,i=!1;return{s:function(){n=n.call(t)},n:function(){var t=n.next();return o=t.done,t},e:function(t){i=!0,s=t},f:function(){try{o||null==n.return||n.return()}finally{if(i)throw s}}}}function l(t,e){if(t){if("string"==typeof t)return u(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);return"Object"===n&&t.constructor&&(n=t.constructor.name),"Map"===n||"Set"===n?Array.from(t):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?u(t,e):void 0}}function u(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,a=new Array(e);n<e;n++)a[n]=t[n];return a}function d(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),n.push.apply(n,a)}return n}function m(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?d(Object(n),!0).forEach(function(e){_(t,e,n[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):d(Object(n)).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))})}return t}function p(t,e,n,a,r,s,o){try{var i=t[s](o),c=i.value}catch(t){return void n(t)}i.done?e(c):Promise.resolve(c).then(a,r)}function f(t){return function(){var e=this,n=arguments;return new Promise(function(a,r){var s=t.apply(e,n);function o(t){p(s,a,r,o,i,"next",t)}function i(t){p(s,a,r,o,i,"throw",t)}o(void 0)})}}function _(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}e.default={components:{RegisterForm:function(){return n.e(108).then(n.bind(null,"UGvb"))},ServiceForm:function(){return n.e(143).then(n.bind(null,"oByX"))},IncompleteForm:function(){return n.e(144).then(n.bind(null,"xLv5"))}},props:["record","title","customer_default","is_payment","member","configuration","desarrollador","personalWhatsapp","type","student","classroomId","plan","register","services","payable"],watch:{all_customers:function(t,e){this.customers=t.filter(function(t){return"88888888"!=t.number})}},data:function(){var t;return _(t={incomplete:!1,cash_id:null,documentId:null,registerId:null,showDialog:!1,series:[],affectationIgvTypes:[],establishments:null,methodPayment:[],currencyTypes:[],documentsType:[],variation:null,form:{college:!0,afectar_caja:!0,orden_id:null,customer_telephone:null,restaurant:!0,total_rounded:0,total_payment:0,establishment_id:null,series_id:null,prefix:null,number:"#",date_of_issue:moment().format("YYYY-MM-DD"),time_of_issue:moment().format("HH:mm:ss"),currency_type_id:"PEN",purchase_order:null,exchange_rate_sale:1,total_prepayment:0,total_charge:0,total_discount:0,total_exportation:0,total_free:0,total_taxed:0,total_unaffected:0,total_exonerated:0,total_igv:0,total_base_isc:0,total_isc:0,total_base_other_taxes:0,total_other_taxes:0,total_taxes:0,total_value:0,total:0,operation_type_id:"0101",date_of_due:moment().format("YYYY-MM-DD"),items:[],charges:[],discounts:[],attributes:[],guides:[],payments:[],hotel:{},additional_information:null,payment_condition_id:"01",printerOn:!1,actions:{format_pdf:"a4"},difference:0,enter_amount:0,method_pay:"Efectivo",commands_fisico:null,to_carry:!1,document_type_id:"01"},user:null,company:null,categories:[],observation:null,percentage_igv:18,started:!0,refCustomer:null,currentDocumentsType:[],time:null,splitPayments:[],splitProducts:[],isInterno:!1,showSplitPayment:!1,currencyTypeActive:{symbol:"S/ "},currentPayments:[],input_person:{},customer:null,value:null,paymentsValue:{"01":"Efectivo","02":"Culqui","03":"Yape","04":"PLIN","05":"TARJETA: IZYPAY","06":"TARJETA: NIUBIZ"},last_number:{},showDialogNewPerson:!1,loading:!1,enabled_discount:!1,discount_amount:0,loading_submit:!1,showDialogOptions:!1,showDialogMultiplePayment:!1,showDialogSaleNote:!1,showDialogNewCardBrand:!1,documentNewId:null,saleNotesNewId:null,resource_options:null,has_card:!1,method_payments:"01",number:null,resource:"pos",resource_documents:"documents",resource_payments:"document_payments",amount:0,printerOn:0,button_payment:!1,input_item:"",form_payment:{}},"series",[]),_(t,"cards_brand",[]),_(t,"cancel",!1),_(t,"form_cash_document",{}),_(t,"formRegister",null),_(t,"statusDocument",{}),_(t,"cashes",[]),_(t,"payment_method_types",[]),_(t,"last_date",null),_(t,"customers",[]),_(t,"datEmision",{disabledDate:function(t){return t.getTime()>moment()}}),_(t,"activeColo","black"),_(t,"socket",null),t},created:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getTables();case 2:return t.loading=!0,t.currentDocumentsType=t.documentsType,t.form.identity_document_type_id=t.currentDocumentsType[0].id,t.isInterno="03"==t.company.soap_type_id,e.next=8,t.initFormPayment();case 8:return e.next=10,t.getFormPosLocalStorage();case 10:qz.security.setCertificatePromise(function(e,n){t.$http.get("/api/qz/crt/override",{responseType:"text"}).then(function(t){e(t.data)}).catch(function(t){n(t.data)})}),qz.security.setSignaturePromise(function(e){return function(n,a){t.$http.post("/api/qz/signing",{request:e}).then(function(t){n(t.data)}).catch(function(t){a(t.data)})}}),t.setAmountCash(t.form.total),t.loading=!1,t.socketWhatsappConfig();case 15:case"end":return e.stop()}},e)}))()},methods:{changePrice:function(t){this.form.items=this.form.items.map(function(e){return m(m({},e),{},{sale_unit_price:t,total:t,total_base_igv:t,total_value:t,unit_price:t,unit_price_value:t,unit_value:t})})},getFile:function(t){var e=this;return f(r.a.mark(function n(){var a,s,o,i,c,l,u,d,m,p,f,_;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return a=t.documentId,s=t.documentTypeId,o=t.number,i=t.message,n.prev=1,n.next=4,e.$http.post("/whatsapp/get-file",{document_id:a,document_type_id:s});case 4:c=n.sent,l=c.data,u=l.pdf,d=l.xml,m=l.name,p="Su comprobante de pago electrónico "+m+" de *"+e.company.name+"*, ha sido generado correctamente a través del facturador electrónico de *Sdrimsac Solutions*",i&&(p+="\n"+i),e.socket.emit("basicMessage",{message:p,sender:e.sender,number:"51".concat(o)}),e.socket.emit("sendFile",{file:u,name:"".concat(m,".pdf"),number:"51".concat(o),sender:e.sender}),d&&e.socket.emit("sendFile",{file:d,name:"".concat(m,".xml"),number:"51".concat(o),sender:e.sender}),n.next=19;break;case 13:n.prev=13,n.t0=n.catch(1),f="Ocurrió un error",n.t0.response&&(_=n.t0.response,f=404==_.status?"No se encontró la ruta":_.data.message),e.$toast.error(f),console.log(n.t0);case 19:return n.prev=19,n.finish(19);case 21:case"end":return n.stop()}},n,null,[[1,13,19,21]])}))()},socketWhatsappConfig:function(){var t=this,e=window.location.hostname,n="https://".concat(e);this.sender=e.replace(/https?\:\/\//,"").replace("/","").split(".").join("");try{this.socket=io.connect(this.$socketUrl)}catch(t){console.log(t)}this.socket.on("connected",function(e){var a=e.message;t.$toast.success(a),t.socket.emit("getStatus",n)}),this.socket.on("setStatus",function(e){var n=e.status,a=e.sender;n?(t.sender=a,t.$toast.success("Whatsapp Listo!")):(t.sender="sdrimsac",t.$toast.warning("Sesión iniciada con SDRIMSAC"))}),this.socket.on("MessageResponse",function(e){var n=e.success,a=e.message;n?t.$toast.success(a):t.$toast.error(a)})},updateCustomer:function(t){this.form.customer=t,this.form.customer_id=t.id},updateObservation:function(t){this.observation=t,this.$forceUpdate()},open:function(){var t=this;console.log(this.register),this.incomplete=!1,this.currentPayments=[],this.form.total=0,this.form.customer_telephone=null,this.form.enter_amount=void 0,this.form.difference=0,this.observation=null,this.documentId=null,this.registerId=null,setTimeout(function(){var e;if("service"==t.type)null===(e=t.$refs.service)||void 0===e||e.getTables();else if("register"==t.type){var n;null===(n=t.$refs.register)||void 0===n||n.getTables()}else{var a;null===(a=t.$refs.incomplete)||void 0===a||a.getTables()}},250),"incomplete"==this.type&&(this.form.items=this.services.map(function(t){return t.item.sale_unit_price=t.price,t.item.percentage_igv=18,t.item}),console.log(this.form))},createFormRegister:function(t){t.classroom_id=this.record.id,this.formRegister=t},createFormService:function(t){t.classroom_id=this.classroomId,this.formRegister=t},updateTotal:function(t){this.form.total=t},updateItems:function(t){var e=this;return f(r.a.mark(function n(){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return e.form.items=t,e.formatItems(),e.reCalculateTotal(),e.form.enter_amount=e.form.total,n.next=6,e.$refs.enter_amount.$el.getElementsByTa;case 6:return n.next=8,e.$refs.enter_amount.$el.getElementsByTagName("input")[0].select();case 8:case"end":return n.stop()}},n)}))()},getTables:function(){var t=this;return f(r.a.mark(function e(){var n,a,s,o,i,c,l,u,d,m,p,f;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,t.loading=!0,e.next=4,t.$http.get("registers/payment_tables");case 4:n=e.sent,a=n.data,s=a.affectation_igv_types,o=a.establishment,i=a.method_payment,c=a.currency_types,l=a.documents_type,u=a.series,d=a.user,m=a.company,p=a.categories,f=a.cashes,t.cashes=f,t.affectationIgvTypes=s,t.establishments=o,t.methodPayment=i,t.currencyTypes=c,t.series=u,t.documentsType=l,t.user=d,t.company=m,t.categories=p,t.form.user_id=t.user.id,t.form.establishment_id=t.establishments.id,e.next=24;break;case 20:e.prev=20,e.t0=e.catch(0),console.log(e.t0),t.$toast.error("Ocurrió un problema");case 24:return e.prev=24,t.loading=!1,e.finish(24);case 27:case"end":return e.stop()}},e,null,[[0,20,24,27]])}))()},existNumber:function(){var t=this.form.customer_telephone;return!!t.startsWith("9")&&(9==t.length&&!isNaN(Number(t)))},createClient:function(){this.value=null,this.form.document_type_id,this.form.customer_id=null,this.showDialogNewPerson=!0},reloadDataCustomers:function(t){var e=this;return f(r.a.mark(function n(){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:e.$http.get("/pos/table/customers").then(function(){var n=f(r.a.mark(function n(a){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,e.$emit("update:all_customers",a.data);case 2:e.value=t,e.form.customer_id=t,e.changeCustomer();case 5:case"end":return n.stop()}},n)}));return function(t){return n.apply(this,arguments)}}());case 1:case"end":return n.stop()}},n)}))()},totalItemSelected:function(t){var e=0;return t.forEach(function(t){e+=t.quantity*t.price}),o.a.round(e,2)},receivePayments:function(t){this.splitPayments=t},receiveProducts:function(t){this.splitProducts=t},removePayment:function(t){this.currentPayments=this.currentPayments.filter(function(e){return e.id!=t}),this.enterAmount()},addPayment:function(){var t=this.currentPayments.length+1,e=this.paymentsValue[this.method_payments];""==this.form.enter_amount||isNaN(this.form.enter_amount)||void 0==this.form.enter_amount||this.currentPayments.push({id:t,method_payment_id:this.method_payments,method:e,amount:this.form.enter_amount})},customerForm:function(t){this.form.customer_id=t?void 0:this.value,this.showDialogNewPerson=!0},add_customer:function(t){},reloadDataPersons:function(){},keyupCustomer:function(t){var e=this;this.time&&clearTimeout(this.time),this.time=setTimeout(f(r.a.mark(function t(){var n,a;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e.input_person.number=e.$refs.select_person.$el.getElementsByTagName("input")[0].value,t.next=3,e.$http("/restaurant/search_customers?value=".concat(e.input_person.number));case 3:n=t.sent,a=n.data.persons,e.customers=a.filter(function(t){return"88888888"!=t.number}),e.updateAllCustomers(e.customers);case 7:case"end":return t.stop()}},t)})),500)},updateAllCustomers:function(t){var e=this;return f(r.a.mark(function n(){var a,s,o,l,u,d;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:a=e.all_customers.map(function(t){return t.id}),s=[],o=c(t);try{for(u=function(){var t=l.value;void 0==a.find(function(e){return e==t.id})&&s.push(t)},o.s();!(l=o.n()).done;)u()}catch(t){o.e(t)}finally{o.f()}if(d=[].concat(i(e.all_customers),s),0==s.length){n.next=8;break}return n.next=8,e.$emit("update:all_customers",d);case 8:case"end":return n.stop()}},n)}))()},changeCustomer:function(){this.form.customer_id=this.value;var t=o.a.find(this.customers,{id:this.form.customer_id});null!=t&&(this.customer=t,"80"!=this.form.document_type_id&&("1"==t.identity_document_type_id||"4"==t.identity_document_type_id?this.form.document_type_id="03":this.form.document_type_id="01"),this.form.customer_telephone=t.phone,this.setLocalStorageIndex("customer",this.customer)),this.setSeries()},setLocalStorageIndex:function(t,e){localStorage.setItem(t,JSON.stringify(e))},getLastNumbersDocument:function(){var t=this;return f(r.a.mark(function e(){var n;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$http.post("".concat(t.resource,"/last_number_documents"),{series:t.all_series,ordenId:t.idOrden});case 2:200==(n=e.sent).status&&(t.last_number=n.data.result,t.refCustomer=n.data.customer,null!=t.refCustomer&&(t.refCustomer.description="".concat(t.refCustomer.number," - ").concat(t.refCustomer.name),t.customers=[t.refCustomer].concat(i(t.customers.filter(function(e){return e.id!=t.refCustomer.id&&"88888888"!=e.number}))),t.value=t.refCustomer.id));case 4:case"end":return e.stop()}},e)}))()},changeEnabledDiscount:function(){this.enabled_discount||(this.discount_amount=0,this.deleteDiscountGlobal(),this.reCalculateTotal())},teclasInit:function(){var t=this;document.onkeydown=function(e){var n=e.key;"F7"==n&&t.form.items.length}},date_of_issue:function(){var t=this;return f(r.a.mark(function e(){var n;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.customers=t.all_customers.filter(function(t){return"88888888"!=t.number}),t.customers=[].concat(i(t.customers.filter(function(e){return e.id!=t.customer_default.id})),[t.customer_default]),t.establishments.customer_id&&(t.value=t.establishments.customer_id,t.form.customer_id=t.establishments.customer_id),n={enter_amount:0,difference:0},e.next=6,t.$http.post("/efectivo",n);case 6:e.sent;case 7:case"end":return e.stop()}},e)}))()},Printer:function(t,e,n){var a=arguments,s=this;return f(r.a.mark(function o(){var i,c,l,u,d,m,p;return r.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(a.length>3&&void 0!==a[3]?a[3]:null,i=a.length>4&&void 0!==a[4]&&a[4],qz.security.setCertificatePromise(function(t,e){s.$http.get("/api/qz/crt/override",{responseType:"text"}).then(function(e){t(e.data)}).catch(function(t){e(t.data)})}),qz.security.setSignaturePromise(function(t){return function(e,n){s.$http.post("/api/qz/signing",{request:t}).then(function(t){e(t.data)}).catch(function(t){n(t.data)})}}),1!=s.printerOn){r.next=22;break}if(1!=i){r.next=14;break}if(c=qz.configs.create(t,{scaleContent:!1}),qz.websocket.isActive()){r.next=11;break}return r.next=11,qz.websocket.connect(c);case 11:for(l=[{type:"pdf",format:"file",data:e}],qz.print(c,l).catch(function(t){s.$toast.error(t.message)}),u=0;u<n;u++)qz.print(c,l).catch(function(t){s.$toast.error(t.message)});case 14:if(0!=i){r.next=22;break}if(d=qz.configs.create(t,{scaleContent:!1}),qz.websocket.isActive()){r.next=19;break}return r.next=19,qz.websocket.connect(d);case 19:for(m=[{type:"pdf",format:"file",data:e}],qz.print(d,m).catch(function(t){s.$toast.error(t.message)}),p=0;p<n;p++)qz.print(d,m).catch(function(t){s.$toast.error(t.message)});case 22:case"end":return r.stop()}},o)}))()},clickSendWhatsapp:function(t,e,n){var a=arguments,s=this;return f(r.a.mark(function o(){var i,c,l;return r.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(null==(i=a.length>3&&void 0!==a[3]?a[3]:{}).customer_telephone){r.next=23;break}return c={id:s.recordId,document_id:e,document_type_id:t,customer_telephone:i.customer_telephone,sender:"sdrimsac",mensaje:"Su comprobante de pago electrónico "+n+" de *"+s.company.name+"*, ha sido generado correctamente a través del facturador electrónico de *Sdrimsac Solutions*"},r.prev=3,s.loading=!0,r.next=7,s.$http.post("/whatsapp",c);case 7:if(1==(l=r.sent).data.success&&(s.$toast.success(l.data.message),s.loading=!1),!s.configuration.xml_whatsapp||"80"==t){r.next=15;break}return c.xml=!0,r.next=13,s.$http.post("/whatsapp",c);case 13:1==(l=r.sent).data.success&&(s.$toast.success(l.data.message),s.loading=!1);case 15:r.next=20;break;case 17:r.prev=17,r.t0=r.catch(3),console.log(r.t0," error");case 20:return r.prev=20,s.loading=!1,r.finish(20);case 23:case"end":return r.stop()}},o,null,[[3,17,20,23]])}))()},changeDateOfIssue:function(){var t=this;this.form.date_of_due=this.form.date_of_issue,moment(this.form.date_of_issue)<moment().day(-1)&&this.configuration.restrict_receipt_date?(this.$toast.error("No puede seleccionar una fecha menor a 6 días."),this.dateValid=!1):this.dateValid=!0,this.form.date_of_due=this.form.date_of_issue,this.searchExchangeRateByDate(this.form.date_of_issue).then(function(e){t.form.exchange_rate_sale=e}),this.form.exchange_rate_sale=1},NuevaVenta:function(){this.$parent.nueva_venta()},setInitialAmount:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.enter_amount=t.form.total,t.form.payments=[],e.next=4,t.$refs.enter_amount.$el.getElementsByTagName("input")[0].focus();case 4:return e.next=6,t.$refs.enter_amount.$el.getElementsByTagName("input")[0].select();case 6:case"end":return e.stop()}},e)}))()},inputDiscountAmount:function(){if(this.enabled_discount)if(this.discount_amount&&!isNaN(this.discount_amount)&&parseFloat(this.discount_amount)>0){if(this.discount_amount>=this.form.total)return this.$toast.error("El monto de descuento debe ser menor al total de venta");this.reCalculateTotal()}else this.deleteDiscountGlobal(),this.reCalculateTotal()},discountGlobal:function(){var t=parseFloat(this.discount_amount),e=parseFloat(this.form.total),n=parseFloat(t),a=o.a.round(n/e,4),r=o.a.find(this.form.discounts,{discount_type_id:"03"});if(t>0&&!r)this.form.total_discount=o.a.round(n,2),this.form.total=o.a.round(this.form.total-n,2),this.form.total_value=o.a.round(this.form.total/(1+this.percentage_igv/100),2),this.form.total_taxed=this.form.total_value,this.form.total_igv=o.a.round(this.form.total_value*(this.percentage_igv/100),2),this.form.total_taxes=this.form.total_igv,this.form.discounts.push({discount_type_id:"03",description:"Descuentos globales que no afectan la base imponible del IGV/IVAP",factor:a,amount:n,base:e});else{var s=this.form.discounts.indexOf(r);s>-1&&(this.form.total_discount=o.a.round(n,2),this.form.total=o.a.round(this.form.total-n,2),this.form.total_value=o.a.round(this.form.total/(1+this.percentage_igv/100),2),this.form.total_taxed=this.form.total_value,this.form.total_igv=o.a.round(this.form.total_value*(this.percentage_igv/100),2),this.form.total_taxes=this.form.total_igv,this.form.discounts[s].base=e,this.form.discounts[s].amount=n,this.form.discounts[s].factor=a)}},method_payment:function(t){this.form.payment_condition_id="01",this.form.method_pay=t,this.form.afectar_caja=!0},reCalculateTotal:function(){var t=0,e=0,n=0,a=0,r=0,s=0,i=0,c=0,l=0;this.form.items.forEach(function(o){parseFloat(o.total_discount),parseFloat(o.total_charge),"10"===o.affectation_igv_type_id&&(e+=parseFloat(o.total_value)),"20"===o.affectation_igv_type_id&&(n+=parseFloat(o.total_value)),"30"===o.affectation_igv_type_id&&(a+=parseFloat(o.total_value)),"40"===o.affectation_igv_type_id&&(t+=parseFloat(o.total_value)),["10","20","30","40"].indexOf(o.affectation_igv_type_id)<0&&(r+=parseFloat(o.total_value)),["10","20","30","40"].indexOf(o.affectation_igv_type_id)>-1&&(s+=parseFloat(o.total_igv),c+=parseFloat(o.total)),i+=parseFloat(o.total_value),l+=isNaN(parseFloat(o.total_plastic_bag_taxes))?0:parseFloat(o.total_plastic_bag_taxes)}),this.form.total_exportation=o.a.round(t,2),this.form.total_taxed=o.a.round(e,2),this.form.total_exonerated=o.a.round(n,2),this.form.total_unaffected=o.a.round(a,2),this.form.total_free=o.a.round(r,2),this.form.total_igv=o.a.round(s,2),this.form.total_value=o.a.round(i,2),this.form.total_taxes=o.a.round(s,2),this.form.total_plastic_bag_taxes=o.a.round(l,2),this.form.total=o.a.round(c,2)},deleteDiscountGlobal:function(){var t=o.a.find(this.form.discounts,{discount_type_id:"03"}),e=this.form.discounts.indexOf(t);e>-1&&(this.form.discounts.splice(e,1),this.form.total_discount=0)},getFormPosLocalStorage:function(){var t=localStorage.getItem("form_pos");(t=JSON.parse(t))&&(this.form.payments=t.payments)},clickAddPayment:function(){this.showDialogMultiplePayment=!0},reloadDataCardBrands:function(t){var e=this;this.$http.get("/".concat(this.resource,"/table/card_brands")).then(function(n){e.cards_brand=n.data,e.form_payment.card_brand_id=t,e.changePaymentMethodType()})},getDescriptionPaymentMethodType:function(t){var e=o.a.find(this.payment_method_types,{id:t});return e?e.description:""},changePaymentMethodType:function(){var t=o.a.find(this.payment_method_types,{id:this.form_payment.payment_method_type_id});this.has_card=t.has_card,this.form_payment.card_brand_id=t.has_card?this.form_payment.card_brand_id:null},addRow:function(t){this.form.payments=t;var e=0;this.form.payments.forEach(function(t){e+=parseFloat(t.payment)}),this.setAmount(e)},setAmount:function(t){this.form.enter_amount=t,this.amount=parseFloat(t),this.inputAmount(t)},setAmountCash:function(t){this.setAmount(t)},diferen:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:(parseFloat(t.form.enter_amount)||0)+t.totalPayments()-parseFloat(t.form.total);case 2:case"end":return e.stop()}},e)}))()},totalPayments:function(){if(0!=this.currentPayments.length){var t=0;return this.currentPayments.forEach(function(e){t+=parseFloat(e.amount)}),t}return 0},enterAmount:function(){var t=arguments,e=this;return f(r.a.mark(function n(){var a,s,o;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:a=t.length>0&&void 0!==t[0]?t[0]:0,e.amount=a,s=parseFloat(e.form.enter_amount)||0,o=s-parseFloat(e.form.total),e.form.difference=parseFloat(o),e.form.difference<0?e.form.difference=o:e.form.difference>=0&&(e.button_payment=!1,parseFloat(e.form.enter_amount),parseFloat(e.form.total));case 6:case"end":return n.stop()}},n)}))()},getLocalStoragePayment:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=localStorage.getItem(t);return(n=JSON.parse(n))||e},setLocalStoragePayment:function(t,e){return localStorage.setItem(t,JSON.stringify(e))},inputAmount:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.enterAmount(t),this.form.difference=this.form.enter_amount-this.form.total,isNaN(this.form.difference)?this.form.difference="-":this.form.difference>=0&&(this.button_payment=!1,this.form.difference=this.amount-this.form.total),this.$eventHub.$emit("eventSetFormPosLocalStorage",this.form)},lStoPayment:function(){this.setLocalStoragePayment("enter_amount",this.form.enter_amount),this.setLocalStoragePayment("amount",0==this.amount?this.form.total:this.amount),this.setLocalStoragePayment("difference",0==this.amount?this.form.total-this.amount:0)},initFormPayment:function(){this.form.difference=15,this.form_payment={id:null,date_of_payment:moment().format("YYYY-MM-DD"),payment_method_type_id:"01",reference:null,card_brand_id:null,document_id:null,sale_note_id:null,payment:this.form.total},this.form_cash_document={document_id:null,sale_note_id:null}},cleanLocalStoragePayment:function(){this.setLocalStoragePayment("form_pos",null),this.setLocalStoragePayment("amount",null),this.setLocalStoragePayment("enter_amount",null),this.setLocalStoragePayment("difference",null)},sleep:function(t){return new Promise(function(e){return setTimeout(e,t)})},passBoxes:function(t,e){var n=e.reduce(function(t,e){return t+e.amount},0)-t,a=!1;n<0&&(a=!0,n*=-1);var r=i(e);if(0!=n)for(var s=0;s<r.length;s++){var o=r[s];if(a?(o.amount+=n,n=0):o.amount-n>0&&(o.amount-=n,n=0),0==n)break}return r},sendPayment:function(t){var e=arguments,n=this;return f(r.a.mark(function t(){var a,s,o,i,c;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(a=e.length>1&&void 0!==e[1]?e[1]:null,n.cash_id){t.next=4;break}return n.$toast.error("Seleccione o abra una caja."),t.abrupt("return");case 4:if(s=!1,!((o=parseFloat(n.form.enter_amount)-parseFloat(n.form.total))<0)){t.next=16;break}return t.prev=7,t.next=10,n.$confirm("Hay un saldo por cobrar de ".concat(-1*o),"Saldo",{distinguishCancelAndClose:!0,confirmButtonText:"Pagar",cancelButtonText:"Cambiar cantidad"});case 10:s=!0,t.next=16;break;case 13:return t.prev=13,t.t0=t.catch(7),t.abrupt("return");case 16:if(s&&(n.incomplete=!0,i=isNaN(parseFloat(n.form.enter_amount))?0:parseFloat(n.form.enter_amount),n.changePrice(i),n.reCalculateTotal()),0!=n.form.total){t.next=20;break}return n.$toast.error("Monto inválido."),t.abrupt("return");case 20:if(n.form.total&&(n.form.cash_id=n.cash_id),a||(a=n.form),a.printerOn=1==n.printerOn,c=!0,"incomplete"==n.type){t.next=30;break}return t.next=27,n.sendRegister();case 27:c=t.sent,t.next=32;break;case 30:console.log("reg ",n.register),n.registerId=n.register.id;case 32:if(!c){t.next=39;break}return t.next=35,n.clickPayment(a);case 35:if(!t.sent){t.next=39;break}return t.next=39,n.sendCollegePayment();case 39:case"end":return t.stop()}},t,null,[[7,13]])}))()},sendCollegePayment:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,t.loading=!0,e.next=4,t.$http.post("payments",{document_id:t.documentId,register_id:t.registerId,months:"incomplete"==t.type?[]:t.formRegister.months,active:1,type:t.incomplete?"incomplete":"complete"});case 4:e.sent,t.$emit("getRecords"),e.next=11;break;case 8:e.prev=8,e.t0=e.catch(0),console.log(e.t0);case 11:return e.prev=11,t.loading=!1,e.finish(11);case 14:case"end":return e.stop()}},e,null,[[0,8,11,14]])}))()},sendRegister:function(){var t=this;return f(r.a.mark(function e(){var n,a;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(t.formRegister){e.next=3;break}return t.$toast.error("Seleccione un plan/estudiante"),e.abrupt("return",!1);case 3:return e.prev=3,t.loading=!0,e.next=7,t.$http.post("registers",t.formRegister);case 7:return n=e.sent,a=n.data.id,t.registerId=a,e.abrupt("return",!0);case 13:return e.prev=13,e.t0=e.catch(3),console.log(e.t0),t.$toast.error("Ocurrió un error"),e.abrupt("return",!1);case 18:return e.prev=18,t.loading=!1,e.finish(18);case 21:case"end":return e.stop()}},e,null,[[3,13,18,21]])}))()},formatItems:function(){var t=this;this.form.items=this.form.items.map(function(e){var n;return e.quantity=1,m(m({},e),{},(_(n={warehouse_id:null,item:e,item_id:e.id,unit_value:10==e.sale_affectation_igv_type_id?e.sale_unit_price/(1+t.percentage_igv/100):e.sale_unit_price,quantity:e.quantity,aux_quantity:e.quantity,total_base_igv:10==e.sale_affectation_igv_type_id?e.sale_unit_price*e.quantity/(1+t.percentage_igv/100):e.sale_unit_price*e.quantity,percentage_igv:t.percentage_igv,total_igv:10==e.sale_affectation_igv_type_id?e.sale_unit_price*e.quantity/(1+t.percentage_igv/100)*(t.percentage_igv/100):0,total_base_isc:0,percentage_isc:0,total_isc:0,total_base_other_taxes:0,percentage_other_taxes:0,total_other_taxes:0,total_taxes:10==e.sale_affectation_igv_type_id?e.sale_unit_price*e.quantity/(1+t.percentage_igv/100)*(t.percentage_igv/100):0,total_value:10==e.sale_affectation_igv_type_id?e.sale_unit_price*e.quantity/(1+t.percentage_igv/100):e.quantity*e.sale_unit_price,total_charge:0,total_discount:0,total:e.sale_unit_price*e.quantity,price_type_id:"01",unit_price:e.sale_unit_price,unit_price_value:e.sale_unit_price,has_igv:e.has_igv,affectation_igv_type_id:e.sale_affectation_igv_type_id},"unit_price",e.sale_unit_price),_(n,"presentation",null),_(n,"charges",[]),_(n,"discounts",[]),_(n,"attributes",[]),_(n,"affectation_igv_type",e.sale_affectation_igv_type_id),n))})},clickPayment:function(t){var e=this;return f(r.a.mark(function n(){var a,s,o,i,c;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(e.form.cash_id){n.next=3;break}return e.$toast.error("Seleccione o abra una caja."),n.abrupt("return");case 3:if("1"==(a=t.customer).identity_document_type_id?t.document_type_id="03":t.document_type_id="01",s=e.series.find(function(e){return e.document_type_id==t.document_type_id}),e.form.series_id=s.id,null==t.customer_telephone){n.next=11;break}if(e.existNumber()){n.next=11;break}return e.$toast.error("Número para envío whatsapp inválido"),n.abrupt("return");case 11:if(null!=t.customer_id&&""!=t.customer_id){n.next=13;break}return n.abrupt("return",e.$toast.error("Elija un cliente"));case 13:if("1"!=a.identity_document_type_id||"01"!=t.document_type_id){n.next=15;break}return n.abrupt("return",e.$toast.error("No puede emitir Factura con DNI"));case 15:if(t.series_id){n.next=17;break}return n.abrupt("return",e.$toast.warning("El establecimiento no tiene series disponibles para el comprobante"));case 17:return t.prefix=null,e.resource_documents="documents",e.resource_payments="document_payments",e.resource_options=e.resource_documents,t.advances=0,t.total_advances=0,t.total_payment=t.total,t.payments=[{payment_method_type_id:"01",date_of_payment:t.date_of_issue,payment:t.total}],t.boxes=e.currentPayments,e.addPayment(),e.form.observation=e.observation,e.loading_submit=!0,n.prev=29,t.orden_id=null,n.next=33,e.$http.post("/".concat(e.resource_documents),t);case 33:if(200!=(o=n.sent).status){n.next=58;break}if(1!=o.data.success){n.next=56;break}if(e.documentId=o.data.data.id,e.form_cash_document.document_id=o.data.data.id,e.number=o.data.data.number,e.documentNewId=o.data.data.id,1!=o.data.success){n.next=55;break}if(!e.form.customer_telephone){n.next=53;break}if(!e.personalWhatsapp){n.next=47;break}return n.next=45,e.getFile({documentId:e.documentNewId,documentTypeId:t.document_type_id,number:e.form.customer_telephone,message:e.form.message});case 45:n.next=49;break;case 47:return n.next=49,e.clickSendWhatsapp(t.document_type_id,e.documentNewId,e.number,t);case 49:e.loading_submit=!1,e.back(!0),n.next=55;break;case 53:e.loading_submit=!1,e.back(!0);case 55:return n.abrupt("return",!0);case 56:n.next=61;break;case 58:return e.loading_submit=!0,e.$alert("<strong>Ocurrio un error </strong>"+o.statusCode+"<br>"+e.resource_documents,"HTML String",{dangerouslyUseHTMLString:!0}),n.abrupt("return",!1);case 61:n.next=70;break;case 63:return n.prev=63,n.t0=n.catch(29),console.log(n.t0),i=n.t0.response,c=i.data.message,e.$toast.error(c||"Ocurrió un error"),n.abrupt("return",!1);case 70:return n.prev=70,e.loading_submit=!1,n.finish(70);case 73:case"end":return n.stop()}},n,null,[[29,63,70,73]])}))()},clickPrintPos:function(t,e){var n=arguments,a=this;return f(r.a.mark(function s(){var o,i;return r.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(n.length>2&&void 0!==n[2]?n[2]:null,r.prev=1,o=qz.configs.create(t,{legacy:!0},{scaleContent:!1}),qz.websocket.isActive()){r.next=6;break}return r.next=6,qz.websocket.connect(o);case 6:i=[{type:"pdf",format:"file",data:e}],qz.print(o,i).catch(function(t){a.$toast.error(t.message)}),r.next=13;break;case 10:r.prev=10,r.t0=r.catch(1),a.$toast.error(r.t0.message);case 13:case"end":return r.stop()}},s,null,[[1,10]])}))()},saveCashDocument:function(){var t=this;this.$http.post("/cash/cash_document",this.form_cash_document).then(function(e){e.data.success||t.$toast.error(e.data.message)}).catch(function(t){console.log(t)})},savePaymentMethod:function(){var t=this;this.$http.post("/".concat(this.resource_payments),this.form_payment).then(function(e){e.data.success||t.$toast.error(e.data.message)}).catch(function(e){422===e.response.status?t.records[index].errors=e.response.data:console.log(e)})},clickCancel:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.loading_submit=!0,t.loading_submit=!1,t.cleanLocalStoragePayment(),t.$eventHub.$emit("cancelSale");case 4:case"end":return e.stop()}},e)}))()},back:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0];"service"==this.type?this.$refs.service.initForm():"register"==this.type?this.$refs.register.initForm():"incomplete"==this.type?this.$refs.incomplete.initForm():console.log("object"),this.splitPayments=[],t||this.$emit("openDrawer"),this.$emit("update:is_payment",!1)},initLStoPayment:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getLocalStoragePayment("amount",t.form.total);case 2:return t.amount=e.sent,e.next=5,t.getLocalStoragePayment("enter_amount",t.form.total);case 5:return t.form.enter_amount=e.sent,e.next=8,t.getLocalStoragePayment("difference",t.form.total-t.form.enter_amount);case 8:t.form.difference=e.sent;case 9:case"end":return e.stop()}},e)}))()},checkCustomers:function(){return"01"==this.form.document_type_id?this.customers.some(function(t){return"6"==t.identity_document_type_id}):this.customers.some(function(t){return"1"==t.identity_document_type_id})},setSeries:function(){var t=this;this.form.series_id=null,this.series=o.a.filter(this.all_series,{document_type_id:this.form.document_type_id}),this.series.forEach(function(e){e.full_number="".concat(e.number,"-").concat(t.last_number[e.number]||"1")||e.number}),this.form.series_id=this.series.length>0?this.series[0].id:null},filterSeries:function(){if(!this.checkCustomers()&&!this.started){var t="DNI";return"01"==this.form.document_type_id?(t="RUC",this.form.document_type_id="03"):this.form.document_type_id="01",this.$toast.warning("Digite el número de ".concat(t)),void this.setSeries()}this.started=!1,"01"==this.form.document_type_id?(this.currentDocumentsType=i(this.documentsType.filter(function(t){return"RUC"==t.description})),this.form.identity_document_type_id=this.currentDocumentsType[0].id):this.currentDocumentsType=this.documentsType,this.setSeries()}}}},rjj0:function(t,e,n){var a="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!a)throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var r=n("tTVk"),s={},o=a&&(document.head||document.getElementsByTagName("head")[0]),i=null,c=0,l=!1,u=function(){},d=null,m="data-vue-ssr-id",p="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());function f(t){for(var e=0;e<t.length;e++){var n=t[e],a=s[n.id];if(a){a.refs++;for(var r=0;r<a.parts.length;r++)a.parts[r](n.parts[r]);for(;r<n.parts.length;r++)a.parts.push(h(n.parts[r]));a.parts.length>n.parts.length&&(a.parts.length=n.parts.length)}else{var o=[];for(r=0;r<n.parts.length;r++)o.push(h(n.parts[r]));s[n.id]={id:n.id,refs:1,parts:o}}}}function _(){var t=document.createElement("style");return t.type="text/css",o.appendChild(t),t}function h(t){var e,n,a=document.querySelector("style["+m+'~="'+t.id+'"]');if(a){if(l)return u;a.parentNode.removeChild(a)}if(p){var r=c++;a=i||(i=_()),e=y.bind(null,a,r,!1),n=y.bind(null,a,r,!0)}else a=_(),e=function(t,e){var n=e.css,a=e.media,r=e.sourceMap;a&&t.setAttribute("media",a);d.ssrId&&t.setAttribute(m,e.id);r&&(n+="\n/*# sourceURL="+r.sources[0]+" */",n+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(r))))+" */");if(t.styleSheet)t.styleSheet.cssText=n;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(n))}}.bind(null,a),n=function(){a.parentNode.removeChild(a)};return e(t),function(a){if(a){if(a.css===t.css&&a.media===t.media&&a.sourceMap===t.sourceMap)return;e(t=a)}else n()}}t.exports=function(t,e,n,a){l=n,d=a||{};var o=r(t,e);return f(o),function(e){for(var n=[],a=0;a<o.length;a++){var i=o[a];(c=s[i.id]).refs--,n.push(c)}e?f(o=r(t,e)):o=[];for(a=0;a<n.length;a++){var c;if(0===(c=n[a]).refs){for(var l=0;l<c.parts.length;l++)c.parts[l]();delete s[c.id]}}}};var v,g=(v=[],function(t,e){return v[t]=e,v.filter(Boolean).join("\n")});function y(t,e,n,a){var r=n?"":a.css;if(t.styleSheet)t.styleSheet.cssText=g(e,r);else{var s=document.createTextNode(r),o=t.childNodes;o[e]&&t.removeChild(o[e]),o.length?t.insertBefore(s,o[e]):t.appendChild(s)}}},tTVk:function(t,e){t.exports=function(t,e){for(var n=[],a={},r=0;r<e.length;r++){var s=e[r],o=s[0],i={id:t+":"+r,css:s[1],media:s[2],sourceMap:s[3]};a[o]?a[o].parts.push(i):n.push(a[o]={id:o,parts:[i]})}return n}},wevU:function(t,e,n){var a=n("VU/8")(n("gcqR"),n("x3s1"),!1,function(t){n("14+x")},null,null);t.exports=a.exports},x3s1:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("el-dialog",{staticClass:"algunaClase",attrs:{visible:t.is_payment,"close-on-click-modal":!1,"close-on-press-escape":!1,"modal-append-to-body":!0,"show-close":!1,"append-to-body":!0,width:"770px",top:"2vh",title:t.title||"MODULO DE CAJA"},on:{open:t.open}},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"mb-0"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading_submit,expression:"loading_submit"}],staticClass:"pt-1"},[n("div",{staticClass:"row"},["incomplete"==t.type?[n("incomplete-form",{ref:"incomplete",attrs:{payable:t.payable,services:t.services,plan:t.plan,member:t.member},on:{"update:payable":function(e){t.payable=e},updateItems:t.updateItems,updateObservation:t.updateObservation,updateCustomer:t.updateCustomer,"update:member":function(e){t.member=e}}})]:t._e(),t._v(" "),"service"==t.type?[n("service-form",{ref:"service",attrs:{member:t.member},on:{updateTotal:t.updateTotal,updateItems:t.updateItems,updateObservation:t.updateObservation,updateCustomer:t.updateCustomer,createFormRegister:t.createFormService,"update:member":function(e){t.member=e}}})]:t._e(),t._v(" "),"register"==t.type?[n("register-form",{ref:"register",attrs:{record:t.record},on:{updateTotal:t.updateTotal,updateItems:t.updateItems,updateObservation:t.updateObservation,updateCustomer:t.updateCustomer,createFormRegister:t.createFormRegister}})]:t._e()],2),t._v(" "),n("div",{staticClass:"row pt-2"},[n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:"mb-2"},[n("div",{staticClass:"card bg-light"},[n("div",{staticClass:"row col-lg-6 col-xl-12"},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"control-label"},[t._v("Observaciones")]),t._v(" "),n("el-input",{attrs:{type:"textarea",rows:2},model:{value:t.observation,callback:function(e){t.observation=e},expression:"observation"}})],1)])])])]),t._v(" "),n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:"mb-2"},[n("div",{staticClass:"text-center text-dark card bg-light"},[n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:"align-items-start"},[n("label",{staticClass:"control-label"},[t._v("Medios de Pago")]),t._v(" "),n("label",{staticClass:"text-primary control-label",attrs:{role:"button"}})]),t._v(" "),n("div",{staticClass:"radio-tile-group2 flex-wrap"},[n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"cash",type:"radio",name:"method_payment",value:"01"},domProps:{checked:t._q(t.method_payments,"01")},on:{change:[function(e){t.method_payments="01"},function(e){return t.method_payment("Efectivo")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/botonEfectivo.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon walk-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"cash"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"culqui",type:"radio",name:"method_payment",value:"02"},domProps:{checked:t._q(t.method_payments,"02")},on:{change:[function(e){t.method_payments="02"},function(e){return t.method_payment("Culqui")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/CulquiIcon.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"plin",type:"radio",name:"method_payment",value:"05"},domProps:{checked:t._q(t.method_payments,"05")},on:{change:[function(e){t.method_payments="05"},function(e){return t.method_payment("TARJETA: IZYPAY")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/botonIzipay.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"plin",type:"radio",name:"method_payment",value:"06"},domProps:{checked:t._q(t.method_payments,"06")},on:{change:[function(e){t.method_payments="06"},function(e){return t.method_payment("TARJETA: NIUBIZ")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/botonNiubiz.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"yape",type:"radio",name:"method_payment",value:"03"},domProps:{checked:t._q(t.method_payments,"03")},on:{change:[function(e){t.method_payments="03"},function(e){return t.method_payment("Yape")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"plin",type:"radio",name:"method_payment",value:"04"},domProps:{checked:t._q(t.method_payments,"04")},on:{change:[function(e){t.method_payments="04"},function(e){return t.method_payment("PLIN")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/plin-logo-0C4106153C-seeklogo.com.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])])]),t._v(" "),n("div",{staticClass:"row col-md-12"},[n("div",{staticClass:"row"},[n("label",{staticClass:"control-label text-center"},[t._v("Emision de\n                                                comprobante")])]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-2 col-md-5 col-xl-6"},[n("label",{staticClass:"\n                          control-label\n                          text-left\n                          d-flex\n                          align-items-start\n                          justify-content-start\n                        "},[t._v("\n                                                    Ingrese Nro Celular\n                                                ")]),t._v(" "),n("el-input",{model:{value:t.form.customer_telephone,callback:function(e){t.$set(t.form,"customer_telephone",e)},expression:"\n                                                        form.customer_telephone\n                                                    "}},[n("template",{slot:"prepend"},[n("i",{staticClass:"fab fa-whatsapp fa-2x"})])],2)],1),t._v(" "),n("div",{staticClass:"radio-tile-group2 col-lg-6 col-xl-6 d",staticStyle:{"padding-top":"12px"}},[n("div",{staticClass:"input-container2 border rounded-sm col-lg-3"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.printerOn,expression:"printerOn"}],staticClass:"radio-button2",attrs:{id:"imprimir",type:"radio",name:"imprimir",value:"1"},domProps:{checked:t._q(t.printerOn,"1")},on:{change:function(e){t.printerOn="1"}}}),t._v(" "),n("div",{staticClass:"radio-tile2"},[n("div",{staticClass:"icon walk-icon"},[n("i",{staticClass:"fa fa-print"})]),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"cash"}},[t._v("Imprimir")])])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm col-lg-3"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.printerOn,expression:"printerOn"}],staticClass:"radio-button2",attrs:{id:"noimprimir",type:"radio",name:"noimprimir",value:"0"},domProps:{checked:t._q(t.printerOn,"0")},on:{change:function(e){t.printerOn="0"}}}),t._v(" "),n("div",{staticClass:"radio-tile2"},[n("div",{staticClass:"icon bike-icon"},[n("i",{staticClass:"fa fa-print"})]),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}},[t._v("No\n                                                            Imprimir")])])])])])]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-8 d-flex flex-row align-items-end"}),t._v(" "),n("div",{staticClass:"d-flex flex-column"})]),t._v(" "),n("div",{staticClass:"row d-flex justify-content-start"},[0!=t.currentPayments.length?n("table",{staticClass:"table"},[n("thead",[n("tr",[n("th",{staticClass:"text-left",attrs:{colspan:"4"}},[t._v("\n                                                        Pagos\n                                                    ")])])]),t._v(" "),n("tbody",t._l(t.currentPayments,function(e,a){return n("tr",{key:a},[n("td",[t._v(t._s(a+1))]),t._v(" "),n("td",[t._v("\n                                                        "+t._s(e.method)+"\n                                                    ")]),t._v(" "),n("td",[n("strong",[t._v(t._s(e.amount))])]),t._v(" "),n("td",[n("label",{staticClass:"text-danger",attrs:{for:"",role:"button"},on:{click:function(n){return t.removePayment(e.id)}}},[n("i",{staticClass:"fa fa-trash"})])])])}),0)]):t._e()])]),t._v(" "),n("div",{staticClass:"card bg-light col-lg-12"})])])]),t._v(" "),n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:"mb-2"},[n("div",{staticClass:"card bg-light"},[n("div",{staticClass:"row"},[n("div",{staticClass:"col-xl-4",class:{"has-danger":t.form.difference<0},staticStyle:{"margin-top":"10px","padding-top":"5px"}},[n("label",{staticClass:"control-label h1"},[t._v("Total a cobrar: ")]),n("br"),t._v(" "),n("span",{staticClass:"\n                      control-label\n                      font-weight-semibold\n                      text-center\n                      h3\n                    "},[t._v("\n                                            S/ "+t._s(" "+t.form.total)+"\n                                        ")])]),t._v(" "),"01"==t.form_payment.payment_method_type_id?n("div",{staticClass:"col-xl-8"},[n("div",{staticClass:"\n                      btn-group btn-group-square\n                      m-0\n                      flex-wrap\n                      justify-content-around\n                    ",staticStyle:{"padding-top":"12px"},attrs:{role:"group"}},[n("label",{staticClass:"control-label"},[t._v("Ingrese monto")]),t._v(" "),n("div",{staticClass:"row col-12"},[n("div",{staticClass:"col-2 col-md-2 col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(10)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"10\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2 col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(20)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"20\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2 col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(50)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"50\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2 col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(100)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"100\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2 col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(200)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"200\n                                                    ")])])]),t._v(" "),n("div",{staticClass:"row col-xl-12 col-12"},[n("div",{staticClass:"col-xl-6 col-3"},[n("el-input",{ref:"enter_amount",attrs:{id:"inputTotal",disabled:0==t.form.total},on:{blur:function(e){return t.diferen()},input:function(e){return t.enterAmount()}},nativeOn:{keyup:function(e){if(!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter"))return null;t.sendPayment(),t.inputAmount(t.form.enter_amount)}},model:{value:t.form.enter_amount,callback:function(e){t.$set(t.form,"enter_amount",e)},expression:"\n                                                            form.enter_amount\n                                                        "}},[n("template",{slot:"prepend"},[t._v(t._s(t.currencyTypeActive.symbol)+"\n                                                        ")])],2)],1),t._v(" "),n("div",{staticClass:"m-2 col-xl-2 col-2"},[n("el-button",{attrs:{type:"primary"},on:{click:t.addPayment}},[t._v("Agregar")])],1)])])]):t._e(),t._v(" "),n("div",{staticClass:"row col-xl-4"},[n("div",{staticClass:"col-xl-5",staticStyle:{"margin-bottom":"10px"}})])]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-md-6 col-12"}),t._v(" "),n("div",{staticClass:"col-md-6 col-12 d-flex justify-content-end"},[n("div",{staticClass:"form-group d-flex flex-row align-items-end",class:{"has-danger":t.form.difference<0}},[n("label",{staticClass:"control-label display-4",domProps:{textContent:t._s(t.form.difference<0?"A cuenta: ":"Vuelto: ")}}),t._v(" "),n("span",{staticClass:"\n                        control-label\n                        font-weight-semibold\n                        text-center\n                        display-3\n                      "},[t._v("\n                                                "+t._s(t.currencyTypeActive.symbol)+"\n                                                "+t._s(t.form.difference.toFixed(2))+"\n                                            ")])])])])])])])])]),t._v(" "),0!=t.splitPayments.length?n("div",{staticClass:"row m-1 p-2 bg-light rounded"},[n("span",{staticStyle:{"margin-bottom":"5px"}},[t._v("Pagos divididos")]),t._v(" "),n("div",{staticClass:"d-flex flex-wrap"},t._l(t.splitPayments,function(e,a){return n("div",{key:a,staticClass:"col-2"},[t._v("\n                        Pago "+t._s(a+1)+":\n                        "),n("strong",[t._v("S/. "+t._s(e.amount))])])}),0)]):t._e(),t._v(" "),0!=t.splitProducts.length?n("div",{staticClass:"row m-1 p-2 bg-light rounded"},[n("span",{staticStyle:{"margin-bottom":"5px"}},[t._v("Pagos divididos por producto")]),t._v(" "),n("div",{staticClass:"d-flex flex-wrap"},t._l(t.splitProducts,function(e,a){return n("div",{key:a,staticClass:"col-3 m-1"},[e.products&&e.products.length>0?n("table",{staticClass:"col-12"},[n("thead",[n("tr",{class:"bg-primary text-white border rounded-top",attrs:{role:"button"},on:{click:function(e){return t.selectAccount(a)}}},[n("th",{staticClass:"text-center",attrs:{colspan:"3"}},[n("b",[t._v(" CUENTA "+t._s(a+1)+" ")])])])]),t._v(" "),e.products&&e.products.length>0?n("tbody",{staticClass:"border rounded-top"},[t._l(e.products,function(e,a){return n("tr",{key:a},[n("td",[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            "+t._s(e.quantity)+"\n                                        ")])]),t._v(" "),n("td",[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            "+t._s(e.description)+"\n                                        ")])]),t._v(" "),n("td",{staticStyle:{"text-align":"right"}},[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            "+t._s(e.price*e.quantity)+"\n                                        ")])])])}),t._v(" "),n("tr",[n("td",{staticClass:"text-muted text-small",staticStyle:{"text-align":"right"},attrs:{colspan:"2"}},[n("b",[t._v(" Total")])]),t._v(" "),n("td",{staticClass:"text-muted text-small"},[t._v("\n                                        S/.\n                                        "+t._s(t.totalItemSelected(e.products))+"\n                                    ")])])],2):n("tbody",{staticClass:"border"},[n("tr",[n("td",{staticClass:"text-center",attrs:{colspan:"3"}},[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            Sin productos seleccionados\n                                        ")])])])])]):t._e()])}),0)]):t._e(),t._v(" "),n("div",{staticClass:"p-3"},[n("div",{staticClass:"row"},[n("div",{staticClass:"col-md-4 col-12"},[n("label",{staticClass:"label-control"},[t._v(" Elija Caja ")]),t._v(" "),n("el-select",{model:{value:t.cash_id,callback:function(e){t.cash_id=e},expression:"cash_id"}},t._l(t.cashes,function(t,e){return n("el-option",{key:e,attrs:{value:t.id,label:t.reference_number}})}),1)],1),t._v(" "),n("div",{staticClass:"col-md-6 col-12 d-flex align-items-end"},[n("div",{staticClass:"btn-group btn-group-square",attrs:{role:"group"}},[n("button",{staticClass:"btn btn-block btn-primary mr-3",attrs:{disabled:t.button_payment},on:{click:t.sendPayment}},[n("i",{staticClass:"fas fa-money-bill-alt"}),t._v("\n                                PAGAR\n                            ")]),t._v(" "),n("button",{staticClass:"btn btn-block btn-dark",on:{click:function(e){return t.back(!1)}}},[n("i",{staticClass:"fa fa-reply"}),t._v(" Cerrar\n                            ")])])])])])])])])},staticRenderFns:[]}}});
=======
webpackJsonp([105,114],{"9yJJ":function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"offcanvas offcanvas-end",attrs:{tabindex:"-1",id:"offcanvasRight2","aria-labelledby":"offcanvasRightLabel"}},[n("div",{staticClass:"offcanvas-header"},[n("h5",{attrs:{id:"offcanvasRightLabel"}},[n("p",{staticClass:"h4 txt-info p-10 txt-primary f-w-700"},[n("i",{staticClass:"icofont icofont-fork-and-knife"}),t._v(" "),n("a",{staticClass:"badge badge bg-dark text-white",attrs:{href:"javascript:void(0)"}},[t.localOrden.length>0&&t.localOrden.length<=9?[t._v("\n                        0"+t._s(t.localOrden.length)+"\n                    ")]:[t._v("\n                        "+t._s(t.localOrden.length)+"\n                    ")]],2),t._v("\n                Ordenes Pendiente\n            ")])]),t._v(" "),n("button",{staticClass:"btn-close text-reset",attrs:{type:"button","data-bs-dismiss":"offcanvas","aria-label":"Close"}})]),t._v(" "),n("div",{staticClass:"offcanvas-body"},[n("section",{staticClass:"scroll-section",attrs:{id:"checkboxes"}},[1==t.configuration.commands_fisico?n("div",{staticClass:"row align-items-start"},[n("div",{staticClass:"col-md-12"},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"control-label"},[t._v("Nº Comanda")]),t._v(" "),n("el-input",{attrs:{autofocus:""},on:{focus:function(e){return t.clear_command()}},nativeOn:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.sendOrden()}},model:{value:t.commands_fisico,callback:function(e){t.commands_fisico=e},expression:"commands_fisico"}})],1)])]):t._e(),t._v(" "),n("div",{staticClass:"d-flex justify-content-end mb-2"},[n("div",{staticClass:"btn-group mr-2",attrs:{role:"group","aria-label":"First group"}},[n("button",{staticClass:"btn btn-success",attrs:{type:"button",disabled:t.disableSend,loading:t.loading},on:{click:function(e){return t.sendOrden()}}},[n("i",{staticClass:"icofont-checked"}),t._v("\n\n                        Cobrar\n                    ")]),t._v(" "),t._m(0)])]),t._v(" "),n("div",{staticClass:"row align-items-start"},[n("div",{staticClass:"col-md-6 text-end pt-2 pb-2 font-weight-light"},[n("label",{staticClass:"control-label w-100"},[t._v("Para llevar")]),t._v(" "),n("el-switch",{attrs:{"active-text":"Si","inactive-text":"No"},model:{value:t.to_carry,callback:function(e){t.to_carry=e},expression:"to_carry"}})],1),t._v(" "),n("div",{staticClass:"col-md-6 text-end pt-2 pb-2 font-weight-light"},[n("h3",{staticClass:"badge text-success lead-font-weight-700"},[t._v("\n                        Total Pedido: S/. "+t._s(t.total.toFixed(2))+"\n                    ")])])]),t._v(" "),n("div",{staticClass:"scroll-out"},[n("div",{staticClass:"scroll-by-count os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition",staticStyle:{height:"calc(100vh - 8rem)"},attrs:{"data-count":"4",id:"checkboxTable"}},[t._m(1),t._v(" "),t._m(2),t._v(" "),n("div",{staticClass:"os-content-glue",staticStyle:{margin:"0px 5px"}}),t._v(" "),n("div",{staticClass:"os-padding"},[n("div",{staticClass:"os-viewport os-viewport-native-scrollbars-invisible",staticStyle:{"overflow-y":"scroll"}},[n("div",{staticClass:"os-content",staticStyle:{padding:"0px 5px",height:"100%",width:"100%"}},t._l(t.localOrden,function(e,a){return n("div",{key:a,staticClass:"col-sm-12 col-md-12 col-lg-12  col-xl-12"},[n("div",{staticClass:"coupon rounded d-flex justify-content-between mb-2",attrs:{id:"card"}},[n("div",{staticClass:"tengah py-2 d-flex w-100 justify-content-start  p-2"},[n("div",[n("h3",{staticClass:"lead font-weight-light"},[t._v("\n                                                    "+t._s(e.food.description.toUpperCase())+"\n                                                ")]),t._v(" "),n("p",{staticClass:"badge bg-foreground text-uppercase font-weight-light p-0"}),t._v(" "),n("div",{staticClass:"row align-items-end"},[n("div",{staticClass:"col-md-5"},[n("span",{staticClass:"text-muted"},[t._v("\n                                                            Cantidad"),n("br"),t._v(" "),n("div",{staticClass:"input-group spinner",attrs:{"data-trigger":"spinner"}},[n("input",{directives:[{name:"model",rawName:"v-model",value:e.quantity,expression:"\n                                                                        order_pend.quantity\n                                                                    "}],staticClass:"form-control text-center",attrs:{type:"text",readonly:"","data-rule":"currency"},domProps:{value:e.quantity},on:{input:function(n){n.target.composing||t.$set(e,"quantity",n.target.value)}}}),t._v(" "),n("div",{staticClass:"input-group-text"},[n("button",{staticClass:"spin-up",attrs:{type:"button","data-spin":"up"},on:{click:function(e){return t.sumar_orden(a)}}},[n("span",{staticClass:"arrow"})]),t._v(" "),n("button",{staticClass:"spin-down",attrs:{type:"button","data-spin":"down"},on:{click:function(e){return t.restar_orden(a)}}},[n("span",{staticClass:"arrow"})])])])])]),t._v(" "),n("div",{staticClass:"col-md-5"},[n("span",{staticClass:"time font-weight-light"},[n("span",{staticClass:"text-muted"},[t._v("\n                                                                Precio\n                                                                "),n("br"),t._v(" "),n("el-input",{attrs:{type:"number"},on:{input:function(n){return t.update_price(a,e.price)}},model:{value:e.price,callback:function(n){t.$set(e,"price",n)},expression:"\n                                                                        order_pend.price\n                                                                    "}},["PEN"==e.food.item.currency_type_id?n("template",{slot:"prepend"},[t._v("\n                                                                        S/\n                                                                    ")]):t._e(),t._v(" "),"USD"==e.food.item.currency_type_id?n("template",{slot:"prepend"},[t._v("\n                                                                        $\n                                                                    ")]):t._e()],2)],1)])]),t._v(" "),n("div",{staticClass:"col-md-2 p-0"},[n("span",{staticClass:"time font-weight-light"},[n("span",{staticClass:"text-muted"},[n("el-button",{staticClass:"text-white",attrs:{type:"danger",icon:"el-icon-delete"},on:{click:function(e){return t.deleteFood(a)}}})],1)])])])])])])])}),0)])])])])])])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn btn-danger",attrs:{type:"button",id:"close_offcanvas","data-bs-dismiss":"offcanvas","aria-label":"Close"}},[e("i",{staticClass:"icofont-checked"}),e("i",{staticClass:"icofont-close-line"}),this._v(" Cancelar\n                    ")])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"os-resize-observer-host observed"},[e("div",{staticClass:"os-resize-observer",staticStyle:{left:"0px",right:"auto"}})])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"os-size-auto-observer observed",staticStyle:{height:"calc(100% + 1px)",float:"left"}},[e("div",{staticClass:"os-resize-observer"})])}]}},BGRX:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("En79"),s=n.n(a);function r(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),n.push.apply(n,a)}return n}function i(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?r(Object(n),!0).forEach(function(e){o(t,e,n[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):r(Object(n)).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))})}return t}function o(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function c(t,e,n,a,s,r,i){try{var o=t[r](i),c=o.value}catch(t){return void n(t)}o.done?e(c):Promise.resolve(c).then(a,s)}function l(t){return function(t){if(Array.isArray(t))return u(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return u(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(t);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return u(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function u(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,a=new Array(e);n<e;n++)a[n]=t[n];return a}e.default={props:["showSplitPayment","total","orden_items"],data:function(){return{selectedAccount:void 0,splitByAmount:"1",number:2,numberProduct:2,payments:[],items:[]}},created:function(){var t=_.round(this.total/2,1);this.payments=[{fixed:!1,amount:t},{fixed:!1,amount:t}],this.total!=2*t&&(this.payments[0].amount+=_.round(2*t-this.total,1))},methods:{totalItemSelected:function(t){var e=0;return t.forEach(function(t){e+=t.quantity*t.price}),_.round(e,2)},removeItem:function(t){var e=this.payments.findIndex(function(t){return t.selected});if(e>-1){var n=this.payments[e].products.findIndex(function(e){return e.id==t});if(n>-1){1==this.payments[e].products[n].quantity?this.payments[e].products=l(this.payments[e].products.filter(function(e){return e.id!=t})):this.payments[e].products[n].quantity-=1;var a=this.items.find(function(e){return e.id==t});++a.quantity,1==a.quantity&&(this.items=[a].concat(l(this.items.filter(function(t){return t.id!=a.id}))))}}},addItem:function(t){if(0!=t.quantity){var e=this.payments.findIndex(function(t){return t.selected});if(e>-1){var n=this.payments[e].products.findIndex(function(e){return e.id==t.id});n>-1?this.payments[e].products[n].quantity+=1:this.payments[e].products.push({price:t.price,description:t.food.description,id:t.id,quantity:1}),--t.quantity,0==t.quantity&&(this.items=[].concat(l(this.items.filter(function(e){return e.id!=t.id})),[t]))}else this.$toast.warning("Seleccione una cuenta")}else this.$toast.warning("No quedan unidades disponibles para dividir el producto")},sendPayments:function(){var t,e=this;return(t=s.a.mark(function t(){return s.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if("1"!=e.splitByAmount){t.next=4;break}e.$emit("receivePayments",e.payments),t.next=8;break;case 4:if(!e.items.some(function(t){return t.quantity>0})){t.next=7;break}return e.$toast.error("Aún hay productos por dividir"),t.abrupt("return");case 7:e.$emit("receiveProducts",e.payments);case 8:e.close();case 9:case"end":return t.stop()}},t)}),function(){var e=this,n=arguments;return new Promise(function(a,s){var r=t.apply(e,n);function i(t){c(r,a,s,i,o,"next",t)}function o(t){c(r,a,s,i,o,"throw",t)}i(void 0)})})()},changePayment:function(t){var e=this.payments.filter(function(t){return t.fixed});e.length;if(e.length>0&&(e=e.reduce(function(t,e){return{amount:t.amount+e.amount,fixed:!0}}),isNaN(e.amount)&&e.amount>0)){this.total,e.amount;this.payments[t].amount}},paymentByAmount:function(){var t=_.round(this.total/this.number,1);this.payments=Array.from({length:this.number},function(e,n){return{fixed:!1,amount:t}}),this.total!=t*this.number&&(this.payments[0].amount+=_.round(this.total-t*this.number,1)),this.payments.map(function(t){return i(i({},t),{},{amount:_.round(t.amount,2)})})},updatePayments:function(){(this.number<2||isNaN(this.number))&&(this.number=2),"1"==this.splitByAmount?this.paymentByAmount():this.paymentByProducts()},selectAccount:function(t){void 0==this.selectedAccount&&null==this.selectedAccount||(this.payments[this.selectedAccount].selected=!1),this.payments[t].selected=!0,this.selectedAccount=t},paymentByProducts:function(){this.payments=[],this.restoreItems();var t=this.payments.some(function(t){return t.products}),e=this.numberProduct;t&&(e=this.numberProduct-this.payments.length),this.payments=[].concat(l(this.payments),l(Array.from({length:e},function(t,e){return{fixed:!1,amount:0,products:[],selected:!1}})))},restoreItems:function(){this.items=JSON.parse(JSON.stringify(this.orden_items.items))},open:function(){this.payments=[],this.restoreItems()},close:function(){this.items=[],this.$emit("update:showSplitPayment",!1)}}}},HSfk:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a,s=n("En79"),r=n.n(s),i=n("s3Ks");n.n(i);function o(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function c(t){return function(t){if(Array.isArray(t))return l(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return l(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(t);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return l(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function l(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,a=new Array(e);n<e;n++)a[n]=t[n];return a}function u(t,e,n,a,s,r,i){try{var o=t[r](i),c=o.value}catch(t){return void n(t)}o.done?e(c):Promise.resolve(c).then(a,s)}function d(t){return function(){var e=this,n=arguments;return new Promise(function(a,s){var r=t.apply(e,n);function i(t){u(r,a,s,i,o,"next",t)}function o(t){u(r,a,s,i,o,"throw",t)}i(void 0)})}}e.default=(o(a={props:["localOrden","configuration","ordens"],created:function(){},data:function(){return{pin:"",totalOrdenItems:0,total:0,disableSend:!1,totalOrden:0,loading:!1,commands_fisico:"",AllSelected:!1,showDialogPing:!1,dialogLocalObservation:!1,currentLocalOrden:null,localObservation:null,dialogObservation:!1,observation:null,loadingObservation:!1,currentOrden:null,form_ped:{},to_carry:!1}},watch:{ordens:function(t,e){this.calculateTotal(t)}},mounted:function(){}},"created",function(){var t=this;return d(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:qz.security.setCertificatePromise(function(e,n){t.$http.get("/api/qz/crt/override",{responseType:"text"}).then(function(t){e(t.data)}).catch(function(t){n(t.data)})}),qz.security.setSignaturePromise(function(e){return function(n,a){t.$http.post("/api/qz/signing",{request:e}).then(function(t){n(t.data)}).catch(function(t){a(t.data)})}});case 2:case"end":return e.stop()}},e)}))()}),o(a,"methods",{addNumberPin:function(t){this.pin.length>=4||(this.pin+=t.toString())},close:function(){this.$emit("update:localOrden",[])},update_price:function(t,e){var n=this.localOrden;n[t].food.sale_unit_price=e,this.$emit("update:localOrden",n),this.calculateTotal()},sumar_orden:function(t){var e=this.localOrden;e[t].quantity=e[t].quantity+1,this.$emit("update:localOrden",e),this.calculateTotal()},restar_orden:function(t){var e=this.localOrden;e[t].quantity>1&&(e[t].quantity=e[t].quantity-1,this.$emit("update:localOrden",e)),this.calculateTotal()},printTicket:function(){var t=this;return d(r.a.mark(function e(){var n,a,s,i;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return n=t.ordens[0].orden_id,e.prev=1,e.next=4,t.$http.get("/restaurant/worker/record/".concat(n));case 4:if(a=e.sent,s=qz.configs.create(a.data.printer,{scaleContent:!1}),qz.websocket.isActive()){e.next=9;break}return e.next=9,qz.websocket.connect(s);case 9:i=[{type:"pdf",format:"file",data:a.data.print}],qz.print(s,i).catch(function(e){t.$toast.error(e.message)}),e.next=16;break;case 13:e.prev=13,e.t0=e.catch(1),t.$toast.error(e.t0.message);case 16:case"end":return e.stop()}},e,null,[[1,13]])}))()},view_orders:function(){$(".style-switcher").animate({right:"0"},300).addClass("active")},selectAllCats:function(){},closeDialog:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,e=c(this.localOrden);e=e.map(function(t){return{status_orden_id:1,food:{description:t.food.description,price:t.food.price},observations:t.observation}}),this.$emit("updateOrdens",t),this.$emit("listtables"),this.$emit("update:localOrden",[]),this.$eventHub.$emit("reloadData"),this.totalOrdenItems=0,this.total=0,this.totalOrden=0},clear_command:function(){this.commands_fisico=null},sendOrden:function(){var t=this;return d(r.a.mark(function e(){var n;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(1!=t.configuration.commands_fisico){e.next=3;break}if(""!=t.commands_fisico&&null!=t.commands_fisico&&0!=t.commands_fisico.length){e.next=3;break}return e.abrupt("return",t.$toast.error("Debe ingresar la comanda fisica"));case 3:t.disableSend=!0,n={id:null,caja:!0,printing:t.configuration.print_commands,commands_fisico:t.commands_fisico,print_kitchen:t.configuration.print_kitchen,to_carry:t.to_carry,orden:{table_id:1,status_orden_id:1},items:t.localOrden,pin:null},t.loading=!0,t.commands_fisico="",t.to_carry=!1,t.loading=!1,t.disableSend=!1,document.querySelector("#close_offcanvas").click(),t.loading=!1,t.disableSend=!1,t.$emit("paymentsOrden",n);case 14:case"end":return e.stop()}},e)}))()},formatUrlImage:function(t){if(t)return"/".concat("storage/uploads/items/"+t)},cancelGeneralOrden:function(){var t=this;return d(r.a.mark(function e(){var n,a,s;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.loading=!0,e.prev=1,e.next=4,t.$confirm("Desea cancelar toda la orden?","Cancelar",{confirmButtonText:"Ok",cancelButtonText:"Cancelar",type:"warning"});case 4:if(!e.sent){e.next=11;break}return n={id:t.ordens[0].orden_id},e.next=9,t.$http.post("cancel-orden",n);case 9:200==(a=e.sent).status&&(s=a.data.message,t.$toast.success(s),t.$eventHub.$emit("reloadData"),t.$emit("ordenDeleted"));case 11:e.next=16;break;case 13:e.prev=13,e.t0=e.catch(1),"cancel"!=e.t0&&(console.log(e.t0),t.$toast.error("Ocurrió un error"));case 16:t.loading=!1;case 17:case"end":return e.stop()}},e,null,[[1,13]])}))()},calculateTotal:function(){arguments.length>0&&void 0!==arguments[0]&&arguments[0];this.totalOrdenItems=0,this.total=0,this.totalOrden=0;var t=0,e=0;_.forEach(this.localOrden,function(e){t=parseFloat(t)+e.quantity*e.price});this.totalOrden=_.round(t,2);_.forEach(this.ordens,function(t){e=parseFloat(e)+t.quantity*t.price});this.totalOrdenItems=_.round(e,2),this.total=this.totalOrden+this.totalOrdenItems,this.$emit("total_sales",this.total)},deleteFood:function(t){this.$emit("deletedFood",t),this.calculateTotal()},submit:function(){var t=this;return d(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.showDialogPing=!0,t.open_orders();case 2:case"end":return e.stop()}},e)}))()},cancelOrden:function(t){var e=this;return d(r.a.mark(function n(){var a,s,i;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.prev=0,n.next=3,e.$confirm("Desea cancelar este pedido?","Cancelar",{confirmButtonText:"Ok",cancelButtonText:"Cancelar",type:"warning"});case 3:if(!n.sent){n.next=9;break}return n.next=7,e.$http.delete("delete-orden/".concat(t));case 7:200==(a=n.sent).status&&(s=a.data.message,i=(i=c(e.ordens)).filter(function(e){return e.id!=t}),e.$emit("update:ordens",i),e.$eventHub.$emit("reloadData"),e.$toast.success(s));case 9:n.next=14;break;case 11:n.prev=11,n.t0=n.catch(0),"cancel"!=n.t0&&e.$toast.error("Ocurrió un error");case 14:case"end":return n.stop()}},n,null,[[0,11]])}))()},ordenReady:function(t){var e=this;return d(r.a.mark(function n(){var a,s,i,o,l;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return e.loading=!0,n.prev=1,n.next=4,e.$http.get("ordens-ready/".concat(t));case 4:a=n.sent,s=a.data,i=s.success,o=s.message,i?e.$toast.success(o):e.$toast.error(o),i&&(l=(l=c(e.ordens)).map(function(e){return e.id==t&&(e.status_orden_id=3),e}),e.$emit("update:ordens",l)),n.next=14;break;case 10:n.prev=10,n.t0=n.catch(1),console.log(n.t0),e.$toast.error("Ocurrió un error");case 14:e.loading=!1;case 15:case"end":return n.stop()}},n,null,[[1,10]])}))()},changeObservation:function(){var t=this;return d(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.loadingObservation=!0,e.next=3,t.$http.post("change-observation",{observation:t.observation,id:t.currentOrden});case 3:200==e.sent.status&&(t.$eventHub.$emit("reloadData"),c(t.ordens).find(function(e){return e.id==t.currentOrden}).observations=t.observation),t.loadingObservation=!1,t.closeObservationDialog();case 7:case"end":return e.stop()}},e)}))()},openObservationDialog:function(t,e){this.currentOrden=t,this.observation=this.ordens[e].observations,this.dialogObservation=!0},closeObservationDialog:function(){this.dialogObservation=!1,this.observation=null},changeLocalObservation:function(){var t=c(this.localOrden);t[this.currentLocalOrden].observation=this.localObservation,this.$emit("update:localOrden",t),this.closeLocalObservationDialog()},openLocalObservationDialog:function(t){this.currentLocalOrden=t,this.localObservation=this.localOrden[t].observation,this.dialogLocalObservation=!0},closeLocalObservationDialog:function(){this.dialogLocalObservation=!1,this.currentLocalOrden=null,this.localObservation=null}}),a)},fUVb:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("el-dialog",{attrs:{"append-to-body":"",visible:t.showSplitPayment,title:"Dividir pago: S/. "+t.total,width:"70%"},on:{open:t.open,close:t.close}},[n("div",{staticClass:"d-flex flex-column p-2"},[n("div",{staticClass:"d-flex flex-row align-items-end"},[n("div",[n("label",{attrs:{for:""}},[t._v("Dividir entre:")]),n("br"),t._v(" "),"1"==t.splitByAmount?n("el-input-number",{attrs:{max:10},on:{input:t.updatePayments},model:{value:t.number,callback:function(e){t.number=e},expression:"number"}}):n("el-input-number",{attrs:{max:t.items.length},on:{input:t.updatePayments},model:{value:t.numberProduct,callback:function(e){t.numberProduct=e},expression:"numberProduct"}})],1),t._v(" "),n("div",{staticStyle:{"margin-left":"10px"}},[n("el-radio-group",{on:{change:t.updatePayments},model:{value:t.splitByAmount,callback:function(e){t.splitByAmount=e},expression:"splitByAmount"}},[n("el-radio-button",{attrs:{label:"1"}},[t._v("Por cuotas")]),t._v(" "),n("el-radio-button",{attrs:{label:"2"}},[t._v("Por producto")])],1)],1)]),t._v(" "),"1"==t.splitByAmount?n("div",{staticClass:"d-flex flex-wrap "},t._l(t.payments,function(e,a){return n("div",{key:a,staticClass:"col-3"},[n("div",{staticStyle:{"margin-top":"10px","margin-right":"5px"}},[n("h2",{staticClass:"text-muted text-small"},[t._v("\n                        Cuota "+t._s(a+1)+"\n                    ")]),t._v(" "),n("el-input",{attrs:{readonly:""},model:{value:e.amount,callback:function(n){t.$set(e,"amount",n)},expression:"payment.amount"}})],1)])}),0):n("div",[n("div",{staticClass:"d-flex flex-wrap"},t._l(t.items,function(e,a){return n("div",{key:a,staticClass:"col-2"},[n("div",{staticClass:"card p-1",staticStyle:{"margin-top":"10px","margin-right":"5px"},attrs:{role:"button"},on:{click:function(n){return t.addItem(e)}}},[n("h2",{staticClass:"text-muted text-small"},[t._v("\n                            "+t._s(e.food.description)+"\n                        ")]),t._v(" "),n("h3",{staticClass:"text-muted text-small"},[t._v("\n                            S/. "+t._s(e.price)+"\n                        ")]),t._v(" "),n("h3",{class:" text-small "+(0==e.quantity?"text-danger":"text-muted")},[t._v("\n                            Cantidad: "+t._s(e.quantity)+"\n                        ")])])])}),0),t._v(" "),n("div",{staticClass:"d-flex flex-wrap justify-content-center",staticStyle:{"margin-top":"15px"}},t._l(t.payments,function(e,a){return n("div",{key:a,staticClass:"col-3 ",staticStyle:{margin:"5px"}},[n("table",{staticClass:"col-12"},[n("thead",[n("tr",{class:e.selected?"bg-primary text-white border rounded-top":"border rounded-top",attrs:{role:"button"},on:{click:function(e){return t.selectAccount(a)}}},[n("th",{staticClass:"text-center",attrs:{colspan:"3"}},[n("b",[t._v(" CUENTA "+t._s(a+1)+" ")])])])]),t._v(" "),e.products&&e.products.length>0?n("tbody",{staticClass:"border rounded-top "},[t._l(e.products,function(e,a){return n("tr",{key:a},[n("td",[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                        "+t._s(e.quantity)+"\n                                    ")])]),t._v(" "),n("td",[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                        "+t._s(e.description)+"\n                                    ")])]),t._v(" "),n("td",{staticStyle:{"text-align":"right"}},[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                        "+t._s(e.price*e.quantity)+"\n\n                                        "),n("b",{staticClass:"text-danger",attrs:{role:"button"},on:{click:function(n){return t.removeItem(e.id)}}},[t._v("\n                                            x\n                                        ")])])])])}),t._v(" "),n("tr",[n("td",{staticClass:"text-muted text-small",staticStyle:{"text-align":"right"},attrs:{colspan:"2"}},[n("b",[t._v("\n                                        Total\n                                    ")])]),t._v(" "),n("td",{staticClass:"text-muted text-small"},[t._v("\n                                    S/.\n                                    "+t._s(t.totalItemSelected(e.products))+"\n                                ")])])],2):n("tbody",{staticClass:"border"},[n("tr",[n("td",{staticClass:"text-center",attrs:{colspan:"3"}},[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                        Sin productos seleccionados\n                                    ")])])])])])])}),0)]),t._v(" "),n("div",{staticClass:"row d-flex m-2 justify-content-end"},[n("div",{staticClass:"col-3 d-flex justify-content-end"},[n("el-button",{attrs:{type:"primary"},on:{click:t.sendPayments}},[t._v("Listo")])],1)])])])},staticRenderFns:[]}},kQyA:function(t,e,n){var a=n("VU/8")(n("HSfk"),n("9yJJ"),!1,null,null,null);t.exports=a.exports},s3Ks:function(t,e,n){var a=n("VU/8")(n("BGRX"),n("fUVb"),!1,null,null,null);t.exports=a.exports}});
//# sourceMappingURL=105.js.map
>>>>>>> master
=======
webpackJsonp([105],{"38N9":function(t,e,n){var a;window,a=function(){return function(t){var e={};function n(a){if(e[a])return e[a].exports;var r=e[a]={i:a,l:!1,exports:{}};return t[a].call(r.exports,r,r.exports,n),r.l=!0,r.exports}return n.m=t,n.c=e,n.d=function(t,e,a){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)n.d(a,r,function(e){return t[e]}.bind(null,r));return a},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=0)}({"./src/index.js":function(t,e,n){"use strict";n.r(e);n("./src/sass/index.scss");var a=n("./src/js/init.js").default.init;"undefined"!=typeof window&&(window.printJS=a),e.default=a},"./src/js/browser.js":function(t,e,n){"use strict";n.r(e);var a={isFirefox:function(){return"undefined"!=typeof InstallTrigger},isIE:function(){return-1!==navigator.userAgent.indexOf("MSIE")||!!document.documentMode},isEdge:function(){return!a.isIE()&&!!window.StyleMedia},isChrome:function(){return!!(arguments.length>0&&void 0!==arguments[0]?arguments[0]:window).chrome},isSafari:function(){return Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0||-1!==navigator.userAgent.toLowerCase().indexOf("safari")},isIOSChrome:function(){return-1!==navigator.userAgent.toLowerCase().indexOf("crios")}};e.default=a},"./src/js/functions.js":function(t,e,n){"use strict";n.r(e),n.d(e,"addWrapper",function(){return s}),n.d(e,"capitalizePrint",function(){return i}),n.d(e,"collectStyles",function(){return c}),n.d(e,"addHeader",function(){return u}),n.d(e,"cleanUp",function(){return d}),n.d(e,"isRawHTML",function(){return m});var a=n("./src/js/modal.js"),r=n("./src/js/browser.js");function o(t){"@babel/helpers - typeof";return(o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function s(t,e){return'<div style="'+("font-family:"+e.font+" !important; font-size: "+e.font_size+" !important; width:100%;")+'">'+t+"</div>"}function i(t){return t.charAt(0).toUpperCase()+t.slice(1)}function c(t,e){for(var n="",a=(document.defaultView||window).getComputedStyle(t,""),r=0;r<a.length;r++)(-1!==e.targetStyles.indexOf("*")||-1!==e.targetStyle.indexOf(a[r])||l(e.targetStyles,a[r]))&&a.getPropertyValue(a[r])&&(n+=a[r]+":"+a.getPropertyValue(a[r])+";");return n+="max-width: "+e.maxWidth+"px !important; font-size: "+e.font_size+" !important;"}function l(t,e){for(var n=0;n<t.length;n++)if("object"===o(e)&&-1!==e.indexOf(t[n]))return!0;return!1}function u(t,e){var n=document.createElement("div");if(m(e.header))n.innerHTML=e.header;else{var a=document.createElement("h1"),r=document.createTextNode(e.header);a.appendChild(r),a.setAttribute("style",e.headerStyle),n.appendChild(a)}t.insertBefore(n,t.childNodes[0])}function d(t){t.showModal&&a.default.close(),t.onLoadingEnd&&t.onLoadingEnd(),(t.showModal||t.onLoadingStart)&&window.URL.revokeObjectURL(t.printable);var e="mouseover";(r.default.isChrome()||r.default.isFirefox())&&(e="focus");window.addEventListener(e,function n(){window.removeEventListener(e,n),t.onPrintDialogClose();var a=document.getElementById(t.frameId);a&&a.remove()})}function m(t){return new RegExp("<([A-Za-z][A-Za-z0-9]*)\\b[^>]*>(.*?)</\\1>").test(t)}},"./src/js/html.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/functions.js"),r=n("./src/js/print.js");function o(t){"@babel/helpers - typeof";return(o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}e.default={print:function(t,e){var n,s="object"===o(n=t.printable)&&n&&(n instanceof HTMLElement||1===n.nodeType)?t.printable:document.getElementById(t.printable);s?(t.printableElement=function t(e,n){var r=e.cloneNode();var o=Array.prototype.slice.call(e.childNodes);for(var s=0;s<o.length;s++)if(-1===n.ignoreElements.indexOf(o[s].id)){var i=t(o[s],n);r.appendChild(i)}n.scanStyles&&1===e.nodeType&&r.setAttribute("style",Object(a.collectStyles)(e,n));switch(e.tagName){case"SELECT":r.value=e.value;break;case"CANVAS":r.getContext("2d").drawImage(e,0,0)}return r}(s,t),t.header&&Object(a.addHeader)(t.printableElement,t),r.default.send(t,e)):window.console.error("Invalid HTML element id: "+t.printable)}}},"./src/js/image.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/functions.js"),r=n("./src/js/print.js"),o=n("./src/js/browser.js");e.default={print:function(t,e){t.printable.constructor!==Array&&(t.printable=[t.printable]),t.printableElement=document.createElement("div"),t.printable.forEach(function(e){var n=document.createElement("img");if(n.setAttribute("style",t.imageStyle),n.src=e,o.default.isFirefox()){var a=n.src;n.src=a}var r=document.createElement("div");r.appendChild(n),t.printableElement.appendChild(r)}),t.header&&Object(a.addHeader)(t.printableElement,t),r.default.send(t,e)}}},"./src/js/init.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/browser.js"),r=n("./src/js/modal.js"),o=n("./src/js/pdf.js"),s=n("./src/js/html.js"),i=n("./src/js/raw-html.js"),c=n("./src/js/image.js"),l=n("./src/js/json.js");function u(t){"@babel/helpers - typeof";return(u="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}var d=["pdf","html","image","json","raw-html"];e.default={init:function(){var t={printable:null,fallbackPrintable:null,type:"pdf",header:null,headerStyle:"font-weight: 300;",maxWidth:800,properties:null,gridHeaderStyle:"font-weight: bold; padding: 5px; border: 1px solid #dddddd;",gridStyle:"border: 1px solid lightgray; margin-bottom: -1px;",showModal:!1,onError:function(t){throw t},onLoadingStart:null,onLoadingEnd:null,onPrintDialogClose:function(){},onIncompatibleBrowser:function(){},modalMessage:"Retrieving Document...",frameId:"printJS",printableElement:null,documentTitle:"Document",targetStyle:["clear","display","width","min-width","height","min-height","max-height"],targetStyles:["border","box","break","text-decoration"],ignoreElements:[],repeatTableHeader:!0,css:null,style:null,scanStyles:!0,base64:!1,onPdfOpen:null,font:"TimesNewRoman",font_size:"12pt",honorMarginPadding:!0,honorColor:!1,imageStyle:"max-width: 100%;"},e=arguments[0];if(void 0===e)throw new Error("printJS expects at least 1 attribute.");switch(u(e)){case"string":t.printable=encodeURI(e),t.fallbackPrintable=t.printable,t.type=arguments[1]||t.type;break;case"object":for(var n in t.printable=e.printable,t.fallbackPrintable=void 0!==e.fallbackPrintable?e.fallbackPrintable:t.printable,t.fallbackPrintable=t.base64?"data:application/pdf;base64,".concat(t.fallbackPrintable):t.fallbackPrintable,t)"printable"!==n&&"fallbackPrintable"!==n&&(t[n]=void 0!==e[n]?e[n]:t[n]);break;default:throw new Error('Unexpected argument type! Expected "string" or "object", got '+u(e))}if(!t.printable)throw new Error("Missing printable information.");if(!t.type||"string"!=typeof t.type||-1===d.indexOf(t.type.toLowerCase()))throw new Error("Invalid print type. Available types are: pdf, html, image and json.");t.showModal&&r.default.show(t),t.onLoadingStart&&t.onLoadingStart();var m=document.getElementById(t.frameId);m&&m.parentNode.removeChild(m);var f=document.createElement("iframe");switch(a.default.isFirefox()?f.setAttribute("style","width: 1px; height: 100px; position: fixed; left: 0; top: 0; opacity: 0; border-width: 0; margin: 0; padding: 0"):f.setAttribute("style","visibility: hidden; height: 0; width: 0; position: absolute; border: 0"),f.setAttribute("id",t.frameId),"pdf"!==t.type&&(f.srcdoc="<html><head><title>"+t.documentTitle+"</title>",t.css&&(Array.isArray(t.css)||(t.css=[t.css]),t.css.forEach(function(t){f.srcdoc+='<link rel="stylesheet" href="'+t+'">'})),f.srcdoc+="</head><body></body></html>"),t.type){case"pdf":if(a.default.isIE())try{console.info("Print.js doesn't support PDF printing in Internet Explorer."),window.open(t.fallbackPrintable,"_blank").focus(),t.onIncompatibleBrowser()}catch(e){t.onError(e)}finally{t.showModal&&r.default.close(),t.onLoadingEnd&&t.onLoadingEnd()}else o.default.print(t,f);break;case"image":c.default.print(t,f);break;case"html":s.default.print(t,f);break;case"raw-html":i.default.print(t,f);break;case"json":l.default.print(t,f)}}}},"./src/js/json.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/functions.js"),r=n("./src/js/print.js");function o(t){"@babel/helpers - typeof";return(o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}e.default={print:function(t,e){if("object"!==o(t.printable))throw new Error("Invalid javascript data object (JSON).");if("boolean"!=typeof t.repeatTableHeader)throw new Error("Invalid value for repeatTableHeader attribute (JSON).");if(!t.properties||!Array.isArray(t.properties))throw new Error("Invalid properties array for your JSON data.");t.properties=t.properties.map(function(e){return{field:"object"===o(e)?e.field:e,displayName:"object"===o(e)?e.displayName:e,columnSize:"object"===o(e)&&e.columnSize?e.columnSize+";":100/t.properties.length+"%;"}}),t.printableElement=document.createElement("div"),t.header&&Object(a.addHeader)(t.printableElement,t),t.printableElement.innerHTML+=function(t){var e=t.printable,n=t.properties,r='<table style="border-collapse: collapse; width: 100%;">';t.repeatTableHeader&&(r+="<thead>");r+="<tr>";for(var o=0;o<n.length;o++)r+='<th style="width:'+n[o].columnSize+";"+t.gridHeaderStyle+'">'+Object(a.capitalizePrint)(n[o].displayName)+"</th>";r+="</tr>",t.repeatTableHeader&&(r+="</thead>");r+="<tbody>";for(var s=0;s<e.length;s++){r+="<tr>";for(var i=0;i<n.length;i++){var c=e[s],l=n[i].field.split(".");if(l.length>1)for(var u=0;u<l.length;u++)c=c[l[u]];else c=c[n[i].field];r+='<td style="width:'+n[i].columnSize+t.gridStyle+'">'+c+"</td>"}r+="</tr>"}return r+="</tbody></table>"}(t),r.default.send(t,e)}}},"./src/js/modal.js":function(t,e,n){"use strict";n.r(e);var a={show:function(t){var e=document.createElement("div");e.setAttribute("style","font-family:sans-serif; display:table; text-align:center; font-weight:300; font-size:30px; left:0; top:0;position:fixed; z-index: 9990;color: #0460B5; width: 100%; height: 100%; background-color:rgba(255,255,255,.9);transition: opacity .3s ease;"),e.setAttribute("id","printJS-Modal");var n=document.createElement("div");n.setAttribute("style","display:table-cell; vertical-align:middle; padding-bottom:100px;");var r=document.createElement("div");r.setAttribute("class","printClose"),r.setAttribute("id","printClose"),n.appendChild(r);var o=document.createElement("span");o.setAttribute("class","printSpinner"),n.appendChild(o);var s=document.createTextNode(t.modalMessage);n.appendChild(s),e.appendChild(n),document.getElementsByTagName("body")[0].appendChild(e),document.getElementById("printClose").addEventListener("click",function(){a.close()})},close:function(){var t=document.getElementById("printJS-Modal");t&&t.parentNode.removeChild(t)}};e.default=a},"./src/js/pdf.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/print.js"),r=n("./src/js/functions.js");function o(t,e,n){var r=new window.Blob([n],{type:"application/pdf"});r=window.URL.createObjectURL(r),e.setAttribute("src",r),a.default.send(t,e)}e.default={print:function(t,e){if(t.base64){var n=Uint8Array.from(atob(t.printable),function(t){return t.charCodeAt(0)});o(t,e,n)}else{t.printable=/^(blob|http|\/\/)/i.test(t.printable)?t.printable:window.location.origin+("/"!==t.printable.charAt(0)?"/"+t.printable:t.printable);var a=new window.XMLHttpRequest;a.responseType="arraybuffer",a.addEventListener("error",function(){Object(r.cleanUp)(t),t.onError(a.statusText,a)}),a.addEventListener("load",function(){if(-1===[200,201].indexOf(a.status))return Object(r.cleanUp)(t),void t.onError(a.statusText,a);o(t,e,a.response)}),a.open("GET",t.printable,!0),a.send()}}}},"./src/js/print.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/browser.js"),r=n("./src/js/functions.js"),o={send:function(t,e){document.getElementsByTagName("body")[0].appendChild(e);var n=document.getElementById(t.frameId);n.onload=function(){if("pdf"!==t.type){var e=n.contentWindow||n.contentDocument;if(e.document&&(e=e.document),e.body.appendChild(t.printableElement),"pdf"!==t.type&&t.style){var r=document.createElement("style");r.innerHTML=t.style,e.head.appendChild(r)}var o=e.getElementsByTagName("img");o.length>0?function(t){var e=t.map(function(t){if(t.src&&t.src!==window.location.href)return function(t){return new Promise(function(e){!function n(){t&&void 0!==t.naturalWidth&&0!==t.naturalWidth&&t.complete?e():setTimeout(n,500)}()})}(t)});return Promise.all(e)}(Array.from(o)).then(function(){return s(n,t)}):s(n,t)}else a.default.isFirefox()?setTimeout(function(){return s(n,t)},1e3):s(n,t)}}};function s(t,e){try{if(t.focus(),a.default.isEdge()||a.default.isIE())try{t.contentWindow.document.execCommand("print",!1,null)}catch(e){t.contentWindow.print()}else t.contentWindow.print()}catch(t){e.onError(t)}finally{a.default.isFirefox()&&(t.style.visibility="hidden",t.style.left="-1px"),Object(r.cleanUp)(e)}}e.default=o},"./src/js/raw-html.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/print.js");e.default={print:function(t,e){t.printableElement=document.createElement("div"),t.printableElement.setAttribute("style","width:100%"),t.printableElement.innerHTML=t.printable,a.default.send(t,e)}}},"./src/sass/index.scss":function(t,e,n){},0:function(t,e,n){t.exports=n("./src/index.js")}}).default},t.exports=a()},AhJO:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("el-dialog",{staticClass:"algunaClase",attrs:{visible:t.is_payment,"close-on-click-modal":!1,"close-on-press-escape":!1,"modal-append-to-body":!0,"show-close":!1,"append-to-body":!0,width:"770px",top:"2vh",title:"MODULO DE COBRO "+(t.variation?"- Variación":"")},on:{open:function(e){return t.date_of_issue()}}},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:" mb-0"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading_submit,expression:"loading_submit"}],staticClass:"pt-1"},[n("div",{staticClass:"row pt-2"},[n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:"mb-2"},[n("div",{staticClass:"card bg-light"},[n("div",{staticClass:"row "},[n("div",{staticClass:"  col-md-6 col-lg-5 col-sm-6"},[n("label",{staticClass:"control-label"},[t._v("Comprobante de Pago\n                                    ")]),t._v(" "),n("div",{staticClass:"form-group"},[n("el-radio-group",{attrs:{size:"small"},on:{change:function(e){t.date_of_issue(),t.filterSeries()}},model:{value:t.form.document_type_id,callback:function(e){t.$set(t.form,"document_type_id",e)},expression:"form.document_type_id"}},[t.isInterno?t._e():[n("el-radio-button",{attrs:{label:"01"}},[t._v("FACTURA\n                                                ")]),t._v(" "),n("el-radio-button",{attrs:{label:"03"}},[t._v("\n                                                    BOLETA\n                                                ")])],t._v(" "),t.variation?t._e():n("el-radio-button",{attrs:{label:"80"}},[t._v("\n                                                N. VENTA\n                                            ")])],2)],1)]),t._v(" "),n("div",{staticClass:"col-6 col-md-3 col-lg-3 col-xl-3"},[n("label",{staticClass:"control-label"},[t._v("\n                                        Serie\n                                    ")]),t._v(" "),n("div",{staticClass:"form-group"},[n("el-select",{staticClass:"w-100",model:{value:t.form.series_id,callback:function(e){t.$set(t.form,"series_id",e)},expression:"form.series_id"}},t._l(t.series,function(t){return n("el-option",{key:t.id,staticStyle:{"z-index":"2000 !important"},attrs:{label:t.full_number,value:t.id}})}),1)],1)]),t._v(" "),n("div",{staticClass:"col-6 col-md-4 col-lg-4 "},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"control-label"},[t._v("Fecha de Emisión")]),t._v(" "),n("el-date-picker",{staticStyle:{width:"100%"},attrs:{type:"date","value-format":"yyyy-MM-dd",clearable:!1,format:"dd-MM-yyyy",readonly:"","picker-options":t.datEmision},model:{value:t.form.date_of_issue,callback:function(e){t.$set(t.form,"date_of_issue",e)},expression:"form.date_of_issue"}})],1)])]),t._v(" "),n("div",{staticClass:"row "},[n("div",{staticClass:"col-lg-6 "},[n("div",{staticClass:"form-group"},[[n("div",{staticClass:"el-input el-input-group col-md-6 ",staticStyle:{"margin-bottom":"3px"}},[n("label",{staticClass:"control-label",staticStyle:{"margin-right":"3px"}},[t._v("Seleccion de\n                                                    Cliente")]),t._v(" "),n("el-button",{attrs:{disabled:!t.value},on:{click:function(e){t.showDialogNewPerson=!0}}},[t._v("Editar\n                                                    cliente")]),t._v(" "),n("el-button",{on:{click:t.createClient}},[t._v("Nuevo\n                                                    cliente")])],1)]],2)]),t._v(" "),n("div",{staticClass:"col-12 col-sm-8 col-lg-6"},[n("el-select",{ref:"select_person",staticClass:"col-md-6",attrs:{filterable:"",clearable:"",size:"small",placeholder:"Cliente",disabled:t.loading},on:{change:t.changeCustomer},nativeOn:{keyup:[function(e){return t.keyupCustomer.apply(null,arguments)},function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.keyupCustomer()}]},model:{value:t.value,callback:function(e){t.value=e},expression:"value"}},t._l(t.customers,function(t){return n("el-option",{key:t.id,attrs:{label:t.description,value:t.id}})}),1)],1)]),t._v(" "),n("div",{staticClass:"row col-lg-6 col-xl-12"},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"control-label"},[t._v("Observaciones")]),t._v(" "),n("el-input",{attrs:{type:"textarea",rows:2},model:{value:t.form.observation,callback:function(e){t.$set(t.form,"observation",e)},expression:"form.observation"}})],1)])])])]),t._v(" "),n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:" mb-2 "},[n("div",{staticClass:" text-center text-dark card  bg-light  "},[n("div",{staticClass:"row"},[n("div",{staticClass:"  col-lg-12 "},[n("div",{staticClass:" align-items-start "},[n("label",{staticClass:"control-label"},[t._v("Medios de Pago")]),t._v(" "),n("label",{staticClass:"text-primary control-label",attrs:{role:"button"}})]),t._v(" "),n("div",{staticClass:"radio-tile-group2 flex-wrap"},[n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"cash",type:"radio",name:"method_payment",value:"01"},domProps:{checked:t._q(t.method_payments,"01")},on:{change:[function(e){t.method_payments="01"},function(e){return t.method_payment("Efectivo")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/botonEfectivo.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon walk-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"cash"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"culqui",type:"radio",name:"method_payment",value:"02"},domProps:{checked:t._q(t.method_payments,"02")},on:{change:[function(e){t.method_payments="02"},function(e){return t.method_payment("Culqui")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/CulquiIcon.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"plin",type:"radio",name:"method_payment",value:"05"},domProps:{checked:t._q(t.method_payments,"05")},on:{change:[function(e){t.method_payments="05"},function(e){return t.method_payment("TARJETA: IZYPAY")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/botonIzipay.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"plin",type:"radio",name:"method_payment",value:"06"},domProps:{checked:t._q(t.method_payments,"06")},on:{change:[function(e){t.method_payments="06"},function(e){return t.method_payment("TARJETA: NIUBIZ")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/botonNiubiz.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"yape",type:"radio",name:"method_payment",value:"03"},domProps:{checked:t._q(t.method_payments,"03")},on:{change:[function(e){t.method_payments="03"},function(e){return t.method_payment("Yape")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"plin",type:"radio",name:"method_payment",value:"04"},domProps:{checked:t._q(t.method_payments,"04")},on:{change:[function(e){t.method_payments="04"},function(e){return t.method_payment("PLIN")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/plin-logo-0C4106153C-seeklogo.com.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])])]),t._v(" "),n("div",{staticClass:"row col-md-12"},[n("div",{staticClass:"row"},[n("label",{staticClass:"control-label text-center"},[t._v("Emision de\n                                                comprobante")])]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-2 col-md-5 col-xl-6"},[n("label",{staticClass:"control-label text-left  d-flex align-items-start justify-content-start"},[t._v("\n                                                    Ingrese Nro Celular\n                                                ")]),t._v(" "),n("el-input",{model:{value:t.form.customer_telephone,callback:function(e){t.$set(t.form,"customer_telephone",e)},expression:"\n                                                        form.customer_telephone\n                                                    "}},[n("template",{slot:"prepend"},[n("i",{staticClass:"fab fa-whatsapp fa-2x"})])],2)],1),t._v(" "),n("div",{staticClass:"radio-tile-group2 col-lg-6 col-xl-6 d ",staticStyle:{"padding-top":"12px"}},[n("div",{staticClass:"input-container2 border rounded-sm col-lg-3"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.printerOn,expression:"printerOn"}],staticClass:"radio-button2",attrs:{id:"imprimir",type:"radio",name:"imprimir",value:"1"},domProps:{checked:t._q(t.printerOn,"1")},on:{change:function(e){t.printerOn="1"}}}),t._v(" "),n("div",{staticClass:"radio-tile2"},[n("div",{staticClass:"icon walk-icon"},[n("i",{staticClass:"fa fa-print"})]),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"cash"}},[t._v("Imprimir")])])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm col-lg-3"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.printerOn,expression:"printerOn"}],staticClass:"radio-button2",attrs:{id:"noimprimir",type:"radio",name:"noimprimir",value:"0"},domProps:{checked:t._q(t.printerOn,"0")},on:{change:function(e){t.printerOn="0"}}}),t._v(" "),n("div",{staticClass:"radio-tile2"},[n("div",{staticClass:"icon bike-icon"},[n("i",{staticClass:"fa fa-print"})]),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}},[t._v("No\n                                                            Imprimir")])])])])])]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-8  d-flex flex-row align-items-end"}),t._v(" "),n("div",{staticClass:"d-flex flex-column"})]),t._v(" "),n("div",{staticClass:"row d-flex justify-content-start"},[0!=t.currentPayments.length?n("table",{staticClass:"table"},[n("thead",[n("tr",[n("th",{staticClass:"text-left",attrs:{colspan:"4"}},[t._v("\n                                                        Pagos\n                                                    ")])])]),t._v(" "),n("tbody",t._l(t.currentPayments,function(e,a){return n("tr",{key:a},[n("td",[t._v(t._s(a+1))]),t._v(" "),n("td",[t._v("\n                                                        "+t._s(e.method)+"\n                                                    ")]),t._v(" "),n("td",[n("strong",[t._v(t._s(e.amount))])]),t._v(" "),n("td",[n("label",{staticClass:"text-danger",attrs:{for:"",role:"button"},on:{click:function(n){return t.removePayment(e.id)}}},[n("i",{staticClass:"fa fa-trash"})])])])}),0)]):t._e()])]),t._v(" "),n("div",{staticClass:" card  bg-light col-lg-12  "})])])]),t._v(" "),n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:"mb-2"},[n("div",{staticClass:" card  bg-light "},[n("div",{staticClass:"row"},[n("div",{staticClass:" col-xl-4",class:{"has-danger":t.form.difference<0},staticStyle:{"margin-top":"10px","padding-top":"5px"}},[n("label",{staticClass:"control-label h1"},[t._v("Total a cobrar: ")]),n("br"),t._v(" "),n("span",{staticClass:"control-label font-weight-semibold text-center h3"},[t._v("\n                                            S/ "+t._s(" "+t.form.total)+"\n                                        ")])]),t._v(" "),"01"==t.form_payment.payment_method_type_id?n("div",{staticClass:"col-xl-8"},[n("div",{staticClass:"btn-group btn-group-square m-0 flex-wrap justify-content-around",staticStyle:{"padding-top":"12px"},attrs:{role:"group"}},[n("label",{staticClass:"control-label"},[t._v("Ingrese monto")]),t._v(" "),n("div",{staticClass:"row col-12"},[n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(10)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"10\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(20)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"20\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(50)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"50\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(100)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"100\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(200)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"200\n                                                    ")])])]),t._v(" "),n("div",{staticClass:"row col-xl-12 col-12"},[n("div",{staticClass:"col-xl-6 col-3"},[n("el-input",{ref:"enter_amount",attrs:{id:"inputTotal"},on:{blur:function(e){return t.diferen()},input:function(e){return t.enterAmount()}},nativeOn:{keyup:function(e){if(!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter"))return null;t.sendPayment(),t.inputAmount(t.form.enter_amount)}},model:{value:t.form.enter_amount,callback:function(e){t.$set(t.form,"enter_amount",e)},expression:"\n                                                            form.enter_amount\n                                                        "}},[n("template",{slot:"prepend"},[t._v(t._s(t.currencyTypeActive.symbol))])],2)],1),t._v(" "),n("div",{staticClass:"m-2 col-xl-2 col-2"},[n("el-button",{attrs:{type:"primary"},on:{click:t.addPayment}},[t._v("Agregar")])],1),t._v(" "),n("div",{staticClass:"m-2 col-xl-3 col-3 "},[n("el-button",{attrs:{type:"success"},on:{click:function(e){t.showSplitPayment=!0}}},[t._v("Dividir\n                                                        pago")])],1)])])]):t._e(),t._v(" "),n("div",{staticClass:" row col-xl-4"},[n("div",{staticClass:"col-xl-5",staticStyle:{"margin-bottom":"10px"}})])]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-xl-3"}),t._v(" "),n("div",{staticClass:"col-xl-5"}),t._v(" "),n("div",{staticClass:"col-xl-4"},[n("div",{staticClass:"form-group d-flex flex-row align-items-end",class:{"has-danger":t.form.difference<0}},[n("label",{staticClass:"control-label display-4",domProps:{textContent:t._s(t.form.difference<0?"Faltante: ":"Vuelto: ")}}),t._v(" "),n("span",{staticClass:"control-label font-weight-semibold text-center display-3 "},[t._v("\n                                                "+t._s(t.currencyTypeActive.symbol)+t._s(t.form.difference.toFixed(2)))])])])])])])])])]),t._v(" "),0!=t.splitPayments.length?n("div",{staticClass:"row m-1 p-2  bg-light rounded"},[n("span",{staticStyle:{"margin-bottom":"5px"}},[t._v("Pagos divididos")]),t._v(" "),n("div",{staticClass:"d-flex flex-wrap "},t._l(t.splitPayments,function(e,a){return n("div",{key:a,staticClass:"col-2"},[t._v("\n                        Pago "+t._s(a+1)+":\n                        "),n("strong",[t._v("S/. "+t._s(e.amount))])])}),0)]):t._e(),t._v(" "),0!=t.splitProducts.length?n("div",{staticClass:"row m-1 p-2  bg-light rounded"},[n("span",{staticStyle:{"margin-bottom":"5px"}},[t._v("Pagos divididos por producto")]),t._v(" "),n("div",{staticClass:"d-flex flex-wrap "},t._l(t.splitProducts,function(e,a){return n("div",{key:a,staticClass:"col-3 m-1"},[e.products&&e.products.length>0?n("table",{staticClass:"col-12"},[n("thead",[n("tr",{class:"bg-primary text-white border rounded-top",attrs:{role:"button"},on:{click:function(e){return t.selectAccount(a)}}},[n("th",{staticClass:"text-center",attrs:{colspan:"3"}},[n("b",[t._v(" CUENTA "+t._s(a+1)+" ")])])])]),t._v(" "),e.products&&e.products.length>0?n("tbody",{staticClass:"border rounded-top "},[t._l(e.products,function(e,a){return n("tr",{key:a},[n("td",[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            "+t._s(e.quantity)+"\n                                        ")])]),t._v(" "),n("td",[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            "+t._s(e.description)+"\n                                        ")])]),t._v(" "),n("td",{staticStyle:{"text-align":"right"}},[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            "+t._s(e.price*e.quantity)+"\n                                        ")])])])}),t._v(" "),n("tr",[n("td",{staticClass:"text-muted text-small",staticStyle:{"text-align":"right"},attrs:{colspan:"2"}},[n("b",[t._v(" Total")])]),t._v(" "),n("td",{staticClass:"text-muted text-small"},[t._v("\n                                        S/.\n                                        "+t._s(t.totalItemSelected(e.products))+"\n                                    ")])])],2):n("tbody",{staticClass:"border"},[n("tr",[n("td",{staticClass:"text-center",attrs:{colspan:"3"}},[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            Sin productos seleccionados\n                                        ")])])])])]):t._e()])}),0)]):t._e(),t._v(" "),n("div",{staticClass:"p-3"},[n("div",{staticClass:"row "},[n("div",{staticClass:"col-lg-4"},[n("div",{staticClass:"btn-group btn-group-square",attrs:{role:"group"}},[n("button",{staticClass:"btn btn-block btn-primary",attrs:{disabled:t.button_payment},on:{click:t.sendPayment}},[n("i",{staticClass:"fas fa-money-bill-alt"}),t._v("\n                                PAGAR\n                            ")]),t._v(" "),n("button",{staticClass:"btn btn-block btn-dark",on:{click:function(e){return t.back(!1)}}},[n("i",{staticClass:"fa fa-reply"}),t._v(" Cerrar\n                            ")])])])])])]),t._v(" "),n("multiple-payment-form",{attrs:{showDialog:t.showDialogMultiplePayment,payments:t.payments},on:{"update:showDialog":function(e){t.showDialogMultiplePayment=e},"update:show-dialog":function(e){t.showDialogMultiplePayment=e},add:t.addRow}}),t._v(" "),n("card-brands-form",{attrs:{showDialog:t.showDialogNewCardBrand,external:!0,recordId:null},on:{"update:showDialog":function(e){t.showDialogNewCardBrand=e},"update:show-dialog":function(e){t.showDialogNewCardBrand=e}}}),t._v(" "),n("person-form",{attrs:{showDialog:t.showDialogNewPerson,type:"customers",input_person:t.input_person,external:!0,user_id:t.form.user_id,document_type_id:t.form.document_type_id,recordId:t.form.customer_id},on:{"update:showDialog":function(e){t.showDialogNewPerson=e},"update:show-dialog":function(e){t.showDialogNewPerson=e},"update:user_id":function(e){return t.$set(t.form,"user_id",e)},add_customer:t.add_customer}}),t._v(" "),n("show-split-payment-form",{attrs:{orden_items:t.orden_items,total:t.form.total,showSplitPayment:t.showSplitPayment},on:{receivePayments:t.receivePayments,receiveProducts:t.receiveProducts,"update:showSplitPayment":function(e){t.showSplitPayment=e},"update:show-split-payment":function(e){t.showSplitPayment=e}}})],1)])},staticRenderFns:[]}},E8J9:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("En79"),r=n.n(a),o=n("M4fF"),s=n.n(o),i=n("38N9");n.n(i);function c(t){return function(t){if(Array.isArray(t))return d(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||u(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function l(t,e){var n="undefined"!=typeof Symbol&&t[Symbol.iterator]||t["@@iterator"];if(!n){if(Array.isArray(t)||(n=u(t))||e&&t&&"number"==typeof t.length){n&&(t=n);var a=0,r=function(){};return{s:r,n:function(){return a>=t.length?{done:!0}:{done:!1,value:t[a++]}},e:function(t){throw t},f:r}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var o,s=!0,i=!1;return{s:function(){n=n.call(t)},n:function(){var t=n.next();return s=t.done,t},e:function(t){i=!0,o=t},f:function(){try{s||null==n.return||n.return()}finally{if(i)throw o}}}}function u(t,e){if(t){if("string"==typeof t)return d(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);return"Object"===n&&t.constructor&&(n=t.constructor.name),"Map"===n||"Set"===n?Array.from(t):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?d(t,e):void 0}}function d(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,a=new Array(e);n<e;n++)a[n]=t[n];return a}function m(t,e,n,a,r,o,s){try{var i=t[o](s),c=i.value}catch(t){return void n(t)}i.done?e(c):Promise.resolve(c).then(a,r)}function f(t){return function(){var e=this,n=arguments;return new Promise(function(a,r){var o=t.apply(e,n);function s(t){m(o,a,r,s,i,"next",t)}function i(t){m(o,a,r,s,i,"throw",t)}s(void 0)})}}e.default={components:{CardBrandsForm:function(){return n.e(112).then(n.bind(null,"c39N"))},MultiplePaymentForm:function(){return n.e(120).then(n.bind(null,"p40F"))},PersonForm:function(){return n.e(99).then(n.bind(null,"N7nD"))},ShowSplitPaymentForm:function(){return n.e(115).then(n.bind(null,"s3Ks"))}},props:["customer_default","customer_variation","variation","establishments","formVariation","documentsType","orden_items","cash_id","form","exchangeRateSale","is_payment","soapCompany","direct_printing","auth_login","payments","configuration","idOrden","company","desarrollador","percentage_igv","all_series","all_customers","personalWhatsapp"],watch:{all_customers:function(t,e){this.customers=t.filter(function(t){return"88888888"!=t.number})}},data:function(){return{started:!0,refCustomer:null,currentDocumentsType:[],time:null,splitPayments:[],splitProducts:[],isInterno:!1,showSplitPayment:!1,currencyTypeActive:{symbol:"S/ "},currentPayments:[],input_person:{},customer:null,value:null,paymentsValue:{"01":"Efectivo","02":"Culqui","03":"Yape","04":"PLIN","05":"TARJETA: IZYPAY","06":"TARJETA: NIUBIZ"},last_number:{},showDialogNewPerson:!1,loading:!1,enabled_discount:!1,discount_amount:0,loading_submit:!1,showDialogOptions:!1,showDialogMultiplePayment:!1,showDialogSaleNote:!1,showDialogNewCardBrand:!1,documentNewId:null,saleNotesNewId:null,resource_options:null,has_card:!1,method_payments:"01",number:null,resource:"pos",resource_documents:"documents",resource_payments:"document_payments",amount:0,printerOn:0,button_payment:!1,input_item:"",form_payment:{},series:[],cards_brand:[],cancel:!1,form_cash_document:{},statusDocument:{},payment_method_types:[],last_date:null,customers:[],datEmision:{disabledDate:function(t){return t.getTime()>moment()}},activeColo:"black"}},created:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.loading=!0,t.currentDocumentsType=t.documentsType,t.form.identity_document_type_id=t.currentDocumentsType[0].id,t.form.customer_id=t.establishments.customer_id,t.value=t.establishments.customer_id,t.isInterno="03"==t.company.soap_type_id,e.next=8,t.date_of_issue();case 8:return e.next=10,t.getLastNumbersDocument();case 10:return e.next=12,t.initFormPayment();case 12:return e.next=14,t.setInitialAmount();case 14:return t.$eventHub.$on("reloadDataCardBrands",function(e){t.reloadDataCardBrands(e)}),e.next=17,t.$eventHub.$on("reloadDataPersons",function(e){t.reloadDataCustomers(e)});case 17:return e.next=19,t.getFormPosLocalStorage();case 19:qz.security.setCertificatePromise(function(e,n){t.$http.get("/api/qz/crt/override",{responseType:"text"}).then(function(t){e(t.data)}).catch(function(t){n(t.data)})}),qz.security.setSignaturePromise(function(e){return function(n,a){t.$http.post("/api/qz/signing",{request:e}).then(function(t){n(t.data)}).catch(function(t){a(t.data)})}}),t.setAmountCash(t.form.total),t.filterSeries(),t.loading=!1;case 24:case"end":return e.stop()}},e)}))()},mounted:function(){},methods:{existNumber:function(){var t=this.form.customer_telephone;return!!t.startsWith("9")&&(9==t.length&&!isNaN(Number(t)))},createClient:function(){this.value=null,this.form.document_type_id,this.form.customer_id=null,this.showDialogNewPerson=!0},reloadDataCustomers:function(t){var e=this;return f(r.a.mark(function n(){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:e.$http.get("/pos/table/customers").then(function(){var n=f(r.a.mark(function n(a){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,e.$emit("update:all_customers",a.data);case 2:e.value=t,e.form.customer_id=t,e.changeCustomer();case 5:case"end":return n.stop()}},n)}));return function(t){return n.apply(this,arguments)}}());case 1:case"end":return n.stop()}},n)}))()},totalItemSelected:function(t){var e=0;return t.forEach(function(t){e+=t.quantity*t.price}),s.a.round(e,2)},receivePayments:function(t){this.splitPayments=t},receiveProducts:function(t){this.splitProducts=t},removePayment:function(t){this.currentPayments=this.currentPayments.filter(function(e){return e.id!=t}),this.enterAmount()},addPayment:function(){var t=this.currentPayments.length+1,e=this.paymentsValue[this.method_payments];""==this.form.enter_amount||isNaN(this.form.enter_amount)||void 0==this.form.enter_amount||(this.currentPayments.push({id:t,method_payment_id:this.method_payments,method:e,amount:this.form.enter_amount}),this.form.enter_amount=void 0)},customerForm:function(t){this.form.customer_id=t?void 0:this.value,this.showDialogNewPerson=!0},add_customer:function(t){},reloadDataPersons:function(){},keyupCustomer:function(t){var e=this;this.time&&clearTimeout(this.time),this.time=setTimeout(f(r.a.mark(function t(){var n,a;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e.input_person.number=e.$refs.select_person.$el.getElementsByTagName("input")[0].value,t.next=3,e.$http("/restaurant/search_customers?value=".concat(e.input_person.number));case 3:n=t.sent,a=n.data.persons,e.customers=a.filter(function(t){return"88888888"!=t.number}),e.updateAllCustomers(e.customers);case 7:case"end":return t.stop()}},t)})),500)},updateAllCustomers:function(t){var e=this;return f(r.a.mark(function n(){var a,o,s,i,u,d;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:a=e.all_customers.map(function(t){return t.id}),o=[],s=l(t);try{for(u=function(){var t=i.value;void 0==a.find(function(e){return e==t.id})&&o.push(t)},s.s();!(i=s.n()).done;)u()}catch(t){s.e(t)}finally{s.f()}if(d=[].concat(c(e.all_customers),o),0==o.length){n.next=8;break}return n.next=8,e.$emit("update:all_customers",d);case 8:case"end":return n.stop()}},n)}))()},changeCustomer:function(){this.form.customer_id=this.value;var t=s.a.find(this.customers,{id:this.form.customer_id});null!=t&&(this.customer=t,"80"!=this.form.document_type_id&&("1"==t.identity_document_type_id||"4"==t.identity_document_type_id?this.form.document_type_id="03":this.form.document_type_id="01"),this.form.customer_telephone=t.phone,this.setLocalStorageIndex("customer",this.customer)),this.setSeries()},setLocalStorageIndex:function(t,e){localStorage.setItem(t,JSON.stringify(e))},getLastNumbersDocument:function(){var t=this;return f(r.a.mark(function e(){var n;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$http.post("".concat(t.resource,"/last_number_documents"),{series:t.all_series,ordenId:t.idOrden});case 2:200==(n=e.sent).status&&(t.last_number=n.data.result,t.refCustomer=n.data.customer,null!=t.refCustomer&&(t.refCustomer.description="".concat(t.refCustomer.number," - ").concat(t.refCustomer.name),t.customers=[t.refCustomer].concat(c(t.customers.filter(function(e){return e.id!=t.refCustomer.id&&"88888888"!=e.number}))),t.value=t.refCustomer.id));case 4:case"end":return e.stop()}},e)}))()},changeEnabledDiscount:function(){this.enabled_discount||(this.discount_amount=0,this.deleteDiscountGlobal(),this.reCalculateTotal())},teclasInit:function(){var t=this;document.onkeydown=function(e){var n=e.key;"F7"==n&&t.form.items.length}},date_of_issue:function(){var t=this;return f(r.a.mark(function e(){var n;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.customers=t.all_customers.filter(function(t){return"88888888"!=t.number}),t.customers=[].concat(c(t.customers.filter(function(e){return e.id!=t.customer_default.id})),[t.customer_default]),t.establishments.customer_id&&(t.value=t.establishments.customer_id,t.form.customer_id=t.establishments.customer_id),n={enter_amount:0,difference:0},e.next=6,t.$http.post("/efectivo",n);case 6:e.sent;case 7:case"end":return e.stop()}},e)}))()},Printer:function(t,e,n){var a=arguments,o=this;return f(r.a.mark(function s(){var i,c,l,u,d,m,f,p;return r.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(i=a.length>3&&void 0!==a[3]?a[3]:null,c=a.length>4&&void 0!==a[4]&&a[4],qz.security.setCertificatePromise(function(t,e){o.$http.get("/api/qz/crt/override",{responseType:"text"}).then(function(e){t(e.data)}).catch(function(t){e(t.data)})}),qz.security.setSignaturePromise(function(t){return function(e,n){o.$http.post("/api/qz/signing",{request:t}).then(function(t){e(t.data)}).catch(function(t){n(t.data)})}}),1!=o.printerOn){r.next=22;break}if(1!=c){r.next=14;break}if(o.auth_login!=i){r.next=14;break}if(l=qz.configs.create(t,{scaleContent:!1}),qz.websocket.isActive()){r.next=11;break}return r.next=11,qz.websocket.connect(l);case 11:for(u=[{type:"pdf",format:"file",data:e}],qz.print(l,u).catch(function(t){o.$toast.error(t.message)}),d=0;d<n;d++)qz.print(l,u).catch(function(t){o.$toast.error(t.message)});case 14:if(0!=c){r.next=22;break}if(m=qz.configs.create(t,{scaleContent:!1}),qz.websocket.isActive()){r.next=19;break}return r.next=19,qz.websocket.connect(m);case 19:for(f=[{type:"pdf",format:"file",data:e}],qz.print(m,f).catch(function(t){o.$toast.error(t.message)}),p=0;p<n;p++)qz.print(m,f).catch(function(t){o.$toast.error(t.message)});case 22:case"end":return r.stop()}},s)}))()},clickSendWhatsapp:function(t,e,n){var a=arguments,o=this;return f(r.a.mark(function s(){var i,c,l;return r.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(null==(i=a.length>3&&void 0!==a[3]?a[3]:{}).customer_telephone){r.next=23;break}return c={id:o.recordId,document_id:e,document_type_id:t,customer_telephone:i.customer_telephone,sender:"sdrimsac",mensaje:"Su comprobante de pago electrónico "+n+" de *"+o.company.name+"*, ha sido generado correctamente a través del facturador electrónico de *Sdrimsac Solutions*"},r.prev=3,o.loading=!0,r.next=7,o.$http.post("/whatsapp",c);case 7:if(1==(l=r.sent).data.success&&(o.$toast.success(l.data.message),o.loading=!1),!o.configuration.xml_whatsapp||"80"==t){r.next=15;break}return c.xml=!0,r.next=13,o.$http.post("/whatsapp",c);case 13:1==(l=r.sent).data.success&&(o.$toast.success(l.data.message),o.loading=!1);case 15:r.next=20;break;case 17:r.prev=17,r.t0=r.catch(3),console.log(r.t0," error");case 20:return r.prev=20,o.loading=!1,r.finish(20);case 23:case"end":return r.stop()}},s,null,[[3,17,20,23]])}))()},changeDateOfIssue:function(){var t=this;this.form.date_of_due=this.form.date_of_issue,moment(this.form.date_of_issue)<moment().day(-1)&&this.configuration.restrict_receipt_date?(this.$toast.error("No puede seleccionar una fecha menor a 6 días."),this.dateValid=!1):this.dateValid=!0,this.form.date_of_due=this.form.date_of_issue,this.searchExchangeRateByDate(this.form.date_of_issue).then(function(e){t.form.exchange_rate_sale=e}),this.form.exchange_rate_sale=1},NuevaVenta:function(){this.$parent.nueva_venta()},setInitialAmount:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.enter_amount=t.form.total,t.form.payments=t.payments,e.next=4,t.$refs.enter_amount.$el.getElementsByTagName("input")[0].focus();case 4:return e.next=6,t.$refs.enter_amount.$el.getElementsByTagName("input")[0].select();case 6:case"end":return e.stop()}},e)}))()},inputDiscountAmount:function(){if(this.enabled_discount)if(this.discount_amount&&!isNaN(this.discount_amount)&&parseFloat(this.discount_amount)>0){if(this.discount_amount>=this.form.total)return this.$toast.error("El monto de descuento debe ser menor al total de venta");this.reCalculateTotal()}else this.deleteDiscountGlobal(),this.reCalculateTotal()},discountGlobal:function(){var t=parseFloat(this.discount_amount),e=parseFloat(this.form.total),n=parseFloat(t),a=s.a.round(n/e,4),r=s.a.find(this.form.discounts,{discount_type_id:"03"});if(t>0&&!r)this.form.total_discount=s.a.round(n,2),this.form.total=s.a.round(this.form.total-n,2),this.form.total_value=s.a.round(this.form.total/(1+this.percentage_igv/100),2),this.form.total_taxed=this.form.total_value,this.form.total_igv=s.a.round(this.form.total_value*(this.percentage_igv/100),2),this.form.total_taxes=this.form.total_igv,this.form.discounts.push({discount_type_id:"03",description:"Descuentos globales que no afectan la base imponible del IGV/IVAP",factor:a,amount:n,base:e});else{var o=this.form.discounts.indexOf(r);o>-1&&(this.form.total_discount=s.a.round(n,2),this.form.total=s.a.round(this.form.total-n,2),this.form.total_value=s.a.round(this.form.total/(1+this.percentage_igv/100),2),this.form.total_taxed=this.form.total_value,this.form.total_igv=s.a.round(this.form.total_value*(this.percentage_igv/100),2),this.form.total_taxes=this.form.total_igv,this.form.discounts[o].base=e,this.form.discounts[o].amount=n,this.form.discounts[o].factor=a)}},method_payment:function(t){this.form.payment_condition_id="01",this.form.method_pay=t,this.form.afectar_caja=!0},reCalculateTotal:function(){var t=0,e=0,n=0,a=0,r=0,o=0,i=0,c=0,l=0;this.form.items.forEach(function(s){parseFloat(s.total_discount),parseFloat(s.total_charge),"10"===s.affectation_igv_type_id&&(e+=parseFloat(s.total_value)),"20"===s.affectation_igv_type_id&&(n+=parseFloat(s.total_value)),"30"===s.affectation_igv_type_id&&(a+=parseFloat(s.total_value)),"40"===s.affectation_igv_type_id&&(t+=parseFloat(s.total_value)),["10","20","30","40"].indexOf(s.affectation_igv_type_id)<0&&(r+=parseFloat(s.total_value)),["10","20","30","40"].indexOf(s.affectation_igv_type_id)>-1&&(o+=parseFloat(s.total_igv),c+=parseFloat(s.total)),i+=parseFloat(s.total_value),l+=isNaN(parseFloat(s.total_plastic_bag_taxes))?0:parseFloat(s.total_plastic_bag_taxes)}),this.form.total_exportation=s.a.round(t,2),this.form.total_taxed=s.a.round(e,2),this.form.total_exonerated=s.a.round(n,2),this.form.total_unaffected=s.a.round(a,2),this.form.total_free=s.a.round(r,2),this.form.total_igv=s.a.round(o,2),this.form.total_value=s.a.round(i,2),this.form.total_taxes=s.a.round(o,2),this.form.total_plastic_bag_taxes=s.a.round(l,2),this.form.total=s.a.round(c+this.form.total_plastic_bag_taxes,2),this.discountGlobal()},deleteDiscountGlobal:function(){var t=s.a.find(this.form.discounts,{discount_type_id:"03"}),e=this.form.discounts.indexOf(t);e>-1&&(this.form.discounts.splice(e,1),this.form.total_discount=0)},getFormPosLocalStorage:function(){var t=localStorage.getItem("form_pos");(t=JSON.parse(t))&&(this.form.payments=t.payments)},clickAddPayment:function(){this.showDialogMultiplePayment=!0},reloadDataCardBrands:function(t){var e=this;this.$http.get("/".concat(this.resource,"/table/card_brands")).then(function(n){e.cards_brand=n.data,e.form_payment.card_brand_id=t,e.changePaymentMethodType()})},getDescriptionPaymentMethodType:function(t){var e=s.a.find(this.payment_method_types,{id:t});return e?e.description:""},changePaymentMethodType:function(){var t=s.a.find(this.payment_method_types,{id:this.form_payment.payment_method_type_id});this.has_card=t.has_card,this.form_payment.card_brand_id=t.has_card?this.form_payment.card_brand_id:null},addRow:function(t){this.form.payments=t;var e=0;this.form.payments.forEach(function(t){e+=parseFloat(t.payment)}),this.setAmount(e)},setAmount:function(t){this.form.enter_amount=t,this.amount=parseFloat(t),this.inputAmount(t)},setAmountCash:function(t){this.setAmount(t)},diferen:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:(parseFloat(t.form.enter_amount)||0)+t.totalPayments()-parseFloat(t.form.total)<0&&t.$toast.error("El monto de efectivo es menor al total de venta");case 2:case"end":return e.stop()}},e)}))()},totalPayments:function(){if(0!=this.currentPayments.length){var t=0;return this.currentPayments.forEach(function(e){t+=parseFloat(e.amount)}),t}return 0},enterAmount:function(){var t=arguments,e=this;return f(r.a.mark(function n(){var a,o,s;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:a=t.length>0&&void 0!==t[0]?t[0]:0,e.amount=a,o=(parseFloat(e.form.enter_amount)||0)+e.totalPayments(),s=o-parseFloat(e.form.total),e.form.difference=parseFloat(s),e.form.difference<0?(e.button_payment=!0,e.form.difference=s):e.form.difference>=0?(e.button_payment=!1,parseFloat(e.form.enter_amount),parseFloat(e.form.total)):e.button_payment=!0,e.$eventHub.$emit("eventSetFormPosLocalStorage",e.form);case 7:case"end":return n.stop()}},n)}))()},getLocalStoragePayment:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=localStorage.getItem(t);return(n=JSON.parse(n))||e},setLocalStoragePayment:function(t,e){return localStorage.setItem(t,JSON.stringify(e))},inputAmount:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.enterAmount(t),this.form.difference=this.form.enter_amount-this.form.total,isNaN(this.form.difference)?(this.button_payment=!0,this.form.difference="-"):this.form.difference>=0?(this.button_payment=!1,this.form.difference=this.amount-this.form.total):this.button_payment=!0,this.$eventHub.$emit("eventSetFormPosLocalStorage",this.form)},lStoPayment:function(){this.setLocalStoragePayment("enter_amount",this.form.enter_amount),this.setLocalStoragePayment("amount",0==this.amount?this.form.total:this.amount),this.setLocalStoragePayment("difference",0==this.amount?this.form.total-this.amount:0)},initFormPayment:function(){this.form.difference=this.form.total-this.form.enter_amount,this.form_payment={id:null,date_of_payment:moment().format("YYYY-MM-DD"),payment_method_type_id:"01",reference:null,card_brand_id:null,document_id:null,sale_note_id:null,payment:this.form.total},this.form_cash_document={document_id:null,sale_note_id:null}},cleanLocalStoragePayment:function(){this.setLocalStoragePayment("form_pos",null),this.setLocalStoragePayment("amount",null),this.setLocalStoragePayment("enter_amount",null),this.setLocalStoragePayment("difference",null)},sleep:function(t){return new Promise(function(e){return setTimeout(e,t)})},passBoxes:function(t,e){var n=e.reduce(function(t,e){return t+e.amount},0)-t,a=!1;n<0&&(a=!0,n*=-1);var r=c(e);if(0!=n)for(var o=0;o<r.length;o++){var s=r[o];if(a?(s.amount+=n,n=0):s.amount-n>0&&(s.amount-=n,n=0),0==n)break}return r},sendPayment:function(t){var e=arguments,n=this;return f(r.a.mark(function t(){var a,o,s;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return(a=e.length>1&&void 0!==e[1]?e[1]:null)||(a=n.form),a.printerOn=1==n.printerOn,t.next=5,n.clickPayment(a);case 5:if(0==n.formVariation.items.length){t.next=21;break}if((o=n.formVariation).printerOn=!1,o.document_type_id="80",o.customer_telephone=null,o.customer_id=n.customer_variation.id,n.customers=[].concat(c(n.customers.filter(function(t){return t!=n.customer_variation.id})),[n.customer_variation]),o.boxes=n.passBoxes(n.formVariation.total,n.form.boxes),!(s=n.all_series.find(function(t){return"80"==t.document_type_id}))){t.next=20;break}return o.series_id=s.id,t.next=18,n.clickPayment(o);case 18:t.next=21;break;case 20:n.$toast.error("Sin serie en nota de venta");case 21:case"end":return t.stop()}},t)}))()},clickPayment:function(t){var e=this;return f(r.a.mark(function n(){var a,o,s,i,c,l;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(a=e.customers.find(function(e){return e.id==t.customer_id}),null==t.customer_telephone){n.next=5;break}if(e.existNumber()){n.next=5;break}return e.$toast.error("Número para envío whatsapp inválido"),n.abrupt("return");case 5:if(null!=t.customer_id&&""!=t.customer_id){n.next=7;break}return n.abrupt("return",e.$toast.error("Elija un cliente"));case 7:if("1"!=a.identity_document_type_id||"01"!=t.document_type_id){n.next=9;break}return n.abrupt("return",e.$toast.error("No puede emitir Factura con DNI"));case 9:if(t.series_id){n.next=11;break}return n.abrupt("return",e.$toast.warning("El establecimiento no tiene series disponibles para el comprobante"));case 11:if("80"===t.document_type_id?(t.prefix="NV",t.paid=1,e.resource_documents="sale-notes",e.resource_payments="sale_note_payments",e.resource_options=e.resource_documents):(t.prefix=null,e.resource_documents="documents",e.resource_payments="document_payments",e.resource_options=e.resource_documents),null!=e.orden&&(t.additional_information="Orden N°".concat(e.orden)),t.advances=0,t.total_advances=0,t.total_payment=t.total,t.payments=[{payment_method_type_id:"01",date_of_payment:t.date_of_issue,payment:t.total}],t.cash_id=e.cash_id,t.boxes=e.currentPayments,e.addPayment(),e.loading_submit=!0,n.prev=21,{enter_amount:t.enter_amount,difference:t.difference},void 0!=(o=e.idOrden)&&null!=o||void 0!=t.variation&&null!=t.variation){n.next=31;break}return n.next=27,e.$http.post("/restaurant/worker/send-orden",e.orden_items);case 27:if(s=n.sent,o=s.data.id,200==s.status){n.next=31;break}return n.abrupt("return");case 31:return t.orden_id=o,n.next=34,e.$http.post("/".concat(e.resource_documents),t);case 34:if(200!=(i=n.sent).status){n.next=69;break}if(1!=i.data.success){n.next=67;break}if(0,"80"===t.document_type_id?(e.number=i.data.data.number,i.data.data.id,e.form_cash_document.sale_note_id=i.data.data.id):(i.data.data.id,e.form_cash_document.document_id=i.data.data.id,e.number=i.data.data.number),e.documentNewId=i.data.data.id,1!=i.data.success){n.next=67;break}if(!o){n.next=64;break}return n.next=44,e.$http.post("pos/orden_payment",{id:o,customer_id:a.id,document:{isNoteSale:"80"===t.document_type_id,id:e.documentNewId}});case 44:if(1!=n.sent.data.success){n.next=62;break}if(!e.form.customer_telephone){n.next=59;break}if(!e.personalWhatsapp){n.next=52;break}return n.next=50,e.$emit("getFile",{documentId:e.documentNewId,documentTypeId:t.document_type_id,number:e.form.customer_telephone,message:e.form.message});case 50:n.next=54;break;case 52:return n.next=54,e.clickSendWhatsapp(t.document_type_id,e.documentNewId,e.number,t);case 54:e.$emit("limpiarForm"),e.loading_submit=!1,e.back(!0),n.next=62;break;case 59:e.$emit("limpiarForm"),e.loading_submit=!1,e.back(!0);case 62:n.next=67;break;case 64:e.$emit("limpiarForm"),e.loading_submit=!1,e.back(!0);case 67:n.next=71;break;case 69:e.loading_submit=!0,e.$alert("<strong>Ocurrio un error </strong>"+i.statusCode+"<br>"+e.resource_documents,"HTML String",{dangerouslyUseHTMLString:!0});case 71:n.next=80;break;case 73:n.prev=73,n.t0=n.catch(21),console.log(n.t0),c=n.t0.response,l=c.data.message,e.$toast.error(l||"Ocurrió un error"),e.loading_submit=!1;case 80:case"end":return n.stop()}},n,null,[[21,73]])}))()},clickPrintPos:function(t,e){var n=arguments,a=this;return f(r.a.mark(function o(){var s,i;return r.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(n.length>2&&void 0!==n[2]?n[2]:null,r.prev=1,s=qz.configs.create(t,{legacy:!0},{scaleContent:!1}),qz.websocket.isActive()){r.next=6;break}return r.next=6,qz.websocket.connect(s);case 6:i=[{type:"pdf",format:"file",data:e}],qz.print(s,i).catch(function(t){a.$toast.error(t.message)}),r.next=13;break;case 10:r.prev=10,r.t0=r.catch(1),a.$toast.error(r.t0.message);case 13:case"end":return r.stop()}},o,null,[[1,10]])}))()},saveCashDocument:function(){var t=this;this.$http.post("/cash/cash_document",this.form_cash_document).then(function(e){e.data.success||t.$toast.error(e.data.message)}).catch(function(t){console.log(t)})},savePaymentMethod:function(){var t=this;this.$http.post("/".concat(this.resource_payments),this.form_payment).then(function(e){e.data.success||t.$toast.error(e.data.message)}).catch(function(e){422===e.response.status?t.records[index].errors=e.response.data:console.log(e)})},getTables:function(){this.filterSeries()},clickCancel:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.loading_submit=!0,t.loading_submit=!1,t.cleanLocalStoragePayment(),t.$eventHub.$emit("cancelSale");case 4:case"end":return e.stop()}},e)}))()},back:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0];this.splitPayments=[],t||this.$emit("openDrawer"),this.$emit("update:is_payment",!1)},initLStoPayment:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getLocalStoragePayment("amount",t.form.total);case 2:return t.amount=e.sent,e.next=5,t.getLocalStoragePayment("enter_amount",t.form.total);case 5:return t.form.enter_amount=e.sent,e.next=8,t.getLocalStoragePayment("difference",t.form.total-t.form.enter_amount);case 8:t.form.difference=e.sent;case 9:case"end":return e.stop()}},e)}))()},checkCustomers:function(){return"01"==this.form.document_type_id?this.customers.some(function(t){return"6"==t.identity_document_type_id}):this.customers.some(function(t){return"1"==t.identity_document_type_id})},setSeries:function(){var t=this;this.form.series_id=null,this.series=s.a.filter(this.all_series,{document_type_id:this.form.document_type_id}),this.series.forEach(function(e){e.full_number="".concat(e.number,"-").concat(t.last_number[e.number]||"1")||e.number}),this.form.series_id=this.series.length>0?this.series[0].id:null},filterSeries:function(){var t=this;if(!this.checkCustomers()&&!this.started){var e="DNI";return"01"==this.form.document_type_id?(e="RUC",this.form.document_type_id="03"):this.form.document_type_id="01",this.$toast.warning("Digite el número de ".concat(e)),void this.setSeries()}this.started=!1,"01"==this.form.document_type_id?(this.currentDocumentsType=c(this.documentsType.filter(function(t){return"RUC"==t.description})),this.form.identity_document_type_id=this.currentDocumentsType[0].id):this.currentDocumentsType=this.documentsType,this.setSeries();var n=null;if(null!=this.value&&(n=this.all_customers.find(function(e){return e.id==t.value})),"01"==this.form.document_type_id)if(this.customers=this.all_customers.filter(function(t){return"6"==t.identity_document_type_id}),0==this.customers.length)this.$toast.warning("Digite el número de RUC"),this.form.document_type_id;else{if(n&&this.customers.some(function(t){return t.id==n.id}))return;this.value=this.customers[0].id,this.form.customer_telephone=this.customers[0].phone}else if("03"==this.form.document_type_id||"80"==this.form.document_type_id){if(this.customers=this.all_customers.filter(function(t){return"6"!=t.identity_document_type_id}),this.form.total>300&&(this.customers=this.customers.filter(function(t){return"1"==t.identity_document_type_id})),n&&this.customers.some(function(t){return t.id==n.id}))return;var a=this.customers.find(function(t){return t.name.toLowerCase().includes("varios")});a?(this.value=a.id,this.form.customer_telephone=a.phone):(this.value=this.customers[0].id,this.form.customer_telephone=this.customers[0].phone)}else this.customers=this.all_customers;this.customers=this.customers.filter(function(t){return"88888888"!=t.number}),this.customers=[].concat(c(this.customers.filter(function(e){return e.id!=t.customer_default.id})),[this.customer_default]),this.changeCustomer()}}}},"QeH/":function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".algunaClase .el-dialog .el-dialog__header .el-dialog__title{font-size:35px!important}.el-scrollbar{z-index:2000!important}.c-width{width:80px!important;padding:0!important;margin-right:0!important}.control-label,h4,h5,label{color:#000}",""])},uLqX:function(t,e,n){var a=n("QeH/");"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);n("rjj0")("15477698",a,!0,{})},wArv:function(t,e,n){var a=n("VU/8")(n("E8J9"),n("AhJO"),!1,function(t){n("uLqX")},null,null);t.exports=a.exports}});
//# sourceMappingURL=105.js.map
>>>>>>> master
=======
webpackJsonp([105],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-385e4f75\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-385e4f75", Component.options)
  } else {
    hotAPI.reload("data-v-385e4f75", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_lodash__ = __webpack_require__("./node_modules/lodash/lodash.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_lodash___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_lodash__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_print_js__ = __webpack_require__("./node_modules/print-js/dist/print.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_print_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_print_js__);
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
// import * as shajs from 'sha.js';

 //import CardBrandsForm from "../../../../../../../../resources/js/views/card_brands/form.vue";
// import SaleNotesOptions from '../../sale_notes/partials/options.vue'
//import OptionsForm from './options.vue'
//import MultiplePaymentForm from "./multiple_payment.vue";
//import PersonForm from "../../../../../../../../resources/js/views/persons/form.vue";
//import ShowSplitPaymentForm from "./split_payment.vue";

var CardBrandsForm = function CardBrandsForm() {
  return __webpack_require__.e/* import() */(112).then(__webpack_require__.bind(null, "./resources/js/views/card_brands/form.vue"));
};

var MultiplePaymentForm = function MultiplePaymentForm() {
  return __webpack_require__.e/* import() */(120).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/multiple_payment.vue"));
};

var PersonForm = function PersonForm() {
  return __webpack_require__.e/* import() */(99/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/views/persons/form.vue"));
};

var ShowSplitPaymentForm = function ShowSplitPaymentForm() {
  return __webpack_require__.e/* import() */(115).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/split_payment.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    CardBrandsForm: CardBrandsForm,
    MultiplePaymentForm: MultiplePaymentForm,
    PersonForm: PersonForm,
    ShowSplitPaymentForm: ShowSplitPaymentForm
  },
  props: ["customer_default", "customer_variation", "variation", "establishments", "formVariation", "documentsType", "orden_items", "cash_id", "form", "exchangeRateSale", "is_payment", "soapCompany", "direct_printing", "auth_login", "payments", "configuration", "idOrden", "company", "desarrollador", "percentage_igv", "all_series", "all_customers", "personalWhatsapp"],
  watch: {
    all_customers: function all_customers(newCustomer, _) {
      this.customers = newCustomer.filter(function (n) {
        return n.number != "88888888";
      });
    }
  },
  data: function data() {
    return {
      started: true,
      refCustomer: null,
      currentDocumentsType: [],
      time: null,
      splitPayments: [],
      splitProducts: [],
      isInterno: false,
      showSplitPayment: false,
      currencyTypeActive: {
        symbol: "S/ "
      },
      currentPayments: [],
      input_person: {},
      customer: null,
      value: null,
      paymentsValue: {
        "01": "Efectivo",
        "02": "Culqui",
        "03": "Yape",
        "04": "PLIN",
        "05": "TARJETA: IZYPAY",
        "06": "TARJETA: NIUBIZ"
      },
      last_number: {},
      showDialogNewPerson: false,
      loading: false,
      enabled_discount: false,
      discount_amount: 0,
      loading_submit: false,
      showDialogOptions: false,
      showDialogMultiplePayment: false,
      showDialogSaleNote: false,
      showDialogNewCardBrand: false,
      documentNewId: null,
      saleNotesNewId: null,
      resource_options: null,
      has_card: false,
      method_payments: "01",
      number: null,
      resource: "pos",
      resource_documents: "documents",
      resource_payments: "document_payments",
      amount: 0,
      printerOn: 0,
      button_payment: false,
      input_item: "",
      form_payment: {},
      series: [],
      cards_brand: [],
      cancel: false,
      form_cash_document: {},
      statusDocument: {},
      payment_method_types: [],
      last_date: null,
      customers: [],
      datEmision: {
        disabledDate: function disabledDate(time) {
          return time.getTime() > moment();
        }
      },
      activeColo: "black"
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.loading = true;
              _this.currentDocumentsType = _this.documentsType;
              _this.form.identity_document_type_id = _this.currentDocumentsType[0].id;
              _this.form.customer_id = _this.establishments.customer_id;
              _this.value = _this.establishments.customer_id;
              _this.isInterno = _this.company.soap_type_id == "03"; // await this.getTables();

              _context.next = 8;
              return _this.date_of_issue();

            case 8:
              _context.next = 10;
              return _this.getLastNumbersDocument();

            case 10:
              _context.next = 12;
              return _this.initFormPayment();

            case 12:
              _context.next = 14;
              return _this.setInitialAmount();

            case 14:
              _this.$eventHub.$on("reloadDataCardBrands", function (card_brand_id) {
                _this.reloadDataCardBrands(card_brand_id);
              });

              _context.next = 17;
              return _this.$eventHub.$on("reloadDataPersons", function (customer_id) {
                _this.reloadDataCustomers(customer_id);
              });

            case 17:
              _context.next = 19;
              return _this.getFormPosLocalStorage();

            case 19:
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

              _this.setAmountCash(_this.form.total);

              _this.filterSeries();

              _this.loading = false;

            case 24:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  mounted: function mounted() {},
  methods: {
    existNumber: function existNumber() {
      var number = this.form.customer_telephone;

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
    createClient: function createClient() {
      this.value = null;
      this.form.document_type_id;
      this.form.customer_id = null;
      this.showDialogNewPerson = true;
    },
    reloadDataCustomers: function reloadDataCustomers(customer_id) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this2.$http.get("/pos/table/customers").then( /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2(response) {
                    return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
                      while (1) {
                        switch (_context2.prev = _context2.next) {
                          case 0:
                            _context2.next = 2;
                            return _this2.$emit("update:all_customers", response.data);

                          case 2:
                            _this2.value = customer_id;
                            _this2.form.customer_id = customer_id;

                            _this2.changeCustomer();

                          case 5:
                          case "end":
                            return _context2.stop();
                        }
                      }
                    }, _callee2);
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }());

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    totalItemSelected: function totalItemSelected(products) {
      var total = 0;
      products.forEach(function (p) {
        total += p.quantity * p.price;
      });
      return __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total, 2);
    },
    receivePayments: function receivePayments(payments) {
      this.splitPayments = payments;
    },
    receiveProducts: function receiveProducts(payments) {
      this.splitProducts = payments;
    },
    removePayment: function removePayment(id) {
      this.currentPayments = this.currentPayments.filter(function (c) {
        return c.id != id;
      });
      this.enterAmount();
    },
    addPayment: function addPayment() {
      var id = this.currentPayments.length + 1;
      var method = this.paymentsValue[this.method_payments];

      if (this.form.enter_amount != "" && !isNaN(this.form.enter_amount) && this.form.enter_amount != undefined) {
        this.currentPayments.push({
          id: id,
          method_payment_id: this.method_payments,
          method: method,
          amount: this.form.enter_amount
        });
        this.form.enter_amount = undefined;
      }
    },
    customerForm: function customerForm(isNew) {
      if (isNew) {
        this.form.customer_id = undefined;
      } else {
        this.form.customer_id = this.value;
      }

      this.showDialogNewPerson = true;
    },
    add_customer: function add_customer(value) {},
    reloadDataPersons: function reloadDataPersons() {},
    keyupCustomer: function keyupCustomer(e) {
      var _this3 = this;

      //buscar
      if (this.time) {
        clearTimeout(this.time);
      }

      this.time = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response, persons;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this3.input_person.number = _this3.$refs.select_person.$el.getElementsByTagName("input")[0].value;
                _context4.next = 3;
                return _this3.$http("/restaurant/search_customers?value=".concat(_this3.input_person.number));

              case 3:
                response = _context4.sent;
                persons = response.data.persons;
                _this3.customers = persons.filter(function (n) {
                  return n.number != "88888888";
                });

                _this3.updateAllCustomers(_this3.customers);

              case 7:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      })), 500);
    },
    updateAllCustomers: function updateAllCustomers(personsFromServer) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var ids, persons, _iterator, _step, _loop, newData;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                ids = _this4.all_customers.map(function (c) {
                  return c.id;
                });
                persons = [];
                _iterator = _createForOfIteratorHelper(personsFromServer);

                try {
                  _loop = function _loop() {
                    var person = _step.value;
                    var existInList = ids.find(function (p) {
                      return p == person.id;
                    });

                    if (existInList == undefined) {
                      persons.push(person);
                    }
                  };

                  for (_iterator.s(); !(_step = _iterator.n()).done;) {
                    _loop();
                  }
                } catch (err) {
                  _iterator.e(err);
                } finally {
                  _iterator.f();
                }

                newData = [].concat(_toConsumableArray(_this4.all_customers), persons);

                if (!(persons.length != 0)) {
                  _context5.next = 8;
                  break;
                }

                _context5.next = 8;
                return _this4.$emit("update:all_customers", newData);

              case 8:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    changeCustomer: function changeCustomer() {
      this.form.customer_id = this.value;

      var customer = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.customers, {
        id: this.form.customer_id
      });

      if (customer != null) {
        this.customer = customer;

        if (this.form.document_type_id != "80") {
          if (customer.identity_document_type_id == "1" || customer.identity_document_type_id == "4") {
            this.form.document_type_id = "03";
          } else {
            this.form.document_type_id = "01";
          }
        }

        this.form.customer_telephone = customer.phone;
        this.setLocalStorageIndex("customer", this.customer);
      }

      this.setSeries();
    },
    setLocalStorageIndex: function setLocalStorageIndex(key, obj) {
      localStorage.setItem(key, JSON.stringify(obj));
    },
    getLastNumbersDocument: function getLastNumbersDocument() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _context6.next = 2;
                return _this5.$http.post("".concat(_this5.resource, "/last_number_documents"), {
                  series: _this5.all_series,
                  ordenId: _this5.idOrden
                });

              case 2:
                response = _context6.sent;

                if (response.status == 200) {
                  _this5.last_number = response.data.result;
                  _this5.refCustomer = response.data.customer;

                  if (_this5.refCustomer != null) {
                    _this5.refCustomer.description = "".concat(_this5.refCustomer.number, " - ").concat(_this5.refCustomer.name);
                    _this5.customers = [_this5.refCustomer].concat(_toConsumableArray(_this5.customers.filter(function (f) {
                      return f.id != _this5.refCustomer.id && f.number != "88888888";
                    })));
                    _this5.value = _this5.refCustomer.id;
                  }
                }

              case 4:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    changeEnabledDiscount: function changeEnabledDiscount() {
      if (!this.enabled_discount) {
        this.discount_amount = 0;
        this.deleteDiscountGlobal();
        this.reCalculateTotal();
      }
    },
    teclasInit: function teclasInit() {
      var _this6 = this;

      document.onkeydown = function (e) {
        var key = e.key;

        if (key == "F4") {//Agregar cliente
          // this.clickPayment();
        }

        if (key == "F6") {//Agregar Producto
          //this.clickAddItemInvoice()
          //return false;
        }

        if (key == "F7" && _this6.form.items.length > 0) {//Guardar
          // this.submit()
        }

        if (key == "F8") {//Cancelar
          // this.close()
        }
      };
    },
    date_of_issue: function date_of_issue() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee7() {
        var form_efectivo, response_efectivo;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                // this.form.customer_id
                _this7.customers = _this7.all_customers.filter(function (n) {
                  return n.number != "88888888";
                });
                _this7.customers = [].concat(_toConsumableArray(_this7.customers.filter(function (c) {
                  return c.id != _this7.customer_default.id;
                })), [_this7.customer_default]);

                if (_this7.establishments.customer_id) {
                  _this7.value = _this7.establishments.customer_id;
                  _this7.form.customer_id = _this7.establishments.customer_id;
                }

                form_efectivo = {
                  enter_amount: 0,
                  difference: 0
                };
                _context7.next = 6;
                return _this7.$http.post("/efectivo", form_efectivo);

              case 6:
                response_efectivo = _context7.sent;

              case 7:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    Printer: function Printer(_Printer, linkpdf, copies) {
      var _arguments = arguments,
          _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee8() {
        var auth, multiple_boxes, config, data, _index, _config, _data, _index2;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                auth = _arguments.length > 3 && _arguments[3] !== undefined ? _arguments[3] : null;
                multiple_boxes = _arguments.length > 4 && _arguments[4] !== undefined ? _arguments[4] : false;
                qz.security.setCertificatePromise(function (resolve, reject) {
                  _this8.$http.get("/api/qz/crt/override", {
                    responseType: "text"
                  }).then(function (response) {
                    resolve(response.data);
                  })["catch"](function (error) {
                    reject(error.data);
                  });
                });
                qz.security.setSignaturePromise(function (toSign) {
                  return function (resolve, reject) {
                    _this8.$http.post("/api/qz/signing", {
                      request: toSign
                    }).then(function (response) {
                      resolve(response.data);
                    })["catch"](function (error) {
                      reject(error.data);
                    });
                  };
                });

                if (!(_this8.printerOn == 1)) {
                  _context8.next = 22;
                  break;
                }

                if (!(multiple_boxes == true)) {
                  _context8.next = 14;
                  break;
                }

                if (!(_this8.auth_login == auth)) {
                  _context8.next = 14;
                  break;
                }

                config = qz.configs.create(_Printer, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context8.next = 11;
                  break;
                }

                _context8.next = 11;
                return qz.websocket.connect(config);

              case 11:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: linkpdf
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this8.$toast.error(e.message);
                });

                for (_index = 0; _index < copies; _index++) {
                  qz.print(config, data)["catch"](function (e) {
                    _this8.$toast.error(e.message);
                  });
                }

              case 14:
                if (!(multiple_boxes == false)) {
                  _context8.next = 22;
                  break;
                }

                _config = qz.configs.create(_Printer, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context8.next = 19;
                  break;
                }

                _context8.next = 19;
                return qz.websocket.connect(_config);

              case 19:
                _data = [{
                  type: "pdf",
                  format: "file",
                  data: linkpdf
                }];
                qz.print(_config, _data)["catch"](function (e) {
                  _this8.$toast.error(e.message);
                });

                for (_index2 = 0; _index2 < copies; _index2++) {
                  qz.print(_config, _data)["catch"](function (e) {
                    _this8.$toast.error(e.message);
                  });
                }

              case 22:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    clickSendWhatsapp: function clickSendWhatsapp(document_type_id, document_id, number) {
      var _arguments2 = arguments,
          _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee9() {
        var form, formWhatsapp, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                form = _arguments2.length > 3 && _arguments2[3] !== undefined ? _arguments2[3] : {};

                if (!(form.customer_telephone != null)) {
                  _context9.next = 23;
                  break;
                }

                formWhatsapp = {
                  id: _this9.recordId,
                  document_id: document_id,
                  document_type_id: document_type_id,
                  customer_telephone: form.customer_telephone,
                  sender: "sdrimsac",
                  mensaje: "Su comprobante de pago electrónico " + number + " de *" + _this9.company.name + "*, ha sido generado correctamente a través del facturador electrónico de *Sdrimsac Solutions*"
                };
                _context9.prev = 3;
                _this9.loading = true;
                _context9.next = 7;
                return _this9.$http.post("/whatsapp", formWhatsapp);

              case 7:
                response = _context9.sent;

                if (response.data.success == true) {
                  _this9.$toast.success(response.data.message);

                  _this9.loading = false;
                }

                if (!(_this9.configuration.xml_whatsapp && document_type_id != "80")) {
                  _context9.next = 15;
                  break;
                }

                formWhatsapp.xml = true;
                _context9.next = 13;
                return _this9.$http.post("/whatsapp", formWhatsapp);

              case 13:
                response = _context9.sent;

                if (response.data.success == true) {
                  _this9.$toast.success(response.data.message);

                  _this9.loading = false;
                }

              case 15:
                _context9.next = 20;
                break;

              case 17:
                _context9.prev = 17;
                _context9.t0 = _context9["catch"](3);
                console.log(_context9.t0, " error");

              case 20:
                _context9.prev = 20;
                _this9.loading = false;
                return _context9.finish(20);

              case 23:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9, null, [[3, 17, 20, 23]]);
      }))();
    },
    changeDateOfIssue: function changeDateOfIssue() {
      var _this10 = this;

      this.form.date_of_due = this.form.date_of_issue;

      if (moment(this.form.date_of_issue) < moment().day(-1) && this.configuration.restrict_receipt_date) {
        this.$toast.error("No puede seleccionar una fecha menor a 6 días.");
        this.dateValid = false;
      } else {
        this.dateValid = true;
      }

      this.form.date_of_due = this.form.date_of_issue;
      this.searchExchangeRateByDate(this.form.date_of_issue).then(function (response) {
        _this10.form.exchange_rate_sale = response;
      });
      this.form.exchange_rate_sale = 1;
    },
    NuevaVenta: function NuevaVenta() {
      this.$parent.nueva_venta();
    },
    setInitialAmount: function setInitialAmount() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee10() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                _this11.enter_amount = _this11.form.total;
                _this11.form.payments = _this11.payments;
                _context10.next = 4;
                return _this11.$refs.enter_amount.$el.getElementsByTagName("input")[0].focus();

              case 4:
                _context10.next = 6;
                return _this11.$refs.enter_amount.$el.getElementsByTagName("input")[0].select();

              case 6:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    inputDiscountAmount: function inputDiscountAmount() {
      if (this.enabled_discount) {
        if (this.discount_amount && !isNaN(this.discount_amount) && parseFloat(this.discount_amount) > 0) {
          if (this.discount_amount >= this.form.total) return this.$toast.error("El monto de descuento debe ser menor al total de venta");
          this.reCalculateTotal();
        } else {
          this.deleteDiscountGlobal();
          this.reCalculateTotal();
        }
      }
    },
    discountGlobal: function discountGlobal() {
      var global_discount = parseFloat(this.discount_amount);
      var base = parseFloat(this.form.total);
      var amount = parseFloat(global_discount);

      var factor = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount / base, 4);

      var discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.form.discounts, {
        discount_type_id: "03"
      });

      if (global_discount > 0 && !discount) {
        this.form.total_discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount, 2);
        this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total - amount, 2);
        this.form.total_value = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total / (1 + this.percentage_igv / 100), 2);
        this.form.total_taxed = this.form.total_value;
        this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total_value * (this.percentage_igv / 100), 2);
        this.form.total_taxes = this.form.total_igv;
        this.form.discounts.push({
          discount_type_id: "03",
          description: "Descuentos globales que no afectan la base imponible del IGV/IVAP",
          factor: factor,
          amount: amount,
          base: base
        });
      } else {
        var _index3 = this.form.discounts.indexOf(discount);

        if (_index3 > -1) {
          this.form.total_discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount, 2);
          this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total - amount, 2);
          this.form.total_value = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total / (1 + this.percentage_igv / 100), 2);
          this.form.total_taxed = this.form.total_value;
          this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total_value * (this.percentage_igv / 100), 2);
          this.form.total_taxes = this.form.total_igv;
          this.form.discounts[_index3].base = base;
          this.form.discounts[_index3].amount = amount;
          this.form.discounts[_index3].factor = factor;
        }
      }
    },
    method_payment: function method_payment(method_pay) {
      this.form.payment_condition_id = "01";
      this.form.method_pay = method_pay;
      this.form.afectar_caja = true;
    },
    reCalculateTotal: function reCalculateTotal() {
      var total_discount = 0;
      var total_charge = 0;
      var total_exportation = 0;
      var total_taxed = 0;
      var total_exonerated = 0;
      var total_unaffected = 0;
      var total_free = 0;
      var total_igv = 0;
      var total_value = 0;
      var total = 0;
      var total_plastic_bag_taxes = 0;
      this.form.items.forEach(function (row) {
        total_discount += parseFloat(row.total_discount);
        total_charge += parseFloat(row.total_charge);

        if (row.affectation_igv_type_id === "10") {
          total_taxed += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "20") {
          total_exonerated += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "30") {
          total_unaffected += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "40") {
          total_exportation += parseFloat(row.total_value);
        }

        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) < 0) {
          total_free += parseFloat(row.total_value);
        }

        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) > -1) {
          total_igv += parseFloat(row.total_igv);
          total += parseFloat(row.total);
        }

        total_value += parseFloat(row.total_value);
        total_plastic_bag_taxes += isNaN(parseFloat(row.total_plastic_bag_taxes)) ? 0.0 : parseFloat(row.total_plastic_bag_taxes);
      });
      this.form.total_exportation = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_exportation, 2);
      this.form.total_taxed = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_taxed, 2);
      this.form.total_exonerated = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_exonerated, 2);
      this.form.total_unaffected = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_unaffected, 2);
      this.form.total_free = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_free, 2);
      this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_igv, 2);
      this.form.total_value = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_value, 2);
      this.form.total_taxes = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_igv, 2);
      this.form.total_plastic_bag_taxes = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_plastic_bag_taxes, 2); // this.form.total = _.round(total, 2)

      this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total + this.form.total_plastic_bag_taxes, 2);
      this.discountGlobal();
    },
    deleteDiscountGlobal: function deleteDiscountGlobal() {
      var discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.form.discounts, {
        discount_type_id: "03"
      });

      var index = this.form.discounts.indexOf(discount);

      if (index > -1) {
        this.form.discounts.splice(index, 1);
        this.form.total_discount = 0;
      }
    },
    getFormPosLocalStorage: function getFormPosLocalStorage() {
      var form_pos = localStorage.getItem("form_pos");
      form_pos = JSON.parse(form_pos);

      if (form_pos) {
        this.form.payments = form_pos.payments;
      }
    },
    clickAddPayment: function clickAddPayment() {
      this.showDialogMultiplePayment = true;
    },
    reloadDataCardBrands: function reloadDataCardBrands(card_brand_id) {
      var _this12 = this;

      this.$http.get("/".concat(this.resource, "/table/card_brands")).then(function (response) {
        _this12.cards_brand = response.data;
        _this12.form_payment.card_brand_id = card_brand_id;

        _this12.changePaymentMethodType();
      });
    },
    getDescriptionPaymentMethodType: function getDescriptionPaymentMethodType(id) {
      var payment_method_type = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.payment_method_types, {
        id: id
      });

      return payment_method_type ? payment_method_type.description : "";
    },
    changePaymentMethodType: function changePaymentMethodType() {
      var payment_method_type = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.payment_method_types, {
        id: this.form_payment.payment_method_type_id
      });

      this.has_card = payment_method_type.has_card;
      this.form_payment.card_brand_id = payment_method_type.has_card ? this.form_payment.card_brand_id : null;
    },
    addRow: function addRow(payments) {
      this.form.payments = payments;
      var acum_payment = 0;
      this.form.payments.forEach(function (item) {
        acum_payment += parseFloat(item.payment);
      }); // this.amount = acum_payment

      this.setAmount(acum_payment); // console.log(this.form.payments)
    },
    setAmount: function setAmount(amount) {
      // this.amount = parseFloat(this.amount) + parseFloat(amount)
      this.form.enter_amount = amount;
      this.amount = parseFloat(amount); //+ parseFloat(amount)
      //   this.form.enter_amount =  parseFloat(amount) //+ parseFloat(amount)

      this.inputAmount(amount);
    },
    setAmountCash: function setAmountCash(amount) {
      this.setAmount(amount);
    },
    diferen: function diferen() {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee11() {
        var differen;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                differen = (parseFloat(_this13.form.enter_amount) || 0) + _this13.totalPayments() - parseFloat(_this13.form.total);

                if (differen < 0) {
                  _this13.$toast.error("El monto de efectivo es menor al total de venta");
                }

              case 2:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    totalPayments: function totalPayments() {
      if (this.currentPayments.length != 0) {
        var enter_amount = 0.0;
        this.currentPayments.forEach(function (cp) {
          enter_amount += parseFloat(cp.amount);
        });
        return enter_amount;
      }

      return 0;
    },
    enterAmount: function enterAmount() {
      var _arguments3 = arguments,
          _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee12() {
        var amount, enter_amount, differen;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                amount = _arguments3.length > 0 && _arguments3[0] !== undefined ? _arguments3[0] : 0;
                _this14.amount = amount;
                enter_amount = (parseFloat(_this14.form.enter_amount) || 0) + _this14.totalPayments();
                differen = enter_amount - parseFloat(_this14.form.total);
                _this14.form.difference = parseFloat(differen);

                if (_this14.form.difference < 0) {
                  _this14.button_payment = true;
                  _this14.form.difference = differen;
                } else if (_this14.form.difference >= 0) {
                  _this14.button_payment = false;
                  parseFloat(_this14.form.enter_amount) - parseFloat(_this14.form.total);
                } else {
                  _this14.button_payment = true;
                } //this.form.difference = _.round(this.form.difference, 2);


                _this14.$eventHub.$emit("eventSetFormPosLocalStorage", _this14.form); // this.setAmountCash(amount)


              case 7:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    getLocalStoragePayment: function getLocalStoragePayment(key) {
      var re_default = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      var ls_obj = localStorage.getItem(key);
      ls_obj = JSON.parse(ls_obj);

      if (ls_obj) {
        return ls_obj;
      }

      return re_default;
    },
    setLocalStoragePayment: function setLocalStoragePayment(key, obj) {
      return localStorage.setItem(key, JSON.stringify(obj));
    },
    inputAmount: function inputAmount() {
      var amount = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.enterAmount(amount);
      this.form.difference = this.form.enter_amount - this.form.total;

      if (isNaN(this.form.difference)) {
        this.button_payment = true;
        this.form.difference = "-";
      } else if (this.form.difference >= 0) {
        this.button_payment = false;
        this.form.difference = this.amount - this.form.total;
      } else {
        this.button_payment = true;
      }

      this.$eventHub.$emit("eventSetFormPosLocalStorage", this.form);
    },
    lStoPayment: function lStoPayment() {
      this.setLocalStoragePayment("enter_amount", this.form.enter_amount);
      this.setLocalStoragePayment("amount", this.amount == 0 ? this.form.total : this.amount);
      this.setLocalStoragePayment("difference", this.amount == 0 ? this.form.total - this.amount : 0);
    },
    initFormPayment: function initFormPayment() {
      this.form.difference = this.form.total - this.form.enter_amount;
      this.form_payment = {
        id: null,
        date_of_payment: moment().format("YYYY-MM-DD"),
        payment_method_type_id: "01",
        reference: null,
        card_brand_id: null,
        document_id: null,
        sale_note_id: null,
        payment: this.form.total
      };
      this.form_cash_document = {
        document_id: null,
        sale_note_id: null
      };
    },
    cleanLocalStoragePayment: function cleanLocalStoragePayment() {
      this.setLocalStoragePayment("form_pos", null);
      this.setLocalStoragePayment("amount", null);
      this.setLocalStoragePayment("enter_amount", null);
      this.setLocalStoragePayment("difference", null);
    },
    sleep: function sleep(ms) {
      return new Promise(function (resolve) {
        return setTimeout(resolve, ms);
      });
    },
    passBoxes: function passBoxes(total, boxes) {
      var amounts = boxes.reduce(function (a, b) {
        return a + b.amount;
      }, 0);
      var rest = amounts - total;
      var plus = false;

      if (rest < 0) {
        plus = true;
        rest *= -1;
      }

      var newBoxes = _toConsumableArray(boxes);

      if (rest != 0) {
        for (var i = 0; i < newBoxes.length; i++) {
          var box = newBoxes[i];

          if (plus) {
            box.amount += rest;
            rest = 0;
          } else {
            if (box.amount - rest > 0) {
              box.amount -= rest;
              rest = 0;
            }
          }

          if (rest == 0) {
            break;
          }
        }
      }

      return newBoxes;
    },
    sendPayment: function sendPayment($event) {
      var _arguments4 = arguments,
          _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee13() {
        var form, formVariation, noteVariation;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                form = _arguments4.length > 1 && _arguments4[1] !== undefined ? _arguments4[1] : null;

                if (!form) {
                  form = _this15.form;
                }

                form.printerOn = _this15.printerOn == 1 ? true : false;
                _context13.next = 5;
                return _this15.clickPayment(form);

              case 5:
                if (!(_this15.formVariation.items.length != 0)) {
                  _context13.next = 21;
                  break;
                }

                formVariation = _this15.formVariation;
                formVariation.printerOn = false;
                formVariation.document_type_id = "80";
                formVariation.customer_telephone = null;
                formVariation.customer_id = _this15.customer_variation.id;
                _this15.customers = [].concat(_toConsumableArray(_this15.customers.filter(function (c) {
                  return c != _this15.customer_variation.id;
                })), [_this15.customer_variation]);
                formVariation.boxes = _this15.passBoxes(_this15.formVariation.total, _this15.form.boxes);
                noteVariation = _this15.all_series.find(function (s) {
                  return s.document_type_id == "80";
                });

                if (!noteVariation) {
                  _context13.next = 20;
                  break;
                }

                formVariation.series_id = noteVariation.id;
                _context13.next = 18;
                return _this15.clickPayment(formVariation);

              case 18:
                _context13.next = 21;
                break;

              case 20:
                _this15.$toast.error("Sin serie en nota de venta");

              case 21:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    clickPayment: function clickPayment(form) {
      var _this16 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee14() {
        var customer, form_efectivo, ordenId, responses, response, document_id, response2, _response, message;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                customer = _this16.customers.find(function (c) {
                  return c.id == form.customer_id;
                });

                if (!(form.customer_telephone != null)) {
                  _context14.next = 5;
                  break;
                }

                if (_this16.existNumber()) {
                  _context14.next = 5;
                  break;
                }

                _this16.$toast.error("Número para envío whatsapp inválido");

                return _context14.abrupt("return");

              case 5:
                if (!(form.customer_id == null || form.customer_id == "")) {
                  _context14.next = 7;
                  break;
                }

                return _context14.abrupt("return", _this16.$toast.error("Elija un cliente"));

              case 7:
                if (!(customer.identity_document_type_id == "1" && form.document_type_id == "01")) {
                  _context14.next = 9;
                  break;
                }

                return _context14.abrupt("return", _this16.$toast.error("No puede emitir Factura con DNI"));

              case 9:
                if (form.series_id) {
                  _context14.next = 11;
                  break;
                }

                return _context14.abrupt("return", _this16.$toast.warning("El establecimiento no tiene series disponibles para el comprobante"));

              case 11:
                if (form.document_type_id === "80") {
                  form.prefix = "NV";
                  form.paid = 1;
                  _this16.resource_documents = "sale-notes";
                  _this16.resource_payments = "sale_note_payments";
                  _this16.resource_options = _this16.resource_documents;
                } else {
                  form.prefix = null;
                  _this16.resource_documents = "documents";
                  _this16.resource_payments = "document_payments";
                  _this16.resource_options = _this16.resource_documents;
                }

                if (_this16.orden != null) {
                  form.additional_information = "Orden N\xB0".concat(_this16.orden);
                }

                form.advances = 0.0;
                form.total_advances = 0.0;
                form.total_payment = form.total;
                form.payments = [{
                  payment_method_type_id: "01",
                  date_of_payment: form.date_of_issue,
                  payment: form.total
                }];
                form.cash_id = _this16.cash_id;
                form.boxes = _this16.currentPayments;

                _this16.addPayment();

                _this16.loading_submit = true;
                _context14.prev = 21;
                form_efectivo = {
                  enter_amount: form.enter_amount,
                  difference: form.difference
                };
                ordenId = _this16.idOrden;

                if (!((ordenId == undefined || ordenId == null) && (form.variation == undefined || form.variation == null))) {
                  _context14.next = 31;
                  break;
                }

                _context14.next = 27;
                return _this16.$http.post("/restaurant/worker/send-orden", _this16.orden_items);

              case 27:
                responses = _context14.sent;
                ordenId = responses.data.id;

                if (!(responses.status != 200)) {
                  _context14.next = 31;
                  break;
                }

                return _context14.abrupt("return");

              case 31:
                form.orden_id = ordenId; // const response_efectivo = await this.$http.post(`/efectivo`,form_efectivo);

                _context14.next = 34;
                return _this16.$http.post("/".concat(_this16.resource_documents), form);

              case 34:
                response = _context14.sent;

                if (!(response.status == 200)) {
                  _context14.next = 69;
                  break;
                }

                if (!(response.data.success == true)) {
                  _context14.next = 67;
                  break;
                }

                document_id = 0;

                if (form.document_type_id === "80") {
                  _this16.number = response.data.data.number;
                  document_id = response.data.data.id;
                  _this16.form_cash_document.sale_note_id = response.data.data.id;
                } else {
                  document_id = response.data.data.id;
                  _this16.form_cash_document.document_id = response.data.data.id;
                  _this16.number = response.data.data.number;
                }

                _this16.documentNewId = response.data.data.id;

                if (!(response.data.success == true)) {
                  _context14.next = 67;
                  break;
                }

                if (!ordenId) {
                  _context14.next = 64;
                  break;
                }

                _context14.next = 44;
                return _this16.$http.post("pos/orden_payment", {
                  id: ordenId,
                  customer_id: customer.id,
                  document: {
                    isNoteSale: form.document_type_id === "80",
                    id: _this16.documentNewId
                  }
                });

              case 44:
                response2 = _context14.sent;

                if (!(response2.data.success == true)) {
                  _context14.next = 62;
                  break;
                }

                if (!_this16.form.customer_telephone) {
                  _context14.next = 59;
                  break;
                }

                if (!_this16.personalWhatsapp) {
                  _context14.next = 52;
                  break;
                }

                _context14.next = 50;
                return _this16.$emit("getFile", {
                  documentId: _this16.documentNewId,
                  documentTypeId: form.document_type_id,
                  number: _this16.form.customer_telephone,
                  message: _this16.form.message
                });

              case 50:
                _context14.next = 54;
                break;

              case 52:
                _context14.next = 54;
                return _this16.clickSendWhatsapp(form.document_type_id, _this16.documentNewId, _this16.number, form);

              case 54:
                _this16.$emit("limpiarForm");

                _this16.loading_submit = false;

                _this16.back(true);

                _context14.next = 62;
                break;

              case 59:
                _this16.$emit("limpiarForm");

                _this16.loading_submit = false;

                _this16.back(true);

              case 62:
                _context14.next = 67;
                break;

              case 64:
                _this16.$emit("limpiarForm");

                _this16.loading_submit = false;

                _this16.back(true);

              case 67:
                _context14.next = 71;
                break;

              case 69:
                _this16.loading_submit = true;

                _this16.$alert("<strong>Ocurrio un error </strong>" + response.statusCode + "<br>" + _this16.resource_documents, "HTML String", {
                  dangerouslyUseHTMLString: true
                });

              case 71:
                _context14.next = 80;
                break;

              case 73:
                _context14.prev = 73;
                _context14.t0 = _context14["catch"](21);
                console.log(_context14.t0);
                _response = _context14.t0.response;
                message = _response.data.message;

                _this16.$toast.error(message || "Ocurrió un error");

                _this16.loading_submit = false;

              case 80:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14, null, [[21, 73]]);
      }))();
    },
    clickPrintPos: function clickPrintPos(printerName, formatoPdf) {
      var _arguments5 = arguments,
          _this17 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee15() {
        var userId, config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                userId = _arguments5.length > 2 && _arguments5[2] !== undefined ? _arguments5[2] : null;
                _context15.prev = 1;
                config = qz.configs.create(printerName, {
                  legacy: true
                }, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context15.next = 6;
                  break;
                }

                _context15.next = 6;
                return qz.websocket.connect(config);

              case 6:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: formatoPdf
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this17.$toast.error(e.message);
                });
                _context15.next = 13;
                break;

              case 10:
                _context15.prev = 10;
                _context15.t0 = _context15["catch"](1);

                _this17.$toast.error(_context15.t0.message);

              case 13:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15, null, [[1, 10]]);
      }))();
    },
    saveCashDocument: function saveCashDocument() {
      var _this18 = this;

      this.$http.post("/cash/cash_document", this.form_cash_document).then(function (response) {
        if (response.data.success) {// console.log(response)
        } else {
          _this18.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        console.log(error);
      });
    },
    savePaymentMethod: function savePaymentMethod() {
      var _this19 = this;

      this.$http.post("/".concat(this.resource_payments), this.form_payment).then(function (response) {
        if (response.data.success) {// console.log(response)
        } else {
          _this19.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this19.records[index].errors = error.response.data;
        } else {
          console.log(error);
        }
      });
    },
    getTables: function getTables() {
      this.filterSeries();
    },
    clickCancel: function clickCancel() {
      var _this20 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee16() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee16$(_context16) {
          while (1) {
            switch (_context16.prev = _context16.next) {
              case 0:
                _this20.loading_submit = true;
                _this20.loading_submit = false;

                _this20.cleanLocalStoragePayment();

                _this20.$eventHub.$emit("cancelSale");

              case 4:
              case "end":
                return _context16.stop();
            }
          }
        }, _callee16);
      }))();
    },
    back: function back() {
      var val = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      this.splitPayments = []; //this.$emit("limpiarForm");

      if (!val) {
        this.$emit("openDrawer");
      }

      this.$emit("update:is_payment", false);
    },
    initLStoPayment: function initLStoPayment() {
      var _this21 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee17() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee17$(_context17) {
          while (1) {
            switch (_context17.prev = _context17.next) {
              case 0:
                _context17.next = 2;
                return _this21.getLocalStoragePayment("amount", _this21.form.total);

              case 2:
                _this21.amount = _context17.sent;
                _context17.next = 5;
                return _this21.getLocalStoragePayment("enter_amount", _this21.form.total);

              case 5:
                _this21.form.enter_amount = _context17.sent;
                _context17.next = 8;
                return _this21.getLocalStoragePayment("difference", _this21.form.total - _this21.form.enter_amount);

              case 8:
                _this21.form.difference = _context17.sent;

              case 9:
              case "end":
                return _context17.stop();
            }
          }
        }, _callee17);
      }))();
    },
    checkCustomers: function checkCustomers() {
      if (this.form.document_type_id == "01") {
        return this.customers.some(function (c) {
          return c.identity_document_type_id == "6";
        });
      } else {
        return this.customers.some(function (c) {
          return c.identity_document_type_id == "1";
        });
      }
    },
    setSeries: function setSeries() {
      var _this22 = this;

      this.form.series_id = null;
      this.series = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.filter(this.all_series, {
        document_type_id: this.form.document_type_id
      });
      this.series.forEach(function (s) {
        s.full_number = "".concat(s.number, "-").concat(_this22.last_number[s.number] || "1") || s.number;
      });
      this.form.series_id = this.series.length > 0 ? this.series[0].id : null;
    },
    filterSeries: function filterSeries() {
      var _this23 = this;

      var check = this.checkCustomers();

      if (!check && !this.started) {
        var dcto = "DNI";

        if (this.form.document_type_id == "01") {
          dcto = "RUC";
          this.form.document_type_id = "03";
        } else {
          this.form.document_type_id = "01";
        }

        this.$toast.warning("Digite el n\xFAmero de ".concat(dcto));
        this.setSeries();
        return;
      }

      this.started = false;

      if (this.form.document_type_id == "01") {
        this.currentDocumentsType = _toConsumableArray(this.documentsType.filter(function (f) {
          return f.description == "RUC";
        }));
        this.form.identity_document_type_id = this.currentDocumentsType[0].id;
      } else {
        this.currentDocumentsType = this.documentsType;
      }

      this.setSeries(); //aqui
      //factura solo ruc
      //boletas solo dni
      //note de venta todo

      var currentClient = null;

      if (this.value != null) {
        currentClient = this.all_customers.find(function (c) {
          return c.id == _this23.value;
        }); // if (currentClient.identity_document_type_id == "1") {
        //     this.form.document_type_id = "03";
        // }
      }

      if (this.form.document_type_id == "01") {
        this.customers = this.all_customers.filter(function (f) {
          return f.identity_document_type_id == "6";
        });

        if (this.customers.length == 0) {
          this.$toast.warning("Digite el número de RUC");
          this.form.document_type_id == "03"; // this.customers = this.all_customers;
        } else {
          if (currentClient && this.customers.some(function (c) {
            return c.id == currentClient.id;
          })) {
            return;
          }

          this.value = this.customers[0].id;
          this.form.customer_telephone = this.customers[0].phone;
        }
      } else if (this.form.document_type_id == "03" || this.form.document_type_id == "80") {
        this.customers = this.all_customers.filter(function (f) {
          return f.identity_document_type_id != "6";
        });

        if (this.form.total > 300) {
          this.customers = this.customers.filter(function (c) {
            return c.identity_document_type_id == "1";
          });
        }

        if (currentClient && this.customers.some(function (c) {
          return c.id == currentClient.id;
        })) {
          return;
        }

        var client = this.customers.find(function (c) {
          return c.name.toLowerCase().includes("varios");
        });

        if (client) {
          this.value = client.id;
          this.form.customer_telephone = client.phone;
        } else {
          this.value = this.customers[0].id;
          this.form.customer_telephone = this.customers[0].phone;
        }
      } else {
        this.customers = this.all_customers;
      }

      this.customers = this.customers.filter(function (n) {
        return n.number != "88888888";
      });
      this.customers = [].concat(_toConsumableArray(this.customers.filter(function (n) {
        return n.id != _this23.customer_default.id;
      })), [this.customer_default]);
      this.changeCustomer();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.algunaClase .el-dialog .el-dialog__header .el-dialog__title {\r\n    font-size: 35px !important;\n}\n.el-scrollbar {\r\n    z-index: 2000 !important;\n}\n.c-width {\r\n    width: 80px !important;\r\n    padding: 0 !important;\r\n    margin-right: 0 !important;\n}\n.control-label,\r\nh4,\r\nh5,\r\nlabel {\r\n    color: #000;\n}\r\n/* .el-dialog__header {\r\n    padding: 0px;\r\n}\r\n.el-dialog__body {\r\n    padding: 0px !important;\r\n} */\r\n", "", {"version":3,"sources":["D:/laragon/www/restobar/modules/Restaurant/Resources/assets/js/views/pos/partials/modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue"],"names":[],"mappings":";AA84BA;IACA,2BAAA;CACA;AACA;IACA,yBAAA;CACA;AACA;IACA,uBAAA;IACA,sBAAA;IACA,2BAAA;CACA;AACA;;;;IAIA,YAAA;CACA;AACA;;;;;IAKA","file":"payment.vue","sourcesContent":["<template>\r\n    <el-dialog\r\n        :visible=\"is_payment\"\r\n        @open=\"date_of_issue()\"\r\n        :close-on-click-modal=\"false\"\r\n        :close-on-press-escape=\"false\"\r\n        :modal-append-to-body=\"true\"\r\n        :show-close=\"false\"\r\n        :append-to-body=\"true\"\r\n        width=\"770px\"\r\n        top=\"2vh\"\r\n        :title=\"`MODULO DE COBRO ${variation ? '- Variación' : ''}`\"\r\n        class=\"algunaClase\"\r\n    >\r\n        <div v-loading=\"loading\" class=\" mb-0\">\r\n            <div class=\"pt-1\" v-loading=\"loading_submit\">\r\n                <div class=\"row pt-2\">\r\n                    <div class=\"col-lg-12\">\r\n                        <div class=\"mb-2\">\r\n                            <div class=\"card bg-light\">\r\n                                <div class=\"row \">\r\n                                    <div class=\"  col-md-6 col-lg-5 col-sm-6\">\r\n                                        <label class=\"control-label\"\r\n                                            >Comprobante de Pago\r\n                                        </label>\r\n                                        <div class=\"form-group\">\r\n                                            <el-radio-group\r\n                                                v-model=\"form.document_type_id\"\r\n                                                size=\"small\"\r\n                                                @change=\"\r\n                                                    date_of_issue();\r\n                                                    filterSeries();\r\n                                                \"\r\n                                            >\r\n                                                <template v-if=\"!isInterno\">\r\n                                                    <el-radio-button label=\"01\"\r\n                                                        >FACTURA\r\n                                                    </el-radio-button>\r\n                                                    <el-radio-button label=\"03\">\r\n                                                        BOLETA\r\n                                                    </el-radio-button>\r\n                                                </template>\r\n                                                <el-radio-button\r\n                                                    v-if=\"!variation\"\r\n                                                    label=\"80\"\r\n                                                >\r\n                                                    N. VENTA\r\n                                                </el-radio-button>\r\n                                            </el-radio-group>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div\r\n                                        class=\"col-6 col-md-3 col-lg-3 col-xl-3\"\r\n                                    >\r\n                                        <label class=\"control-label\">\r\n                                            Serie\r\n                                        </label>\r\n                                        <div class=\"form-group\">\r\n                                            <el-select\r\n                                                v-model=\"form.series_id\"\r\n                                                class=\"w-100\"\r\n                                            >\r\n                                                <el-option\r\n                                                    style=\"z-index:2000 !important;\"\r\n                                                    v-for=\"option in series\"\r\n                                                    :key=\"option.id\"\r\n                                                    :label=\"option.full_number\"\r\n                                                    :value=\"option.id\"\r\n                                                >\r\n                                                </el-option>\r\n                                            </el-select>\r\n                                        </div>\r\n                                    </div>\r\n\r\n                                    <div class=\"col-6 col-md-4 col-lg-4 \">\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"control-label\"\r\n                                                >Fecha de Emisión</label\r\n                                            >\r\n                                            <el-date-picker\r\n                                                style=\"width:100%;\"\r\n                                                v-model=\"form.date_of_issue\"\r\n                                                type=\"date\"\r\n                                                value-format=\"yyyy-MM-dd\"\r\n                                                :clearable=\"false\"\r\n                                                format=\"dd-MM-yyyy\"\r\n                                                readonly\r\n                                                :picker-options=\"datEmision\"\r\n                                            >\r\n                                            </el-date-picker>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row \">\r\n                                    <div class=\"col-lg-6 \">\r\n                                        <div class=\"form-group\">\r\n                                            <template>\r\n                                                <div\r\n                                                    class=\"el-input el-input-group col-md-6 \"\r\n                                                    style=\"margin-bottom:3px;\"\r\n                                                >\r\n                                                    <label\r\n                                                        class=\"control-label\"\r\n                                                        style=\"margin-right:3px;\"\r\n                                                        >Seleccion de\r\n                                                        Cliente</label\r\n                                                    >\r\n                                                    <el-button\r\n                                                        :disabled=\"!value\"\r\n                                                        @click=\"\r\n                                                            showDialogNewPerson = true\r\n                                                        \"\r\n                                                        >Editar\r\n                                                        cliente</el-button\r\n                                                    >\r\n                                                    <el-button\r\n                                                        @click=\"createClient\"\r\n                                                        >Nuevo\r\n                                                        cliente</el-button\r\n                                                    >\r\n                                                </div>\r\n                                            </template>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"col-12 col-sm-8 col-lg-6\">\r\n                                        <el-select\r\n                                            class=\"col-md-6\"\r\n                                            ref=\"select_person\"\r\n                                            v-model=\"value\"\r\n                                            filterable\r\n                                            clearable\r\n                                            size=\"small\"\r\n                                            placeholder=\"Cliente\"\r\n                                            :disabled=\"loading\"\r\n                                            @change=\"changeCustomer\"\r\n                                            @keyup.native=\"keyupCustomer\"\r\n                                            @keyup.enter.native=\"\r\n                                                keyupCustomer()\r\n                                            \"\r\n                                        >\r\n                                            <el-option\r\n                                                v-for=\"option in customers\"\r\n                                                :key=\"option.id\"\r\n                                                :label=\"option.description\"\r\n                                                :value=\"option.id\"\r\n                                            ></el-option>\r\n                                        </el-select>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row col-lg-6 col-xl-12\">\r\n                                    <div class=\"form-group\">\r\n                                        <label class=\"control-label\"\r\n                                            >Observaciones</label\r\n                                        >\r\n                                        <el-input\r\n                                            type=\"textarea\"\r\n                                            :rows=\"2\"\r\n                                            v-model=\"form.observation\"\r\n                                        ></el-input>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n\r\n                    <div class=\"col-lg-12\">\r\n                        <div class=\" mb-2 \">\r\n                            <div\r\n                                class=\" text-center text-dark card  bg-light  \"\r\n                            >\r\n                                <div class=\"row\">\r\n                                    <div class=\"  col-lg-12 \">\r\n                                        <div class=\" align-items-start \">\r\n                                            <label class=\"control-label\"\r\n                                                >Medios de Pago</label\r\n                                            >\r\n                                            <label\r\n                                                role=\"button\"\r\n                                                class=\"text-primary control-label\"\r\n                                            ></label>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"radio-tile-group2 flex-wrap\"\r\n                                        >\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"cash\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"01\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'Efectivo'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/botonEfectivo.png') ; background-size: contain ; background-repeat: no-repeat\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon walk-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"cash\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"culqui\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"02\"\r\n                                                    @change=\"\r\n                                                        method_payment('Culqui')\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/CulquiIcon.png') ; background-size: contain ; background-repeat: no-repeat\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"05\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'TARJETA: IZYPAY'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/botonIzipay.png') ; background-size: contain ; background-repeat: no-repeat; \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"06\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'TARJETA: NIUBIZ'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/botonNiubiz.png') ; background-size: contain ; background-repeat: no-repeat; \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"yape\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"03\"\r\n                                                    @change=\"\r\n                                                        method_payment('Yape')\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png') ; background-size: contain ; background-repeat: no-repeat\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"04\"\r\n                                                    @change=\"\r\n                                                        method_payment('PLIN')\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/plin-logo-0C4106153C-seeklogo.com.png') ; background-size: contain ; background-repeat: no-repeat; \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"row col-md-12\">\r\n                                            <div class=\"row\">\r\n                                                <label\r\n                                                    class=\"control-label text-center\"\r\n                                                    >Emision de\r\n                                                    comprobante</label\r\n                                                >\r\n                                            </div>\r\n                                            <div class=\"row\">\r\n                                                <div\r\n                                                    class=\"col-lg-2 col-md-5 col-xl-6\"\r\n                                                >\r\n                                                    <label\r\n                                                        class=\"control-label text-left  d-flex align-items-start justify-content-start\"\r\n                                                    >\r\n                                                        Ingrese Nro Celular\r\n                                                    </label>\r\n                                                    <el-input\r\n                                                        v-model=\"\r\n                                                            form.customer_telephone\r\n                                                        \"\r\n                                                    >\r\n                                                        <template slot=\"prepend\"\r\n                                                            ><i\r\n                                                                class=\"fab fa-whatsapp fa-2x\"\r\n                                                            ></i>\r\n                                                        </template>\r\n                                                    </el-input>\r\n                                                </div>\r\n                                                <div\r\n                                                    class=\"radio-tile-group2 col-lg-6 col-xl-6 d \"\r\n                                                    style=\"padding-top: 12px;\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"input-container2 border rounded-sm col-lg-3\"\r\n                                                    >\r\n                                                        <input\r\n                                                            id=\"imprimir\"\r\n                                                            v-model=\"printerOn\"\r\n                                                            class=\"radio-button2\"\r\n                                                            type=\"radio\"\r\n                                                            name=\"imprimir\"\r\n                                                            value=\"1\"\r\n                                                        />\r\n                                                        <div\r\n                                                            class=\"radio-tile2\"\r\n                                                        >\r\n                                                            <div\r\n                                                                class=\"icon walk-icon\"\r\n                                                            >\r\n                                                                <i\r\n                                                                    class=\"fa fa-print\"\r\n                                                                ></i>\r\n                                                            </div>\r\n                                                            <label\r\n                                                                for=\"cash\"\r\n                                                                class=\"radio-tile-label2\"\r\n                                                                >Imprimir</label\r\n                                                            >\r\n                                                        </div>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"input-container2 border rounded-sm col-lg-3\"\r\n                                                    >\r\n                                                        <input\r\n                                                            id=\"noimprimir\"\r\n                                                            v-model=\"printerOn\"\r\n                                                            class=\"radio-button2\"\r\n                                                            type=\"radio\"\r\n                                                            name=\"noimprimir\"\r\n                                                            value=\"0\"\r\n                                                        />\r\n                                                        <div\r\n                                                            class=\"radio-tile2\"\r\n                                                        >\r\n                                                            <div\r\n                                                                class=\"icon bike-icon\"\r\n                                                            >\r\n                                                                <i\r\n                                                                    class=\"fa fa-print\"\r\n                                                                ></i>\r\n                                                            </div>\r\n                                                            <label\r\n                                                                for=\"Tarjeta\"\r\n                                                                class=\"radio-tile-label2\"\r\n                                                                >No\r\n                                                                Imprimir</label\r\n                                                            >\r\n                                                        </div>\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n\r\n                                        <div class=\"row\">\r\n                                            <div\r\n                                                class=\"col-lg-8  d-flex flex-row align-items-end\"\r\n                                            ></div>\r\n                                            <div\r\n                                                class=\"d-flex flex-column\"\r\n                                            ></div>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"row d-flex justify-content-start\"\r\n                                        >\r\n                                            <table\r\n                                                class=\"table\"\r\n                                                v-if=\"\r\n                                                    currentPayments.length != 0\r\n                                                \"\r\n                                            >\r\n                                                <thead>\r\n                                                    <tr>\r\n                                                        <th\r\n                                                            colspan=\"4\"\r\n                                                            class=\"text-left\"\r\n                                                        >\r\n                                                            Pagos\r\n                                                        </th>\r\n                                                    </tr>\r\n                                                </thead>\r\n                                                <tbody>\r\n                                                    <tr\r\n                                                        v-for=\"(paymnt,\r\n                                                        idx) in currentPayments\"\r\n                                                        :key=\"idx\"\r\n                                                    >\r\n                                                        <td>{{ idx + 1 }}</td>\r\n                                                        <td>\r\n                                                            {{ paymnt.method }}\r\n                                                        </td>\r\n                                                        <td>\r\n                                                            <strong>{{\r\n                                                                paymnt.amount\r\n                                                            }}</strong>\r\n                                                        </td>\r\n                                                        <td>\r\n                                                            <label\r\n                                                                for=\"\"\r\n                                                                role=\"button\"\r\n                                                                @click=\"\r\n                                                                    removePayment(\r\n                                                                        paymnt.id\r\n                                                                    )\r\n                                                                \"\r\n                                                                class=\"text-danger\"\r\n                                                            >\r\n                                                                <i\r\n                                                                    class=\"fa fa-trash\"\r\n                                                                ></i\r\n                                                            ></label>\r\n                                                        </td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                        </div>\r\n                                    </div>\r\n\r\n                                    <div\r\n                                        class=\" card  bg-light col-lg-12  \"\r\n                                    ></div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-lg-12\">\r\n                            <div class=\"mb-2\">\r\n                                <div class=\" card  bg-light \">\r\n                                    <div class=\"row\">\r\n                                        <div\r\n                                            class=\" col-xl-4\"\r\n                                            style=\"margin-top: 10px;padding-top: 5px;\"\r\n                                            :class=\"{\r\n                                                'has-danger':\r\n                                                    form.difference < 0\r\n                                            }\"\r\n                                        >\r\n                                            <label class=\"control-label h1\"\r\n                                                >Total a cobrar: </label\r\n                                            ><br />\r\n                                            <span\r\n                                                class=\"control-label font-weight-semibold text-center h3\"\r\n                                            >\r\n                                                S/ {{ \" \" + form.total }}\r\n                                            </span>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"col-xl-8\"\r\n                                            v-if=\"\r\n                                                form_payment.payment_method_type_id ==\r\n                                                    '01'\r\n                                            \"\r\n                                        >\r\n                                            <div\r\n                                                class=\"btn-group btn-group-square m-0 flex-wrap justify-content-around\"\r\n                                                role=\"group\"\r\n                                                style=\"padding-top: 12px\"\r\n                                            >\r\n                                                <label class=\"control-label\"\r\n                                                    >Ingrese monto</label\r\n                                                >\r\n                                                <div class=\"row col-12\">\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    10\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}10\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    20\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}20\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    50\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}50\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    100\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}100\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary btn_responsive m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    200\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            {{\r\n                                                                currencyTypeActive.symbol\r\n                                                            }}200\r\n                                                        </button>\r\n                                                    </div>\r\n                                                </div>\r\n                                                <div\r\n                                                    class=\"row col-xl-12 col-12\"\r\n                                                >\r\n                                                    <div class=\"col-xl-6 col-3\">\r\n                                                        <el-input\r\n                                                            id=\"inputTotal\"\r\n                                                            ref=\"enter_amount\"\r\n                                                            v-model=\"\r\n                                                                form.enter_amount\r\n                                                            \"\r\n                                                            @blur=\"diferen()\"\r\n                                                            @input=\"\r\n                                                                enterAmount()\r\n                                                            \"\r\n                                                            @keyup.enter.native=\"\r\n                                                                sendPayment();\r\n                                                                inputAmount(\r\n                                                                    form.enter_amount\r\n                                                                );\r\n                                                            \"\r\n                                                        >\r\n                                                            <template\r\n                                                                slot=\"prepend\"\r\n                                                                >{{\r\n                                                                    currencyTypeActive.symbol\r\n                                                                }}</template\r\n                                                            >\r\n                                                        </el-input>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"m-2 col-xl-2 col-2\"\r\n                                                    >\r\n                                                        <el-button\r\n                                                            type=\"primary\"\r\n                                                            @click=\"addPayment\"\r\n                                                            >Agregar</el-button\r\n                                                        >\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"m-2 col-xl-3 col-3 \"\r\n                                                    >\r\n                                                        <el-button\r\n                                                            type=\"success\"\r\n                                                            @click=\"\r\n                                                                showSplitPayment = true\r\n                                                            \"\r\n                                                            >Dividir\r\n                                                            pago</el-button\r\n                                                        >\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\" row col-xl-4\">\r\n                                            <div\r\n                                                class=\"col-xl-5\"\r\n                                                style=\"margin-bottom: 10px\"\r\n                                            ></div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xl-3\"></div>\r\n                                        <div class=\"col-xl-5\"></div>\r\n                                        <div class=\"col-xl-4\">\r\n                                            <div\r\n                                                class=\"form-group d-flex flex-row align-items-end\"\r\n                                                :class=\"{\r\n                                                    'has-danger':\r\n                                                        form.difference < 0\r\n                                                }\"\r\n                                            >\r\n                                                <label\r\n                                                    class=\"control-label display-4\"\r\n                                                    v-text=\"\r\n                                                        form.difference < 0\r\n                                                            ? 'Faltante: '\r\n                                                            : 'Vuelto: '\r\n                                                    \"\r\n                                                ></label>\r\n                                                <span\r\n                                                    class=\"control-label font-weight-semibold text-center display-3 \"\r\n                                                >\r\n                                                    {{\r\n                                                        currencyTypeActive.symbol\r\n                                                    }}{{\r\n                                                        form.difference.toFixed(\r\n                                                            2\r\n                                                        )\r\n                                                    }}</span\r\n                                                >\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div\r\n                    v-if=\"splitPayments.length != 0\"\r\n                    class=\"row m-1 p-2  bg-light rounded\"\r\n                >\r\n                    <span style=\"margin-bottom:5px;\">Pagos divididos</span>\r\n                    <div class=\"d-flex flex-wrap \">\r\n                        <div\r\n                            v-for=\"(payment, idx) in splitPayments\"\r\n                            :key=\"idx\"\r\n                            class=\"col-2\"\r\n                        >\r\n                            Pago {{ idx + 1 }}:\r\n                            <strong>S/. {{ payment.amount }}</strong>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div\r\n                    v-if=\"splitProducts.length != 0\"\r\n                    class=\"row m-1 p-2  bg-light rounded\"\r\n                >\r\n                    <span style=\"margin-bottom:5px;\"\r\n                        >Pagos divididos por producto</span\r\n                    >\r\n                    <div class=\"d-flex flex-wrap \">\r\n                        <div\r\n                            v-for=\"(payment, idx) in splitProducts\"\r\n                            :key=\"idx\"\r\n                            class=\"col-3 m-1\"\r\n                        >\r\n                            <table\r\n                                v-if=\"\r\n                                    payment.products &&\r\n                                        payment.products.length > 0\r\n                                \"\r\n                                class=\"col-12\"\r\n                            >\r\n                                <thead>\r\n                                    <tr\r\n                                        role=\"button\"\r\n                                        @click=\"selectAccount(idx)\"\r\n                                        :class=\"\r\n                                            'bg-primary text-white border rounded-top'\r\n                                        \"\r\n                                    >\r\n                                        <th class=\"text-center\" colspan=\"3\">\r\n                                            <b> CUENTA {{ idx + 1 }} </b>\r\n                                        </th>\r\n                                    </tr>\r\n                                </thead>\r\n                                <tbody\r\n                                    class=\"border rounded-top \"\r\n                                    v-if=\"\r\n                                        payment.products &&\r\n                                            payment.products.length > 0\r\n                                    \"\r\n                                >\r\n                                    <tr\r\n                                        v-for=\"(product,\r\n                                        idx) in payment.products\"\r\n                                        :key=\"idx\"\r\n                                    >\r\n                                        <td>\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                {{ product.quantity }}\r\n                                            </h3>\r\n                                        </td>\r\n                                        <td>\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                {{ product.description }}\r\n                                            </h3>\r\n                                        </td>\r\n                                        <td style=\"text-align:right\">\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                {{\r\n                                                    product.price *\r\n                                                        product.quantity\r\n                                                }}\r\n                                            </h3>\r\n                                        </td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td\r\n                                            colspan=\"2\"\r\n                                            class=\"text-muted text-small\"\r\n                                            style=\"text-align:right\"\r\n                                        >\r\n                                            <b> Total</b>\r\n                                        </td>\r\n                                        <td class=\"text-muted text-small\">\r\n                                            S/.\r\n                                            {{\r\n                                                totalItemSelected(\r\n                                                    payment.products\r\n                                                )\r\n                                            }}\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                                <tbody v-else class=\"border\">\r\n                                    <tr>\r\n                                        <td colspan=\"3\" class=\"text-center\">\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                Sin productos seleccionados\r\n                                            </h3>\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"p-3\">\r\n                    <div class=\"row \">\r\n                        <div class=\"col-lg-4\">\r\n                            <div\r\n                                class=\"btn-group btn-group-square\"\r\n                                role=\"group\"\r\n                            >\r\n                                <button\r\n                                    class=\"btn btn-block btn-primary\"\r\n                                    @click=\"sendPayment\"\r\n                                    :disabled=\"button_payment\"\r\n                                >\r\n                                    <i class=\"fas fa-money-bill-alt\"></i>\r\n                                    PAGAR\r\n                                </button>\r\n                                <button\r\n                                    class=\"btn btn-block btn-dark\"\r\n                                    @click=\"back(false)\"\r\n                                >\r\n                                    <i class=\"fa fa-reply\"></i> Cerrar\r\n                                </button>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n\r\n            <multiple-payment-form\r\n                :showDialog.sync=\"showDialogMultiplePayment\"\r\n                :payments=\"payments\"\r\n                @add=\"addRow\"\r\n            ></multiple-payment-form>\r\n\r\n            <!-- <sale-notes-options :showDialog.sync=\"showDialogSaleNote\"\r\n                          :recordId=\"saleNotesNewId\"\r\n                          :showClose=\"true\"></sale-notes-options>  -->\r\n\r\n            <card-brands-form\r\n                :showDialog.sync=\"showDialogNewCardBrand\"\r\n                :external=\"true\"\r\n                :recordId=\"null\"\r\n            ></card-brands-form>\r\n            <person-form\r\n                :showDialog.sync=\"showDialogNewPerson\"\r\n                type=\"customers\"\r\n                :input_person=\"input_person\"\r\n                :external=\"true\"\r\n                :user_id.sync=\"form.user_id\"\r\n                :document_type_id=\"form.document_type_id\"\r\n                @add_customer=\"add_customer\"\r\n                :recordId=\"form.customer_id\"\r\n            >\r\n            </person-form>\r\n            <show-split-payment-form\r\n                :orden_items=\"orden_items\"\r\n                @receivePayments=\"receivePayments\"\r\n                @receiveProducts=\"receiveProducts\"\r\n                :total=\"form.total\"\r\n                :showSplitPayment.sync=\"showSplitPayment\"\r\n            >\r\n            </show-split-payment-form>\r\n        </div>\r\n    </el-dialog>\r\n</template>\r\n\r\n<style>\r\n.algunaClase .el-dialog .el-dialog__header .el-dialog__title {\r\n    font-size: 35px !important;\r\n}\r\n.el-scrollbar {\r\n    z-index: 2000 !important;\r\n}\r\n.c-width {\r\n    width: 80px !important;\r\n    padding: 0 !important;\r\n    margin-right: 0 !important;\r\n}\r\n.control-label,\r\nh4,\r\nh5,\r\nlabel {\r\n    color: #000;\r\n}\r\n/* .el-dialog__header {\r\n    padding: 0px;\r\n}\r\n.el-dialog__body {\r\n    padding: 0px !important;\r\n} */\r\n</style>\r\n\r\n<script>\r\n// import * as shajs from 'sha.js';\r\nimport _ from \"lodash\";\r\nimport printjs from \"print-js\";\r\n//import CardBrandsForm from \"../../../../../../../../resources/js/views/card_brands/form.vue\";\r\n// import SaleNotesOptions from '../../sale_notes/partials/options.vue'\r\n//import OptionsForm from './options.vue'\r\n//import MultiplePaymentForm from \"./multiple_payment.vue\";\r\n//import PersonForm from \"../../../../../../../../resources/js/views/persons/form.vue\";\r\n//import ShowSplitPaymentForm from \"./split_payment.vue\";\r\n\r\nconst CardBrandsForm = () =>\r\n    import(\"../../../../../../../../resources/js/views/card_brands/form.vue\");\r\nconst MultiplePaymentForm = () => import(\"./multiple_payment.vue\");\r\nconst PersonForm = () =>\r\n    import(\"../../../../../../../../resources/js/views/persons/form.vue\");\r\nconst ShowSplitPaymentForm = () => import(\"./split_payment.vue\");\r\nexport default {\r\n    components: {\r\n        CardBrandsForm,\r\n        MultiplePaymentForm,\r\n        PersonForm,\r\n        ShowSplitPaymentForm\r\n    },\r\n\r\n    props: [\r\n        \"customer_default\",\r\n        \"customer_variation\",\r\n        \"variation\",\r\n        \"establishments\",\r\n        \"formVariation\",\r\n        \"documentsType\",\r\n        \"orden_items\",\r\n        \"cash_id\",\r\n        \"form\",\r\n        \"exchangeRateSale\",\r\n        \"is_payment\",\r\n        \"soapCompany\",\r\n        \"direct_printing\",\r\n        \"auth_login\",\r\n        \"payments\",\r\n        \"configuration\",\r\n        \"idOrden\",\r\n        \"company\",\r\n        \"desarrollador\",\r\n        \"percentage_igv\",\r\n        \"all_series\",\r\n        \"all_customers\",\r\n        \"personalWhatsapp\"\r\n    ],\r\n    watch: {\r\n        all_customers(newCustomer, _) {\r\n            this.customers = newCustomer.filter(n => n.number != \"88888888\");\r\n        }\r\n    },\r\n    data() {\r\n        return {\r\n            started: true,\r\n            refCustomer: null,\r\n            currentDocumentsType: [],\r\n            time: null,\r\n            splitPayments: [],\r\n            splitProducts: [],\r\n            isInterno: false,\r\n            showSplitPayment: false,\r\n            currencyTypeActive: {\r\n                symbol: \"S/ \"\r\n            },\r\n            currentPayments: [],\r\n            input_person: {},\r\n            customer: null,\r\n            value: null,\r\n            paymentsValue: {\r\n                \"01\": \"Efectivo\",\r\n                \"02\": \"Culqui\",\r\n                \"03\": \"Yape\",\r\n                \"04\": \"PLIN\",\r\n                \"05\": \"TARJETA: IZYPAY\",\r\n                \"06\": \"TARJETA: NIUBIZ\"\r\n            },\r\n            last_number: {},\r\n            showDialogNewPerson: false,\r\n            loading: false,\r\n            enabled_discount: false,\r\n            discount_amount: 0,\r\n            loading_submit: false,\r\n            showDialogOptions: false,\r\n            showDialogMultiplePayment: false,\r\n            showDialogSaleNote: false,\r\n            showDialogNewCardBrand: false,\r\n            documentNewId: null,\r\n            saleNotesNewId: null,\r\n            resource_options: null,\r\n            has_card: false,\r\n            method_payments: \"01\",\r\n            number: null,\r\n            resource: \"pos\",\r\n            resource_documents: \"documents\",\r\n            resource_payments: \"document_payments\",\r\n            amount: 0,\r\n            printerOn: 0,\r\n            button_payment: false,\r\n            input_item: \"\",\r\n            form_payment: {},\r\n            series: [],\r\n            cards_brand: [],\r\n            cancel: false,\r\n            form_cash_document: {},\r\n            statusDocument: {},\r\n            payment_method_types: [],\r\n            last_date: null,\r\n            customers: [],\r\n            datEmision: {\r\n                disabledDate(time) {\r\n                    return time.getTime() > moment();\r\n                }\r\n            },\r\n            activeColo: \"black\"\r\n        };\r\n    },\r\n\r\n    async created() {\r\n        this.loading = true;\r\n        this.currentDocumentsType = this.documentsType;\r\n        this.form.identity_document_type_id = this.currentDocumentsType[0].id;\r\n        this.form.customer_id = this.establishments.customer_id;\r\n        this.value = this.establishments.customer_id;\r\n        this.isInterno = this.company.soap_type_id == \"03\";\r\n\r\n        // await this.getTables();\r\n        await this.date_of_issue();\r\n        await this.getLastNumbersDocument();\r\n        await this.initFormPayment();\r\n        await this.setInitialAmount();\r\n        this.$eventHub.$on(\"reloadDataCardBrands\", card_brand_id => {\r\n            this.reloadDataCardBrands(card_brand_id);\r\n        });\r\n        await this.$eventHub.$on(\"reloadDataPersons\", customer_id => {\r\n            this.reloadDataCustomers(customer_id);\r\n        });\r\n\r\n        await this.getFormPosLocalStorage();\r\n\r\n        qz.security.setCertificatePromise((resolve, reject) => {\r\n            this.$http\r\n                .get(\"/api/qz/crt/override\", {\r\n                    responseType: \"text\"\r\n                })\r\n                .then(response => {\r\n                    resolve(response.data);\r\n                })\r\n                .catch(error => {\r\n                    reject(error.data);\r\n                });\r\n        });\r\n\r\n        qz.security.setSignaturePromise(toSign => {\r\n            return (resolve, reject) => {\r\n                this.$http\r\n                    .post(\"/api/qz/signing\", { request: toSign })\r\n                    .then(response => {\r\n                        resolve(response.data);\r\n                    })\r\n                    .catch(error => {\r\n                        reject(error.data);\r\n                    });\r\n            };\r\n        });\r\n\r\n        this.setAmountCash(this.form.total);\r\n\r\n        this.filterSeries();\r\n        this.loading = false;\r\n    },\r\n    mounted() {},\r\n    methods: {\r\n        existNumber() {\r\n            let number = this.form.customer_telephone;\r\n            if (!number.startsWith(\"9\")) {\r\n                return false;\r\n            }\r\n            if (number.length != 9) {\r\n                return false;\r\n            }\r\n            if (isNaN(Number(number))) {\r\n                return false;\r\n            }\r\n            return true;\r\n        },\r\n        createClient() {\r\n            this.value = null;\r\n            this.form.document_type_id;\r\n            this.form.customer_id = null;\r\n            this.showDialogNewPerson = true;\r\n        },\r\n        async reloadDataCustomers(customer_id) {\r\n            this.$http.get(`/pos/table/customers`).then(async response => {\r\n                await this.$emit(\"update:all_customers\", response.data);\r\n                this.value = customer_id;\r\n                this.form.customer_id = customer_id;\r\n                this.changeCustomer();\r\n            });\r\n        },\r\n        totalItemSelected(products) {\r\n            let total = 0;\r\n            products.forEach(p => {\r\n                total += p.quantity * p.price;\r\n            });\r\n\r\n            return _.round(total, 2);\r\n        },\r\n        receivePayments(payments) {\r\n            this.splitPayments = payments;\r\n        },\r\n        receiveProducts(payments) {\r\n            this.splitProducts = payments;\r\n        },\r\n        removePayment(id) {\r\n            this.currentPayments = this.currentPayments.filter(c => c.id != id);\r\n            this.enterAmount();\r\n        },\r\n        addPayment() {\r\n            let id = this.currentPayments.length + 1;\r\n\r\n            let method = this.paymentsValue[this.method_payments];\r\n\r\n            if (\r\n                this.form.enter_amount != \"\" &&\r\n                !isNaN(this.form.enter_amount) &&\r\n                this.form.enter_amount != undefined\r\n            ) {\r\n                this.currentPayments.push({\r\n                    id,\r\n                    method_payment_id: this.method_payments,\r\n                    method,\r\n                    amount: this.form.enter_amount\r\n                });\r\n                this.form.enter_amount = undefined;\r\n            }\r\n        },\r\n        customerForm(isNew) {\r\n            if (isNew) {\r\n                this.form.customer_id = undefined;\r\n            } else {\r\n                this.form.customer_id = this.value;\r\n            }\r\n            this.showDialogNewPerson = true;\r\n        },\r\n        add_customer(value) {},\r\n        reloadDataPersons() {},\r\n        keyupCustomer(e) {\r\n            //buscar\r\n            if (this.time) {\r\n                clearTimeout(this.time);\r\n            }\r\n            this.time = setTimeout(async () => {\r\n                this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(\r\n                    \"input\"\r\n                )[0].value;\r\n                const response = await this.$http(\r\n                    `/restaurant/search_customers?value=${this.input_person.number}`\r\n                );\r\n                const { persons } = response.data;\r\n\r\n                this.customers = persons.filter(n => n.number != \"88888888\");\r\n                this.updateAllCustomers(this.customers);\r\n            }, 500);\r\n        },\r\n        async updateAllCustomers(personsFromServer) {\r\n            let ids = this.all_customers.map(c => c.id);\r\n            let persons = [];\r\n\r\n            for (let person of personsFromServer) {\r\n                let existInList = ids.find(p => p == person.id);\r\n                if (existInList == undefined) {\r\n                    persons.push(person);\r\n                }\r\n            }\r\n            let newData = [...this.all_customers, ...persons];\r\n\r\n            if (persons.length != 0) {\r\n                await this.$emit(\"update:all_customers\", newData);\r\n            }\r\n        },\r\n        changeCustomer() {\r\n            this.form.customer_id = this.value;\r\n            let customer = _.find(this.customers, {\r\n                id: this.form.customer_id\r\n            });\r\n\r\n            if (customer != null) {\r\n                this.customer = customer;\r\n                if (this.form.document_type_id != \"80\") {\r\n                    if (\r\n                        customer.identity_document_type_id == \"1\" ||\r\n                        customer.identity_document_type_id == \"4\"\r\n                    ) {\r\n                        this.form.document_type_id = \"03\";\r\n                    } else {\r\n                        this.form.document_type_id = \"01\";\r\n                    }\r\n                }\r\n\r\n                this.form.customer_telephone = customer.phone;\r\n                this.setLocalStorageIndex(\"customer\", this.customer);\r\n            }\r\n            this.setSeries();\r\n        },\r\n        setLocalStorageIndex(key, obj) {\r\n            localStorage.setItem(key, JSON.stringify(obj));\r\n        },\r\n        async getLastNumbersDocument() {\r\n            const response = await this.$http.post(\r\n                `${this.resource}/last_number_documents`,\r\n                { series: this.all_series, ordenId: this.idOrden }\r\n            );\r\n            if (response.status == 200) {\r\n                this.last_number = response.data.result;\r\n                this.refCustomer = response.data.customer;\r\n                if (this.refCustomer != null) {\r\n                    this.refCustomer.description = `${this.refCustomer.number} - ${this.refCustomer.name}`;\r\n                    this.customers = [\r\n                        this.refCustomer,\r\n                        ...this.customers.filter(\r\n                            f =>\r\n                                f.id != this.refCustomer.id &&\r\n                                f.number != \"88888888\"\r\n                        )\r\n                    ];\r\n\r\n                    this.value = this.refCustomer.id;\r\n                }\r\n            }\r\n        },\r\n        changeEnabledDiscount() {\r\n            if (!this.enabled_discount) {\r\n                this.discount_amount = 0;\r\n                this.deleteDiscountGlobal();\r\n                this.reCalculateTotal();\r\n            }\r\n        },\r\n        teclasInit() {\r\n            document.onkeydown = e => {\r\n                const key = e.key;\r\n\r\n                if (key == \"F4\") {\r\n                    //Agregar cliente\r\n                    // this.clickPayment();\r\n                }\r\n                if (key == \"F6\") {\r\n                    //Agregar Producto\r\n                    //this.clickAddItemInvoice()\r\n                    //return false;\r\n                }\r\n                if (key == \"F7\" && this.form.items.length > 0) {\r\n                    //Guardar\r\n                    // this.submit()\r\n                }\r\n                if (key == \"F8\") {\r\n                    //Cancelar\r\n                    // this.close()\r\n                }\r\n            };\r\n        },\r\n        async date_of_issue() {\r\n            // this.form.customer_id\r\n\r\n            this.customers = this.all_customers.filter(\r\n                n => n.number != \"88888888\"\r\n            );\r\n            this.customers = [\r\n                ...this.customers.filter(c => c.id != this.customer_default.id),\r\n                this.customer_default\r\n            ];\r\n\r\n            if (this.establishments.customer_id) {\r\n                this.value = this.establishments.customer_id;\r\n                this.form.customer_id = this.establishments.customer_id;\r\n            }\r\n\r\n            let form_efectivo = {\r\n                enter_amount: 0,\r\n                difference: 0\r\n            };\r\n            const response_efectivo = await this.$http.post(\r\n                `/efectivo`,\r\n                form_efectivo\r\n            );\r\n        },\r\n        async Printer(\r\n            Printer,\r\n            linkpdf,\r\n            copies,\r\n            auth = null,\r\n            multiple_boxes = false\r\n        ) {\r\n            qz.security.setCertificatePromise((resolve, reject) => {\r\n                this.$http\r\n                    .get(\"/api/qz/crt/override\", {\r\n                        responseType: \"text\"\r\n                    })\r\n                    .then(response => {\r\n                        resolve(response.data);\r\n                    })\r\n                    .catch(error => {\r\n                        reject(error.data);\r\n                    });\r\n            });\r\n            qz.security.setSignaturePromise(toSign => {\r\n                return (resolve, reject) => {\r\n                    this.$http\r\n                        .post(\"/api/qz/signing\", {\r\n                            request: toSign\r\n                        })\r\n                        .then(response => {\r\n                            resolve(response.data);\r\n                        })\r\n                        .catch(error => {\r\n                            reject(error.data);\r\n                        });\r\n                };\r\n            });\r\n            if (this.printerOn == 1) {\r\n                if (multiple_boxes == true) {\r\n                    if (this.auth_login == auth) {\r\n                        let config = qz.configs.create(Printer, {\r\n                            scaleContent: false\r\n                        });\r\n                        if (!qz.websocket.isActive()) {\r\n                            await qz.websocket.connect(config);\r\n                        }\r\n                        let data = [\r\n                            {\r\n                                type: \"pdf\",\r\n                                format: \"file\",\r\n                                data: linkpdf\r\n                            }\r\n                        ];\r\n                        qz.print(config, data).catch(e => {\r\n                            this.$toast.error(e.message);\r\n                        });\r\n                        for (let index = 0; index < copies; index++) {\r\n                            qz.print(config, data).catch(e => {\r\n                                this.$toast.error(e.message);\r\n                            });\r\n                        }\r\n                    }\r\n                }\r\n                if (multiple_boxes == false) {\r\n                    let config = qz.configs.create(Printer, {\r\n                        scaleContent: false\r\n                    });\r\n                    if (!qz.websocket.isActive()) {\r\n                        await qz.websocket.connect(config);\r\n                    }\r\n                    let data = [\r\n                        {\r\n                            type: \"pdf\",\r\n                            format: \"file\",\r\n                            data: linkpdf\r\n                        }\r\n                    ];\r\n\r\n                    qz.print(config, data).catch(e => {\r\n                        this.$toast.error(e.message);\r\n                    });\r\n                    for (let index = 0; index < copies; index++) {\r\n                        qz.print(config, data).catch(e => {\r\n                            this.$toast.error(e.message);\r\n                        });\r\n                    }\r\n                }\r\n            }\r\n        },\r\n        async clickSendWhatsapp(\r\n            document_type_id,\r\n            document_id,\r\n            number,\r\n            form = {}\r\n        ) {\r\n            if (form.customer_telephone != null) {\r\n                let formWhatsapp = {\r\n                    id: this.recordId,\r\n                    document_id: document_id,\r\n                    document_type_id: document_type_id,\r\n                    customer_telephone: form.customer_telephone,\r\n                    sender: \"sdrimsac\",\r\n                    mensaje:\r\n                        \"Su comprobante de pago electrónico \" +\r\n                        number +\r\n                        \" de *\" +\r\n                        this.company.name +\r\n                        \"*, ha sido generado correctamente a través del facturador electrónico de *Sdrimsac Solutions*\"\r\n                };\r\n                try {\r\n                    this.loading = true;\r\n                    let response = await this.$http.post(\r\n                        `/whatsapp`,\r\n                        formWhatsapp\r\n                    );\r\n                    if (response.data.success == true) {\r\n                        this.$toast.success(response.data.message);\r\n                        this.loading = false;\r\n                    }\r\n\r\n                    if (\r\n                        this.configuration.xml_whatsapp &&\r\n                        document_type_id != \"80\"\r\n                    ) {\r\n                        formWhatsapp.xml = true;\r\n                        response = await this.$http.post(\r\n                            `/whatsapp`,\r\n                            formWhatsapp\r\n                        );\r\n                        if (response.data.success == true) {\r\n                            this.$toast.success(response.data.message);\r\n                            this.loading = false;\r\n                        }\r\n                    }\r\n                } catch (e) {\r\n                    console.log(e, \" error\");\r\n                } finally {\r\n                    this.loading = false;\r\n                }\r\n            }\r\n        },\r\n        changeDateOfIssue() {\r\n            this.form.date_of_due = this.form.date_of_issue;\r\n            if (\r\n                moment(this.form.date_of_issue) < moment().day(-1) &&\r\n                this.configuration.restrict_receipt_date\r\n            ) {\r\n                this.$toast.error(\r\n                    \"No puede seleccionar una fecha menor a 6 días.\"\r\n                );\r\n                this.dateValid = false;\r\n            } else {\r\n                this.dateValid = true;\r\n            }\r\n            this.form.date_of_due = this.form.date_of_issue;\r\n            this.searchExchangeRateByDate(this.form.date_of_issue).then(\r\n                response => {\r\n                    this.form.exchange_rate_sale = response;\r\n                }\r\n            );\r\n            this.form.exchange_rate_sale = 1;\r\n        },\r\n        NuevaVenta() {\r\n            this.$parent.nueva_venta();\r\n        },\r\n\r\n        async setInitialAmount() {\r\n            this.enter_amount = this.form.total;\r\n            this.form.payments = this.payments;\r\n            await this.$refs.enter_amount.$el\r\n                .getElementsByTagName(\"input\")[0]\r\n                .focus();\r\n            await this.$refs.enter_amount.$el\r\n                .getElementsByTagName(\"input\")[0]\r\n                .select();\r\n        },\r\n        inputDiscountAmount() {\r\n            if (this.enabled_discount) {\r\n                if (\r\n                    this.discount_amount &&\r\n                    !isNaN(this.discount_amount) &&\r\n                    parseFloat(this.discount_amount) > 0\r\n                ) {\r\n                    if (this.discount_amount >= this.form.total)\r\n                        return this.$toast.error(\r\n                            \"El monto de descuento debe ser menor al total de venta\"\r\n                        );\r\n\r\n                    this.reCalculateTotal();\r\n                } else {\r\n                    this.deleteDiscountGlobal();\r\n                    this.reCalculateTotal();\r\n                }\r\n            }\r\n        },\r\n        discountGlobal() {\r\n            let global_discount = parseFloat(this.discount_amount);\r\n            let base = parseFloat(this.form.total);\r\n            let amount = parseFloat(global_discount);\r\n            let factor = _.round(amount / base, 4);\r\n\r\n            let discount = _.find(this.form.discounts, {\r\n                discount_type_id: \"03\"\r\n            });\r\n\r\n            if (global_discount > 0 && !discount) {\r\n                this.form.total_discount = _.round(amount, 2);\r\n\r\n                this.form.total = _.round(this.form.total - amount, 2);\r\n\r\n                this.form.total_value = _.round(\r\n                    this.form.total / (1 + this.percentage_igv / 100),\r\n                    2\r\n                );\r\n                this.form.total_taxed = this.form.total_value;\r\n\r\n                this.form.total_igv = _.round(\r\n                    this.form.total_value * (this.percentage_igv / 100),\r\n                    2\r\n                );\r\n                this.form.total_taxes = this.form.total_igv;\r\n\r\n                this.form.discounts.push({\r\n                    discount_type_id: \"03\",\r\n                    description:\r\n                        \"Descuentos globales que no afectan la base imponible del IGV/IVAP\",\r\n                    factor: factor,\r\n                    amount: amount,\r\n                    base: base\r\n                });\r\n            } else {\r\n                let index = this.form.discounts.indexOf(discount);\r\n\r\n                if (index > -1) {\r\n                    this.form.total_discount = _.round(amount, 2);\r\n                    this.form.total = _.round(this.form.total - amount, 2);\r\n                    this.form.total_value = _.round(\r\n                        this.form.total / (1 + this.percentage_igv / 100),\r\n                        2\r\n                    );\r\n                    this.form.total_taxed = this.form.total_value;\r\n                    this.form.total_igv = _.round(\r\n                        this.form.total_value * (this.percentage_igv / 100),\r\n                        2\r\n                    );\r\n                    this.form.total_taxes = this.form.total_igv;\r\n\r\n                    this.form.discounts[index].base = base;\r\n                    this.form.discounts[index].amount = amount;\r\n                    this.form.discounts[index].factor = factor;\r\n                }\r\n            }\r\n        },\r\n        method_payment(method_pay) {\r\n            this.form.payment_condition_id = \"01\";\r\n            this.form.method_pay = method_pay;\r\n            this.form.afectar_caja = true;\r\n        },\r\n        reCalculateTotal() {\r\n            let total_discount = 0;\r\n            let total_charge = 0;\r\n            let total_exportation = 0;\r\n            let total_taxed = 0;\r\n            let total_exonerated = 0;\r\n            let total_unaffected = 0;\r\n            let total_free = 0;\r\n            let total_igv = 0;\r\n            let total_value = 0;\r\n            let total = 0;\r\n            let total_plastic_bag_taxes = 0;\r\n\r\n            this.form.items.forEach(row => {\r\n                total_discount += parseFloat(row.total_discount);\r\n                total_charge += parseFloat(row.total_charge);\r\n\r\n                if (row.affectation_igv_type_id === \"10\") {\r\n                    total_taxed += parseFloat(row.total_value);\r\n                }\r\n                if (row.affectation_igv_type_id === \"20\") {\r\n                    total_exonerated += parseFloat(row.total_value);\r\n                }\r\n                if (row.affectation_igv_type_id === \"30\") {\r\n                    total_unaffected += parseFloat(row.total_value);\r\n                }\r\n                if (row.affectation_igv_type_id === \"40\") {\r\n                    total_exportation += parseFloat(row.total_value);\r\n                }\r\n                if (\r\n                    [\"10\", \"20\", \"30\", \"40\"].indexOf(\r\n                        row.affectation_igv_type_id\r\n                    ) < 0\r\n                ) {\r\n                    total_free += parseFloat(row.total_value);\r\n                }\r\n                if (\r\n                    [\"10\", \"20\", \"30\", \"40\"].indexOf(\r\n                        row.affectation_igv_type_id\r\n                    ) > -1\r\n                ) {\r\n                    total_igv += parseFloat(row.total_igv);\r\n                    total += parseFloat(row.total);\r\n                }\r\n                total_value += parseFloat(row.total_value);\r\n                total_plastic_bag_taxes += isNaN(\r\n                    parseFloat(row.total_plastic_bag_taxes)\r\n                )\r\n                    ? 0.0\r\n                    : parseFloat(row.total_plastic_bag_taxes);\r\n            });\r\n\r\n            this.form.total_exportation = _.round(total_exportation, 2);\r\n            this.form.total_taxed = _.round(total_taxed, 2);\r\n            this.form.total_exonerated = _.round(total_exonerated, 2);\r\n            this.form.total_unaffected = _.round(total_unaffected, 2);\r\n            this.form.total_free = _.round(total_free, 2);\r\n            this.form.total_igv = _.round(total_igv, 2);\r\n            this.form.total_value = _.round(total_value, 2);\r\n            this.form.total_taxes = _.round(total_igv, 2);\r\n            this.form.total_plastic_bag_taxes = _.round(\r\n                total_plastic_bag_taxes,\r\n                2\r\n            );\r\n            // this.form.total = _.round(total, 2)\r\n\r\n            this.form.total = _.round(\r\n                total + this.form.total_plastic_bag_taxes,\r\n                2\r\n            );\r\n\r\n            this.discountGlobal();\r\n        },\r\n        deleteDiscountGlobal() {\r\n            let discount = _.find(this.form.discounts, {\r\n                discount_type_id: \"03\"\r\n            });\r\n            let index = this.form.discounts.indexOf(discount);\r\n\r\n            if (index > -1) {\r\n                this.form.discounts.splice(index, 1);\r\n                this.form.total_discount = 0;\r\n            }\r\n        },\r\n\r\n        getFormPosLocalStorage() {\r\n            let form_pos = localStorage.getItem(\"form_pos\");\r\n            form_pos = JSON.parse(form_pos);\r\n            if (form_pos) {\r\n                this.form.payments = form_pos.payments;\r\n            }\r\n        },\r\n        clickAddPayment() {\r\n            this.showDialogMultiplePayment = true;\r\n        },\r\n        reloadDataCardBrands(card_brand_id) {\r\n            this.$http\r\n                .get(`/${this.resource}/table/card_brands`)\r\n                .then(response => {\r\n                    this.cards_brand = response.data;\r\n                    this.form_payment.card_brand_id = card_brand_id;\r\n                    this.changePaymentMethodType();\r\n                });\r\n        },\r\n        getDescriptionPaymentMethodType(id) {\r\n            let payment_method_type = _.find(this.payment_method_types, {\r\n                id: id\r\n            });\r\n            return payment_method_type ? payment_method_type.description : \"\";\r\n        },\r\n        changePaymentMethodType() {\r\n            let payment_method_type = _.find(this.payment_method_types, {\r\n                id: this.form_payment.payment_method_type_id\r\n            });\r\n            this.has_card = payment_method_type.has_card;\r\n            this.form_payment.card_brand_id = payment_method_type.has_card\r\n                ? this.form_payment.card_brand_id\r\n                : null;\r\n        },\r\n        addRow(payments) {\r\n            this.form.payments = payments;\r\n            let acum_payment = 0;\r\n\r\n            this.form.payments.forEach(item => {\r\n                acum_payment += parseFloat(item.payment);\r\n            });\r\n            // this.amount = acum_payment\r\n            this.setAmount(acum_payment);\r\n\r\n            // console.log(this.form.payments)\r\n        },\r\n        setAmount(amount) {\r\n            // this.amount = parseFloat(this.amount) + parseFloat(amount)\r\n            this.form.enter_amount = amount;\r\n            this.amount = parseFloat(amount); //+ parseFloat(amount)\r\n            //   this.form.enter_amount =  parseFloat(amount) //+ parseFloat(amount)\r\n            this.inputAmount(amount);\r\n        },\r\n        setAmountCash(amount) {\r\n            this.setAmount(amount);\r\n        },\r\n        async diferen() {\r\n            let differen =\r\n                (parseFloat(this.form.enter_amount) || 0) +\r\n                this.totalPayments() -\r\n                parseFloat(this.form.total);\r\n            if (differen < 0) {\r\n                this.$toast.error(\r\n                    \"El monto de efectivo es menor al total de venta\"\r\n                );\r\n            }\r\n        },\r\n        totalPayments() {\r\n            if (this.currentPayments.length != 0) {\r\n                let enter_amount = 0.0;\r\n                this.currentPayments.forEach(cp => {\r\n                    enter_amount += parseFloat(cp.amount);\r\n                });\r\n                return enter_amount;\r\n            }\r\n            return 0;\r\n        },\r\n        async enterAmount(amount = 0) {\r\n            this.amount = amount;\r\n\r\n            let enter_amount =\r\n                (parseFloat(this.form.enter_amount) || 0) +\r\n                this.totalPayments();\r\n\r\n            let differen = enter_amount - parseFloat(this.form.total);\r\n\r\n            this.form.difference = parseFloat(differen);\r\n\r\n            if (this.form.difference < 0) {\r\n                this.button_payment = true;\r\n                this.form.difference = differen;\r\n            } else if (this.form.difference >= 0) {\r\n                this.button_payment = false;\r\n                parseFloat(this.form.enter_amount) -\r\n                    parseFloat(this.form.total);\r\n            } else {\r\n                this.button_payment = true;\r\n            }\r\n            //this.form.difference = _.round(this.form.difference, 2);\r\n\r\n            this.$eventHub.$emit(\"eventSetFormPosLocalStorage\", this.form);\r\n            // this.setAmountCash(amount)\r\n        },\r\n        getLocalStoragePayment(key, re_default = null) {\r\n            let ls_obj = localStorage.getItem(key);\r\n            ls_obj = JSON.parse(ls_obj);\r\n\r\n            if (ls_obj) {\r\n                return ls_obj;\r\n            }\r\n\r\n            return re_default;\r\n        },\r\n        setLocalStoragePayment(key, obj) {\r\n            return localStorage.setItem(key, JSON.stringify(obj));\r\n        },\r\n        inputAmount(amount = null) {\r\n            this.enterAmount(amount);\r\n            this.form.difference = this.form.enter_amount - this.form.total;\r\n            if (isNaN(this.form.difference)) {\r\n                this.button_payment = true;\r\n                this.form.difference = \"-\";\r\n            } else if (this.form.difference >= 0) {\r\n                this.button_payment = false;\r\n                this.form.difference = this.amount - this.form.total;\r\n            } else {\r\n                this.button_payment = true;\r\n            }\r\n            this.$eventHub.$emit(\"eventSetFormPosLocalStorage\", this.form);\r\n        },\r\n        lStoPayment() {\r\n            this.setLocalStoragePayment(\"enter_amount\", this.form.enter_amount);\r\n            this.setLocalStoragePayment(\r\n                \"amount\",\r\n                this.amount == 0 ? this.form.total : this.amount\r\n            );\r\n            this.setLocalStoragePayment(\r\n                \"difference\",\r\n                this.amount == 0 ? this.form.total - this.amount : 0\r\n            );\r\n        },\r\n        initFormPayment() {\r\n            this.form.difference = this.form.total - this.form.enter_amount;\r\n            this.form_payment = {\r\n                id: null,\r\n                date_of_payment: moment().format(\"YYYY-MM-DD\"),\r\n                payment_method_type_id: \"01\",\r\n                reference: null,\r\n                card_brand_id: null,\r\n                document_id: null,\r\n                sale_note_id: null,\r\n                payment: this.form.total\r\n            };\r\n\r\n            this.form_cash_document = {\r\n                document_id: null,\r\n                sale_note_id: null\r\n            };\r\n        },\r\n\r\n        cleanLocalStoragePayment() {\r\n            this.setLocalStoragePayment(\"form_pos\", null);\r\n            this.setLocalStoragePayment(\"amount\", null);\r\n            this.setLocalStoragePayment(\"enter_amount\", null);\r\n            this.setLocalStoragePayment(\"difference\", null);\r\n        },\r\n        sleep(ms) {\r\n            return new Promise(resolve => setTimeout(resolve, ms));\r\n        },\r\n        passBoxes(total, boxes) {\r\n            let amounts = boxes.reduce((a, b) => a + b.amount, 0);\r\n            let rest = amounts - total;\r\n            let plus = false;\r\n            if (rest < 0) {\r\n                plus = true;\r\n                rest *= -1;\r\n            }\r\n            let newBoxes = [...boxes];\r\n\r\n            if (rest != 0) {\r\n                for (let i = 0; i < newBoxes.length; i++) {\r\n                    let box = newBoxes[i];\r\n                    if (plus) {\r\n                        box.amount += rest;\r\n                        rest = 0;\r\n                    } else {\r\n                        if (box.amount - rest > 0) {\r\n                            box.amount -= rest;\r\n                            rest = 0;\r\n                        }\r\n                    }\r\n\r\n                    if (rest == 0) {\r\n                        break;\r\n                    }\r\n                }\r\n            }\r\n            return newBoxes;\r\n        },\r\n        async sendPayment($event, form = null) {\r\n            if (!form) {\r\n                form = this.form;\r\n            }\r\n            form.printerOn = this.printerOn == 1 ? true : false;\r\n            await this.clickPayment(form);\r\n\r\n            if (this.formVariation.items.length != 0) {\r\n                let formVariation = this.formVariation;\r\n                formVariation.printerOn = false;\r\n                formVariation.document_type_id = \"80\";\r\n                formVariation.customer_telephone = null;\r\n                formVariation.customer_id = this.customer_variation.id;\r\n                this.customers = [\r\n                    ...this.customers.filter(\r\n                        c => c != this.customer_variation.id\r\n                    ),\r\n                    this.customer_variation\r\n                ];\r\n                formVariation.boxes = this.passBoxes(\r\n                    this.formVariation.total,\r\n                    this.form.boxes\r\n                );\r\n\r\n                let noteVariation = this.all_series.find(\r\n                    s => s.document_type_id == \"80\"\r\n                );\r\n                if (noteVariation) {\r\n                    formVariation.series_id = noteVariation.id;\r\n                    await this.clickPayment(formVariation);\r\n                } else {\r\n                    this.$toast.error(\"Sin serie en nota de venta\");\r\n                }\r\n            }\r\n        },\r\n        async clickPayment(form) {\r\n            let customer = this.customers.find(c => c.id == form.customer_id);\r\n\r\n            if (form.customer_telephone != null) {\r\n                if (!this.existNumber()) {\r\n                    this.$toast.error(\"Número para envío whatsapp inválido\");\r\n                    return;\r\n                }\r\n            }\r\n            if (form.customer_id == null || form.customer_id == \"\") {\r\n                return this.$toast.error(\"Elija un cliente\");\r\n            }\r\n            if (\r\n                customer.identity_document_type_id == \"1\" &&\r\n                form.document_type_id == \"01\"\r\n            ) {\r\n                return this.$toast.error(\"No puede emitir Factura con DNI\");\r\n            }\r\n            if (!form.series_id) {\r\n                return this.$toast.warning(\r\n                    \"El establecimiento no tiene series disponibles para el comprobante\"\r\n                );\r\n            }\r\n\r\n            if (form.document_type_id === \"80\") {\r\n                form.prefix = \"NV\";\r\n                form.paid = 1;\r\n                this.resource_documents = \"sale-notes\";\r\n                this.resource_payments = \"sale_note_payments\";\r\n                this.resource_options = this.resource_documents;\r\n            } else {\r\n                form.prefix = null;\r\n                this.resource_documents = \"documents\";\r\n                this.resource_payments = \"document_payments\";\r\n                this.resource_options = this.resource_documents;\r\n            }\r\n            if (this.orden != null) {\r\n                form.additional_information = `Orden N°${this.orden}`;\r\n            }\r\n            form.advances = 0.0;\r\n            form.total_advances = 0.0;\r\n            form.total_payment = form.total;\r\n            form.payments = [\r\n                {\r\n                    payment_method_type_id: \"01\",\r\n                    date_of_payment: form.date_of_issue,\r\n                    payment: form.total\r\n                }\r\n            ];\r\n\r\n            form.cash_id = this.cash_id;\r\n            form.boxes = this.currentPayments;\r\n            this.addPayment();\r\n\r\n            this.loading_submit = true;\r\n\r\n            try {\r\n                let form_efectivo = {\r\n                    enter_amount: form.enter_amount,\r\n                    difference: form.difference\r\n                };\r\n                let ordenId = this.idOrden;\r\n                if (\r\n                    (ordenId == undefined || ordenId == null) &&\r\n                    (form.variation == undefined || form.variation == null)\r\n                ) {\r\n                    const responses = await this.$http.post(\r\n                        \"/restaurant/worker/send-orden\",\r\n                        this.orden_items\r\n                    );\r\n                    ordenId = responses.data.id;\r\n                    if (responses.status != 200) {\r\n                        return;\r\n                    }\r\n                }\r\n                form.orden_id = ordenId;\r\n                // const response_efectivo = await this.$http.post(`/efectivo`,form_efectivo);\r\n\r\n                const response = await this.$http.post(\r\n                    `/${this.resource_documents}`,\r\n                    form\r\n                );\r\n\r\n                if (response.status == 200) {\r\n                    if (response.data.success == true) {\r\n                        let document_id = 0;\r\n                        if (form.document_type_id === \"80\") {\r\n                            this.number = response.data.data.number;\r\n                            document_id = response.data.data.id;\r\n                            this.form_cash_document.sale_note_id =\r\n                                response.data.data.id;\r\n                        } else {\r\n                            document_id = response.data.data.id;\r\n                            this.form_cash_document.document_id =\r\n                                response.data.data.id;\r\n                            this.number = response.data.data.number;\r\n                        }\r\n                        this.documentNewId = response.data.data.id;\r\n\r\n                        if (response.data.success == true) {\r\n                            /* let customer = this.all_customers.find(\r\n                                c => c.id == form.customer_id\r\n                            ); */\r\n\r\n                            if (ordenId) {\r\n                                const response2 = await this.$http.post(\r\n                                    \"pos/orden_payment\",\r\n                                    {\r\n                                        id: ordenId,\r\n                                        customer_id: customer.id,\r\n                                        document: {\r\n                                            isNoteSale:\r\n                                                form.document_type_id === \"80\",\r\n                                            id: this.documentNewId\r\n                                        }\r\n                                    }\r\n                                );\r\n                                if (response2.data.success == true) {\r\n                                    if (this.form.customer_telephone) {\r\n                                        if (this.personalWhatsapp) {\r\n                                            await this.$emit(\"getFile\", {\r\n                                                documentId: this.documentNewId,\r\n                                                documentTypeId:\r\n                                                    form.document_type_id,\r\n                                                number: this.form\r\n                                                    .customer_telephone,\r\n                                                message: this.form.message\r\n                                            });\r\n                                        } else {\r\n                                            await this.clickSendWhatsapp(\r\n                                                form.document_type_id,\r\n                                                this.documentNewId,\r\n                                                this.number,\r\n                                                form\r\n                                            );\r\n                                        }\r\n                                        this.$emit(\"limpiarForm\");\r\n                                        this.loading_submit = false;\r\n                                        this.back(true);\r\n                                    } else {\r\n                                        this.$emit(\"limpiarForm\");\r\n                                        this.loading_submit = false;\r\n                                        this.back(true);\r\n                                    }\r\n                                }\r\n                            } else {\r\n                                this.$emit(\"limpiarForm\");\r\n                                this.loading_submit = false;\r\n\r\n                                this.back(true);\r\n                            }\r\n                        }\r\n                    }\r\n                } else {\r\n                    this.loading_submit = true;\r\n                    this.$alert(\r\n                        \"<strong>Ocurrio un error </strong>\" +\r\n                            response.statusCode +\r\n                            \"<br>\" +\r\n                            this.resource_documents,\r\n                        \"HTML String\",\r\n                        {\r\n                            dangerouslyUseHTMLString: true\r\n                        }\r\n                    );\r\n                }\r\n            } catch (error) {\r\n                console.log(error);\r\n                const response = error.response;\r\n                let {\r\n                    data: { message }\r\n                } = response;\r\n\r\n                this.$toast.error(message || \"Ocurrió un error\");\r\n                this.loading_submit = false;\r\n            }\r\n        },\r\n\r\n        async clickPrintPos(printerName, formatoPdf, userId = null) {\r\n            try {\r\n                let config = qz.configs.create(\r\n                    printerName,\r\n                    { legacy: true },\r\n                    { scaleContent: false }\r\n                );\r\n                if (!qz.websocket.isActive()) {\r\n                    await qz.websocket.connect(config);\r\n                }\r\n                let data = [\r\n                    {\r\n                        type: \"pdf\",\r\n                        format: \"file\",\r\n                        data: formatoPdf\r\n                    }\r\n                ];\r\n                qz.print(config, data).catch(e => {\r\n                    this.$toast.error(e.message);\r\n                });\r\n            } catch (e) {\r\n                this.$toast.error(e.message);\r\n            }\r\n        },\r\n        saveCashDocument() {\r\n            this.$http\r\n                .post(`/cash/cash_document`, this.form_cash_document)\r\n                .then(response => {\r\n                    if (response.data.success) {\r\n                        // console.log(response)\r\n                    } else {\r\n                        this.$toast.error(response.data.message);\r\n                    }\r\n                })\r\n                .catch(error => {\r\n                    console.log(error);\r\n                });\r\n        },\r\n        savePaymentMethod() {\r\n            this.$http\r\n                .post(`/${this.resource_payments}`, this.form_payment)\r\n                .then(response => {\r\n                    if (response.data.success) {\r\n                        // console.log(response)\r\n                    } else {\r\n                        this.$toast.error(response.data.message);\r\n                    }\r\n                })\r\n                .catch(error => {\r\n                    if (error.response.status === 422) {\r\n                        this.records[index].errors = error.response.data;\r\n                    } else {\r\n                        console.log(error);\r\n                    }\r\n                });\r\n        },\r\n        getTables() {\r\n            this.filterSeries();\r\n        },\r\n\r\n        async clickCancel() {\r\n            this.loading_submit = true;\r\n\r\n            this.loading_submit = false;\r\n            this.cleanLocalStoragePayment();\r\n            this.$eventHub.$emit(\"cancelSale\");\r\n        },\r\n        back(val = false) {\r\n            this.splitPayments = [];\r\n            //this.$emit(\"limpiarForm\");\r\n            if (!val) {\r\n                this.$emit(\"openDrawer\");\r\n            }\r\n            this.$emit(\"update:is_payment\", false);\r\n        },\r\n        async initLStoPayment() {\r\n            this.amount = await this.getLocalStoragePayment(\r\n                \"amount\",\r\n                this.form.total\r\n            );\r\n            this.form.enter_amount = await this.getLocalStoragePayment(\r\n                \"enter_amount\",\r\n                this.form.total\r\n            );\r\n            this.form.difference = await this.getLocalStoragePayment(\r\n                \"difference\",\r\n                this.form.total - this.form.enter_amount\r\n            );\r\n        },\r\n        checkCustomers() {\r\n            if (this.form.document_type_id == \"01\") {\r\n                return this.customers.some(\r\n                    c => c.identity_document_type_id == \"6\"\r\n                );\r\n            } else {\r\n                return this.customers.some(\r\n                    c => c.identity_document_type_id == \"1\"\r\n                );\r\n            }\r\n        },\r\n        setSeries() {\r\n            this.form.series_id = null;\r\n            this.series = _.filter(this.all_series, {\r\n                document_type_id: this.form.document_type_id\r\n            });\r\n            this.series.forEach(s => {\r\n                s.full_number =\r\n                    `${s.number}-${this.last_number[s.number] || \"1\"}` ||\r\n                    s.number;\r\n            });\r\n            this.form.series_id =\r\n                this.series.length > 0 ? this.series[0].id : null;\r\n        },\r\n        filterSeries() {\r\n            let check = this.checkCustomers();\r\n            if (!check && !this.started) {\r\n                let dcto = \"DNI\";\r\n                if (this.form.document_type_id == \"01\") {\r\n                    dcto = \"RUC\";\r\n                    this.form.document_type_id = \"03\";\r\n                } else {\r\n                    this.form.document_type_id = \"01\";\r\n                }\r\n                this.$toast.warning(`Digite el número de ${dcto}`);\r\n\r\n                this.setSeries();\r\n                return;\r\n            }\r\n            this.started = false;\r\n\r\n            if (this.form.document_type_id == \"01\") {\r\n                this.currentDocumentsType = [\r\n                    ...this.documentsType.filter(f => f.description == \"RUC\")\r\n                ];\r\n                this.form.identity_document_type_id = this.currentDocumentsType[0].id;\r\n            } else {\r\n                this.currentDocumentsType = this.documentsType;\r\n            }\r\n            this.setSeries();\r\n            //aqui\r\n            //factura solo ruc\r\n            //boletas solo dni\r\n            //note de venta todo\r\n            let currentClient = null;\r\n            if (this.value != null) {\r\n                currentClient = this.all_customers.find(\r\n                    c => c.id == this.value\r\n                );\r\n\r\n                // if (currentClient.identity_document_type_id == \"1\") {\r\n                //     this.form.document_type_id = \"03\";\r\n                // }\r\n            }\r\n\r\n            if (this.form.document_type_id == \"01\") {\r\n                this.customers = this.all_customers.filter(\r\n                    f => f.identity_document_type_id == \"6\"\r\n                );\r\n                if (this.customers.length == 0) {\r\n                    this.$toast.warning(\"Digite el número de RUC\");\r\n                    this.form.document_type_id == \"03\";\r\n\r\n                    // this.customers = this.all_customers;\r\n                } else {\r\n                    if (\r\n                        currentClient &&\r\n                        this.customers.some(c => c.id == currentClient.id)\r\n                    ) {\r\n                        return;\r\n                    }\r\n                    this.value = this.customers[0].id;\r\n                    this.form.customer_telephone = this.customers[0].phone;\r\n                }\r\n            } else if (\r\n                this.form.document_type_id == \"03\" ||\r\n                this.form.document_type_id == \"80\"\r\n            ) {\r\n                this.customers = this.all_customers.filter(\r\n                    f => f.identity_document_type_id != \"6\"\r\n                );\r\n                if (this.form.total > 300) {\r\n                    this.customers = this.customers.filter(\r\n                        c => c.identity_document_type_id == \"1\"\r\n                    );\r\n                }\r\n\r\n                if (\r\n                    currentClient &&\r\n                    this.customers.some(c => c.id == currentClient.id)\r\n                ) {\r\n                    return;\r\n                }\r\n                let client = this.customers.find(c => {\r\n                    return c.name.toLowerCase().includes(\"varios\");\r\n                });\r\n                if (client) {\r\n                    this.value = client.id;\r\n                    this.form.customer_telephone = client.phone;\r\n                } else {\r\n                    this.value = this.customers[0].id;\r\n                    this.form.customer_telephone = this.customers[0].phone;\r\n                }\r\n            } else {\r\n                this.customers = this.all_customers;\r\n            }\r\n            this.customers = this.customers.filter(n => n.number != \"88888888\");\r\n            this.customers = [\r\n                ...this.customers.filter(n => n.id != this.customer_default.id),\r\n                this.customer_default\r\n            ];\r\n            this.changeCustomer();\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/print-js/dist/print.js":
/***/ (function(module, exports, __webpack_require__) {

(function webpackUniversalModuleDefinition(root, factory) {
	if(true)
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["printJS"] = factory();
	else
		root["printJS"] = factory();
})(window, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sass_index_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./sass/index.scss */ "./src/sass/index.scss");
/* harmony import */ var _sass_index_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_sass_index_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _js_init__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./js/init */ "./src/js/init.js");


var printJS = _js_init__WEBPACK_IMPORTED_MODULE_1__["default"].init;

if (typeof window !== 'undefined') {
  window.printJS = printJS;
}

/* harmony default export */ __webpack_exports__["default"] = (printJS);

/***/ }),

/***/ "./src/js/browser.js":
/*!***************************!*\
  !*** ./src/js/browser.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var Browser = {
  // Firefox 1.0+
  isFirefox: function isFirefox() {
    return typeof InstallTrigger !== 'undefined';
  },
  // Internet Explorer 6-11
  isIE: function isIE() {
    return navigator.userAgent.indexOf('MSIE') !== -1 || !!document.documentMode;
  },
  // Edge 20+
  isEdge: function isEdge() {
    return !Browser.isIE() && !!window.StyleMedia;
  },
  // Chrome 1+
  isChrome: function isChrome() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : window;
    return !!context.chrome;
  },
  // At least Safari 3+: "[object HTMLElementConstructor]"
  isSafari: function isSafari() {
    return Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0 || navigator.userAgent.toLowerCase().indexOf('safari') !== -1;
  },
  // IOS Chrome
  isIOSChrome: function isIOSChrome() {
    return navigator.userAgent.toLowerCase().indexOf('crios') !== -1;
  }
};
/* harmony default export */ __webpack_exports__["default"] = (Browser);

/***/ }),

/***/ "./src/js/functions.js":
/*!*****************************!*\
  !*** ./src/js/functions.js ***!
  \*****************************/
/*! exports provided: addWrapper, capitalizePrint, collectStyles, addHeader, cleanUp, isRawHTML */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addWrapper", function() { return addWrapper; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "capitalizePrint", function() { return capitalizePrint; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "collectStyles", function() { return collectStyles; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addHeader", function() { return addHeader; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cleanUp", function() { return cleanUp; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isRawHTML", function() { return isRawHTML; });
/* harmony import */ var _modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal */ "./src/js/modal.js");
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./browser */ "./src/js/browser.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



function addWrapper(htmlData, params) {
  var bodyStyle = 'font-family:' + params.font + ' !important; font-size: ' + params.font_size + ' !important; width:100%;';
  return '<div style="' + bodyStyle + '">' + htmlData + '</div>';
}
function capitalizePrint(obj) {
  return obj.charAt(0).toUpperCase() + obj.slice(1);
}
function collectStyles(element, params) {
  var win = document.defaultView || window; // String variable to hold styling for each element

  var elementStyle = ''; // Loop over computed styles

  var styles = win.getComputedStyle(element, '');

  for (var key = 0; key < styles.length; key++) {
    // Check if style should be processed
    if (params.targetStyles.indexOf('*') !== -1 || params.targetStyle.indexOf(styles[key]) !== -1 || targetStylesMatch(params.targetStyles, styles[key])) {
      if (styles.getPropertyValue(styles[key])) elementStyle += styles[key] + ':' + styles.getPropertyValue(styles[key]) + ';';
    }
  } // Print friendly defaults (deprecated)


  elementStyle += 'max-width: ' + params.maxWidth + 'px !important; font-size: ' + params.font_size + ' !important;';
  return elementStyle;
}

function targetStylesMatch(styles, value) {
  for (var i = 0; i < styles.length; i++) {
    if (_typeof(value) === 'object' && value.indexOf(styles[i]) !== -1) return true;
  }

  return false;
}

function addHeader(printElement, params) {
  // Create the header container div
  var headerContainer = document.createElement('div'); // Check if the header is text or raw html

  if (isRawHTML(params.header)) {
    headerContainer.innerHTML = params.header;
  } else {
    // Create header element
    var headerElement = document.createElement('h1'); // Create header text node

    var headerNode = document.createTextNode(params.header); // Build and style

    headerElement.appendChild(headerNode);
    headerElement.setAttribute('style', params.headerStyle);
    headerContainer.appendChild(headerElement);
  }

  printElement.insertBefore(headerContainer, printElement.childNodes[0]);
}
function cleanUp(params) {
  // If we are showing a feedback message to user, remove it
  if (params.showModal) _modal__WEBPACK_IMPORTED_MODULE_0__["default"].close(); // Check for a finished loading hook function

  if (params.onLoadingEnd) params.onLoadingEnd(); // If preloading pdf files, clean blob url

  if (params.showModal || params.onLoadingStart) window.URL.revokeObjectURL(params.printable); // Run onPrintDialogClose callback

  var event = 'mouseover';

  if (_browser__WEBPACK_IMPORTED_MODULE_1__["default"].isChrome() || _browser__WEBPACK_IMPORTED_MODULE_1__["default"].isFirefox()) {
    // Ps.: Firefox will require an extra click in the document to fire the focus event.
    event = 'focus';
  }

  var handler = function handler() {
    // Make sure the event only happens once.
    window.removeEventListener(event, handler);
    params.onPrintDialogClose(); // Remove iframe from the DOM

    var iframe = document.getElementById(params.frameId);

    if (iframe) {
      iframe.remove();
    }
  };

  window.addEventListener(event, handler);
}
function isRawHTML(raw) {
  var regexHtml = new RegExp('<([A-Za-z][A-Za-z0-9]*)\\b[^>]*>(.*?)</\\1>');
  return regexHtml.test(raw);
}

/***/ }),

/***/ "./src/js/html.js":
/*!************************!*\
  !*** ./src/js/html.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./print */ "./src/js/print.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Get the DOM printable element
    var printElement = isHtmlElement(params.printable) ? params.printable : document.getElementById(params.printable); // Check if the element exists

    if (!printElement) {
      window.console.error('Invalid HTML element id: ' + params.printable);
      return;
    } // Clone the target element including its children (if available)


    params.printableElement = cloneElement(printElement, params); // Add header

    if (params.header) {
      Object(_functions__WEBPACK_IMPORTED_MODULE_0__["addHeader"])(params.printableElement, params);
    } // Print html element contents


    _print__WEBPACK_IMPORTED_MODULE_1__["default"].send(params, printFrame);
  }
});

function cloneElement(element, params) {
  // Clone the main node (if not already inside the recursion process)
  var clone = element.cloneNode(); // Loop over and process the children elements / nodes (including text nodes)

  var childNodesArray = Array.prototype.slice.call(element.childNodes);

  for (var i = 0; i < childNodesArray.length; i++) {
    // Check if we are skipping the current element
    if (params.ignoreElements.indexOf(childNodesArray[i].id) !== -1) {
      continue;
    } // Clone the child element


    var clonedChild = cloneElement(childNodesArray[i], params); // Attach the cloned child to the cloned parent node

    clone.appendChild(clonedChild);
  } // Get all styling for print element (for nodes of type element only)


  if (params.scanStyles && element.nodeType === 1) {
    clone.setAttribute('style', Object(_functions__WEBPACK_IMPORTED_MODULE_0__["collectStyles"])(element, params));
  } // Check if the element needs any state processing (copy user input data)


  switch (element.tagName) {
    case 'SELECT':
      // Copy the current selection value to its clone
      clone.value = element.value;
      break;

    case 'CANVAS':
      // Copy the canvas content to its clone
      clone.getContext('2d').drawImage(element, 0, 0);
      break;
  }

  return clone;
}

function isHtmlElement(printable) {
  // Check if element is instance of HTMLElement or has nodeType === 1 (for elements in iframe)
  return _typeof(printable) === 'object' && printable && (printable instanceof HTMLElement || printable.nodeType === 1);
}

/***/ }),

/***/ "./src/js/image.js":
/*!*************************!*\
  !*** ./src/js/image.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./print */ "./src/js/print.js");
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./browser */ "./src/js/browser.js");



/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Check if we are printing one image or multiple images
    if (params.printable.constructor !== Array) {
      // Create array with one image
      params.printable = [params.printable];
    } // Create printable element (container)


    params.printableElement = document.createElement('div'); // Create all image elements and append them to the printable container

    params.printable.forEach(function (src) {
      // Create the image element
      var img = document.createElement('img');
      img.setAttribute('style', params.imageStyle); // Set image src with the file url

      img.src = src; // The following block is for Firefox, which for some reason requires the image's src to be fully qualified in
      // order to print it

      if (_browser__WEBPACK_IMPORTED_MODULE_2__["default"].isFirefox()) {
        var fullyQualifiedSrc = img.src;
        img.src = fullyQualifiedSrc;
      } // Create the image wrapper


      var imageWrapper = document.createElement('div'); // Append image to the wrapper element

      imageWrapper.appendChild(img); // Append wrapper to the printable element

      params.printableElement.appendChild(imageWrapper);
    }); // Check if we are adding a print header

    if (params.header) Object(_functions__WEBPACK_IMPORTED_MODULE_0__["addHeader"])(params.printableElement, params); // Print image

    _print__WEBPACK_IMPORTED_MODULE_1__["default"].send(params, printFrame);
  }
});

/***/ }),

/***/ "./src/js/init.js":
/*!************************!*\
  !*** ./src/js/init.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./browser */ "./src/js/browser.js");
/* harmony import */ var _modal__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modal */ "./src/js/modal.js");
/* harmony import */ var _pdf__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./pdf */ "./src/js/pdf.js");
/* harmony import */ var _html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./html */ "./src/js/html.js");
/* harmony import */ var _raw_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./raw-html */ "./src/js/raw-html.js");
/* harmony import */ var _image__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./image */ "./src/js/image.js");
/* harmony import */ var _json__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./json */ "./src/js/json.js");


function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }








var printTypes = ['pdf', 'html', 'image', 'json', 'raw-html'];
/* harmony default export */ __webpack_exports__["default"] = ({
  init: function init() {
    var params = {
      printable: null,
      fallbackPrintable: null,
      type: 'pdf',
      header: null,
      headerStyle: 'font-weight: 300;',
      maxWidth: 800,
      properties: null,
      gridHeaderStyle: 'font-weight: bold; padding: 5px; border: 1px solid #dddddd;',
      gridStyle: 'border: 1px solid lightgray; margin-bottom: -1px;',
      showModal: false,
      onError: function onError(error) {
        throw error;
      },
      onLoadingStart: null,
      onLoadingEnd: null,
      onPrintDialogClose: function onPrintDialogClose() {},
      onIncompatibleBrowser: function onIncompatibleBrowser() {},
      modalMessage: 'Retrieving Document...',
      frameId: 'printJS',
      printableElement: null,
      documentTitle: 'Document',
      targetStyle: ['clear', 'display', 'width', 'min-width', 'height', 'min-height', 'max-height'],
      targetStyles: ['border', 'box', 'break', 'text-decoration'],
      ignoreElements: [],
      repeatTableHeader: true,
      css: null,
      style: null,
      scanStyles: true,
      base64: false,
      // Deprecated
      onPdfOpen: null,
      font: 'TimesNewRoman',
      font_size: '12pt',
      honorMarginPadding: true,
      honorColor: false,
      imageStyle: 'max-width: 100%;'
    }; // Check if a printable document or object was supplied

    var args = arguments[0];

    if (args === undefined) {
      throw new Error('printJS expects at least 1 attribute.');
    } // Process parameters


    switch (_typeof(args)) {
      case 'string':
        params.printable = encodeURI(args);
        params.fallbackPrintable = params.printable;
        params.type = arguments[1] || params.type;
        break;

      case 'object':
        params.printable = args.printable;
        params.fallbackPrintable = typeof args.fallbackPrintable !== 'undefined' ? args.fallbackPrintable : params.printable;
        params.fallbackPrintable = params.base64 ? "data:application/pdf;base64,".concat(params.fallbackPrintable) : params.fallbackPrintable;

        for (var k in params) {
          if (k === 'printable' || k === 'fallbackPrintable') continue;
          params[k] = typeof args[k] !== 'undefined' ? args[k] : params[k];
        }

        break;

      default:
        throw new Error('Unexpected argument type! Expected "string" or "object", got ' + _typeof(args));
    } // Validate printable


    if (!params.printable) throw new Error('Missing printable information.'); // Validate type

    if (!params.type || typeof params.type !== 'string' || printTypes.indexOf(params.type.toLowerCase()) === -1) {
      throw new Error('Invalid print type. Available types are: pdf, html, image and json.');
    } // Check if we are showing a feedback message to the user (useful for large files)


    if (params.showModal) _modal__WEBPACK_IMPORTED_MODULE_1__["default"].show(params); // Check for a print start hook function

    if (params.onLoadingStart) params.onLoadingStart(); // To prevent duplication and issues, remove any used printFrame from the DOM

    var usedFrame = document.getElementById(params.frameId);
    if (usedFrame) usedFrame.parentNode.removeChild(usedFrame); // Create a new iframe for the print job

    var printFrame = document.createElement('iframe');

    if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isFirefox()) {
      // Set the iframe to be is visible on the page (guaranteed by fixed position) but hidden using opacity 0, because
      // this works in Firefox. The height needs to be sufficient for some part of the document other than the PDF
      // viewer's toolbar to be visible in the page
      printFrame.setAttribute('style', 'width: 1px; height: 100px; position: fixed; left: 0; top: 0; opacity: 0; border-width: 0; margin: 0; padding: 0');
    } else {
      // Hide the iframe in other browsers
      printFrame.setAttribute('style', 'visibility: hidden; height: 0; width: 0; position: absolute; border: 0');
    } // Set iframe element id


    printFrame.setAttribute('id', params.frameId); // For non pdf printing, pass an html document string to srcdoc (force onload callback)

    if (params.type !== 'pdf') {
      printFrame.srcdoc = '<html><head><title>' + params.documentTitle + '</title>'; // Attach css files

      if (params.css) {
        // Add support for single file
        if (!Array.isArray(params.css)) params.css = [params.css]; // Create link tags for each css file

        params.css.forEach(function (file) {
          printFrame.srcdoc += '<link rel="stylesheet" href="' + file + '">';
        });
      }

      printFrame.srcdoc += '</head><body></body></html>';
    } // Check printable type


    switch (params.type) {
      case 'pdf':
        // Check browser support for pdf and if not supported we will just open the pdf file instead
        if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isIE()) {
          try {
            console.info('Print.js doesn\'t support PDF printing in Internet Explorer.');
            var win = window.open(params.fallbackPrintable, '_blank');
            win.focus();
            params.onIncompatibleBrowser();
          } catch (error) {
            params.onError(error);
          } finally {
            // Make sure there is no loading modal opened
            if (params.showModal) _modal__WEBPACK_IMPORTED_MODULE_1__["default"].close();
            if (params.onLoadingEnd) params.onLoadingEnd();
          }
        } else {
          _pdf__WEBPACK_IMPORTED_MODULE_2__["default"].print(params, printFrame);
        }

        break;

      case 'image':
        _image__WEBPACK_IMPORTED_MODULE_5__["default"].print(params, printFrame);
        break;

      case 'html':
        _html__WEBPACK_IMPORTED_MODULE_3__["default"].print(params, printFrame);
        break;

      case 'raw-html':
        _raw_html__WEBPACK_IMPORTED_MODULE_4__["default"].print(params, printFrame);
        break;

      case 'json':
        _json__WEBPACK_IMPORTED_MODULE_6__["default"].print(params, printFrame);
        break;
    }
  }
});

/***/ }),

/***/ "./src/js/json.js":
/*!************************!*\
  !*** ./src/js/json.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./print */ "./src/js/print.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Check if we received proper data
    if (_typeof(params.printable) !== 'object') {
      throw new Error('Invalid javascript data object (JSON).');
    } // Validate repeatTableHeader


    if (typeof params.repeatTableHeader !== 'boolean') {
      throw new Error('Invalid value for repeatTableHeader attribute (JSON).');
    } // Validate properties


    if (!params.properties || !Array.isArray(params.properties)) {
      throw new Error('Invalid properties array for your JSON data.');
    } // We will format the property objects to keep the JSON api compatible with older releases


    params.properties = params.properties.map(function (property) {
      return {
        field: _typeof(property) === 'object' ? property.field : property,
        displayName: _typeof(property) === 'object' ? property.displayName : property,
        columnSize: _typeof(property) === 'object' && property.columnSize ? property.columnSize + ';' : 100 / params.properties.length + '%;'
      };
    }); // Create a print container element

    params.printableElement = document.createElement('div'); // Check if we are adding a print header

    if (params.header) {
      Object(_functions__WEBPACK_IMPORTED_MODULE_0__["addHeader"])(params.printableElement, params);
    } // Build the printable html data


    params.printableElement.innerHTML += jsonToHTML(params); // Print the json data

    _print__WEBPACK_IMPORTED_MODULE_1__["default"].send(params, printFrame);
  }
});

function jsonToHTML(params) {
  // Get the row and column data
  var data = params.printable;
  var properties = params.properties; // Create a html table

  var htmlData = '<table style="border-collapse: collapse; width: 100%;">'; // Check if the header should be repeated

  if (params.repeatTableHeader) {
    htmlData += '<thead>';
  } // Add the table header row


  htmlData += '<tr>'; // Add the table header columns

  for (var a = 0; a < properties.length; a++) {
    htmlData += '<th style="width:' + properties[a].columnSize + ';' + params.gridHeaderStyle + '">' + Object(_functions__WEBPACK_IMPORTED_MODULE_0__["capitalizePrint"])(properties[a].displayName) + '</th>';
  } // Add the closing tag for the table header row


  htmlData += '</tr>'; // If the table header is marked as repeated, add the closing tag

  if (params.repeatTableHeader) {
    htmlData += '</thead>';
  } // Create the table body


  htmlData += '<tbody>'; // Add the table data rows

  for (var i = 0; i < data.length; i++) {
    // Add the row starting tag
    htmlData += '<tr>'; // Print selected properties only

    for (var n = 0; n < properties.length; n++) {
      var stringData = data[i]; // Support nested objects

      var property = properties[n].field.split('.');

      if (property.length > 1) {
        for (var p = 0; p < property.length; p++) {
          stringData = stringData[property[p]];
        }
      } else {
        stringData = stringData[properties[n].field];
      } // Add the row contents and styles


      htmlData += '<td style="width:' + properties[n].columnSize + params.gridStyle + '">' + stringData + '</td>';
    } // Add the row closing tag


    htmlData += '</tr>';
  } // Add the table and body closing tags


  htmlData += '</tbody></table>';
  return htmlData;
}

/***/ }),

/***/ "./src/js/modal.js":
/*!*************************!*\
  !*** ./src/js/modal.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var Modal = {
  show: function show(params) {
    // Build modal
    var modalStyle = 'font-family:sans-serif; ' + 'display:table; ' + 'text-align:center; ' + 'font-weight:300; ' + 'font-size:30px; ' + 'left:0; top:0;' + 'position:fixed; ' + 'z-index: 9990;' + 'color: #0460B5; ' + 'width: 100%; ' + 'height: 100%; ' + 'background-color:rgba(255,255,255,.9);' + 'transition: opacity .3s ease;'; // Create wrapper

    var printModal = document.createElement('div');
    printModal.setAttribute('style', modalStyle);
    printModal.setAttribute('id', 'printJS-Modal'); // Create content div

    var contentDiv = document.createElement('div');
    contentDiv.setAttribute('style', 'display:table-cell; vertical-align:middle; padding-bottom:100px;'); // Add close button (requires print.css)

    var closeButton = document.createElement('div');
    closeButton.setAttribute('class', 'printClose');
    closeButton.setAttribute('id', 'printClose');
    contentDiv.appendChild(closeButton); // Add spinner (requires print.css)

    var spinner = document.createElement('span');
    spinner.setAttribute('class', 'printSpinner');
    contentDiv.appendChild(spinner); // Add message

    var messageNode = document.createTextNode(params.modalMessage);
    contentDiv.appendChild(messageNode); // Add contentDiv to printModal

    printModal.appendChild(contentDiv); // Append print modal element to document body

    document.getElementsByTagName('body')[0].appendChild(printModal); // Add event listener to close button

    document.getElementById('printClose').addEventListener('click', function () {
      Modal.close();
    });
  },
  close: function close() {
    var printModal = document.getElementById('printJS-Modal');

    if (printModal) {
      printModal.parentNode.removeChild(printModal);
    }
  }
};
/* harmony default export */ __webpack_exports__["default"] = (Modal);

/***/ }),

/***/ "./src/js/pdf.js":
/*!***********************!*\
  !*** ./src/js/pdf.js ***!
  \***********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./print */ "./src/js/print.js");
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");


/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Check if we have base64 data
    if (params.base64) {
      var bytesArray = Uint8Array.from(atob(params.printable), function (c) {
        return c.charCodeAt(0);
      });
      createBlobAndPrint(params, printFrame, bytesArray);
      return;
    } // Format pdf url


    params.printable = /^(blob|http|\/\/)/i.test(params.printable) ? params.printable : window.location.origin + (params.printable.charAt(0) !== '/' ? '/' + params.printable : params.printable); // Get the file through a http request (Preload)

    var req = new window.XMLHttpRequest();
    req.responseType = 'arraybuffer';
    req.addEventListener('error', function () {
      Object(_functions__WEBPACK_IMPORTED_MODULE_1__["cleanUp"])(params);
      params.onError(req.statusText, req); // Since we don't have a pdf document available, we will stop the print job
    });
    req.addEventListener('load', function () {
      // Check for errors
      if ([200, 201].indexOf(req.status) === -1) {
        Object(_functions__WEBPACK_IMPORTED_MODULE_1__["cleanUp"])(params);
        params.onError(req.statusText, req); // Since we don't have a pdf document available, we will stop the print job

        return;
      } // Print requested document


      createBlobAndPrint(params, printFrame, req.response);
    });
    req.open('GET', params.printable, true);
    req.send();
  }
});

function createBlobAndPrint(params, printFrame, data) {
  // Pass response or base64 data to a blob and create a local object url
  var localPdf = new window.Blob([data], {
    type: 'application/pdf'
  });
  localPdf = window.URL.createObjectURL(localPdf); // Set iframe src with pdf document url

  printFrame.setAttribute('src', localPdf);
  _print__WEBPACK_IMPORTED_MODULE_0__["default"].send(params, printFrame);
}

/***/ }),

/***/ "./src/js/print.js":
/*!*************************!*\
  !*** ./src/js/print.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./browser */ "./src/js/browser.js");
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");


var Print = {
  send: function send(params, printFrame) {
    // Append iframe element to document body
    document.getElementsByTagName('body')[0].appendChild(printFrame); // Get iframe element

    var iframeElement = document.getElementById(params.frameId); // Wait for iframe to load all content

    iframeElement.onload = function () {
      if (params.type === 'pdf') {
        // Add a delay for Firefox. In my tests, 1000ms was sufficient but 100ms was not
        if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isFirefox()) {
          setTimeout(function () {
            return performPrint(iframeElement, params);
          }, 1000);
        } else {
          performPrint(iframeElement, params);
        }

        return;
      } // Get iframe element document


      var printDocument = iframeElement.contentWindow || iframeElement.contentDocument;
      if (printDocument.document) printDocument = printDocument.document; // Append printable element to the iframe body

      printDocument.body.appendChild(params.printableElement); // Add custom style

      if (params.type !== 'pdf' && params.style) {
        // Create style element
        var style = document.createElement('style');
        style.innerHTML = params.style; // Append style element to iframe's head

        printDocument.head.appendChild(style);
      } // If printing images, wait for them to load inside the iframe


      var images = printDocument.getElementsByTagName('img');

      if (images.length > 0) {
        loadIframeImages(Array.from(images)).then(function () {
          return performPrint(iframeElement, params);
        });
      } else {
        performPrint(iframeElement, params);
      }
    };
  }
};

function performPrint(iframeElement, params) {
  try {
    iframeElement.focus(); // If Edge or IE, try catch with execCommand

    if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isEdge() || _browser__WEBPACK_IMPORTED_MODULE_0__["default"].isIE()) {
      try {
        iframeElement.contentWindow.document.execCommand('print', false, null);
      } catch (e) {
        iframeElement.contentWindow.print();
      }
    } else {
      // Other browsers
      iframeElement.contentWindow.print();
    }
  } catch (error) {
    params.onError(error);
  } finally {
    if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isFirefox()) {
      // Move the iframe element off-screen and make it invisible
      iframeElement.style.visibility = 'hidden';
      iframeElement.style.left = '-1px';
    }

    Object(_functions__WEBPACK_IMPORTED_MODULE_1__["cleanUp"])(params);
  }
}

function loadIframeImages(images) {
  var promises = images.map(function (image) {
    if (image.src && image.src !== window.location.href) {
      return loadIframeImage(image);
    }
  });
  return Promise.all(promises);
}

function loadIframeImage(image) {
  return new Promise(function (resolve) {
    var pollImage = function pollImage() {
      !image || typeof image.naturalWidth === 'undefined' || image.naturalWidth === 0 || !image.complete ? setTimeout(pollImage, 500) : resolve();
    };

    pollImage();
  });
}

/* harmony default export */ __webpack_exports__["default"] = (Print);

/***/ }),

/***/ "./src/js/raw-html.js":
/*!****************************!*\
  !*** ./src/js/raw-html.js ***!
  \****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./print */ "./src/js/print.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Create printable element (container)
    params.printableElement = document.createElement('div');
    params.printableElement.setAttribute('style', 'width:100%'); // Set our raw html as the printable element inner html content

    params.printableElement.innerHTML = params.printable; // Print html contents

    _print__WEBPACK_IMPORTED_MODULE_0__["default"].send(params, printFrame);
  }
});

/***/ }),

/***/ "./src/sass/index.scss":
/*!*****************************!*\
  !*** ./src/sass/index.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ 0:
/*!****************************!*\
  !*** multi ./src/index.js ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./src/index.js */"./src/index.js");


/***/ })

/******/ })["default"];
});
//# sourceMappingURL=print.map

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-385e4f75\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      staticClass: "algunaClase",
      attrs: {
        visible: _vm.is_payment,
        "close-on-click-modal": false,
        "close-on-press-escape": false,
        "modal-append-to-body": true,
        "show-close": false,
        "append-to-body": true,
        width: "770px",
        top: "2vh",
        title: "MODULO DE COBRO " + (_vm.variation ? "- Variación" : "")
      },
      on: {
        open: function($event) {
          return _vm.date_of_issue()
        }
      }
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
          staticClass: " mb-0"
        },
        [
          _c(
            "div",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading_submit,
                  expression: "loading_submit"
                }
              ],
              staticClass: "pt-1"
            },
            [
              _c("div", { staticClass: "row pt-2" }, [
                _c("div", { staticClass: "col-lg-12" }, [
                  _c("div", { staticClass: "mb-2" }, [
                    _c("div", { staticClass: "card bg-light" }, [
                      _c("div", { staticClass: "row " }, [
                        _c(
                          "div",
                          { staticClass: "  col-md-6 col-lg-5 col-sm-6" },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v(
                                "Comprobante de Pago\n                                    "
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "form-group" },
                              [
                                _c(
                                  "el-radio-group",
                                  {
                                    attrs: { size: "small" },
                                    on: {
                                      change: function($event) {
                                        _vm.date_of_issue()
                                        _vm.filterSeries()
                                      }
                                    },
                                    model: {
                                      value: _vm.form.document_type_id,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.form,
                                          "document_type_id",
                                          $$v
                                        )
                                      },
                                      expression: "form.document_type_id"
                                    }
                                  },
                                  [
                                    !_vm.isInterno
                                      ? [
                                          _c(
                                            "el-radio-button",
                                            { attrs: { label: "01" } },
                                            [
                                              _vm._v(
                                                "FACTURA\n                                                "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "el-radio-button",
                                            { attrs: { label: "03" } },
                                            [
                                              _vm._v(
                                                "\n                                                    BOLETA\n                                                "
                                              )
                                            ]
                                          )
                                        ]
                                      : _vm._e(),
                                    _vm._v(" "),
                                    !_vm.variation
                                      ? _c(
                                          "el-radio-button",
                                          { attrs: { label: "80" } },
                                          [
                                            _vm._v(
                                              "\n                                                N. VENTA\n                                            "
                                            )
                                          ]
                                        )
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ],
                              1
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-6 col-md-3 col-lg-3 col-xl-3" },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v(
                                "\n                                        Serie\n                                    "
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "form-group" },
                              [
                                _c(
                                  "el-select",
                                  {
                                    staticClass: "w-100",
                                    model: {
                                      value: _vm.form.series_id,
                                      callback: function($$v) {
                                        _vm.$set(_vm.form, "series_id", $$v)
                                      },
                                      expression: "form.series_id"
                                    }
                                  },
                                  _vm._l(_vm.series, function(option) {
                                    return _c("el-option", {
                                      key: option.id,
                                      staticStyle: {
                                        "z-index": "2000 !important"
                                      },
                                      attrs: {
                                        label: option.full_number,
                                        value: option.id
                                      }
                                    })
                                  }),
                                  1
                                )
                              ],
                              1
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-6 col-md-4 col-lg-4 " }, [
                          _c(
                            "div",
                            { staticClass: "form-group" },
                            [
                              _c("label", { staticClass: "control-label" }, [
                                _vm._v("Fecha de Emisión")
                              ]),
                              _vm._v(" "),
                              _c("el-date-picker", {
                                staticStyle: { width: "100%" },
                                attrs: {
                                  type: "date",
                                  "value-format": "yyyy-MM-dd",
                                  clearable: false,
                                  format: "dd-MM-yyyy",
                                  readonly: "",
                                  "picker-options": _vm.datEmision
                                },
                                model: {
                                  value: _vm.form.date_of_issue,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "date_of_issue", $$v)
                                  },
                                  expression: "form.date_of_issue"
                                }
                              })
                            ],
                            1
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "row " }, [
                        _c("div", { staticClass: "col-lg-6 " }, [
                          _c(
                            "div",
                            { staticClass: "form-group" },
                            [
                              [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "el-input el-input-group col-md-6 ",
                                    staticStyle: { "margin-bottom": "3px" }
                                  },
                                  [
                                    _c(
                                      "label",
                                      {
                                        staticClass: "control-label",
                                        staticStyle: { "margin-right": "3px" }
                                      },
                                      [
                                        _vm._v(
                                          "Seleccion de\n                                                    Cliente"
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "el-button",
                                      {
                                        attrs: { disabled: !_vm.value },
                                        on: {
                                          click: function($event) {
                                            _vm.showDialogNewPerson = true
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "Editar\n                                                    cliente"
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "el-button",
                                      { on: { click: _vm.createClient } },
                                      [
                                        _vm._v(
                                          "Nuevo\n                                                    cliente"
                                        )
                                      ]
                                    )
                                  ],
                                  1
                                )
                              ]
                            ],
                            2
                          )
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-12 col-sm-8 col-lg-6" },
                          [
                            _c(
                              "el-select",
                              {
                                ref: "select_person",
                                staticClass: "col-md-6",
                                attrs: {
                                  filterable: "",
                                  clearable: "",
                                  size: "small",
                                  placeholder: "Cliente",
                                  disabled: _vm.loading
                                },
                                on: { change: _vm.changeCustomer },
                                nativeOn: {
                                  keyup: [
                                    function($event) {
                                      return _vm.keyupCustomer.apply(
                                        null,
                                        arguments
                                      )
                                    },
                                    function($event) {
                                      if (
                                        !$event.type.indexOf("key") &&
                                        _vm._k(
                                          $event.keyCode,
                                          "enter",
                                          13,
                                          $event.key,
                                          "Enter"
                                        )
                                      ) {
                                        return null
                                      }
                                      return _vm.keyupCustomer()
                                    }
                                  ]
                                },
                                model: {
                                  value: _vm.value,
                                  callback: function($$v) {
                                    _vm.value = $$v
                                  },
                                  expression: "value"
                                }
                              },
                              _vm._l(_vm.customers, function(option) {
                                return _c("el-option", {
                                  key: option.id,
                                  attrs: {
                                    label: option.description,
                                    value: option.id
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
                      _c("div", { staticClass: "row col-lg-6 col-xl-12" }, [
                        _c(
                          "div",
                          { staticClass: "form-group" },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Observaciones")
                            ]),
                            _vm._v(" "),
                            _c("el-input", {
                              attrs: { type: "textarea", rows: 2 },
                              model: {
                                value: _vm.form.observation,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "observation", $$v)
                                },
                                expression: "form.observation"
                              }
                            })
                          ],
                          1
                        )
                      ])
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-12" }, [
                  _c("div", { staticClass: " mb-2 " }, [
                    _c(
                      "div",
                      {
                        staticClass: " text-center text-dark card  bg-light  "
                      },
                      [
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "  col-lg-12 " }, [
                            _c("div", { staticClass: " align-items-start " }, [
                              _c("label", { staticClass: "control-label" }, [
                                _vm._v("Medios de Pago")
                              ]),
                              _vm._v(" "),
                              _c("label", {
                                staticClass: "text-primary control-label",
                                attrs: { role: "button" }
                              })
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "radio-tile-group2 flex-wrap" },
                              [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "cash",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "01"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "01"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "01"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "Efectivo"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonEfectivo.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon walk-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "cash" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "culqui",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "02"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "02"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "02"
                                          },
                                          function($event) {
                                            return _vm.method_payment("Culqui")
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/CulquiIcon.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "05"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "05"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "05"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "TARJETA: IZYPAY"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonIzipay.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "06"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "06"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "06"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "TARJETA: NIUBIZ"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonNiubiz.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "yape",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "03"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "03"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "03"
                                          },
                                          function($event) {
                                            return _vm.method_payment("Yape")
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "04"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "04"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "04"
                                          },
                                          function($event) {
                                            return _vm.method_payment("PLIN")
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/plin-logo-0C4106153C-seeklogo.com.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c("div", { staticClass: "row col-md-12" }, [
                              _c("div", { staticClass: "row" }, [
                                _c(
                                  "label",
                                  { staticClass: "control-label text-center" },
                                  [
                                    _vm._v(
                                      "Emision de\n                                                comprobante"
                                    )
                                  ]
                                )
                              ]),
                              _vm._v(" "),
                              _c("div", { staticClass: "row" }, [
                                _c(
                                  "div",
                                  { staticClass: "col-lg-2 col-md-5 col-xl-6" },
                                  [
                                    _c(
                                      "label",
                                      {
                                        staticClass:
                                          "control-label text-left  d-flex align-items-start justify-content-start"
                                      },
                                      [
                                        _vm._v(
                                          "\n                                                    Ingrese Nro Celular\n                                                "
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "el-input",
                                      {
                                        model: {
                                          value: _vm.form.customer_telephone,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.form,
                                              "customer_telephone",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "\n                                                        form.customer_telephone\n                                                    "
                                        }
                                      },
                                      [
                                        _c("template", { slot: "prepend" }, [
                                          _c("i", {
                                            staticClass: "fab fa-whatsapp fa-2x"
                                          })
                                        ])
                                      ],
                                      2
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "radio-tile-group2 col-lg-6 col-xl-6 d ",
                                    staticStyle: { "padding-top": "12px" }
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "input-container2 border rounded-sm col-lg-3"
                                      },
                                      [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: _vm.printerOn,
                                              expression: "printerOn"
                                            }
                                          ],
                                          staticClass: "radio-button2",
                                          attrs: {
                                            id: "imprimir",
                                            type: "radio",
                                            name: "imprimir",
                                            value: "1"
                                          },
                                          domProps: {
                                            checked: _vm._q(_vm.printerOn, "1")
                                          },
                                          on: {
                                            change: function($event) {
                                              _vm.printerOn = "1"
                                            }
                                          }
                                        }),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          { staticClass: "radio-tile2" },
                                          [
                                            _c(
                                              "div",
                                              { staticClass: "icon walk-icon" },
                                              [
                                                _c("i", {
                                                  staticClass: "fa fa-print"
                                                })
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "label",
                                              {
                                                staticClass:
                                                  "radio-tile-label2",
                                                attrs: { for: "cash" }
                                              },
                                              [_vm._v("Imprimir")]
                                            )
                                          ]
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "input-container2 border rounded-sm col-lg-3"
                                      },
                                      [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: _vm.printerOn,
                                              expression: "printerOn"
                                            }
                                          ],
                                          staticClass: "radio-button2",
                                          attrs: {
                                            id: "noimprimir",
                                            type: "radio",
                                            name: "noimprimir",
                                            value: "0"
                                          },
                                          domProps: {
                                            checked: _vm._q(_vm.printerOn, "0")
                                          },
                                          on: {
                                            change: function($event) {
                                              _vm.printerOn = "0"
                                            }
                                          }
                                        }),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          { staticClass: "radio-tile2" },
                                          [
                                            _c(
                                              "div",
                                              { staticClass: "icon bike-icon" },
                                              [
                                                _c("i", {
                                                  staticClass: "fa fa-print"
                                                })
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "label",
                                              {
                                                staticClass:
                                                  "radio-tile-label2",
                                                attrs: { for: "Tarjeta" }
                                              },
                                              [
                                                _vm._v(
                                                  "No\n                                                            Imprimir"
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ])
                            ]),
                            _vm._v(" "),
                            _c("div", { staticClass: "row" }, [
                              _c("div", {
                                staticClass:
                                  "col-lg-8  d-flex flex-row align-items-end"
                              }),
                              _vm._v(" "),
                              _c("div", { staticClass: "d-flex flex-column" })
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass: "row d-flex justify-content-start"
                              },
                              [
                                _vm.currentPayments.length != 0
                                  ? _c("table", { staticClass: "table" }, [
                                      _c("thead", [
                                        _c("tr", [
                                          _c(
                                            "th",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "4" }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        Pagos\n                                                    "
                                              )
                                            ]
                                          )
                                        ])
                                      ]),
                                      _vm._v(" "),
                                      _c(
                                        "tbody",
                                        _vm._l(_vm.currentPayments, function(
                                          paymnt,
                                          idx
                                        ) {
                                          return _c("tr", { key: idx }, [
                                            _c("td", [_vm._v(_vm._s(idx + 1))]),
                                            _vm._v(" "),
                                            _c("td", [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(paymnt.method) +
                                                  "\n                                                    "
                                              )
                                            ]),
                                            _vm._v(" "),
                                            _c("td", [
                                              _c("strong", [
                                                _vm._v(_vm._s(paymnt.amount))
                                              ])
                                            ]),
                                            _vm._v(" "),
                                            _c("td", [
                                              _c(
                                                "label",
                                                {
                                                  staticClass: "text-danger",
                                                  attrs: {
                                                    for: "",
                                                    role: "button"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.removePayment(
                                                        paymnt.id
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass: "fa fa-trash"
                                                  })
                                                ]
                                              )
                                            ])
                                          ])
                                        }),
                                        0
                                      )
                                    ])
                                  : _vm._e()
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: " card  bg-light col-lg-12  "
                          })
                        ])
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-12" }, [
                    _c("div", { staticClass: "mb-2" }, [
                      _c("div", { staticClass: " card  bg-light " }, [
                        _c("div", { staticClass: "row" }, [
                          _c(
                            "div",
                            {
                              staticClass: " col-xl-4",
                              class: {
                                "has-danger": _vm.form.difference < 0
                              },
                              staticStyle: {
                                "margin-top": "10px",
                                "padding-top": "5px"
                              }
                            },
                            [
                              _c("label", { staticClass: "control-label h1" }, [
                                _vm._v("Total a cobrar: ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "span",
                                {
                                  staticClass:
                                    "control-label font-weight-semibold text-center h3"
                                },
                                [
                                  _vm._v(
                                    "\n                                            S/ " +
                                      _vm._s(" " + _vm.form.total) +
                                      "\n                                        "
                                  )
                                ]
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _vm.form_payment.payment_method_type_id == "01"
                            ? _c("div", { staticClass: "col-xl-8" }, [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "btn-group btn-group-square m-0 flex-wrap justify-content-around",
                                    staticStyle: { "padding-top": "12px" },
                                    attrs: { role: "group" }
                                  },
                                  [
                                    _c(
                                      "label",
                                      { staticClass: "control-label" },
                                      [_vm._v("Ingrese monto")]
                                    ),
                                    _vm._v(" "),
                                    _c("div", { staticClass: "row col-12" }, [
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "col-2 col-md-2  col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(10)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "10\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "col-2 col-md-2  col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(20)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "20\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "col-2 col-md-2  col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(50)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "50\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "col-2 col-md-2  col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(100)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "100\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "col-2 col-md-2  col-xl-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-outline-primary btn_responsive m-2",
                                              on: {
                                                click: function($event) {
                                                  return _vm.setAmountCash(200)
                                                }
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.currencyTypeActive
                                                      .symbol
                                                  ) +
                                                  "200\n                                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      { staticClass: "row col-xl-12 col-12" },
                                      [
                                        _c(
                                          "div",
                                          { staticClass: "col-xl-6 col-3" },
                                          [
                                            _c(
                                              "el-input",
                                              {
                                                ref: "enter_amount",
                                                attrs: { id: "inputTotal" },
                                                on: {
                                                  blur: function($event) {
                                                    return _vm.diferen()
                                                  },
                                                  input: function($event) {
                                                    return _vm.enterAmount()
                                                  }
                                                },
                                                nativeOn: {
                                                  keyup: function($event) {
                                                    if (
                                                      !$event.type.indexOf(
                                                        "key"
                                                      ) &&
                                                      _vm._k(
                                                        $event.keyCode,
                                                        "enter",
                                                        13,
                                                        $event.key,
                                                        "Enter"
                                                      )
                                                    ) {
                                                      return null
                                                    }
                                                    _vm.sendPayment()
                                                    _vm.inputAmount(
                                                      _vm.form.enter_amount
                                                    )
                                                  }
                                                },
                                                model: {
                                                  value: _vm.form.enter_amount,
                                                  callback: function($$v) {
                                                    _vm.$set(
                                                      _vm.form,
                                                      "enter_amount",
                                                      $$v
                                                    )
                                                  },
                                                  expression:
                                                    "\n                                                            form.enter_amount\n                                                        "
                                                }
                                              },
                                              [
                                                _c(
                                                  "template",
                                                  { slot: "prepend" },
                                                  [
                                                    _vm._v(
                                                      _vm._s(
                                                        _vm.currencyTypeActive
                                                          .symbol
                                                      )
                                                    )
                                                  ]
                                                )
                                              ],
                                              2
                                            )
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          { staticClass: "m-2 col-xl-2 col-2" },
                                          [
                                            _c(
                                              "el-button",
                                              {
                                                attrs: { type: "primary" },
                                                on: { click: _vm.addPayment }
                                              },
                                              [_vm._v("Agregar")]
                                            )
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          {
                                            staticClass: "m-2 col-xl-3 col-3 "
                                          },
                                          [
                                            _c(
                                              "el-button",
                                              {
                                                attrs: { type: "success" },
                                                on: {
                                                  click: function($event) {
                                                    _vm.showSplitPayment = true
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "Dividir\n                                                        pago"
                                                )
                                              ]
                                            )
                                          ],
                                          1
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _c("div", { staticClass: " row col-xl-4" }, [
                            _c("div", {
                              staticClass: "col-xl-5",
                              staticStyle: { "margin-bottom": "10px" }
                            })
                          ])
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "col-xl-3" }),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-xl-5" }),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-xl-4" }, [
                            _c(
                              "div",
                              {
                                staticClass:
                                  "form-group d-flex flex-row align-items-end",
                                class: {
                                  "has-danger": _vm.form.difference < 0
                                }
                              },
                              [
                                _c("label", {
                                  staticClass: "control-label display-4",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.form.difference < 0
                                        ? "Faltante: "
                                        : "Vuelto: "
                                    )
                                  }
                                }),
                                _vm._v(" "),
                                _c(
                                  "span",
                                  {
                                    staticClass:
                                      "control-label font-weight-semibold text-center display-3 "
                                  },
                                  [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(_vm.currencyTypeActive.symbol) +
                                        _vm._s(_vm.form.difference.toFixed(2))
                                    )
                                  ]
                                )
                              ]
                            )
                          ])
                        ])
                      ])
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _vm.splitPayments.length != 0
                ? _c("div", { staticClass: "row m-1 p-2  bg-light rounded" }, [
                    _c("span", { staticStyle: { "margin-bottom": "5px" } }, [
                      _vm._v("Pagos divididos")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "d-flex flex-wrap " },
                      _vm._l(_vm.splitPayments, function(payment, idx) {
                        return _c("div", { key: idx, staticClass: "col-2" }, [
                          _vm._v(
                            "\n                        Pago " +
                              _vm._s(idx + 1) +
                              ":\n                        "
                          ),
                          _c("strong", [
                            _vm._v("S/. " + _vm._s(payment.amount))
                          ])
                        ])
                      }),
                      0
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.splitProducts.length != 0
                ? _c("div", { staticClass: "row m-1 p-2  bg-light rounded" }, [
                    _c("span", { staticStyle: { "margin-bottom": "5px" } }, [
                      _vm._v("Pagos divididos por producto")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "d-flex flex-wrap " },
                      _vm._l(_vm.splitProducts, function(payment, idx) {
                        return _c(
                          "div",
                          { key: idx, staticClass: "col-3 m-1" },
                          [
                            payment.products && payment.products.length > 0
                              ? _c("table", { staticClass: "col-12" }, [
                                  _c("thead", [
                                    _c(
                                      "tr",
                                      {
                                        class:
                                          "bg-primary text-white border rounded-top",
                                        attrs: { role: "button" },
                                        on: {
                                          click: function($event) {
                                            return _vm.selectAccount(idx)
                                          }
                                        }
                                      },
                                      [
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            attrs: { colspan: "3" }
                                          },
                                          [
                                            _c("b", [
                                              _vm._v(
                                                " CUENTA " +
                                                  _vm._s(idx + 1) +
                                                  " "
                                              )
                                            ])
                                          ]
                                        )
                                      ]
                                    )
                                  ]),
                                  _vm._v(" "),
                                  payment.products &&
                                  payment.products.length > 0
                                    ? _c(
                                        "tbody",
                                        { staticClass: "border rounded-top " },
                                        [
                                          _vm._l(payment.products, function(
                                            product,
                                            idx
                                          ) {
                                            return _c("tr", { key: idx }, [
                                              _c("td", [
                                                _c(
                                                  "h3",
                                                  {
                                                    staticClass:
                                                      "text-muted text-small"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(
                                                          product.quantity
                                                        ) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]),
                                              _vm._v(" "),
                                              _c("td", [
                                                _c(
                                                  "h3",
                                                  {
                                                    staticClass:
                                                      "text-muted text-small"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(
                                                          product.description
                                                        ) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]),
                                              _vm._v(" "),
                                              _c(
                                                "td",
                                                {
                                                  staticStyle: {
                                                    "text-align": "right"
                                                  }
                                                },
                                                [
                                                  _c(
                                                    "h3",
                                                    {
                                                      staticClass:
                                                        "text-muted text-small"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            product.price *
                                                              product.quantity
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  )
                                                ]
                                              )
                                            ])
                                          }),
                                          _vm._v(" "),
                                          _c("tr", [
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-muted text-small",
                                                staticStyle: {
                                                  "text-align": "right"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [_c("b", [_vm._v(" Total")])]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-muted text-small"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                        S/.\n                                        " +
                                                    _vm._s(
                                                      _vm.totalItemSelected(
                                                        payment.products
                                                      )
                                                    ) +
                                                    "\n                                    "
                                                )
                                              ]
                                            )
                                          ])
                                        ],
                                        2
                                      )
                                    : _c("tbody", { staticClass: "border" }, [
                                        _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              attrs: { colspan: "3" }
                                            },
                                            [
                                              _c(
                                                "h3",
                                                {
                                                  staticClass:
                                                    "text-muted text-small"
                                                },
                                                [
                                                  _vm._v(
                                                    "\n                                            Sin productos seleccionados\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      ])
                                ])
                              : _vm._e()
                          ]
                        )
                      }),
                      0
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c("div", { staticClass: "p-3" }, [
                _c("div", { staticClass: "row " }, [
                  _c("div", { staticClass: "col-lg-4" }, [
                    _c(
                      "div",
                      {
                        staticClass: "btn-group btn-group-square",
                        attrs: { role: "group" }
                      },
                      [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-block btn-primary",
                            attrs: { disabled: _vm.button_payment },
                            on: { click: _vm.sendPayment }
                          },
                          [
                            _c("i", { staticClass: "fas fa-money-bill-alt" }),
                            _vm._v(
                              "\n                                PAGAR\n                            "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-block btn-dark",
                            on: {
                              click: function($event) {
                                return _vm.back(false)
                              }
                            }
                          },
                          [
                            _c("i", { staticClass: "fa fa-reply" }),
                            _vm._v(" Cerrar\n                            ")
                          ]
                        )
                      ]
                    )
                  ])
                ])
              ])
            ]
          ),
          _vm._v(" "),
          _c("multiple-payment-form", {
            attrs: {
              showDialog: _vm.showDialogMultiplePayment,
              payments: _vm.payments
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogMultiplePayment = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogMultiplePayment = $event
              },
              add: _vm.addRow
            }
          }),
          _vm._v(" "),
          _c("card-brands-form", {
            attrs: {
              showDialog: _vm.showDialogNewCardBrand,
              external: true,
              recordId: null
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogNewCardBrand = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogNewCardBrand = $event
              }
            }
          }),
          _vm._v(" "),
          _c("person-form", {
            attrs: {
              showDialog: _vm.showDialogNewPerson,
              type: "customers",
              input_person: _vm.input_person,
              external: true,
              user_id: _vm.form.user_id,
              document_type_id: _vm.form.document_type_id,
              recordId: _vm.form.customer_id
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogNewPerson = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogNewPerson = $event
              },
              "update:user_id": function($event) {
                return _vm.$set(_vm.form, "user_id", $event)
              },
              add_customer: _vm.add_customer
            }
          }),
          _vm._v(" "),
          _c("show-split-payment-form", {
            attrs: {
              orden_items: _vm.orden_items,
              total: _vm.form.total,
              showSplitPayment: _vm.showSplitPayment
            },
            on: {
              receivePayments: _vm.receivePayments,
              receiveProducts: _vm.receiveProducts,
              "update:showSplitPayment": function($event) {
                _vm.showSplitPayment = $event
              },
              "update:show-split-payment": function($event) {
                _vm.showSplitPayment = $event
              }
            }
          })
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
    require("vue-hot-reload-api")      .rerender("data-v-385e4f75", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("71657b18", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./payment.vue", function() {
     var newContent = require("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./payment.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=105.js.map
>>>>>>> master
