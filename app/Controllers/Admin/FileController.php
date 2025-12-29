<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class FileController extends BaseController
{
    /**
     * Download file yang diupload user
     */
    public function download($filename)
    {
        $filepath = WRITEPATH . 'uploads/' . $filename;
        
        // Security check: pastikan file ada dan dalam folder uploads
        if (!file_exists($filepath) || !is_file($filepath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }
        
        // Security check: pastikan path tidak keluar dari uploads folder
        $realPath = realpath($filepath);
        $uploadsPath = realpath(WRITEPATH . 'uploads/');
        
        if (strpos($realPath, $uploadsPath) !== 0) {
            return redirect()->back()->with('error', 'Akses file ditolak!');
        }
        
        // Detect MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filepath);
        finfo_close($finfo);
        
        // Set headers untuk download
        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', 'attachment; filename="' . basename($filename) . '"')
            ->setHeader('Content-Length', filesize($filepath))
            ->setBody(file_get_contents($filepath));
    }
}
