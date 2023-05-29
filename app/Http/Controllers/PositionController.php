<?php

namespace App\Http\Controllers;

use App\Models\Departmen;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;

class PositionController extends Controller
{
    public function index(Datatables $datatables)
    {
        $columns = [
            'id' => ['title' => 'No.', 'orderable' => false, 'searchable' => false, 'render' => function () {
                return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
            }],
            'name' => ['name' => 'name', 'title' => 'Nama'],
            'description' => ['name' => 'description', 'title' => 'Deskripsi'],
            'minimum_employee' => ['name' => 'minimum_employee', 'title' => 'Minimum Jumlah Karyawan'],
            'aksi' => [
                'orderable' => false, 'width' => '110px', 'searchable' => false, 'printable' => false, 'class' => 'text-center', 'width' => '130px', 'exportable' => false
            ],
        ];

        if ($datatables->getRequest()->ajax()) {
            $position = Position::query()
                ->select('positions.*', 'departmens.name as departmen_name')
                ->with('departmen')
                ->leftJoin('departmens', 'positions.departmen_id', '=', 'departmens.id');

            return $datatables->eloquent($position)
                ->filterColumn('name', function (Builder $query, $keyword) {
                    $sql = "positions.name  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('description', function (Builder $query, $keyword) {
                    $sql = "positions.description like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('minimum_employee', function (Builder $query, $keyword) {
                    $sql = "positions.minimum_employee like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('aksi', function (Position $data) {
                    $position = $data->load('departmen');
                    $button = '';

                    if (auth()->user()->can('ubah jabatan')) {
                        $button .= '<a href="javascript:void(0)" onclick="onEdit(' . htmlspecialchars(json_encode($position), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-warning me-2"><i class="bi bi-pen"></i></a>';
                    }

                    if (auth()->user()->can('hapus jabatan')) {
                        $button .= '<a href="javascript:void(0)" onclick="onDelete(' . htmlspecialchars(json_encode($position), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>';
                    }

                    return $button;
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }

        $columnsArrExPr = [0, 1, 2, 3];
        $html = $datatables->getHtmlBuilder()
            ->columns($columns)
            ->parameters([
                'order' => [[1, 'desc']],
                'responsive' => true,
                'autoWidth' => false,
                'dom' => 'lBfrtip',
                'lengthMenu' => [
                    [10, 25, 50, -1],
                    ['10 Data', '25 Data', '50 Data', 'Semua Data']
                ],
                'buttons' => $this->buttonDatatables($columnsArrExPr),
            ]);


        $positions = Position::all();
        $departments = Departmen::all();

        $compact = compact('html', 'positions', 'departments');

        return view("pages.master.position.index", $compact);
    }

    private function buttonDatatables($columnsArrExPr)
    {
        return [
            ['extend' => 'csv', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Export CSV'],
            ['extend' => 'pdf', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Export PDF'],
            ['extend' => 'excel', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Export Excel'],
            ['extend' => 'print', 'className' => 'btn btn-sm btn-secondary', 'text' => 'Print'],
        ];
    }

    public function fetchData()
    {
        $positions = Position::all();

        return response()->json([
            "positions" => $positions,
        ]);
    }

    public function store()
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $position = Position::find(request("id"));
                $position->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $position = new Position;
                $position->created_by = Auth::user()->id;

                $message = "ditambahkan";
            }

            $position->name = request("name");
            $position->description = request("description");
            $position->minimum_employee = request("minimum_employee");
            $position->departmen_id = request("departmen_id");
            $position->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil {$message}",
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => "Gagal {$message}",
            ], 500);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $position = Position::find(request("id"));
            $position->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $position->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus',
            ], 500);
        }
    }
}
