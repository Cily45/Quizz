<?php

function cleanString(string $value): string
{
    return trim(htmlspecialchars($value, ENT_QUOTES));
}

function cleanJson($data): string {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = cleanJson($value);
        }
    } else {
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    return $data;
}