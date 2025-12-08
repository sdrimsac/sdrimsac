<template>

    <el-tabs type="card" @tab-click="handleClick">
        <el-tab-pane label="Dashboard general">
            <div v-if="typeUser == 'admin' || typeUser == 'superadmin'" class="dashboard-container">


                <div class="filter-bar pro-card">

                    <div class="title-section">
                        <h1
                            style="color: white; font-size: 32px; font-weight: 700; font-family: 'Inter', 'Segoe UI', Arial, sans-serif; margin: 0;">
                            Dashboard General</h1>
                        <p class="subtitle">Resumen de operaciones y rendimiento</p>
                    </div>
                    <div class="filter-item">
                        <label>Establecimiento</label>
                        <el-select v-model="form.establishment_id" @change="loadAll" size="small">
                            <el-option v-for="option in establishments" :key="option.id" :value="option.id"
                                :label="option.name"></el-option>
                        </el-select>
                    </div>

                    <div class="filter-item">
                        <label>Período</label>
                        <el-select v-model="form.period" @change="changePeriod" size="small">
                            <el-option key="month" value="month" label="Por mes"></el-option>
                            <el-option key="between_months" value="between_months" label="Entre meses"></el-option>
                            <el-option key="date" value="date" label="Por fecha"></el-option>
                            <el-option key="between_dates" value="between_dates" label="Entre fechas"></el-option>
                        </el-select>
                    </div>

                    <template v-if="form.period === 'month' || form.period === 'between_months'">
                        <div class="filter-item">
                            <label>Mes de</label>
                            <el-date-picker v-model="form.month_start" type="month" @change="changeDisabledMonths"
                                value-format="yyyy-MM" format="MM/yyyy" :clearable="false"
                                size="small"></el-date-picker>
                        </div>
                    </template>
                    <template v-if="form.period === 'between_months'">
                        <div class="filter-item">
                            <label>Mes al</label>
                            <el-date-picker v-model="form.month_end" type="month" :picker-options="pickerOptionsMonths"
                                @change="loadAll" value-format="yyyy-MM" format="MM/yyyy" :clearable="false"
                                size="small"></el-date-picker>
                        </div>
                    </template>
                    <template v-if="form.period === 'date' || form.period === 'between_dates'">
                        <div class="filter-item">
                            <label>Fecha del</label>
                            <el-date-picker v-model="form.date_start" type="date" @change="changeDisabledDates"
                                value-format="yyyy-MM-dd" format="dd/MM/yyyy" :clearable="false"
                                size="small"></el-date-picker>
                        </div>
                    </template>
                    <template v-if="form.period === 'between_dates'">
                        <div class="filter-item">
                            <label>Fecha al</label>
                            <el-date-picker v-model="form.date_end" type="date" :picker-options="pickerOptionsDates"
                                @change="loadAll" value-format="yyyy-MM-dd" format="dd/MM/yyyy" :clearable="false"
                                size="small"></el-date-picker>
                        </div>
                    </template>
                </div>

                <div class="kpi-grid">
                    <div class="pro-card kpi-card">
                        <div class="kpi-icon icon-glow-blue">
                            <i class="el-icon-tickets"></i>
                        </div>
                        <div class="kpi-content">
                            <span class="kpi-label">CPE Emitidos</span>
                            <h3 class="kpi-value">{{ total_cpe }}</h3>
                        </div>
                    </div>

                    <div class="pro-card kpi-card">
                        <div class="kpi-icon icon-glow-indigo">
                            <i class="el-icon-money"></i>
                        </div>
                        <div class="kpi-content">
                            <span class="kpi-label">Total CPE</span>
                            <h3 class="kpi-value">S/ {{ document_total_global }}</h3>
                        </div>
                    </div>

                    <div class="pro-card kpi-card">
                        <div class="kpi-icon icon-glow-orange">
                            <i class="el-icon-notebook-1"></i>
                        </div>
                        <div class="kpi-content">
                            <span class="kpi-label">Total Notas Venta</span>
                            <h3 class="kpi-value">S/ {{ sale_note_total_global }}</h3>
                        </div>
                    </div>

                    <div class="pro-card kpi-card highlight-card">
                        <div class="kpi-icon icon-glow-emerald">
                            <i class="el-icon-s-data"></i>
                        </div>
                        <div class="kpi-content">
                            <span class="kpi-label">Monto Total General</span>
                            <h3 class="kpi-value">S/ {{ (Number(sale_note_total_global) +
                                Number(document_total_global)).toFixed(2) }}
                            </h3>
                        </div>
                    </div>

                    <div class="pro-card kpi-card">
                        <div class="kpi-icon icon-glow-green">
                            <i class="el-icon-wallet"></i>
                        </div>
                        <div class="kpi-content">
                            <span class="kpi-label">Utilidad Neta</span>
                            <h3 class="kpi-value" v-if="utilities.totals">S/ {{ utilities.totals.utility }}</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-3" v-if="soapCompany != '03'">
                                <section class="card card-featured-left card-featured-secondary">
                                    <div class="card-header bg-primary d-flex align-items-center"
                                        style="padding: 10px; background: linear-gradient(90deg,#0b5a8a,#032a4a); ">
                                        <span style="color: white; font-weight: bold;">CPE </span>
                                    </div>
                                    <div class="card-body" v-if="document">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <x-graph type="pie" :all-data="document.graph"></x-graph>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <div class="summary-item">
                                                        <span class="text-muted">Total Pagado</span>
                                                        <h4 class="title text-info">S/ {{ document.totals.total_payment
                                                            }}</h4>
                                                    </div>
                                                    <div class="summary-item">
                                                        <span class="text-muted">Total por Pagar</span>
                                                        <h4 class="title text-danger">S/ {{ document.totals.total_to_pay
                                                            }}</h4>
                                                    </div>
                                                    <div class="summary-item total">
                                                        <span class="text-muted">Total</span>
                                                        <h4 class="title text-white">S/ {{ document.totals.total }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-xl-3">
                                <section class="card card-featured-left card-featured-secondary">
                                    <div class="card-header bg-primary d-flex align-items-center"
                                        style="padding: 10px; background: linear-gradient(90deg,#0b5a8a,#032a4a); ">
                                        <span style="color: white; font-weight: bold;">Notas de Venta</span>
                                    </div>
                                    <div class="card-body" v-if="sale_note">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col">
                                                <div class="row no-gutters">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <x-graph type="pie" :all-data="sale_note.graph"></x-graph>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <div class="summary-item">
                                                            <span class="text-muted">Total Pagado</span>
                                                            <h4 class="title text-info">S/ {{
                                                                sale_note.totals.total_payment }}
                                                            </h4>
                                                        </div>
                                                        <div class="summary-item">
                                                            <span class="text-muted">Total por Pagar</span>
                                                            <h4 class="title text-danger">S/ {{
                                                                sale_note.totals.total_to_pay }}
                                                            </h4>
                                                        </div>
                                                        <div class="summary-item total">
                                                            <span class="text-muted">Total</span>
                                                            <h4 class="title text-white">S/ {{ sale_note.totals.total }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>



                            <div class="col-xl-6 col-md-6">
                                <section class="card card-featured-left card-featured-secondary">
                                    <div class="card-header bg-primary d-flex align-items-center"
                                        style="padding: 10px; background: linear-gradient(90deg,#0b5a8a,#032a4a); ">
                                        <span style="color: white; font-weight: bold;">Totales Generales</span>
                                    </div>
                                    <div class="card-body" v-if="general">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <div class="row no-gutters">
                                                        <div class="row w-100 mt-2">
                                                            <div class="col-lg-4">
                                                                <div class="stat-box bg-dark-gradient">
                                                                    <span class="stat-label">Total Nota Venta</span>
                                                                    <strong class="amount text-danger">S/ {{
                                                                        general.totals.total_sale_notes }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="stat-box bg-dark-gradient">
                                                                    <span class="stat-label">Total Comprobantes</span>
                                                                    <strong class="amount text-info">S/ {{
                                                                        general.totals.total_documents }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="stat-box bg-dark-gradient">
                                                                    <span class="stat-label">Total General</span>
                                                                    <strong class="amount text-white">S/ {{
                                                                        general.totals.total
                                                                        }}</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-20">
                                                        <div class="col-md-12 mt-3">
                                                            <x-graph-line :all-data="general.graph"></x-graph-line>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="col-xl-3 mt-2 col-md-3">
                                <section class="card card-featured-left card-featured-secondary">
                                    <div class="card-header bg-primary d-flex align-items-center"
                                        style="padding: 10px; background: linear-gradient(90deg,#0b5a8a,#032a4a); ">
                                        <span style="color: white; font-weight: bold;">CPE Emitidos</span>
                                    </div>
                                    <div class="card-body" v-if="document">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6 col-sm-6 col-12">
                                                        <div class="doc-stat">Facturas: <span class="val">{{
                                                            count_documents.totals.invoices }}</span></div>
                                                        <div class="doc-stat">Boletas: <span class="val">{{
                                                            count_documents.totals.receives }}</span></div>
                                                        <div class="doc-stat">Notas Venta: <span class="val">{{
                                                            count_documents.totals.sale_notes }}</span></div>
                                                        <div class="doc-stat">Notas Crédito: <span class="val">{{
                                                            count_documents.totals.credit_notes }}</span></div>
                                                        <div class="doc-stat">Notas Débito: <span class="val">{{
                                                            count_documents.totals.debit_notes }}</span></div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-12">
                                                        <x-graph type="doughnut"
                                                            :all-data="count_documents.graph"></x-graph>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="col-xl-3 mt-2 col-md-3">
                                <section class="card card-featured-left card-featured-secondary">
                                    <div class="card-header bg-primary d-flex align-items-center"
                                        style="padding: 10px; background: linear-gradient(90deg,#0b5a8a,#032a4a); ">
                                        <span style="color: white; font-weight: bold;">Utilidades / Ganancias</span>
                                    </div>
                                    <div class="card-body" v-if="utilities">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col">
                                                <div class="row no-gutters">
                                                    <div class="row w-100 mt-2">
                                                        <div class="col-4 text-center">
                                                            <span class="d-block text-muted text-small">Ingreso</span>
                                                            <strong class="text-info">S/ {{
                                                                utilities.totals.total_income
                                                                }}</strong>
                                                        </div>
                                                        <div class="col-4 text-center">
                                                            <span class="d-block text-muted text-small">Egreso</span>
                                                            <strong class="text-danger">S/ {{
                                                                utilities.totals.total_egress
                                                                }}</strong>
                                                        </div>
                                                        <div class="col-4 text-center">
                                                            <span class="d-block text-muted text-small">Utilidad</span>
                                                            <strong class="text-success">S/ {{ utilities.totals.utility
                                                                }}</strong>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 mt-3">
                                                        <div class="summary">
                                                            <el-checkbox v-model="form.enabled_expense"
                                                                @change="loadDataUtilities">Considerar
                                                                gastos</el-checkbox>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="summary">
                                                            <el-checkbox v-model="filter_item"
                                                                @change="changeFilterItem">Filtrar por
                                                                producto</el-checkbox>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-2" v-if="filter_item">
                                                        <div class="summary">
                                                            <el-select v-model="form.item_id" filterable remote
                                                                popper-class="el-select-customers" clearable
                                                                placeholder="Buscar producto"
                                                                :remote-method="searchRemoteItems"
                                                                :loading="loading_search" @change="loadDataUtilities"
                                                                size="small" class="w-100">
                                                                <el-option v-for="option in items" :key="option.id"
                                                                    :value="option.id"
                                                                    :label="option.description"></el-option>
                                                            </el-select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row m-t-20">
                                                    <div class="col-md-12 mt-2">
                                                        <x-graph type="doughnut" :all-data="utilities.graph"></x-graph>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="col-xl-6 col-md-6 mt-2">
                                <section class="card card-featured-left card-featured-secondary">
                                    <div class="card-header bg-primary d-flex align-items-center"
                                        style="padding: 10px; background: linear-gradient(90deg,#0b5a8a,#032a4a); ">
                                        <span style="color: white; font-weight: bold;">Total Compras</span>
                                    </div>
                                    <div class="card-body" v-if="general">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <div class="row no-gutters">


                                                        <div class="row w-100 mt-2 justify-content-center">

                                                            <div class="col-lg-4">
                                                                <div class="stat-box">
                                                                    <span class="stat-label">Total Compras</span>
                                                                    <strong class="amount text-info">S/ {{
                                                                        purchase.totals.purchases_total }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="stat-box">
                                                                    <span class="stat-label">Total</span>
                                                                    <strong class="amount text-white">S/ {{
                                                                        purchase.totals.total
                                                                        }}</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-20">
                                                        <div class="col-md-12 mt-3">
                                                            <x-graph-line :all-data="purchase.graph"></x-graph-line>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="col-xl-3 col-md-6 mt-2">
                                <section class="card">
                                    <div class="card-header bg-primary d-flex align-items-center"
                                        style="padding: 10px; background: linear-gradient(90deg,#0b5a8a,#032a4a); ">
                                        <span style="color: white; font-weight: bold;">Productos Top</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="">
                                            <el-checkbox v-model="form.enabled_move_item" @change="loadDataAditional"
                                                style="color: black;">
                                                Ordenar X movimientos
                                            </el-checkbox>
                                        </div>
                                        <div class="table-responsive " style="max-height: 600px; overflow-y: auto;">
                                            <table class="table ">
                                                <thead style="position: sticky; top: 0; z-index: 1;">
                                                    <tr style="background-color: #073f68;">
                                                        <th style="color: white;">#</th>
                                                        <!-- <th style="color: white;">Código</th> -->
                                                        <th style="color: white;">Producto</th>
                                                        <th class="text-end" style="color: white;">Mov.</th>
                                                        <th class="text-end" style="color: white;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(row, index) in items_by_sales" :key="index"
                                                        :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                                                        <td>{{ index + 1 }}</td>
                                                        <td>
                                                            {{ row.internal_id }}
                                                            <br>
                                                            {{ row.description }}
                                                        </td>
                                                        <!-- <td></td> -->
                                                        <td class="text-end">
                                                            {{ parseInt(row.move_quantity) }}</td>
                                                        <td class="text-end">{{ row.total }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="col-xl-3 col-md-6 mt-2">
                                <section class="card">
                                    <div class="card-header bg-primary d-flex align-items-center"
                                        style="padding: 10px; background: linear-gradient(90deg,#0b5a8a,#032a4a); ">
                                        <span style="color: white; font-weight: bold;">Clientes Top</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="">
                                            <el-checkbox v-model="form.enabled_transaction_customer"
                                                @change="loadDataAditional">Ordenar
                                                por transacciones</el-checkbox>
                                        </div>
                                        <div class="table-responsive " style="max-height: 600px; overflow-y: auto;">
                                            <table class="table ">
                                                <thead>
                                                    <tr
                                                        style="position: sticky; top: 0; z-index: 1; background-color: #073f68;">
                                                        <th style="color: white;">#</th>
                                                        <th style="color: white;">Cliente</th>
                                                        <th class="text-end" style="color: white;">Trans.</th>
                                                        <th class="text-end" style="color: white;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(row, index) in top_customers" :key="index"
                                                        :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                                                        <td>{{ index + 1 }}</td>
                                                        <td>
                                                            {{ row.number }}
                                                            <br />
                                                            {{ row.name }}
                                                        </td>
                                                        <td class="text-end">{{ row.transaction_quantity }}</td>
                                                        <td class="text-end">{{ row.total }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="col-xl-6 col-md-12 col-lg-12 mt-2">
                                <dashboard-stock></dashboard-stock>
                            </div>
                            <div class="col-3"></div>


                            <div class="col-xl-6 col-md-12 col-lg-12 mt-2">
                                <dashboard-conparative></dashboard-conparative>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </el-tab-pane>
        <el-tab-pane label="Dashboard caja"> 
            <dashboar-cash></dashboar-cash>
        </el-tab-pane>
    </el-tabs>
</template>

<style scoped>
/* --- VARIABLES DEL TEMA OSCURO --- */
:root {
    --bg-dashboard: #0f172a;
    /* Azul noche profundo */
    --bg-card: #1e293b;
    /* Azul grisáceo oscuro para tarjetas */
    --text-primary: #ffffff;
    /* Blanco puro */
    --text-secondary: #94a3b8;
    /* Gris azulado claro */
    --border-color: #334155;
    /* Borde sutil */
    --accent-blue: #3b82f6;
    --accent-purple: #8b5cf6;
}

/* --- LAYOUT GENERAL --- */
.dashboard-container {
    font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    color: var(--text-secondary);
    background-color: #e4dccf;
    /* Fondo general oscuro */
    padding: 15px;
    min-height: 100vh;
}

.dashboard-header {
    margin-bottom: 25px;
}

.dashboard-header h2 {
    font-size: 26px;
    font-weight: 700;
    color: #240303;
    margin: 0;
    letter-spacing: -0.5px;
}

.subtitle {
    color: #94a3b8;
    margin: 5px 0 0;
    font-size: 14px;
}

/* --- TARJETAS (CARDS) Principal ESTILO GLASS/DARK --- */
.pro-card {
    background: #073f68 !important;
    /* Fondo oscuro para tarjetas */
    border-radius: 16px;
    /* Bordes redondeados modernos */
    border: 1px solid #334155;
    /* Borde sutil */
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.15);
    color: white;
    margin-bottom: 0;
    /* Controlado por grid */
    height: 100%;
    /* Para que se estiren igual en grid */
}

.card {
    background: #9aa1a7 !important;
    /* Fondo oscuro para tarjetas */
    border-radius: 16px;
    /* Bordes redondeados modernos */
    border: 1px solid #334155;
    /* Borde sutil */
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.15);
    color: rgb(177, 20, 20);
    margin-bottom: 0;
    /* Controlado por grid */
    height: 100%;
    /* Para que se estiren igual en grid */
}

.card-body {
    padding: 10px;
}

.card-title {
    color: #000000;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
    border-left: 3px solid #073f68;
    /* Acento visual */
    padding-left: 10px;
}

/* --- BARRA DE FILTROS --- */
.filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
    align-items: center;
    margin-bottom: 30px;
}

.filter-item {
    display: flex;
    flex-direction: column;
    min-width: 180px;
}

.filter-item label {
    font-size: 12px;
    font-weight: 600;
    color: #cbd5e1;
    /* Texto claro */
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* --- KPI GRID (CUADROS SUPERIORES) --- */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.kpi-card {
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: transform 0.2s, border-color 0.2s;
}

.kpi-card:hover {
    transform: translateY(-3px);
    border-color: #64748b;
}

.kpi-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    background: rgba(255, 255, 255, 0.05);
    /* Fondo translúcido */
}

/* Efectos de color neón para iconos */
.icon-glow-blue {
    color: #60a5fa;
    text-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
}

.icon-glow-indigo {
    color: #818cf8;
    text-shadow: 0 0 10px rgba(99, 102, 241, 0.3);
}

.icon-glow-orange {
    color: #fb923c;
    text-shadow: 0 0 10px rgba(249, 115, 22, 0.3);
}

.icon-glow-emerald {
    color: #34d399;
    text-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
}

.icon-glow-green {
    color: #4ade80;
    text-shadow: 0 0 10px rgba(34, 197, 94, 0.3);
}

.kpi-content {
    display: flex;
    flex-direction: column;
}

.kpi-label {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
}

.kpi-value {
    font-size: 22px;
    font-weight: 700;
    color: #ffffff;
    margin: 2px 0 0;
}

/* --- RESÚMENES DENTRO DE CARDS --- */
.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    padding-bottom: 8px;
    border-bottom: 1px dashed #334155;
}

.summary-item.total {
    border-top: 1px solid #475569;
    border-bottom: none;
    padding-top: 10px;
    margin-top: 10px;
}

.stat-box {
    background: #ffffff;
    padding: 10px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #334155;
    margin-bottom: 10px;
}

.stat-label {
    display: block;
    font-size: 11px;
    color: #000000;
    margin-bottom: 4px;
}

.doc-stat {
    font-size: 13px;
    margin-bottom: 6px;
    color: #cbd5e1;
    display: flex;
    justify-content: space-between;
}

.doc-stat .val {
    font-weight: 700;
    color: white;
}

/* --- TABLAS OSCURAS --- */
.table-dark-theme {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    color: #cbd5e1;
}

.table-dark-theme thead th {
    background-color: #0f172a;
    /* Header más oscuro */
    color: #ffffff;
    font-weight: 600;
    padding: 10px;
    border-bottom: 2px solid #334155;
    font-size: 13px;
}

.table-dark-theme td {
    padding: 10px;
    border-bottom: 1px solid #ffffff;
    font-size: 13px;
}

.table-dark-theme tr:hover td {
    background-color: #073f68;
    color: white;
}

.text-end {
    text-align: right;
}

.text-center {
    text-align: center;
}

.w-100 {
    width: 100%;
}

.m-t-20 {
    margin-top: 20px;
}

/* --- COLORES DE TEXTO UTILITARIOS --- */
.text-white {
    color: rgb(105, 3, 3) !important;
}

.text-muted {
    color: #062857 !important;
}

.text-small {
    font-size: 11px;
}

.text-info {
    color: #38bdf8 !important;
}

.text-danger {
    color: #f87171 !important;
}

.text-success {
    color: #4ade80 !important;
}

/* --- OVERRIDES PARA ELEMENT UI (FORZAR MODO OSCURO) --- */
/* Esto penetra los estilos de la librería para hacerlos oscuros */
::v-deep .el-input__inner {
    background-color: #0f172a !important;
    /* Fondo input oscuro */
    border: 1px solid #334155 !important;
    color: white !important;
    border-radius: 8px;
}

::v-deep .el-input__inner:hover,
::v-deep .el-input__inner:focus {
    border-color: #3b82f6 !important;
}

::v-deep .el-select .el-input .el-select__caret {
    color: #94a3b8;
}

::v-deep .el-checkbox__label {
    color: #cbd5e1 !important;
}

::v-deep .el-card {
    background-color: #1e293b !important;
    border: none;
    color: white;
}

/* SCROLLBAR PERSONALIZADO */
.dark-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.dark-scrollbar::-webkit-scrollbar-track {
    background: #0f172a;
}

.dark-scrollbar::-webkit-scrollbar-thumb {
    background-color: #334155;
    border-radius: 10px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .kpi-grid {
        grid-template-columns: 1fr;
    }

    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<script>
// Mantengo tu script intacto ya que la lógica no cambia
import DashboardStock from "./partials/dashboard_stock.vue";
import DashboardConparative from "./partials/dashboard_conparative.vue";
import queryString from "query-string";
import DashboarCash from "./partials/dasboard_cash.vue";

export default {
    props: ["typeUser", "soapCompany"],
    components: { DashboardStock, DashboardConparative, DashboarCash },
    data() {
        return {
            loading_search: false,
            records_base: [],
            selected_customer: null,
            customers: [],
            resource: "dashboard",
            establishments: [],
            balance: { totals: {}, graph: {} },
            count_documents: { totals: {}, graph: {} },
            document: { totals: {}, graph: {} },
            sale_note: { totals: {}, graph: {} },
            general: { totals: {}, graph: {} },
            purchase: { totals: {}, graph: {} },
            utilities: { totals: {}, graph: {} },
            disc: [],
            form: {},
            pickerOptionsDates: {
                disabledDate: time => {
                    time = moment(time).format("YYYY-MM-DD");
                    return this.form.date_start > time;
                }
            },
            pickerOptionsMonths: {
                disabledDate: time => {
                    time = moment(time).format("YYYY-MM");
                    return this.form.month_start > time;
                }
            },
            records: [],
            items_by_sales: [],
            top_customers: [],
            recordId: null,
            showDialogDocumentPayments: false,
            showDialogSaleNotePayments: false,
            filter_item: false,
            all_items: [],
            items: [],
            total: 0,
            document_total_global: 0.0,
            total_cpe: 0,
            sale_note_total_global: 0.0
        };
    },
    async created() {
        this.initForm();
        await this.$http.get(`/${this.resource}/filter`).then(response => {
            this.establishments = response.data.establishments;
            this.form.establishment_id =
                this.establishments.length > 0
                    ? this.establishments[0].id
                    : null;
        });
        await this.loadAll();
        await this.filterItems();
        await this.onFetchData();
    },

    methods: {
        handleClick(tab, event) {
            // Maneja el cambio de tabs
            console.log('Tab clicked:', tab.name);
        },
        changeFilterItem() {
            this.form.item_id = null;
            this.loadDataUtilities();
        },
        searchRemoteItems(input) {
            if (input.length > 1) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/reports/data-table/items/?${parameters}`)
                    .then(response => {
                        this.items = response.data.items;
                        this.loading_search = false;

                        if (this.items.length == 0) {
                            this.filterItems();
                        }
                    });
            } else {
                this.filterItems();
            }
        },
        filterItems() {
            this.items = this.all_items;
        },
        calculateTotalCurrency(currency_type_id, exchange_rate_sale, total) {
            if (currency_type_id == "USD") {
                return parseFloat(total) * exchange_rate_sale;
            } else {
                return parseFloat(total);
            }
        },
        clickDownloadDispatch(download) {
            window.open(download, "_blank");
        },
        clickDownload(type) {
            let query = queryString.stringify({
                ...this.form
            });
            window.open(`/reports/no_paid/${type}/?${query}`, "_blank");
        },
        initForm() {
            this.form = {
                item_id: null,
                establishment_id: null,
                enabled_expense: null,
                enabled_move_item: false,
                enabled_transaction_customer: false,
                period: "date",
                date_start: moment().format("YYYY-MM-DD"),
                date_end: moment().format("YYYY-MM-DD"),
                month_start: moment().format("YYYY-MM"),
                month_end: moment().format("YYYY-MM"),
                customer_id: null
            };
        },
        changeDisabledDates() {
            if (this.form.date_end < this.form.date_start) {
                this.form.date_end = this.form.date_start;
            }
            this.loadAll();
        },
        changeDisabledMonths() {
            if (this.form.month_end < this.form.month_start) {
                this.form.month_end = this.form.month_start;
            }
            this.loadAll();
        },
        changePeriod() {
            if (this.form.period === "month") {
                this.form.month_start = moment().format("YYYY-MM");
                this.form.month_end = moment().format("YYYY-MM");
            }
            if (this.form.period === "between_months") {
                this.form.month_start = moment()
                    .startOf("year")
                    .format("YYYY-MM");
                this.form.month_end = moment()
                    .endOf("year")
                    .format("YYYY-MM");
            }
            if (this.form.period === "date") {
                this.form.date_start = moment().format("YYYY-MM-DD");
                this.form.date_end = moment().format("YYYY-MM-DD");
            }
            if (this.form.period === "between_dates") {
                this.form.date_start = moment()
                    .startOf("month")
                    .format("YYYY-MM-DD");
                this.form.date_end = moment()
                    .endOf("month")
                    .format("YYYY-MM-DD");
            }
            this.loadAll();
        },
        loadAll() {
            this.loadData();
            this.loadDataAditional();
            this.loadDataUtilities();
            this.onFetchData();
        },
        onFetchData() {
            this.$http
                .post("/dashboard/global-data", this.form)
                .then(response => {
                    const data = response.data;
                    this.document_total_global = data.document_total_global;
                    this.total_cpe = data.total_cpe;
                    this.sale_note_total_global = data.sale_note_total_global;
                    this.total =
                        parseFloat(this.document_total_global) +
                        parseFloat(this.sale_note_total_global);
                });
        },
        loadData() {
            this.$http
                .post(`/${this.resource}/data`, this.form)
                .then(response => {
                    this.document = response.data.data.document;
                    this.balance = response.data.data.balance;
                    this.sale_note = response.data.data.sale_note;
                    this.count_documents = response.data.data.count_documents;
                    this.general = response.data.data.general;
                    this.customers = response.data.data.customers;
                    this.items = response.data.data.items;
                });
        },
        loadDataAditional() {
            this.$http
                .post(`/${this.resource}/data_aditional`, this.form)
                .then(response => {
                    this.purchase = response.data.data.purchase;
                    this.items_by_sales = response.data.data.items_by_sales;
                    this.top_customers = response.data.data.top_customers;
                });
        },
        loadDataUtilities() {
            this.$http
                .post(`/${this.resource}/utilities`, this.form)
                .then(response => {
                    this.utilities = response.data.data.utilities;
                });
        }
    }
};
</script>