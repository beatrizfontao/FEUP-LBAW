<article class="mb-3" data-id="{{ $order->id_order }}">
    <h2><a class="element-name" href='/user/{{$user->id_user}}/order/{{$order->id_order}}'>{{ 'Order #' . $order->id_order }}</a></h2>
    <h5> {{ 'Placed in: ' . $order->date }} </h5>
</article> 