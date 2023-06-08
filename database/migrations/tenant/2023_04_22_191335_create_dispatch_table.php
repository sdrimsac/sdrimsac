<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->uuid('external_id');
            $table->unsignedInteger('establishment_id');
            $table->json('establishment');
            $table->char('soap_type_id', 2);
            $table->char('state_type_id', 2);
            $table->string('ubl_version');
            $table->string('document_type_id');
            $table->unsignedInteger('reference_sale_note_id')->nullable(); //*** */
            $table->unsignedInteger('reference_document_id')->nullable(); //*** */
            $table->unsignedInteger('reference_quotation_id')->nullable(); //*** */
            $table->unsignedInteger('reference_order_form_id')->nullable(); //*** */
            $table->unsignedInteger('reference_order_note_id')->nullable(); //*** */
            $table->char('series', 4);
            $table->integer('number');
            $table->date('date_of_issue');
            $table->time('time_of_issue');
            $table->unsignedInteger('customer_id')->nullable();
            $table->json('customer')->nullable();
            $table->text('observations')->nullable();
            $table->string('transport_mode_type_id')->nullable();
            $table->string('transfer_reason_type_id')->nullable();
            $table->string('transfer_reason_description')->nullable();
            $table->date('date_of_shipping');
            $table->boolean('transshipment_indicator');
            $table->string('port_code')->nullable();
            $table->string('unit_type_id');
            $table->decimal('total_weight', 10, 2);
            $table->integer('packages_number')->nullable();
            $table->integer('container_number')->nullable();
            $table->json('related')->nullable()->comment('Numero de DAM'); //*** */
            $table->json('origin')->nullable();
            $table->json('delivery')->nullable();
            $table->unsignedInteger('dispatcher_id')->nullable(); //*** */
            $table->json('dispatcher')->nullable();
            $table->unsignedInteger('driver_id')->nullable(); //*** */
            $table->json('driver')->nullable();
            $table->string('order_form_external')->nullable(); //*** */
            $table->string('license_plate')->nullable();
            $table->json('secondary_license_plates')->nullable(); //*** */
            $table->unsignedInteger('sender_id')->nullable(); //*** *3/
            $table->json('sender_data')->nullable(); //*** *3/
            $table->unsignedInteger('sender_address_id')->nullable(); //*** *3/
            $table->json('sender_address_data')->nullable(); //*** *3/
            $table->unsignedInteger('receiver_id')->nullable(); //*** *3/
            $table->json('receiver_data')->nullable(); //*** *3/
            $table->unsignedInteger('receiver_address_id')->nullable(); //*** *3/
            $table->json('receiver_address_data')->nullable(); //*** *3/
            $table->unsignedInteger('transport_id')->nullable(); //*** */
            $table->json('legends')->nullable();
            $table->json('optional')->nullable();
            $table->string('filename')->nullable();
            $table->string('hash')->nullable();
            $table->json('soap_shipping_response')->nullable(); //*** */
            $table->boolean('send_to_pse')->default(false); //*** */
            $table->boolean('has_xml')->default(false);
            $table->boolean('has_pdf')->default(false);
            $table->boolean('has_cdr')->default(false);
            $table->unsignedInteger('document_id')->nullable(); //*** */
            $table->json('response_send_cdr_pse')->nullable(); //*** */
            $table->json('response_signature_pse')->nullable(); //*** */
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade'); //*** */
            $table->string('ticket', 50)->nullable(); //*** */
            $table->string('reception_date')->nullable(); //*** */
            $table->string('qr_url')->nullable(); //*** */
            $table->longText('data_affected_document')->nullable(); //*** */
            $table->text('terms_condition')->nullable(); //*** */
            $table->json('additional_data')->nullable(); //*** */
            $table->foreign('dispatcher_id')->references('id')->on('dispatchers'); //*** */
            $table->foreign('driver_id')->references('id')->on('drivers'); //*** */
            $table->foreign('transport_id')->references('id')->on('transports'); //*** */
            $table->json('transport_data')->nullable(); //*** */
            $table->unsignedInteger('origin_address_id')->nullable(); //*** */
            $table->unsignedInteger('delivery_address_id')->nullable(); //*** */
            //cambio hace 3 meses //*** */
            $table->timestamps();
            $table->foreign('sender_id')->references('id')->on('persons'); //*** *3/
            $table->foreign('sender_address_id')->references('id')->on('dispatch_addresses'); //*** *3/
            $table->foreign('receiver_id')->references('id')->on('persons'); //*** *3/
            $table->foreign('receiver_address_id')->references('id')->on('dispatch_addresses'); //*** *3/
            /////////
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('soap_type_id')->references('id')->on('soap_types');
            $table->foreign('state_type_id')->references('id')->on('state_types');
            $table->foreign('document_type_id')->references('id')->on('cat_document_types');
            $table->foreign('customer_id')->references('id')->on('persons');
            $table->foreign('unit_type_id')->references('id')->on('cat_unit_types');
            $table->foreign('transport_mode_type_id')->references('id')->on('cat_transport_mode_types');
            $table->foreign('transfer_reason_type_id')->references('id')->on('cat_transfer_reason_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispatches');
    }
}
