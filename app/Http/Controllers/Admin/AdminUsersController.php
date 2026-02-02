<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BgaUser;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class AdminUsersController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::query()
                ->select(['id', 'name', 'email', 'last_login_at', 'is_active'])
                ->whereHas('bgaUser')
                ->get()
                ->sortBy(function ($query) { return $query->bgaUser->bga_username; })
                ->all(),
        ]);
    }

    public function switchActive($user_id, $new_state)
    {
        $validator = Validator::make(
            [
                'user_id' => $user_id,
                'new_state' => $new_state,
            ],
            [
                'user_id' => 'required|exists:' . User::class . ',id',
                'new_state' => 'required|boolean',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Paramètres incorrects.',
                'errors' => $validator->errors(),
            ], 406);
        }

        $nb_user_update =  User::where('id', $user_id)
            ->update(['is_active' => $new_state]);

        return response(status: !empty($nb_user_update) ? 200 : 406);
    }

    public function switchAdmin($bga_user_id, $new_state)
    {
        $validator = Validator::make(
            [
                'bga_user_id' => $bga_user_id,
                'new_state' => $new_state,
            ],
            [
                'bga_user_id' => 'required|exists:' . BgaUser::class . ',id',
                'new_state' => 'required|boolean',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Paramètres incorrects.',
                'errors' => $validator->errors(),
            ], 406);
        }

        $nb_user_update = BgaUser::where('id', $bga_user_id)
            ->update(['is_admin' => $new_state]);

        return response(status: !empty($nb_user_update) ? 200 : 406);
    }
}
