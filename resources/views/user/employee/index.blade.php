
<a href="{{route('user.employee.create')}}" class="btn btn-primary btn-sm text-right">Add New Employee</a>
<table class="table datatable-button-html5-basic">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Designation</th>
            <th>Created At</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach (Auth::user()->employees as $employee_key => $employee)
        <tr>
            <td>{{$employee_key+1}}</td>
            <td>{{$employee->name }}</td>
            <td>{{$employee->phone}}</td>
            <td>{{$employee->address}}</td>
            <td>{{$employee->designation}}</td>
            <td>{{$employee->created_at->format('d M,Y')}}</td>
            <td>
                <a href="{{route('user.employee.edit',$employee->id)}}" class="btn btn-primary btn-sm">Edit</a>
            </td>
            <td>
                <form action="{{route('user.employee.destroy',$employee->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>