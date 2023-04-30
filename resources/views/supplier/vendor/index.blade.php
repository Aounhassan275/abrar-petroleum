<div class="card-header header-elements-inline text-right">
    <a href="{{route('user.vendor.create')}}" class="btn btn-primary btn-sm text-right">Add New Supplier</a>
</div>
<table class="table datatable-button-html5-basic">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach(App\Models\Supplier::all() as $supplier)
        <tr>
            <td></td>
            <td>{{$supplier->name}}</td>
            <td>{{$supplier->email}}</td>
            <td colspan="3" class="text-center">Global Supplier</td>
        </tr>
        @endforeach
        @foreach (Auth::user()->vendors as $key => $vendor)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$vendor->name}}</td>
            <td>{{$vendor->phone}}</td>
            <td>{{$vendor->address}}</td>
            <td>
                <a href="{{route('user.vendor.edit',$vendor->id)}}" class="btn btn-primary btn-sm">Edit</a>
            </td>
            <td>
                <form action="{{route('user.vendor.destroy',$vendor->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
