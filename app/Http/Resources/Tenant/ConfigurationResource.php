<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'ordens_cash'              => (bool) $this->ordens_cash,
            'discount_with_base_variant' => (bool) $this->discount_with_base_variant,
            'translate_direct'         => (bool) $this->translate_direct,
            'item_consignment_id'      => $this->item_consignment_id,
            'id'                        => $this->id,
            'socket_channel'            => $this->socket_channel,
            'send_auto'                 => (bool) $this->send_auto,
            'formats'                   => $this->formats,
            'stock'                     => (bool) $this->stock,
            'cron'                      => (bool) $this->cron,
            'credits'                   => (bool) $this->credits,
            'show_contract'             => $this->show_contract,
            'sunat_alternate_server'    => (bool) $this->sunat_alternate_server,
            'compact_sidebar'           => (bool) $this->compact_sidebar,
            'recreat_document'          => (bool) $this->recreat_document,
            'delete_document'           => (bool) $this->delete_document,
            'subtotal_account'          => $this->subtotal_account,
            'decimal_quantity'          => $this->decimal_quantity,
            'amount_plastic_bag_taxes'  => $this->amount_plastic_bag_taxes,
            'colums_grid_item'          => $this->colums_grid_item,
            'options_pos'               => (bool) $this->options_pos,
            'edit_name_product'         => (bool) $this->edit_name_product,
            'restrict_receipt_date'     => (bool) $this->restrict_receipt_date,
            'affectation_igv_type_id'   => $this->affectation_igv_type_id,
            'visual'                    => $this->visual,
            'enable_whatsapp'           => (bool) $this->enable_whatsapp,
            'visual'                    => $this->visual,
            'terms_condition'           => $this->terms_condition,
            'cotizaction_finance'       => (bool) $this->cotizaction_finance,
            'include_igv'               => (bool) $this->include_igv,
            'product_only_location'     => (bool) $this->product_only_location,
            'show_restriction'          => (bool) $this->show_restriction,
            'print_direct'              => (bool) $this->print_direct,
            'socket_channel'            => $this->socket_channel,
            'refresh_price_sales'       => (bool) $this->refresh_price_sales,
            'search_type'               => (string) $this->search_type,
            'edit_price_sales'          => (bool)$this->edit_price_sales,
            'copies'                    => $this->copies,
            'multiple_boxes'            => (bool) $this->multiple_boxes,
            'sales_stock'               => (bool) $this->sales_stock,
            'print_commands'            => (bool) $this->print_commands,
            'commands_fisico'           => (bool) $this->commands_fisico,
            'sales_quick'               => (bool) $this->sales_quick,
            'restaurant'                => (bool) $this->restaurant,
            'print_kitchen'             => (bool) $this->print_kitchen,
            'quantity_cash'             => (bool) $this->quantity_cash,
            'pin_switch'             => (bool) $this->pin_switch,
            'box_orden'             => (bool) $this->box_orden,
            'edit_subtotal_box'             => (bool) $this->edit_subtotal_box,
            'xml_whatsapp'             => (bool) $this->xml_whatsapp,
            'show_unit_types_ticket'      => (bool) $this->show_unit_types_ticket,
            'show_variation_dcto'  => (bool) $this->show_variation_dcto,
            'item_variation_id'  => $this->item_variation_id,
            'change_date_emit'  => (bool) $this->change_date_emit,
            'personal_phone'  => (bool) $this->personal_phone,
            'new_old_printer'  => (bool) $this->new_old_printer,
            'days_before_emit'  => $this->days_before_emit,
            'show_stock_establishment_box'  => $this->show_stock_establishment_box,
            'college' => (bool) $this->college,
            'internet' => (bool) $this->internet,
            'receive_merchandise' => (bool) $this->receive_merchandise,
            'reference_ticket' => (bool) $this->reference_ticket,
            'toll' => (bool) $this->toll,
            'promotions_sell' => (bool) $this->promotions_sell,
            'promotions_cant_purchase' => $this->promotions_cant_purchase,
            "dispatch" => (bool) $this->dispatch,
            "quotation" => (bool) $this->quotation,
            'credit_mode' => (bool) $this->credit_mode,
            'rates' => (float) $this->rates,
            'send_whatsapp_activity' => (bool) $this->send_whatsapp_activity,
            'pin_orden_delete' => (bool) $this->pin_orden_delete,
            'number_activity' => $this->number_activity,
            'print_incomes_expenses' => (bool) $this->print_incomes_expenses,
            'pos_drag_category' => (bool) $this->pos_drag_category,
            'edit_product_pos' => (bool) $this->edit_product_pos,
            'view_daily_cash' => (bool)  $this->view_daily_cash,
            'view_daily_cash_pin' => (bool) $this->view_daily_cash_pin,
            'send_whatsapp_daily_cash' => (bool) $this->send_whatsapp_daily_cash,
            'init_stock' => (bool) $this->init_stock,
            'observation_translate' => (bool) $this->observation_translate,
            'consignment' => (bool) $this->consignment,
            'afectation_optional' => (bool) $this->affectation_optional,
            'affectation_optional_id' => $this->affectation_optional_id,

        ];
    }
}
