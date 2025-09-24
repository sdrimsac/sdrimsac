<template>
    <div class="card mb-0 pt-0 pt-md-0">
        <div class="card-header bg-primary d-flex align-items-center" style="padding: 16px;">
            <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1rem; font-weight: bold;">
                <i class="fas fa-box-open" style="font-size: 1rem; margin-right: 0.5rem;"></i>
                Consulta de Kardex
            </h4>
        </div>

        <div class="card mb-0">
            
            <div class="card-body" style="padding: 10px;">
                <data-table :resource="resource" :establecimiento.sync="establecimiento" class="table-striped"
                    ref="dataTable" :invertir-orden.sync="invertirOrden">
                    <tr slot="heading" width="100%" class="bg-primary">
                        <th class="text-white" style="width: 10px;">#</th>
                        <th v-if="!item_id" class="text-white" style="width: 100px;">Producto</th>
                        <th class="text-white" style="width: 50px;"></th>
                        <th class="text-white" style="width: 200px;">Usuario</th>
                        <th class="text-white" style="width: 80px;">Tipo transacción</th>
                        <th class="text-white text-center" style="width: 80px;">Número</th>
                        <th class="text-white text-center" style="width: 80px;">NV. Asociada</th>
                        <th class="text-white text-center" style="width: 100px;">Entrada</th>
                        <th class="text-white text-center" style="width: 100px;">Salida</th>
                        <th class="text-white text-center" style="width: 100px;">Saldo</th>
                        
                    </tr>
                    <tr slot-scope="{ index, row }" :class="{ disable_color: !row.active }">
                        <td>{{ index }}</td>
                        <td v-if="!item_id">{{ row.item_name }}</td>
                        <td>
                            <template v-if="row.user_avatar">
                                <img :src="row.user_avatar" alt="avatar"
                                    style="width:80px; height:80px; border-radius:50%; margin-right:5px; vertical-align:middle;">
                            </template>
                        </td>
                        <td class="text-left align-middle">


                            {{ row.user_name }}
                            <br>
                            <span style="color: #007bff; font-weight: bold;">
                                {{ row.date_time ? row.date_time.split(' ')[0] : '' }}
                            </span>
                            <br>
                            <small style="color: #28a745; font-weight: bold;">
                                {{ row.date_time ? row.date_time.split(' ')[1] : '' }}
                            </small>
                        </td>
                        <td class="text-left align-middle">
                            {{ row.type_transaction }}
                            <br>
                            <template v-if="row.detail">
                                Comentario: <small>{{ row.detail }}</small>
                            </template>
                        </td>
                        <td class="text-center align-middle"> {{ row.series }} - {{ row.number }}</td>
                        <td class="text-center align-middle">{{ row.sale_note_asoc }}</td>
                        <td class="text-center text-green align-middle" style="font-weight: bold; font-size: 1.1em;">{{
                            row.input }}</td>
                        <td class="text-center text-red align-middle" style="font-weight: bold; font-size: 1.1em;">{{
                            row.output }}</td>
                        <td class="text-center" style="vertical-align: middle;">
                            <span
                                style="font-weight: bold; font-size: 1.1em; display: inline-block; width: 100%; text-align: center;">
                                {{ row.balance }}
                            </span>
                        </td>
                        
                    </tr>
                </data-table>


            </div>
        </div>

    </div>
</template>

<script>

import DataTable from '../../components/DataTableKardex.vue'

export default {
    props: ["establecimiento", "configurations"],
    components: { DataTable },
    data() {
        return {
            resource: 'reports/kardex',
            form: {},
            item_id: null,
            invertirOrden: false
        }
    },
    created() {
        this.$eventHub.$on('emitItemID', (item_id) => {
            // console.log(item_id)
            this.item_id = item_id
        })
    },
    methods: {


    }
}
</script>

<style>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2 !important;
}

/* Colores para Entrada y Salida */
.text-green {
    color: #28a745 !important;
    font-weight: bold;
}

.text-red {
    color: #dc3545 !important;
    font-weight: bold;
}

/* Saldo negativo: rojo intenso y borde */
td .saldo-negativo,
.saldo-negativo {
    color: #b30000 !important;
    font-weight: bold !important;
    border: 3px solid #b30000 !important;
    border-radius: 6px !important;
    background: yellow !important;
    padding: 6px 12px !important;
    display: inline-block !important;
    box-shadow: 0 2px 6px rgba(179, 0, 0, 0.08) !important;
    font-size: 1em !important;
    line-height: 1.2 !important;
}
</style>
