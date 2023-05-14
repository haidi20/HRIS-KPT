<?php

return [
    "feature_private" => ["Jam Kerja", "Bahan", "Lokasi", "Jadwal Kerja", "Penyesuaian Gaji", "Jenis Karyawan", "Tingkat Persetujuan"],
    "permission_private" => [
        "lihat jam kerja",  "lihat bahan", "lihat penyesuaian gaji",
        "lihat lokasi", "lihat jadwal kerja", "lihat jenis karyawan", "lihat tingkat persetujuan",
        "hapus fitur", "hapus hak akses",
    ],
    "permission_added" => [
        [
            "name" => "detail fitur",
            "featurer_id" => 7,
        ],
        [
            "name" => "detail grup pengguna",
            "featurer_id" => 7,
        ],
        [
            "name" => "detail proyek",
            "featurer_id" => 8,
        ],
        [
            // untuk tombol detail job order di proyek
            "name" => "proyek job order",
            "featurer_id" => 8,
        ],
        // start kasbon
        [
            "name" => "persetujuan kasbon",
            "featurer_id" => 4,
        ],
        [
            "name" => "perwakilan kasbon",
            "featurer_id" => 4,
        ],
        [
            "name" => "perwakilan persetujuan kasbon",
            "featurer_id" => 4,
        ],
        [
            "name" => "ekspor laporan kasbon",
            "featurer_id" => 4,
        ],

        // end kasbon

        // start SPL
        [
            "name" => "detail laporan surat perintah lembur",
            "featurer_id" => 11,
        ],
        [
            "name" => "ekspor laporan surat perintah lembur",
            "featurer_id" => 11,
        ],

        // end SPL
        [
            "name" => "ekspor laporan job order",
            "featurer_id" => 9,
        ],
    ],
];
