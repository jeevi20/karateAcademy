@extends('layouts.admin.master')
@section('title','Belt List')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <h2>Belts</h2>
                </div>
            </div>
            <br>

            <div class="card-body">
                
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                
                <table id="myTable" class="display">
                    <thead td class="table-dark">
                        <tr>
                        <th >ID</th>
                        <th >Name</th>
                        <th >Rank</th>
                        <th >Color</th>
                        <th >Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($belts as $belt)
                    <tr>
                        <td>{{ $belt->id }}</td>
                        <td>{{ $belt->belt_name }}</td>
                        <td>{{ $belt->rank }}</td>
                        <td>
                            <!-- <span class="badge rounded-pill" style="background-color: {{ strtolower($belt->color) }}; color: {{ strtolower($belt->color) === 'white' ? 'black' : 'white' }};">
                            {{ $belt->color }}
                            </span> -->

                            <span class="badge rounded-pill" style="background-color: {{ strtolower($belt->color) }}; color: {{ in_array(strtolower($belt->color), ['white', 'yellow']) ? 'black' : 'white' }}; padding: 0.35em 0.85em;">
                            {{ $belt->color }}
                            </span>
                        </td>

                        <td>
                            <!-- Show Button -->
                            <a href="{{ route('belt.show', $belt->id ) }}" class="btn btn-info btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            <!-- Edit Button -->
                            <a href="{{ route('belt.edit', $belt->id ) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>   
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    
                </table>

                <div class="pt-2">
                <div class="float-right">
                  
                </div>
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
