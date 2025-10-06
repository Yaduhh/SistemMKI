<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemInfoController extends Controller
{
    public function uploadInfo()
    {
        $info = [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'max_input_time' => ini_get('max_input_time'),
            'file_uploads' => ini_get('file_uploads') ? 'Enabled' : 'Disabled',
            'max_file_uploads' => ini_get('max_file_uploads'),
            'upload_tmp_dir' => ini_get('upload_tmp_dir'),
        ];

        return response()->json($info);
    }

    public function testUpload(Request $request)
    {
        if ($request->hasFile('test_file')) {
            $file = $request->file('test_file');
            $info = [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'is_valid' => $file->isValid(),
                'error' => $file->getError(),
                'error_message' => $file->getErrorMessage(),
            ];

            return response()->json([
                'success' => true,
                'file_info' => $info
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ]);
    }
}
