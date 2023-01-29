<div class="modal fade" id="delete_product_form" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" hidden>
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body text-center fw-bold">
             Are you sure you want to delete this product?
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="delete-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="delete-modal-label">Delete Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to delete this product?</h5>
            </div>
            <div class="modal-footer">
                <form action={{ "/product/$product->id_product/delete" }} method="DELETE"
                    id="delete_product-{{ $product->id_product }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <a href="/product/{{ $product->id_product }}" type="button" data-bs-dismiss="modal" class="btn btn-primary">Cancel</a>
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>
            </div>
        </div>
    </div>
</div>