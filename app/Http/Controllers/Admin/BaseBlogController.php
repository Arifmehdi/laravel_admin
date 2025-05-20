<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;



class BaseBlogController extends Controller
{
    protected function getBlogData(Request $request, $typeId, $viewName, $routeName, $title)
    {
        if ($request->ajax()) {
            $data = DB::table('blogs')
                ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
                ->join('blog_sub_categories', 'blogs.sub_category_id', '=', 'blog_sub_categories.id')
                ->select(
                    'blogs.id',
                    'blogs.title',
                    'blogs.img',
                    'blogs.status',
                    'blogs.created_at',
                    'blog_categories.name as category_name',
                    'blog_sub_categories.name as sub_category_name'
                )
                ->where('sub_category_id', $typeId)
                ->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    static $count = 1;
                    return $count++;
                })
                ->addColumn('created_at', function ($row) {
                    // If created_at is already a timestamp (integer)
                    if (is_numeric($row->created_at)) {
                        return date('m-d-Y', $row->created_at);
                    }

                    // If created_at is a string date (like from database)
                    if (is_string($row->created_at)) {
                        return date('m-d-Y', strtotime($row->created_at));
                    }

                    // If created_at is a Carbon instance (Laravel default)
                    if ($row->created_at instanceof \Carbon\Carbon) {
                        return $row->created_at->format('m-d-Y');
                    }

                    return $row->created_at; // fallback
                })
                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';

                    // View button
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="view btn btn-info btn-sm mr-1" title="View">
                <i class="fas fa-eye"></i>
             </a>';

                    // Edit button
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm mr-1" title="Edit">
                <i class="fas fa-edit"></i>
             </a>';

                    // Status toggle button
                    $btnClass = $row->status ? 'btn-success' : 'btn-warning';
                    $btnIcon = $row->status ? 'fa-check-circle' : 'fa-times-circle';

                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" data-status="' . $row->status . '" class="status-toggle btn btn-sm mr-1 ' . $btnClass . '" title="Toggle Status">
                <i class="fas ' . $btnIcon . '"></i>
             </a>';

                    // Delete button
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm" title="Delete">
                <i class="fas fa-trash"></i>
             </a>';

                    $btn .= '</div>';

                    return $btn;
                })
                // ->addColumn('action', function ($row) {
                //     return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                // })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $categories = DB::table('blog_categories')->select('id', 'name', 'slug', 'status', 'img')->get();
        $sub_categories = DB::table('blog_sub_categories')->select('id', 'name', 'slug', 'status', 'img')->get();

        return view($viewName, [
            'type' => $title,
            'route' => 'admin.' . $routeName,
            'categories' => $categories,
            'sub_categories' => $sub_categories
        ]);
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

    public function edit(Request $request)
    {
        $blog = DB::table('blogs')
            ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
            ->join('blog_sub_categories', 'blogs.sub_category_id', '=', 'blog_sub_categories.id')
            ->select(
                'blogs.*',
                'blog_categories.name as category_name',
                'blog_sub_categories.name as sub_category_name'
            )
            ->where('blogs.id', $request->id)
            ->first();

        return response()->json($blog);
    }

    public function show(Request $request)
    {
        $blog = DB::table('blogs')
            ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
            ->join('blog_sub_categories', 'blogs.sub_category_id', '=', 'blog_sub_categories.id')
            ->select(
                'blogs.*',
                'blog_categories.name as category_name',
                'blog_sub_categories.name as sub_category_name'
            )
            ->where('blogs.id', $request->id)
            ->first();

        return response()->json($blog);
    }

    public function status(Request $request)
    {
        try {
            DB::table('blogs')
                ->where('id', $request->id)
                ->update(['status' => $request->status]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating status'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:blog_categories,id',
            'sub_category_id' => 'required|exists:blog_sub_categories,id',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);

        try {
            $data = [
                'title' => $request->title,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'sub_title' => $request->sub_title,
                'description' => $request->description,
                'seo_description' => $request->seo_description,
                'seo_keyword' => $request->seo_keywords,
                'hash_keyword' => $request->hashKeyword,
                'status' => $request->status,
                'updated_at' => now(),
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('frontend/assets/images/blog'), $imageName);
                $data['img'] = $imageName;
            }

            DB::table('blogs')
                ->where('id', $request->id)
                ->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Blog updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating blog: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::table('blogs')->where('id', $request->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Blog deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting blog'
            ], 500);
        }
    }
}
