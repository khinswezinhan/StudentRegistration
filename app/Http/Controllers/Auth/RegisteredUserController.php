<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // 💡 ၁။ Role Model ကို သုံးနိုင်အောင် ဆွဲထည့်လိုက်တယ်
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // 💡 ၂။ roles table ထဲက ဒေတာအားလုံးကို ဆွဲထုတ်မယ်
        $roles = Role::all(); 

        // 💡 ၃။ register view ဖိုင်ဆီကို $roles တေ လှမ်းပို့ပေးမယ်
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 💡 ၄။ role_id ပါဝင်ပြီး roles table ထဲမှာ တကယ်ရှိမရှိပါ စစ်ဆေးမယ်
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'], 
        ]);

        // 💡 ၅။ user ဆောက်တဲ့နေရာမှာ role_id ကိုပါ ထည့်သိမ်းပေးလိုက်မယ်
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id, 
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}