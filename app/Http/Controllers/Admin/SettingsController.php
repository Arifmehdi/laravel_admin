<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('general_settings')->first();

            $frontendUrl = config('frontend.url') . '/frontend/assets/images/logos/';

            return DataTables::of(collect([$data]))
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    return $row->id;
                })
                ->addColumn('logo', function ($row) use ($frontendUrl) {
                    $html = '<img width="50%" src="' . $frontendUrl . $row->image . '" />';
                    return $html;
                })
                ->addColumn('slider', function ($row) use ($frontendUrl) {
                    $html = '<img width="50%" src="' . $frontendUrl . $row->slider_image . '" />';
                    return $html;
                })
                ->addColumn('favicon', function ($row) use ($frontendUrl) {
                    $html = '<img width="40%" src="' . $frontendUrl . $row->fav_image . '" />';
                    return $html;
                })
                ->addColumn('upload_by', function ($row) {
                    return $row->userName->name ?? 'N/A';
                })

                ->addColumn('action', function ($row) {
                    $html = '<a
                data-id="' . $row->id . '"
                style="margin-right:3px"
                href="javascript:void(0);"

                class="btn btn-info btn-sm edit-btn editLogo">
                <i class="fa fa-edit"></i>
                </a>';
                    return $html;
                })
                ->rawColumns(['action', 'logo', 'favicon', 'slider'])
                ->make(true);
        }
        return view('Admin.settings');
    }

    public function edit(Request $request)
    {
        $general_settings = DB::table('general_settings')
            ->where('id', $request->id)
            ->first();

        if (!$general_settings) {
            return response()->json([
                'success' => false,
                'message' => 'Settings not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $general_settings
        ]);
    }
}
