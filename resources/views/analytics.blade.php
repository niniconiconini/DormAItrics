<x-layout>
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
</x-layout>