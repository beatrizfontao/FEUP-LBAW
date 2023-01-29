<?php  use App\Models\User;  ?>
<div class="modal fade" id="staticBackdrop-{{ $review->id_review }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Report</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="report_review-{{ $review->id_review }}">
      @csrf
        <div class="modal-body report_form" id="report_form-{{ $review->id_review }}">
              <label for="motive"><b>Motive</b></label>
              <textarea class="form-control" name="motive" id="motive-{{ $review->id_review }}" placeholder="Write your report..." rows="3" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary send_report" id="{{ $review->id_review }}">Send</button>
        </div>
      </form>
    </div>
  </div>
</div>

<form method="POST" id="edit_review-{{$review->id_review}}" hidden>
    @csrf
    @method('PUT')
    <div class="card text-white bg-primary mb-3"> 
        <div class="card-header"> 
            <input name="id" value="{{$review->id_review}}" hidden>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <span class="star-rating">
                <label class= "star_label-edit label_1" id=1 for="1_star-{{$review->id_review}}"><i class="fa-regular fa-star"></i></label>
                <input type="radio" name="rating" value="1" id= "1_star-{{$review->id_review}}" required>
                <label class= "star_label-edit label_2" id=2 for="2_star-{{$review->id_review}}"><i class="fa-regular fa-star"></i></label>
                <input type="radio" name="rating" value="2" id= "2_star-{{$review->id_review}}" required>
                <label class= "star_label-edit label_3" id=3 for="3_star-{{$review->id_review}}"><i class="fa-regular fa-star"></i></label> 
                <input type="radio" name="rating" value="3" id= "3_star-{{$review->id_review}}" required>
                <label class= "star_label-edit label_4" id=4 for="4_star-{{$review->id_review}}"><i class="fa-regular fa-star"></i></label>
                <input type="radio" name="rating" value="4" id= "4_star-{{$review->id_review}}" required>
                <label class= "star_label-edit label_5" id=5 for="5_star-{{$review->id_review}}"><i class="fa-regular fa-star"></i></label>
                <input type="radio" name="rating" value="5" id= "5_star-{{$review->id_review}}" required>
            </span>
            </div>
            <button id="{{$review->id_review}}" class="btn btn-primary confirm_edit_review" type="submit" style="float: right;"><i class="fa-solid fa-check"></i></button>
        </div>
        <div class="card-body">
            <input value="{{$review->title}}" type="text" class="form-control" name="title" id="edit_title-{{$review->id_review}}" placeholder="Title" style="width: 30% ; margin-bottom: 5px" required>
            <textarea class="form-control" name="text" id="edit_text-{{$review->id_review}}" placeholder="Write your review" required rows="3" style="height: 80px;">{{$review->text}}</textarea>
        </div>
    </div>
</form>
<div id="review-{{$review->id_review}}"class="card bg-light mb-3">
  <div class="card-header">
  {{$review->date}} {{User::find($review->id_user)->name}}
  @if(Auth::check())
    @if(Auth::user()->id_user == $review->id_user)
    <button type="button" class="btn-close remove_review" data-bs-dismiss="modal" aria-label="Close" style="float: right;" id="{{$review->id_review}}"></button> 
    <button type="button" class="edit_review" data-bs-dismiss="modal" aria-label="Close" style="float: right;color:#808a94;background-color:transparent;background-repeat:no-repeat;border: none;" id="{{$review->id_review}}">
    <i class="fa-solid fa-pen-to-square"></i></button> 
    @else
    <button type="button" class="" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $review->id_review }}" style="float: right;color:#808a94;background-color:transparent;background-repeat:no-repeat;border: none;"><i class="fa-solid fa-flag"></i></button>
    @endif
  @endif
    <input value="{{$review->rating}}" id="rating-{{$review->id_review}}" hidden>
    @if($review->rating==0)
    <div class="rating" style="float: right;">
                <i class="fa-regular fa-star"></i> <i class="fa-regular fa-star"></i> <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i> <i class="fa-regular fa-star"></i>
            </div>
        @elseif($review->rating == 1)
            <div class="rating" style="float: right;">
                <i class="fa-solid fa-star"></i> <i class="fa-regular fa-star"></i> <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i> <i class="fa-regular fa-star"></i>
            </div>
        @elseif($review->rating == 2)
            <div class="rating" style="float: right;">
                <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-regular fa-star"></i> <i
                    class="fa-regular fa-star"></i> <i class="fa-regular fa-star"></i>
            </div>
        @elseif($review->rating == 3)
            <div class="rating" style="float: right;">
                <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                    class="fa-regular fa-star"></i> <i class="fa-regular fa-star"></i>
            </div>
        @elseif($review->rating == 4)
            <div class="rating" style="float: right;">
                <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                    class="fa-solid fa-star"></i> <i class="fa-regular fa-star"></i>
            </div>
        @elseif($review->rating == 5)
            <div class="rating mx-3" style="float: right;">
                <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                    class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i>
            </div>
        @endif
    </div>
    <div class="card-body">
        <h4 class="card-title">{{ $review->title }}</h4>
        <p class="card-text">{{ $review->text }}</p>
    </div>
</div>
