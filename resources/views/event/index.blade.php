@extends('layouts.admin.master')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <h2> Events </h2>
                </div>

                <div class="float-right">
                    <!-- Back to dashboard -->
                    <a href="{{ route('dashboard') }}" class="btn btn-dark">Back</a>

                    <!-- Add event button -->
                    <a class="btn btn-primary btn-md btn-rounded" href="{{ route('event.create') }}">
                        <i class="mdi mdi-plus-circle mdi-18px"></i> <i class='fas fa-plus' style="color:white"></i> Add
                    </a>
                </div>
            </div>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="card-body">
                <table id="myTable" class="display">
                    <thead class="table-dark">
                        <tr>
                            <th> ID </th>
                            <th> Title </th>
                            <th> Event Type </th>
                            <th> Date </th>
                            <th> Location </th>
                            <th> Status</th>
                            <th> Actions </th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->title }}</td>
                            <td>{{ ucfirst($event->event_type) }}</td>
                            <td>{{ $event->event_date }}</td>
                            <td>{{ $event->location ?? 'N/A' }}</td>
                            <td>
                                
                            </td>

                            <td>
                                <!-- Show Button -->
                                <a href="{{ route('event.show', $event->id) }}" class="btn btn-info btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('event.edit', $event->id) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <!-- Delete Button -->
                                <button class="btn btn-danger btn-sm rounded-0" type="button" onclick="confirmDelete({{ $event->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            <form id="deleteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(eventId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will delete this event record.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Set the form action dynamically
                let deleteForm = document.getElementById("deleteForm");
                deleteForm.action = `/events/${eventId}/destroy`;
                deleteForm.submit();
            }
        });
    }
</script>

@endsection
