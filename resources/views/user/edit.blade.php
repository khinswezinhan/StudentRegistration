<x-app-layout>
    <style>
         .form-border-custom {
            border: 1px solid rgb(93, 79, 112) !important; 
            box-shadow: 0 4px 12px rgba(93, 79, 112, 0.05);
        }

        .form-theme-title {
            color: rgb(93, 79, 112) !important;
            font-weight: 600;
        }
        
        .form-theme-label {
            color: rgb(93, 79, 112) !important;
            font-weight: 500;
        }

        .form-control:focus, .form-select:focus {
            border-color: rgb(93, 79, 112) !important;
            box-shadow: 0 0 0 0.25rem rgba(93, 79, 112, 0.25) !important;
        }

        .btn-custom-solid {
            color: #ffffff !important;
            background-color: rgb(93, 79, 112) !important;
            border: 1px solid rgb(93, 79, 112) !important;
            transition: all 0.2s ease;
        }
        
        .btn-custom-solid:hover {
            background-color: rgb(75, 63, 91) !important;
            border-color: rgb(75, 63, 91) !important;
        }
    </style>
    
    <div class="container p-5 rounded-4 w-50 m-auto form-border-custom bg-white my-5" style="max-width: 500px;">
        <h2 class="text-center form-theme-title mb-4 fs-3">Editing User</h2>

        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 small rounded-3 mb-4">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            <div class="mb-3">
                <label class="form-label form-theme-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-3">
                <label class="form-label form-theme-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
                <label class="form-label form-theme-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
            </div>

            <div class="mb-3">
                <label class="form-label form-theme-label">Role Name</label>
                <select class="form-select form-control" name="role_id" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label form-theme-label">Account Status</label>
                <select class="form-select form-control" name="status" required>
                    <option value="active" {{ old('status', $user->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-custom-solid px-4">Save Changes</button>
                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>