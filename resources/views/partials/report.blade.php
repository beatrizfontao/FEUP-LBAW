<div motive="{{ $report->motive }}" user="{{ $report->id_user }}" review="{{$report->id_review}}" class="card text-white bg-primary mb-3" style="max-width: 20rem; margin:1em;">
  <div class="card-header">Motive -> {{ $report->motive }}   <button style="float:right;" class="btn btn-close close_report"></button></div>
  <div class="card-body">
    <h4 class="card-title">{{ $report->title }}</h4>
    <p class="card-text">{{ $report->text }}  </p>
    <p class="card-text">User {{ $report->id_user}} reported User {{ $report->target }}</p>
  </div>
  <div class="card-footer">
    Ban user<button data-bs-toggle="modal" data-bs-target="#ban-{{$report->target}}" style="color:white;background-color:transparent;background-repeat:no-repeat;border: none;"><i class="fa-solid fa-ban"></i></button>
    Only delete review<button data-bs-toggle="modal" data-bs-target="#delete_review_modal-{{$report->id_review}}" style="color:white;background-color:transparent;background-repeat:no-repeat;border: none;"><i class="fa-solid fa-eraser"></i></button>
  </div>
</div>
    
   

<div class="modal fade" id="delete_review_modal-{{$report->id_review}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Confirmation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete review {{$report->id_review}} ? 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <form>
        <button href="" id="{{$report->id_review}}" class="delete_review_by_report btn btn-primary">Yes</button>
        </form> 
    </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ban-{{$report->target}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Ban Confirmation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to ban User {{$report->target}} ? 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <form> 
        <button type="submit" motive="{{$report->motive}}" review="{{$report->id_review}}" id="{{$report->target}}" class="ban_by_report btn btn-primary">Yes</button>
        </form> 
    </div>
    </div>
  </div>
</div>