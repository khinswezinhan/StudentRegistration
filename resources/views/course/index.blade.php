<x-app-layout>
    <style>
        .custom-theme-color, .form-theme-label {
            color: rgb(93, 79, 112) !important;
        }

        /* Table Wrapper Box Style */
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

        /* Table Header Style */
        .table-custom-theme thead th {
            color: rgb(93, 79, 112) !important;
            background-color: rgba(93, 79, 112, 0.05) !important;
            border-bottom: 2px solid rgb(93, 79, 112) !important;
            font-weight: 600;
            padding: 15px 18px !important;
        }

        /* Table Body Style */
        .table-custom-theme tbody td, 
        .table-custom-theme tbody th {
            color: rgb(93, 79, 112) !important;
            vertical-align: middle;
            padding: 15px 18px !important;
            border-color: rgba(93, 79, 112, 0.15) !important;
        }

        /* Create Button */
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

        /* Filter Box Style */
        .filter-box {
            border: 1px solid rgb(93, 79, 112);
            border-radius: 10px;
            background-color: white;
        }
    </style>

    <div class="py-4">
        <div class="mt-2 mb-4"> 
            <a href="/course/create" class="text-decoration-none">
                <button type="button" class="btn btn-custom-solid fw-medium px-3 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Create New Course
                </button>
            </a>
        </div>

        @if($courses->isEmpty() && request('course_name'))
            
            <div class="filter-box p-4 mb-4 shadow-sm">
                <h5 class="custom-theme-color mb-3 fs-6 fw-bold">
                    <i class="fa-solid fa-filter me-2"></i> သင်တန်းများ ရှာဖွေရန်
                </h5>
                <form action="{{ url()->current() }}" method="GET" class="row g-3">
                    <div class="col-md-9">
                        <label class="form-label form-theme-label small fw-bold">Course Name</label>
                        <input type="text" name="course_name" class="form-control" placeholder="Search course name..." value="{{ request('course_name') }}">
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
                <p class="text-muted small mb-0">သင်ရှာဖွေလိုက်သော သင်တန်းအမည်နှင့် ကိုက်ညီသည့် Course ဒေတာ မရှိပါ။</p>
            </div>

        @elseif($courses->isEmpty())

            <div class="text-center my-4 p-5 bg-white rounded-4 shadow-sm" style="border: 1px dashed rgb(93, 79, 112);">
                <div class="mb-3 text-muted" style="font-size: 3rem;">
                    <i class="fa-solid fa-book-open text-secondary"></i>
                </div>
                <h4 class="custom-theme-color mb-2">Not yet create course list</h4>
                <p class="text-muted small mb-0">သင်တန်းစာရင်းများ လောလောဆယ် လုံးဝမရှိသေးပါသဖြင့် အပေါ်က "Create New Course" မှတစ်ဆင့် စတင်ထည့်သွင်းနိုင်ပါသည်</p>
            </div>

        @else

            <div class="filter-box p-4 mb-4 shadow-sm">
                <h5 class="custom-theme-color mb-3 fs-6 fw-bold">
                    <i class="fa-solid fa-filter me-2"></i> သင်တန်းများ ရှာဖွေရန်
                </h5>
                <form action="{{ url()->current() }}" method="GET" class="row g-3">
                    <div class="col-md-9">
                        <label class="form-label form-theme-label small fw-bold">Course Name</label>
                        <input type="text" name="course_name" class="form-control" placeholder="Search course name..." value="{{ request('course_name') }}">
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
                            <th scope="col">Course Name</th>
                            <th scope="col">Teachers' Name</th>
                            <th scope="col">Files</th>
                            <th scope="col" style="width: 160px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <th scope="row">{{ $course->id }}</th>
                                <td>{{ $course->course_name }}</td>
                                <td>{{ $course->teacher ? $course->teacher->name : 'No Teacher' }}</td>
                                
                                <td>
    @if($course->file && is_array($course->file) && count($course->file) > 0)
        <div class="d-flex flex-column gap-1">
            @foreach($course->file as $singleFile)
                @php
                    $cleanFileName = Str::after($singleFile, '_');

                    $ext = strtolower(pathinfo($singleFile, PATHINFO_EXTENSION));

                    switch($ext) {
                        case 'pdf':
                            $iconClass = 'fa-solid fa-file-pdf text-danger'; 
                            break;
                        case 'doc':
                        case 'docx':
                            $iconClass = 'fa-solid fa-file-word text-primary'; 
                            break;
                        case 'xls':
                        case 'xlsx':
                            $iconClass = 'fa-solid fa-file-excel text-success'; 
                            break;
                        case 'ppt':
                        case 'pptx':
                            $iconClass = 'fa-solid fa-file-powerpoint text-warning'; 
                            break;
                        case 'txt':
                            $iconClass = 'fa-solid fa-file-lines text-secondary'; 
                            break;
                        case 'png':
                        case 'jpg':
                        case 'jpeg':
                        case 'gif':
                        case 'webp':
                            $iconClass = 'fa-solid fa-file-image text-info'; 
                            break;
                        case 'mp4':
                        case 'mov':
                        case 'avi':
                        case 'mkv':
                            $iconClass = 'fa-solid fa-file-video text-dark'; 
                            break;
                        case 'mp3':
                        case 'wav':
                            $iconClass = 'fa-solid fa-file-audio text-purple';
                            break;
                        case 'zip':
                        case 'rar':
                            $iconClass = 'fa-solid fa-file-zipper text-muted'; 
                            break;
                        default:
                            $iconClass = 'fa-solid fa-file text-muted'; 
                @endphp
                <a href="{{ asset('file/' . $singleFile) }}" 
                   target="_blank" 
                   class="btn btn-sm btn-outline-secondary text-start text-truncate"
                   style="padding: 4px 8px; font-size: 12px; max-width: 240px;">
                     <i class="{{ $iconClass }} me-1"></i> {{ Str::limit($cleanFileName, 20) }}
                </a>
            @endforeach
        </div>
    @else
        <span class="text-muted" style="font-size: 13px;">No File</span>
    @endif
</td>
                                
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('course.edit', $course->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        
                                        <form method="post" action="{{ route('course.destroy', $course) }}" onsubmit="return confirm('Are you sure you want to delete?')">
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
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</x-app-layout>