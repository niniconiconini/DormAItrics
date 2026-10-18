<x-layout>
    <x-slot:title>Room Management</x-slot:title>    
    <section class="rooms">
        <header class="page-title">ROOM MANAGEMENT</header>
        <section class="grid-view">
            @forelse ($rooms as $room)
            <div class="card room-card">
                <div class="room-image"><img src=" {{ asset('storage/' .$room->room_image) }}"></div>
                <div class="room-number"><p>Room Number: {{ $room->room_number }}</p></div>
                <div class="room-info"><p>Building: {{ $room->dorm_name }}</p></div>
                <div class="room-info"><p>Capacity: {{ $room->capacity }}</p></div>
            </div>
            @empty
                <p>No rooms yet. Please add a room.</p>
            @endforelse
        </section>
    </section>
</x-layout>