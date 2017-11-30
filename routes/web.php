<?php

Route::view('/', 'index');

Route::get('/reports', 'ReportsController@find');
