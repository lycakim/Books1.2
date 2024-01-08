@extends('user.user_dashboard')
@section('user')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('user.book.table')}}">Tables</a></li>
      <li class="breadcrumb-item active" aria-current="page">Book Table</li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 d-flex justify-content-between mb-2">
              <h6 class="card-title">Book Table</h6>
              <a href="{{ route('user.book.add') }}" class="btn btn-primary btn-icon-text">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Add new book
              </a>
            </div>
          </div>
          <div class="table-responsive">
            <table id="dataTableExample" class="table">
              <thead>
                <tr>
                  <th>Book Name</th>
                  <th>Book Description</th>
                  <th>Date Uploaded</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($books as $key => $items)
                <tr>
                  <td>{{$items->book_name}}</td>
                  <td class="text-truncate"
                    style="max-width: 50px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{$items->book_desc}}
                  </td>
                  <td>
                    {{date_format($items->created_at,"M-d-Y")}}
                  </td>
                  <td>
                    <a href="{{ route('user.book.edit', $items->id)}}" class="btn btn-outline-warning">Edit</a>
                    <a href="{{ route('user.book.delete', $items->id)}}" id="delete"
                      class="btn btn-outline-danger">Delete</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- @if (count($errors) > 0)
<script type="text/javascript">
$(document).ready(function() {
  $('#addBookModal').modal('show');
});
</script>
@endif -->
@endsection