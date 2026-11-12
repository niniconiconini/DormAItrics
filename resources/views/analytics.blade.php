{{-- <x-layout>
    <x-slot:title>Analytics</x-slot:title>    
    <header class="page-title">ANALYTICS</header>
    <section>
        <div class="flex-view">
            <div class="card analytics-card">
                <h3>Total Residents</h3>
                <h1>{{ $demographicsTrend['total_residents'] }}</h1>
            </div>
            <div class="card analytics-card">
                <h3>Total Rooms</h3>
                <h1>{{ $occupancyTrend['total_rooms'] }}</h1>
            </div>
            <div class="card analytics-card">
                <h3>Total Capacity</h3>
                <h1>{{ $occupancyTrend['total_capacity'] }}</h1>
            </div>
            <div class="card analytics-card">
                <h3>Occupied Slots</h3>
                <h1>{{ $occupancyTrend['occupied_slots'] }}</h1>
            </div>
            <div class="card analytics-card">
                <h3>Available Slots</h3>
                <h1>{{ $occupancyTrend['available_slots'] }}</h1>
            </div>
        </div>
        <div class="flex-view">
            <div class="card" style="width: 400px;">
                <h3 style="text-align: center;">Gender of Residents</h3>
                <div style="height: 300px;">
                    <canvas id="demographicsChart_gender"></canvas>
                </div>
            </div>
            <div class="card" style="width: 400px;">
                <h3 style="text-align: center;">Accommodation type of Residents</h3>
                <div style="height: 300px;">
                    <canvas id="demographicsChart_accommodation"></canvas>
                </div>
            </div>
            <div class="card" style="width: 400px;">
                <h3 style="text-align: center;">Resident type of Residents</h3>
                <div style="height: 300px;">
                    <canvas id="demographicsChart_resident"></canvas>
                </div>
            </div>
        </div>
        <div class="flex-view">
            <div class="card" style="width: 600px;">
                <h3 style="text-align: center;">Monthly Resident Check-ins</h3>
                <div style="height: 300px;">
                    <canvas id="checkInsChart"></canvas>
                </div>
            </div>
            <div class="card" style="width: 600px;">
                <h3 style="text-align: center;">Monthly Resident Check-outs</h3>
                <div style="height: 300px;">
                    <canvas id="checkInsChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const genderData = @json($demographicsTrend['gender']);
        console.log(genderData);
        new Chart(
            document.getElementById('demographicsChart_gender'),
            {
                type: 'doughnut',
                data: {
                    labels: genderData.map(item => item.gender),
                    datasets: [{
                        data: genderData.map(item => item.count)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        );
        </script>
        <script>
        const accommodationData = @json($demographicsTrend['accommodation_type']);
        console.log(accommodationData);
        new Chart(
            document.getElementById('demographicsChart_accommodation'),
            {
                type: 'doughnut',
                data: {
                    labels: accommodationData.map(item => item.accommodation_type),
                    datasets: [{
                        data: accommodationData.map(item => item.count)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        );
        </script>
        <script>
        const residentData = @json($demographicsTrend['resident_type']);
        console.log(residentData);
        new Chart(
            document.getElementById('demographicsChart_resident'),
            {
                type: 'doughnut',
                data: {
                    labels: residentData.map(item => item.resident_type),
                    datasets: [{
                        data: residentData.map(item => item.count)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        );
        </script>
        <script>
            const checkInData = @json($checkInTrend);
            new Chart(
                document.getElementById('checkInsChart'),
                {
                    type: 'bar',
                    data: {
                        labels: checkInData.map(
                            item => `${item.month}/${item.year}`
                        ),
                        datasets: [{
                            label: 'Check-Ins',
                            data: checkInData.map(
                                item => item.count
                            )
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                }
            );
        </script>
</x-layout> --}}

<x-layout>
    <x-slot:title>Analytics</x-slot:title>
    <header class="page-title">ANALYTICS</header>
    <section class="analytics-container">
        {{-- A. FACILITY OVERVIEW --}}
        <div class="analytics-section">
            <div class="section-heading">
                <h3>A. Facility Overview</h3>
                <span class="status-badge">Summary</span>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">♧ Total Residents</span>
                    <h2>{{ $demographicsTrend['total_residents'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total Rooms</span>
                    <h2>{{ $occupancyTrend['total_rooms'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total Capacity</span>
                    <h2>{{ $occupancyTrend['total_capacity'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Occupied Slots</span>
                    <h2>{{ $occupancyTrend['occupied_slots'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Available Slots</span>
                    <h2>{{ $occupancyTrend['available_slots'] }}</h2>
                </div>
                {{-- <div class="stat-item">
                    <span class="stat-label">Occupancy Rate</span>
                    <h2>{{ $occupancyTrend['occupancy_rate'] }}%</h2>
                </div> --}}
            </div>
            <p class="analytics-note">
                Based on current facility records.
            </p>
        </div>


        {{-- B. DAILY FACIAL RECOGNITION ACTIVITY --}}
        <div class="analytics-section">
            <h3>B. Daily Facial Recognition Activity</h3>
            <div class="stats-grid activity-stats">
                <div class="stat-item">
                    <span class="stat-label">Daily Time Out</span>
                    <h2 class="text-orange">
                        {{ $dailyAttendance['time_out'] }}
                    </h2>
                    <span class="activity-badge departure">Departures</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Daily Time In</span>
                    <h2 class="text-green">
                        {{ $dailyAttendance['time_in'] }}
                    </h2>
                    <span class="activity-badge returns">Returns</span>
                </div>
            </div>
            <h4 class="chart-heading">Daily Activity Trend</h4>
            <div class="activity-chart">
                <canvas id="weeklyActivityChart"></canvas>
            </div>
            <p class="analytics-note">
                Weekly resident departure and return activity.
            </p>
        </div>

        {{-- C. RESIDENT DEMOGRAPHICS --}}
        <div class="analytics-section">
            <h3>D. Resident Demographics</h3>

            <div class="demographics-grid">
                <div class="demographics-chart">
                    <h4>Gender of Residents</h4>
                    <canvas id="demographicsChart_gender"></canvas>
                </div>
                <div class="demographics-chart">
                    <h4>Accommodation Type</h4>
                    <canvas id="demographicsChart_accommodation"></canvas>
                </div>
                <div class="demographics-chart">
                    <h4>Resident Type</h4>
                    <canvas id="demographicsChart_resident"></canvas>
                </div>
            </div>
        </div>

        {{-- D. RESIDENT CHECK-IN / CHECK-OUT TRENDS --}}
        <div class="analytics-section">
            <h3>E. Resident Check-in and Check-out Trends</h3>

            <div class="monthly-grid">
                <div>
                    <h4 class="chart-heading">Monthly Check-ins</h4>
                    <div class="monthly-chart">
                        <canvas id="checkInsChart"></canvas>
                    </div>
                </div>

                <div>
                    <h4 class="chart-heading">Monthly Check-outs</h4>
                    <div class="monthly-chart">
                        <canvas id="checkOutsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- CHARTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Shared options
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false
        };

        // Weekly facial recognition activity
        const weeklyData = @json($weeklyActivity);
        new Chart(document.getElementById('weeklyActivityChart'), {
            type: 'bar',
            data: {
                labels: weeklyData.map(item => item.day),
                datasets: [
                    {
                        label: 'Time Out',
                        data: weeklyData.map(item => item.time_out),
                        backgroundColor: '#5799f5',
                        borderRadius: 5
                    },
                    {
                        label: 'Time In',
                        data: weeklyData.map(item => item.time_in),
                        backgroundColor: '#6bc580',
                        borderRadius: 5
                    }
                ]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            borderDash: [3, 3]
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Gender demographics
        const genderData = @json($demographicsTrend['gender']);
        new Chart(document.getElementById('demographicsChart_gender'), {
            type: 'doughnut',
            data: {
                labels: genderData.map(item => item.gender ?? 'Unspecified'),
                datasets: [{
                    data: genderData.map(item => item.count)
                }]
            },
            options: commonOptions
        });

        // Accommodation demographics
        const accommodationData = @json($demographicsTrend['accommodation_type']);
        new Chart(document.getElementById('demographicsChart_accommodation'), {
            type: 'doughnut',
            data: {
                labels: accommodationData.map(item =>
                    item.accommodation_type ?? 'Unspecified'
                ),
                datasets: [{
                    data: accommodationData.map(item => item.count)
                }]
            },
            options: commonOptions
        });

        // Resident type demographics
        const residentData = @json($demographicsTrend['resident_type']);
        new Chart(document.getElementById('demographicsChart_resident'), {
            type: 'doughnut',
            data: {
                labels: residentData.map(item =>
                    item.resident_type ?? 'Unspecified'
                ),
                datasets: [{
                    data: residentData.map(item => item.count)
                }]
            },
            options: commonOptions
        });

        // Monthly check-ins
        const checkInData = @json($checkInTrend);
        new Chart(document.getElementById('checkInsChart'), {
            type: 'bar',
            data: {
                labels: checkInData.map(item =>
                    new Date(item.year, item.month - 1)
                        .toLocaleString('en-US', {
                            month: 'short',
                            year: 'numeric'
                        })
                ),
                datasets: [{
                    label: 'Check-ins',
                    data: checkInData.map(item => item.count),
                    backgroundColor: '#5799f5',
                    borderRadius: 5
                }]
            },
            options: commonOptions
        });

        // Monthly check-outs
        const checkOutData = @json($checkOutTrend);
        new Chart(document.getElementById('checkOutsChart'), {
            type: 'bar',
            data: {
                labels: checkOutData.map(item =>
                    new Date(item.year, item.month - 1)
                        .toLocaleString('en-US', {
                            month: 'short',
                            year: 'numeric'
                        })
                ),
                datasets: [{
                    label: 'Check-outs',
                    data: checkOutData.map(item => item.count),
                    backgroundColor: '#6bc580',
                    borderRadius: 5
                }]
            },
            options: commonOptions
        });
    </script>

    {{-- ANALYTICS STYLING --}}
    <style>
        .analytics-container {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            padding: 10px 0;
            width: 100%;
            max-width: 100%;
        }

        .analytics-section {
            background: #fff;
            border: 1px solid #dedede;
            border-radius: 16px;
            padding: 20px;
            flex: 1 1 calc(50% - 18px);
            min-width: 350px;
            width: auto;
            box-sizing: border-box;
        }

        .analytics-section h3 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #222;
        }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-heading h3 {
            margin-bottom: 20px;
        }

        .status-badge {
            background: #d9f5e3;
            color: #16834a;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            row-gap: 28px;
            column-gap: 30px;
            padding: 5px 10px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .stat-label {
            font-size: 11px;
            color: #777;
        }

        .stat-item h2 {
            font-size: 23px;
            font-weight: 500;
            color: #176b4a;
            margin: 0;
        }

        .text-orange {
            color: #c77a13 !important;
        }

        .text-green {
            color: #218653 !important;
        }

        .activity-badge {
            width: fit-content;
            font-size: 11px;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .departure {
            background: #fce5d9;
            color: #a53b0d;
        }

        .returns {
            background: #d9f5e3;
            color: #16834a;
        }

        .activity-chart {
            height: 350px;
            padding: 5px 5px 0;
        }

        .pass-slip-chart {
            height: 350px;
            max-width: 400px;
            margin: 25px auto 0;
        }

        .chart-heading {
            font-size: 13px;
            font-weight: 600;
            margin: 25px 0 12px;
            color: #333;
        }

        .analytics-note {
            font-size: 11px;
            color: #888;
            margin-top: 15px;
            margin-bottom: 0;
        }

        .demographics-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .demographics-chart {
            height: 280px;
            text-align: center;
        }

        .demographics-chart h4 {
            font-size: 13px;
            margin-bottom: 15px;
        }

        .monthly-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 25px;
        }

        .monthly-chart {
            height: 280px;
        }

        @media (max-width: 768px) {
            .demographics-grid {
                grid-template-columns: 1fr;
            }

            .monthly-grid {
                grid-template-columns: 1fr;
            }

            .analytics-section {
                padding: 15px;
            }
        }
    </style>

</x-layout>
