<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller {
    public function index() {
        return Inertia::render('Home', [
            'title' => 'Home Page',
        ]);
    }


    public function about() {
        return Inertia::render('About', [
            'title' => 'About Page',
        ]);
    }
}