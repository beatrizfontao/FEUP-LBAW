@extends('layouts.app')

@section('title', 'Order')

@section('content')
<div class="row">
    <div class="col-md-10 my-4 mt-4">
        <h2>{{ 'Order #' . $order->id_order }}</h2>
        <h6>{{ 'Order placed in ' . $order->date . '.' }}</h6>
        <h6>{{ 'Total: ' . $order->total_price }}</h6>
        <h6>{{ 'Payment Method Used: ' . $order->payment_method }}</h6>

        <div id="current_status">
            <h6>Status: <span id="status_name">{{ $status->name }}</span>
                @if (Auth::check() && Auth::user()['is_admin'] && $status !== 'Finished')
                    <button onclick="show_menu()"><i class="fa-solid fa-pencil"></i></button>
                @endif
            </h6>
        </div>
        <div id="change_status" class="form-group" style="display: none">
            <h6>Status:
                @if ((Auth::check() || Auth::user()['is_admin']) && $status !== 'Finished')
                    <select id="status_list" name="id_order_status" onchange="getSelectedValue()">
                        @foreach ($stages as $order_status)
                            <option value="{{ $order_status->id_order_status }}">
                                {{ $order_status->name }}
                            </option>
                        @endforeach
                    </select>
                    <button id="save_changes" onclick="show_menu()" class="btn btn-primary ms-3" type="submit">Change
                        State</button>
                @endif
            </h6>
        </div>
    </div>

        @include('partials.sidemenu')

</div>

    <div id="id_order" display="none" value={{ $order->id_order }}></div>

    <section id="products">
        @each('partials.product', $order->products($order->id_order), 'product')
    </section>
@endsection
