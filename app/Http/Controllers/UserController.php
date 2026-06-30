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
use Illuminate\Routing\Controllers\HasMiddleware; 
use Illuminate\Routing\Controllers\Middleware;    

class UserController extends Controller implements HasMiddleware 
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
            $searchName = str_replace(' ', '', $request->name);
            $query->whereRaw("REPLACE(name, ' ', '') LIKE ?", ['%' . $searchName . '%']);
        }

        // ၂။ Email Filter (Space နှင့် စာလုံးအကြီးအသေးကို Ignore လုပ်မည်)
        if ($request->filled('email')) {
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
        
        // Form မှာ status field ပါဝင်ခဲ့ရင် သိမ်းမယ်၊ မပါရင် default active ထားမယ်
        $incomingFields['status'] = $request->input('status', 'active');

        User::create($incomingFields);
        
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit($id): View
    {
        // 💡 Inactive စစ်ဆေးချက်တွေကို ဖယ်လိုက်လို့ ဘယ် User မဆို စိတ်ကြိုက် ဝင်ပြင်လို့ရပါပြီ
        $user = User::findOrFail($id);
        $roles = Role::all(); 
        return view('user.edit', compact('user', 'roles'));
    }

    public function update($id, StoreUserRequest $request): RedirectResponse 
    {
        $user = User::findOrFail($id);
        $incomingFields = $request->validated();

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['role_id'] = strip_tags($incomingFields['role_id']);

        // 💡 Password ကွက်လပ်မှာ အသစ်ရိုက်ထည့်ရင် Hash လုပ်ပြီးသိမ်းမယ်၊ ချန်ထားခဲ့ရင် အဟောင်းအတိုင်း ထားမယ်
        if (!empty($incomingFields['password'])) {
            $incomingFields['password'] = bcrypt($incomingFields['password']);
        } else {
            unset($incomingFields['password']); 
        }

        // Form ကလာတဲ့ Status အသစ် (Active/Inactive) ကို အကုန်လုံးအတွက် လွတ်လပ်စွာ update လုပ်ခွင့်ပေးခြင်း
        $incomingFields['status'] = $request->input('status', $user->status);

        $user->update($incomingFields);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user): RedirectResponse 
    {
        // 💡 Status Inactive ဖြစ်နေလည်း တန်းဖျက်လို့ရအောင် ကန့်သတ်ချက် ဖြုတ်လိုက်ပါပြီ
        $user->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }
}