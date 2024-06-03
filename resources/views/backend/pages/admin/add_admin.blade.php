@extends('admin.admin_dashboard')
@section('admin')

<div class = "page-content">

    <div class= "row profile body">

    <div class="col-md-8 col-xl-8 middle-wrapper">
        <div class="row">
          <div class="card">
            <div class="card-body">

        <h6 class= "card-title"> Add Admin </h6>

 <form id="myForm" method="POST" action="{{ route('store.admin') }}" 
 class="forms-sample">

    @csrf

    <div class="form-group mb-3">
<label for="exampleInputEmail1" class="form-label1"> Admin User Name</label>

  <input type="text" name="username" class="form-control">
    </div>

    <div class="form-group mb-3">
<label for="exampleInputEmail1" class="form-label1"> Admin Name</label>
  <input type="text" name="name" class="form-control">
    </div>

    <div class="form-group mb-3">
<label for="exampleInputEmail1" class="form-label1"> Admin Email</label>
  <input type="email" name="email" class="form-control">
    </div>

    <div class="form-group mb-3">
<label for="exampleInputEmail1" class="form-label1"> Admin Phone</label>
  <input type="text" name="phone" class="form-control">
    </div>

    <div class="form-group mb-3">
<label for="exampleInputEmail1" class="form-label1"> Admin Address</label>
  <input type="text" name="address" class="form-control">
    </div>

    <div class="form-group mb-3">
<label for="exampleInputEmail1" class="form-label1"> Admin Password</label>
  <input type="text" name="password" class="form-control">
    </div>

    <div class="form-group mb-3">
<label for="exampleInputEmail1" class="form-label1"> Role Name </label>
<select name="roles" class="form-select" id="exampleFOrmControlSelect1">
                                           
      <option selected="" disabled ="">Select Role</option>
      @foreach($roles as $role)
      <option value="{{ $role->id }}">{{ $role->name }}</option>
      @endforeach
</select>
    
    </div>

    <button type="submit" class="btn btn-primary me-2">Save Changes</button>

</form>
  </div>
</div>

    </div>
  </div>

</div>

   </div>

@endsection 