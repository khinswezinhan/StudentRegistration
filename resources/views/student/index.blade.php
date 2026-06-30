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

        .truncated-email {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
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

    <div class="mt-2 mb-4"> 
        <a href="{{ route('student.create') }}" class="text-decoration-none">
            <button type="button" class="btn btn-success fw-medium px-3 py-2">
                <i class="fa-solid fa-plus me-1"></i> Create New Students
            </button>
        </a>
    </div>

    @if(!$students->isEmpty() || (request('name') || request('class_model_id')))
        <div class="filter-box p-4 mb-4 shadow-sm">
            <h5 class="custom-theme-color mb-3 fs-6 fw-bold">
                <i class="fa-solid fa-filter me-2"></i> ကျောင်းသားများ ရှာဖွေရန်
            </h5>
            <form action="{{ url()->current() }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label form-theme-label small fw-bold">Student Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Search student name..." value="{{ request('name') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label form-theme-label small fw-bold">Class</label>
                    <select name="class_model_id" class="form-select text-secondary">
                        <option value="">-- All Classes --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_model_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-success w-100 py-2">Search</button>
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary px-3 py-2">Clear</a>
                </div>
            </form>
        </div>
    @endif

    @if($students->isEmpty() && (request('name') || request('class_model_id')))
        
        <div class="text-center my-4 p-5 bg-white rounded-4 shadow-sm" style="border: 1px solid rgba(220, 53, 69, 0.2);">
            <div class="mb-3 text-danger" style="font-size: 3rem;">
                <i class="fa-solid fa-magnifying-glass-blur"></i>
            </div>
            <h4 class="text-danger mb-2">No matching results found</h4>
            <p class="text-muted small mb-0">နင်ရှာဖွေလိုက်တဲ့ အမည် သို့မဟုတ် အတန်းနှင့် ကိုက်ညီသော ကျောင်းသားဒေတာ မရှိပါဘူးဗျာ။ စာသားအမှန် ပြန်ရိုက်ပြီး ရှာကြည့်ပေးပါဦး။</p>
        </div>

    @elseif($students->isEmpty())

        <div class="text-center my-4 p-5 bg-white rounded-4 shadow-sm" style="border: 1px dashed rgb(93, 79, 112);">
            <div class="mb-3 text-muted" style="font-size: 3rem;">
                <i class="fa-solid fa-graduation-cap text-secondary"></i>
            </div>
            <h4 class="custom-theme-color mb-2">Not yet create student list</h4>
            <p class="text-muted small mb-0">ကျောင်းသားစာရင်းများ လုံးဝမရှိသေးပါသဖြင့် အပေါ်က "Create New Students" မှတစ်ဆင့် စတင်ထည့်သွင်းနိုင်ပါသည်</p>
        </div>

    @else

        <div class="table-responsive-custom">
            <table class="table table-striped table-hover table-custom-theme">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col" style="width: 120px;">Name</th>
                        <th scope="col">Class</th>
                        <th scope="col">Courses</th> 
                        <th scope="col">Email</th> 
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <th scope="row">{{ $students->firstItem() + $loop->index }}</th>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->classModel ? $student->classModel->name : 'N/A' }}</td>
                            <td>
                                @if($student->classModel && $student->classModel->courses->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($student->classModel->courses as $course)
                                            <span>
                                                {{ $course->course_name }}{{ !$loop->last ? ', ' : '' }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted small">No Course</span>
                                @endif
                            </td>
                            <td class="truncated-email" title="{{ $student->email }}">{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->status }}</td>
                            <td>
                                @if($student->image)
                                    <img src="/image/{{ $student->image }}" width="80" class="rounded">
                                @else
                                    <span class="text-muted" style="font-size: 13px;">No Image</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    
                                        <a href="{{ route('student.edit', $student->id)}}" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-warning"></i> 
                                        </a>
                                        
                                        <form method="post" action="{{ route('student.destroy', $student) }}" onsubmit="return confirm('Are you sure you want to delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0 border-0 bg-transparent">
                                                <i class="fa-solid fa-trash text-danger" title="Delete"></i> 
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
            {{ $students->appends(request()->all())->links() }}
        </div>

    @endif
</x-app-layout>