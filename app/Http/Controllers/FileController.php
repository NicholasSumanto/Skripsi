<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function getURLPromosi($id, $type, $filename, Request $request)
    {
        $path = "private/promosi/$id/$type/$filename";
        $fullPath = storage_path("app/$path");

        if (!file_exists($fullPath)) {
            abort(404, 'File not found');
        }

        $size = filesize($fullPath);
        $file = fopen($fullPath, 'rb');

        $start = 0;
        $length = $size;
        $status = 200;
        $headers = [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
        ];

        if ($request->headers->has('Range')) {
            preg_match('/bytes=(\d+)-(\d*)/', $request->header('Range'), $matches);

            $start = intval($matches[1]);
            $end = isset($matches[2]) && $matches[2] !== '' ? intval($matches[2]) : $size - 1;
            $length = $end - $start + 1;

            fseek($file, $start);
            $status = 206; // Partial content
            $headers['Content-Range'] = "bytes $start-$end/$size";
            $headers['Content-Length'] = $length;
        } else {
            $headers['Content-Length'] = $length;
        }

        return response()->stream(
            function () use ($file, $length) {
                $buffer = 1024 * 8;
                while (!feof($file) && $length > 0) {
                    $read = $length > $buffer ? $buffer : $length;
                    echo fread($file, $read);
                    flush();
                    $length -= $read;
                }
                fclose($file);
            },
            $status,
            $headers,
        );
    }

    public function getURLLiputan($id, $filename, Request $request)
    {
        $path = "private/liputan/$id/$filename";
        $fullPath = storage_path("app/$path");

        if (!file_exists($fullPath)) {
            abort(404, 'File not found');
        }

        $size = filesize($fullPath);
        $file = fopen($fullPath, 'rb');

        $start = 0;
        $length = $size;
        $status = 200;
        $headers = [
            'Content-Type' => 'application/pdf',
            'Accept-Ranges' => 'bytes',
        ];

        if ($request->headers->has('Range')) {
            preg_match('/bytes=(\d+)-(\d*)/', $request->header('Range'), $matches);

            $start = intval($matches[1]);
            $end = isset($matches[2]) && $matches[2] !== '' ? intval($matches[2]) : $size - 1;
            $length = $end - $start + 1;

            fseek($file, $start);
            $status = 206; // Partial content
            $headers['Content-Range'] = "bytes $start-$end/$size";
            $headers['Content-Length'] = $length;
        } else {
            $headers['Content-Length'] = $length;
        }

        return response()->stream(
            function () use ($file, $length) {
                $buffer = 1024 * 8;
                while (!feof($file) && $length > 0) {
                    $read = $length > $buffer ? $buffer : $length;
                    echo fread($file, $read);
                    flush();
                    $length -= $read;
                }
                fclose($file);
            },
            $status,
            $headers,
        );
    }

    public function getVideoThumbnailTemp($id, $type, $filename)
    {
        $videoPath = storage_path("app/private/promosi/$id/$type/$filename");

        if (!file_exists($videoPath)) {
            abort(404, 'Video file not found');
        }

        $tmpDir = storage_path('app/tmp');
        if (!file_exists($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }

        $thumbnailPath = $tmpDir . '/' . uniqid() . '.jpg';

        $command = "ffmpeg -y -i \"{$videoPath}\" -ss 00:00:01.000 -vframes 1 \"{$thumbnailPath}\"";

        shell_exec($command);

        if (!file_exists($thumbnailPath)) {
            abort(500, 'Thumbnail generation failed');
        }

        return response()->file($thumbnailPath)->deleteFileAfterSend(true);
    }
}
