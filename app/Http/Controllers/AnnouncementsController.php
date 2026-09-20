<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    public function index() {
        $announcements = [
            [
                'author' =>  'Aneen Andrada',
                'message'=> 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum'
            ],
            [
                'author' => 'Aneen Andrada',
                'message' => 'Sample sample SAMPLE'
            ]
        
        ];
        return view('home', ['announcements' => $announcements]);
    }
}
