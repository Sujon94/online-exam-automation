<?php

namespace App\Console\Commands;

use App\Entities\backend\exam_system\EXam;
use App\Enums\Exam\LExamStatus;
use App\Enums\Exam\LExamType;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePublishedExamStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:UpdateExamStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'All published and participated exams are updated to complete.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $exam = new EXam();
            $exam->where('status','=',LExamStatus::PUBLISHED)
                ->where('exam_type','<>',LExamType::SKILL_TEST)
                ->where(DB::raw("TIMESTAMP(exam_date,exam_end_at)"),'<',date('Y-m-d H:i:s'))
                ->update(['status' => LExamStatus::COMPLETED]);
            //Log::info('Schedule: ran'.date('Y-m-d H:i:s'));
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
        return 0;
    }
}
