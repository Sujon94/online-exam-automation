<?php


namespace App\Http\Controllers\Frontend;


use App\Entities\backend\lookup\LPostCategory;
use App\Entities\backend\Post;
use App\Enums\PostCategoryFor;
use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class WebPostController extends Controller
{
    public function index()
    {
        return view('frontend.post.index', [
            'postList' => Post::with(['post_photo'])->where(['post_for'=>PostCategoryFor::BLOG,'status'=>PostStatus::PUBLISHED])->get(),
        ]);
    }

    public function postDetail(Request $request, $slug)
    {
        try {
            $lPostCatList = LPostCategory::where('category_for', PostCategoryFor::BLOG)->inRandomOrder()->limit(5)->get();
            $postList = Post::with(['post_photo'])->where('post_for', PostCategoryFor::BLOG)->orderBy('post_id','DESC')->skip(0)->take(4)->get();
            $postInfo = Post::where('slug',$slug)->first();
            $id = $postInfo->post_id;
            $postDetails = Post::with(['category','post_photo'])->where('post_id', $id)->first();

            return view('frontend.post.post_details', [
                'lPostCatList' => $lPostCatList,
                'postList' => $postList,
                'postDetails' => $postDetails,
                'metaInfo' => (object) [
                    'meta_title' => $postDetails->meta_title,
                    'meta_description' => $postDetails->meta_description
                ],
                'social' => (object) [
                    'title'=>$postDetails->title,
                    'description' => strip_tags($postDetails->body),
                    'fb_app_id' => '',
                    'url' => route('web-post.detail',['slug'=>$postInfo->slug]),
                    'image_alt' => $postDetails->title,
                    'image' => $postDetails->post_photo->social_file_path
                ]
            ]);
        }catch (\Exception $e){
            return view('frontend.content_not_found');
        }
    }

    public function categoryWisePosts(Request $request, $id)
    {
        return view('frontend.post.index', [
            'postList' => Post::with(['post_photo'])->where('post_category_id',$id)->get(),
        ]);
    }

}