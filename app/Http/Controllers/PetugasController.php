<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\trans_pbs;
use App\trans_psp;
use App\trans_pp;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function petugas_home()
    {
        // HALAMAN HOME
        session_start();
        $petugas = User::find($_SESSION["id"]);
        $pengajuan = DB::select(DB::raw("
        SELECT * FROM
        trans_pengajuan_sampah t join
        users u
        on t.id_pengguna = u.id
        where status_terima = 'Menunggu' AND id_petugas = " .$_SESSION["id"]));

        $langganan = DB::select(DB::raw("
        SELECT * FROM
        trans_pengajuan_sampah t join
        users u
        on t.id_pengguna = u.id
        where status_terima = 'Berlangganan' AND id_petugas = " .$_SESSION["id"]));

        $pembayaran = DB::select(DB::raw("
        SELECT * FROM
        trans_pengajuan_sampah t join
        users u
        on t.id_pengguna = u.id
        where status_terima = 'Menunggu Pembayaran' AND id_petugas = " .$_SESSION["id"]));

        return view('petugas_home', ['key' => 'petugas_home', 'petugas' => $petugas, 'pengajuan' => $pengajuan, 'pembayaran' => $pembayaran, 'langganan' => $langganan]);
    }

    //TERIMA PENGAJUAN LANGGANAN
    public function petugas_home_terima_psp($id_trans_psp)
    {
        $pengajuan = trans_psp::find($id_trans_psp);
        $pengajuan->status_terima = 'Menunggu Pembayaran';
        $pengajuan->tgl_validasi_psp = date('Y/m/d H:i:s');
        $pengajuan->save();
        return redirect('/petugas_home');
    }

    // PEMBAYARAN PENGAJUAN LANGGANAN
    public function petugas_home_pembayaran_psp($id_trans_psp)
    {
        $pengajuan = trans_psp::find($id_trans_psp);
        $pengajuan->status_terima = 'Berlangganan';
        $pengajuan->tgl_pembayaran_psp = date('Y/m/d H:i:s');
        $pengajuan->tgl_berlaku_psp = date('Y/m/d H:i:s', strtotime(date('Y/m/d H:i:s'). ' + 30 day'));
        $pengajuan->save();
        return redirect('/petugas_home');
    }

    // TOLAK PENGAJUAN LANGGANAN
    public function petugas_home_tolak_psp($id_trans_psp)
    {
        $pengajuan = trans_psp::find($id_trans_psp);
        $pengajuan->status_terima = 'Ditolak';
        $pengajuan->save();
        return redirect('/petugas_home');
    }

    // HALAMAN DATA DIRI
    public function petugas_data_diri()
    {
        session_start();
        $petugas = User::find($_SESSION["id"]);
        return view('petugas_data_diri', ['key' => 'petugas_data_diri', 'petugas' => $petugas]);
    }

    // HALAMAN UBAH DATA DIRI
    public function petugas_ubah_data_diri()
    {
        session_start();
        $petugas = User::find($_SESSION["id"]);
        return view('petugas_ubah_data_diri', ['key' => 'petugas_data_diri', 'petugas' => $petugas]);
    }

    // SIMPAN UBAH DATA DIRI
    public function petugas_ubah_data_diri_update(Request $request)
    {
        session_start();
        $petugas = User::find($_SESSION["id"]);
        $petugas->nama = $request->nama;
        $petugas->alamat = $request->alamat;
        $petugas->telp = $request->telp;
        $petugas->latitude = $request->latitude;
        $petugas->longitude = $request->longitude;
        $petugas->kapasitas_petugas = $request->kapasitas;
        $petugas->tarif_petugas = $request->tarif;
        $petugas->save();
        return redirect ('petugas_data_diri')->with('alert', 'Data telah berhasil diubah!');
    }

    // HALAMAN TITIK JEMPUT LANGGANAN
    public function petugas_titik_jemput_langganan()
    {
        session_start();
        $petugas = User::find($_SESSION["id"]);
        $pengajuan = DB::select(DB::raw("
        SELECT * FROM
        trans_pengajuan_sampah t join
        users u
        on t.id_pengguna = u.id
        where status_terima = 'Berlangganan' AND '".date("Y-m-d H:i:s")."'<=tgl_berlaku_psp AND id_petugas = " .$_SESSION["id"]));
        return view('petugas_titik_jemput_langganan', ['key' => 'petugas_titik_jemput_langganan', 'petugas' => $petugas, 'pengajuan' => $pengajuan]);
    }

    // HALAMAN TITIK JEMPUT TIDAK LANGGANAN
    public function petugas_titik_jemput_tidak_langganan()
    {
        session_start();
        $petugas = User::find($_SESSION["id"]);
        $pengajuan = DB::select(DB::raw("
        SELECT * FROM
        trans_pengajuan_sampah t join
        users u
        on t.id_pengguna = u.id
        where status_terima = 'Berlangganan' AND tgl_berlaku_psp< '".date("Y-m-d H:i:s")."' AND id_petugas = " .$_SESSION["id"]));
        return view('petugas_titik_jemput_tidak_langganan', ['key' => 'petugas_titik_jemput_tidak_langganan', 'petugas' => $petugas, 'pengajuan' => $pengajuan]);
    }

    // HALAMAN DAFTAR BANK
    public function petugas_daftar_bank()
    {
        session_start();
        $petugas = User::find($_SESSION["id"]);
        $bank = User::where('role', 'Bank')->get();

        $pbs=DB::select(DB::raw("
        SELECT *
        FROM trans_daftar_bank t
        LEFT JOIN users u
        ON t.id_bank = u.id
        WHERE date(tgl_trans_pbs) = CURDATE() AND id_pengguna =". $_SESSION["id"]));
        return view('petugas_daftar_bank', ['key' => 'petugas_daftar_bank', 'petugas' => $petugas, 'bank' => $bank, 'pbs' => $pbs]);
    }

    // DAFTAR BANK
    public function petugas_daftar_bank_insert($id_bank)
    {
        session_start();
        $bank = User::find($id_bank);
        trans_pbs::create([
            'id_pengguna' => (int)$_SESSION["id"],
            'id_bank' => (int)$id_bank,
            'status_daftar' => 'Menunggu',
            'iuran' => (int)$bank->tarif_petugas
        ]);
        return redirect('petugas_daftar_bank')->with('alert', 'Data telah berhasil ditambahkan!');
    }

    // HALAMAN AJUKAN PENERIMAAN
    public function petugas_ajukan_penerimaan()
    {
        session_start();
        $petugas = User::find($_SESSION["id"]);
        $pengguna = DB::select(DB::raw("
        SELECT * FROM
        trans_byr_petugas t join
        users u
        on t.id_pengguna = u.id
        where status_klaim = 'Belum' AND id_petugas = " .$_SESSION["id"]));

        $bank = DB::select(DB::raw("
        SELECT * FROM
        trans_byr_petugas t join
        users u
        on t.id_bank = u.id
        where status_klaim = 'Belum' AND id_petugas = " .$_SESSION["id"]));

        $pembuangan = DB::select(DB::raw("
        SELECT t.id_petugas as id_pgs, t.id_bank, us.nama as nama_bank, t.id_pengguna as id_pggn, u.nama as nama_pggn, sum(berat_organik) as total_organik, sum(berat_anorganik) as total_anorganik
        FROM
        trans_byr_petugas t left join
        users u
        on t.id_pengguna = u.id left join
        users us
        on t.id_bank = us.id
        where status_klaim = 'Belum' AND t.id_petugas = ".$_SESSION["id"]."
        group by id_pgs, t.id_bank, nama_bank, nama_pggn, id_pggn;"
        ));

        $menungguPembayaran = DB::select(DB::raw("
        SELECT t.id_petugas as id_pgs, t.id_bank, us.nama as nama_bank, t.id_pengguna as id_pggn, u.nama as nama_pggn, sum(berat_organik) as total_organik, sum(berat_anorganik) as total_anorganik
        FROM
        trans_byr_petugas t left join
        users u
        on t.id_pengguna = u.id left join
        users us
        on t.id_bank = us.id
        where status_klaim = 'Menunggu' AND t.id_petugas = ".$_SESSION["id"]."
        group by id_pgs, t.id_bank, nama_bank, nama_pggn, id_pggn;"
        ));

        $riwayat = DB::select(DB::raw("
        SELECT t.id_petugas as id_pgs, t.id_bank, us.nama as nama_bank, t.id_pengguna as id_pggn, u.nama as nama_pggn, sum(berat_organik) as total_organik, sum(berat_anorganik) as total_anorganik,
        sum(berat_organik*harga_organik)+sum(berat_anorganik*harga_anorganik) as total_penerimaan
        FROM
        trans_byr_petugas t left join
        users u
        on t.id_pengguna = u.id left join
        users us
        on t.id_bank = us.id
        where status_klaim = 'Sudah' AND t.id_petugas = ".$_SESSION["id"]."
        group by id_pgs, t.id_bank, nama_bank, nama_pggn, id_pggn;"
        ));
        return view('petugas_ajukan_penerimaan', ['key' => 'petugas_ajukan_penerimaan', 'petugas'=>$petugas, 'pengguna' => $pengguna, 'bank' => $bank, 'pembuangan' => $pembuangan, 'menungguPembayaran'=>$menungguPembayaran, 'riwayat'=>$riwayat]);
    }

    // HALAMAN DETAIL AJUKAN PENERIMAAN
    public function petugas_detail_ajukan_penerimaan($id_bank, $id_pggn, $pengajuan="true")
    {
        session_start();
        if($pengajuan=="true")
        {
            $harga = DB::select(DB::raw("
            SELECT tgl_buang, berat_organik, berat_organik*harga_organik as harga_organik, berat_anorganik, berat_anorganik*harga_anorganik as harga_anorganik
            FROM trans_byr_petugas t join users u
            on t.id_petugas = u.id
            where status_klaim = 'Belum' AND t.id_petugas = " .$_SESSION["id"]. " AND t.id_bank = " .$id_bank. " AND id_pengguna = ".$id_pggn."
            group by tgl_buang, berat_organik, berat_anorganik, harga_organik, harga_anorganik"));
            $total = DB::select(DB::raw("
            SELECT id_petugas, id_bank, id_pengguna, sum(berat_organik*harga_organik) as total_harga_organik, sum(berat_anorganik*harga_anorganik) as total_harga_anorganik,
            sum(berat_organik*harga_organik+berat_anorganik*harga_anorganik) as total_penerimaan
            FROM trans_byr_petugas t join users u
            on t.id_petugas = u.id
            where status_klaim = 'Belum' AND t.id_bank = " .$id_bank. " AND t.id_petugas =  ".$_SESSION["id"]. " AND id_pengguna = ".$id_pggn."
            group by id_petugas, id_bank, id_pengguna;"
            ))[0];
        }else{
            $harga = DB::select(DB::raw("
            SELECT tgl_buang, berat_organik, berat_organik*harga_organik as harga_organik, berat_anorganik, berat_anorganik*harga_anorganik as harga_anorganik
            FROM trans_byr_petugas t join users u
            on t.id_petugas = u.id
            where status_klaim = 'Menunggu' AND t.id_petugas = " .$_SESSION["id"]. " AND t.id_bank = " .$id_bank. " AND id_pengguna = ".$id_pggn."
            group by tgl_buang, berat_organik, berat_anorganik, harga_organik, harga_anorganik"));
            $total = DB::select(DB::raw("
            SELECT id_petugas, id_bank, id_pengguna, sum(berat_organik*harga_organik) as total_harga_organik, sum(berat_anorganik*harga_anorganik) as total_harga_anorganik,
            sum(berat_organik*harga_organik+berat_anorganik*harga_anorganik) as total_penerimaan
            FROM trans_byr_petugas t join users u
            on t.id_petugas = u.id
            where status_klaim = 'Menunggu' AND t.id_bank = " .$id_bank. " AND t.id_petugas =  ".$_SESSION["id"]. " AND id_pengguna = ".$id_pggn."
            group by id_petugas, id_bank, id_pengguna;"
            ))[0];
        }

        return view('petugas_detail_ajukan_penerimaan', ['key' => 'petugas_ajukan_penerimaan', 'harga' => $harga, 'total'=>$total, 'pengajuan' => $pengajuan]);
    }

    // KLAIM AJUKAN PENERIMAAN
    public function petugas_detail_ajukan_penerimaan_klaim($id_bank, $id_pggn)
    {
        session_start();
        trans_pp::create([
            'id_petugas' => (int)$_SESSION["id"],
            'id_bank' => $id_bank,
            'id_pengguna' => $id_pggn,
            'tgl_pengajuan' => date('Y/m/d H:i:s')
        ]);
        DB::select(DB::raw("
        UPDATE trans_byr_petugas
        SET status_klaim = 'Menunggu', updated_at = now()
        WHERE id_petugas=".$_SESSION["id"]." and id_pengguna=".$id_pggn." and id_bank=".$id_bank.";"
        ));
        return redirect ('petugas_ajukan_penerimaan');
    }

    // HALAMAN LUARAN
    public function petugas_luaran()
    {
        session_start();
        $petugas = User::find($_SESSION["id"]);

        $v_beratSampah=DB::select(DB::raw("
        SELECT id_petugas, sum(berat_organik) as berat_organik, sum(berat_anorganik) as berat_anorganik
        FROM trans_byr_petugas
        WHERE id_petugas = ".$_SESSION["id"]."
        GROUP BY id_petugas;"
        ));
        if($v_beratSampah!=null){
            $beratSampah = $v_beratSampah[0];
        }else{
            $beratSampah = null;
        }

        $jumlah_pengambilan=DB::select(DB::raw("
        SELECT month(tgl_buang) as bulan, count(created_at) as total
        FROM trans_byr_petugas
        WHERE id_petugas = ".$_SESSION["id"]."
        AND year(tgl_buang)= year(CURDATE())
        GROUP BY bulan
        "));

        $xAxist = [];
        $yAxist = [];
        foreach ($jumlah_pengambilan as $key => $value) {
            array_push($xAxist, $value->bulan);
        }
        foreach ($jumlah_pengambilan as $key => $value) {
            array_push($yAxist, $value->total);
        }

        $lokasi=DB::select(DB::raw("
        SELECT u.nama, u.latitude, u.longitude
        FROM trans_byr_petugas t join users u
        on t.id_pengguna = u.id
        WHERE id_petugas = ".$_SESSION["id"]."
        GROUP BY u.nama, u.latitude, u.longitude;"
        ));

        return view('petugas_luaran', ['key' => 'petugas_luaran', 'petugas' => $petugas, 'beratSampah' => $beratSampah, 'lokasi' => $lokasi, 'yAxist'=>$yAxist, 'xAxist'=>$xAxist]);
    }

}
