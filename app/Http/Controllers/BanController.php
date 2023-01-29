<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Ban;
use App\Models\Review;
use App\Models\Report;

class BanController extends Controller
{
    
    protected function create(array $data)
    {
        return Ban::create([
            'motive' => $data['motive'],
            'id_admin' => $data['id_admin'], 
            'id_customer' => $data['id_customer'],
            'date' => $data['date']
        ]);
    }

    public function create_ban(Request $request)
    {
        $data = $request->all();
        $data['motive'] = $request->motive;
        $data['id_admin'] = Auth::user()->id_user;
        $data['id_customer'] =  $request->id;
        $data['date'] = date("Y-m-d");
        $reports = Report::where('id_review',$request->id_review)->delete();
        $review = Review::where('id_review',$request->id_review)->delete();
        $ban = $this->create($data);
        return $ban;
    }
}
