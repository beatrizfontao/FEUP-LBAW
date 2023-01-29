@php
$messsages = App\Http\Controllers\NotificationController::notifications();
@endphp
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i
        class="fas fa-bell"></i></a>
    <div class="dropdown-menu" style="overflow:scroll; height:400px;">
        @foreach ($messsages as $messsage)
        <div class="dropdown-item">
        <h5 style="max-width: 250px; word-wrap: break-all; white-space:normal;">{{ $messsage->pending }}</h5>        
        <p style="max-width: 250px; word-wrap: break-all; white-space:normal;">{{ $messsage->message }}</p>
        </div>
        @endforeach
    </div>
</li>