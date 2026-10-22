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
        <section class="dorm-section">
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
        </section>

        <hr>

        {{-- ===== BOTTOM HALF: ALL PASS SLIPS ===== --}}
        <section class="dorm-section">
            <h2>All Pass Slips</h2>

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
        </section>

    </section>
</x-layout>