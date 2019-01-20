<?php

function urlGroupRestriction($url, $name, $className = null, $returnEmpty = false, $alertClick = false) {
  if (!Logged::isViewOnly()) {
    return '<a href="'.$url.'"'.(strlen($className)? ' class="'.$className.'"':'').($alertClick ? " onclick=\"return confirm('Are you sure?');\"" : '').'>'.$name.'</a>';
  } else {
    if ($returnEmpty)
      return null;
    else
      return $name;
  }
}
