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
            <section class="flex-view" style="margin: 0;">
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
                <a href="{{ route('rooms.index', ['dorm' => 'Dorm 2']) }}">
                    <div class="card dorm-card {{ request('dorm') == 'Dorm 2' ? 'active' : '' }}">
                            <div class="room-image"><img src="/images/rooms/dt.jpg"></div>
                            <div class="room-number"><p>Dorm 2</p></div>
                            <div class="room-info"><p>(St. Paul University Manila)</p></div>
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
                            <div class="room-info"><p>Capacity: {{ $room->residents_count }} / {{ $room->capacity }}</p></div>
                            <div class="room-info"><p>Status: {{ $room->residents_count >= $room->capacity ? 'Full' : 'Available'}}</p></div>
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
                    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data" id="addroom-form">
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
                                <input type="file" name="room_image" id="room_image" accept="image/*" hidden>
                                <div class="image-upload-controls">
                                    <label for="room_image" class="btn-primary">Choose File</label>
                                    <span id="file-name">No file chosen</span><br>
                                </div>
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
                                <option value="" selected disabled hidden></option>
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
                    </form>
                    <div class="form-buttons">
                        <button class="btn-primary" type="reset" form="addroom-form">Reset Changes</button>
                        <button class="btn-primary" type="submit" form="addroom-form">Add Room</button>
                        <a href="{{ route('rooms.index')}}" class="btn-primary">Close</a>
                    </div>
                </div>
            </div>
        @endif
        
        {{-- =============================== EDIT ROOM MODAL =============================== --}}
        {{-- pull info of selected card --}}
        @php
            $selectedRoom = null;
            if (request('room')) {
                $selectedRoom = \App\Models\Room::with('residents.user')->find(request('room'));
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
                                    <img src="{{ asset($selectedRoom->room_image) }}" id="preview-image" alt="Preview">
                                    <span id="preview-text" style="display:none;"></span>
                                </div>
                                <input type="file" name="room_image" id="room_image" accept="image/*" hidden>
                                <label for="room_image" class="btn-primary">Choose File</label>
                                <span id="file-name">No file chosen</span><br>
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
                        <form action="{{ route('rooms.destroy', $selectedRoom->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-primary form-delete"
                                style="background-color: #c70000; color: white;"
                                onclick="return confirm('Are you sure you want to delete this room?')"
                            >Delete Room</button>
                        </form>
                        <a href="{{ route('rooms.index')}}" class="btn-primary">Close</a>
                    </div>
                    <div class="room-occupants">  {{-- room occuppants --}}
                        <br>
                        <details class="inactive-section" @if(request('occupants') == 'open') open @endif><summary class="inactive-summary"><hr><h2>Occupants ({{ $selectedRoom->residents_count ?? $selectedRoom->residents->count() }} / {{ $selectedRoom->capacity }})</h2></summary>
                            @if ($errors->has('resident'))
                                <div class="error-box"><p>{{ $errors->first('resident') }}</p></div>
                            @endif
                            @forelse ($selectedRoom->residents as $resident)
                                <div class="assign-row">
                                    <span>{{ $resident->user->userName() }}</span>
                                    <a href="{{ route('rooms.removeResident', $resident->id) }}" style="color: red; text-decoration: none;">[ Remove Resident ]</a>
                                </div>
                            @empty
                                <p class="list">There are no occupants in this room.</p>
                            @endforelse
                            @php
                                $eligibleResidents = collect();
                                $firstOccupant = $selectedRoom->residents->first();
                                foreach ($availableResidents as $resident) {
                                    $allowed = $resident->room_type === $selectedRoom->capacity . ' persons';
                                    if ($firstOccupant) {
                                        $allowed =
                                            $allowed &&
                                            $resident->user->gender === $firstOccupant->user->gender &&
                                            $resident->accommodation_type === $firstOccupant->accommodation_type &&
                                            $resident->resident_type === $firstOccupant->resident_type;
                                    }
                                    if ($allowed) {
                                        $eligibleResidents->push($resident);
                                    }
                                }
                            @endphp
                            @if ($selectedRoom->residents->count() >= $selectedRoom->capacity)
                                <p class="list">Room is already full. Please remove some resident to add a new one.</p>
                            @elseif ($eligibleResidents->isEmpty())
                                <p class="list">No eligible residents available.</p>
                            @else
                                <form action="{{ route('rooms.assign', $selectedRoom->id) }}" method="POST">
                                    @csrf
                                    <div class="assign-row list">
                                        <select name="resident_id" required>
                                            <option value="" selected disabled hidden>Select Resident</option>
                                            @foreach ($eligibleResidents as $resident)
                                                <option value="{{ $resident->id }}">{{ $resident->user->userName() }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn-primary">Assign</button>
                                    </div>
                                </form>
                            @endif
                        </details>
                    </div>
                </div>
            </div>    
        @endif

        {{-- confirmation receipt --}}
        @if(session('success'))
            <div class="modal">
                <div class="card room-modal receipt-modal">
                    <h2 class="modal-title">Success!</h2>
                    <p style="text-align:center;">{{ session('success') }}</p>
                        @if(session('receipt'))
                            <div class="receipt-box">
                                <p><strong>Action: </strong>{{ session('receipt.action') }}</p>
                                @if(session('receipt.image_deleted'))
                                    <p><strong>Image Deleted: </strong>{{ session('receipt.image_deleted') }}</p>
                                @elseif(session('receipt.room_image'))
                                    <p><strong>Image: </strong>{{ basename(session('receipt.room_image')) }}</p>
                                    <img src="{{ asset(session('receipt.room_image')) }}"
                                        style="width: 200px; display:block; margin: 10px auto; border-radius: 8px;">
                                @endif
                                <p><strong>Room Number: </strong>{{ session('receipt.room_number') }}</p>
                                <p><strong>Dormitory: </strong>{{ session('receipt.dorm_name') }}</p>
                                <p><strong>Capacity: </strong>{{ session('receipt.capacity') }}</p>
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

        {{-- error receipt --}}
        @if(session('error'))
            <div class="modal">
                <div class="card room-modal receipt-modal">
                    <h2 class="modal-title">Error</h2>
                    <p style="text-align:center;">{{ session('error') }}</p>
                    <div class="form-buttons">
                        <button class="btn-primary" onclick="this.closest('.modal').remove()">OK</button>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-layout>