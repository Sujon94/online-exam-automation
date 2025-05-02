<?php
/**
 *Created by PhpStorm
 *Created at ২৭/১০/২১ ৫:১৫ PM
 */

namespace App\Manager\backend;


use App\Contract\backend\CommonContract;
use App\Entities\backend\SelfDevelopmentFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CommonManager implements CommonContract
{
    private SelfDevelopmentFile $selfDevelopmentFile;

    public function __construct()
    {
        $this->selfDevelopmentFile = new SelfDevelopmentFile();
    }

    public function file_delete(int $id)
    {
        try {
            DB::beginTransaction();
            $file = $this->selfDevelopmentFile->where('self_development_file_id', '=', htmlspecialchars($id))->first();
            if (Storage::disk('public_root')->exists($file->social_file_path)){
                Storage::disk('public_root')->delete($file->social_file_path);
            }
            $this->selfDevelopmentFile->where('self_development_file_id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["status" => 'success', "message" => 'File Removed'];
        }catch (\Exception $e){
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }
}