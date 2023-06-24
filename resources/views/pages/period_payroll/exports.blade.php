<table>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    
    <tr>
        <td><br></td>
        <td>PERHITUNGAN GAJI</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td>Bulan</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td>Id</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td>Nama</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td>Posisi</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>

    <tr>
        <td><br></td>
        <td>Kode Hari Kerja</td>
        <td>Tanggal</td>
        <td>Hari</td>
        <td>Masuk</td>
        <td>Keluar</td>
        <td>Durasi</td>
        <td>Koreksi Jam</td>
        <td>Istirahat</td>
        <td>Jam Kerja</td>
        <td>Normal</td>
        <td>Perhitungan Lembur</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>x1</td>
        <td>x2</td>
        <td>x3</td>
        <td>x4</td>
    </tr>

    @for ($i = 1; $i <= 31; $i++)
    <tr>
        <td><br></td>
        <td><br></td>
        <td>{{$i}}</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    @endfor

    <tr>
        <td><br></td>
        <td>TOTAL</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>t1</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td>Jumlah Masuk Hari Kerja</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>t1</td>
        <td>hari</td>
        <td><br></td>
        <td>Total Jam Lembur</td>
        <td>-</td>
        <td>jam</td>
        <td><br></td>
        <td><br></td>
    </tr>

    <tr>
        <td><br></td>
        <td>Perhitungan Gaji</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>t1</td>
        <td><br></td>
        <td>II. Perhitungan BPJS</td>
        <td><br></td>
        <td><br></td>
        <td>Dasar Upah BPJS TK</td>
        <td><br></td>
        <td colspan="2">Rp. 3.000.000</td>
    </tr>
    <tr>
        <td><br></td>
        <td>A. Pendapatan Gaji</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>Dasar Upah BPJS KES</td>
        <td><br></td>
        <td colspan="2">Rp. 3.000.000</td>
    </tr>

    <tr>
        <td><br></td>
        <td>1</td>
        <td>Gaji Dasar</td>
        <td><br></td>
        <td>1</td>
        <td>Bulan</td>
        <td colspan="2">Rp. 3.000.000</td>
        <td>Jaminan Sosial</td>
        <td><br></td>
        <td><br></td>
        <td>%Perusahaan</td>
        <td>%Karyawan</td>
        <td>Rp Perusahaan</td>
        <td>Rp Karyawan</td>
        
    </tr>

    <tr>
        <td><br></td>
        <td>2</td>
        <td>Tunjangan Tetap</td>
        <td><br></td>
        <td>1</td>
        <td>Bulan</td>
        <td colspan="2">Rp. 3.000.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
    </tr>

    <tr>
        <td><br></td>
        <td>3</td>
        <td>Uang Makan</td>
        <td><br></td>
        <td>1</td>
        <td>Hari</td>
        <td colspan="2">Rp. 3.000.000</td>
        <td>1. Hari Tua (JHT)</td>
        <td><br></td>
        <td><br></td>
        <td>%Perusahaan</td>
        <td>%Karyawan</td>
        <td>Rp Perusahaan</td>
        <td>Rp Karyawan</td>
        
    </tr>

    <tr>
        <td><br></td>
        <td>4</td>
        <td>Lembur</td>
        <td><br></td>
        <td>1</td>
        <td>Jam</td>
        <td colspan="2">Rp. 3.000.000</td>
        <td>2. Kecelakaan (JKK)</td>
        <td><br></td>
        <td><br></td>
        <td>%Perusahaan</td>
        <td>%Karyawan</td>
        <td>Rp Perusahaan</td>
        <td>Rp Karyawan</td>
        
    </tr>

    <tr>
        <td><br></td>
        <td>5</td>
        <td>Tambahan Lain Lain</td>
        <td><br></td>
        <td></td>
        <td></td>
        <td colspan="2">Rp. 3.000.000</td>
        <td>3. Kematian (JKM)</td>
        <td><br></td>
        <td><br></td>
        <td>%Perusahaan</td>
        <td>%Karyawan</td>
        <td>Rp Perusahaan</td>
        <td>Rp Karyawan</td>
        
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
        <td>Jumlah Pendapatan Kotor A</td>
        <td><br></td>
        <td></td>
        <td></td>
        <td colspan="2">Rp. 3.000.000</td>
        <td>4. Pensiun (JP)</td>
        <td><br></td>
        <td><br></td>
        <td>%Perusahaan</td>
        <td>%Karyawan</td>
        <td>Rp Perusahaan</td>
        <td>Rp Karyawan</td>
        
    </tr>

    <tr>
        <td><br></td>
        <td>B. Pemotongan</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
        <td>5. Kesehatan (BPJS)</td>
        <td><br></td>
        <td><br></td>
        <td>%Perusahaan</td>
        <td>%Karyawan</td>
        <td>Rp Perusahaan</td>
        <td>Rp Karyawan</td>
        
    </tr>

    <tr>
        <td><br></td>
        <td>1</td>
        <td>BPJS dibayar Karyawan</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan="2">Rp. 3.000.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
    </tr>

    <tr>
        <td><br></td>
        <td>2</td>
        <td>Pajak Penghasilan PPH21((H)/12)</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan="2">Rp. 3.000.000</td>
        <td>Total</td>
        <td><br></td>
        <td><br></td>
        <td>%Perusahaan</td>
        <td>%Karyawan</td>
        <td>Rp Perusahaan</td>
        <td>Rp Karyawan</td>
        
    </tr>


    <tr>
        <td><br></td>
        <td>3</td>
        <td>Potongan Lain-Lain</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan="2">Rp. 3.000.000</td>
        <td>IV. Perhitungan Pajak Penghasilan (PPH21) </td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
        <td>Jumlah Potongan (B)</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan="2">Rp. 3.000.000</td>
        <td>D. Penghasilan kotor </td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>1. Gaji Kotor - Potongan </td>
        <td><br></td>
        <td><br></td>
        <td>Rp. 300.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
    </tr>

    <tr>
        <td><br></td>
        <td>C. Gaji Bersih (A)-(B)</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan="2">Rp. 300.000</td>
        <td>2. BPJS dibayar Perusahaan </td>
        <td><br></td>
        <td><br></td>
        <td>Rp. 300.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
    </tr>

    <tr>
        <td><br></td>
        <td>C. Gaji Bersih (A)-(B)</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan="2">Rp. 300.000</td>
        <td>Total Penghasilan Kotor (D) </td>
        <td><br></td>
        <td><br></td>
        <td>Rp. 300.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>E. Pengurang</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>1. Biaya Jabatan (5% x (D)) </td>
        <td><br></td>
        <td><br></td>
        <td>Rp. 300.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>2. BPJS dibayar Karyawan </td>
        <td><br></td>
        <td><br></td>
        <td>Rp. 300.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>

    <tr>
        <td><br></td>
        <td>Dihitung Oleh</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>Diterima Oleh</td>
        <td><br></td>
        <td><br></td>
        <td>Jumlah Pengurang (E) </td>
        <td><br></td>
        <td><br></td>
        <td>Rp. 300.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>F. Gaji Bersih 12 Bulan</td>
        <td><br></td>
        <td><br></td>
        <td>Rp. 300.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>G. PKP 12 Bulan = (F)- PTKP</td>
        <td><br></td>
        <td><br></td>
        <td>Rp. 300.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>Tarif</td>
        <td>Dari PKP</td>
        <td>Ke PKP</td>
        <td>Progressive PPH 21</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>5%</td>
        <td> 0 Jt</td>
        <td>60 Jt</td>
        <td>Rp. 300.00000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>15%</td>
        <td> 60 Jt</td>
        <td>250 Jt</td>
        <td>Rp. 300.00000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>25%</td>
        <td> 250 Jt</td>
        <td> 500 Jt</td>
        <td>Rp. 300.00000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>30%</td>
        <td> 500 Jt</td>
        <td> 1000 Jt</td>
        <td>Rp. 300.00000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td>G. PPH21 Setahun</td>
        <td><br></td>
        <td><br></td>
        <td>Rp. 300.000</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>






















</table>