@extends('layouts.app')

@section('content')
<h2>Search for a user</h2>
<form action="/user_search" method="POST" enctype="multipart/form-data">
  @csrf
  
  <input class="form-check-input" type="radio" id="ID" name="option" value="1" checked>
  <label class="form-check-label" for="html">Search by ID</label><br>
  
  <input class="form-check-input" type="radio" id="Mail" name="option" value="2">
  <label class="form-check-label" for="css">Search by E-Mail</label><br>

  <label class="form-label mt-4" for="adr"><i class="fa fa-address-card-o"></i> User ID\E-MAIL</label>
  <input class="form-control" type="text" id="adr" name="id" placeholder="0" required>

  <input class="btn btn-primary my-4" type="submit" value="Search user" class="btn">
</form>
@endsection
