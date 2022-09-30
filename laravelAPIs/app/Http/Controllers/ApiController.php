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

// function that takes a number and returns each place value
function placeValue($num=""){
  $array  = array_map('intval', str_split($num));
  $length = count($array);
  $response = [];
  for($i=0; $i<$length; $i++){
    $digits = $length - ($i+1);
    $value = $this->realValue($array[$i], $digits);
    $response = Arr::add($response, $array[$i], $value);
  }
  return response()->json([
     $response
  ]);
   }

// function to generate the place value of the given number
function realValue($num, $digits){
  $array  = array_map('intval', str_split($num));
  for($i=0; $i<$digits; $i++){
    array_push($array, "0");
  }
  $number = implode("", $array);
  $num = (int)$number;
  return $num;
}

// function to translate from Human to Programmer language
function toProgrammer(Request $request){
  $message = $request->message;
  preg_match_all('!\d+!', $message, $numbers);
  $response = [];
  foreach ($numbers as $key => $value) {
    foreach ($value as $keys => $values) {
      $binary =  decbin($values);
      $message = str_replace($values, $binary, $message);
    }
  }

  return response()->json([
    $request->message=> $message
  ]);
}

// function that evaluates a prefix notation
function evaluatePrefix(Request $request){
  $prefix = $request->expression;
  $prefix = explode(" ", $prefix);
  $result = $this->calculatePrefix($prefix);
  return response()->json([
    "result"=>$result
  ]);
}

// function to calculate prefix notation
function calculatePrefix($prefix){
  $stack = [];
  $i = count($prefix)-1;
  while ($i>=0) {
    if(!$this->isOperator($prefix[$i])){
      array_push($stack, $prefix[$i]);
      $i= $i-1;
    }
    else{
      $o1 = array_pop($stack);
      $o2 = array_pop($stack);
      if($prefix[$i] =='+'){
        array_push($stack,$o1+$o2);
      }
      else if($prefix[$i] =='-'){
      array_push($stack,$o1-$o2);
      }
      else if($prefix[$i] =='*'){
        array_push($stack, $o1*$o2);
      }
      else if($prefix[$i] =='/'){
        array_push($stack, $o1/$o2);
      }
      $i= $i-1;
    }
  }
  return array_pop($stack);
}

// function to check if the symbol is an operator
function isOperator($o){
  if($o == "*" || $o == "+" || $o == "-" || $o == "/" || $o == "^"){
    return True;
  }
  else{
    return False;
  }
}
}
