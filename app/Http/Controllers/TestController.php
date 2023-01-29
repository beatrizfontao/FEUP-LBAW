<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Added to support email sending.
use Mail;
use App\Mail\MailtrapExample;
use App\Models\User;


class TestController extends Controller
{
    // sendEmail method.
    public function sendEmail(request $data) {
        $input = $data->all();
        $email = $input["email"];

        if (User::where('email', '=', $email)->exists()) {
            Mail::to($email)->send(new MailtrapExample($email));
            return redirect('/');
         }
           
        return redirect('/recover_password');
    }
}

?>