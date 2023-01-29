@extends('layouts.app')

@section('content')
    <div class="product-form">
        <form method="POST" action='/product/add_product' enctype="multipart/form-data">
            @csrf
            <div class="container">
                <fieldset>
                    <!--Name field-->
                    <div class="form-group">
                        <label for="name" class="form-label mt-4">Name<span style="color: red">*</span></label>
                        <input class="form-control" id="name" type="text" name="name" value="" autofocus required>
                        @if ($errors->has('name'))
                            <span class="error">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>

                    <!--Description field-->
                    <div class="form-group">
                        <label for="description" class="form-label mt-4">Description<span style="color: red">*</span></label>
                        <input class="form-control" id="description" type="text" name="description" value="" required>
                        @if ($errors->has('description'))
                            <span class="error">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </div>

                    <!--Price field-->
                    <div class="form-group">
                        <label for="price" class="form-label mt-4">Price<span style="color: red">*</span></label>
                        <input class="form-control" id="price" type="number" name="price" value="" required>
                        <!--Check if the date is in the right format-->
                        @if ($errors->has('price'))
                            <span class="error">
                                {{ $errors->first('price') }}
                            </span>
                        @endif
                    </div>

                    <!--Stock field-->
                    <div class="form-group">
                        <label for="stock" class="form-label mt-4">Stock<span style="color: red">*</span></label>
                        <input class="form-control" id="stock" type="number" name="stock" value="" required>
                        @if ($errors->has('stock'))
                            <span class="error">
                                {{ $errors->first('stock') }}
                            </span>
                        @endif
                    </div>

                    <!--Category field-->
                    <div class="form-group">
                        <label for="category" class="form-label mt-4">Category<span style="color: red">*</span></label>
                        <select class="form-select" aria-label="category" id="category" name="category" required>
                            <option value="" selected hidden>Select your option</option>
                            @foreach ($categories as $category)
                                <option value={{$category->id_category}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--Brand field-->
                    <div class="form-group">
                        <label for="brand" class="form-label mt-4">Brand<span style="color: red">*</span></label>
                        <select class="form-select" aria-label="brand" id="brand" name="brand" required>
                            <option value="" selected hidden>Select your option</option>
                            @foreach ($brands as $brand)
                                <option value={{$brand->id_brand}}>{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--Product Picture field-->
                    <div class="form-group">
                        <label for="photo" class="form-label mt-4">Profile Pricture<span style="color: red">*</span></label>
                        <input class="form-control" id="photo" type="file" name="photo" accept=".jpg,.png, .jpeg" required/>
                        @if ($errors->has('photo'))
                            <span class="error">
                                {{ $errors->first('photo') }}
                            </span>
                        @endif
                    </div>

                    <button class="btn btn-primary mt-4" type="submit">Create Product</button>
                </fieldset>
            </div>
        </form>
    </div>
@endsection
