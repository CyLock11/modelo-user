<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function checkCredentials(array $data): ?User
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:30'],
            'email' => ['required', 'email', 'unique:users,email', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:30']
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json($user, 201);
    }

    public function get()
    {
        return User::orderByDesc('id')->paginate(10);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:30']
        ]);

        $user = $this->checkCredentials($data);

        if (!$user) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        return response()->json([
            $user->username => $user->except(['username'])
        ], 201);
    }

    public function update_username(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:30'],
            'username' => ['required', 'string', 'min:3', 'max:30']
        ]);

        $user = $this->checkCredentials($data);

        if (!$user) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        $user->username = $data['username'];
        $user->save();

        return response()->json([
            'user' => $user->only(['id', 'username', 'email'])
        ], 201);
    }

    public function update_email(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:30'],
            'new_email' => ['required', 'email', 'max:50']
        ]);

        $user = $this->checkCredentials($data);

        if (!$user) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        $user->email = $data['new_email'];
        $user->save();

        return response()->json([
            'user' => $user->only(['id', 'username', 'email'])
        ]);
    }

    public function update_password(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:30'],
            'new_password' => ['required', 'string', 'min:8', 'max:50']
        ]);

        $user = $this->checkCredentials($data);

        if (!$user) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        return response()->json([
            'user' => $user->only(['id', 'username', 'email'])
        ]);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:30']
        ]);

        $user = $this->checkCredentials($data);

        if (!$user) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente.'
        ]);
    }
}
