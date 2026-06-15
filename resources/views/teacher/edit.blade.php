<x-app-layout>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center text-primary mb-4">Editing Content</h2>
        
        <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name) }}">
                @error('name') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Rank</label>
                <input type="text" name="rank" class="form-control" value="{{ old('rank', $teacher->rank) }}">
                @error('rank') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{ old('email', $teacher->email) }}">
                @error('email') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}">
                @error('phone') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $teacher->address) }}">
                @error('address') 
                    <div class="text-danger small mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Teacher Image</label>
                
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
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="/teacher/index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('image-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const fileText = document.getElementById('file-custom-text');
            const previewImg = document.getElementById('preview-img');

            if (file) {
                // ၁။ Input အကွက်ထဲက စာသားကို ရွေးလိုက်တဲ့ ဖိုင်အသစ်နာမည်နဲ့ လဲလိုက်မယ်
                fileText.value = file.name;

                // ၂။ အပေါ်က ရုပ်ပုံ Preview ကိုပါ ပုံအသစ်နဲ့ လဲပြမယ်
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('d-none'); // တကယ်လို့ ပုံမရှိခဲ့ရင်လည်း ပေါ်လာအောင်လုပ်တာ
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>