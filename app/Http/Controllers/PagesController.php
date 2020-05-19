<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //Send variables to pages 
    // public function about($data){
    //     $god = "I am GOD";
    //     return view('pages.about',compact('data'),compact('god'));
    //}
    public function about(){
        return view('pages.about');
    }
}
