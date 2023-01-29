<div class="text-center col-md-4" data-id="{{ $product->id_product }}">
    <div class="card my-3 mx-3" style="width: 300px">
        <div class="box mt-3">
          <a href="/product/{{ $product->id_product }}"><img href="/product/{{ $product->id_product }}" class="align-items-center" width="250" height="300" id="product_picture"
                src="{{ asset('storage/products/' . $product->photo) }}" alt="Photo of {{ $product->name }}"></a>
        </div>
        <div class="card-body">
            <h5 class="text-center"><a class="element-name"
                    href="/product/{{ $product->id_product }}">{{ $product->name }}</a></h4>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between">
            <h5 class="d-flex">
              Price
            </h5>
            <h5 class="d-flex">
              {{ $product->price }}
            </h5>
          </li>
        </ul>
    </div>
</div>
