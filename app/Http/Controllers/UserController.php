<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware; // 💡 ဒါလေး ထည့်ပါ
use Illuminate\Routing\Controllers\Middleware;    // 💡 ဒါက Error တက်စေတဲ့ အဓိကတရားခံမို့ ထည့်ပေးရပါမယ်

class UserController extends Controller implements HasMiddleware // 💡 implements ထည့်ပေးပါ
{
    public static function middleware(): array
    {
        return [
            new Middleware(function (Request $request, $next) {
                if (!Auth::check() || Auth::user()->role_id != 1) {
                    abort(403, 'Unauthorized. နင်က SuperAdmin မဟုတ်လို့ ဝင်ခွင့်မရှိပါ!');
                }
                return $next($request);
            }),
        ];
    }

   public function index(Request $request): View 
{
    $query = User::with('role');

    // ၁။ Name Filter (Space နှင့် စာလုံးအကြီးအသေးကို Ignore လုပ်မည်)
    if ($request->filled('name')) {
        // Request ထဲက လာတဲ့စာသားကို Space တွေ အကုန်ဖြုတ်လိုက်သည် (ဥပမာ "Mg Mg " -> "MgMg")
        $searchName = str_replace(' ', '', $request->name);

        $query->whereRaw("REPLACE(name, ' ', '') LIKE ?", ['%' . $searchName . '%']);
    }

    // ၂။ Email Filter (Space နှင့် စာလုံးအကြီးအသေးကို Ignore လုပ်မည်)
    if ($request->filled('email')) {
        // Request ထဲက Email ကို Space တွေ အကုန်ဖြုတ်လိုက်သည်
        $searchEmail = str_replace(' ', '', $request->email);

        $query->whereRaw("REPLACE(email, ' ', '') LIKE ?", ['%' . $searchEmail . '%']);
    }

    $users = $query->paginate(5)->appends($request->all());
    
    return view('user.index', compact('users'));
}

    public function create(): View
    {
        $roles = Role::all(); 
        return view('user.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse 
    {
        $incomingFields = $request->validated();

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['password'] = bcrypt(strip_tags($incomingFields['password']));
        $incomingFields['role_id'] = strip_tags($incomingFields['role_id']);

        User::create($incomingFields);
        
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::all(); 
        return view('user.edit', compact('user', 'roles'));
    }

    public function update($id, StoreUserRequest $request): RedirectResponse 
    {
        $user = User::find($id);
        $incomingFields = $request->validated();

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['role_id'] = strip_tags($incomingFields['role_id']);

        if (!empty($incomingFields['password'])) {
            $incomingFields['password'] = bcrypt($incomingFields['password']);
        } else {
            unset($incomingFields['password']); 
        }

        $user->update($incomingFields);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user): RedirectResponse 
    {
        $user->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }
}