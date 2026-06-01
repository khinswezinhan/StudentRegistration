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

    <div class="py-4"> 
        <form action="{{ route('course.store') }}" method="POST">
            @csrf
            
            <div class="p-5 rounded-4 w-50 m-auto form-border-custom bg-white"> 
                <h2 class="text-center mb-4 form-theme-title fs-3">Create Course</h2>
                
                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Course Name</label></b>
                    <input class="form-control" type="text" name="course_name" required>
                </div>

                <div class="mb-4">
                    <b><label class="form-label form-theme-label">Select Teacher</label></b>
                    <select class="form-select form-control" name="teacher_id" required>
                        <option value="" selected disabled>Choose Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <button type="submit" class="btn btn-custom-solid form-control fw-medium py-2">
                        <i class="fa-solid fa-square-plus me-1"></i> Create Course
                    </button>
                </div>    
            </div>
        </form>
    </div>
</x-app-layout>