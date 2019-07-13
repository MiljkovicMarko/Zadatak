<?php
    return [
        App\Core\Route::get('|^.test/students/([0-9]+)/?$|',  'MainApi', 'getStudentReport')
    ];
