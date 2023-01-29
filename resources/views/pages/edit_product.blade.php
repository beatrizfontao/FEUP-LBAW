@extends('layouts.app')

@section('content')
    <div class="edit-form">
        <form method="POST" action='/product/{{ $product->id_product }}/edit_product' enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container">
                <fieldset>
                    <div class="col-md-12">
                        <!--Name field-->
                        <div class="form-group">
                            <label for="name" class="form-label mt-4">Name</label>
                            <input class="form-control" id="name" type="text" name="name" value=""
                                placeholder="{{ $product->name }}" autofocus>
                            @if ($errors->has('name'))
                                <span class="error">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>

                        <!--Description field-->
                        <div class="form-group">
                            <label for="description" class="form-label mt-4">Description</label>
                            <input class="form-control" id="description" type="text" name="description" value="">
                            @if ($errors->has('description'))
                                <span class="error">
                                    {{ $errors->first('description') }}
                                </span>
                            @endif
                        </div>

                        <!--Price field-->
                        <div class="form-group">
                            <label for="price" class="form-label mt-4">Price</label>
                            <input class="form-control" id="price" type="float" name="price" value=""
                                placeholder={{ $product->price }}>
                            <!--Check if the date is in the right format-->
                            @if ($errors->has('price'))
                                <span class="error">
                                    {{ $errors->first('price') }}
                                </span>
                            @endif
                        </div>

                        <!--Stock field-->
                        <div class="form-group">
                            <label for="stock" class="form-label mt-4">Stock</label>
                            <input class="form-control" id="stock" type="number" name="stock" value=""
                                placeholder={{ $product->stock }}>
                            <!--Check if the date is in the right format-->
                            @if ($errors->has('stock'))
                                <span class="error">
                                    {{ $errors->first('stock') }}
                                </span>
                            @endif
                        </div>

                        <!--Category field-->
                        <div class="form-group">
                            <label for="category" class="form-label mt-4">Category</label>
                            <select class="form-select" aria-label="category" id="category" name="category">
                                <option value="" selected hidden>Select your option</option>
                                @foreach ($categories as $category)
                                    <option value={{ $category->id_category }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!--Brand field-->
                        <div class="form-group">
                            <label for="brand" class="form-label mt-4">Brand</label>
                            <select class="form-select" aria-label="brand" id="brand" name="brand">
                                <option value="" selected hidden>Select your option</option>
                                @foreach ($brands as $brand)
                                    <option value={{ $brand->id_brand }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!--Product Picture field-->
                        <div class="form-group">
                            <label for="photo" class="form-label mt-4">Profile Pricture</label>
                            <input class="form-control" id="photo" type="file" name="photo"
                                accept=".jpg,.png, .jpeg" />
                            @if ($errors->has('photo'))
                                <span class="error">
                                    {{ $errors->first('photo') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" value={{ $product->id_product }} />
                </fieldset>

                <div class="col-md-12 text-center mt-2">
                    <button class="btn btn-primary mt-4" type="submit" style="width: 250px">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
