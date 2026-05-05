@include('manager.header')
@include('manager.navbar')

<div class="main-content" id="mainContent">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 mb-1">Total Users</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus me-1"></i> Add User
        </button>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Users Table Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 py-3">
            <h5 class="mb-0 text-dark">All Users</h5>
            <div class="d-flex gap-2 flex-wrap">
                <select class="form-select form-select-sm" id="numofrecord" style="width:auto;">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                    <option value="999999">All</option>
                </select>
                <select class="form-select form-select-sm" id="order" style="width:auto;">
                    <option value="desc">Newest first</option>
                    <option value="asc">Oldest first</option>
                </select>
                <input type="text" id="searchitem" class="form-control form-control-sm" placeholder="Search name or email..." style="width:220px;">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="userslisttbl">
                        @foreach($user as $index => $users)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $users->name }} {{ $users->lname ?? '' }}</td>
                            <td>{{ $users->email }}</td>
                            <td>
                                @if($users->user_status == '1')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($users->created_at)->format('M j, Y g:i A') }}</td>
                            <td>
                                <a href="{{ url('admin/profile/' . $users->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Manage
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('add.user') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter full name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Search
    document.getElementById('searchitem').addEventListener('keyup', function () {
        const search = this.value.toLowerCase();
        document.querySelectorAll('#userslisttbl tr').forEach(row => {
            const name = row.cells[1]?.textContent.toLowerCase() ?? '';
            const email = row.cells[2]?.textContent.toLowerCase() ?? '';
            row.style.display = (name.includes(search) || email.includes(search)) ? '' : 'none';
        });
    });

    // Sort & paginate
    function applySort() {
        const numPerPage = parseInt(document.getElementById('numofrecord').value);
        const order = document.getElementById('order').value;
        const tbody = document.getElementById('userslisttbl');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        rows.sort((a, b) => {
            const aVal = parseInt(a.cells[0]?.textContent.trim()) || 0;
            const bVal = parseInt(b.cells[0]?.textContent.trim()) || 0;
            return order === 'asc' ? aVal - bVal : bVal - aVal;
        });

        rows.forEach((row, i) => {
            tbody.appendChild(row);
            row.style.display = i < numPerPage ? '' : 'none';
        });
    }

    document.getElementById('numofrecord').addEventListener('change', applySort);
    document.getElementById('order').addEventListener('change', applySort);
    window.addEventListener('load', applySort);
</script>

@include('manager.footer')