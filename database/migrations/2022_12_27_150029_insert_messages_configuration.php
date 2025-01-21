<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


//2022_12_27_150029_insert_messages_configuration
class InsertMessagesConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('configurations')->update([
            'message_client_before_end' => 'Estimado Cliente, Sdrimsac Solutions le informa que usted ya tiene disponible su recibo de pago con fecha del DD-MM-AAAA, por los servicios de App de Facturación Electrónica y Control Interno; por lo que se le invita a realizar su pago puntual correspondiente a través de la plataforma, YAPE al #########.<br>Si ya realizó su pago, omita este mensaje. Para más información, comunicarse al número %%%%%%%%%. ¡Sdrimsac tu aliado comercial!',
            'message_client_after_end' => 'Estimado cliente, desde la Gerencia General de Sdrimsac se comunica que este dddddd DD-MM-AAAA a las XX:XXXX se procederá a la suspensión del Servicio de Uso del Aplicativo Web de Facturación Electrónica por falta de pago del recibo adelantado del mes de MMMMMMMMMMM AAAA.<br> Importante tomar en cuenta que sólo se restablecerá el servicio con el pago adicional de S/SS POR RECONEXIÓN, sumado a su cuota ordinaria al YAPE #########.<br>Si ya realizó su pago, omita este mensaje. Para más información, comunicarse al número %%%%%%%%%. ¡Sdrimsac tu aliado comercial!',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('configurations')->update([
            'message_client_before_end' => null,
            'message_client_after_end' => null,
        ]);
    }
}
