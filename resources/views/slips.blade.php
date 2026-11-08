<x-layout>
    <x-slot:title>Pass Slips</x-slot:title>    
    <header class="page-title">PASS SLIPS</header>
    <section>

        {{-- ===== TOP HALF: FILL UP PASS SLIP ===== --}}
        <div class="announcement-card">
            <button type="button" class="card passslip-toggle" id="slipToggle" aria-expanded="{{ $errors->any() ? 'true' : 'false' }}" aria-controls="slipPanel">
                Fill Out Pass Slip
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
                        </div>

                        <div class="slip-grid">
                            <div class="slip-field full">
                                <label for="name">Name</label>
                                <input type="text" id="name" value="{{ $fullName }}" readonly style="cursor: not-allowed;">
                            </div>
                            <div class="slip-field">
                                <label for="date">Date Out</label>
                                <input type="date" id="date" name="requested_date_out" value="{{ old('requested_date_out') }}" required>
                            </div>
                            <div class="slip-field">
                                <label for="time_out">Time out</label>
                                <input type="time" id="time_out" name="requested_time_out" value="{{ old('requested_time_out') }}" min="00:00" max="21:00" step="600" required>
                            </div>
                            <div class="slip-field full">
                                <label for="destination">Destination</label>
                                <input type="text" id="destination" name="purpose" value="{{ old('purpose') }}" placeholder="Where are you going?" required>
                            </div>
                            <div class="slip-field">
                                <label for="return_date">Expected Return Date</label>
                                <input type="date" id="return_date" name="requested_date_in" value="{{ old('requested_date_in') }}" required>
                            </div>
                            <div class="slip-field">
                                <label for="return_time">Expected Return Time</label>
                                <input type="time" id="return_time" name="requested_time_in" value="{{ old('requested_time_in') }}" min="00:00" max="21:00" step="600" required>
                            </div>
                        </div>

                        <div class="slip-submit">
                            <small>Note: The curfew is at 9:00 PM, please plan accordingly.</small>
                            <button type="submit" class="btn-primary">Submit Pass Slip</button>
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
        <section class="dorm-section" id="previous">
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

                        <div class="slip-side">
                            <button type="button" class="slip-copy"
                                data-purpose="{{ $slip->purpose }}"
                                data-date-out="{{ \Carbon\Carbon::parse($slip->requested_date_out)->format('Y-m-d') }}"
                                data-time-out="{{ \Carbon\Carbon::parse($slip->requested_time_out)->format('H:i') }}"
                                data-date-in="{{ \Carbon\Carbon::parse($slip->requested_date_in)->format('Y-m-d') }}"
                                data-time-in="{{ \Carbon\Carbon::parse($slip->requested_time_in)->format('H:i') }}">Copy</button>
                            <span class="status {{ $slip->statusClass() }}">{{ $label }}</span>
                        </div>

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

            {{-- page numbers --}}
            @if ($passSlips->hasPages())
                @php
                    $current = $passSlips->currentPage();
                    $last = $passSlips->lastPage();

                    if ($last <= 7) {
                        $pages = range(1, $last);
                    } elseif ($current <= 4) {
                        $pages = [...range(1, 5), '...', $last];
                    } elseif ($current >= $last - 3) {
                        $pages = [1, '...', ...range($last - 4, $last)];
                    } else {
                        $pages = [1, '...', $current - 1, $current, $current + 1, '...', $last];
                    }
                @endphp
                <nav class="pager" aria-label="Pagination" data-last="{{ $last }}" data-url="{{ $passSlips->url(1) }}" data-page-name="{{ $passSlips->getPageName() }}">
                    @if ($passSlips->onFirstPage())
                        <span class="disabled" aria-label="Previous page">&#9664;&#xFE0E;</span>
                    @else
                        <a href="{{ $passSlips->previousPageUrl() }}" aria-label="Previous page">&#9664;&#xFE0E;</a>
                    @endif

                    @foreach ($pages as $page)
                        @if ($page === '...')
                            <button type="button" class="dots" aria-label="Jump to a page">&hellip;</button>
                        @elseif ($page == $current)
                            <span class="active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $passSlips->url($page) }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($passSlips->hasMorePages())
                        <a href="{{ $passSlips->nextPageUrl() }}" aria-label="Next page">&#9654;&#xFE0E;</a>
                    @else
                        <span class="disabled" aria-label="Next page">&#9654;&#xFE0E;</span>
                    @endif
                </nav>
            @endif
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

            function setDefaults() {
                const d = new Date();
                const today = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
                ['date', 'return_date'].forEach(id => {
                    const el = document.getElementById(id);
                    el.min = today;
                    if (!el.value) el.value = today;
                });
            }

            toggle.addEventListener('click', () => setOpen(!panel.classList.contains('open')));

            form.addEventListener('submit', e => {
                const out = new Date(`${form.requested_date_out.value}T${form.requested_time_out.value}`);
                const back = new Date(`${form.requested_date_in.value}T${form.requested_time_in.value}`);
                if (back <= out) {
                    e.preventDefault();
                    errorEl.textContent = 'Expected return time must be after your time out.';
                    errorEl.hidden = false;
                }
            });

            setDefaults();
        </script>
        
            <script>
            // clicking "..." turns it into a box where you can type a page number
            (() => {
                document.querySelectorAll('.pager .dots').forEach(dots => {
                    dots.addEventListener('click', () => {
                        const nav = dots.closest('.pager');
                        const last = Number(nav.dataset.last);

                        const input = document.createElement('input');
                        input.type = 'number';
                        input.min = 1;
                        input.max = last;
                        input.setAttribute('aria-label', 'Go to page');

                        const restore = () => input.replaceWith(dots);

                        input.addEventListener('keydown', e => {
                            if (e.key === 'Escape') restore();

                            if (e.key === 'Enter') {
                                e.preventDefault();
                                const page = Math.min(Math.max(parseInt(input.value, 10), 1), last);
                                if (!page) return restore();

                                const url = new URL(nav.dataset.url);
                                url.searchParams.set(nav.dataset.pageName, page);
                                location.href = url.href;
                            }
                        });
                        input.addEventListener('blur', restore);

                        dots.replaceWith(input);
                        input.focus();
                    });
                });
            })();
        </script>

        <script>
            // Copy button: fills the pass slip form with the details of an earlier slip
            (() => {
                const panel = document.getElementById('slipPanel');
                const toggle = document.getElementById('slipToggle');
                const form = document.getElementById('slipForm');
                const error = document.getElementById('slipError');

                const pad = n => String(n).padStart(2, '0');
                const todayString = () => {
                    const d = new Date();
                    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
                };

                document.querySelectorAll('.slip-copy').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const slip = btn.dataset;
                        const today = todayString();

                        // which of the two dates are already in the past
                        const outPast = slip.dateOut < today;
                        const inPast = slip.dateIn < today;

                        // a date in the past is set to today
                        const dateOut = outPast ? today : slip.dateOut;
                        const dateIn = inPast ? today : slip.dateIn;

                        form.elements.requested_date_out.value = dateOut;
                        form.elements.requested_time_out.value = slip.timeOut;
                        form.elements.purpose.value = slip.purpose;
                        form.elements.requested_date_in.value = dateIn;
                        form.elements.requested_time_in.value = slip.timeIn;

                        // the message depends on which dates were in the past
                        if (outPast && inPast) {
                            error.textContent = 'The requested date out and expected return date is already in the past, therefore it has been set to today.';
                            error.hidden = false;
                        } else if (outPast) {
                            error.textContent = 'The requested date out is already in the past, therefore it has been set to today.';
                            error.hidden = false;
                        } else {
                            error.hidden = true;
                        }

                        // open the form and take the person to it
                        panel.classList.add('open');
                        toggle.setAttribute('aria-expanded', 'true');
                        toggle.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        form.elements.requested_time_out.focus({ preventScroll: true });
                    });
                });
            })();
        </script>
    </section>
</x-layout>