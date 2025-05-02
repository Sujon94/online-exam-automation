<?php


namespace App\Http\Controllers\Frontend;


use App\Entities\backend\Circular;
use App\Entities\backend\Post;
use App\Enums\PostCategoryFor;
use App\Enums\PostStatus;
use App\Enums\Role;
use App\Enums\YesNoFlag;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CircularController extends Controller
{


    public function __construct()
    {
        // Call
    }

    public function index(Request $request)
    {
        $serviceList = Post::with(['category'])
            ->where(['post_for'=> PostCategoryFor::SERVICE,'status'=>PostStatus::PUBLISHED, 'master_yn'=>YesNoFlag::YES])
            ->inRandomOrder()->limit(15)
            ->get();

        $circularList = Circular::with(['circular_types','locations'])
            ->where(['active_yn'=>YesNoFlag::YES])
            ->get();

        return view('frontend.circular.index', [
            'serviceList' => $serviceList,
            'circularList' => $circularList,
        ]);
    }

    /*public function circularList(Request $request, $id)
    {
        $catWiseServiceList = Post::where('post_category_id', $id)->where(['post_for'=> PostCategoryFor::SERVICE,'status'=>PostStatus::PUBLISHED])->get();

        return view('frontend.service.services', [
            'courseInfo' => 0,
            'catWiseServiceList' => $catWiseServiceList,
        ]);
    }*/

    public function circularDetail(Request $request, $id)
    {
        //$postInfo = Post::where('slug',$slug)->first();
        //$id = $postInfo->post_id;
        try {
           /* $serviceDetails = Post::with(['category', 'post_photo'])
                ->where('status', PostStatus::PUBLISHED)
                ->where('post_id', $id)
                ->first();*/

            $circularDetails = Circular::with(['circular_types','circular_pay_types','locations'])
                ->where(['active_yn'=>YesNoFlag::YES])
                ->where('circular_id', $id)
                ->first();

            return view('frontend.circular.circular_details', [
                'circularDetails' => $circularDetails,
                /*'metaInfo' => (object) [
                    'meta_title' => $serviceDetails->meta_title,
                    'meta_description' => $serviceDetails->meta_description
                ],
                'social' => (object) [
                    'title' => $serviceDetails->title,
                    'description' => strip_tags(substr($serviceDetails->body, 0, 105)).'...',
                    'image' => $serviceDetails->post_photo->social_file_path,
                    'image_alt' => $serviceDetails->title,
                    'url' => route('service.detail',['slug'=>$postInfo->slug]),
                    'fb_app_id' => ''
                ]*/
            ]);
        }catch (\Exception $e){
            return view('frontend.content_not_found');
        }
    }
}