<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function monthly()
    {
        $month = Carbon::now();
        $monthNow = $month->format("Y-m");
        $monthReadAble = $month->isoFormat("MMMM YYYY");
        $employees =  [
            (object)[
                "id" => 1,
                "name" => "AVET ATAN",
            ],
            (object)[
                "id" => 2,
                "name" => "MUHAMMAD ADI",
            ],
        ];

        $data = (object) [
            //
        ];

        return view("pages.payroll.monthly", compact(
            "data",
            "month",
            "employees",
            "monthNow",
        ));
    }

    public function fetchInformation()
    {
        $employeeId = request("employee_id");
        $month = Carbon::parse(request("month_filter", Carbon::now()));
        $monthNow = $month->format("Y-m");
        $monthReadAble = $month->isoFormat("MMMM YYYY");

        $employee =  (object)[
            "id" => 1,
            "name" => "AVET ATAN",
            "number_identity" => "112201001",
            "position_name" => "DRIVER",
            "salary" => "3.394.000",
            "tunjangan_tetap" => "",
            "rate_lembur" => "19.618",
            "tunjangan_makan" => "12.000",
            "tunjangan_transportasi" => "-",
            "tunjangan_kehadiran" => "-",
            "ptkp_karyawan" => "-",
            "jumlah_cuti_ijin" => "-",
            "sisa_cuti" => "-",
        ];

        return response()->json([
            "employee" => $employee,
            "monthReadAble" => $monthReadAble,
        ]);
    }

    public function fetchSalary()
    {
        $employeeId = request("employee_id");
        $month = Carbon::parse(request("month_filter", Carbon::now()));
        $monthNow = $month->format("Y-m");
        $monthReadAble = $month->isoFormat("MMMM YYYY");

        $data = (object) [
            // A. Pendapatan
            "jumlah_gaji_dasar" => 1,
            "nominal_gaji_dasar" => "3.394.000",
            "jumlah_tunjangan_tetap" => 1,
            "nominal_tunjangan_tetap" => "-",
            "jumlah_uang_makan" => 10,
            "nominal_uang_makan" => "-",
            // total berapa jam lembur
            "jumlah_lembur" => 7,
            "nominal_lembur" => "137.326",
            "nominal_tambahan_lain_lain" => "130.538",
            "jumlah_pendapatan_kotor" => "3.661.864",
            // B. Pemotongan
            "nominal_bpjs_dibayar_karyawan" => "135.781",
            "nominal_pajak_penghasilan_pph21" => "-",
            "nominal_potongan_lain_lain" => "-",
            "jumlah_potongan" => "135.781",
            "gaji_bersih" => "3.526.083",
        ];

        return response()->json([
            "data" => $data,
        ]);
    }

    public function fetchBpjs()
    {
        $employeeId = request("employee_id");
        $month = Carbon::parse(request("month_filter", Carbon::now()));
        $monthNow = $month->format("Y-m");
        $monthReadAble = $month->isoFormat("MMMM YYYY");

        $data = (object) [
            "dasar_upah_bpjs_tk" => "3.394.513",
            "dasar_upah_bpjs_kesehatan" => "3.394.513",
        ];

        $jaminanSosial = [
            (object)[
                "nama" => "Hari Tua (JHT)",
                "perusahaan_persen" => "3,70",
                "perusahaan_nominal" => "125.597",
                "karyawan_persen" => "2,00",
                "karyawan_nominal" => "67.890",
            ],
            (object)[
                "nama" => "Kecelakaan (JKK)",
                "perusahaan_persen" => "1,74",
                "perusahaan_nominal" => "59.065",
                "karyawan_persen" => "0,00",
                "karyawan_nominal" => "0",
            ],
            (object)[
                "nama" => "Kematian (JKM)",
                "perusahaan_persen" => "0,30",
                "perusahaan_nominal" => "10.184",
                "karyawan_persen" => "0,00",
                "karyawan_nominal" => "0",
            ],
            (object)[
                "nama" => "Pensiun (JP)",
                "perusahaan_persen" => "2,00",
                "perusahaan_nominal" => "67.890",
                "karyawan_persen" => "1,00",
                "karyawan_nominal" => "33.945",
            ],
            (object)[
                "nama" => "Kesehatan (BPJS)",
                "perusahaan_persen" => "4,00",
                "perusahaan_nominal" => "135.781",
                "karyawan_persen" => "1,00",
                "karyawan_nominal" => "33.945",
            ],
        ];

        return response()->json([
            "data" => $data,
            "jaminanSosial" => $jaminanSosial,
        ]);
    }

    public function fetchPph21()
    {
        $employeeId = request("employee_id");
        $month = Carbon::parse(request("month_filter", Carbon::now()));
        $monthNow = $month->format("Y-m");
        $monthReadAble = $month->isoFormat("MMMM YYYY");

        $data = (object) [
            // D. Penghasilan Kotor
            "gaji_kotor_potongan" => "3.661.864",
            "bpjs_dibayar_perusahaan" => "398.516",
            "total_penghasilan_kotor" => "4.060.380",
            // E. Pengurangan
            "biaya_jabatan" => "203.019",
            "bpjs_dibayar_karyawan" => "135.781",
            "jumlah_pengurangan" => "338.800",
            // F. Gaji Bersih 12 Bulan
            "gaji_bersih_setahun" => "44.658.964",
            // G. PKP 12 Bulan= (F)-PTKP
            "pkp_setahun" => "44.658.964",
        ];

        $table = [
            (object) [
                "tarif" => "5",
                "dari_pkp" => "0",
                "ke_pkp" => "50",
                "progressive_pph21" => "2.232.948",
            ],
            (object) [
                "tarif" => "15",
                "dari_pkp" => "50",
                "ke_pkp" => "250",
                "progressive_pph21" => "-",
            ],
            (object) [
                "tarif" => "25",
                "dari_pkp" => "250",
                "ke_pkp" => "500",
                "progressive_pph21" => "-",
            ],
            (object) [
                "tarif" => "30",
                "dari_pkp" => "500",
                "ke_pkp" => "1.000",
                "progressive_pph21" => "-",
            ],
        ];

        return response()->json([
            "data" => $data,
            "table" => $table,
        ]);
    }
}
