<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Configuration;
use Modules\Services\Data\ServiceData;
use App\CoreFacturalo\Services\Ruc\Sunat;
class ServiceController extends Controller
{
	public function ruc($number)
	{
		$configuration = Configuration::first();
		if (!$configuration->token_apiruc || $configuration->token_apiruc === 'false') {
			$service = new Sunat();
			$res     = $service->get($number);
			if ($res) {
				return [
					'success' => true,
					'data'    => [
						'name'       => $res->razonSocial,
						'trade_name' => $res->nombreComercial,
					]
				];
			} else {
				return [
					'success' => false,
					'message' => $service->getError()
				];
			}
		} else {
			try {
				// Determine type by number length: 8 => dni, 11 => ruc
				$cleanNumber = preg_replace('/\D+/', '', (string)$number);
				$typeToUse = (strlen($cleanNumber) === 8) ? 'dni' : 'ruc';

				$data = ServiceData::service($typeToUse, $cleanNumber);

				// Normalize different possible response shapes coming from the API wrappers
				$name = null;
				if (isset($data['data']['nombre_o_razon_social'])) {
					$name = $data['data']['nombre_o_razon_social'];
				} elseif (isset($data['data']['name'])) {
					$name = $data['data']['name'];
				} elseif (isset($data['data']['nombre_completo'])) {
					$name = $data['data']['nombre_completo'];
				}

				$response = [
					'success' => true,
					'data'    => [
						'name'       => $name ?? $number,
						'trade_name' => $name ?? $number,
					]
				];

				return response()->json($response, 200);
			} catch (\Throwable $th) {
				return response()->json([
					'success' => false,
					'message' => 'El número de RUC ingresado no existe. Detalles: ' . $th->getMessage()
				], 200);
			}
		}
	}
}
