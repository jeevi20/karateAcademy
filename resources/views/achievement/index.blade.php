@extends('layouts.admin.master')

@section('title', 'Students Achievements List')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
    <h2>Achievements</h2>
    <!-- <form action="{{ route('achievement.yearly_report_print') }}" method="GET" class="d-flex align-items-center mb-0">
        <label for="year" class="me-2 mb-0">Select Year:</label>
        <input type="number" name="year" id="year" min="2000" max="{{ date('Y') }}" value="{{ request('year') }}" class="form-control me-2" style="width: 100px;" />
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form> -->
</div>

    <div class="card-body">
        
    <form method="GET" action="{{ route('achievement.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by user ID or achievement name" value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>


        <br>

        @if($achievements->isEmpty())
            <p>No record found.</p>
        @else
            <table id="achievementTable" class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Stu ID</th>
                        <th>Reg.No</th>
                        <th>Achievement Type</th>
                        <th>Achievement Name</th>
                        <th>Date</th>
                        <th>Organization</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($achievements as $achievement)
                        <tr>
                            <td>{{ $achievement->student->id }}</td>
                            <td>{{ $achievement->student->student_reg_no }}</td> 
                            <td>{{ $achievement->formatted_achievement_type }}</td>
                            <td>{{ $achievement->achievement_name }}</td>
                            <td>{{ $achievement->achievement_date }}</td>
                            <td>{{ $achievement->organization_name }}</td>
                            <td>{{ $achievement->remarks }}</td>
                            <td>
                                <!-- Updated Edit Button -->
                                <a href="{{ route('achievement.edit', ['studentId' => $achievement->student->id, 'achievementId' => $achievement->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                
                                <!-- Delete Form -->
                                <form action="{{ route('achievement.destroy', $achievement->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#achievementTable').DataTable();
    });
</script>
@endsection
