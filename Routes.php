<?php
    return [
        App\Core\Route::get('|^students/([0-9]+)/?$|',  'MainApi', 'getStudentReport')
    ];
