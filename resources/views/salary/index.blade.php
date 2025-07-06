@extends('layouts.admin.master')

@section('title','Staffs Salary Record')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Salary Record</h2>
                <a href="{{ route('dashboard') }}" class="btn btn-dark">Back</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card-body">
                <table id="myTable" class="display table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Reference No</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Paid Amount</th>
                            <th>Paid Method</th>
                            <th>Paid Date</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salaries as $salary)
                            @php
                                $type = \Illuminate\Support\Str::startsWith($salary->notes, 'instructor:') ? 'Instructor' : 'Branch Staff';
                                $id = \Illuminate\Support\Str::after($salary->notes, ':');
                                $name = $type === 'Instructor'
                                    ? \App\Models\Instructor::find($id)?->user->name
                                    : \App\Models\User::find($id)?->name;
                            @endphp
                            <tr>
                                <td>{{ $salary->reference_no }}</td>
                                <td>{{ $type }}</td>
                                <td>{{ $name  }}</td>
                                <td>{{ ucfirst($salary->salary_status) }}</td>
                                <td>{{ $salary->paid_amount ?? 'N/A' }}</td>
                                <td>{{ $salary->paid_method ?? 'N/A' }}</td>
                                <td>{{ $salary->paid_date ? \Carbon\Carbon::parse($salary->paid_date)->format('d M Y') : 'N/A' }}</td>
                                <td>{{ $salary->notes ?? 'N/A' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $salary->id }}">
                                        Edit
                                    </button>
                                </td>

                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="editModal{{ $salary->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $salary->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('salary.update', $salary->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Salary</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="paid_amount" class="form-label">Paid Amount</label>
                                                    <input type="number" step="0.01" name="paid_amount" class="form-control" value="{{ $salary->paid_amount }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="paid_method" class="form-label">Paid Method</label>
                                                    <select name="paid_method" class="form-control">
                                                        <option value="">-- Select --</option>
                                                        @foreach(['Cash', 'Bank Transfer', 'Cheque', 'Other'] as $method)
                                                            <option value="{{ $method }}" {{ $salary->paid_method === $method ? 'selected' : '' }}>{{ $method }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="notes" class="form-label">Add Note</label>
                                                    <textarea name="notes" class="form-control" placeholder="Enter additional note (will be appended)"></textarea>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Save</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8">No salary records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
@endsection


