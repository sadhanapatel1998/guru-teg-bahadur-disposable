<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function showForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string|max:15|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create($data);
        event(new Registered($user));
        Auth::login($user);
        $this->cartService->mergeTo($user->id);
        return redirect()->route('home')->with('success', 'Welcome to Gastro Wellness!');
    }
}
