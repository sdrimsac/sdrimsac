<?php
namespace App\Traits;
use App\Plan;
use App\User;
use App\Query;
use App\Company;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

trait ApiResponser
{

private function successResponse($data, $code)

{
	return response()->json($data, $code);
}

protected  function errorResponse($message, $code)

{
//	return response()->json(['error'=> $message, 'code' => $code], $code);
}

protected function showAll(Collection $collection, $code)

{

    return $this->successResponse(['data'=> $collection], $code);
}

protected function showOne(Model $instance, $code = 200)

{

    return $this->successResponse(['data'=> $instance], $code);
}

    
}