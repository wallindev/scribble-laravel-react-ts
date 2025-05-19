<?php

/**
 * Helper functions
 */
function longDateStr(?string $dateStr = null, ?string $format = null): string {
  return (new DateTime($dateStr ?? ''))->format($format ?? 'l F jS Y \a\t H:i');
}

function contentStub(string $text, ?int $length = 50): string {
  return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
}

function newLineToBr(string $text): string {
  return str_replace(PHP_EOL, '<br>', $text);
}
