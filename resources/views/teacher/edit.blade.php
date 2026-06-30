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
    </style>
    <div class="container p-5 rounded-4 w-50 m-auto form-border-custom bg-white" style="max-width: 500px;">
        <h2 class="text-center text-primary mb-4 fs-3">Editing Teachers</h2>
        
        <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            <div class="mb-3">
                <label class="form-label form-theme-label fw-bold">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name) }}">
                @error('name') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label form-theme-label fw-bold">Rank</label>
                <input type="text" name="rank" class="form-control" value="{{ old('rank', $teacher->rank) }}">
                @error('rank') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
    <label class="form-label form-theme-label fw-bold">Department</label>
    <select class="form-select form-control" name="department_id" id="department-select" required>
        @foreach($departments as $dept)
            <option value="{{ $dept->id }}" {{ old('department_id', $teacher->department_id) == $dept->id ? 'selected' : '' }}>
                {{ $dept->department_name }}
            </option>
        @endforeach
    </select>
    @error('department_id') 
        <div class="text-danger small mt-1">{{ $message }}</div> 
    @enderror
</div>

<div class="mb-3">
    <label class="form-label form-theme-label fw-bold">Courses (ပြင်ဆင်ရန်)</label>
    
    <div class="row ps-2" id="course-container" data-selected-courses="{{ json_encode(old('course_ids', $teacher->courses->pluck('id')->toArray())) }}">
        @foreach($courses as $course)
            <div class="col-md-6 form-check mb-2">
                <input class="form-check-input" 
                       type="checkbox" 
                       name="course_ids[]" 
                       value="{{ $course->id }}" 
                       id="edit_course_{{ $course->id }}"
                       {{ (is_array(old('course_ids')) && in_array($course->id, old('course_ids'))) || (!is_array(old('course_ids')) && $teacher->courses->contains($course->id)) ? 'checked' : '' }}>
                <label class="form-check-label text-secondary small" for="edit_course_{{ $course->id }}">
                    {{ $course->course_name }}
                </label>
            </div>
        @endforeach
    </div>
    @error('course_ids') 
        <div class="text-danger small mt-1">{{ $message }}</div> 
    @enderror
</div>

<script>
document.getElementById('department-select').addEventListener('change', function () {
    const departmentId = this.value;
    const courseContainer = document.getElementById('course-container');
    
    // မူလ ရွေးချယ်ထားခဲ့ဖူးသော Course ID များကို JSON ပြန်ဖြည်ယူခြင်း
    const selectedCourses = JSON.parse(courseContainer.getAttribute('data-selected-courses') || '[]');

    courseContainer.innerHTML = '<p class="text-muted small">Loading courses...</p>';

    if (!departmentId) return;

    // Controller ရဲ့ getCourses Method ဆီသို့ လှမ်းတောင်းခြင်း
    fetch(`/get-courses-by-dept/${departmentId}`)
        .then(response => response.json())
        .then(courses => {
            courseContainer.innerHTML = ''; // အဟောင်းများရှင်းထုတ်ရန်

            if (courses.length === 0) {
                courseContainer.innerHTML = '<p class="text-danger small">No courses found for this department.</p>';
                return;
            }

            courses.forEach(course => {
                // အသစ်ထွက်လာတဲ့ List ထဲမှာ ဆရာ/မ ရွေးထားဖူးတဲ့ ID ပါရင် Checked ပေးထားမည်
                const isChecked = selectedCourses.includes(course.id) ? 'checked' : '';

                const checkboxHtml = `
                    <div class="col-md-6 form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="course_ids[]" 
                               value="${course.id}" 
                               id="edit_course_${course.id}"
                               ${isChecked}>
                        <label class="form-check-label text-secondary small" for="edit_course_${course.id}">
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
                <label class="form-label form-theme-label fw-bold">Email</label>
                <input type="text" name="email" class="form-control" value="{{ old('email', $teacher->email) }}">
                @error('email') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label form-theme-label fw-bold">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}">
                @error('phone') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label form-theme-label fw-bold">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $teacher->address) }}">
                @error('address') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label form-theme-label fw-bold">Teacher Image</label>
                <div class="mb-2 text-center">
                    @if ($teacher->image)
                        <img src="{{ asset('image/' . $teacher->image) }}" id="preview-img" height="100" class="rounded shadow-sm">
                    @else
                        <img src="" id="preview-img" height="100" class="rounded shadow-sm d-none">
                    @endif
                </div>

                <div class="input-group">
                    <input type="file" name="image" id="image-input" class="form-control d-none" accept="image/*">
                    <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('image-input').click()">Choose File</button>
                    <input type="text" id="file-custom-text" class="form-control bg-white" 
                           value="{{ $teacher->image ? $teacher->image : 'No file chosen' }}" readonly style="cursor: pointer;"
                           onclick="document.getElementById('image-input').click()">
                </div>
                @error('image') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                <a href="/teacher/index" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('image-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const fileText = document.getElementById('file-custom-text');
            const previewImg = document.getElementById('preview-img');

            if (file) {
                fileText.value = file.name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>