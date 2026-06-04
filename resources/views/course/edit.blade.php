<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            <h2 class="text-center mb-4 form-theme-title fs-3">Editing Content</h2>
            
            <form action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data" id="editCourseForm">
                @csrf
                @method('PUT') 
                
                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Course Name</label></b>
                    <input type="text" name="course_name" class="form-control" value="{{ $course->course_name }}" required>
                </div>

                <div class="mb-4">
                    <b><label class="form-label form-theme-label">Teacher Name</label></b>
                    <select class="form-select form-control" name="teacher_id" required>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <b><label class="form-label form-theme-label">Current Files</label></b>
                    <div class="mb-4">
                        @if($course->file && is_array($course->file) && count($course->file) > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($course->file as $singleFile)
                                    <div class="d-flex align-items-center bg-light border rounded px-3 py-2 shadow-sm" id="old-file-row-{{ $loop->index }}" style="border-color: rgba(93, 79, 112, 0.2) !important;">
                                        <a href="{{ asset('file/' . $singleFile) }}" target="_blank" class="text-decoration-none small me-3" style="color: rgb(93, 79, 112);">
                                            <i class="fa-solid fa-file-pdf me-2 text-danger"></i>{{ Str::limit($singleFile, 15) }}
                                        </a>
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 border-0 delete-old-file-btn" data-file-name="{{ $singleFile }}" data-row-id="old-file-row-{{ $loop->index }}" style="line-height: 1;">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted" id="no-old-file-text" style="font-size: 13px;">No file uploaded</span>
                        @endif
                    </div>

                    <b><label class="form-label form-theme-label">Upload New File (Multiple)</label></b>
                    <input type="file" name="files[]" id="fileInput" class="form-control" multiple>
                    
                    <div id="newFilesContainer" class="d-flex flex-wrap gap-2 mt-3" style="display: none;">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-custom-solid fw-medium py-2 flex-grow-1">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                    </button>
                    <a href="{{ route('course.index') }}" class="btn btn-secondary px-4 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.querySelectorAll('.delete-old-file-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this file from server?')) {
                const fileName = this.getAttribute('data-file-name');
                const rowId = this.getAttribute('data-row-id');
                const fileRow = document.getElementById(rowId);
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch("{{ route('course.file.delete', $course->id) }}", {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ file_name: fileName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fileRow.remove();
                        
                        const oldContainer = document.querySelector('.mb-4 .flex-wrap');
                        if (oldContainer && oldContainer.children.length === 0) {
                            oldContainer.parentElement.innerHTML = '<span class="text-muted" style="font-size: 13px;">No file uploaded</span>';
                        }
                    } else {
                        alert(data.message || 'Something went wrong!');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });

    const fileInput = document.getElementById('fileInput');
    const newFilesContainer = document.getElementById('newFilesContainer');
    let selectedFilesArray = [];

    fileInput.addEventListener('change', function() {
        const newFiles = Array.from(this.files);
        
        newFiles.forEach(file => {
            const isDuplicate = selectedFilesArray.some(f => f.name === file.name && f.size === file.size);
            if (!isDuplicate) {
                selectedFilesArray.push(file);
            }
        });

        updateNewFilesUI();
    });

    function updateNewFilesUI() {
        newFilesContainer.innerHTML = '';

        if (selectedFilesArray.length > 0) {
            newFilesContainer.style.display = 'flex';
            
            selectedFilesArray.forEach((file, index) => {
                const badge = document.createElement('div');
                badge.className = 'd-flex align-items-center bg-white border rounded px-3 py-2 shadow-sm';
                badge.style.borderColor = 'rgba(93, 79, 112, 0.4)';
                
                const fileNameShort = file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name;

                badge.innerHTML = `
                    <span class="small me-3" style="color: rgb(93, 79, 112);">
                        <i class="fa-solid fa-file me-2 text-primary"></i>${fileNameShort}
                    </span>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0 border-0" onclick="removeNewFileByIndex(${index})" style="line-height: 1;">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                `;
                newFilesContainer.appendChild(badge);
            });
        } else {
            newFilesContainer.style.display = 'none';
        }

        const dataTransfer = new DataTransfer();
        selectedFilesArray.forEach(file => {
            dataTransfer.items.add(file);
        });
        fileInput.files = dataTransfer.files;
    }

    function removeNewFileByIndex(indexToRemove) {
        selectedFilesArray.splice(indexToRemove, 1);
        updateNewFilesUI();
    }
</script>
</x-app-layout>