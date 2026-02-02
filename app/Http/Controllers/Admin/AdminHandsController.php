<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BgaUser;
use App\Models\Hand;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class AdminHandsController extends Controller
{
    public function index()
    {
        return view('admin.hands.index', [
            'hands' => Hand::query()
                ->select(['id', 'started_at', 'ended_at', 'bga_hand_id'])
                ->with(['players', 'games', 'games.players'])
                ->whereNull('deleted_at')
                ->orderByDesc('started_at')
                ->get(),
        ]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hand_id' => 'required|exists:' . Hand::class . ',id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Paramètres incorrects.',
                'errors' => $validator->errors(),
            ], 406);
        }

        $nb_hand_update = Hand::where('id', $request->input('hand_id'))
            ->update(['deleted_at' => Carbon::now()]);

        return response(status: !empty($nb_hand_update) ? 200 : 406);
    }
}
