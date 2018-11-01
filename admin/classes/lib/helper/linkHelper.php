<?php

function urlGroupRestriction($url, $name, $className = null, $returnEmpty = false) {
  if (!Logged::isViewOnly()) {
    return '<a href="'.$url.'"'.(strlen($className)? ' class="'.$className.'"':'').'>'.$name.'</a>';
  } else {
    if ($returnEmpty)
      return null;
    else
      return $name;
  }
}
