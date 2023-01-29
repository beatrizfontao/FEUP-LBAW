<div id="profile-side-menu" class="col-md-2 mt-3">
    <a class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#profile-options"><i
            class="fa-solid fa-bars"></i></a>
    <div class="collapse" id="profile-options">
        <div class="row">
            @if (Auth::user()['is_admin'])
                <a class="col-sm-12 text-decoration-none" href='/user/{{ $user["id_user"] }}'>{{ $user["name"] }}'s Profile</a>
                <a class="col-sm-12 text-decoration-none" href='/user/{{ $user["id_user"] }}/addresses/'>{{ $user["name"] }}'s Addresses</a>
                <a class="col-sm-12 text-decoration-none" href='/user/{{ $user["id_user"] }}/orders/'>{{ $user["name"] }}'s Orders</a>
                <a class="col-sm-12 text-decoration-none" href='/user/{{ $user["id_user"] }}/past_orders/'>{{ $user["name"] }}'s Order History</a>
            @else
                <a class="col-sm-12 text-decoration-none" href='/user/{{ Auth::user()->id_user }}'>My Profile</a>
                <a class="col-sm-12 text-decoration-none" href='/user/{{ Auth::user()->id_user }}/addresses/'>My Addresses</a>
                <a class="col-sm-12 text-decoration-none" href='/user/{{ Auth::user()->id_user }}/orders/'>My Orders</a>
                <a class="col-sm-12 text-decoration-none" href='/user/{{ Auth::user()->id_user }}/past_orders/'>My Order History</a>
            @endif
        </div>
    </div>
</div>
