<?php

function mandatoryFields($data, $fields) {
    foreach ($fields as $field)
        if (!isset($data[$field]))
            $data[$field] = null;
    return $data;
}