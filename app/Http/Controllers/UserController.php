<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller
{
    // User အားလုံးကို List ပြတဲ့ Function
    public function index(): View 
    {
        $users = User::with('role')->get(); 
        return view('user.index', compact('users'));
    }

    // User အသစ်ဆောက်မယ့် Form စာမျက်နှာကို ပြတဲ့ Function
    public function create(): View
    {
        $roles = Role::all(); // Dropdown မှာပြဖို့ Role ဒေတာတွေ ဆွဲထုတ်တယ်
        return view('user.create', compact('roles'));
    }

    // Form ကလာတဲ့ ဒေတာတွေကို Database ထဲ သိမ်းတဲ့ Function
    public function store(StoreUserRequest $request): RedirectResponse 
    {
        $incomingFields = $request->validated();

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        
        // 🔐 အသစ်ဆောက်တာဖြစ်လို့ Password ကို မဖြစ်မနေ Hash လုပ်ပြီး သိမ်းပါတယ်
        $incomingFields['password'] = bcrypt(strip_tags($incomingFields['password']));
        $incomingFields['role_id'] = strip_tags($incomingFields['role_id']);

        User::create($incomingFields);
        
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    // User ပြင်ဆင်မယ့် စာမျက်နှာကို ပြတဲ့ Function
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::all(); 
        return view('user.edit', compact('user', 'roles'));
    }

    // ပြင်ဆင်လိုက်တဲ့ ဒေတာတွေကို Database ထဲမှာ Update လုပ်တဲ့ Function
    public function update($id, StoreUserRequest $request): RedirectResponse 
    {
        $user = User::find($id);
        $incomingFields = $request->validated();

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['role_id'] = strip_tags($incomingFields['role_id']);

        // 🔐 Password Logic: ပတ်စဝေါ့အသစ် ရိုက်ထည့်မှသာ Hash လုပ်ပြီး သိမ်းမယ်
        if (!empty($incomingFields['password'])) {
            $incomingFields['password'] = bcrypt($incomingFields['password']);
        } else {
            unset($incomingFields['password']); // ဘာမှမရိုက်ရင် အဟောင်းအတိုင်းထားဖို့ ဖယ်ထုတ်တယ်
        }

        $user->update($incomingFields);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    // User ကို ဖျက်တဲ့ Function
    public function destroy(User $user): RedirectResponse 
    {
        $user->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }
}
