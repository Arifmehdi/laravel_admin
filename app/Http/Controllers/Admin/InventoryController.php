<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainInventory;
use DataTables;
use DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            // $data = MainInventory::query();
            $data = DB::table('main_inventories')
                ->join('admins', 'main_inventories.deal_id', '=', 'admins.id')
                ->select(
                    'main_inventories.id',
                    'main_inventories.stock',
                    'main_inventories.vin',
                    'main_inventories.year',
                    'main_inventories.make',
                    'main_inventories.model',
                    'main_inventories.created_date',
                    'main_inventories.created_at',
                    'main_inventories.active_till',
                    'main_inventories.inventory_status',
                    'main_inventories.is_visibility',
                    'main_inventories.package',
                    'admins.name as admin_name',
                    'admins.email as admin_email',
                    'admins.city as admin_city',
                    'admins.state as admin_state'
                    // Add other specific columns you need from admins
                );
            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
       return view('Admin.inventories');
    }
}
