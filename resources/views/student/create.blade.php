<x-app-layout>
    <style>
        .form-border-custom {
            border: 1px solid rgb(93, 79, 112) !important; 
            box-shadow: 0 4px 12px rgba(93, 79, 112, 0.05);
        }

        .form-theme-title {
            font-weight: 600;
        }
        
        .form-theme-label {
            color: rgb(93, 79, 112) !important;
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
            box-shadow: 0 4px 8px rgba(93, 79, 112, 0.2);
        }
    </style>

    <div class="py-4"> 
        <form action="/student-create" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            
            <div class="p-5 rounded-4 w-50 m-auto form-border-custom bg-white"> 
                
                <h2 class="text-center mb-4 form-theme-title text-success fs-3">Create New Students</h2>
                
                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Name</label></b>
                    <input class="form-control" type="text" name="name" required value="{{ old('name') }}">
                    @error('name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <b><label for="class_model_id" class="form-label form-theme-label">Class (အတန်း)</label></b>
                    <select name="class_model_id" id="class_model_id" class="form-select text-secondary" required>
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_model_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_model_id')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Email</label></b>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Phone Number</label></b>
                    <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>
               
                <div class="mb-4"> 
                    <b><label class="form-label form-theme-label">Address</label></b>
                    <input class="form-control" type="text" name="address" value="{{ old('address') }}">
                    @error('address')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Upload your photo</label></b>
                    <input class="form-control" type="file" name="image" required>
                    @error('image')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-2">
                    <button type="submit" class="btn btn-success form-control fw-medium py-2">
                        Create
                    </button>
                </div>    
            </div>
        </form>
    </div>
</x-app-layout>