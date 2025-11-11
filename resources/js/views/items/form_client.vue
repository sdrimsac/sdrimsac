<template>
    <el-dialog :visible.sync="internalDialog" width="60%" :before-close="handleClose" :close-on-click-modal="false"
        :close-on-press-escape="false" title="Productos por cliente">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr slot="heading" style="background:#1e5a85;color:#fff;">
                            <th class="text-white" style="width:12%; min-width:80px; white-space:nowrap;">CPE</th>
                            <th class="text-white text-center" style="width:8%; min-width:60px;">Cant</th>
                            <th class="text-white" style="width:20%; min-width:100px;">Producto</th>
                            <th class="text-white text-center" style="width:15%; min-width:110px;">Fecha</th>
                            <th class="text-white text-right" style="width:15%; min-width:90px;">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, idx) in paginatedItems" :key="idx"
                            :style="{ backgroundColor: idx % 2 === 0 ? '#ffffff' : '#f7f7f7' }">
                            <td class="align-middle" style="white-space:nowrap; padding: .35rem .75rem;">
                                <small>
                                    <span style="font-size:1rem; font-weight:700; color:#073f68;">
                                        {{ item.document }}
                                    </span>
                                </small>
                            </td>

                            <td class="align-middle text-center" style="width:80px; padding: .35rem .75rem;">
                                <small>{{ isNaN(Number(item.quantity)) ? '0.00' : Number(item.quantity).toFixed(2)
                                }}</small>
                            </td>

                            <td class="align-middle" style="width:40%; padding: .35rem .75rem;">
                                <small class="d-block text-truncate" style="max-width:100%;">
                                    {{ item.description }}
                                    <span v-if="item.selectedAncho && item.selectedGrosor && item.selectedLargo">
                                        - {{ item.selectedAncho }}x{{ item.selectedGrosor }}x{{ item.selectedLargo }}
                                    </span>
                                </small>
                            </td>

                            <td class="align-middle text-center" style="width:120px; padding: .35rem .75rem;">
                                <small>{{ item.date_of_issue }}</small>
                            </td>

                            <td class="align-middle text-right" style="width:100px; padding: .35rem .75rem;">
                                <small>{{ isNaN(Number(item.total)) ? '0.00' : Number(item.total).toFixed(2)
                                }}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- pagination controls -->
                <div class="mt-2 d-flex justify-content-end align-items-center">
                    <el-pagination
                        v-if="filteredItems && filteredItems.length > perPage"
                        :page-size="perPage"
                        :current-page="currentPage"
                        :total="filteredItems.length"
                        layout="prev, pager, next"
                        @current-change="handlePageChange"
                        background>
                    </el-pagination>
                </div>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    name: 'FormClient',
    props: {
        showDialog: {
            type: Boolean,
            default: false
        },
        customerId: {
            type: [Number, String],
            default: null
        },
        items: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            // pagination
            currentPage: 1,
            perPage: 15
        };
    },
    computed: {
        // proxy so we can use .sync on el-dialog without mutating a prop directly
        internalDialog: {
            get() {
                return this.showDialog;
            },
            set(val) {
                this.$emit('update:showDialog', val);
            }
        },

        // filter items by customerId (support both customer_id and customerId keys)
        // If items already appear to be per-customer (no customer_id on each item), return them as-is.
        filteredItems() {
            const items = this.items || [];
            if (!items.length) return [];

            // detect whether items contain a customer identifier (they are global items)
            const hasCustomerIdField = items.some(i => i && (i.customer_id !== undefined || i.customerId !== undefined || i.customer !== undefined));

            // if items don't carry customer id (i.e. parent already passed per-customer items), return them
            if (!hasCustomerIdField) return items;

            // otherwise filter by customerId (if provided)
            if (!this.customerId) return items;

            return items.filter(i => {
                if (!i) return false;
                return i.customer_id == this.customerId || i.customerId == this.customerId || i.customer == this.customerId;
            });
        },

        // total pages for pagination
        totalPages() {
            const total = (this.filteredItems && this.filteredItems.length) || 0;
            return Math.max(1, Math.ceil(total / this.perPage));
        },

        // items for the current page
        paginatedItems() {
            const items = this.filteredItems || [];
            const start = (this.currentPage - 1) * this.perPage;
            return items.slice(start, start + this.perPage);
        }
    },
    methods: {
        handlePageChange(page) {
            this.currentPage = page;
        },
        handleClose() {
            // emit update to parent so it can close the dialog
            this.$emit('update:showDialog', false);
        },
        fetchItems() {
            // Emit an event so parent can fetch items for the given customer if needed.
            // Parent may listen to 'fetch-items' and update the `items` prop.
            this.$emit('fetch-items', this.customerId);
        }
    },
    watch: {
        showDialog(newVal) {
            if (newVal) {
                this.fetchItems();
            }
        }
        ,
        // reset current page when filteredItems changes (e.g., new customer or fresh fetch)
        filteredItems() {
            // if current page is out of range after items change, reset to 1
            if (this.currentPage > this.totalPages) {
                this.currentPage = 1;
            }
        }
    }
};
</script>