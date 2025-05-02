<?php
/**
 *Created by PhpStorm
 *Created at ২৯/৯/২১ ১:১৯ PM
 */

namespace App\Manager\backend;


use App\Contract\backend\BatchContract;
use App\Entities\backend\Batch;
use App\Entities\backend\BatchSchedule;
use App\Entities\backend\SelfDevelopmentFile;
use App\Entities\backend\StudentTransaction;
use App\Enums\LBatchType;
use App\Enums\ParentTable;
use App\Helpers\HelperClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BatchManager implements BatchContract
{
    protected Batch $batch;
    protected $file;
    protected SelfDevelopmentFile $selfDevelopmentFile;
    protected BatchSchedule $batchSchedule;
    protected StudentTransaction $studentTransaction;

    public function __construct()
    {
        $this->batch = new Batch();
        $this->selfDevelopmentFile = new SelfDevelopmentFile();
        $this->batchSchedule = new BatchSchedule();
        $this->studentTransaction = new StudentTransaction();
    }

    public function store(Request $request)
    {
        //dd(HelperClass::dateFormatForDB(htmlspecialchars($request->post('batch_start_date'))));
        try {
            DB::beginTransaction();
            $batch_type = $request->get('batch_type',1);
            $this->batch->course_id = htmlspecialchars($request->post('course'));
            $this->batch->batch_code = htmlspecialchars($request->post('batch_code'));
            $this->batch->batch_name_en = htmlspecialchars($request->post('batch_name_en'));
            $this->batch->batch_name_bn = htmlspecialchars($request->post('batch_name_bn'));
            $this->batch->batch_start_date = HelperClass::dateFormatForDB(htmlspecialchars($request->post('batch_start_date')));
            $this->batch->batch_end_date = HelperClass::dateFormatForDB(htmlspecialchars($request->post('batch_end_date')));
            $this->batch->max_participant = htmlspecialchars($request->post('max_participant'));
            $this->batch->fee_amount = htmlspecialchars($request->post('fee_amount'));
            $this->batch->payment_process_type_id = ($request->post('payment_process_type_id') != "") ? htmlspecialchars($request->post('payment_process_type_id')) : null;
            $this->batch->payment_process_desc_en = $request->post('payment_process_en');
            $this->batch->payment_process_desc_bn = $request->post('payment_process_bn');
            $this->batch->payment_deadline = HelperClass::dateFormatForDB(htmlspecialchars($request->post('payment_deadline')));
            $this->batch->batch_status = htmlspecialchars($request->has('upcoming_yn') ? $request->post('upcoming_yn') : 0);
            $this->batch->batch_type = $batch_type;
            $this->batch->total_batch_schedules = ($batch_type == LBatchType::LONG_TERM) ? $request->get('total_schedules') : 0;
            $this->batch->total_participants = $request->get('total_participants',0);
            //$this->batch->upcoming_batch = htmlspecialchars($request->post('upcoming_batch'));
            $this->batch->created_by = Auth::id();
            $this->batch->active_yn = $request->post('active_yn');

            if ($this->batch->active_yn == 'Y') {
                $batches = new Batch();
                $batches->where('course_id', '=', $this->batch->course_id)->update(['active_yn' => 'N']);
            }

            $this->batch->save();

            if ($request->file()) {
                $this->file = new SelfDevelopmentFile();

                $image = $request->file('batch_image');
                $byteCode = base64_encode(file_get_contents($image->getRealPath()));
                $fileExt = $image->getMimeType();
                $fileName = $image->getClientOriginalName();

                $social_image = $request->file('social_image');
                $image_ext = $social_image->getMimeType();
                $image_name = $social_image->getClientOriginalName();

                $this->file->parent_table = "batches";
                $this->file->parent_id = $this->batch->batch_id;
                $this->file->doc_file_name = $fileName;
                $this->file->doc_file_type = $fileExt;
                $this->file->doc_file = $byteCode;
                $this->file->doc_img_alt_tag = $request->post('doc_img_alt_tag');

                $this->file->social_file_path = Storage::disk('public_root')->putFile('social_files',$social_image);
                $this->file->social_file_type = $image_ext;
                $this->file->social_file_name = $image_name;
                $this->file->save();

            }
            DB::commit();
            return ["status" => 'success', "message" => 'Batch Created'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function getAllBatch()
    {
        return $this->batch->select('course_id','max_participant','batch_name_en','batch_code','batch_start_date','batch_end_date','active_yn','batch_id')
            ->with(['course'=>function ($e){
                return $e->select("course_id","course_name_en");
            }])
            //->orderByRaw('created_at DESC, active_yn DESC')
            ->get();
    }

    public function getABatchInfo($id)
    {
        return $this->batch->with('course', 'batch_file')->where('batch_id', '=', $id)->first();
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $batch = $this->batch->find($id);
            $batch_type = $request->get('batch_type');
            $batch->course_id = htmlspecialchars($request->post('course'));
            $batch->batch_code = htmlspecialchars($request->post('batch_code'));
            $batch->batch_name_en = htmlspecialchars($request->post('batch_name_en'));
            $batch->batch_name_bn = htmlspecialchars($request->post('batch_name_bn'));
            $batch->batch_start_date = HelperClass::dateFormatForDB(htmlspecialchars($request->post('batch_start_date')));
            $batch->batch_end_date = HelperClass::dateFormatForDB(htmlspecialchars($request->post('batch_end_date')));
            $batch->max_participant = htmlspecialchars($request->post('max_participant'));
            $batch->fee_amount = htmlspecialchars($request->post('fee_amount'));
            $batch->payment_process_type_id = ($request->post('payment_process_type_id') != "") ? htmlspecialchars($request->post('payment_process_type_id')) : null;
            $batch->payment_process_desc_en = $request->post('payment_process_en');
            $batch->payment_process_desc_bn = $request->post('payment_process_bn');
            $batch->payment_deadline = HelperClass::dateFormatForDB(htmlspecialchars($request->post('payment_deadline')));
            $batch->batch_status = htmlspecialchars($request->post('upcoming_yn'));
            $batch->batch_type = $batch_type;
            $batch->total_batch_schedules = ($batch_type == LBatchType::LONG_TERM) ? $request->get('total_schedules') : 0;
            $batch->total_participants = $request->get('total_participants');
            //$batch->upcoming_batch = htmlspecialchars($request->post('upcoming_batch'));
            $batch->created_by = Auth::id();
            $batch->active_yn = $request->post('active_yn');

            if ($batch_type == LBatchType::LONG_TERM){
                $this->batchSchedule->where('batch_id', '=', htmlspecialchars($id))->delete();
            }

            if ($batch->active_yn == 'Y') {

                $batches = new Batch();
                $batches->where(function ($q) use ($batch) {
                    $q->where('batch_id', '!=', $batch->batch_id);
                    $q->where('course_id', '=', $batch->course_id);
                })->update(['active_yn' => 'N']);
            }

            $batch->save();

            //if ($request->file()) {
                $image = $request->file('batch_image');
                $social_image = $request->file('social_image');

                $this->file = SelfDevelopmentFile::where(['parent_table'=>ParentTable::BATCH,'parent_id'=> htmlspecialchars($id)])->first();
                if (isset($image)){
                    $byteCode = base64_encode(file_get_contents($image->getRealPath()));
                    $fileExt = $image->getMimeType();
                    $fileName = $image->getClientOriginalName();

                    $this->file->doc_file_name = $fileName;
                    $this->file->doc_file_type = $fileExt;
                    $this->file->doc_file = $byteCode;
                }
                if (isset($social_image)){
                    if (Storage::disk('public_root')->exists($this->file->social_file_path)){
                        Storage::disk('public_root')->delete($this->file->social_file_path);
                    }
                    $social_image = $request->file('social_image');
                    $image_ext = $social_image->getMimeType();
                    $image_name = $social_image->getClientOriginalName();

                    $this->file->social_file_name = $image_name;
                    $this->file->social_file_type = $image_ext;
                    $this->file->social_file_path = Storage::disk('public_root')->putFile('social_files',$social_image);
                }

                /*$this->file->parent_table = "batches";
                $this->file->parent_id = $id;*/

                //$this->file->social_file_path = Storage::disk('public_root')->putFile('social_files',$image);
                $this->file->doc_img_alt_tag = $request->post('doc_img_alt_tag');
                $this->file->save();
            //}
            DB::commit();
            return ["status" => 'success', "message" => 'Batch Updated'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->selfDevelopmentFile->where(['parent_table'=>ParentTable::BATCH,'parent_id'=> htmlspecialchars($id)])->delete();
            $this->delete_file($id);
            $this->batchSchedule->where('batch_id', '=', htmlspecialchars($id))->delete();
            $this->studentTransaction->where('batch_id','=',$id)->delete();
            $this->batch->where('batch_id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["status" => 'success', "message" => 'Batch Removed'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    public function getBatchOnCourse($id)
    {
        return $this->batch->where(['course_id' => $id, 'active_yn'=>'Y'])->first();
    }

    public function delete_file(int $batch_id): bool
    {
        $this->file = new SelfDevelopmentFile();
        $file = $this->file->where(['parent_table' => ParentTable::BATCH, 'parent_id' => $batch_id])->first();
        if($file){
            try {
                Storage::disk('public_root')->delete($file->social_file_path);
            }catch (\Exception $e){
                return false;
            }
        }
        $this->file->where(['parent_table' => 'batches', 'parent_id' => $batch_id])->delete();
        return true;
    }

    public function getApprovedStudents($id)
    {
        return $this->batch->with('approved_students')->where(['course_id' => $id, 'active_yn'=>'Y'])->first();
    }
}