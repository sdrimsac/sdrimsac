<template>
    <el-dialog
        :visible="showDialog"
        :close-on-click-modal="false"
        v-loading="loading"
        @open="open"
        @close="close"
        title="Lista de créditos aaa"
        width="85%"
    >
        <div class="row mt-2">
            <div class="col-md-3">
                <label class="control-label">Periodo (Fecha de emisión)</label>
                <el-select v-model="form.period" @change="changePeriod">
                    <el-option
                        key="month"
                        value="month"
                        label="Por mes"
                    ></el-option>
                    <el-option
                        key="between_months"
                        value="between_months"
                        label="Entre meses"
                    ></el-option>
                    <el-option
                        key="date"
                        value="date"
                        label="Por fecha"
                    ></el-option>
                    <el-option
                        key="between_dates"
                        value="between_dates"
                        label="Entre fechas"
                    ></el-option>
                </el-select>
            </div>
            <template
                v-if="
                    form.period === 'month' || form.period === 'between_months'
                "
            >
                <div class="col-md-2">
                    <label class="w-100 control-label">Mes de</label>
                    <el-date-picker
                        v-model="form.month_start"
                        type="month"
                        class="w-100"
                        @change="changeDisabledMonths"
                        value-format="yyyy-MM"
                        format="MM/yyyy"
                        clearable
                    ></el-date-picker>
                </div>
            </template>
            <template v-if="form.period === 'between_months'">
                <div class="col-md-2">
                    <label class="w-100 control-label">Mes al</label>
                    <el-date-picker
                        class="w-100"
                        v-model="form.month_end"
                        type="month"
                        :picker-options="pickerOptionsMonths"
                        value-format="yyyy-MM"
                        format="MM/yyyy"
                        :clearable="false"
                    ></el-date-picker>
                </div>
            </template>
            <template
                v-if="form.period === 'date' || form.period === 'between_dates'"
            >
                <div class="col-md-2">
                    <label class="w-100 control-label">Fecha del</label>
                    <el-date-picker
                        class="w-100"
                        v-model="form.date_start"
                        type="date"
                        @change="changeDisabledDates"
                        value-format="yyyy-MM-dd"
                        format="dd/MM/yyyy"
                        :clearable="false"
                    ></el-date-picker>
                </div>
            </template>
            <template v-if="form.period === 'between_dates'">
                <div class="col-md-2">
                    <label class="w-100 control-label">Fecha al</label>
                    <el-date-picker
                        class="w-100"
                        v-model="form.date_end"
                        type="date"
                        :picker-options="pickerOptionsDates"
                        value-format="yyyy-MM-dd"
                        format="dd/MM/yyyy"
                        :clearable="false"
                    ></el-date-picker>
                </div>
            </template>

            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label class="w-100 control-label">
                        Clientes
                    </label>

                    <el-select
                        class="w-100"
                        v-model="form.person_id"
                        filterable
                        remote
                        popper-class="el-select-customers"
                        clearable
                        placeholder="Nombre o número de documento"
                        :remote-method="searchRemotePersons"
                        :loading="loading_search"
                    >
                        <el-option
                            v-for="option in persons"
                            :key="option.id"
                            :value="option.id"
                            :label="option.description"
                        ></el-option>
                    </el-select>
                </div>
            </div>
            <div class="col-lg-2 col-md-2">
                <div class="form-group">
                    <label class="w-100 control-label">
                        Estado del pago
                    </label>

                    <el-select
                        class="w-100"
                        v-model="form.paid"
                        clearable
                        placeholder="Estado de crédito"
                        @change="getRecordsByFilter"
                        :loading="loading_search"
                    >
                        <el-option
                            v-for="(option, idx) in [
                                { id: 0, description: 'Pendiente' },
                                { id: 1, description: 'Pagado' }
                            ]"
                            :key="idx"
                            :value="option.id"
                            :label="option.description"
                        ></el-option>
                    </el-select>
                </div>
            </div>
            <div
                class="col-lg-2 col-md-2"
                v-if="configuration.sale_note_credit_confirm"
            >
                <div class="form-group">
                    <label class="w-100 control-label">
                        Estado del documento
                    </label>

                    <el-select
                        class="w-100"
                        v-model="form.status"
                        clearable
                        placeholder="Estado de crédito"
                        @change="getRecordsByFilter"
                        :loading="loading_search"
                    >
                        <el-option
                            v-for="(option, idx) in [
                                { id: 'A', description: 'Aceptado' },
                                { id: 'P', description: 'Pendiente' },
                                { id: 'R', description: 'Rechazado' }
                            ]"
                            :key="idx"
                            :value="option.id"
                            :label="option.description"
                        ></el-option>
                    </el-select>
                </div>
            </div>
            <div
                class="col-lg-2 col-md-2"
                v-if="configuration.sale_note_credit_confirm"
            >
                <div class="form-group">
                    <label class="w-100 control-label">
                        Usuario
                    </label>

                    <el-select
                        class="w-100"
                        v-model="form.user_id"
                        clearable
                        placeholder="Usuario"
                        @change="getRecordsByFilter"
                        :loading="loading_search"
                    >
                        <el-option
                            v-for="(option, idx) in users"
                            :key="idx"
                            :value="option.id"
                            :label="option.name"
                        ></el-option>
                    </el-select>
                </div>
            </div>
            <div
                class="col-lg-2 col-md-2"
                v-if="configuration.sale_note_credit_confirm"
            >
                <div class="form-group">
                    <label class="w-100 control-label">
                        Tipo
                    </label>

                    <el-select
                        class="w-100"
                        v-model="form.type"
                        clearable
                        placeholder="Tipo"
                        @change="getRecordsByFilter"
                        :loading="loading_search"
                    >
                        <el-option
                            v-for="(option, idx) in [
                                { id: 'is_product', name: 'Hogar' },
                                { id: 'is_cash', name: 'Efectivo' }
                            ]"
                            :key="idx"
                            :value="option.id"
                            :label="option.name"
                        ></el-option>
                    </el-select>
                </div>
            </div>
            <div
                class="col-lg-2 col-md-2"
                v-if="configuration.sale_note_credit_confirm"
            >
                <div class="form-group">
                    <label class="w-100 control-label">
                        Tipo cuota
                    </label>

                    <el-select
                        class="w-100"
                        v-model="form.type_payment"
                        clearable
                        placeholder="Tipo cuota"
                        @change="getRecordsByFilter"
                        :loading="loading_search"
                    >
                        <el-option
                            v-for="(option, idx) in [
                                {
                                    id: 'Diario',
                                    name: 'Diario'
                                },
                                {
                                    id: 'Semanal',
                                    name: 'Semanal'
                                },
                                {
                                    id: 'Quincenal',
                                    name: 'Quincenal'
                                },
                                {
                                    id: 'Mensual',
                                    name: 'Mensual'
                                },
                                {
                                    id: 'Unico',
                                    name: 'Unico'
                                }
                            ]"
                            :key="idx"
                            :value="option.id"
                            :label="option.name"
                        ></el-option>
                    </el-select>
                </div>
            </div>
            <div class="d-flex col-12" style="margin-top:29px">
                <el-button
                    class="submit"
                    type="primary"
                    @click.prevent="getRecordsByFilter"
                    :loading="loading_submit"
                    icon="el-icon-search"
                    >Buscar</el-button
                >

                <template
                    v-if="
                        records.length > 0 &&
                            resource !== 'reports/document-detractions'
                    "
                >
                    <el-button
                        class="submit"
                        type="danger"
                        icon="el-icon-tickets"
                        @click.prevent="clickDownload('pdf')"
                        >Exportar PDF</el-button
                    >

                    <el-button
                        class="submit"
                        type="success"
                        @click.prevent="clickDownload('excel')"
                        ><i class="fa fa-file-excel"></i> Exportar
                        Excel</el-button
                    >
                    <el-button class="submit" @click.prevent="clickOpenWhatsapp"
                        ><i class="fa fa-whatsapp"></i> Enviar
                        whatsapp</el-button
                    >
                    <el-button
                        class="submit"
                        v-if="form.paid"
                        type="success"
                        @click.prevent="clickDownload('excel_accept')"
                        ><i class="fa fa-file-excel"></i> Exportar Excel
                        aceptados</el-button
                    >
                </template>
            </div>
        </div>
        <div>
            <div class="container table-responsive">
                <table
                    class="table table-hover table-striped table-condensed  table-responsive"
                    style="width: 100%; white-space: nowrap;"
                >
                    <thead>
                        <tr>
                            <th class="text-right">Acciones</th>

                            <th class="text-center">N/V</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Fecha de emisión</th>
                            <th class="text-center">DNI</th>
                            <th class="text-center">Nombres</th>
                            <th class="text-center">C. Vencidas</th>
                            <th class="text-center">Estado</th>
                            <th class="text-end">Fecha de cobro</th>
                            <th class="text-end">Monto</th>
                            <th
                                v-if="configuration.sale_note_credit_penalty"
                                class="text-end"
                            >
                                Penalidad
                            </th>

                            <th class="text-end">Días de atraso</th>
                            <th
                                v-if="configuration.sale_note_credit_confirm"
                                class="text-end"
                            >
                                Aprobado
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, idx) in records" :key="idx">
                            <td class="text-center">
                                <template
                                    v-if="
                                        row.is_credit &&
                                            configuration.sale_note_credit_confirm
                                    "
                                >
                                    <el-dropdown
                                        v-if="
                                            !user.can_accept_credit_sale_note &&
                                            !isAnalist
                                                ? row.status == 'A'
                                                : true
                                        "
                                        size="medium"
                                        split-button
                                        type="primary"
                                        trigger="click"
                                    >
                                        Acciones
                                        <el-dropdown-menu slot="dropdown">
                                            <template
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        configuration.sale_note_credit_confirm &&
                                                        user.can_accept_credit_sale_note &&
                                                        row.status == 'P'
                                                "
                                            >
                                                <el-dropdown-item>
                                                    <span
                                                        role="button"
                                                        style="width:100%;display:block;"
                                                        class="text-success"
                                                        @click.prevent="
                                                            clickSetStatus(
                                                                row.id,
                                                                'A'
                                                            )
                                                        "
                                                    >
                                                        Aceptar créditos
                                                    </span>
                                                </el-dropdown-item>
                                                <el-dropdown-item>
                                                    <span
                                                        role="button"
                                                        style="width:100%;display:block;"
                                                        class="text-danger"
                                                        @click.prevent="
                                                            clickSetStatus(
                                                                row.id,
                                                                'R'
                                                            )
                                                        "
                                                    >
                                                        Rechazar crédito
                                                    </span>
                                                </el-dropdown-item>
                                            </template>
                                            <template>
                                                <el-dropdown-item
                                                    v-if="
                                                        !row.canceled &&
                                                            row.state_type_id !=
                                                                '11' &&
                                                            (configuration.sale_note_credit_confirm
                                                                ? row.status ==
                                                                  'A'
                                                                : true)
                                                    "
                                                >
                                                    <span
                                                        role="button"
                                                        style="width:100%;display:block;"
                                                        @click.prevent="
                                                            clickPayment(row.id)
                                                        "
                                                    >
                                                        Registrar pagos
                                                    </span>
                                                </el-dropdown-item>
                                                <el-dropdown-item>
                                                    <span
                                                        role="button"
                                                        style="width:100%;display:block;"
                                                        @click.prevent="
                                                            clickContract(
                                                                row.id
                                                            )
                                                        "
                                                    >
                                                        Imprimir contrato
                                                    </span>
                                                </el-dropdown-item>
                                                <template
                                                    v-if="row.status != 'R'"
                                                >
                                                    <el-dropdown-item
                                                        v-for="(schedule,
                                                        idx) in row.schedules"
                                                        :key="idx"
                                                    >
                                                        <a
                                                            role="button"
                                                            style="width:100%;display:block;"
                                                            target="_blank"
                                                            :href="schedule"
                                                        >
                                                            <template
                                                                v-if="
                                                                    row
                                                                        .schedules
                                                                        .length >
                                                                        1
                                                                "
                                                            >
                                                                Cronograma de
                                                                pagos N°
                                                                {{ idx + 1 }}
                                                            </template>
                                                            <template v-else>
                                                                Cronograma de
                                                                pagos
                                                            </template>
                                                        </a>
                                                    </el-dropdown-item>
                                                </template>
                                            </template>
                                            <!-- <el-dropdown-item
                                            v-if="
                                                
                                                    row.state_type_id != '11' 
                                            "
                                        >
                                            <span
                                                role="button"
                                                class="text-primary"
                                                @click.prevent="
                                                    clickInitPayment(row.id)
                                                "
                                            >
                                                Registrar pagos anteriores
                                            </span>
                                        </el-dropdown-item> -->
                                            <el-dropdown-item
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        row.status != 'O' &&
                                                        row.can_edit && 
                                                        (user.can_accept_credit_sale_note
                                                            ? true
                                                            : isAnalist
                                                            ? row.status == 'P'
                                                            : false)
                                                "
                                            >
                                                <span
                                                    style="width:100%;display:block;"
                                                    role="button"
                                                    @click.prevent="
                                                        clickEditSaleNote(
                                                            row.id
                                                        )
                                                    "
                                                >
                                                    Editar
                                                </span>
                                            </el-dropdown-item>
                                                <el-dropdown-item
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        row.can_edit &&
                                                        user.can_accept_credit_sale_note && row.status != 'O'
                                                "
                                            >
                                                <span
                                                    style="width:100%;display:block;"
                                                    role="button"
                                                    @click.prevent="
                                                        pauseCredit(row)
                                                    "
                                                >
                                                    Terminar
                                                </span>
                                            </el-dropdown-item>
                                            <el-dropdown-item
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        row.can_edit &&
                                                        user.can_accept_credit_sale_note
                                                "
                                            >
                                                <span
                                                    style="width:100%;display:block;"
                                                    role="button"
                                                    @click.prevent="
                                                        anulateCredit(row)
                                                    "
                                                >
                                                    Anular
                                                </span>
                                            </el-dropdown-item>
                                        </el-dropdown-menu>
                                    </el-dropdown>
                                </template>
                                <template
                                    v-if="
                                        row.is_credit &&
                                            !configuration.sale_note_credit_confirm
                                    "
                                >
                                    <el-dropdown
                                        size="medium"
                                        split-button
                                        type="primary"
                                    >
                                        Acciones
                                        <el-dropdown-menu slot="dropdown">
                                            <template>
                                                <el-dropdown-item
                                                    v-if="
                                                        !row.canceled &&
                                                            row.state_type_id !=
                                                                '11'
                                                    "
                                                >
                                                    <span
                                                        role="button"
                                                        style="width:100%;display:block;"
                                                        @click.prevent="
                                                            clickPayment(row.id)
                                                        "
                                                    >
                                                        Registrar pagos
                                                    </span>
                                                </el-dropdown-item>
                                                <el-dropdown-item>
                                                    <span
                                                        role="button"
                                                        style="width:100%;display:block;"
                                                        @click.prevent="
                                                            clickContract(
                                                                row.id
                                                            )
                                                        "
                                                    >
                                                        Imprimir contrato
                                                    </span>
                                                </el-dropdown-item>
                                                <el-dropdown-item>
                                                    <span
                                                        role="button"
                                                        style="width:100%;display:block;"
                                                        @click.prevent="
                                                            clickSchedule(
                                                                row.id
                                                            )
                                                        "
                                                    >
                                                        Cronograma de pagos
                                                    </span>
                                                </el-dropdown-item>
                                            </template>

                                            <el-dropdown-item
                                                
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        row.status != 'O' &&
                                                        row.can_edit && 
                                                        (user.can_accept_credit_sale_note
                                                            ? true
                                                            : isAnalist
                                                            ? row.status == 'P'
                                                            : false)
                                                "
                                            >
                                                <span
                                                    style="width:100%;display:block;"
                                                    role="button"
                                                    @click.prevent="
                                                        clickEditSaleNote(
                                                            row.id
                                                        )
                                                    "
                                                >
                                                    Editar
                                                </span>
                                            </el-dropdown-item>
                                        </el-dropdown-menu>
                                    </el-dropdown></template
                                >
                            </td>
                            <td class="text-center">{{ row.number }}</td>
                            <td class="text-center">{{ row.user_name }}</td>
                            <td class="text-center">{{ row.date_of_issue }}</td>
                            <td class="text-center">
                                {{ row.customer.number }}
                            </td>
                            <td class="text-center">{{ row.customer.name }}</td>
                            <td class="text-center">{{ row.dues }}</td>
                            <td
                                class="text-center"
                                :class="
                                    `${
                                        row.canceled
                                            ? 'text-success'
                                            : 'text-danger'
                                    }`
                                "
                            >
                                <template v-if="row.state_type_id != '11'">
                                    {{ row.canceled ? "PAGADO" : "PENDIENTE" }}
                                </template>
                                <template v-else>
                                    ANULADO
                                </template>
                            </td>
                            <td class="text-end">{{ row.date_of_due }}</td>
                            <td class="text-end">{{ row.amount_due }}</td>
                            <td
                                v-if="configuration.sale_note_credit_penalty"
                                class="text-end"
                            >
                                {{ row.penalty }}
                            </td>
                            <td class="text-end">{{ row.differenc_days }}</td>
                            <td
                                v-if="configuration.sale_note_credit_confirm"
                                class="text-end"
                                :class="
                                    `${
                                        row.status == 'P'
                                            ? 'text-warning'
                                            : row.status == 'A'
                                            ? 'text-success'
                                            : 'text-danger'
                                    }`
                                "
                            >
                                <strong>
                                    {{
                                        row.status == "P"
                                            ? "POR APROBAR"
                                            : row.status == "A"
                                            ? "ACEPTADO"
                                            : row.status == "O"
                                            ? "TERMINADO"
                                            : row.state_type_id == "11"
                                            ? "ANULADO"
                                            : "RECHAZADO"
                                    }}
                                    <el-tooltip
                                        v-if="
                                            (row.status == 'R' ||
                                                row.state_type_id == '11') &&
                                                row.observation
                                        "
                                        :content="row.observation"
                                        placement="top"
                                    >
                                        <i
                                            class="el-icon-info"
                                            style="color:red"
                                        ></i>
                                    </el-tooltip>
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <el-dialog
                    :visible.sync="showObservationsDialog"
                    title="Rechazo de crédito"
                    @open="openObservationsDialog"
                    append-to-body
                >
                    <div class="row m-2">
                        <div class="col-md-12">
                            <el-input
                                type="textarea"
                                v-model="observations"
                                placeholder="Motivo de rechazo"
                            ></el-input>
                        </div>
                    </div>

                    <span slot="footer" class="dialog-footer">
                        <el-button @click="showObservationsDialog = false"
                            >Cancelar</el-button
                        >
                        <el-button
                            type="primary"
                            @click="changeStatus(recordId, 'R')"
                            >Aceptar</el-button
                        >
                    </span>
                </el-dialog>
            </div>
        </div>

        <el-dialog
            :visible.sync="showAnulateDialog"
            :title="titleVoided"
            append-to-body
            :close-on-click-modal="false"
        >
            <div class="row m-2">
                <div class="col-md-12">
                    <el-input
                        type="textarea"
                        v-model="anulateReason"
                        placeholder="Motivo de anulación"
                    ></el-input>
                </div>
            </div>

            <span slot="footer" class="dialog-footer">
                <el-button @click="showAnulateDialog = false"
                    >Cancelar</el-button
                >
                <el-button
                    type="primary"
                    @click="
                        isPauseSaleNote ? clickPauseSaleNote() : clickVoidSaleNote()
                    "
                    >{{isPauseSaleNote ? 'Terminar' : 'Anular'}}</el-button
                >
            </span>
        </el-dialog>

        <div>
            <el-pagination
                @current-change="getRecords"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="pagination.per_page"
            >
            </el-pagination>
        </div>
        <whatsapp-form-report
            :message.sync="messageReport"
            :resource="resourceReport"
            :showWhatsappForm.sync="showWhatsappForm"
        >
        </whatsapp-form-report>
        <sale-note-payments
            :configuration="configuration"
            :showDialog.sync="showDialogPayments"
            :documentId="recordId"
        ></sale-note-payments>

        <sale-note-generate
            :showDialog.sync="showDialogGenerate"
            :recordId="recordId"
            :showGenerate="true"
            :showClose="false"
        ></sale-note-generate>
        <sale-note-detail
            :number="currentNumber"
            :saleNoteId="recordId"
            :showDialog.sync="showDialogDetail"
            :boxes="boxes"
        >
        </sale-note-detail>
        <credit-modal-update
            :configuration="configuration"
            :showDialog.sync="showDialogUpdate"
            :recordId="recordId"
        >
        </credit-modal-update>
        <credits-init-payment
            :showDialog.sync="showDialogInitPayments"
            :recordId="recordId"
        ></credits-init-payment>
    </el-dialog>
