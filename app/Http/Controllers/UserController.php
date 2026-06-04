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
    public function index(Request $request): View 
{
    $query = User::with('role');

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
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
