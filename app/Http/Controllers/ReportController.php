<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Report;
use App\Models\Review;

class ReportController extends Controller
{

  public function list()
  {
    $this->authorize('management',Auth::user());
    $reports = Report::where('status', 'Waiting')->get();
    foreach ($reports as $report) {
      $review= Review::find($report->id_review);
      $report->text = $review->text;
      $report->title = $review->title;
      $report->target = $review->id_user;
    }
    return view('pages.reports', ['reports' => $reports]);
  }

    protected function create(array $data)
    {
        return Report::create([
            'status' => $data['status'],
            'motive' => $data['motive'],
            'id_user' => $data['id_user'], 
            'id_review' => $data['id_review'],
            'date' => $data['date']
        ]);
    }

    public function create_report(Request $request)
    {
        $data = $request->all();
        $data['motive'] = $request->motive;
        $data['id_user'] = Auth::user()->id_user;
        $data['id_review'] =  $request->id;
        $data['date'] = date("Y-m-d");
        $data['status'] = "Waiting";
        $report = $this->create($data);
        return $report;
    }
  
    public function dismiss(Request $request)
    {
        $data = $request->all();
        $report = DB::table('report')
        ->where('id_user',$request->id_user)
        ->where('id_review',$request->id_review)
        ->where('motive',$request->motive)
        ->update(['status' => 'Done']);
        return $report;
    }
}
