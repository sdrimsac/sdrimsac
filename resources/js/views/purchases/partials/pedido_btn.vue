<template>
    <div class="card-pedido" :class="{'status_danger': status}">
        <div class="card-pedido--header">
            <div>
                {{number}}
            </div>
            <div >
                {{category_name}}
            </div>
        </div>
        <div class="card-pedido--body">
            <div>
                {{restaurant_name}}
            </div>
            <div class="card-time" :class="{'status_text_danger': status}">
                 <div class="card-time--header">
                        {{time}}
                 </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
      props:{
            number:{
                type: String,
                default: "",
                required: false
            },
              category_name:{
                type: String
            },
             restaurant_name:{
                type: String,
                default: "",
                required: false
            },
             time:{
                type: String,
                default: "",
                required: false
            },
             status:{
                type: Boolean,
                default: true,
                required: false
            },
            //Dos estados en ele tiempo estimado y pasado el tiempo
      },
         data () {
            return {
                 form:{}
            }
        }
}
</script>