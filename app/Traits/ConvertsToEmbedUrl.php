<?php

namespace App\Traits;

trait ConvertsToEmbedUrl
{
    /**
     * Convert a YouTube/Vimeo/direct file URL into an embeddable URL.
     */
    protected function convertToEmbedUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // ✅ Already an embed URL → return as-is
        if (
            str_contains($url, 'youtube.com/embed') ||
            str_contains($url, 'player.vimeo.com')
        ) {
            return $url;
        }

        // 🎥 YOUTUBE
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {

            preg_match(
                '/(youtu\.be\/|v=|embed\/|shorts\/)([^\&\?\/]+)/',
                $url,
                $matches
            );

            if (! empty($matches[2])) {
                return 'https://www.youtube.com/embed/'.$matches[2];
            }

            return null; // invalid youtube format
        }

        // 🎥 VIMEO
        if (str_contains($url, 'vimeo.com')) {

            preg_match('/vimeo\.com\/(\d+)/', $url, $matches);

            if (! empty($matches[1])) {
                return 'https://player.vimeo.com/video/'.$matches[1];
            }

            return null; // invalid vimeo format
        }

        // 🎬 Direct video file (mp4, webm, etc.)
        if (preg_match('/\.(mp4|webm|ogg)$/i', $url)) {
            return $url;
        }

        // 🔄 Fallback (return original)
        return $url;
    }
}
