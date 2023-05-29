<?php

namespace App\Http\Controllers;

use App\Models\Barge;
use App\Models\Customer;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(Datatables $datatables)
    {
        $columns = [
            'id' => ['title' => 'No.', 'orderable' => false, 'searchable' => false, 'render' => function () {
                return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
            }],
            'name' => ['name' => 'name', 'title' => 'Nama'],
            'company_name' => ['name' => 'company_name', 'title' => 'Nama Perusahaan'],
            'barge_name' => ['name' => 'barge_name', 'title' => 'Nama Kapal'],
            'aksi' => [
                'orderable' => false, 'width' => '110px', 'searchable' => false, 'printable' => false, 'class' => 'text-center', 'width' => '130px', 'exportable' => false
            ],
        ];

        if ($datatables->getRequest()->ajax()) {
            $departmen = Customer::query()
                ->select('customers.*', 'companies.name as company_name', 'barges.name as barge_name')
                ->with('company', 'barge')
                ->leftJoin('companies', 'customers.company_id', '=', 'companies.id')
                ->leftJoin('barges', 'customers.barge_id', '=', 'barges.id');

            return $datatables->eloquent($departmen)
                ->filterColumn('name', function (Builder $query, $keyword) {
                    $sql = "customers.name  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('company_name', function (Builder $query, $keyword) {
                    $sql = "companies.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('barge_name', function (Builder $query, $keyword) {
                    $sql = "barges.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('aksi', function (Customer $data) {
                    $customer = $data->load('company', 'barge');
                    $button = '';

                    if (auth()->user()->can('ubah pelanggan')) {
                        $button .= '<a href="javascript:void(0)" onclick="onEdit(' . htmlspecialchars(json_encode($customer), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-warning me-2"><i class="bi bi-pen"></i></a>';
                    }

                    if (auth()->user()->can('hapus pelanggan')) {
                        $button .= '<a href="javascript:void(0)" onclick="onDelete(' . htmlspecialchars(json_encode($customer), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>';
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


        $barges = Barge::all();
        $companies = Company::all();
        $customers = Customer::all();

        $compact = compact('html', 'barges', 'companies', 'customers');

        return view("pages.master.customer.index", $compact);
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
    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $customer = Customer::find(request("id"));
                $customer->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $customer = new Customer;
                $customer->created_by = Auth::user()->id;

                $message = "ditambahkan";
            }

            $customer->name = request("name");
            $customer->company_id = request("company_id");
            $customer->barge_id = request("barge_id");
            $customer->save();

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

            $customer = Customer::find(request("id"));
            $customer->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $customer->delete();

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
