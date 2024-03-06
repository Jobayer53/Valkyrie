@extends('layouts.dashboard')
@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped" >
                    <tr>
                        <th>SL</th>
                        <th>COUPON</th>
                        <th>DISCOUNT</th>
                        <th>EXPIRE DATE</th>
                        <th>ACTION</th>
                    </tr>
                    @foreach ($coupons as $key=> $coupon)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $coupon->coupon_name }}</td>
                        <td>{{ ($coupon->type == 2)?'৳':'' }} {{ $coupon->discount }}{{ ($coupon->type == 1)?'%':'' }}</td>
                        <td>{{ $coupon->expire_date }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                   
                                    <a class="dropdown-item" href="{{ route('coupon.delete',$coupon->id) }}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Coupon</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('add.coupon') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for=""class="form-label">Coupon Name</label>
                        <input type="text" name="coupon_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for=""class="form-label">Discount %</label>
                        <input type="number" name="discount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for=""class="form-label">Expire Date</label>
                        <input type="date" name="expire_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for=""class="form-label">Type</label>
                       <select name="type" class="form-control" >
                        <option value=""> -- Select Type --</option>
                        <option value="1"> Percentage</option>
                        <option value="2"> Solid Amount</option>
                       </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" >Add Coupon</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>


@endsection