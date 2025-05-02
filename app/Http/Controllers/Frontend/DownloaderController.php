<?php

namespace App\Http\Controllers\Frontend;

use App\Entities\backend\SelfDevelopmentFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DownloaderController extends Controller
{

    public function profilePictureAttachment(Request $request, $docFileId)
    {
        $profilePictureAttachment = SelfDevelopmentFile::where('self_development_file_id', $docFileId)->first();

        if($profilePictureAttachment) {
            if($profilePictureAttachment->doc_file && $profilePictureAttachment->doc_file_type && $profilePictureAttachment->doc_file_name) {
                $content = base64_decode($profilePictureAttachment->doc_file);

                return response()->make($content, 200, [
                    'Content-Type' => $profilePictureAttachment->doc_file_type,
                    'Content-Disposition' => 'attachment; filename="'.$profilePictureAttachment->doc_file_name.'"'
                ]);
            }
        }
    }

    public function certificateAttachment(Request $request, $docFileId)
    {
        $certificateAttachment = SelfDevelopmentFile::where('self_development_file_id', $docFileId)->first();

        if($certificateAttachment) {
            if($certificateAttachment->doc_file && $certificateAttachment->doc_file_type && $certificateAttachment->doc_file_name) {
                $content = base64_decode($certificateAttachment->doc_file);

                return response()->make($content, 200, [
                    'Content-Type' => $certificateAttachment->doc_file_type,
                    'Content-Disposition' => 'attachment; filename="'.$certificateAttachment->doc_file_name.'"'
                ]);
            }
        }
    }

}