@extends('vendor.irando.country-codes.app')
@section('content')
    <div class="row mt-5 mb-5 justify-content-center">
        <div class="col-md-4 mb-3">
            @if(isset($country))
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit</h5>
                        <form method="POST" action="{{route('country-codes.update', $country->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control" value="{{$country->code}}" name="code" placeholder="code">
                                </div>
                                <div class="col-md-12 mb-1">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" value="{{$country->country}}" name="country" placeholder="country">
                                </div>
                                <div class="col-md-12 mb-1">
                                    <label for="phone_name">Phone Name</label>
                                    <input type="text" class="form-control" value="{{$country->phone_name}}" name="phone_name" placeholder="phone_name">
                                </div>
                                <div class="col-md-12 mb-1">
                                    <label for="phone_code">Phone Code</label>
                                    <input type="text" class="form-control" value="{{$country->phone_code}}" name="phone_code" placeholder="phone_code">
                                </div>
                            </div>

                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                <a href="{{route('country-codes.index')}}" class="btn btn-warning btn-sm">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add New Country</h5>
                        <form action="{{route('country-codes.store')}}" method="post">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control" name="code" placeholder="code">
                                </div>
                                <div class="col-md-12 mb-1">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" name="country" placeholder="country">
                                </div>
                                <div class="col-md-12 mb-1">
                                    <label for="phone_name">Phone Name</label>
                                    <input type="text" class="form-control" name="phone_name" placeholder="phone_name">
                                </div>
                                <div class="col-md-12 mb-1">
                                    <label for="phone_code">Phone Code</label>
                                    <input type="text" class="form-control" name="phone_code" placeholder="phone_code">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Country Codes</h5>
                    @if(count($countries) > 0)
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Country</th>
                                    <th>Phone Name</th>
                                    <th>Phone Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($countries as $country)
                                    <tr>
                                        <td>{{ $country->code }}</td>
                                        <td>{{ $country->country }}</td>
                                        <td>{{ $country->phone_name }}</td>
                                        <td>{{ $country->phone_code }}</td>
                                        <td width="60">
                                            <div class='btn-group'>
                                                <a href="{{route('country-codes.edit', $country->id)}}" class='btn btn-default btn-sm'><i data-feather="edit"></i></a>
                                                <form style="display: inline;" action="{{route('country-codes.destroy', $country->id)}}" onclick= "return confirm('Are you sure?')" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i data-feather="trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <h3 class="text-danger"><i data-feather="alert-triangle"></i> You have no country in your list. Try to seed database.</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="footer mb-3">
        <a href="https://irando.co.id" class="text-dark" target="_blank" rel="no-follow"><i data-feather="globe"></i></a>
        <a href="https://github.com/robertnicjoo/country-codes" class="text-dark" target="_blank" rel="no-follow"><i data-feather="github"></i></a>
    </div>
@endsection
