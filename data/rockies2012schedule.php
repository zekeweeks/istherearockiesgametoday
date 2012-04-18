<?php
/* From robflaherty on Github: https://gist.github.com/1185299 */
/* Not intended for public consumption; just for manual updates to schedule JSON.
   TODO: Remove escape backslashes, add encapsulating headers for drop-in file replacement.
 */
header('Content-type: application/json');
 
// Set your CSV feed
$feed = 'https://docs.google.com/spreadsheet/pub?key=0Asw39a0iCguZdC1YWnJwTlY1OE9yeFhWMHFWYTBIVkE&output=csv';
 
// Arrays we'll use later
$keys = array();
$newArray = array();
 
// Function to convert CSV into associative array
function csvToArray($file, $delimiter) { 
  if (($handle = fopen($file, 'r')) !== FALSE) { 
    $i = 0; 
    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
      for ($j = 0; $j < count($lineArray); $j++) { 
        $arr[$i][$j] = $lineArray[$j]; 
      } 
      $i++; 
    } 
    fclose($handle); 
  } 
  return $arr; 
} 
 
// Do it
$data = csvToArray($feed, ',');
 
// Set number of elements (minus 1 because we shift off the first row)
$count = count($data) - 1;
 
//Use first row for names  
$labels = array_shift($data);  
 
foreach ($labels as $label) {
  $keys[] = $label;
}
 
// Add Ids, just in case we want them later
$keys[] = 'id';
 
for ($i = 0; $i < $count; $i++) {
  $data[$i][] = $i;
}
 
// Bring it all together
for ($j = 0; $j < $count; $j++) {
  $d = array_combine($keys, $data[$j]);
  $newArray[$j] = $d;
}
 
// Print it out as JSON
echo json_encode($newArray);
 
?>