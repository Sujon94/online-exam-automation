<?php


namespace App\Http\Controllers\Backend;


use App\Contract\backend\CourseContract;
use App\Contract\backend\PostContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    private $postManager;
    private $courseManager;

    public function __construct(PostContract $postManager, CourseContract $courseManager)
    {
        $this->postManager = $postManager;
        $this->courseManager = $courseManager;
    }

    public function globalUI(){
        return view('backend.seo.global_options');
    }

    public function sitemapXml()
    {
        if (!File::exists(public_path('sitemap.xml'))){
            return abort(404);
        }

        /*$blogs = $this->postManager->getAllPost();
        $services = $this->postManager->getAllServices();
        $courses = $this->courseManager->getAllActiveCourses();
        return response()->view('backend.seo.sitemap',compact('blogs','services','courses'))
            ->header('Content-type','text/xml');*/
    }

    public function robotsTxt()
    {
        if (!File::exists(public_path('robots.txt'))){
            return abort(404);
        }

        /*$blogs = $this->postManager->getAllPost();
        $services = $this->postManager->getAllServices();
        $courses = $this->courseManager->getAllActiveCourses();
        return response()->view('backend.seo.sitemap',compact('blogs','services','courses'))
            ->header('Content-type','text/xml');*/
    }

    public function uploadSitemap(Request $request)
    {
        $request->validate(
            ['sitemap_file'=>'mimes:application/xml,xml,text/xml']
        );
;
        $sitemap = $request->file('sitemap_file');
        $sitemap->move(public_path(),'sitemap.xml');

        return redirect()->back()->with('success','Sitemap Uploaded');
    }
    public function uploadRobots(Request $request)
    {
        $request->validate(
            ['robot_file'=>'mimes:txt']
        );

        $sitemap = $request->file('robot_file');
        $sitemap->move(public_path(),'robots.txt');

        return redirect()->back()->with('success','Robots Uploaded');
    }
}