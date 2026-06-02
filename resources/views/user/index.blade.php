{{-- <x-app-layout>
    <style>
        .custom-theme-color {
            color: rgb(93, 79, 112) !important;
        }

        /* Table တစ်ခုလုံးကို ပတ်ပြီး ထောင့်ကွေးပေးမယ့် Wrapper */
        .table-responsive-custom {
            border: 1px solid rgb(93, 79, 112) !important;
            border-radius: 10px !important;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(93, 79, 112, 0.05);
        }

        .table-custom-theme {
            margin-bottom: 0 !important;
            border: none !important;
        }

        /* Table Header (ခေါင်းစဉ်တန်း) ခရမ်းရောင်နောက်ခံနှင့် စာသား */
        .table-custom-theme thead th {
            color: rgb(93, 79, 112) !important;
            background-color: rgba(93, 79, 112, 0.05) !important;
            border-bottom: 2px solid rgb(93, 79, 112) !important;
            font-weight: 600;
            padding: 15px 18px !important; /* စာသားနှင့် ဘောင်ကြား ခွာရန် Padding */
        }

        /* Table Body (အထဲကစာသားများ) ကို ခရမ်းရောင်ပြောင်းပြီး Padding တိုးထားပါတယ် */
        .table-custom-theme tbody td, 
        .table-custom-theme tbody th {
            color: rgb(93, 79, 112) !important;
            vertical-align: middle;
            padding: 15px 18px !important;
            border-color: rgba(93, 79, 112, 0.15) !important;
        }

        /* Create Button - မူလကတည်းက ခရမ်းရောင်အပြည့် */
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

    <div class="mt-2 mb-4">
        <a href="/user-create" class="text-decoration-none">
            <button type="button" class="btn btn-custom-solid fw-medium px-3 py-2">
                <i class="fa-solid fa-plus me-1"></i> Create New Content
            </button>
        </a>
    </div>

    <div class="table-responsive-custom">
        <table class="table table-striped-columns table-custom-theme">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Rank</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col" style="width: 160px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                    <tr>
                        <th scope="row">{{ $teacher->id }}</th>
                        <td>
                           @if($teacher->image)
                               
                        <img src="/image/{{ $teacher->image }}"
                            width="80">
                      @else
                                <span class="text-muted" style="font-size: 13px;">No Image</span>
                            @endif
                        </td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->rank }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>{{ $teacher->phone }}</td>
                        <td>{{ $teacher->address }}</td>
                        
                        <td>
                            <form method="post" action="{{ route('teacher.destroy', $teacher) }}" class="d-flex gap-2">
                                @csrf
                                @method('DELETE')
                                
                                <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this teacher?')">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button> 
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout> --}}