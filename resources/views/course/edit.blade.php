<x-app-layout>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center text-primary mb-4">Editing Content</h2>
        
        <form action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 
            
            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input type="text" name="course_name" class="form-control" value="{{ $course->course_name }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Teacher Name</label>
                <select class="form-select form-control" name="teacher_id" required>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Current File</label>
                <div class="mb-2">
                    @if($course->file)
                        <a href="{{ asset('file/' . $course->file) }}" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="fa-solid fa-file"></i> View Current File
                        </a>
                    @else
                        <span class="text-muted" style="font-size: 13px;">No file uploaded</span>
                    @endif
                </div>

                <label class="form-label">Upload New File</label>
                <input type="file" name="file" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('course.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app-layout>