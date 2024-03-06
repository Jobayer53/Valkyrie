@extends('layouts.dashboard')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12 m-auto">
        {{-- alert --}}
            @if (session('dlt'))
            <div class="alert alert-danger">{{session('dlt')}}</div>
            @endif
            {{-- alert --}}
            <div class="card">
                <div class="card-header">
                    <h3>User List </h3>
                    <span class="" style="float: right;">Total User : {{$total_user}} </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>PHOTO</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>CREATED AT</th>
                            <th>ACTION</th>
                        </tr>

                        @foreach ($user_data as $key=> $user)

                        <tr>

                            <td> {{$key+1}} </td>
                            <td>
                                @if ($user->image == null)
                                    <img width="50" src="{{ Avatar::create($user->name)->toBase64(); }}" alt="">
                                @else
                                    {{-- <img width="50" src="{{ asset('uploads/users/')}}/{{$user->image}}" alt=""> --}}
                                @endif

                            </td>
                            <td> {{$user->name}} </td>
                            <td> {{$user->email}} </td>
                            <td> {{$user->created_at->diffForHumans()}} </td>
                            <td>
                                <a href="{{ route('user.delete', $user->id) }} " class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
