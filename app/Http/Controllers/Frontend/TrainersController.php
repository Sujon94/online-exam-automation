<?php


namespace App\Http\Controllers\Frontend;


use App\Entities\backend\PageSetup;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\PageContent;
use App\Enums\PageName;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TrainersController extends Controller
{
    public function index()
    {
        $trainer_detail = PageSetup::where('page_id', PageName::OUR_TRAINER)->where('content_id',PageContent::TRAINER_DETAIL)
            ->orderBy('content_serial', 'asc')->get();


        foreach ($trainer_detail as $detail) {
            $file = SelfDevelopmentFile::where('parent_id',$detail->id)->where('parent_table','page_setup')->first();
            $detail->doc_file = $file->doc_file;
        }

        //dd($trainer_detail);
        return view('frontend.trainers.index', compact('trainer_detail'));
    }

}