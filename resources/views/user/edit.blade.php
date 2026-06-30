<x-app-layout>
    <style>
         .form-border-custom {
            border: 1px solid rgb(93, 79, 112) !important; /* border-2 ထက် ပိုပြီး သပ်ရပ်အောင် 1px ပြောင်းထားပါတယ် */
            box-shadow: 0 4px 12px rgba(93, 79, 112, 0.05);
        }

        .form-theme-title {
            color: rgb(93, 79, 112) !important;
            font-weight: 600;
        }
        .form-theme-label {
            color: rgb(93, 79, 112) !important;
        }

                .form-control:focus {
            border-color: rgb(93, 79, 112) !important;
            box-shadow: 0 0 0 0.25rem rgba(93, 79, 112, 0.25) !important;
        }
    </style>
    <div class="container p-5 rounded-4 w-50 m-auto form-border-custom bg-white" style="max-width: 500px;">
        <h2 class="text-center text-primary mb-4 fs-3">Editing User</h2>
        
        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="text" name="password" class="form-control" value="{{ $user->password }}">
            </div>

          

            
            <div class="mb-4">
                <label class="form-label">Role Name</label>
                <select class="form-select form-control" name="role_id" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="/" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app-layout>