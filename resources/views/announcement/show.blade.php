@extends('layouts.admin.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2>Announcement Details</h2>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th> ID </th>
                            <td> {{ $announcement->id }} </td>
                        </tr>
                        <tr>
                            <th> Title</th>
                            <td> {{ $announcement->title }} </td>
                        </tr>
                        <tr>
                            <th>Body</th>
                            <td>{{ $announcement->body  }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{$announcement->announcement_date}}</td>
                        </tr>
                        <tr>
                            <th>Audience</th>
                            <td>{{$announcement->audience}}</td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                            @if($announcement->image)
                                <img src="{{ asset('storage/' . $announcement->image) }}" alt="Announcement Image" width="80">
                            @else
                                No Image
                            @endif
                            </td>
                        </tr>
                        
                    </table>
                </div>

                <a href="{{ route('announcement.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('announcement.edit', $announcement->id) }}" class="btn btn-warning">Edit</a>

            </div>
        </div>
    </div>
</div>

@endsection


