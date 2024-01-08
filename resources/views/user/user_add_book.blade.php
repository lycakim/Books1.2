@extends('user.user_dashboard')
@section('user')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <form class="forms-sample" method="POST" enctype="multipart/form-data"
            action="{{ $booksData ? route('user.save.changes') : route('user.upload.book') }}" id="bookForm">
            <div class="modal-body">
              @csrf
              <input type="hidden" value="{{$booksData ? $booksData[0]->id : ''}}" name="id">
              <div class="mb-3">
                <label for="book_name" class="form-label">Book Name</label>
                <input type="text" class="form-control @error('book_name') is-invalid @enderror"
                  value="{{$booksData ? $booksData[0]->book_name : ''}}" id="book_name" name="book_name"
                  placeholder="Book Name" autofocus>
              </div>

              <div class=" mb-3">
                <label for="book_desc" class="form-label">Book Description</label>
                <textarea type="text" class="form-control" id="book_desc" name="book_desc"
                  placeholder="Book Description" rows="5">
                  @if (count($booksData) > 0)
                  @foreach ($booksData as $com)
                  {{$com->book_desc}}
                  @endforeach
                  @endif
                </textarea>
              </div>
              @if(count($booksData) > 0)
              <div class="mb-3">
                <label for="exampleInputPhoto1" class="form-label">Photo</label>
                <input type="file" name="cover_image" class="form-control" id="cover_image">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"></label>
                <img id="showImage" class="img-lg rounded-circle"
                  src="{{ !empty($booksData[0]->cover_image) ? url('upload/cover_images/'.$booksData[0]->cover_image) : url('upload/no_image.jpg') }}"
                  alt="">
              </div>
              <?php
              $id = auth()->user()->id;
              // $checkedd = false;
              // $bookID = $booksData[0]->id;
              $users = App\Models\User::where('id','!=',$id)->latest()->get();
              // $users->put('isAllowed', false);
              // $books = App\Models\Books::where('id', $bookID)->latest()->get();
              // foreach($users as $data){
              //   if($books[0]->allowed_users[0] !== $data->id){
              //    $data->isAllowed = true;
              //   }
              // }
              $jsonData = json_encode($booksData);
              
              // echo App\Models\User::isAllowed($users, $books);
              ?>
              <script>
              $(document).ready(function() {
                var data = <?php echo $jsonData; ?>;
                var parsed = JSON.parse(data[0]['allowed_users']);
                for (let index = 0; index < parsed.length; index++) {
                  $("#allowUser option[value='" + parsed[index] + "']").attr("selected", "selected");
                  console.log(parsed[index]);
                }
                $("#gate option[value='Gateway 2']").prop('selected', true);
                // you need to specify id of combo to set right combo, if more than one combo
              });
              </script>
              <!-- <label for="exampleInputPhoto1" class="form-label">Allowed Users</label>
              @foreach($users as $key=> $data)
              <div class="">
                <input type="checkbox" id="checkDefault{{$data->id}}" {{ $data->isAllowed ? 'checked':''}}
                  value="{{$data->id}}" name="allowed_users[]">
                <label for="checkDefault{{$data->id}}" class="form-label">{{$data->name}}</label>
              </div>
              @endforeach -->
              <div class="mb-3">
                <label class="form-label">Allowed Users</label>
                <select name="allowed_users[]" id="allowUser" class="js-example-basic-multiple form-select"
                  multiple="multiple" data-width="100%">
                  @foreach($users as $ke => $data)
                  <option value="{{$data->id}}">{{$data->name}}</option>
                  @endforeach
                </select>
              </div>
              @endif
              <div>
                @if (count($booksData) > 0)
                <button type="submit" class="btn btn-primary">Update</button>
                @else
                <button type="submit" class="btn btn-primary">Upload</button>
                @endif
                <button type="button" onclick="window.location='{{ route("user.book.table") }}'"
                  class="btn btn-secondary">Back to
                  table</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- @if (count($booksData) > 0)
<script>
console.log('{{$booksData[0]->book_desc}}');
</script>
@endif -->

<script type="text/javascript">
$(document).ready(function() {
  $("#cover_image").change(function(e) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#showImage').attr('src', e.target.result)
    }
    reader.readAsDataURL(e.target.files['0']);
  });
});
</script>
@endsection