<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;




route::get('/', [HomeController::class, 'index']);
route::get('resume', [ResumeController::class, 'index']);
route::get('project', [ProjectController::class, 'index']);
route::get('contact', [ContactController::class, 'index']);
