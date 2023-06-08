<?php

namespace App\Traits;

use App\Events\RegisterEvent;
use App\Models\Tenant\RegisterMovement;

/**
 * 
 */
trait RegisterMovementTrait
{

    use HelperTrait;

    public static function registerMovement($event, $model, $request_data, $description = null, $data = [])
    {   $id = $model->id;
        $class_model = get_class($model);
        $user_id = auth()->id();
        $ip = $request_data->ip();
        $userAgent = $request_data->userAgent();
        $browser_so = self::func_get_browser_so($userAgent);
        $platform = $browser_so['platform'];


       $register = RegisterMovement::create([
            "ip" => $ip ?? "SERVIDOR - TAREA PROGRAMADA",
            "browser" => $platform,
            "user_id" => $user_id,
            "event" => $event,
            "model" => $class_model,
            "model_id" => $id,
            "description" => $description,
            "data" => json_encode($data),
        ]);
        event(new RegisterEvent($register));
    }

    public function registerUpdate($model, $request_data, $description = null, $data = [])
    {
        $event = 'update';
        self::registerMovement($event, $model, $request_data, $description, $data);
       
        return null;
    }//registerDelete
    public function registerDelete($model, $request_data, $description = null, $data = [])
    {
        $event = 'delete';
        self::registerMovement($event, $model, $request_data, $description, $data);
       
    }//
    public function registerCreate($model, $request_data, $description = null, $data = [])
    {
        $event = 'create';
        self::registerMovement($event, $model, $request_data, $description, $data);
       
    }
    public static function func_get_browser_so($userAgent)
    {
        $browser = '';
        $platform = '';

        if (preg_match('/MSIE|Trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
            $browser = 'Opera';
        }

        if (preg_match('/Windows/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $platform = 'Mac';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $platform = 'Android';
        } elseif (preg_match('/iOS/i', $userAgent)) {
            $platform = 'iOS';
        }

        return [
            'browser' => $browser,
            'platform' => $platform
        ];
    }

    

}
