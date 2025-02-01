<?php
function cleanString(string $value): string
{
    return trim(htmlspecialchars($value, ENT_QUOTES));
}

function cleanJson($data): bool|string
{
    $data = json_decode($data, true);
    cleanArray($data);
    return json_encode($data);
}

function cleanArray(&$array): void
{
    foreach ($array as &$item) {
        if (is_array($item)) {
            cleanArray($item);
        } else {
            $item = cleanString($item);
        }
    }
}
