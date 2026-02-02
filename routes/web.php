<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DailyPlanner;

Route::get('/', DailyPlanner::class)->name('home');
