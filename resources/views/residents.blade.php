<x-layout>
    <x-slot:title>Dormer Management</x-slot:title>    
    <header class="page-title">DORMITORY RESIDENTS</header>
    <section class="dorm-section">
        <h2>Dormitory Administrators</h2>
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
        <h2>Residents</h2>
        <hr>
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