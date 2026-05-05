@include('manager.header')
@include('manager.navbar')

<div class="content-wrapper-scroll">
    <div class="main-header d-flex align-items-center justify-content-between position-relative">
        <div class="d-flex align-items-center justify-content-center">
            <div class="page-icon"><i class="bi bi-cash-coin"></i></div>
            <div class="page-title d-none d-md-block">
                <h5>All Withdrawals</h5>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        @if(session('message'))
            <div class="alert alert-success mb-2">{{ session('message') }}</div>
        @endif

        <!-- Stats Row -->
        <div class="row gx-3 mb-4">
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Total Withdrawals</h6>
                        <h4 class="fw-bold text-dark">{{ $totalWithdrawal }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Approved Amount</h6>
                        <h4 class="fw-bold text-success">${{ number_format($activeWithdrawal, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Pending Amount</h6>
                        <h4 class="fw-bold text-warning">${{ number_format($inactiveWithdrawal, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="row gx-3">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">All Client Withdrawals</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Client Name</th>
                                        <th>Client Email</th>
                                        <th>Amount</th>
                                        <th>Wallet Address</th>
                                        <th>Transaction ID</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($withdrawal as $with)
                                        @php $client = $user->firstWhere('id', $with->user_id); @endphp
                                        <tr>
                                            <td>{{ $with->id }}</td>
                                            <td>{{ $client->name ?? 'N/A' }}</td>
                                            <td>{{ $client->email ?? 'N/A' }}</td>
                                            <td>${{ number_format($with->amount, 2) }}</td>
                                            <td class="text-truncate" style="max-width:130px;" title="{{ $with->wallet_address }}">{{ $with->wallet_address }}</td>
                                            <td>{{ $with->transaction_id }}</td>
                                            <td>
                                                @if($with->status == '1')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($with->status == '0')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($with->status == '2')
                                                    <span class="badge bg-danger">Declined</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($with->created_at)->format('M j, Y g:i A') }}</td>
                                            <td>
                                                @if($with->user_id)
                                                    <a href="{{ url('profile/'.$with->user_id) }}" class="btn btn-sm btn-outline-secondary">View User</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($withdrawal->isEmpty())
                                        <tr><td colspan="9" class="text-center text-muted">No withdrawals found</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('manager.footer')
