@extends('layouts.admin.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

                <div class="float-left">
                    <h2> Announcements </h2>
                </div>

                <div class="float-right">
                    <!-- back to dashboard -->
                    <a href="{{ route('dashboard') }}" class="btn btn-dark" >Back</a>

                    <!-- add student button -->
                    <a class="btn btn-primary btn-md btn-rounded" href="{{route('announcement.create')}}" >
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
                    <thead td class="table-dark">
                        <tr>
                        <tr>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Date</th>
                            <th>Audience</th>
                            <th>Image</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                    @foreach($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td>
                            <div style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $announcement->body }}
                            </div>
                        </td>
                        <td>{{ $announcement->announcement_date }}</td>
                        <td>{{ ucfirst($announcement->audience) }}</td>
                        <td>
                            @if($announcement->image)
                                <img src="{{ asset('storage/' . $announcement->image) }}" alt="Announcement Image" width="80">
                            @else
                                No Image
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- Show Button -->
                            <a href="{{ route('announcement.show', $announcement->id) }}" class="btn btn-info btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            
                           <!-- Edit Button -->
                            <a href="{{ route('announcement.edit', $announcement->id) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>

                            <!-- Delete Button -->
                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"
                                    onclick="confirmDelete({{ $announcement->id }})">
                                <i class="fa fa-trash"></i>
                            </button>

                            <!-- Hidden Form for Each Announcement -->
                            <form id="deleteForm-{{ $announcement->id }}" action="{{ route('announcement.destroy', $announcement->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                                
                        </td>
                    </tr>
                @endforeach
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(announcementId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will delete this Announcement record.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                let deleteForm = document.getElementById(`deleteForm-${announcementId}`);
                deleteForm.submit();
            }
        });
    }
</script>

@endsection
