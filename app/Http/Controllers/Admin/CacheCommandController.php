<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CacheCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CacheCommandController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Cache Command';
        if ($request->ajax()) {
            $data = CacheCommand::query();

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
                    $btn .= '<button class="btn btn-info btn-sm view-btn mr-1" data-id="' . $row->id . '" title="View">
                                <i class="fas fa-eye"></i>
                            </button>';
                    $btn .= '<button class="btn btn-primary btn-sm edit-btn mr-1" data-id="' . $row->id . '" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>';
                    $btn .= '<button class="btn ' . $btnClass . ' btn-sm status-toggle mr-1" data-id="' . $row->id . '" data-status="' . $row->status . '" title="Status">
                                <i class="fas ' . $btnIcon . '"></i>
                            </button>';
                    $btn .= '<button class="btn btn-danger btn-sm status-toggle mr-1" data-id="' . $row->id . '" title="Delete">
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
            'name' => 'required',
            'command' => 'required|unique:cache_commands,command',
            'state' => 'required',
            'zip_codes' => 'required',
            'cache_file' => 'required'
        ]);

        $data = $request->all();
        $data['zip_codes'] = implode(',', array_map('trim', explode(',', $request->zip_codes)));

        CacheCommand::create($data);

        return redirect()->route('cache-commands.index')
            ->with('success', 'Cache command created successfully.');
    }

    public function edit($id)
    {
        $command = CacheCommand::findOrFail($id);
        return view('admin.cache-commands.edit', compact('command'));
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

    public function destroy($id)
    {
        $command = CacheCommand::findOrFail($id);
        $command->delete();

        return response()->json(['success' => 'Cache command deleted successfully.']);
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
