<?php
/**
 *Created by PhpStorm
 *Created at ৬/১/২২ ১১:১৪ AM
 */

namespace App\Contract\backend;


use Illuminate\Http\Request;

interface PostCategoryContract
{
    public function store(Request $request);

    public function getAllCategory();

    public function getCategoriesOnPostType(string $postFor);

    public function getActiveCategories();

    public function getACategoryInfo(int $id);

    public function update(Request $request, int $id);

    public function delete(int $id);
}