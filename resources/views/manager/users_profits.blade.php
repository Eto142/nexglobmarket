@include('manager.header')
@include('manager.navbar')

<div class="content-wrapper-scroll">
    <div class="main-header d-flex align-items-center justify-content-between position-relative">
        <div class="d-flex align-items-center justify-content-center">
            <div class="page-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="page-title d-none d-md-block">
                <h5>All Profits</h5>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        @if(session('message'))
            <div class="alert alert-success mb-2">{{ session('message') }}</div>
        @endif

        <div class="row gx-3">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">All Client Profits</h5>
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
                                        <th>Transaction ID</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($profit as $pro)
                                        @php $client = $user->firstWhere('id', $pro->user_id); @endphp
                                        <tr>
                                            <td>{{ $pro->id }}</td>
                                            <td>{{ $client->name ?? 'N/A' }}</td>
                                            <td>{{ $client->email ?? 'N/A' }}</td>
                                            <td>${{ number_format($pro->amount, 2) }}</td>
                                            <td>{{ $pro->transaction_id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pro->created_at)->format('M j, Y g:i A') }}</td>
                                            <td>
                                                @if($pro->user_id)
                                                    <a href="{{ url('profile/'.$pro->user_id) }}" class="btn btn-sm btn-outline-secondary">View User</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($profit->isEmpty())
                                        <tr><td colspan="7" class="text-center text-muted">No profits found</td></tr>
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
