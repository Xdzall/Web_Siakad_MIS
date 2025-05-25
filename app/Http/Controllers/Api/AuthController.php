<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if user is admin - reject mobile login for admins
            if ($user->hasRole('admin')) {
                return response()->json([
                    'message' => 'Admin accounts cannot access the mobile API'
                ], 403);
            }
            
            $token = $user->createToken('mobile-app')->plainTextToken;
            
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->roles->first()->name,
                    'nrp' => $user->nrp,
                    'nip' => $user->nip,
                    'semester' => $user->semester,
                    'kelas_id' => $user->kelas_id,
                    'is_wali' => $user->is_wali,
                ],
                'token' => $token,
            ]);
        }
        
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request){
        try {
            if ($request->user()) {
                $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();
                
            }
            return response()->json(['message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error logging out: ' . $e->getMessage()], 500);
        }
    }

    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->roles->first()->name,
            'nrp' => $user->nrp,
            'nip' => $user->nip,
            'semester' => $user->semester,
            'kelas_id' => $user->kelas_id,
            'is_wali' => $user->is_wali,
        ]);
    }
}