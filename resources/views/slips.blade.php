<x-layout>
    <x-slot:title>Pass Slips</x-slot:title>    
    <header class="page-title">PASS SLIPS</header>
    <section>
        {{-- ===== TOP HALF: FILL UP PASS SLIP ===== --}}
        <div class="announcement-card">
            <button type="button" class="card passslip-toggle" id="slipToggle" aria-expanded="{{ $errors->any() ? 'true' : 'false' }}" aria-controls="slipPanel">
                Fill Up Pass Slip
                <span class="chevron" aria-hidden="true"></span>
            </button>

            <div class="passslip-panel {{ $errors->any() ? 'open' : '' }}" id="slipPanel">
                <div>
                    <form class="card passslip-form" id="slipForm" action="{{ route('pass-slips.store') }}" method="POST">
                        @csrf

                        <p class="slip-error" id="slipError" @unless ($errors->any()) hidden @endunless>{{ $errors->first() }}</p>

                        <div class="slip-heading">
                            <h3>Pass Slip</h3>
                            <strong>(St. Paul University Manila System)</strong><br>
                            <small>To be presented to the Guard</small>
                        </div>

                        <div class="slip-grid">
                            <div class="slip-field full">
                                <label for="name">Name</label>
                                <input type="text" id="name" value="{{ $fullName }}" readonly>
                            </div>
                            <div class="slip-field">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="requested_date_out" value="{{ old('requested_date_out') }}" required>
                            </div>
                            <div class="slip-field">
                                <label for="time_out">Time out</label>
                                <input type="time" id="time_out" name="requested_time_out" value="{{ old('requested_time_out') }}" required>
                            </div>
                            <div class="slip-field full">
                                <label for="destination">Destination</label>
                                <input type="text" id="destination" name="purpose" value="{{ old('purpose') }}" placeholder="Where are you going?" required>
                            </div>
                            <div class="slip-field full">
                                <label>Expected return</label>
                                <div class="pair">
                                    <input type="date" id="return_date" name="requested_date_in" value="{{ old('requested_date_in') }}" aria-label="Expected return date" required>
                                    <input type="time" id="return_time" name="requested_time_in" value="{{ old('requested_time_in') }}" aria-label="Expected return time" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="btn-primary">Submit pass slip</button>
                        </div>
                    </form>
                </div>
            </div>

            @if (session('success'))
                <p class="slip-success">{{ session('success') }}</p>
            @endif
        </div>

        <hr>

        {{-- ===== BOTTOM HALF: PREVIOUS PASS SLIPS ===== --}}
        <section class="dorm-section">
            <h2>Previous Pass Slips</h2>

            @if (session('error'))
                <p class="slip-error">{{ session('error') }}</p>
            @endif

            <div class="list-view">
                @forelse ($passSlips as $slip)
                    @php $label = $slip->displayStatus(); @endphp
                    <div class="card announcement-card slip-card">
                        <div>
                            <div class="title">{{ $slip->purpose }}</div>
                            <div class="message"><b>Date:</b> {{ \Carbon\Carbon::parse($slip->requested_date_out)->format('M j, Y') }} | <b>Time out:</b> {{ \Carbon\Carbon::parse($slip->requested_time_out)->format('g:i A') }}<br><b>Expected return:</b> {{ $slip->returnAt()->format('M j, Y, g:i A') }}</div>
                        </div>
                        <span class="status {{ $slip->statusClass() }}">{{ $label }}</span>

                        {{-- date the admin decided (updated_at) --}}
                        @if (in_array($slip->status, ['Approved', 'Rejected']))
                            <i>{{ $slip->status === 'Rejected' ? 'Denied' : 'Approved' }} on {{ $slip->updated_at->format('M j, Y') }}</i>
                        @endif

                        {{-- cancel only while still for approval --}}
                        @if ($label === 'For approval')
                            <form action="{{ route('pass-slips.cancel', $slip) }}" method="POST" onsubmit="return confirm('Cancel your pass slip request for {{ e($slip->purpose) }}?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Cancel request</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p>No pass slips yet. Fill one up above to get started.</p>
                @endforelse
            </div>
        </section>

        <script>
            const toggle = document.getElementById('slipToggle');
            const panel = document.getElementById('slipPanel');
            const form = document.getElementById('slipForm');
            const errorEl = document.getElementById('slipError');

            function setOpen(open) {
                panel.classList.toggle('open', open);
                toggle.setAttribute('aria-expanded', open);
            }

            toggle.addEventListener('click', () => setOpen(!panel.classList.contains('open')));

            // quick check before sending (the controller checks it again)
            form.addEventListener('submit', e => {
                const out = new Date(`${form.requested_date_out.value}T${form.requested_time_out.value}`);
                const back = new Date(`${form.requested_date_in.value}T${form.requested_time_in.value}`);
                if (back <= out) {
                    e.preventDefault();
                    errorEl.textContent = 'Expected return must be after your time out.';
                    errorEl.hidden = false;
                }
            });

            setDefaults();
        </script>
    </section>
</x-layout>