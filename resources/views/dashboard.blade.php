<x-app-layout>
    <style>
        .stat-card-custom {
            background-color: transparent !important;
            border: 1px solid rgb(93, 79, 112) !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            color: rgb(93, 79, 112) !important;
            transition: all 0.2s ease;
        }
        
        .stat-card-custom:hover {
            transform: translateY(-3px);
            background-color: rgba(93, 79, 112, 0.05) !important; 
            box-shadow: 0 6px 12px rgba(93, 79, 112, 0.1);
        }
        
        .stat-card-inner {
            display: flex !important;
            align-items: center !important;
            padding: 1.2rem 1rem !important; /* Padding ကို နည်းနည်းကျစ်လျစ်အောင် လျှော့ထားပါတယ် */
        }
        
        .stat-icon-style {
            font-size: 2rem !important; /* Icon size ကို 2.5 ကနေ 2 ကို လျှော့ပါတယ် */
            color: rgb(93, 79, 112) !important;
            opacity: 0.9;
            margin-right: 12px;
            flex-shrink: 0; /* Icon ပုံစံ ပျက်မသွားအောင် ထိန်းထားတာပါ */
        }

        .stat-info-area {
            flex-grow: 1;
            min-width: 0; /* စာသားတွေ overflow ဖြစ်တာ ကာကွယ်ဖို့ */
        }

        .stat-label {
            font-size: 0.85rem; /* စာသား size လျှော့ထားပါတယ် */
            margin-bottom: 2px;
            white-space: nowrap; /* စာလုံးကို အောက်ကြောင်းမဆင်းဘဲ တစ်တန်းတည်းရှိနေစေဖို့ */
            overflow: hidden;
            text-overflow: ellipsis; /* တကယ်လို့ အရမ်းရှည်ရင် ... ပြပေးဖို့ */
        }

        .stat-number {
            font-size: 1.5rem !important; /* ဂဏန်း size ကို 1.75 ကနေ 1.5 ကို လျှော့ပါတယ် */
            margin-bottom: 0;
        }
    </style>

    <div class="py-3">
        
        <div class="row g-3 mb-4"> <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card stat-card-custom">
                    <div class="stat-card-inner">
                        <i class="fa-solid fa-users stat-icon-style"></i>
                        <div class="stat-info-area">
                            <p class="stat-label text-muted fw-normal">User Registration</p>
                            <h3 class="stat-number fw-bold">{{ $users->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card stat-card-custom">
                    <div class="stat-card-inner">
                        <i class="fa-solid fa-book-reader stat-icon-style"></i>
                        <div class="stat-info-area">
                            <p class="stat-label text-muted fw-normal">Students</p>
                            <h3 class="stat-number fw-bold">{{ $students->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card stat-card-custom">
                    <div class="stat-card-inner">
                        <i class="fa-solid fa-chalkboard-teacher stat-icon-style"></i>
                        <div class="stat-info-area">
                            <p class="stat-label text-muted fw-normal">Teachers</p>
                            <h3 class="stat-number fw-bold">{{ $teachers->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card stat-card-custom">
                    <div class="stat-card-inner">
                        <i class="fa-solid fa-circle-check stat-icon-style"></i>
                        <div class="stat-info-area">
                            <p class="stat-label text-muted fw-normal">Course</p>
                            <h3 class="stat-number fw-bold">576</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>