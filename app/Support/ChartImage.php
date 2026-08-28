<?php

namespace App\Support;

/**
 * Generate grafik sebagai gambar PNG murni pakai ekstensi GD bawaan PHP.
 *
 * Kenapa begini (bukan SVG atau Chart.js dijadikan gambar via JS)? Karena dompdf
 * terbukti gak reliable render SVG (kejadian di QR code sebelumnya), sedangkan
 * gambar PNG raster base64 sudah kepake mulus di project ini (logo, foto lampiran).
 * GD adalah ekstensi PHP yang hampir selalu aktif secara default di XAMPP/Laragon,
 * beda dengan Imagick yang harus diinstall manual.
 */
class ChartImage
{
    // True kalau ekstensi GD aktif. Dipakai buat fallback (misal ke tabel/bar CSS biasa)
    // kalau ternyata GD gak tersedia di server, daripada laporan PDF error/blank.
    public static function tersedia(): bool
    {
        return extension_loaded('gd');
    }

    // Grafik garis (tren), gaya mirip yang di halaman web: garis biru + gradasi tipis di bawahnya
    public static function garis(array $labels, array $data, int $width = 680, int $height = 220): ?string
    {
        if (!self::tersedia() || count($data) === 0) {
            return null;
        }

        $img = imagecreatetruecolor($width, $height);
        imagesavealpha($img, true);
        $white = imagecolorallocate($img, 255, 255, 255);
        imagefill($img, 0, 0, $white);

        $marginLeft = 42;
        $marginRight = 12;
        $marginTop = 12;
        $marginBottom = 26;
        $chartW = $width - $marginLeft - $marginRight;
        $chartH = $height - $marginTop - $marginBottom;

        $max = max(array_merge($data, [1]));
        $count = count($data);

        $gridColor = imagecolorallocate($img, 226, 232, 240);
        $textColor = imagecolorallocate($img, 100, 116, 139);
        $lineColor = imagecolorallocate($img, 11, 111, 180);
        $fillColor = imagecolorallocatealpha($img, 11, 111, 180, 100);

        // Gridline horizontal + label angka di kiri
        for ($i = 0; $i <= 4; $i++) {
            $y = (int) ($marginTop + $chartH - ($i / 4) * $chartH);
            imageline($img, $marginLeft, $y, $width - $marginRight, $y, $gridColor);
            $val = (string) round($max * $i / 4);
            imagestring($img, 2, 4, $y - 7, $val, $textColor);
        }

        $points = [];
        foreach (array_values($data) as $i => $val) {
            $x = $count > 1 ? $marginLeft + ($i / ($count - 1)) * $chartW : $marginLeft + $chartW / 2;
            $y = $marginTop + $chartH - ($max > 0 ? ($val / $max) * $chartH : 0);
            $points[] = [$x, $y];
        }

        if (count($points) >= 2) {
            // Area gradasi tipis di bawah garis
            $polygon = [];
            foreach ($points as $p) {
                $polygon[] = $p[0];
                $polygon[] = $p[1];
            }
            $polygon[] = end($points)[0];
            $polygon[] = $marginTop + $chartH;
            $polygon[] = $points[0][0];
            $polygon[] = $marginTop + $chartH;
            imagefilledpolygon($img, $polygon, (int) (count($polygon) / 2), $fillColor);

            // Garis penghubung titik
            imagesetthickness($img, 2);
            for ($i = 0; $i < count($points) - 1; $i++) {
                imageline($img, (int) $points[$i][0], (int) $points[$i][1], (int) $points[$i + 1][0], (int) $points[$i + 1][1], $lineColor);
            }
        }

        foreach ($points as $p) {
            imagefilledellipse($img, (int) $p[0], (int) $p[1], 6, 6, $lineColor);
        }

        // Label sumbu X -- dilewatin sebagian kalau titiknya kebanyakan, biar gak numpuk
        $labelValues = array_values($labels);
        $step = max(1, (int) ceil($count / 7));
        foreach ($labelValues as $i => $label) {
            if ($i % $step !== 0 && $i !== $count - 1) {
                continue;
            }
            $x = $count > 1 ? $marginLeft + ($i / ($count - 1)) * $chartW : $marginLeft + $chartW / 2;
            imagestring($img, 1, (int) $x - (strlen($label) * 2), $height - 16, $label, $textColor);
        }

        return self::keluarkanBase64($img);
    }

    // Grafik donat, warna sesuai palet yang dikasih. Sengaja TANPA teks label di dalam
    // gambar -- labelnya ditulis terpisah pakai HTML biasa di sebelah gambar (legend),
    // supaya teksnya tetap tajam (dirender font asli dompdf, bukan ikut jadi raster).
    public static function donat(array $data, array $warnaHex, int $size = 240): ?string
    {
        if (!self::tersedia() || count($data) === 0 || array_sum($data) <= 0) {
            return null;
        }

        $img = imagecreatetruecolor($size, $size);
        imagesavealpha($img, true);
        $transparan = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $transparan);
        imagealphablending($img, true);

        $total = array_sum($data);
        $cx = $size / 2;
        $cy = $size / 2;
        $diameter = $size - 10;
        $mulai = 0;

        foreach (array_values($data) as $i => $value) {
            $sapuan = ($value / $total) * 360;
            $akhir = $mulai + $sapuan;
            [$r, $g, $b] = self::hexKeRgb($warnaHex[$i % count($warnaHex)]);
            $warna = imagecolorallocate($img, $r, $g, $b);
            // +/-0.5 derajat overlap dikit biar gak ada garis putih tipis antar potongan
            imagefilledarc($img, (int) $cx, (int) $cy, $diameter, $diameter, (int) $mulai, (int) ceil($akhir), $warna, IMG_ARC_PIE);
            $mulai = $akhir;
        }

        // Lubang donat di tengah -- alphablending WAJIB dimatikan dulu di sini, soalnya kalau
        // nyala, warna transparan cuma "dicampur" (gak berefek) bukan "menimpa" pixel di bawahnya.
        imagealphablending($img, false);
        imagefilledellipse($img, (int) $cx, (int) $cy, (int) ($diameter * 0.55), (int) ($diameter * 0.55), $transparan);
        imagesavealpha($img, true);

        return self::keluarkanBase64($img);
    }

    private static function hexKeRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
    }

    private static function keluarkanBase64($img): string
    {
        ob_start();
        imagepng($img);
        $binary = ob_get_clean();
        imagedestroy($img);

        return base64_encode($binary);
    }
}
