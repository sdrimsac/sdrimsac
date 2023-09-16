<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Catalogs\CurrencyType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Configuration extends ModelTenant
{
    protected $fillable = [
        'purchase_affectation_igv_type_id',
        'text_comanda',
        'text_one',
        'text_two',
        'seller_caja',
        'item_adjustment',
        'show_image_a5',
        'a5_orientation',
        'users_views',
        'trunc_txt',
        'ord_dscp',
        'items_due_caja',
        'item_set_caja',
        'ordens_cash',
        'discount_with_base_variant',
        'translate_direct',
        'item_consignment_id',
        'affectation_optional',
        'affectation_optional_id',
        'consignment',
        'view_daily_cash',
        'view_daily_cash_pin',
        'send_whatsapp_daily_cash',
        'print_incomes_expenses',
        'edit_product_pos',
        'toll',
        'send_auto',
        'formats',
        'cron',
        'stock',
        'locked_emission',
        'locked_users',
        'limit_documents',
        'sunat_alternate_server',
        'show_contract',
        'plan',
        'visual',
        'enable_whatsapp',
        'phone_whatsapp',
        'limit_users',
        'quantity_documents',
        'date_time_start',
        'locked_tenant',
        'compact_sidebar',
        'decimal_quantity',
        'amount_plastic_bag_taxes',
        'colums_grid_item',
        'options_pos',
        'edit_name_product',
        'restrict_receipt_date',
        'affectation_igv_type_id',
        'terms_condition',
        'cotizaction_finance',
        'include_igv',
        'product_only_location',
        'recreat_document',
        'delete_document',
        'show_restriction',
        'print_direct',
        'show_quotations',
        'rates',
        'smtp_host',
        'smtp_port',
        'smtp_user',
        'smtp_password',
        'smtp_encryption',
        'credits',
        'socket_channel',
        'refresh_price_sales',
        'search_type',
        'edit_price_sales',
        'multiple_boxes',
        'sales_stock',
        'print_commands',
        'commands_fisico',
        'sales_quick',
        'direct_printing',
        'restaurant',
        'print_kitchen',
        'quantity_cash',
        'pin_switch',
        'box_orden',
        'edit_subtotal_box',
        'xml_whatsapp',
        'show_unit_types_ticket',
        'show_variation_dcto',
        'item_variation_id',
        'show_stock_establishment_box',
        'change_date_emit',
        'days_before_emit',
        'personal_phone',
        'new_old_printer',
        'college',
        'internet',
        'receive_merchandise',
        'reference_ticket',
        'promotions_sell',
        'promotions_cant_purchase',
        "dispatch",
        "quotation",
        'credit_mode',
        "send_whatsapp_activity",
        "pin_orden_delete",
        "number_activity",
        'pos_drag_category',
        'init_stock',
        'observation_translate',

    ];
    protected $casts = [
        'text_comanda' => 'boolean',
        'seller_caja' => 'boolean',
        'item_adjustment' => 'boolean',
        'show_image_a5' => 'boolean',
        'a5_orientation' => 'boolean',
        'users_views' => 'boolean',
        'trunc_txt' => 'boolean',
        'ord_dscp' => 'boolean',
        'items_due_caja' => 'boolean',
        'item_set_caja' => 'boolean',
        'ordens_cash' => 'boolean',
        'discount_with_base_variant' => 'boolean',
        'consignment' => 'boolean',
        'commands_fisico' => 'boolean',
        'print_commands'  => 'boolean',
        'restaurant'      => 'boolean',
        'print_kitchen'   => 'boolean',
        'show_restriction' => 'boolean',
        'sales_stock'     => 'boolean',
        'change_date_emit' => 'boolean',
        'receive_merchandise' => 'boolean',
        'reference_ticket' => 'boolean',
        'toll' => 'boolean',
        'promotions_sell'   => 'boolean',
        'credits' => 'boolean',
        'credit_mode' => 'boolean',
        'pos_drag_category' => 'boolean',
        // 'college' => 'boolean',
        'send_whatsapp_activity' => 'boolean',
        'pin_orden_delete' => 'boolean',
        'edit_product_pos' => 'boolean',
        'quotation' => 'boolean',

        'print_incomes_expenses' => 'boolean',
    ];
    public function scopeGetUnitPriceDispatchRelatedRecord($query)
    {
        return $query->select('set_unit_price_dispatch_related_record')->first()->set_unit_price_dispatch_related_record;
    }
    public static function getPublicConfig()
    {
        $conf = self::first();
        $data = $conf->getCollectionData();

        return json_encode($data);
    }
    public function getUpdateDocumentOnDispaches()
    {
        return $this->update_document_on_dispaches;
    }
    public function getCollectionData()
    {
        $company = Company::first();
        /** @var User $user */
        $user = new User();
        $productionApp = false;
        if (Auth::user()) {
            $user = auth()->user();
            $productionApp = !empty($user->modules->where('value', 'production_app')->first());
            // se busca el permiso para produccion app

        }

        $establishment = $user->establishment;
        $establishment_id = $user->establishment_id;
        $serie = $user->series_id;
        $document_id = $user->document_id;
        $typeUser = $user->type;
        $unit_type_id = 'KGM'; //Unidad de medida por defecto
        $warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
        if ($warehouse == null) {
            $warehouse = new Warehouse();
        }
        $currency = CurrencyType::all();
        // $skins = Skin::all();
        $skins = [];
        return [
            'purchase_affectation_igv_type_id' => $this->purchase_affectation_igv_type_id,
            'text_comanda' => (bool) $this->text_comanda,
            'text_one' => $this->text_one,
            'text_two' => $this->text_two,
            'seller_caja' => (bool)$this->seller_caja,
            'item_adjustment' => (bool)$this->item_adjustment,
            'show_image_a5' => (bool)$this->show_image_a5,
            'a5_orientation' => (bool)$this->a5_orientation,
            'users_views' => (bool)$this->users_views,
            'trunc_txt' => (bool)$this->trunc_txt,
            'ord_dscp' => (bool)$this->ord_dscp,
            'items_due_caja' => (bool)$this->items_due_caja,
            'item_set_caja' => (bool)$this->item_set_caja,
            'ordens_cash' => (bool)$this->ordens_cash,
            'discount_with_base_variant' => (bool)$this->discount_with_base_variant,
            'translate_direct' => (bool)$this->translate_direct,
            'item_consignment_id' => $this->item_consignment_id,
            'id' => $this->id,
            'company' => $company,
            'establishment' => $establishment,
            'production_app' => $productionApp,
            'warehouse_id' => $warehouse->id,
            'send_auto' => (bool)$this->send_auto,
            'formats' => $this->formats,
            'stock' => (bool)$this->stock,
            'cron' => (bool)$this->cron,
            'sunat_alternate_server' => (bool)$this->sunat_alternate_server,
            'compact_sidebar' => (bool)$this->compact_sidebar,
            'subtotal_account' => $this->subtotal_account,
            'decimal_quantity' => $this->decimal_quantity,
            'amount_plastic_bag_taxes' => $this->amount_plastic_bag_taxes,
            'colums_grid_item' => $this->colums_grid_item,
            'options_pos' => (bool)$this->options_pos,
            'edit_name_product' => (bool)$this->edit_name_product,
            'restrict_receipt_date' => (bool)$this->restrict_receipt_date,
            'affectation_igv_type_id' => $this->affectation_igv_type_id,
            'visual' => $this->visual,
            'enable_whatsapp' => (bool)$this->enable_whatsapp,
            'phone_whatsapp' => $this->enable_whatsapp,
            'apk_url' => $this->apk_url,
            'terms_condition' => $this->terms_condition,
            'terms_condition_sale' => $this->terms_condition_sale,
            'cotizaction_finance' => (bool)$this->cotizaction_finance,
            'include_igv' => (bool)$this->include_igv,
            'product_only_location' => (bool)$this->product_only_location,
            'legend_footer' => (bool)$this->legend_footer,
            'default_document_type_03' => (bool)$this->default_document_type_03,
            'header_image' => $this->header_image,
            'destination_sale' => (bool)$this->destination_sale,
            'quotation_allow_seller_generate_sale' => $this->quotation_allow_seller_generate_sale,
            'allow_edit_unit_price_to_seller' => $this->allow_edit_unit_price_to_seller,
            'finances' => $this->finances,
            'ticket_58' => (bool)$this->ticket_58,
            'seller_can_create_product' => (bool)$this->seller_can_create_product,
            'seller_can_view_balance' => (bool)$this->seller_can_view_balance,
            'seller_can_generate_sale_opportunities' => (bool)$this->seller_can_generate_sale_opportunities,
            'update_document_on_dispaches' => (bool)$this->update_document_on_dispaches,
            'is_pharmacy' => (bool)$this->is_pharmacy,
            'auto_send_dispatchs_to_sunat' => (bool)$this->auto_send_dispatchs_to_sunat,
            'send_data_to_other_server' => (bool)$this->send_data_to_other_server,
            'item_per_page' => config('tenant.items_per_page'),
            'active_warehouse_prices' => (bool)$this->active_warehouse_prices,
            'active_allowance_charge' => (bool)$this->active_allowance_charge,
            'dispatches_address_text' => $this->isDispatchesAddressText(),
            'show_items_only_user_stablishment' => $this->isShowItemsOnlyUserStablishment(),
            'search_item_by_series' => (bool)$this->search_item_by_series,
            'change_free_affectation_igv' => (bool)$this->change_free_affectation_igv,
            'select_available_price_list' => (bool)$this->select_available_price_list,
            'show_extra_info_to_item' => $this->isShowExtraInfoToItem(),
            'percentage_allowance_charge' => $this->percentage_allowance_charge,
            'group_items_generate_document' => $this->group_items_generate_document,
            'set_address_by_establishment' => $this->set_address_by_establishment,
            'permission_to_edit_cpe' => $this->permission_to_edit_cpe,
            'name_product_pdf_to_xml' => $this->name_product_pdf_to_xml,
            'default_document_type_80' => $this->default_document_type_80,
            'search_item_by_barcode' => $this->search_item_by_barcode,
            'igv_retention_percentage' => $this->igv_retention_percentage,
            'currency_type_id' => $this->getCurrencyTypeId(),
            'currency_types' => $currency,
            'affectation_igv_types_exonerated_unaffected' => Item::AffectationIgvTypesExoneratedUnaffected(),
            'typeUser' => $typeUser,
            'unit_type_id' => $unit_type_id,
            'enabled_global_igv_to_purchase' => $this->isEnabledGlobalIgvToPurchase(),
            'show_pdf_name' => $this->isShowPdfName(),
            'item_name_pdf_description' => $this->isItemNamePdfDescription(),
            'api_service_token' => $this->getApiServiceToken(),
            'user' => [
                'serie' => $serie,
                'document_id' => $document_id,
                'type' => $typeUser,
            ],
            'auto_print' => (bool)$this->auto_print,
            'show_service_on_pos' => (bool)$this->show_service_on_pos,
            'pos_history' => $this->isPosHistory(),
            'pos_cost_price' => $this->isPosCostPrice(),
            'show_totals_on_cpe_list' => $this->isShowTotalsOnCpeList(),
            'detraction_amount_rounded_int' => $this->detraction_amount_rounded_int,
            'customer_filter_by_seller' => $this->customer_filter_by_seller,
            'validate_purchase_sale_unit_price' => $this->validate_purchase_sale_unit_price,
            'global_discount_type_id' => $this->global_discount_type_id,
            'show_terms_condition_pos' => (bool)$this->show_terms_condition_pos,
            'mi_tienda_pe' => false,
            'show_ticket_80' => (bool)$this->show_ticket_80,
            'show_ticket_58' => (bool)$this->show_ticket_58,
            'show_ticket_50' => (bool)$this->show_ticket_50,
            'show_last_price_sale' => (bool)$this->show_last_price_sale,
            'show_logo_by_establishment' => (bool)$this->show_logo_by_establishment,
            'shipping_time_days' => $this->shipping_time_days,
            'checked_global_igv_to_purchase' => $this->checked_global_igv_to_purchase,
            'checked_update_purchase_price' => $this->checked_update_purchase_price,
            'set_global_purchase_currency_items' => $this->set_global_purchase_currency_items,
            'set_unit_price_dispatch_related_record' => $this->set_unit_price_dispatch_related_record,
            'new_validator_pagination' => $this->getNewValidatorPagination(),
            'restrict_voided_send' => $this->restrict_voided_send,
            'shipping_time_days_voided' => $this->shipping_time_days_voided,
            'top_menu_a' => $this->top_menu_a_id ? $this->top_menu_a : '',
            'top_menu_b' => $this->top_menu_b_id ? $this->top_menu_b : '',
            'top_menu_c' => $this->top_menu_c_id ? $this->top_menu_c : '',
            'top_menu_d' => $this->top_menu_d_id ? $this->top_menu_d : '',
            'skin_id' => $this->skin_id,
            'skins' => $skins,
            'facturalo_server' => true, // $this->getFacturaloConfig(),
            'enabled_tips_pos' => $this->enabled_tips_pos,
            'legend_forest_to_xml' => $this->legend_forest_to_xml,
            'change_currency_item' => $this->change_currency_item,
            'enabled_advanced_records_search' => $this->enabled_advanced_records_search,
            'change_decimal_quantity_unit_price_pdf' => $this->change_decimal_quantity_unit_price_pdf,
            'decimal_quantity_unit_price_pdf' => $this->decimal_quantity_unit_price_pdf,
            'separate_cash_transactions' => $this->separate_cash_transactions,
            'order_cash_income' => $this->order_cash_income,
            'generate_order_note_from_quotation' => $this->generate_order_note_from_quotation,
            'list_items_by_warehouse' => $this->list_items_by_warehouse,
            'ticket_single_shipment' => $this->ticket_single_shipment,
            'hide_pdf_view_documents' => $this->hide_pdf_view_documents,
            'regex_password_user' => $this->regex_password_user,
            'enabled_remember_change_password' => $this->enabled_remember_change_password,
            'quantity_month_remember_change_password' => $this->quantity_month_remember_change_password,
            'dashboard_sales' => (bool)$this->dashboard_sales,
            'dashboard_general' => (bool)$this->dashboard_general,
            'dashboard_clients' => (bool)$this->dashboard_clients,
            'dashboard_products' => (bool)$this->dashboard_products,
            'affect_all_documents' => (bool)$this->affect_all_documents,
            'restrict_series_selection_seller' => $this->restrict_series_selection_seller,
            'enabled_point_system' => $this->enabled_point_system,
            'point_system_sale_amount' => $this->point_system_sale_amount,
            'quantity_of_points' => $this->quantity_of_points,
            'round_points_of_sale' => $this->round_points_of_sale,
            'delete_relation_note_to_invoice' => (bool)config('tenant.delete_relation_note_to_invoice'),
            'show_complete_name_pos' => (bool)$this->show_complete_name_pos,
            'enable_categories_products_view' => $this->enable_categories_products_view,
            'restrict_seller_discount' => $this->restrict_seller_discount,
            'sellers_discount_limit' => $this->sellers_discount_limit,
            'enabled_sales_agents' => $this->enabled_sales_agents,
            'change_affectation_exonerated_igv' => $this->change_affectation_exonerated_igv,
            'show_load_voucher' => $this->show_load_voucher,
            'search_factory_code_items' => $this->search_factory_code_items,
            'enabled_dispatch_ticket_pdf' => $this->enabled_dispatch_ticket_pdf,
            'register_series_invoice_xml' => $this->register_series_invoice_xml,
            'enable_discount_by_customer' => $this->enable_discount_by_customer,
            'show_price_barcode_ticket' => $this->show_price_barcode_ticket,
            'price_selected_add_product' => $this->price_selected_add_product,
            'restrict_sale_items_cpe' => $this->restrict_sale_items_cpe,
            'show_convert_cpe_pos' => $this->show_convert_cpe_pos,
            'socket_channel'            => $this->socket_channel,
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
            'reference_ticket' => (bool) $this->reference_ticket,
            'toll' => (bool) $this->toll,
            'promotions_sell'   => $this->promotions_sell,
            'credits' => (bool) $this->credits,
            "dispatch" => (bool) $this->dispatch,
            "quotation" => (bool) $this->quotation,
            'credit_mode' => (bool) $this->credit_mode,
            "send_whatsapp_activity" => (bool) $this->send_whatsapp_activity,
            "pin_orden_delete" => (bool) $this->pin_orden_delete,
            "number_activity" => $this->number_activity,
            'pos_drag_category' => (bool) $this->pos_drag_category,
            'edit_product_pos' => (bool) $this->edit_product_pos,
            'receive_merchandise' => (bool) $this->receive_merchandise,
            'print_incomes_expenses' => (bool) $this->print_incomes_expenses,
            'view_daily_cash' => (bool) $this->view_daily_cash,
            'view_daily_cash_pin' => (bool) $this->view_daily_cash_pin,
            'send_whatsapp_daily_cash' => (bool) $this->send_whatsapp_daily_cash,
            'init_stock' => (bool) $this->init_stock,
            'observation_translate' => (bool)$this->observation_translate,
            'consignment' => (bool)$this->consignment,
            'affectation_optional' => (bool)$this->affectation_optional,
            'affectation_optional_id' => $this->affectation_optional_id,

        ];
    }
    public function isSearchItemBySeries(): ?bool
    {
        return (bool)$this->search_item_by_series;
    }

    public function getNewValidatorPagination(): ?int
    {
        $val = (int)$this->new_validator_pagination;
        return $val == 0 ? (int)config('tenant.items_per_page') : $val;
    }
    public function isPosCostPrice(): bool
    {
        return (bool)$this->pos_cost_price;
    }
    /**
     * @return bool
     */
    public function isShowTotalsOnCpeList(): bool
    {
        return (bool)$this->show_totals_on_cpe_list;
    }

    /**
     * @param bool $show_totals_on_cpe_list
     *
     * @return Configuration
     */
    public function setShowTotalsOnCpeList(?bool $show_totals_on_cpe_list): Configuration
    {
        $this->show_totals_on_cpe_list = (bool)$show_totals_on_cpe_list;
        return $this;
    }
    public function isPosHistory(): bool
    {
        return (bool)$this->pos_history;
    }
    public function isItemNamePdfDescription(): ?bool
    {
        return (bool)$this->item_name_pdf_description;
    }
    public  function getApiServiceToken()
    {

        $api_service_token = $this->token_apiruc == 'false' ? config('configuration.api_service_token') : $this->token_apiruc;
        return $api_service_token;
    }
    public function isShowPdfName(): ?bool
    {
        return (bool)$this->show_pdf_name;
    }
    public function isEnabledGlobalIgvToPurchase(): ?bool
    {
        return (bool)$this->enabled_global_igv_to_purchase;
    }
    public function getCurrencyTypeId(): ?string
    {
        return empty($this->currency_type_id) ? 'PEN' : $this->currency_type_id;
    }
    public function isShowExtraInfoToItem(): ?bool
    {
        return (bool)$this->show_extra_info_to_item;
    }
    public function isDispatchesAddressText(): ?bool
    {
        return (bool)$this->dispatches_address_text;
    }
    public function isShowItemsOnlyUserStablishment(): ?bool
    {
        return false;
        return (bool)$this->show_items_only_user_stablishment;
    }
    public function setPlanAttribute($value)
    {
        $this->attributes['plan'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getPlanAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setVisualAttribute($value)
    {
        $this->attributes['visual'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getVisualAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public static function setConfigSmtpMail()
    {
        $config = self::first();
        if (empty($config)) $config = new self();
        if (
            !empty($config->smtp_host) &&
            !empty($config->smtp_port) &&
            !empty($config->smtp_user) &&
            !empty($config->smtp_password) &&
            !empty($config->smtp_encryption)
        ) {
            Config::set('mail.host', $config->smtp_host);
            Config::set('mail.port', $config->smtp_port);
            Config::set('mail.username', $config->smtp_user);
            Config::set('mail.password', $config->smtp_password);
            Config::set('mail.encryption', $config->smtp_encryption);
        }
        return $config;
    }
    /**
     * @return mixed
     */
    public function getSmtpHost()
    {
        return empty($this->smtp_host) ? config('mail.host') : $this->smtp_host;
    }

    /**
     * @param mixed $smtp_host
     *
     * @return Configuration
     */
    public function setSmtpHost($smtp_host)
    {
        $this->smtp_host = $smtp_host;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSmtpPort()
    {
        return empty($this->smtp_port) ? config('mail.port') : $this->smtp_port;
    }

    /**
     * @param mixed $smtp_port
     *
     * @return Configuration
     */
    public function setSmtpPort($smtp_port)
    {
        $this->smtp_port = $smtp_port;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSmtpUser()
    {
        return empty($this->smtp_user) ? config('mail.username') : $this->smtp_user;
    }

    /**
     * @param mixed $smtp_user
     *
     * @return Configuration
     */
    public function setSmtpUser($smtp_user)
    {
        $this->smtp_user = $smtp_user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSmtpPassword()
    {
        return empty($this->smtp_password) ? config('mail.password') : $this->smtp_password;
    }

    /**
     * @param mixed $smtp_password
     *
     * @return Configuration
     */
    public function setSmtpPassword($smtp_password)
    {
        $this->smtp_password = $smtp_password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSmtpEncryption()
    {
        return empty($this->smtp_encryption) ? config('mail.encryption') : $this->smtp_encryption;
    }

    /**
     * @param mixed $smtp_encryption
     *
     * @return Configuration
     */
    public function setSmtpEncryption($smtp_encryption)
    {
        $this->smtp_encryption = $smtp_encryption;
        return $this;
    }
}
