<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CacheCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CacheCommandController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Cache Command';
        if ($request->ajax()) {
            $data = CacheCommand::orderBy('id','desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    return $row->id;
                })
                ->addColumn('action', function ($row) {
                    $btnClass = $row->status ? 'btn-success' : 'btn-warning';
                    $btnIcon = $row->status ? 'fa-check-circle' : 'fa-times-circle';

                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<button class="btn btn-secondary btn-sm link-btn mr-1" data-id="' . $row->id . '" title="Generate">
                                <i class="fas fa-sync-alt"></i>
                            </button>';
                    // $btn .= '<button class="btn btn-info btn-sm view-btn mr-1" data-id="' . $row->id . '" title="View">
                    //             <i class="fas fa-eye"></i>
                    //         </button>';
                    $btn .= '<button class="btn btn-primary btn-sm edit-btn mr-1" data-id="' . $row->id . '" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>';
                    $btn .= '<button class="btn ' . $btnClass . ' btn-sm status-toggle mr-1" data-id="' . $row->id . '" data-status="' . $row->status . '" title="Status">
                                <i class="fas ' . $btnIcon . '"></i>
                            </button>';
                    $btn .= '<button class="btn btn-danger btn-sm delete-btn mr-1" data-id="' . $row->id . '" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    return ($row->created_at)->format('m-d-Y');
                })
                ->addColumn('status', function ($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('Admin.cache-commands.index', compact('page_title'));
    }

    public function create()
    {
        return view('cache-commands.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'cache_name' => 'required',
            'cache_command' => 'required|unique:cache_commands,command',
            'cache_state' => 'required',
            'zip_codes' => 'required',
        ]);


        $caheInsert = new CacheCommand();
        $caheInsert->name = $request->cache_name;
        $caheInsert->command = $request->cache_command;
        $caheInsert->state = $request->cache_state;
        // $caheInsert->zip_codes = implode(',', array_map('trim', explode(',', $request->zip_codes)));
        $zips = array_filter(array_map('trim', explode(',', $request->zip_codes)));
        $caheInsert->zip_codes = json_encode(array_values($zips));
        $caheInsert->cache_file = $request->cache_file;
        $caheInsert->status = $request->status;
        $caheInsert->save();

        return response()->json([
            'success' => true,
            'message' => 'Cache command created successfully.',
            'data' => $caheInsert
        ]);
        // return redirect()->route('cache-commands.index')->with('success', 'Cache command created successfully.');
    }

    public function edit($id)
    {
        $command = CacheCommand::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $command
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'command' => 'required|unique:cache_commands,command,' . $id,
            'state' => 'required',
            'zip_codes' => 'required',
            'cache_file' => 'required'
        ]);

        $command = CacheCommand::findOrFail($id);
        $data = $request->all();
        $data['zip_codes'] = implode(',', array_map('trim', explode(',', $request->zip_codes)));

        $command->update($data);

        return redirect()->route('cache-commands.index')
            ->with('success', 'Cache command updated successfully.');
    }


    public function status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cache_commands,id',
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::table('cache_commands')
                ->where('id', $request->id)
                ->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Cache command status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cache command status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $command = CacheCommand::findOrFail($id);
        $command->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cache command deleted successfully.',
        ]);
    }

    public function runCommand($command)
    {
        Artisan::call($command);
        $output = Artisan::output();

        return response()->json([
            'success' => true,
            'output' => $output
        ]);
    }
}
