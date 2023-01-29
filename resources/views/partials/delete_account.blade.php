<div class="modal fade" id="delete_user_form" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" hidden>
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center fw-bold">
                Are you sure you want to delete this account?
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
                <h1 class="modal-title fs-5" id="delete-modal-label">Delete Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to delete this user?</h5>
            </div>
            <div class="modal-footer">
                <form method="DELETE"
                    action="{{ url('/user/' . $user->id_user . '/delete_user') }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <a href="/user/{{ $user->id_user }}" type="button" data-bs-dismiss="modal"
                        class="btn btn-primary">Cancel</a>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
