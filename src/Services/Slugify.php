<?php

namespace App\Services;

class Slugify
{

    public function slugify($string){
        $string = str_replace(array(" ", "'", "_"), "-", $string);
        $string = strtolower($string);
        return $string;
    }

}