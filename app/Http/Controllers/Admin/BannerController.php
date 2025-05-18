<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class BannerController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            // $data = MainInventory::query();
            $data = DB::table('banners')
                ->select(
                    'banners.id',
                    'banners.name',
                    'banners.image',
                    'banners.position',
                    'banners.status',
                    'banners.created_at',
                    // Add other specific columns you need from admins
                );
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    return $row->id; // Use any unique identifier for your rows
                })
                ->addColumn('image', function($row) {
                    return $row->image
                        ? '<img src="https://bestdreamcar.com/dashboard/images/banners/'.$row->image.'" style="width: 150px; height: auto; border-radius: 4px;">'
                        : '<span class="text-muted">No image</span>';
                })
                ->addColumn('status', function($row) {
                    // Check if the row is visible (active)
                    if ($row->status) {
                        $btn = '<span class="badge bg-success">Active</span>';
                    } else {
                        $btn = '<span class="badge bg-danger">Inactive</span>';
                    }
                    return $btn;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['image','action','status'])
                ->make(true);
        }
       return view('Admin.banner');
    }
}
