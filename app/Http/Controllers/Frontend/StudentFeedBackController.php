<?php


namespace App\Http\Controllers\Frontend;


use App\Entities\backend\PageSetup;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\PageContent;
use App\Enums\PageName;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class StudentFeedBackController extends Controller
{
    public function index()
    {
        $title1 = PageSetup::select('*')->where('page_id', PageName::STUDENTS_FEEDBACK)->where('content_id',PageContent::TITLE1)->first();
        $title1 = preg_replace('/<[^>]*>/', '', $title1->content);

        $title2 = PageSetup::select('*')->where('page_id', PageName::STUDENTS_FEEDBACK)->where('content_id',PageContent::TITLE2)->first();
        $title2 = preg_replace('/<[^>]*>/', '', $title2->content);

        $comments = PageSetup::where('page_id', PageName::STUDENTS_FEEDBACK)->where('content_id',PageContent::COMMENTS)
            ->orderBy('content_serial', 'asc')->get();

        foreach ($comments as $value) {
            $file = SelfDevelopmentFile::where('parent_id',$value->id)->where('parent_table','page_setup')->first();
            $value->doc_file = $file->doc_file;
        }
        return view('frontend.student-feedback.index',compact('title1','title2','comments'));
    }

}