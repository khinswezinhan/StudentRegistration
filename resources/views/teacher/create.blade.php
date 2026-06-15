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
        }

        .form-control:focus {
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
            box-shadow: 0 4px 8px rgba(93, 79, 112, 0.2);
        }
    </style>

    <div class="py-4"> 
        <form action="/teacher-create" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-5 rounded-4 w-50 m-auto form-border-custom bg-white"> 
                
                <h2 class="text-center mb-4 form-theme-title fs-3">Create Teachers' Content</h2>
                
    

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Name</label></b>
                    <input class="form-control" type="text" name="name" required value="{{ old('name') }}">

                    @error('name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Rank</label></b>
                    <input class="form-control" type="text" name="rank" required value="{{ old('rank') }}">
                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Email</label></b>
                    <input class="form-control" type="email" name="email" required value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Phone Number</label></b>
                    <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
                     @error('phone')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4"> 
                    <b><label class="form-label form-theme-label">Address</label></b>
                    <input class="form-control" type="text" name="address" value="{{ old('address') }}">
                </div>

                 <div class="mb-3">
                    <b><label class="form-label form-theme-label">Upload your photo</label></b>
                    <input class="form-control" type="file" name="image" required value="{{ old('image') }}">
                </div>

                <div class="mb-2">
                    <button type="submit" class="btn btn-custom-solid form-control fw-medium py-2">
                        <i class="fa-solid fa-chalkboard-user me-1"></i> Create
                    </button>
                </div>    
            </div>
        </form>
    </div>
</x-app-layout>