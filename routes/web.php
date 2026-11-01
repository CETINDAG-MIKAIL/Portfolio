<?php


use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $projects = config('projects');
    $experiences = config('experiences');
    $timeline = config('timeline');
    $languages = config('languages');
    $contact = config('contact');

    return view('welcome', [
        'projects' => $projects,
        'experiences' => $experiences,
        'timeline' => $timeline,
        'languages' => $languages,
        'contact' => $contact,
    ]);

});
