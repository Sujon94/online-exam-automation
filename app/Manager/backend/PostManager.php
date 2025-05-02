<?php
/**
 *Created by PhpStorm
 *Created at ৫/১/২২ ৫:১৪ PM
 */

namespace App\Manager\backend;


use App\Contract\backend\PostContract;
use App\Entities\backend\Post;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\ParentTable;
use App\Enums\PostCategoryFor;
use App\Enums\PostStatus;
use App\Helpers\HelperClass;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostManager implements PostContract
{
    use SoftDeletes;
    protected Post $post;
    protected SelfDevelopmentFile $file;

    public function __construct()
    {
        $this->post = new Post();
        $this->file = new SelfDevelopmentFile();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->post->post_for = $request->post('post_for');
            $this->post->post_category_id = $request->post('category_id');
            $this->post->contact_person_mbl = ( $request->post('contact_person_mbl') && ($request->post('post_for') == PostCategoryFor::SERVICE)) ? $request->post('contact_person_mbl') : null ;
            $this->post->author_id = Auth::id();
            $this->post->title = htmlspecialchars($request->post('post_title'));
            $this->post->post_summary = htmlspecialchars($request->post('post_summary'));
            $this->post->slug = $request->post('slug');
            $this->post->body = $request->post('post_body');
            $this->post->meta_title = $request->post('meta_title');
            $this->post->meta_description = $request->post('meta_description');
            $this->post->status = $request->post('post_status');
            $this->post->save();

            if ($request->file()) {
                $post_image = $request->file('post_image'); //For service = post  image
                $social_image = $request->file('social_image'); // For blog = post + social image

                if ($this->post->post_for == 'B'){
                    $byteCode = base64_encode(file_get_contents($social_image->getRealPath()));
                    $fileType = $social_image->getMimeType();
                    $fileName = $social_image->getClientOriginalName();

                    $image_ext = $fileType;
                    $image_name = $fileName;
                }else{
                    $byteCode = base64_encode(file_get_contents($post_image->getRealPath()));
                    $fileType = $post_image->getMimeType();
                    $fileName = $post_image->getClientOriginalName();

                    $image_ext = $social_image->getMimeType();
                    $image_name = $social_image->getClientOriginalName();
                }

                $this->file->parent_table = "posts";
                $this->file->parent_id = $this->post->post_id;
                $this->file->doc_file_name = $fileName;
                $this->file->doc_file_type = $fileType;
                $this->file->doc_file = $byteCode;
                $this->file->doc_img_alt_tag = $request->post('doc_img_alt_tag');
                $this->file->social_file_path = Storage::disk('public_root')->putFile('social_files',$social_image);
                $this->file->social_file_type = $image_ext;
                $this->file->social_file_name = $image_name;
                $this->file->social_file_alt_tag = $request->post('social_img_alt_tag');
                $this->file->save();
            }
            DB::commit();
            return ["status" => 'success', "message" => 'Post Created'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function getAllPost()
    {
        return $this->post->with('category')->orderBy('created_at','desc')->get();
    }

    public function getAPostInfo($id)
    {
        return $this->post->with('post_photo')->where('post_id','=',$id)->first();
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $this->post->find($id);
            $data->post_for = $request->post('post_for');
            $data->post_category_id = $request->post('category_id');
            $data->contact_person_mbl = ( $request->post('contact_person_mbl') && ($request->post('post_for') == PostCategoryFor::SERVICE)) ? $request->post('contact_person_mbl') : null ;
            $data->author_id = Auth::id();
            $data->title = htmlspecialchars($request->post('post_title'));
            $data->post_summary = htmlspecialchars($request->post('post_summary'));
            $data->slug = $request->post('slug');
            $data->body = $request->post('post_body');
            $data->meta_title = $request->post('meta_title');
            $data->meta_description = $request->post('meta_description');
            $data->status = $request->post('post_status');

            $data->save();

            /*if ($request->file()) {*/
                $post_image = $request->file('post_image');  //For service = only post image
                $social_image = $request->file('social_image'); // For blog = post+social image

                $this->file = SelfDevelopmentFile::where(['parent_table'=>ParentTable::POST,'parent_id'=> htmlspecialchars($id)])->first();
            $this->file->doc_img_alt_tag = $request->post('doc_img_alt_tag',null);
            $this->file->social_file_alt_tag = $request->post('social_img_alt_tag',null);
                if ($data->post_for == 'S'){
                    if (isset($post_image)){
                        $byteCode = base64_encode(file_get_contents($post_image->getRealPath()));
                        $fileExt = $post_image->getMimeType();
                        $fileName = $post_image->getClientOriginalName();

                        $this->file->doc_file_name = $fileName;
                        $this->file->doc_file_type = $fileExt;
                        $this->file->doc_file = $byteCode;
                    }

                    if (isset($social_image)){
                        if (Storage::disk('public_root')->exists($this->file->social_file_path)){
                            Storage::disk('public_root')->delete($this->file->social_file_path);
                        }
                        $image_ext = $social_image->getMimeType();
                        $image_name = $social_image->getClientOriginalName();

                        $this->file->social_file_name = $image_name;
                        $this->file->social_file_type = $image_ext;
                        $this->file->social_file_path = Storage::disk('public_root')->putFile('social_files',$social_image);
                    }
                }else{
                    if (isset($social_image)){
                        $byteCode = base64_encode(file_get_contents($social_image->getRealPath()));
                        $fileExt = $social_image->getMimeType();
                        $fileName = $social_image->getClientOriginalName();

                        /*$this->file->parent_table = "posts";
                        $this->file->parent_id = $id;*/

                        $this->file->doc_file_name = $fileName;
                        $this->file->doc_file_type = $fileExt;
                        $this->file->doc_file = $byteCode;

                        if (Storage::disk('public_root')->exists($this->file->social_file_path)){
                            Storage::disk('public_root')->delete($this->file->social_file_path);
                        }
                        $this->file->social_file_path = Storage::disk('public_root')->putFile('social_files',$social_image);
                        $this->file->social_file_name = $fileName;
                        $this->file->social_file_type = $fileExt;
                    }
                }

                $this->file->save();
            /*}*/
            DB::commit();
            return ["status" => 'success', "message" => 'Post Updated'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->file->where(['parent_table'=>'posts','parent_id' => htmlspecialchars($id)])->delete();
            $this->post->where('post_id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["status" => 'success', "message" => 'Post Removed'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    public function delete_file($fileId)
    {
        $this->file = new SelfDevelopmentFile();
        $file = $this->file->where(['parent_table' => 'posts', 'parent_id' => $fileId])->first();
        try {
           Storage::disk('public_root')->delete($file->social_file_path);
        }catch (\Exception $e){
            return false;
        }
        $this->file->where(['parent_table' => 'posts', 'parent_id' => $fileId])->delete();
        return true;
    }


    public function download($fileId)
    {
        return  $this->file->find($fileId);
    }

    public function getAllServices()
    {
        return $this->post->with('category')->where(['status'=>PostStatus::PUBLISHED,'post_for'=>PostCategoryFor::SERVICE])->get();
    }

    public function updateMasterYN($post_id, $status)
    {
        $service = $this->post->find($post_id);
        if ($status == "true") {
            $service->master_yn = 'Y';
        } else {
            $service->master_yn = 'N';
        }
        $service->save();
        return ["code" => '1', "status" => 'success', "message" => 'Service Updated', "data" => ['service_name' => $service->title]];
    }
}