<?php
function mp_site_settings(): array {
    static $s = null;
    if ($s === null) {
        $f = __DIR__ . '/../data/settings.json';
        $s = file_exists($f) ? (json_decode(file_get_contents($f), true) ?? []) : [];
    }
    return $s;
}
function mp_s(string $key, string $default = ''): string {
    return htmlspecialchars(mp_site_settings()[$key] ?? $default);
}
function mp_sr(string $key, string $default = ''): string {
    return mp_site_settings()[$key] ?? $default;
}
