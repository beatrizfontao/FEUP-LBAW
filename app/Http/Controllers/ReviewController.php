<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\Report;

class ReviewController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'rating' => 'required|integer|between:0,5,',
            'title' => 'required|string|max:255',
            'text' => 'required',
        ]);
    }


    protected function create(array $data)
    {
        return Review::create([
            'rating' => $data['rating'],
            'title' => $data['title'],
            'text' => $data['text'],
            'id_user' => $data['id_user'], 
            'id_product' => $data['id_product'],
            'date' => $data['date']
        ]);
    }

    public function create_review(Request $request)
    {
        $data = $request->all();
        $validation = $this->validator($data);
        if ($validation->fails()) {
            return redirect('/product/' . $request->id);
        } 
        else{
            $data['id_user'] = Auth::user()->id_user;
            $data['id_product'] =  $request->id;
            $data['date'] = date("Y-m-d");
            $review = $this->create($data);
            return redirect()->intended('/product/' . $request->id);
        }
    }

    public function edit_review(Request $request){
        $data = $request->all();
        $review = Review::find($request->id);
        $validation = $this->validator($data);
        $review->title = $request->title;
        $review->text = $request->text;
        $review->rating = $request->rating;
        $review->date = date("Y-m-d");
        $review->save();
        return redirect()->intended('/product/' . $review->id_product);
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $review = Review::find($id);
        $reports = Report::where('id_review',$id)->delete();
        $review->delete();
        return $id;
    }
}
