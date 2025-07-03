@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="h3 mb-3 text-gray-800">Data Users</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="text-white" style="background-color: #034078;">
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody class="bg-light">
                @foreach($users as $user)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username}}</td>
                    <td>{{ $user->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection