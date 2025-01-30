<?php

function cleanString(string $value): string
{
    return trim(htmlspecialchars($value, ENT_QUOTES));
}

function cleanJson($data): bool|string|null
{
    $data = json_decode($data);
        for($i = 0; $i < count($data); $i++) {
            $data[$i] = cleanString($data[$i]);
        }

    return json_encode($data);
}
