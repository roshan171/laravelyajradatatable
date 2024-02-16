@extends('layouts.app')

   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
  <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
@section('title')
    Student Data
@endsection
@section('content')


<div class="container mt-3">
    <div class="card shadow m-2">

    @if ($message = session('success'))
    <div class="alert alert-success mx-1" role="alert">
        {{ $message }}
    </div>
     @endif
    <h2 class=" text-center mt-2">Student Data</h2>
    <div class="mt-5">

         <a href="{{ route('student.export') }}" class="btn btn-success m-2">
             Export Data
        </a>

        <a href="{{ route('student.create') }}" class="btn btn-primary">
            Add Data
         </a>
  
    </div>
    
    <div class="col-md-6 ml-auto m-2">
        
            <form action="{{ route('student.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Choose Excel File</label>
            <input type="file" name="file" id="file" class="form-control">
        </div>
        <button type="submit" class="btn btn-info m-2 text-white">Import</button>
    </form>
                 </div>
      

    <table class="table mt-5" id="student-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Action</th>
            </tr>
        </thead>
    </table> 
    
</div>  
</div>
@endsection
<script type="text/javascript">
     
 $(document).ready( function () {
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
$('#student-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ url('student') }}",
    columns: [
        { 
            data: 'id', 
            name: 'id', 
            render: function (data, type, row, meta) {
                // Calculate the incremental ID based on the row index
                return meta.row + 1;
            }
        },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'city', name: 'city' },
        { data: 'action', name: 'action', orderable: false },
    ],
    order: [[0, 'desc']] // Order by the first column (ID) in ascending order
});

   $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-student') }}",
            data: { id: id},
            dataType: 'json',
            success: function(res){

              var oTable = $('#student-table').dataTable();
              oTable.fnDraw(false);
           }
        });
       }

     });
 });

</script>
