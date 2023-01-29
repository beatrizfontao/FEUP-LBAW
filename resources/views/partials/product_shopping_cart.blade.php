<?php use App\Http\Controllers\ProductController; ?>

<div class="text-center col-md-4" data-id="{{ $product->id_product }}" id="cart_product_{{ $product->id_product }}">
    <div class="card my-3 mx-3" style="width: 300px">


        <div class="box mt-3">
            <img class="align-items-center" width="250" height="300" id="product_picture"
                src="{{ asset('storage/products/' . $product->photo) }}" alt="Photo of {{ $product->name }}">
        </div>
        <div class="card-body">
            <h5 class="text-center"><a class="element-name"
                    href="/product/{{ $product->id_product }}">{{ $product->name }}</a></h4>
        </div>

        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
                <div class="d-flex">
                    Price
                </div>
                <div class="d-flex">
                    {{ $product->price }}
                </div>
            </li>
        </ul>

        <!--add/remove-->
        <div class="d-flex my-4 ps-5 mx-5" style="max-width: 30px max-height: 30px">
            <button class='remove btn btn-primary px-3 me-2' id="{{ $product->id_product }}"><i
                    class="fa-solid fa-minus"></i></button>
            <div class="form-outline">
                <div class='prodnum col-sm-4' id="numof{{ $product->id_product }}">
                    {{ ProductController::count_prod($product->id_product) }}
                </div>
            </div>
            <button class='buy btn btn-primary px-3 ms-2' id="{{ $product->id_product }}"><i
                    class="fa-solid fa-plus"></i></button>
        </div>
    </div>
</div>
