<x-layout>
    <x-slot:title>Facial Recognition Logs</x-slot:title>
    <section>
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
                            <tr>
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
                                        <strong>{{ ucfirst($log->notes) }}</strong>
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
            </div>
        </div>
    </section>

    {{-- <style>
        .logs-table {
            width: 100%;
            min-width: 750px;
        }

        .logs-table thead {
            background: #f3f6ed;
        }

        .logs-table th {
            color: #315b49;
            text-align: left;
            padding: 17px 20px;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logs-table td {
            padding: 17px 20px;
            border-bottom: 1px solid #edf0eb;
            color: #40584c;
            font-size: 0.9rem;
        }

        .logs-table tbody tr {
            transition: background 0.2s ease;
        }

        .logs-table tbody tr:hover {
            background: #f8faf5;
        }

        .logs-table tbody tr:last-child td {
            border-bottom: none;
        }

        .log-id {
            color: #9aa99f !important;
            font-weight: 700;
        }

        .resident-name {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .resident-avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #dcebdc;
            color: #155b43;
            border-radius: 50%;
            font-weight: 800;
            font-size: 1rem;
        }

        .resident-name strong {
            display: block;
            color: #194b38;
            font-size: 0.9rem;
        }

        .resident-name small,
        .date-info small {
            display: block;
            color: #91a096;
            font-size: 0.78rem;
            margin-top: 4px;
        }

        .date-info strong {
            color: #40584c;
            font-size: 0.88rem;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 30px;
            font-size: 0.76rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .approved,
        .returned {
            background: #e0f2e5;
            color: #237343;
        }

        .pending,
        .outside {
            background: #fff0d4;
            color: #a36a13;
        }

        .no-slip {
            background: #f0eeee;
            color: #777;
        }

        .empty-state {
            text-align: center !important;
            padding: 65px 20px !important;
        }

        .empty-icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }

        .empty-state strong {
            display: block;
            color: #155b43;
            font-size: 1.1rem;
        }

        .empty-state p {
            color: #91a096;
            margin-top: 7px;
        }

        @media (max-width: 768px) {
            .logs-page {
                padding: 15px;
            }

            .logs-header h1 {
                font-size: 1.7rem;
            }

            .logs-card-header {
                padding: 18px;
                gap: 12px;
                flex-wrap: wrap;
            }

            .logs-table th,
            .logs-table td {
                padding: 14px;
            }
        }
    </style> --}}
</x-layout>
