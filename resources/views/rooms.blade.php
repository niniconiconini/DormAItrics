<x-layout>
    <x-slot:title>Room Management</x-slot:title>    
    <section id="rooms">
        <header class="page-title">ROOM MANAGEMENT</header>
        <section class="dorm-section">
            <h2>Dormitories
                @if(request('dorm'))
                    <small>(Showing: {{ request('dorm') }})</small>
                @else
                    <small>(Showing: All Rooms)</small>
                @endif
            </h2><hr>
            <section class="flex-view">
                <a href="{{ route('rooms.index')}}">
                    <div class="card dorm-card" {{ request('dorm') == 'All Dorms' ? 'active' : '' }}>
                        <div class="room-image"><img src="/images/rooms/lb.jpg"></div>
                        <div class="room-number"><p>All Dorms</p></div>
                        <div class="room-info"><p>(St. Paul University Manila Dormitories)</p></div>
                    </div>
                </a>
                <a href="{{ route('rooms.index', ['dorm' => 'Le Berceau']) }}">
                    <div class="card dorm-card">
                            <div class="room-image"><img src="/images/rooms/lb.jpg"></div>
                            <div class="room-number"><p>Le Berceau</p></div>
                            <div class="room-info"><p>(SPU Manila Campus)</p></div>
                    </div>
                </a>
                <a href="{{ route('rooms.index', ['dorm' => 'Maison Paul']) }}">
                    <div class="card dorm-card">
                            <div class="room-image"><img src="/images/rooms/mp.jpg"></div>
                            <div class="room-number"><p>Maison Paul</p></div>
                            <div class="room-info"><p>(Malvar Street)</p></div>
                    </div>
                </a>
                <a href="{{ route('rooms.index', ['dorm' => 'Nini Dorm']) }}">
                    <div class="card dorm-card">
                            <div class="room-image"><img src="/images/rooms/mp.jpg"></div>
                            <div class="room-number"><p>Nini Dorm</p></div>
                            <div class="room-info"><p>(Taft Avenue)</p></div>
                    </div>
                </a>
            </section>
        </section>
        @forelse ($roomsByDorm as $dorm_name => $rooms)
            <section class="dorm-section">
                <h2>{{ $dorm_name }}</h2><hr>
                <section class="grid-view">
                    @forelse ($rooms as $room)
                    <div class="card room-card">
                        <div class="room-image"><img src="{{ $room->room_image }}"></div>
                        <div class="room-number"><p>Room Number: {{ $room->room_number }}</p></div>
                        <div class="room-info"><p>Building: {{ $room->dorm_name }}</p></div>
                        <div class="room-info"><p>Capacity: {{ $room->capacity }}</p></div>
                    </div>
                    @empty
                    <p>No rooms yet in this dorm. Please add a room.</p>
                    @endforelse
                </section>
            </section>
            @empty
                <p style="text-align: center;">No dorm info yet. Please add the dorm information.</p>
        @endforelse
    </section>
</x-layout>