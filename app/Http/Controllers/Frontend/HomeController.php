<?php


namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Entities\backend\PageSetup;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\PageContent;
use App\Enums\PageName;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        //return view('frontend.home.index');
        $wos = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::WHAT_OTHERS_SAYS)
            ->orderBy('content_serial', 'asc')->get();

        foreach ($wos as $value) {
            try {
                $file = SelfDevelopmentFile::where('parent_id', $value->id)->where('parent_table', 'page_setup')->first();
                $value->doc_file = isset($file) ? $file->social_file_name : null;
                $value->content = preg_replace('/<[^>]*>/', '', $value->content);
            } catch (\Exception $e) {
                DB::statement(
                    "CALL GENERATE_EXCEPTION(:p_exception, :p_entity, :p_user_id);",
                    ['p_exception' => $e->getMessage() . '||' . $e->getCode() . '||' . $e->getLine() . '||' . $e->getTraceAsString()
                        , 'p_entity' => 'Social image load'
                        , 'p_user_id' => Auth::id()
                    ]
                );
                abort(404);
            }
        }

        $os = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::OUR_SERVICE)
            ->orderBy('content_serial', 'asc')->first();

        $osg = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::OUR_SERVICE_GALLERY)
            ->orderBy('content_serial', 'asc')->get();

        foreach ($osg as $value) {
            try {
                $file = SelfDevelopmentFile::where('parent_id', $value->id)->where('parent_table', 'page_setup')->first();
                $value->doc_file = isset($file) ? $file->social_file_name : null;
                $value->content = preg_replace('/<[^>]*>/', '', $value->content);
            } catch (\Exception $e) {
                DB::statement(
                    "CALL GENERATE_EXCEPTION(:p_exception, :p_entity, :p_user_id);",
                    ['p_exception' => $e->getMessage() . '||' . $e->getCode() . '||' . $e->getLine() . '||' . $e->getTraceAsString()
                        , 'p_entity' => 'Social image load'
                        , 'p_user_id' => Auth::id()
                    ]
                );
                abort(404);
            }
        }

        $ot = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::OUR_TEACHERS)
            ->orderBy('content_serial', 'asc')->first();

        $tg = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::TEACHERS_GALLERY)
            ->orderBy('content_serial', 'asc')->get();

        foreach ($tg as $value) {
            try {
                $file = SelfDevelopmentFile::where('parent_id', $value->id)->where('parent_table', 'page_setup')->first();
                $value->doc_file = isset($file) ? $file->social_file_name : null;
            } catch (\Exception $e) {
                DB::statement(
                    "CALL GENERATE_EXCEPTION(:p_exception, :p_entity, :p_user_id);",
                    ['p_exception' => $e->getMessage() . '||' . $e->getCode() . '||' . $e->getLine() . '||' . $e->getTraceAsString()
                        , 'p_entity' => 'Social image load'
                        , 'p_user_id' => Auth::id()
                    ]
                );
                abort(404);
            }
        }

        $gtext = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::GALLERY_TEXT)
            ->orderBy('content_serial', 'asc')->first();

        $gimg = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::GALLERY_IMAGE)
            ->orderBy('content_serial', 'asc')->get();

        foreach ($gimg as $value) {
            try {
                $file = SelfDevelopmentFile::where('parent_id', $value->id)->where('parent_table', 'page_setup')->first();
                $value->doc_file = isset($file) ? $file->social_file_name : null;
            } catch (\Exception $e) {
                DB::statement(
                    "CALL GENERATE_EXCEPTION(:p_exception, :p_entity, :p_user_id);",
                    ['p_exception' => $e->getMessage() . '||' . $e->getCode() . '||' . $e->getLine() . '||' . $e->getTraceAsString()
                        , 'p_entity' => 'Social image load'
                        , 'p_user_id' => Auth::id()
                    ]
                );
                abort(404);
            }
        }

        $vds = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::VIDEO_SECTION)
            ->orderBy('content_serial', 'asc')->first();

        $csec = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::COUNTER_SECTION)
            ->orderBy('content_serial', 'asc')->get();

        $wwedo = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::WHAT_WE_DO)
            ->orderBy('content_serial', 'asc')->first();

        $wwedo2 = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::WHAT_WE_DO_2)
            ->orderBy('content_serial', 'asc')->get();

        foreach ($wwedo2 as $value) {
            try {
                $file = SelfDevelopmentFile::where('parent_id', $value->id)->where('parent_table', 'page_setup')->first();
                $value->doc_file = isset($file) ? $file->social_file_name : null;
                $value->content = preg_replace('/<[^>]*>/', '', $value->content);
            } catch (\Exception $e) {
                DB::statement(
                    "CALL GENERATE_EXCEPTION(:p_exception, :p_entity, :p_user_id);",
                    ['p_exception' => $e->getMessage() . '||' . $e->getCode() . '||' . $e->getLine() . '||' . $e->getTraceAsString()
                        , 'p_entity' => 'Social image load'
                        , 'p_user_id' => Auth::id()
                    ]
                );
                abort(404);
            }
        }

        $wweare = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::WHO_WE_ARE)
            ->orderBy('content_serial', 'asc')->first();

        $file = SelfDevelopmentFile::where('parent_id', $wweare->id)->where('parent_table', 'page_setup')->first();
        $wweare->doc_file = isset($file->social_file_name) ? $file->social_file_name : '';

        $wweare2 = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::WHO_WE_ARE_2)
            ->orderBy('content_serial', 'asc')->first();

        $file = SelfDevelopmentFile::where('parent_id', $wweare2->id)->where('parent_table', 'page_setup')->first();
        $wweare2->doc_file = isset($file->social_file_name) ? $file->social_file_name : '';
        $wweare2_title = preg_replace('/<[^>]*>/', '', $wweare2->content);

        $services = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::OUR_SERVICES)
            ->orderBy('content_serial', 'asc')->first();

        $service_bottom = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::OUR_SERVICES_BOTTOM_BADGE)
            ->orderBy('content_serial', 'asc')->get();

        $our_course = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::OUR_COURSE)->first();

        $our_course_2 = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::OUR_COURSE_2)
            ->orderBy('content_serial', 'asc')->get();

        foreach ($our_course_2 as $value) {
            $file = SelfDevelopmentFile::where('parent_id', $value->id)->where('parent_table', 'page_setup')->first();
            $value->doc_file = isset($file->social_file_name) ? $file->social_file_name : '';
            //$value->content = preg_replace('/<[^>]*>/', '', $value->content);
        }

        $wcsd = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::WHY_CHOOSE_SD)
            ->orderBy('content_serial', 'asc')->first();

        $file = SelfDevelopmentFile::where('parent_id', $wcsd->id)->where('parent_table', 'page_setup')->first();
        $wcsd->doc_file = isset($file->social_file_name) ? $file->social_file_name : '';

        $wcsdr = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::WHY_CHOOSE_SD_REASON)
            ->orderBy('content_serial', 'asc')->get();

        $slider = PageSetup::select('*')
            ->where('page_id', PageName::HOME)
            ->where('content_id', PageContent::SLIDER)
            ->orderBy('content_serial', 'asc')->get();

        foreach ($slider as $value) {
            $file = SelfDevelopmentFile::where('parent_id', $value->id)->where('parent_table', 'page_setup')->first();
            $value->doc_file = isset($file->social_file_name) ? $file->social_file_name : '';//$file->social_file_name;
            //$value->content = preg_replace('/<[^>]*>/', '', $value->content);
        }


        $newsletter = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::NEWSLETTER)->first();

        $usefullink = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::USEFULLINK)
            ->orderBy('content_serial', 'asc')->get();

        $latestnews = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::LATESTNEWS)
            ->orderBy('content_serial', 'asc')->get();

        foreach ($latestnews as $value) {
            try {
                $file = SelfDevelopmentFile::where('parent_id', $value->id)->where('parent_table', 'page_setup')->first();
                $value->doc_file = isset($file) ? $file->social_file_name : null;
                $value->content = preg_replace('/<[^>]*>/', '', $value->content);
            } catch (\Exception $e) {
                DB::statement(
                    "CALL GENERATE_EXCEPTION(:p_exception, :p_entity, :p_user_id);",
                    ['p_exception' => $e->getMessage() . '||' . $e->getCode() . '||' . $e->getLine() . '||' . $e->getTraceAsString()
                        , 'p_entity' => 'Social image load'
                        , 'p_user_id' => Auth::id()
                    ]
                );
                abort(404);
            }
        }

        $header = PageSetup::select('*')
            ->where('page_id', PageName::HEADER)
            ->where('content_id', PageContent::HEADER_LOGO)->first();
        if (isset($header)) {
            $file_header = SelfDevelopmentFile::where('parent_id', $header->id ?? null)->where('parent_table', 'page_setup')->first();
            $header->doc_file = isset($file_header->social_file_name) ? $file_header->social_file_name : "";
        }

        //----------Contact Bottom----------------
        $contact_social = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::BOTTOM_CONTACT_SOCIAL_MEDIA)->get();

        $contact_phone = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::BOTTOM_CONTACT_PHONE)->get();
        $contact_email = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::BOTTOM_CONTACT_EMAIL)->first();

        $contact_top_left_img = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::TOP_IMG_LEFT)->first();
        if (isset($contact_top_left_img)) {
            $top_left_img = SelfDevelopmentFile::where('parent_id', $contact_top_left_img->id ?? null)->where('parent_table', 'page_setup')->first();
            $contact_top_left_img->doc_file = isset($top_left_img->social_file_name) ? $top_left_img->social_file_name : '';
        }
        $contact_top_right_img = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::TOP_IMG_RIGHT)->first();
        if (isset($contact_top_right_img)) {
            $top_right_img = SelfDevelopmentFile::where('parent_id', $contact_top_right_img->id)->where('parent_table', 'page_setup')->first();
            $contact_top_right_img->doc_file = isset($top_right_img->social_file_name) ? $top_right_img->social_file_name : '';
        }

        return view('frontend.home.index', compact('wos', 'os', 'osg', 'ot', 'tg', 'gtext', 'gimg',
            'vds', 'csec', 'wwedo', 'wwedo2', 'wweare', 'wweare2', 'wweare2_title', 'services', 'service_bottom',
            'our_course', 'our_course_2', 'wcsd', 'wcsdr', 'slider', 'newsletter', 'usefullink', 'latestnews', 'header',
            'contact_social', 'contact_phone', 'contact_email', 'contact_top_left_img', 'contact_top_right_img'));
    }
}