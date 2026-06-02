{{-- <x-app-layout>

    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center text-primary mb-4">Editing Content</h2>
        
        <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $teacher->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Rank</label>
                <input type="text" name="rank" class="form-control" value="{{ $teacher->rank }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{ $teacher->email }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $teacher->phone }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ $teacher->address }}">
            </div>

            
            <div class="mb-3">
                <label class="form-label">Image</label>
                @if ($teacher->image)
                            <div class="mb-2">
                                <img src="{{ asset('image/' . $teacher->image) }}" height="60"
                                    class="rounded">
                            </div>
                        @endif
                <input type="file" name="image" class="form-control" >
            </div>


            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="/" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app-layout> --}}