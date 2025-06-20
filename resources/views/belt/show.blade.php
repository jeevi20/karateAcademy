@extends('layouts.admin.master')
@section('title', 'Belt Details')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2>Belt Details</h2>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <td>{{ $belt->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $belt->belt_name }}</td>
                        </tr>
                        <tr>
                            <th>Rank</th>
                            <td>{{ $belt->rank }}</td>
                        </tr>
                        <tr>
                            <th>Belt Color</th>
                            <td>
                                <span class="badge rounded-pill" style="background-color: {{ strtolower($belt->color) }}; color: {{ in_array(strtolower($belt->color), ['white', 'yellow']) ? 'black' : 'white' }}; padding: 0.35em 0.85em;">
                                {{ $belt->color }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Requirements</th>
                            <td>{{ $belt->requirements }}</td>
                        </tr>
                        <tr>
                            <th>Maximum No of Attempts</th>
                            <td>{{ $belt->max_attempts }}</td>
                        </tr>
                    </table>
                </div>

                <a href="{{ route('belt.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('belt.edit', $belt->id ) }}" class="btn btn-warning">Edit</a>

            </div>
        </div>
    </div>
</div>

@endsection