</template>

<script>
import SaleNotePayments from "../../../../../../../../resources/js/views/sale_notes/partials/payments.vue";
import SaleNoteGenerate from "../../../../../../../../resources/js/views/sale_notes/partials/option_documents";
import SaleNoteDetail from "../../../../../../../../resources/js/views/sale_notes/partials/detail.vue";
import queryString from "query-string";
import WhatsappFormReport from "../../../../../../../../resources/js/components/WhatsappModalReports.vue";
import CreditModalUpdate from "./credit_modal_update.vue";
import CreditsInitPayment from "./credits_init_payment.vue";
export default {
    components: {
        CreditsInitPayment,
        CreditModalUpdate,
        WhatsappFormReport,
        SaleNotePayments,
        SaleNoteGenerate,
        SaleNoteDetail
    },
    props: ["showDialog", "configuration", "isAnalist", "user"],
    data() {
        return {
            users: [],
            titleVoided: "",
            showObservationsDialog: false,
            observations: "",
            showDialogUpdate: false,
            loading_submit: false,
            showWhatsappForm: false,
            messageReport: "",
            resourceReport: "",
            loading_search: false,
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
            resource: "reports/credits",
            loading: false,
            pagination: {},
            anulateReason: "",
            showAnulateDialog: false,
            records: [],
            form: {},
            persons: [],
            saleNotesNewId: null,
            showDialogOptions: false,
            recordId: null,
            currentNumber: null,
            boxes: [],
            showDialogDetail: false,
            showDialogGenerate: false,
            showDialogPayments: false,
            showDialogInitPayments: false,
            isPauseSaleNote: false
        };
    },
    created() {
        this.initForm();
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
        this.getTables();
    },
    methods: {
        pauseCredit(record) {
            this.recordId = record.id;
            this.titleVoided = "Término de crédito-" + record.number;
            this.showAnulateDialog = true;
            this.isPauseSaleNote = true;
        },
        anulateCredit(record) {
            this.recordId = record.id;
            this.titleVoided = "Anulación de crédito-" + record.number;
            this.showAnulateDialog = true;
            this.isPauseSaleNote = false;
        },
        async getTables() {
            const response = await this.$http.get(`/${this.resource}/filter`);
            if (response.data) {
                this.users = response.data.users;
                console.log("🚀 ~ getTables ~ this.users:", this.users);
            }
        },
        clickInitPayment(id) {
            this.recordId = id;
            this.showDialogInitPayments = true;
        },
        openObservationsDialog() {
            this.observations = "";
        },
        async changeStatus(id, status) {
            const response = await this.$http.post(
                "/sale-notes/set-status-credit",
                {
                    id,
                    status,
                    observations: this.observations
                }
            );
            console.log("🚀 ~ changeStatus ~ response:", response);
            this.showObservationsDialog = false;
            this.getRecords();
        },
        async clickSetStatus(id, status) {
            this.recordId = id;
            let statusDescription = status == "A" ? "aceptar" : "rechazar";
            try {
                await this.$confirm(
                    `¿Está seguro de ${statusDescription} el crédito?`,
                    "Atención",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                if (status == "R") {
                    this.showObservationsDialog = true;
                } else {
                    await this.changeStatus(id, status);
                }
            } catch (e) {}
        },

        clickPauseSaleNote() {
            if (this.anulateReason == "") {
                this.$toast.error("Debe introducir una razón para anulación");
                return;
            }
            this.loading = true;
            this.$http
                .post(`/sale-notes/pause-credit`, {
                    sale_note_id: this.recordId,
                    reason_to_void: this.anulateReason
                })
                .then(response => {
                    this.getRecords();
                    this.$toast.success(response.data.message);
                    this.showAnulateDialog = false;
                    this.anulateReason = "";
                    this.recordId = null;
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        clickVoidSaleNote() {
            if (this.anulateReason == "") {
                this.$toast.error("Debe introducir una razón para anulación");
                return;
            }
            this.loading = true;
            this.$http
                .post(`/sale-notes/void-credit`, {
                    sale_note_id: this.recordId,
                    reason_to_void: this.anulateReason
                })
                .then(response => {
                    this.getRecords();
                    this.$toast.success(response.data.message);
                    this.showAnulateDialog = false;
                    this.anulateReason = "";
                    this.recordId = null;
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        clickEditSaleNote(id) {
            this.recordId = id;
            this.showDialogUpdate = true;
        },
        clickDetail(record) {
            this.recordId = record.id;
            this.currentNumber = record.full_number;
            this.boxes = record.boxes;
            this.showDialogDetail = true;
        },
        clickGenerate(recordId) {
            this.recordId = recordId;
            this.showDialogGenerate = true;
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickSchedule(recordId) {
            window.open(`/sale-notes/schedule/${recordId}`, "_blank");
        },
        clickContract(recordId) {
            if (this.configuration.sale_note_credit_confirm) {
                window.open(`/sale-notes/contrato/${recordId}`, "_blank");
            } else {
                window.open(`/sale-notes/contract/${recordId}`, "_blank");
            }
        },
        clickCreate(id = "") {
            location.href = `/${this.resource}/create/${id}`;
        },
        initForm() {
            this.form = {
                user_id: null,
                status: null,
                paid: 0,
                establishment_id: null,
                person_id: null,
                type_person: null,
                document_type_id: null,
                period: "month",
                date_start: moment().format("YYYY-MM-DD"),
                date_end: moment().format("YYYY-MM-DD"),
                month_start: moment().format("YYYY-MM"),
                month_end: moment().format("YYYY-MM"),
                seller_id: null,
                state_type_id: null,
                typeresult: "Detallado"
            };
        },
        changePeriod() {
            if (this.form.period === "month") {
                this.form.month_start = moment().format("YYYY-MM");
                this.form.month_end = moment().format("YYYY-MM");
            }
            if (this.form.period === "between_months") {
                this.form.month_start = moment()
                    .startOf("year")
                    .format("YYYY-MM"); //'2019-01';
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
            // this.loadAll();
        },
        clickOpenWhatsapp() {
            let query = queryString.stringify({
                ...this.form
            });
            this.resourceReport = `/${this.resource}/pdf?${query}`;
            this.messageReport = `Reporte de creditos a la fecha ${moment().format(
                "DD-MM-YYYY"
            )}`;
            this.showWhatsappForm = true;
        },
        clickDownload(type) {
            let query = queryString.stringify({
                ...this.form
            });
            console.log("🚀 ~ clickDownload ~ query:", query);
            window.open(`/${this.resource}/${type}/?${query}`, "_blank");
        },
        searchRemotePersons(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.form.type_person = "customers";

                this.$http
                    .get(
                        `/reports/data-table/persons/${this.form.type_person}?${parameters}`
                    )
                    .then(response => {
                        this.persons = response.data.persons;
                        this.loading_search = false;

                        if (this.persons.length == 0) {
                            this.filterPersons();
                        }
                    });
            } else {
                this.filterPersons();
            }
        },
        async getRecordsByFilter() {
            this.loading_submit = await true;
            await this.getRecords();
            this.loading_submit = await false;
        },
        filterPersons() {
            this.persons = this.all_persons;
        },
        searchRemotePersons(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.form.type_person = "customers";

                this.$http
                    .get(
                        `/reports/data-table/persons/${this.form.type_person}?${parameters}`
                    )
                    .then(response => {
                        this.persons = response.data.persons;
                        this.loading_search = false;

                        if (this.persons.length == 0) {
                            this.filterPersons();
                        }
                    });
            } else {
                this.filterPersons();
            }
        },
        changeDisabledMonths() {
            if (this.form.month_end < this.form.month_start) {
                this.form.month_end = this.form.month_start;
            }
            // this.loadAll();
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        open() {
            this.initForm();
            this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        getRecords() {
            this.loading = true;
            this.$http
                .get(`/${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    this.records = response.data.data;
                    //sort records by dues property (int) in descending order
                    // this.records.sort(function(a, b) {
                    //     return b.dues - a.dues;
                    // });

                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                    this.loading = false;
                });
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.form
            });
        }
    }
};
</script>
