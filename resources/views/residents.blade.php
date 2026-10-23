<x-layout>
    <x-slot:title>Dormer Management</x-slot:title>    
    <header class="page-title">DORMITORY RESIDENTS</header>
    <section class="dorm-section">
        <div class="section-dormname">
            <h2>Dormitory Administrators</h2>
            @if (auth()->user()->user_type === 'Admin')
                <a href="{{ route('residents.index') }}" class="btn-primary">+ Add Admin</a>
            @endif
        </div>
        <hr>
        <section class="flex-view">
            @forelse ($admins as $admin)
                <a href="#">
                    <div class="card dorm-card">
                        <div class="room-image"><img src="{{ asset('images/user-profile.png') }}"></div>
                        <div class="room-number"><p>{{ $admin->nickname }}</p></div>
                    </div>
                </a>
            @empty
                <p>No administrators found.</p>
            @endforelse
        </section>
    </section>
    <section class="dorm-section">
        <div class="residents-header">
            <a href="{{ route('residents.index', ['view' => request('view') === 'transient' ? 'resident' : 'transient']) }}" class="btn-primary">{{ request('view') === 'transient' ? 'View Residents' : 'View Transients' }}</a>
            <div class="residents-title">
                <h2>{{ request('view') === 'transient' ? 'Transients' : 'Residents' }}</h2>
                <a href="{{ route('residents.index') }}" class="btn-primary">+ Add {{ request('view') === 'transient' ? 'Transient' : 'Resident' }}</a>
            </div>
        </div>
        <hr>
        <div class="section-dormname" style="margin-top: 0; margin-bottom: 1rem;">
            <a href="{{ route('residents.index') }}" class="btn-primary">All Residents</a>
            <a href="{{ route('residents.index', ['resident_type' => 'Student']) }}" class="btn-primary">Students</a>
            <a href="{{ route('residents.index', ['resident_type' => 'Employee']) }}" class="btn-primary">Employees</a>
        </div>
        <section class="flex-view">
            @forelse ($residents as $resident)
                <a href="#">
                    <div class="card dorm-card">
                        <div class="room-image"><img src="{{ asset('images/user-profile.png') }}"></div>
                        <div class="room-number"><p>{{ $resident->user->nickname }}</p></div>
                        <div class="room-info"><p>Room: {{ $resident->room->room_number }}</p></div>
                        <div class="room-info"><p>Resident Type: {{ $resident->resident_type }}</p></div>
                    </div>
                </a>
            @empty
                <p>No administrators found.</p>
            @endforelse
        </section>
    </section>
</x-layout>