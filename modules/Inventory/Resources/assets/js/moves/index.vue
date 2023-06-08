<template>
<div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="page-header">
            <div class="row">
            <div class="col-sm-6">
                <h6><span>{{ title }}</span></h6>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><span class="text-muted">{{ title }}</span></li>
                </ol>
            </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Listado de {{ title }}</h6>
            </div>
            <div class="card-body">

                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th >Cantidad</th>
                        <th>Almacen Inicial</th>
                        <th>Almacen Destino</th>
                        <th class="text-end">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.created_at }}</td>
                        <td>{{ row.item_description }}</td>
                        <td >{{ row.quantity }}</td>
                        <td>{{ row.warehouse }}</td>
                        <td>{{ row.warehouse_destination }}</td>
                        <td class="text-end">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-warning"
                                    @click.prevent="clickRemove(row.id)">Remover</button>
                        </td>
                    </tr>
                </data-table>

            </div>


        </div>
    </div>
</div>
</template>

<script>


    import DataTable from '../../../../../../resources/js/components/DataTable.vue'

    export default {
          components: {DataTable},
        data() {
            return {
                title: null,
                showDialog: false,
                showDialogMove: false,
                showDialogRemove: false,
                resource: 'moves',
                recordId: null,
                typeTransaction:null,
            }
        },
        created() {
            this.title = 'Traslados'
        },
        methods: {
            clickRemove()
            {

            }
        }
    }
</script>
