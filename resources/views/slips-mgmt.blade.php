<x-layout>
    <x-slot:title>Pass Slip Management</x-slot:title>
    <header class="page-title">PASS SLIPS MANAGEMENT</header>
    <section>

        @if (session('success') || session('error'))
            <div class="announcement-card">
                @if (session('success'))
                    <p class="slip-success">{{ session('success') }}</p>
                @endif
                @if (session('error'))
                    <p class="slip-error">{{ session('error') }}</p>
                @endif
            </div>
        @endif

        {{-- ===== TOP HALF: FOR APPROVAL ===== --}}
        <section class="dorm-section" id="for-approval">
            <h2>For Approval</h2>

            <div class="list-view">
                @forelse ($forApproval as $slip)
                    <div class="card announcement-card slip-card">
                        <div>
                            <div class="title">{{ $slip->dormerName() }}</div>
                            <div class="message"><b>Destination:</b> {{ $slip->purpose }}<br><b>Date:</b> {{ \Carbon\Carbon::parse($slip->requested_date_out)->format('M j, Y') }} | <b>Time out:</b> {{ \Carbon\Carbon::parse($slip->requested_time_out)->format('g:i A') }}<br><b>Expected return:</b> {{ $slip->returnAt()->format('M j, Y, g:i A') }}</div>
                        </div>

                        {{-- check = approve, X = deny (both ask for confirmation) --}}
                        <div class="slip-actions">
                            <form action="{{ route('slips-mgmt.approve', $slip) }}" method="POST" onsubmit="return confirm('Are you sure you want to accept this pass slip?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="approve" title="Accept" aria-label="Accept">&#10003;</button>
                            </form>
                            <form action="{{ route('slips-mgmt.deny', $slip) }}" method="POST" onsubmit="return confirm('Are you sure you want to deny this pass slip?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="Deny" aria-label="Deny">&#10005;</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>No pass slips are waiting for approval.</p>
                @endforelse
            </div>

            {{-- page numbers: first pages, "...", last page (only shown when there is more than one page) --}}
            @if ($forApproval->hasPages())
                @php
                    $current = $forApproval->currentPage();
                    $last = $forApproval->lastPage();

                    // which numbers to show: the first few, the last, and the ones around the current page
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
                <nav class="pager" aria-label="Pagination" data-last="{{ $last }}" data-url="{{ $forApproval->url(1) }}" data-page-name="{{ $forApproval->getPageName() }}">
                    @if ($forApproval->onFirstPage())
                        <span class="disabled" aria-label="Previous page">&#9664;&#xFE0E;</span>
                    @else
                        <a href="{{ $forApproval->previousPageUrl() }}" aria-label="Previous page">&#9664;&#xFE0E;</a>
                    @endif

                    @foreach ($pages as $page)
                        @if ($page === '...')
                            <button type="button" class="dots" aria-label="Jump to a page">&hellip;</button>
                        @elseif ($page == $current)
                            <span class="active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $forApproval->url($page) }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($forApproval->hasMorePages())
                        <a href="{{ $forApproval->nextPageUrl() }}" aria-label="Next page">&#9654;&#xFE0E;</a>
                    @else
                        <span class="disabled" aria-label="Next page">&#9654;&#xFE0E;</span>
                    @endif
                </nav>
            @endif
        </section>

        <hr>

        {{-- ===== BOTTOM HALF: ALL PASS SLIPS ===== --}}
        <section class="dorm-section" id="all-slips">
            <h2>All Pass Slips</h2>

            {{-- wipes every pass slip (opens the two-step confirmation below) --}}
            @if ($passSlips->total() > 0)
                <div class="center-row">
                    <button type="button" class="btn-primary btn-danger" id="openDelete">Delete All Pass Slips</button>
                </div>
            @endif

            <div class="list-view">
                @forelse ($passSlips as $slip)
                    <div class="card announcement-card slip-card">
                        <div>
                            <div class="title">{{ $slip->dormerName() }}</div>
                            <div class="message"><b>Destination:</b> {{ $slip->purpose }}<br><b>Date:</b> {{ \Carbon\Carbon::parse($slip->requested_date_out)->format('M j, Y') }} | <b>Time out:</b> {{ \Carbon\Carbon::parse($slip->requested_time_out)->format('g:i A') }}<br><b>Expected return:</b> {{ $slip->returnAt()->format('M j, Y, g:i A') }}</div>
                        </div>
                        <span class="status {{ $slip->statusClass() }}">{{ $slip->displayStatus() }}</span>

                        {{-- who decided and when (updated_at) --}}
                        @if (in_array($slip->status, ['Approved', 'Rejected']))
                            <i>{{ $slip->status === 'Rejected' ? 'Denied' : 'Approved' }} by {{ $slip->approverName() }} on {{ $slip->updated_at->format('M j, Y') }} at {{ $slip->updated_at->format('g:i A') }}</i>
                        @endif
                    </div>
                @empty
                    <p>No pass slips have been filed yet.</p>
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

        {{-- ===== DELETE ALL PASS SLIPS: two-step confirmation ===== --}}
        <div id="deleteModal" hidden>
            <div class="modal">
                <div class="room-modal delete-modal">

                    {{-- step 1 --}}
                    <div id="deleteStep1">
                        <h2 class="modal-title">Delete All Pass Slips</h2>
                        <p>This will permanently delete every pass slip from every dormer, including pending, approved, denied, cancelled and expired ones. This cannot be undone.</p>
                        <div class="slip-submit">
                            <button type="button" class="btn-primary closeDelete">Cancel</button>
                            <button type="button" class="btn-primary btn-danger" id="toStep2">Continue</button>
                        </div>
                    </div>

                    {{-- step 2: final confirmation --}}
                    <form id="deleteStep2" action="{{ route('slips-mgmt.destroy-all') }}" method="POST" hidden>
                        @csrf
                        @method('DELETE')
                        <h2 class="modal-title">Are you absolutely sure?</h2>
                        <p>This is your last chance. Every pass slip record will be erased from the database and cannot be recovered.</p>
                        <div class="slip-submit">
                            <button type="button" class="btn-primary closeDelete">No, keep them</button>
                            <button type="submit" class="btn-primary btn-danger">Yes, delete everything</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <script>
            const deleteModal = document.getElementById('deleteModal');
            const deleteStep1 = document.getElementById('deleteStep1');
            const deleteStep2 = document.getElementById('deleteStep2');

            function closeDeleteModal() {
                deleteModal.hidden = true;
            }

            document.getElementById('openDelete')?.addEventListener('click', () => {
                deleteStep1.hidden = false;
                deleteStep2.hidden = true;
                deleteModal.hidden = false;
            });

            document.getElementById('toStep2').addEventListener('click', () => {
                deleteStep1.hidden = true;
                deleteStep2.hidden = false;
            });

            document.querySelectorAll('.closeDelete').forEach(btn => btn.addEventListener('click', closeDeleteModal));
            document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
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

    </section>
</x-layout>