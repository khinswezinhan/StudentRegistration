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
        <div class="p-5 rounded-4 w-50 m-auto form-border-custom bg-white"> 
            <h2 class="text-center mb-4 form-theme-title fs-3">Create Course</h2>
            
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data" id="courseForm">
                @csrf
                
                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Course Name</label></b>
                    <input type="text" name="course_name" class="form-control" placeholder="Distributed System" value="{{ old('course_name') }}" required>
                    
                    @error('course_name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <b><label for="class_model_id" class="form-label form-theme-label">Class</label></b>
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
                    <b><label for="department_id" class="form-label form-theme-label">Department</label></b>
                    <select name="department_id" id="department_id" class="form-select text-secondary" required>
                        <option value="">Select Department</option>
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
                    <b><label class="form-label form-theme-label">Upload files (Multiple)</label></b>
                    <input type="file" name="files[]" id="fileInput" class="form-control" multiple>
                    
                    @error('files')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <div id="selectedFilesContainer" class="d-flex flex-wrap gap-2 mt-3" style="display: none;">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-custom-solid fw-medium py-2 flex-grow-1">
                        <i class="fa-solid fa-plus me-1"></i> Create Course
                    </button>
                    <a href="{{ route('course.index') }}" class="btn btn-secondary px-4 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const container = document.getElementById('selectedFilesContainer');
        
        let selectedFilesArray = [];

        fileInput.addEventListener('change', function() {
            const newFiles = Array.from(this.files);
            
            newFiles.forEach(file => {
                const isDuplicate = selectedFilesArray.some(f => f.name === file.name && f.size === file.size);
                if (!isDuplicate) {
                    selectedFilesArray.push(file);
                }
            });

            updateFilesUIAndInput();
        });

        function updateFilesUIAndInput() {
            container.innerHTML = '';

            if (selectedFilesArray.length > 0) {
                container.style.display = 'flex';
                
                selectedFilesArray.forEach((file, index) => {
                    const badge = document.createElement('div');
                    badge.className = 'd-flex align-items-center bg-light border rounded px-3 py-2 shadow-sm';
                    badge.style.borderColor = 'rgba(93, 79, 112, 0.2)';
                    
                    const fileNameShort = file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name;

                    badge.innerHTML = `
                        <span class="small me-3" style="color: rgb(93, 79, 112);">
                            <i class="fa-solid fa-file me-2 text-secondary"></i>${fileNameShort}
                        </span>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 border-0" onclick="removeFileByIndex(${index})" style="line-height: 1;">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    `;
                    container.appendChild(badge);
                });
            } else {
                container.style.display = 'none';
            }

            const dataTransfer = new DataTransfer();
            selectedFilesArray.forEach(file => {
                dataTransfer.items.add(file);
            });
            fileInput.files = dataTransfer.files; 
        }

        function removeFileByIndex(indexToRemove) {
            selectedFilesArray.splice(indexToRemove, 1);
            updateFilesUIAndInput();
        }
    </script>
</x-app-layout>