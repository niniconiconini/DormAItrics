<x-layout>
    <x-slot:title>Analytics</x-slot:title>
    <header class="page-title">ANALYTICS</header>
    <section class="analytics-container">
        {{-- A. FACILITY STATISTICS --}}
        <div class="analytics-section">
            <div class="section-heading">
                <h3>A. Facility Statistics</h3>
                {{-- <span class="status-badge">Summary</span> --}}
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">Total Residents</span>
                    <h2>{{ $facilityStatistics['total_residents'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total Transients</span>
                    <h2>{{ $facilityStatistics['total_transients'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total Rooms</span>
                    <h2>{{ $facilityStatistics['total_rooms'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total Capacity</span>
                    <h2>{{ $facilityStatistics['total_capacity'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Occupied Slots</span>
                    <h2>{{ $facilityStatistics['occupied_slots'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Available Slots</span>
                    <h2>{{ $facilityStatistics['available_slots'] }}</h2>
                </div>
            </div>
        </div>

        {{-- B. RESIDENT AND TRANSIENT ANALYTICS --}}
        <div class="analytics-section">
            <h3>B. Resident and Transient Analytics</h3>
            <div class="monthly-grid">
                <div>
                    <h4 class="chart-heading">Resident Check-Ins and Check-Outs</h4>
                    <div class="monthly-chart">
                        <canvas id="residentTrendChart"></canvas>
                    </div>
                </div>
                <div>
                    <h4 class="chart-heading">Transient Check-Ins and Check-Outs</h4>
                    <div class="monthly-chart">
                        <canvas id="transientTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>        

        {{-- C. PASS SLIP STATISTICS --}}
        <div class="analytics-section">
            <h3>C. Pass Slip Statistics</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">Submitted This Month</span>
                    <h2>{{ $passSlipStatistics['submitted'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Used This Month</span>
                    <h2>{{ $passSlipStatistics['used'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Cancelled This Month</span>
                    <h2>{{ $passSlipStatistics['cancelled'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Without Pass Slip</span>
                    <h2>{{ $passSlipStatistics['no_pass_slip_logs'] }}</h2>
                </div>
            </div>
            <h4 class="chart-heading">Monthly Pass Slip Usage</h4>
            <div class="monthly-chart">
                <canvas id="passSlipChart"></canvas>
            </div>
            <h4 class="chart-heading">Residents Logged Without Pass Slip</h4>
            <div class="leaderboard-card">
                @forelse($withoutPassSlipLeaderboard as $row)
                    <div class="leaderboard-row">
                        <span>{{ $row['resident']->user->last_name }}, {{ $row['resident']->user->nickname }}
                        </span>
                        <strong>{{ $row['count'] }}</strong>
                    </div>
                @empty
                    <div class="empty-state">No records found.</div>
                @endforelse
            </div>
        </div>

        {{-- D. MOVEMENT & COMPLIANCE ANALYTICS --}}
        <div class="analytics-section">
            <h3>D. Movement & Compliance Analytics</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">Daily Time Out</span>
                    <h2>{{ $movementStatistics['daily_out'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Daily Time In</span>
                    <h2>{{ $movementStatistics['daily_in'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Monthly Time Out</span>
                    <h2>{{ $movementStatistics['monthly_out'] }}</h2>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Monthly Time In</span>
                    <h2>{{ $movementStatistics['monthly_in'] }}</h2>
                </div>
            </div>
            <div class="monthly-grid">
                <div>
                    <h4 class="chart-heading">Weekly Time Out vs Time In</h4>
                    <div class="monthly-chart">
                        <canvas id="weeklyMovementChart"></canvas>
                    </div>
                </div>
                <div>
                    <h4 class="chart-heading">Monthly Time Out vs Time In</h4>
                    <div class="monthly-chart">
                        <canvas id="monthlyMovementChart"></canvas>
                    </div>
                </div>
            </div>
            <h4 class="chart-heading">Late Return Leaderboard</h4>
            <div class="leaderboard-card">
                @forelse($lateReturnLeaderboard as $row)
                    <div class="leaderboard-row">
                        <span>{{ $row['resident']->user->last_name }}, {{ $row['resident']->user->nickname }}</span>
                        <strong>{{ $row['count'] }}</strong>
                    </div>
                @empty
                    <div class="empty-state">No late returns found.</div>
                @endforelse
            </div>
        </div>

        {{-- E. RESIDENT DEMOGRAPHICS
        <div class="analytics-section">
            <h3>E. Resident Demographics</h3>
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
            <h4 class="chart-heading">Top Resident Locations</h4>
            <div class="leaderboard-card">
                @forelse($residentLocationLeaderboard as $row)
                    <div class="leaderboard-row"><span>{{ $row['location'] }}</span><strong>{{ $row['count'] }}</strong></div>
                @empty
                    <div class="empty-state">No location data available.</div>
                @endforelse
            </div>
        </div> --}}
    </section>

    {{-- CHARTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false
        };
        // b
        const residentCheckIns = @json($checkInCheckOut['residentCheckInTrend']);
        const residentCheckOuts = @json($checkInCheckOut['residentCheckOutTrend']);
        new Chart(
            document.getElementById('residentTrendChart'), {
                type: 'bar', data: {
                    labels: residentCheckIns.map(item =>
                        new Date(item.year, item.month - 1).toLocaleString(
                            'en-US', {
                                month: 'short',
                                year: 'numeric'
                            }
                        )
                    ), datasets: [{
                            label: 'Check-Ins',
                            data: residentCheckIns.map(item => item.count),
                            backgroundColor: '#5799f5'
                        }, {
                            label: 'Check-Outs',
                            data: residentCheckOuts.map(item => item.count),
                            backgroundColor: '#6bc580'
                        }
                    ]
                },
                options: commonOptions
            }
        );

        const transientCheckIns = @json($checkInCheckOut['transientCheckInTrend']);
        const transientCheckOuts = @json($checkInCheckOut['transientCheckOutTrend']);
        new Chart(
            document.getElementById('transientTrendChart'), {
                type: 'bar', data: {
                    labels: transientCheckIns.map(item =>
                        new Date(item.year, item.month - 1).toLocaleString(
                            'en-US', {
                                month: 'short',
                                year: 'numeric'
                            }
                        )
                    ), datasets: [{
                            label: 'Check-Ins',
                            data: transientCheckIns.map(item => item.count),
                            backgroundColor: '#5799f5'
                        }, {
                            label: 'Check-Outs',
                            data: transientCheckOuts.map(item => item.count),
                            backgroundColor: '#6bc580'
                        }
                    ]
                },
                options: commonOptions
            }
        );

        // c
        const passSlipData = @json($monthlyPassSlipTrend);
        new Chart(
            document.getElementById('passSlipChart'), {
                type: 'bar', data: {
                    labels: passSlipData.map(item =>
                        new Date(item.year, item.month - 1)
                            .toLocaleString('en-US', {
                                month: 'short',
                                year: 'numeric'
                            })
                    ), datasets: [{
                            label: 'Submitted',
                            data: passSlipData.map(item => item.submitted),
                            backgroundColor: '#5799f5'
                        }, {
                            label: 'Used',
                            data: passSlipData.map(item => item.used),
                            backgroundColor: '#6bc580'
                        }, {
                            label: 'Cancelled',
                            data: passSlipData.map(item => item.cancelled),
                            backgroundColor: '#e58a8a'
                        }
                    ]
                }, options: commonOptions
            }
        );

        // d
        const weeklyData = @json($weeklyActivity);
        new Chart(
            document.getElementById('weeklyMovementChart'), {
                type: 'bar', data: {
                    labels: weeklyData.map(item => item.day),
                    datasets: [{
                            label: 'Time Out',
                            data: weeklyData.map(item => item.time_out),
                            backgroundColor: '#5799f5'
                        }, {
                            label: 'Time In',
                            data: weeklyData.map(item => item.time_in),
                            backgroundColor: '#6bc580'
                        }
                    ]
                }, options: commonOptions
            }
        );

        const monthlyOut = @json($monthlyMovement);
        const monthlyIn = @json($monthlyReturns);
        new Chart(
            document.getElementById('monthlyMovementChart'), {
                type: 'bar', data: {
                    labels: monthlyOut.map(item =>
                        new Date(item.year, item.month - 1)
                            .toLocaleString('en-US', {
                                month: 'short',
                                year: 'numeric'
                            })
                    ), datasets: [{
                            label: 'Time Out',
                            data: monthlyOut.map(item => item.time_outs),
                            backgroundColor: '#5799f5'
                        }, {
                            label: 'Time In',
                            data: monthlyIn.map(item => item.time_ins),
                            backgroundColor: '#6bc580'
                        }
                    ]
                }, options: commonOptions
            }
        );

    </script>
</x-layout>
