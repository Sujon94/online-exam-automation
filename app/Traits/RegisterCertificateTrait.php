<?php


namespace App\Traits;


use App\Entities\backend\exam_system\ECertificateRegister;
use App\Entities\backend\exam_system\EXamResult;
use App\Helpers\HelperClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait RegisterCertificateTrait
{
    public function registerByExamId($examId)
    {
        $results = EXamResult::select(DB::raw("distinct exam_id,student_trans_id"))->where('exam_id', '=', $examId)->get();
        $data = [];
        foreach ($results as $res) {
            $data[] = [
                'certificate_short_code' => HelperClass::random_str(50),
                'exam_id' => $examId,
                'student_transaction_id' => $res->student_trans_id,
                'created_at' => Carbon::now()->toDateString()
            ];
        }

        return ECertificateRegister::insert($data);
    }

    public function registerByTransaction($examId, $transId)
    {
        $data = [
            'certificate_short_code' => HelperClass::random_str(50),
            'exam_id' => $examId,
            'student_transaction_id' => $transId,
            'created_at' => Carbon::now()->toDateString()
        ];

        return ECertificateRegister::insert($data);
    }
}