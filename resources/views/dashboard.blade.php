<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Statistics Card Styles */
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
            padding: 1.2rem 1rem !important; 
        }
        
        .stat-icon-style {
            font-size: 2rem !important;
            color: rgb(93, 79, 112) !important;
            opacity: 0.9;
            margin-right: 12px;
            flex-shrink: 0; 
        }

        .stat-info-area {
            flex-grow: 1;
            min-width: 0; 
        }

        .stat-label {
            font-size: 0.85rem; 
            margin-bottom: 2px;
            white-space: nowrap; 
            overflow: hidden;
            text-overflow: ellipsis; 
        }

        .stat-number {
            font-size: 1.5rem !important;
            margin-bottom: 0;
        }

        /* Chart Area Card Styles */
        .chart-container-custom {
            background-color: #ffffff;
            border: 1px solid rgb(93, 79, 112) !important;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(93, 79, 112, 0.03);
        }
    </style>

    <div class="py-3 px-4">
        
        <div class="row g-3 mb-4"> 
            
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
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
                            <h3 class="stat-number fw-bold">{{ $courses->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-3">
            
            <div class="col-12 col-md-6">
                <div class="card chart-container-custom p-4">
                    <h3 class="fs-5 mb-4 fw-bold" style="color: rgb(93, 79, 112);">Academic Population</h3>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="academicChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card chart-container-custom p-4">
                    <h3 class="fs-5 mb-4 fw-bold" style="color: rgb(93, 79, 112);">Courses by Department</h3>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="courseChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // =========================================================
            // 📊 CHART 1 Configuration: Students & Teachers
            // =========================================================
            const ctx1 = document.getElementById('academicChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Students', 'Teachers'],
                    datasets: [{
                        label: 'Total People',
                        data: [{{ $students->count() }}, {{ $teachers->count() }}],
                        backgroundColor: [
                            'rgba(93, 79, 112, 0.85)', // Students (Theme Main Color)
                            'rgba(141, 124, 165, 0.85)'  // Teachers (Theme Accent Color)
                        ],
                        borderColor: [
                            'rgb(93, 79, 112)',
                            'rgb(141, 124, 165)'
                        ],
                        borderWidth: 1,
                        borderRadius: 5,
                        barThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false } // Dataset Label ကို ဖျောက်ထားမယ်
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            ticks: { stepSize: 1, color: 'rgb(93, 79, 112)' }, 
                            grid: { color: 'rgba(93, 79, 112, 0.05)' } 
                        },
                        x: { 
                            ticks: { color: 'rgb(93, 79, 112)', font: { weight: '500' } }, 
                            grid: { display: false } 
                        }
                    }
                }
            });


            // =========================================================
            // 📊 CHART 2 Configuration: Courses by Department
            // =========================================================
            const ctx2 = document.getElementById('courseChart').getContext('2d');
            
            // Controller မှပေးလိုက်သော Dynamic Department data များကို ယူခြင်း
            const deptLabels = {!! json_encode($deptLabels ?? []) !!};
            const deptData = {!! json_encode($deptData ?? []) !!};

            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: deptLabels, // ဌာနနာမည်များ ပေါ်လာမည်
                    datasets: [{
                        label: 'Total Courses',
                        data: deptData, // ဌာနအလိုက် Course အရေအတွက်
                        backgroundColor: 'rgba(93, 79, 112, 0.85)', 
                        borderColor: 'rgb(93, 79, 112)',
                        borderWidth: 1,
                        borderRadius: 5,
                        barThickness: 35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            ticks: { stepSize: 1, color: 'rgb(93, 79, 112)' }, 
                            grid: { color: 'rgba(93, 79, 112, 0.05)' } 
                        },
                        x: { 
                            ticks: { color: 'rgb(93, 79, 112)', font: { weight: '500' } }, 
                            grid: { display: false } 
                        }
                    }
                }
            });

        });
    </script>
</x-app-layout>