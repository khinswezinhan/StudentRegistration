<x-app-layout>
    <style>
        .custom-theme-color {
            color: rgb(93, 79, 112) !important;
        }

        /* Table Wrapper Box Style */
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

        /* Create Button - မူလကတည်းက ခရမ်းရောင်အပြည့် ဖြစ်အောင် ပြင်ဆင်ထားပါတယ် */
        .btn-custom-solid {
            color: #ffffff !important; /* စာသားနှင့် အိုင်ကွန်ကို အဖြူရောင် ပေးထားပါတယ် */
            background-color: rgb(93, 79, 112) !important; /* မူလနောက်ခံကို ခရမ်းရောင် ထားပါတယ် */
            border: 1px solid rgb(93, 79, 112) !important;
            transition: all 0.2s ease;
        }
        
        /* Hover ဖြစ်သွားတဲ့အခါ ခရမ်းရောင် အနည်းငယ် ရင့်သွားစေပြီး ပိုပြီး ပေါ်လွင်စေပါတယ် */
        .btn-custom-solid:hover {
            background-color: rgb(75, 63, 91) !important; 
            border-color: rgb(75, 63, 91) !important;
            box-shadow: 0 4px 8px rgba(93, 79, 112, 0.2);
        }
    </style>

    <div class="mt-2 mb-4"> <a href="/user-create-form" class="text-decoration-none">
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
                    <th scope="col">Name</th>
                    <th scope="col">Class</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col" style="width: 160px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <th scope="row">{{ $student->id }}</th>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->class }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->address }}</td>
                        
                        <td>
                            <form method="post" action="{{ route('student.destroy', $student) }}" class="d-flex gap-2">
                                @csrf
                                @method('DELETE')
                                
                                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete?')">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button> 
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>