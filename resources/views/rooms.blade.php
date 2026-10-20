<x-layout>
    <x-slot:title>Room Management</x-slot:title>
    @if ($errors->any())
        <script>
            alert('There was an error. Please check your input and try again.');
        </script>
    @endif
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
                    <div class="card dorm-card {{ request('dorm') == null ? 'active' : '' }}">
                        <div class="room-image"><img src="/images/rooms/spum.jpg"></div>
                        <div class="room-number"><p>All Dorms</p></div>
                        <div class="room-info"><p>(St. Paul University Manila Dormitories)</p></div>
                    </div>
                </a>
                <a href="{{ route('rooms.index', ['dorm' => 'Le Berceau']) }}">
                    <div class="card dorm-card {{ request('dorm') == 'Le Berceau' ? 'active' : '' }}">
                            <div class="room-image"><img src="/images/rooms/lb.jpg"></div>
                            <div class="room-number"><p>Le Berceau</p></div>
                            <div class="room-info"><p>(SPU Manila Campus)</p></div>
                    </div>
                </a>
                <a href="{{ route('rooms.index', ['dorm' => 'Maison Paul']) }}">
                    <div class="card dorm-card {{ request('dorm') == 'Maison Paul' ? 'active' : '' }}">
                            <div class="room-image"><img src="/images/rooms/mp.jpg"></div>
                            <div class="room-number"><p>Maison Paul</p></div>
                            <div class="room-info"><p>(Malvar Street)</p></div>
                    </div>
                </a>
                <a href="{{ route('rooms.index', ['dorm' => 'Nini Dorm']) }}">
                    <div class="card dorm-card {{ request('dorm') == 'Nini Dorm' ? 'active' : '' }}">
                            <div class="room-image"><img src="/images/rooms/nd.jpg"></div>
                            <div class="room-number"><p>Nini Dorm</p></div>
                            <div class="room-info"><p>(Taft Avenue)</p></div>
                    </div>
                </a>
            </section>
        </section>
        @forelse ($roomsByDorm as $dorm_name => $rooms)
            <section class="dorm-section">
                <div class="section-dormname">
                    <h2>{{ $dorm_name }}</h2>
                    <a href="{{ route('rooms.index', ['modal' => 'add', 'dorm' => $dorm_name]) }}" class="btn-primary">+ Add Room</a>
                </div>
                <hr>
                <section class="grid-view">
                    @forelse ($rooms as $room)
                    <a href="{{ route('rooms.index', ['modal' => 'edit', 'room' => $room->id, 'dorm' => request('dorm')]) }}">
                        <div class="card room-card">
                            <div class="room-image"><img src="{{ asset($room->room_image) }}"></div>
                            <div class="room-number"><p>Room Number: {{ $room->room_number }}</p></div>
                            <div class="room-info"><p>Building: {{ $room->dorm_name }}</p></div>
                            <div class="room-info"><p>Capacity: {{ $room->capacity }}</p></div>
                        </div>
                    </a>
                    @empty
                    <p>No rooms yet in this dorm. Please add a room.</p>
                    @endforelse
                </section>
            </section>
            @empty
                <p style="text-align: center;">No dorm info yet. Please add the dorm information.</p>
        @endforelse

        {{-- =============================== ADD ROOM MODAL =============================== --}}
        @if(request('modal') == 'add')
        <div class="modal">
            <div class="card room-modal">
                <h2 class="modal-title">Add Room</h2>
                <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="Room Image">Room Image: </label>
                        <div class="image-upload">
                            <div class="image-preview">
                                <img id="preview-image" src="" alt="Preview" style="display:none;">
                                <span id="preview-text">Click "Choose File" to upload an image.</span>
                            </div>
                            <input type="file" name="room_image" id="room_image" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Room Number">Room Number: </label>
                        <input type="text" name="room_number">
                    </div>
                    <div class="form-group">
                        <label for="Dorm Name">Dorm Name: </label>
                        <input type="text" name="dorm_name" value="{{ request('dorm') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Capacity">Capacity: </label>
                        <select name="capacity">
                            <option value="">Select Capacity</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    
                    <div class="form-buttons">
                        <button class="btn-primary" type="submit">Save Room</button>
                        <button class="btn-primary" type="reset">Clear</button>
                        <a href="{{ route('rooms.index')}}" class="btn-primary">Close</a>
                    </div>
                </form>
            </div>
        </div>
        @endif
        
        {{-- =============================== EDIT ROOM MODAL =============================== --}}
        {{-- pull info of selected card --}}
        @php
        $selectedRoom = null;
        if (request('room')) {
            $selectedRoom = \App\Models\Room::find(
                request('room')
                );
                }
                @endphp
    
        {{-- pull up modal once room selected has been identified --}}
        @if(request('modal') == 'edit' && $selectedRoom)
            <div class="modal">
                <div class="card room-modal">
                    <h2 class="modal-title">Editing Room: <span>{{ $selectedRoom->dorm_name }} {{ $selectedRoom->room_number }}</span></h2>
                    <form action="{{ route('rooms.update', $selectedRoom->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        @method('PUT')
                        <div class="form-group">
                            <label for="Room Image">Room Image: </label>
                            <div class="image-upload">
                                <div class="image-preview">
                                    <img src="{{ asset($selectedRoom->room_image) }}">
                                </div>
                                <input type="file" name="room_image" id="room_image" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Room Number">Room Number: </label>
                            <input type="text" name="room_number" value="{{ $selectedRoom->room_number }}">
                        </div>
                        <div class="form-group">
                            <label for="Dorm Name">Dorm Name: </label>
                            <input type="text" name="dorm_name" value="{{ $selectedRoom->dorm_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Capacity">Capacity: </label>
                            <select name="capacity">
                                <option value="">Select Capacity</option>
                                <option value="1" @selected($selectedRoom->capacity == 1)>1</option>
                                <option value="2" @selected($selectedRoom->capacity == 2)>2</option>
                                <option value="3" @selected($selectedRoom->capacity == 3)>3</option>
                                <option value="4" @selected($selectedRoom->capacity == 4)>4</option>
                                <option value="8" @selected($selectedRoom->capacity == 8)>8</option>
                            </select>
                        </div>
                        
                        <div class="form-buttons">
                            <button class="btn-primary" type="submit">Save Room</button>
                            <button class="btn-primary" type="reset">Clear</button>
                            <a href="{{ route('rooms.index')}}" class="btn-primary">Close</a>
                        </div>
                    </form>
                </div>
            </div>    
        @endif
    </section>
</x-layout>