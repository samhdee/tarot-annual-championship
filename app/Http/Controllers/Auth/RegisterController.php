<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BgaUser;
use App\Models\User;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'bga_user_id' => [
                'required',
                'int',
                Rule::exists('bga_users', 'id')->where(function (Builder $query) {
                    $query->where(function (Builder $query) {
                        $query->orWhereNull('user_id')
                            ->orWhere('user_id', 0);
                    });
                }
            )],
            'name' => ['nullable', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:15', 'confirmed'],
            'captcha' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     * @throws \Throwable
     */
    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => !empty($data['name']) ? $data['name'] : null,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $bga_user = BgaUser::find($data['bga_user_id']);
            $bga_user->user()->associate($user);
            $bga_user->save();

            return $user;
        });
    }

    public function showRegistrationForm()
    {
        $unregistered_users = BgaUser::query()
            ->select(['id', 'bga_username'])
            ->whereDoesntHave('user')
            ->orderBy('bga_username')
            ->get();

        return view('auth.register', ['unregistered_users' => $unregistered_users]);
    }
}
