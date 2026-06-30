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
        <form action="{{ route('teacher.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            
            <div class="p-5 rounded-4 w-50 m-auto form-border-custom bg-white"> 
                
                <h2 class="text-center mb-4 form-theme-title text-success fs-3">Create New Teachers</h2>
                
                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Name</label></b>
                    <input class="form-control" type="text" name="name" required value="{{ old('name') }}">

                    @error('name')
                    <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Rank</label></b>
                    <input class="form-control" type="text" name="rank" required value="{{ old('rank') }}">
                    
                    @error('rank')
                    <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
    <b><label class="form-label form-theme-label">Department</label></b>
    <select class="form-select form-control" name="department_id" id="department-select" required>
        <option value="" selected disabled>Choose Department</option>
        @foreach($departments as $dept)
            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                {{ $dept->department_name }}
            </option>
        @endforeach
    </select>

    @error('department_id')
        <p class="text-danger small mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-3">
    <b><label class="form-label form-theme-label">Courses (သင်ကြားမည့် ဘာသာရပ်များ)</label></b>
    <div class="row ps-2" id="course-container">
        <p class="text-muted small">Please select a department first.</p>
    </div>

    @error('course_ids')
        <p class="text-danger small mt-1">{{ $message }}</p>
    @enderror
</div>

<script>
document.getElementById('department-select').addEventListener('change', function () {
    const departmentId = this.value;
    const courseContainer = document.getElementById('course-container');

    // Loading ဖြစ်နေစဉ် ပြသရန်
    courseContainer.innerHTML = '<p class="text-muted small">Loading courses...</p>';

    if (!departmentId) return;

    // Route ဆီကို Department ID ပို့ပြီး ဒေတာလှမ်းတောင်းခြင်း
    fetch(`/get-courses-by-dept/${departmentId}`)
        .then(response => response.json())
        .then(courses => {
            courseContainer.innerHTML = ''; // အရင်အဟောင်းများကို ရှင်းထုတ်ရန်

            if (courses.length === 0) {
                courseContainer.innerHTML = '<p class="text-danger small">No courses found for this department.</p>';
                return;
            }

            // ရလာတဲ့ Course တွေကို Checkbox အဖြစ် တစ်ခုချင်းစီ ဆွဲထုတ်ပေးခြင်း
            courses.forEach(course => {
                const checkboxHtml = `
                    <div class="col-md-6 form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="course_ids[]" 
                               value="${course.id}" 
                               id="course_${course.id}">
                        <label class="form-check-label text-secondary small" for="course_${course.id}">
                            ${course.course_name}
                        </label>
                    </div>
                `;
                courseContainer.insertAdjacentHTML('beforeend', checkboxHtml);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            courseContainer.innerHTML = '<p class="text-danger small">Something went wrong. Please try again.</p>';
        });
});
</script>
                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Email</label></b>
                    <input class="form-control" type="email" name="email" required value="{{ old('email') }}">
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
                        <i class="fa-solid fa-chalkboard-user me-1"></i> Create
                    </button>
                </div>    
            </div>
        </form>
    </div>
</x-app-layout>