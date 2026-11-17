<x-layout>
    <x-slot:title>Facial Recognition Logs</x-slot:title>
    <section id="facial-recognition-logs">
        <header class="page-title">FACIAL RECOGNITION LOGS <div class="logs-count">{{ $logs->count() }} Records</div></header>
        <div class="card">
            <div class="logs-table-wrapper">
                <table class="logs-table">
                    <thead>
                        <tr>
                            <th>Resident Name</th>
                            <th>Time Out</th>
                            <th>Time In</th>
                            <th>Pass Slip</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr onclick="window.location='{{ route('logs.index', ['modal' => $log->id]) }}'">
                                <td>
                                    <div class="resident-name">
                                        <strong>
                                            {{ $log->resident->user->last_name }},
                                            {{ $log->resident->user->first_name }}
                                        </strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <strong>Date: </strong>{{ $log->departed_at->format('M d, Y') }}
                                            <br>
                                        <strong>Time: </strong>{{ $log->departed_at->format('h:i A') }}
                                            <br>
                                        <strong>Guard: </strong>{{ $log->timeOutApprover->first_name }} {{ $log->timeOutApprover->last_name }}
                                    </div>
                                </td>
                                <td>
                                    @if ($log->returned_at)
                                        <div class="date-info">
                                            <strong>Date: </strong>{{ $log->returned_at->format('M d, Y') }}
                                                <br>
                                            <strong>Time: </strong>{{ $log->returned_at->format('h:i A') }}
                                                <br>
                                            <strong>Guard: </strong>{{ $log->timeInApprover?->first_name }} {{ $log->timeInApprover?->last_name }}
                                        </div>
                                    @else
                                        <span class="status-badge pending">
                                            Not yet returned
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($log->pass_slip_id)
                                        <span class="status-badge approved">
                                           o Yes
                                        </span>
                                    @else
                                        <span class="status-badge no-slip">
                                           x No
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="notes">
                                        @php
                                            $lines = explode("\n", $log->notes);
                                        @endphp
                                        <strong>{{ $lines[0] }}</strong>
                                        @if(isset($lines[1]))
                                            <br>
                                            <span style="font-style: italic;">{{ $lines[1] }}</span>
                                        @endif
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <div class="empty-icon">📋</div>
                                    <strong>No Resident Logs Yet</strong>
                                    <p>Resident attendance records will appear here.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($logs->hasPages())
                    @php
                        $current = $logs->currentPage();
                        $last = $logs->lastPage();

                        if ($last <= 7) {
                            $pages = range(1, $last);
                        } elseif ($current <= 4) {
                            $pages = [...range(1, 5), '...', $last];
                        } elseif ($current >= $last - 3) {
                            $pages = [1, '...', ...range($last - 4, $last)];
                        } else {
                            $pages = [
                                1,
                                '...',
                                $current - 1,
                                $current,
                                $current + 1,
                                '...',
                                $last
                            ];
                        }
                    @endphp
                    <nav class="pager" aria-label="Pagination" data-last="{{ $last }}" data-url="{{ $logs->url(1) }}" data-page-name="{{ $logs->getPageName() }}">
                        @if ($logs->onFirstPage())
                            <span class="disabled">◀&#xFE0E;</span>
                        @else
                            <a href="{{ $logs->previousPageUrl() }}">◀&#xFE0E;</a>
                        @endif
                        @foreach ($pages as $page)
                            @if ($page === '...')
                                <button type="button" class="dots">&hellip;</button>
                            @elseif ($page == $current)
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $logs->url($page) }}">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if ($logs->hasMorePages())
                            <a href="{{ $logs->nextPageUrl() }}">▶&#xFE0E;</a>
                        @else
                            <span class="disabled">▶&#xFE0E;</span>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
    </section>
    @if($selectedLog)
        <div class="modal">
            <div class="card scan-modal logs-modal" style="height: 50%;">
                <form action="{{ route('logs.update', $selectedLog) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="slip-heading">
                        <h3>Edit Log</h3>
                    </div>
                    <div class="slip-grid">
                        <div class="slip-field">
                            <label for="date">Date Out</label>
                            <input type="date" id="date" name="departed_date" value="{{ $selectedLog->departed_at->format('Y-m-d') }}" required>
                        </div>
                        <div class="slip-field">
                            <label for="time_out">Time out</label>
                            <input type="time" id="time_out" name="departed_time" value="{{ $selectedLog->departed_at->format('H:i') }}" min="00:00" max="21:00" required>
                        </div>
                        <div class="slip-field">
                            <label for="return_date">Date In</label>
                            <input type="date" id="return_date" name="returned_date" value="{{ $selectedLog->returned_at->format('Y-m-d') }}" required>
                        </div>
                        <div class="slip-field">
                            <label for="return_time">Time In</label>
                            <input type="time" id="return_time" name="returned_time" value="{{ $selectedLog->returned_at->format('H:i') }}" min="00:00" max="21:00" required>
                        </div>
                        <div class="slip-field full">
                            <label>Notes</label>
                             <textarea name="notes">{{ $selectedLog->notes }}</textarea>
                        </div>
                        <div class="slip-field full">
                            <label class="pass-slip-label" style="font-size: 1.20rem; font-weight: 500;"><input type="checkbox" name="has_pass_slip" @checked($selectedLog->pass_slip_id)> With Pass Slip</label>
                        </div>
                    </div>
                    <div class="form-buttons">
                        <button class="btn-primary">Save</button>
                        <a href="{{ route('logs.index') }}" class="btn-primary">Close</a>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <br>
    <section>
        <header class="page-title">ACTIVITY LOGS <div class="logs-count">{{ $logs->count() }} Records</div></header>
    </section>
</x-layout>
