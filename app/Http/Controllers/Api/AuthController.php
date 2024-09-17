<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function user(Request $request)
    {
        try {
            $data = $request->user();
            $response = [
                'success' => true,
                'message' => 'Data user tersedia',
                'data' => $data,
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data user tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $data = $request->validated();

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

            $response = [
                'success' => true,
                'message' => 'Register Berhasil, Silahkan Login',
                'data' => $user,
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Register Gagal',
            ];
            return response()->json($response, 500);
        }
    }

// pada method login tambahkan response nya "access_menu" diambil dari tabel roles
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        // $request->session()->regenerate();
        $user = User::where('email', $request['email'])->firstOrFail();
        if ($user->roles_id == 1) {
            $is_admin = true;
        }
        // $setting_role = SettingRoles::where('users_id', $user->id)->get();
        // $is_admin = false;
        // if (!$setting_role) {
        //     return response()
        //         ->json(['success' => false, 'message' => 'You are not allowed'], 401);
        // } else {
        //     $setting_role_admin = SettingRoles::where('users_id', $user->id)->where('roles_id', 1)->first();
        //     if ($setting_role_admin) {
        //         $is_admin = true;
        //     }
        // }

         // Ambil access dari tabel roles berdasarkan roles_id user
        $role = Roles::where('id', $user->roles_id)->first();
    
        // Jika role ditemukan, ambil nilai access dari role tersebut
        $access_menu = $role ? $role->access : null;

        $token = $user->createToken('auth_token')->plainTextToken;
        // print( Auth::user());
        return response()
            ->json([
                'success' => true,
                'message' => 'Hi ' . $user->name . ', Welcome to Smart Building',
                'access_token' => $token,
                'users_id' => $user->id,
                'roles_id' => $user->roles_id,
                'is_update_password' => $user->is_update_password,
                'perusahaan_id' => $user->perusahaan_id,
                'access_menu' => $access_menu, // Tambahkan access_menu dari tabel roles
            ]);

        return response()
            ->json(['message' => 'Unauthorized'], 401);
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        } else {
            if (!Hash::check($request->password, $user->password)) {
                return redirect()->back()->with('error', 'Password salah');
            } else {
                $remember = $request->has('remember');

                if ($remember) {
                    // email kesimpen kalo remeber di centang
                    Cookie::queue('email', $request->email, 43200);
                } else {
                    // ini kalo ga di centang
                    Cookie::queue(Cookie::forget('email'));
                }

                Auth::login($user, $remember);
                return redirect()->route('dashboard');
            }
        }
    }

    public function prosesLogout(Request $request)
    {
        try {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Logout Berhasil, Silahkan Login Kembali');
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Logout Gagal',
            ];
            return response()->json($response, 500);
        }
    }
    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();
            return response()
                ->json(['success' => true,
                    'message' => 'Thank You.',
                ]);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Logout Gagal',
            ];
            return response()->json($response, 500);
        }
    }

    public function changePasswordById(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        if (!(Hash::check($request->get('current_password'), $user->password))) {
            return response()->json([
                'success' => false,
                'message' => 'Your current password does not match our records.',
            ], 401);
        }

        if ($request->get('current_password') === $request->get('new_password')) {
            return response()->json([
                'success' => false,
                'message' => 'New Password cannot be the same as your current password.',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user->password = bcrypt($request->new_password);
        
        // Reset the flag after the user has successfully changed their password
        $user->is_password_reset = false;
    
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password has been changed successfully.',
        ]);
    }

}
