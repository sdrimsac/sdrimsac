<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System\SummaryCorrelative;
use Illuminate\Support\Facades\DB;

class SummaryCorrelativeController extends Controller
{
    public function nextCorrelative(Request $request)
    {
        $ruc = $request->ruc;
        $type = $request->type; // RC o RA

        DB::beginTransaction();
        try {
            $record = SummaryCorrelative::where('ruc', $ruc)
                ->where('type', $type)
                ->lockForUpdate()
                ->first();

            if (!$record) {
                $record = SummaryCorrelative::create([
                    'ruc' => $ruc,
                    'type' => $type,
                    'correlative' => 1
                ]);
            } else {
                $record->increment('correlative');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'correlative' => str_pad($record->correlative, 3, '0', STR_PAD_LEFT)
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
