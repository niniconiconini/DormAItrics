<x-layout>
    <x-slot:title>Room Management</x-slot:title>
    <section id="rooms">
        <header class="page-title">ROOM MANAGEMENT</header>
        {{-- list of dormitories in spum --}}
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
        
        {{-- list of rooms in the selected dormitory --}}
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
            {{-- capacity options --}}
            @php
                $capacityOptions = match(request('dorm')) {
                    'Le Berceau' => [2,3,4,8],
                    'Maison Paul' => [1,2],
                    'Nini Dorm' => [1,2],
                    default => [],
                };
            @endphp
            {{-- open modal --}}
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
                                    <span id="preview-text" style="text-align: center;">Click "Choose File" to upload an image.
                                        <br><small>Image must not exceed 5MB.</small>
                                    </span>
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
                            <input type="text" name="dorm_name" value="{{ request('dorm') }}" readonly class="readonly-field">
                        </div>
                        <div class="form-group">
                            <label for="Capacity">Capacity: </label>
                            <select name="capacity">
                                <option value="" selected disabled hidden>Select Capacity</option>
                                @foreach($capacityOptions as $capacity)
                                    <option value="{{ $capacity }}">{{ $capacity }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($errors->any())
                            <div class="error-box">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
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
                $selectedRoom = \App\Models\Room::find(request('room'));
            }
        @endphp
    
        {{-- pull up modal once room selected has been identified --}}
        @if(request('modal') == 'edit' && $selectedRoom)
            {{-- capacity options --}}
            @php
                $capacityOptions = match($selectedRoom->dorm_name) {
                    'Le Berceau' => [2,3,4,8],
                    'Maison Paul' => [1,2],
                    'Nini Dorm' => [1,2],
                    default => [],
                };
            @endphp
            {{-- open modal --}}
            <div class="modal">
                <div class="card room-modal">
                    <h2 class="modal-title">Editing Room: <span>{{ $selectedRoom->dorm_name }} {{ $selectedRoom->room_number }}</span></h2>
                    <form id="update-form" action="{{ route('rooms.update', $selectedRoom->id) }}" method="POST" enctype="multipart/form-data">
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
                            <input type="text" name="dorm_name" value="{{ $selectedRoom->dorm_name }}" readonly class="readonly-field">
                        </div>
                        <div class="form-group">
                            <label for="Capacity">Capacity: </label>
                            <select name="capacity">
                                @foreach($capacityOptions as $capacity)
                                    <option value="{{ $capacity }}" @selected( $selectedRoom->capacity == $capacity)>{{ $capacity }}</option>
                                @endforeach
                            </select>
                        </div>    
                    </form>
                    <div class="form-buttons">
                        <button class="btn-primary" type="reset" form="update-form">Reset Changes</button>
                        <button class="btn-primary" type="submit" form="update-form">Update Room</button>
                        <form action="{{ route('rooms.destroy', $selectedRoom->id) }}" 
                            method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-primary form-delete" 
                                style="background-color: #c70000; color: white;"
                                onclick="return confirm('Are you sure you want to delete this room?')"
                            >Delete Room</button>
                        </form>
                        <a href="{{ route('rooms.index')}}" class="btn-primary">Close</a>
                    </div>
                </div>
            </div>    
        @endif

        {{-- confirmation receipt --}}
        @if(session('success'))
            <div class="modal">
                <div class="card room-modal">
                    <h2 class="modal-title">Success!</h2>
                    <p style="text-align:center;">{{ session('success') }}</p>
                        @if(session('receipt'))
                            <div class="receipt-box">
                                <p><strong>Action: </strong>{{ session('receipt.action') }}</p>
                                <p><strong>Dormitory: </strong>{{ session('receipt.dorm_name') }}</p>
                                <p><strong>Room Number: </strong>{{ session('receipt.room_number') }}</p>
                                <p><strong>Capacity: </strong>{{ session('receipt.capacity') }}</p>
                                @if(session('receipt.image_deleted'))
                                    <p><strong>Image Deleted: </strong>{{ session('receipt.image_deleted') }}</p>
                                @elseif(session('receipt.room_image'))
                                    <p><strong>Image: </strong>{{ basename(session('receipt.room_image')) }}</p>
                                @endif
                            </div>
                        @endif
                    <div class="form-buttons">
                        <button class="btn-primary"
                            onclick="this.closest('.modal').remove()"
                        >OK</button>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-layout>