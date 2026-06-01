<x-app-layout>
    <style>
        /* Form တစ်ခုလုံးကို ပတ်ထားတဲ့ Border ရဲ့ အရောင်ကို ခရမ်းရောင် ပြောင်းပါတယ် */
        .form-border-custom {
            border: 1px solid rgb(93, 79, 112) !important; /* border-2 ထက် ပိုပြီး သပ်ရပ်အောင် 1px ပြောင်းထားပါတယ် */
            box-shadow: 0 4px 12px rgba(93, 79, 112, 0.05);
        }

        /* ခေါင်းစဉ်နှင့် Label စာသားများကို ခရမ်းရောင် ပြောင်းပါတယ် */
        .form-theme-title {
            color: rgb(93, 79, 112) !important;
            font-weight: 600;
        }
        .form-theme-label {
            color: rgb(93, 79, 112) !important;
        }

        /* Input Box တွေကို နှိပ်လိုက်ရင် ခရမ်းရောင်အလင်းလိုင်းလေး ပြာသွားအောင် လုပ်တာပါ */
        .form-control:focus {
            border-color: rgb(93, 79, 112) !important;
            box-shadow: 0 0 0 0.25rem rgba(93, 79, 112, 0.25) !important;
        }

        /* Create Button - မူလထဲက ခရမ်းရောင်အပြည့် ဖြစ်စေဖို့ */
        .btn-custom-solid {
            color: #ffffff !important;
            background-color: rgb(93, 79, 112) !important;
            border: 1px solid rgb(93, 79, 112) !important;
            transition: all 0.2s ease;
        }
        
        /* Hover ဖြစ်ရင် အရောင်ရင့်သွားမယ့် Effect */
        .btn-custom-solid:hover {
            background-color: rgb(75, 63, 91) !important;
            border-color: rgb(75, 63, 91) !important;
            box-shadow: 0 4px 8px rgba(93, 79, 112, 0.2);
        }
    </style>

    <div class="py-4"> <form action="/student-create" method="POST">
            @csrf
            
            <div class="p-5 rounded-4 w-50 m-auto form-border-custom bg-white"> 
                
                <h2 class="text-center mb-4 form-theme-title fs-3">Create Student Content</h2>
                
                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Name</label></b>
                    <input class="form-control" type="text" name="name" required>
                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Class</label></b>
                    <input class="form-control" type="text" name="class" required>
                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Email</label></b>
                    <input class="form-control" type="email" name="email" required>
                </div>

                <div class="mb-3">
                    <b><label class="form-label form-theme-label">Phone Number</label></b>
                    <input class="form-control" type="text" name="phone">
                </div>

                <div class="mb-4"> <b><label class="form-label form-theme-label">Address</label></b>
                    <input class="form-control" type="text" name="address">
                </div>

                <div class="mb-2">
                    <button type="submit" class="btn btn-custom-solid form-control fw-medium py-2">
                        <i class="fa-solid fa-square-plus me-1"></i> Create
                    </button>
                </div>    
            </div>
        </form>
    </div>
</x-app-layout>