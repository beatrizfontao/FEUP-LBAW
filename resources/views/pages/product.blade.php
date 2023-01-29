@extends('layouts.app')

@section('title', $product->name)

@section('content')
    @include('partials.delete_product')
    <div class="col-md-12 mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="img-container ms-3 mb-3">
                            <img class="img-fluid" width="350" height="400" id="product_picture"
                                src="{{ asset('storage/products/' . $product->photo) }}"
                                alt="Photo of {{ $product->name }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h2 class="mb-4"><a class="element-name"
                                    href="/product/{{ $product->id_product }}">{{ $product->name }}</a>
                            </h2>
                            <div class="my-3">
                                <h4> Price: {{ $product->price }} €</h4>
                                <h5 class="">{{ $product->description }}</h5>
                            </div>
                        </div>

                        @if (Auth::check() && !Auth::user()['is_admin'])
                            <div class="d-flex mx-4">
                                <button class='remove btn btn-primary px-2 me-2' id="{{ $product->id_product }}"
                                    style="width: 30px height: 30px"><i class="text-center fa-solid fa-minus"></i></button>
                                <div class='prodnum fs-4' id="numof{{ $product->id_product }}">
                                    {{ $productcount }}
                                </div>
                                <button class='buy btn btn-primary px-2 mx-2' id="{{ $product->id_product }}"><i
                                        class="text-center fa-solid fa-plus"></i></button>


                                @if ($wishlist)
                                    <button hidden class='wishlist btn btn-primary px-2 ms-2' name="addwishlistbutton"
                                        id="{{ $product->id_product }}"style="width: 30px height: 30px"><i
                                            class="fa-regular fa-heart"></i></button>
                                    <button class='removewishlist btn btn-primary px-2 ms-2' name="removewishlistbutton"
                                        id="{{ $product->id_product }}"style="width: 30px height: 30px"><i
                                            class="fa-solid fa-heart"></i></button>
                                @else
                                    <button class='wishlist btn btn-primary px-2 ms-2' name="addwishlistbutton"
                                        id="{{ $product->id_product }}"style="width: 30px height: 30px"><i
                                            class="fa-regular fa-heart"></i></button>
                                    <button hidden class='removewishlist btn btn-primary px-2 ms-2'
                                        name="removewishlistbutton"
                                        id="{{ $product->id_product }}"style="width: 30px height: 30px"><i
                                            class="fa-solid fa-heart"></i></button>
                                @endif
                            </div>

                        @endif

                        <div class="mx-3">
                            @if (Auth::check() && Auth::user()['is_admin'])
                                <a class="btn btn-primary mt-4 mx-1" href="/product/{{ $product->id_product }}/edit"> Edit
                                    Product
                                </a>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modal-form"
                                    class="btn btn-danger mt-4 mx-2">Delete Product</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="mt-4">
                <h3>Reviews
                    @if (Auth::check() && !Auth::user()['is_admin'] && $checkbuy)
                        <button id="open_review"
                            style="color:#303c54;background-color:transparent;background-repeat:no-repeat;border: none;"><i
                                class="fa-solid fa-circle-plus"></i></button>
                        <button id="close_review"
                            style="color:#303c54;background-color:transparent;background-repeat:no-repeat;border: none;"
                            hidden><i class="fa-solid fa-circle-minus"></i></button>
                    @endif
                </h3>
                <form method="POST" id="create_review" action="/product/{{ $product->id_product }}" hidden>
                    @csrf
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">
                            <input name="id" value="{{ $product->id_product }}" hidden>
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <span class="star-rating">
                                    <label class="star_label" id=1 for="1_star"><i class="fa-regular fa-star"></i></label>
                                    <input type="radio" name="rating" value="1" id="1_star" required>
                                    <label class="star_label" id=2 for="2_star"><i class="fa-regular fa-star"></i></label>
                                    <input type="radio" name="rating" value="2" id="2_star" required>
                                    <label class="star_label" id=3 for="3_star"><i class="fa-regular fa-star"></i></label>
                                    <input type="radio" name="rating" value="3" id="3_star" required>
                                    <label class="star_label" id=4 for="4_star"><i class="fa-regular fa-star"></i></label>
                                    <input type="radio" name="rating" value="4" id="4_star" required>
                                    <label class="star_label" id=5 for="5_star"><i
                                            class="fa-regular fa-star"></i></label>
                                    <input type="radio" name="rating" value="5" id="5_star" required>
                                </span>
                            </div>
                            <button class="btn btn-primary" type="submit" style="float: right;"><i
                                    class="fa-solid fa-check"></i></button>
                        </div>
                        <div class="card-body">
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Title" style="width: 30% ; margin-bottom: 5px" required>
                            <textarea class="form-control" name="text" id="text" placeholder="Write your review" required
                                rows="3" style="height: 80px;"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            @each('partials.review', $reviews, 'review')
        </div>
    </div>
@endsection
