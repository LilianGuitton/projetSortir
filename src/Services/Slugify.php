<?php

namespace App\Services;

class Slugify
{

    public function slugify($string){
        $string = str_replace(" ", "-", $string);
        $string = strtolower($string);
        return $string;
    }

}