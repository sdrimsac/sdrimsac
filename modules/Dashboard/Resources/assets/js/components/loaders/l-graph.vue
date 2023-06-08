<template> 
    <div>
        <vcl-table :rows="rows" :columns="columns"></vcl-table>
        <template v-if="!hideCircle">
            <br/><br/>
            <vue-content-loading v-bind="$attrs" :width="width" :animate="true" :height="height">
                <circle cx="50%" cy="50%" :r="radius"/>
                <content-placeholders-heading :img="true" />
                <content-placeholders-text :lines="3" />
            </vue-content-loading>
        </template>
    </div>
</template>


<script>
    
    import { VclTable, VueContentLoading  } from 'vue-content-loading';

    export default {
        props: {
            hideCircle: Boolean,
            radius: Number,
            rows: Number,
            columns: Number,
            width:{
                type: Number,
                required: false,
                default:100
            },
            height:{
                type: Number,
                required: false,
                default:100

            },

        },
        components: { VclTable, VueContentLoading },
        data () {
            return {  
            }
        },
        computed: {
        },
        created() { 
        }, 
        methods: { 
        }
    }
</script>