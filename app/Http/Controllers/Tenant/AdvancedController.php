<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

class AdvancedController extends Controller
{
    public function index() {
        $canSee = false;

        if (strpos(url()->current(), 'sdrimsac') !== false || strpos(url()->current(), 'sdrclientes') !== false) {
            $canSee = true;
        }
        return view('tenant.advanced.index',compact('canSee'));
    }
}