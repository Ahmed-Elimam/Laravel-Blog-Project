<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
public function someAction(){
    $localName = 'Mona';
    $age = 27;
   return view('test',['age'=>$age,
    'name'=>$localName, 'job'=>"Engineer"
    ]);
}
}
