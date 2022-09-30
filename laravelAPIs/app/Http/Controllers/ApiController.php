<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;



class ApiController extends Controller
{
  // function to sort a given String
function sortString($string =""){
 $numbers = (string) filter_var($string, FILTER_SANITIZE_NUMBER_INT);
 $sortedNumbers = $this->sortNumbers($numbers);

 preg_match_all('/[A-Z]/', $string, $upper);
 $sortedUpper = $this->sortUpper($upper);

 preg_match_all('/[a-z]/', $string, $lower);
 $sortedLower = $this->sortLower($lower);

 foreach ($sortedLower as $key => $lower) {
   foreach ($sortedUpper as $key => $upper) {
     echo $this->compareLetters($lower, $upper);
   }
 }

 return response()->json([
      "string"=>$string,
      "sortednumber"=>$sortedNumbers,
      "sorted Upper"=>$sortedUpper,
      "sorted Lower"=>$sortedLower
    ]);
}


// function to sort the upper letters of a String
function sortUpper($upperletters){
  $upperLetters = [];
  foreach ($upperletters as $key => $value) {
    foreach ($value as $keys => $values) {
      array_push($upperLetters, $values);
    }
  }
  sort($upperLetters);
  //$upper =  implode('', $upperLetters);
  return $upperLetters;

}

// function to sort the lower letters of a String
function sortLower($lowerletters){
  $lowerLetters = [];
  foreach ($lowerletters as $key => $value) {
    foreach ($value as $keys => $values) {
      array_push($lowerLetters, $values);
    }
  }
  sort($lowerLetters);
  //$lower =  implode('', $lowerLetters);
  return $lowerLetters;
}

// function to sort the numbers of a String
function sortNumbers($numbers){
  $numbers = str_split($numbers);
  sort($numbers);
  $numbers = implode('', $numbers);
  return $numbers;
}

function compareLetters($lower, $upper){
  return strcmp($lower, $upper);
}
}
