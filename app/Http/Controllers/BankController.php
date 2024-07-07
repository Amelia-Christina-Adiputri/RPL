<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\trans_pbs;
use App\bank_proses;
use App\bank_harga;
use App\trans_byrpgs;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    // HALAMAN HOME
    public function bank_home()
    {
        session_start();
        $bank = User::find($_SESSION["id"]);
        $pembuangan = DB::select(DB::raw("
        SELECT * FROM
        trans_daftar_bank t join
        users u
        on t.id_pengguna = u.id
        where DATE(t.tgl_trans_pbs) = CURDATE() AND status_daftar = 'Valid' AND id_bank = " .$_SESSION["id"]));
        $totalSampah = DB::select(DB::raw("
        SELECT sum(berat_organik) as total_organik, sum(berat_anorganik) as total_anorganik
        FROM trans_byr_petugas t
        WHERE DATE(t.tgl_buang) = CURDATE() AND id_bank=".$_SESSION["id"].""
        ))[0];
        return view ('bank_home', ['key' => 'bank_home', 'bank' => $bank, 'pembuangan'=>$pembuangan, 'totalSampah'=>$totalSampah]);
    }

    // HALAMAN DATA DIRI
    public function bank_data_diri()
    {
        session_start();
        $bank = User::find($_SESSION["id"]);
        return view ('bank_data_diri', ['key' => 'bank_data_diri', 'bank' => $bank]);
    }

    // HALAMAN UBAH DATA DIRI
    public function bank_ubah_data_diri()
    {
        session_start();
        $bank = User::find($_SESSION["id"]);
        return view ('bank_ubah_data_diri', ['key' => 'bank_data_diri', 'bank' => $bank]);
    }

    // SIMPAN UBAH DATA DIRI
    public function bank_ubah_data_diri_update($id, Request $request)
    {
        session_start();
        $bank = User::find($_SESSION["id"]);
        // if(strcmp($bank->kapasitas_organik_bank, $request->kapasitas_organik)!=0 OR strcmp($bank->kapasitas_anorganik_bank, $request->kapasitas_anorganik!=0))
        if($bank->kapasitas_organik_bank!=$request->kapasitas_organik OR $bank->kapasitas_anorganik_bank!=$request->kapasitas_anorganik)
        {
            bank_proses::create([
                'id_bank'=>$_SESSION["id"],
                'jenis_proses'=>'Pengelolaan',
                'kapasitas_organik'=>$request->kapasitas_organik,
                'kapasitas_anorganik'=>$request->kapasitas_anorganik,
                'berat_organik'=>"0",
                'berat_anorganik'=>"0",
            ]);
        }

        $bank->nama = $request->nama;
        $bank->alamat = $request->alamat;
        $bank->email = $request->email;
        $bank->telp = $request->telp;
        $bank->kapasitas_organik_bank = $request->kapasitas_organik;
        $bank->kapasitas_anorganik_bank = $request->kapasitas_anorganik;
        $bank->latitude = $request->latitude;
        $bank->longitude = $request->longitude;
        $bank->save();
        return redirect ('bank_data_diri')->with('alert', 'Data telah berhasil diubah!');
    }

    // HALAMAN VALIDASI PENGAJUAN PEMBUANGAN
    public function bank_validasi_pengajuan_pembuangan()
    {
        session_start();
        $pendaftaran = DB::select(DB::raw("
        SELECT * FROM
        trans_daftar_bank t join
        users u
        on t.id_pengguna = u.id
        where status_daftar = 'Menunggu' AND DATE(t.tgl_trans_pbs) = CURDATE() AND id_bank = " .$_SESSION["id"]));

        $terdaftar = DB::select(DB::raw("
        SELECT * FROM
        trans_daftar_bank t join
        users u
        on t.id_pengguna = u.id
        where status_daftar = 'Valid' AND DATE(t.tgl_trans_pbs) = CURDATE() AND id_bank = " .$_SESSION["id"]));

        return view ('bank_validasi_pengajuan_pembuangan', ['key' => 'bank_validasi_pengajuan_pembuangan', 'pendaftaran' => $pendaftaran, 'terdaftar' => $terdaftar]);
    }

    // TERIMA PENGAJUAN PEMBUANGAN
    public function bank_validasi_pengajuan_pembuangan_terima_pbs($id_trans_pbs)
    {
        $pendaftaran = trans_pbs::find($id_trans_pbs);
        $pendaftaran->status_daftar = 'Valid';
        $pendaftaran->save();
        return redirect('/bank_validasi_pengajuan_pembuangan');
    }

    // TOLAK PENGAJUAN PEMBUANGAN
    public function bank_validasi_pengajuan_pembuangan_tolak_pbs($id_trans_pbs)
    {
        $pendaftaran = trans_pbs::find($id_trans_pbs);
        $pendaftaran->delete();
        return redirect('/bank_validasi_pengajuan_pembuangan');
    }

    // HALAMAN PENGAJUAN PENERIMAAN
    public function bank_pengajuan_penerimaan()
    {
        session_start();
        $pembuangan = DB::select(DB::raw("
        SELECT t.id_petugas as id_pgs, t.id_pengguna as id_pggn, u.nama as nama_pgs, us.nama as nama_plggn, sum(berat_organik) as total_organik, sum(berat_anorganik) as total_anorganik
        FROM trans_byr_petugas t LEFT JOIN
        users u on t.id_petugas = u.id LEFT JOIN
        users us on t.id_pengguna = us.id
        where status_klaim = 'Menunggu' AND t.id_bank = " .$_SESSION["id"]. "
        group by nama_pgs, nama_plggn, id_pgs, id_pggn"
        ));

        $riwayat = DB::select(DB::raw("
        SELECT t.id_petugas as id_pgs, t.id_bank, us.nama as nama_petugas, t.id_pengguna as id_pggn, u.nama as nama_pggn, sum(berat_organik) as total_organik, sum(berat_anorganik) as total_anorganik,
        sum(berat_organik*harga_organik)+sum(berat_anorganik*harga_anorganik) as total_penerimaan
        FROM
        trans_byr_petugas t left join
        users u
        on t.id_pengguna = u.id left join
        users us
        on t.id_petugas = us.id
        where status_klaim = 'Sudah' AND t.id_bank = ".$_SESSION["id"]."
        group by id_pgs, t.id_bank, nama_petugas, nama_pggn, id_pggn;"
        ));
        return view ('bank_pengajuan_penerimaan', ['key' => 'bank_pengajuan_penerimaan', 'pembuangan' => $pembuangan, 'riwayat'=>$riwayat]);
    }

    // HALAMAN DETAIL PENGAJUAN PENERIMAAN
    public function bank_detail_pengajuan_penerimaan($id_petugas, $id_pengguna)
    {
        session_start();
        $harga = DB::select(DB::raw("
        SELECT DATE(tgl_buang) as tgl_buang, berat_organik, berat_organik*harga_organik as harga_organik, berat_anorganik, berat_anorganik*harga_anorganik as harga_anorganik
        FROM trans_byr_petugas t join users u
        on t.id_petugas = u.id
        where status_klaim = 'Menunggu' AND t.id_petugas = " .$id_petugas. " AND t.id_bank = " .$_SESSION["id"]. " AND t.id_pengguna = " .$id_pengguna. "
        group by tgl_buang, berat_organik, berat_anorganik, harga_organik, harga_anorganik"));
        $total = DB::select(DB::raw("
        SELECT id_petugas, id_pengguna, u.nama as nama_pgs, us.nama as nama_pggn,sum(berat_organik*harga_organik) as total_harga_organik, sum(berat_anorganik*harga_anorganik) as total_harga_anorganik,
        sum(berat_organik*harga_organik+berat_anorganik*harga_anorganik) as total_penerimaan
        FROM trans_byr_petugas t LEFT JOIN
        users u on t.id_petugas = u.id LEFT JOIN
        users us on t.id_pengguna = us.id
        where status_klaim = 'Menunggu' AND t.id_bank = " .$_SESSION["id"]. " AND t.id_petugas =  ".$id_petugas. " AND t.id_pengguna = " .$id_pengguna. "
        group by id_petugas, id_pengguna, nama_pgs, nama_pggn;"
        ))[0];
        return view('bank_detail_pengajuan_penerimaan', ['key' => 'bank_pengajuan_penerimaan', 'harga' => $harga, 'total'=>$total]);
    }

    // BAYAR PENGAJUAN PENERIMAAN
    public function bank_detail_pengajuan_penerimaan_bayar($id_petugas, $id_pengguna)
    {
        session_start();
        DB::select(DB::raw("
        UPDATE trans_byr_petugas
        SET status_klaim = 'Sudah'
        WHERE id_petugas=".$id_petugas." and id_pengguna=".$id_pengguna." and id_bank=".$_SESSION["id"].";"
        ));
        return redirect('bank_pengajuan_penerimaan');
    }

    // HALAMAN PROSES SAMPAH
    public function bank_proses_sampah()
    {
        session_start();
        $proses = bank_proses::where('id_bank', $_SESSION["id"])->get();
        $bank = User::find($_SESSION["id"]);
        $petugas = DB::select(DB::raw("
        select * from trans_daftar_bank t left join users u
        on t.id_pengguna = u.id
        where DATE(t.tgl_trans_pbs) = CURDATE()
        and u.role = 'Petugas'
        and t.id_bank =".$_SESSION["id"]
        ));
        $pengguna1 = DB::select(DB::raw("
        select t.id_pengguna, u.nama as nama_pengguna from trans_daftar_bank t left join users u
        on t.id_pengguna = u.id
        where DATE(t.tgl_trans_pbs) = CURDATE()
        and u.role = 'Pengguna'
        and t.id_bank =".$_SESSION["id"]
        ));
        $pengguna2 = DB::select(DB::raw("
        select psp.id_pengguna, u.nama as nama_pengguna from trans_daftar_bank pbs left join trans_pengajuan_sampah psp
        on pbs.id_pengguna = psp.id_petugas left join users u
        on psp.id_pengguna = u.id
        where DATE(pbs.tgl_trans_pbs) = CURDATE()
        and status_terima = 'Berlangganan' and
        DATE(tgl_berlaku_psp) >= CURDATE()
        and pbs.id_bank =".$_SESSION["id"]
        ));
        $pengguna = array_filter(array_unique(array_merge($pengguna1,$pengguna2), SORT_REGULAR));
        return view ('bank_proses_sampah', ['key' => 'bank_proses_sampah', 'proses'=>$proses, 'bank'=>$bank, 'petugas'=>$petugas, 'pengguna'=>$pengguna]);
    }

    // TAMBAH PROSES SAMPAH
    public function bank_proses_sampah_insert(Request $request)
    {
        session_start();
        $harga=bank_harga::all();
        $proses = bank_proses::where('id_bank', $_SESSION["id"])->orderBy('id_proses', 'desc')->first();
        if($request->proses=="Penerimaan")
        {
            $kapasitas_organik = ((int)$proses->kapasitas_organik-(int)$request->organik);
            $kapasitas_anorganik = ((int)$proses->kapasitas_anorganik-(int)$request->anorganik);
            trans_byrpgs::create([
                'id_bank'=>$_SESSION["id"],
                'id_petugas'=>$request->id_petugas,
                'id_pengguna'=>$request->id_pengguna,
                'id_harga_organik'=>1,
                'id_harga_anorganik'=>2,
                'harga_organik'=>bank_harga::find(1)->harga_sampah,
                'harga_anorganik'=>bank_harga::find(2)->harga_sampah,
                'berat_organik'=>$request->organik,
                'berat_anorganik'=>$request->anorganik,
                'status_klaim'=>"Belum"
            ]);
        }else
        {
            $kapasitas_organik = ((int)$proses->kapasitas_organik+(int)$request->organik);
            $kapasitas_anorganik = ((int)$proses->kapasitas_anorganik+(int)$request->anorganik);
        }

        bank_proses::create([
            'id_bank'=>$_SESSION["id"],
            'jenis_proses'=>$request->proses,
            'kapasitas_organik'=>$kapasitas_organik,
            'kapasitas_anorganik'=>$kapasitas_anorganik,
            'berat_organik'=>$request->organik,
            'berat_anorganik'=>$request->anorganik
        ]);
        return redirect ('/bank_proses_sampah');
    }

    //HALAMAN LUARAS
    public function bank_luaran(Request $request)
    {
        session_start();
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        if($request->tgl_awal == "" && $request->tgl_akhir == "")
        {
            $pembuangan = DB::select(DB::raw("
            SELECT u.nama as nama_pgs, us.nama as nama_plggn, t.harga_organik, t.harga_anorganik, tgl_buang, berat_organik, berat_anorganik
            FROM trans_byr_petugas t LEFT JOIN
            users u on t.id_petugas = u.id LEFT JOIN
            users us on t.id_pengguna = us.id
            WHERE id_bank=".$_SESSION["id"].""
            ));
            $totalSampah = DB::select(DB::raw("
            SELECT sum(berat_organik) as total_organik, sum(berat_anorganik) as total_anorganik
            FROM trans_byr_petugas t
            WHERE id_bank=".$_SESSION["id"].""
            ))[0];
            return view('bank_luaran', ['key' => 'bank_luaran', 'pembuangan'=>$pembuangan, 'totalSampah'=>$totalSampah]);
        }
        else if($request->tgl_awal <= $request->tgl_akhir)
        {
            $pembuangan = DB::select(DB::raw("
            SELECT u.nama as nama_pgs, us.nama as nama_plggn, t.harga_organik, t.harga_anorganik, tgl_buang, berat_organik, berat_anorganik
            FROM trans_byr_petugas t LEFT JOIN
            users u on t.id_petugas = u.id LEFT JOIN
            users us on t.id_pengguna = us.id
            WHERE id_bank=".$_SESSION["id"]." AND DATE(t.tgl_buang) BETWEEN STR_TO_DATE('$tgl_awal', '%Y-%m-%d') AND STR_TO_DATE('$tgl_akhir', '%Y-%m-%d')"
            ));
            $totalSampah = DB::select(DB::raw("
            SELECT sum(berat_organik) as total_organik, sum(berat_anorganik) as total_anorganik
            FROM trans_byr_petugas t
            WHERE id_bank=".$_SESSION["id"]." AND DATE(t.tgl_buang) BETWEEN STR_TO_DATE('$tgl_awal', '%Y-%m-%d') AND STR_TO_DATE('$tgl_akhir', '%Y-%m-%d')"
            ))[0];
            return view('bank_luaran', ['key' => 'bank_luaran', 'pembuangan'=>$pembuangan, 'totalSampah'=>$totalSampah]);
        }
        else{
            return redirect('bank_luaran')->with('alert', 'Tanggal awal harus lebih kecil atau sama dengan tanggal akhir!');
        }

    }

}
