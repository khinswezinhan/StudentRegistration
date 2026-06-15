<x-app-layout>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center text-primary mb-4">Editing Content</h2>
         
        <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}">
                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Class</label>
                <input type="text" name="class" class="form-control" value="{{ old('class', $student->class) }}">
                @error('class') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{ old('email', $student->email) }}">
                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
                @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $student->address) }}">
                @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Upload your image</label>
                
                <div class="mb-2 text-center">
                    @if ($student->image)
                        <img src="{{ asset('image/' . $student->image) }}" id="preview-img" height="100" class="rounded shadow-sm">
                    @else
                        <img src="" id="preview-img" height="100" class="rounded shadow-sm d-none">
                    @endif
                </div>

                <div class="input-group">
                    <input type="file" name="image" id="image-input" class="form-control d-none" accept="image/*">
                    
                    <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('image-input').click()">Choose File</button>
                    
                    <input type="text" id="file-custom-text" class="form-control bg-white" 
                           value="{{ $student->image ? $student->image : 'No file chosen' }}" readonly style="cursor: pointer;"
                           onclick="document.getElementById('image-input').click()">
                </div>
                @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="/student/index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('image-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const fileText = document.getElementById('file-custom-text');
            const previewImg = document.getElementById('preview-img');

            if (file) {
                // ၁။ စာသားအကွက်ထဲမှာ ရွေးလိုက်တဲ့ ဖိုင်အသစ်နာမည်ကို လဲပြမယ်
                fileText.value = file.name;

                // ၂။ အပေါ်က ရုပ်ပုံ Preview ကိုပါ ပုံအသစ်ပြောင်းပေးမယ်
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