<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseBlogController;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BlogController extends BaseBlogController
{
    public function autoNews(Request $request)
    {
        return $this->getBlogData(
            $request,
            1,                          // type_id for Auto News
            'Admin.Blog.blog_list',     // Blade view
            'autoNews',                 // Route name
            'Auto News'                 // Title name
        );
    }


    public function reviews(Request $request)
    {
        return $this->getBlogData(
            $request,
            2,
            'Admin.Blog.blog_list',
            'reviews',
            'Reviews'
        );
    }

    public function toolsAndAdvice(Request $request)
    {
        return $this->getBlogData(
            $request,
            3,
            'Admin.Blog.blog_list',
            'toolsAndAdvice',
            'Tools and Advice'
        );
    }

    public function carBuyingAdvice(Request $request)
    {
        return $this->getBlogData(
            $request,
            4,
            'Admin.Blog.blog_list',
            'carBuyingAdvice',
            'Car Buying Advice'
        );
    }

    public function carTips(Request $request)
    {
        return $this->getBlogData(
            $request,
            5,
            'Admin.Blog.blog_list',
            'carTips',
            'Car Tips'
        );
    }

    public function news(Request $request)
    {
        return $this->getBlogData(
            $request,
            8,
            'Admin.Blog.blog_list',
            'news',
            'News'
        );
    }

    public function innovation(Request $request)
    {
        return $this->getBlogData(
            $request,
            9,
            'Admin.Blog.blog_list',
            'innovation',
            'Innovation'
        );
    }

    public function opinion(Request $request)
    {
        return $this->getBlogData(
            $request,
            10,
            'Admin.Blog.blog_list',
            'opinion',
            'Opinion'
        );
    }

    public function financial(Request $request)
    {
        return $this->getBlogData(
            $request,
            11,
            'Admin.Blog.blog_list',
            'financial',
            'Financial'
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',
        ], [
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
            'image.image' => 'Invalid image format',
            'image.max' => 'Image size should not exceed 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $new = new Blog();
        $new->user_id = auth('admin')->id();
        $new->category_id = $request->category_id;
        $new->sub_category_id = $request->sub_category_id;
        $new->type = $request->sub_category_id;
        $new->title = $request->title;
        $new->slug = strtolower(str_replace(' ', '-', trim($request->title)));
        $new->sub_title = $request->sub_title;
        $new->description = $request->description;

        if ($request->hasFile('image')) {
            $path = 'frontend/assets/images/blog/';
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $imageName);
            $new->img = $imageName;
        }

        $new->status = $request->status;
        $new->blog_status = 1;
        $new->seo_description = $request->seo_description;
        // $keywords = implode(',', str_replace('×', '', $request->keywords));
        $new->seo_keyword = $request->seo_keywords;
        $new->hash_keyword = $request->hashKeyword;
        $new->save();

        return response()->json(['status' => 'success', 'message' => 'Blog added successfully']);
    }
}
