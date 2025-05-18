<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                ->where('type', $typeId);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    static $count = 1;
                    return $count++;
                })
                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view($viewName, [
            'type' => $title,
            'route' => 'admin.' . $routeName
        ]);
    }
}
