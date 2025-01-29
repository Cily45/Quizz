<?php

function cleanString(string $value): string
{
    return trim(htmlspecialchars($value, ENT_QUOTES));
}

function cleanJson($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = cleanJson($value);
            if ($data[$key] === null) {
                unset($data[$key]);
            }
        }
    }  elseif ($data === null) {
        return null;
    }
    return $data;
}
