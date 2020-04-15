<?php

return [
    '/' => 'HomeController@index',
    'blog' => 'BlogController@index',
    'blog/{id}' => 'BlogController@item',
];
