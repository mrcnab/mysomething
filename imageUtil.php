<?php
function generateAutoString($length = 5)
{
  $autoString = "";
  $possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
  $i = 0; 
  while ($i < $length) { 

    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    if (!strstr($autoString, $char)) { 
      $autoString .= $char;
      $autoString .= "  ";
      $i++;
    }
  }
  
  return $autoString;
}
?>