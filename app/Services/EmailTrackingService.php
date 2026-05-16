<?php

namespace App\Services;

class EmailTrackingService
{
    // 1×1 transparent GIF
    public const PIXEL_GIF = 'R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

    public static function wrapLinks(string $html, string $token): string
    {
        $clickBase = route('track.click', $token);

        return preg_replace_callback(
            '/href="(https?:\/\/[^"]+)"/i',
            function ($m) use ($clickBase) {
                $url = $m[1];
                // Never wrap unsubscribe or tracking links
                if (str_contains($url, '/unsubscribe/') || str_contains($url, '/track/')) {
                    return $m[0];
                }
                return 'href="' . $clickBase . '?to=' . rawurlencode($url) . '"';
            },
            $html
        ) ?? $html;
    }

    public static function injectPixel(string $html, string $token): string
    {
        $pixelUrl = route('track.open', $token);
        $pixel    = '<img src="' . $pixelUrl . '" width="1" height="1" alt="" style="display:none;border:0;">';

        if (stripos($html, '</body>') !== false) {
            return str_ireplace('</body>', $pixel . '</body>', $html);
        }
        return $html . $pixel;
    }

    public static function process(string $html, string $token): string
    {
        return self::injectPixel(self::wrapLinks($html, $token), $token);
    }
}
