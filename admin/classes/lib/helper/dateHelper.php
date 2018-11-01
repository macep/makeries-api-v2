<?php

function checkValidDate($date) {
  $tempDate = explode('-', $date);
  // checkdate(month, day, year)
  if (count($tempDate)!=3) {
    return false;
  }
  return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
}

function checkValidDateArray($data, $fields) {
  foreach ($fields as $field) {
    if (isset($data[$field]) && !checkValidDate($data[$field])) {
      $data[$field] = null;
    }
  }
  return $data;
}