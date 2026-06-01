<x-app-layout>

    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center text-primary mb-4">Editing Content</h2>
        
        <form action="{{ route('student.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT') 
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $student->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Class</label>
                <input type="text" name="class" class="form-control" value="{{ $student->class }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{ $student->email }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $student->phone }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ $student->address }}">
            </div>

            

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="/" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app-layout>