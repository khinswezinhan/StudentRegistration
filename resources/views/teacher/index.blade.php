<x-app-layout>
    <style>
        .custom-theme-color, .form-theme-label {
            color: rgb(93, 79, 112) !important;
        }

        .table-responsive-custom {
            border: 1px solid rgb(93, 79, 112) !important;
            border-radius: 10px !important;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(93, 79, 112, 0.05);
            background-color: white;
        }

        .table-custom-theme {
            margin-bottom: 0 !important;
            border: none !important;
        }

        .table-custom-theme thead th {
            color: rgb(93, 79, 112) !important;
            background-color: rgba(93, 79, 112, 0.05) !important;
            border-bottom: 2px solid rgb(93, 79, 112) !important;
            font-weight: 600;
            padding: 15px 18px !important;
        }

        .table-custom-theme tbody td, 
        .table-custom-theme tbody th {
            color: rgb(93, 79, 112) !important;
            vertical-align: middle;
            padding: 15px 18px !important;
            border-color: rgba(93, 79, 112, 0.15) !important;
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

        .filter-box {
            border: 1px solid rgb(93, 79, 112);
            border-radius: 10px;
            background-color: white;
        }
    </style>

    <div class="py-4">
        <div class="mt-2 mb-4">
            <a href="/user-create" class="text-decoration-none">
                <button type="button" class="btn btn-custom-solid fw-medium px-3 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Create New Teacher's content
                </button>
            </a>
        </div>

        @if($teachers->isEmpty() && (request('name') || request('rank')))
            
            {{-- 🔍 အခြေအနေ ၁ - ရှာဖွေလိုက်လို့ ရလဒ်မတွေ့တဲ့အချိန် --}}
            <div class="filter-box p-4 mb-4 shadow-sm">
                <h5 class="custom-theme-color mb-3 fs-6 fw-bold">
                    <i class="fa-solid fa-filter me-2"></i> ဆရာ/မများ ရှာဖွေရန်
                </h5>
                <form action="{{ url()->current() }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label form-theme-label small fw-bold">Teacher Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Search teacher name..." value="{{ request('name') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label form-theme-label small fw-bold">Rank / Position</label>
                        <input type="text" name="rank" class="form-control" placeholder="Search rank..." value="{{ request('rank') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-custom-solid w-100 py-2">Filter</button>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary px-3 py-2">Clear</a>
                    </div>
                </form>
            </div>

            <div class="text-center my-4 p-5 bg-white rounded-4 shadow-sm" style="border: 1px solid rgba(220, 53, 69, 0.2);">
                <div class="mb-3 text-danger" style="font-size: 3rem;">
                    <i class="fa-solid fa-magnifying-glass-blur"></i>
                </div>
                <h4 class="text-danger mb-2">No matching results found</h4>
                <p class="text-muted small mb-0">နင်ရှာဖွေလိုက်တဲ့ အမည် သို့မဟုတ် ရာထူးနှင့် ကိုက်ညီသော ဆရာ/မ ဒေတာ မရှိပါဘူးဗျာ။</p>
            </div>

        @elseif($teachers->isEmpty())

            {{-- 📁 အခြေအနေ ၂ - Database ထဲမှာ ဒေတာ လုံးဝ မရှိသေးတဲ့အချိန် --}}
            <div class="text-center my-4 p-5 bg-white rounded-4 shadow-sm" style="border: 1px dashed rgb(93, 79, 112);">
                <div class="mb-3 text-muted" style="font-size: 3rem;">
                    <i class="fa-solid fa-folder-open text-secondary"></i>
                </div>
                <h4 class="custom-theme-color mb-2">Not yet create teacher list</h4>
                <p class="text-muted small mb-0">ဆရာ/မ စာရင်းများ လောလောဆယ် လုံးဝမရှိသေးပါသဖြင့် အပေါ်က "Create New Content" မှတစ်ဆင့် စတင်ထည့်သွင်းနိုင်ပါသည်</p>
            </div>

        @else

            <div class="filter-box p-4 mb-4 shadow-sm">
                <h5 class="custom-theme-color mb-3 fs-6 fw-bold">
                    <i class="fa-solid fa-filter me-2"></i> ဆရာ/မများ ရှာဖွေရန်
                </h5>
                <form action="{{ url()->current() }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label form-theme-label small fw-bold">Teacher Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Search teacher name..." value="{{ request('name') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label form-theme-label small fw-bold">Rank / Position</label>
                        <input type="text" name="rank" class="form-control" placeholder="Search rank..." value="{{ request('rank') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-custom-solid w-100 py-2">Filter</button>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary px-3 py-2">Clear</a>
                    </div>
                </form>
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
                                        <img src="/image/{{ $teacher->image }}" width="80" class="rounded">
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
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        
                                        <form method="post" action="{{ route('teacher.destroy', $teacher) }}" onsubmit="return confirm('Are you sure you want to delete this teacher?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button> 
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
</x-app-layout>