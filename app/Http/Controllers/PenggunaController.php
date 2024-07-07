<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\trans_psp;
use App\trans_pbs;
use App\bank_proses;
use Illuminate\Support\Facades\DB;
use PDF;

class PenggunaController extends Controller
{
    // HALAMAN HOME
    public function pengguna_home()
    {
        session_start();
        $pengguna = User::find($_SESSION["id"]);

        $v_psp_petugas = DB::select(DB::raw("
        SELECT * FROM
        trans_pengajuan_sampah t join
        users u
        on t.id_petugas = u.id
        where id_pengguna = " .$_SESSION["id"]."
        ORDER BY id_trans_psp DESC"));
        if($v_psp_petugas!=null)
        {
            $psp_petugas = $v_psp_petugas[0];
        }else
        {
            $psp_petugas = null;
        }

        $v_pbs = DB::select(DB::raw("
        SELECT * FROM
        trans_daftar_bank t join users u
        ON t.id_bank = u.id
        WHERE id_pengguna = " .$_SESSION["id"]."
        AND cast(tgl_trans_pbs as date) = cast(CURRENT_TIMESTAMP as date)"));
        if($v_pbs!=null)
        {
            $pbs = $v_pbs[0];
        }else
        {
            $pbs = null;
        }

        $v_beratSampah=DB::select(DB::raw("
        SELECT id_pengguna, sum(berat_organik) as berat_organik, sum(berat_anorganik) as berat_anorganik
        FROM trans_byr_petugas
        WHERE id_pengguna = ".$_SESSION["id"]."
        GROUP BY id_pengguna;"
        ));
        if($v_beratSampah!=null)
        {
            $beratSampah = $v_beratSampah[0];
        }else
        {
            $beratSampah = null;
        }

        return view ('pengguna_home', ['key' => 'pengguna_home', 'pengguna' => $pengguna, 'pbs' => $pbs, 'psp_petugas' => $psp_petugas, 'beratSampah' => $beratSampah]);
    }

    // HALAMAN DATA DIRI
    public function pengguna_data_diri()
    {
        session_start();
        $pengguna = User::find($_SESSION["id"]);
        return view ('pengguna_data_diri', ['key' => 'pengguna_data_diri', 'pengguna' => $pengguna]);
    }

    // HALAMAN UBAH DATA DIRI
    public function pengguna_ubah_data_diri()
    {
        session_start();
        $pengguna = User::find($_SESSION["id"]);
        return view ('pengguna_ubah_data_diri', ['key' => 'pengguna_data_diri', 'pengguna' => $pengguna]);
    }

    // SIMPAN UBAH DATA DIRI
    public function pengguna_ubah_data_diri_update(Request $request)
    {
        session_start();
        $pengguna = User::find($_SESSION["id"]);
        $pengguna->nama = $request->nama;
        $pengguna->alamat = $request->alamat;
        $pengguna->telp = $request->telp;
        $pengguna->latitude = $request->latitude;
        $pengguna->longitude = $request->longitude;
        $pengguna->save();
        return redirect ('pengguna_data_diri')->with('alert', 'Data telah berhasil diubah!');
    }

    // HALAMAN PILIH PETUGAS
    public function pengguna_pilih_petugas()
    {
        session_start();
        $pengguna = User::find($_SESSION["id"]);
        $petugas = User::where('role', 'Petugas')->get();
        $pengajuan = trans_psp::where('id_pengguna', $_SESSION["id"])->get();
        return view ('pengguna_pilih_petugas', ['key' => 'pengguna_pilih_petugas', 'pengguna' => $pengguna, 'petugas' => $petugas, 'pengajuan'=>$pengajuan]);
    }

    // PILIH PETUGAS
    public function pengguna_pilih_petugas_insert($id_petugas)
    {
        session_start();
        $petugas = User::find($id_petugas);
        trans_psp::create([
            'id_pengguna' => (int)$_SESSION["id"],
            'id_petugas' => (int)$id_petugas,
            'status_terima' => 'Menunggu',
            'iuran' => (int)$petugas->tarif_petugas
        ]);
        return redirect('pengguna_pilih_petugas')->with('alert', 'Data telah berhasil ditambahkan!');
    }

    // HALAMAN PILIH BANK
    public function pengguna_pilih_bank()
    {
        session_start();
        $pengguna = User::find($_SESSION["id"]);
        $bank = User::where('role', 'Bank')->get();
        $pengajuan = trans_pbs::where('id_pengguna', $_SESSION["id"])->get();
        return view ('pengguna_pilih_bank', ['key' => 'pengguna_pilih_bank', 'pengguna' => $pengguna, 'bank' => $bank, 'pengajuan'=>$pengajuan]);
    }

    // PILIH BANK
    public function pengguna_pilih_bank_insert($id_bank)
    {
        session_start();
        $bank = User::find($id_bank);
        trans_pbs::create([
            'id_pengguna' => (int)$_SESSION["id"],
            'id_bank' => (int)$id_bank,
            'status_daftar' => 'Menunggu',
            'iuran' => (int)$bank->tarif_petugas
        ]);
        return redirect('pengguna_pilih_bank')->with('alert', 'Data telah berhasil ditambahkan!');
    }

    // BAYAR PETUGAS
    public function pengguna_bayar($id_trans_psp, Request $request){
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = time()."_".$file->getClientOriginalName();
        $folder_upload = 'pengguna_bukti_bayar';
        $file->move($folder_upload, $nama_file);

        $upload_bukti = trans_psp::find($id_trans_psp);
        $upload_bukti->bukti_pembayaran = $nama_file;
        $upload_bukti->save();

        return redirect('pengguna_home')->with('alert', 'Bukti pembayaran berhasil diupload!');
    }

    // HALAMAN RIWAYAT TRANSAKSI
    public function pengguna_riwayat_transaksi(Request $request)
    {
        session_start();
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        if($request->tgl_awal == "" && $request->tgl_akhir == "")
        {
            $psp = DB::select(DB::raw("
            SELECT * FROM
            trans_pengajuan_sampah t join
            users u
            on t.id_petugas = u.id
            WHERE id_pengguna = ".$_SESSION["id"]."
            AND tgl_pembayaran_psp IS NOT NULL"));

            $pembuangan = DB::select(DB::raw("
            SELECT * FROM
            trans_byr_petugas t join
            users u
            on t.id_bank = u.id
            WHERE id_pengguna = ".$_SESSION["id"].""));;
            return view ('pengguna_riwayat_transaksi', ['key' => 'pengguna_riwayat_transaksi', 'psp'=>$psp, 'pembuangan'=>$pembuangan, 'tgl_awal'=>$tgl_awal, 'tgl_akhir'=>$tgl_akhir]);
        }
        else if($request->tgl_awal <= $request->tgl_akhir )
        {
            $psp = DB::select(DB::raw("
            SELECT * FROM
            trans_pengajuan_sampah t join
            users u
            on t.id_petugas = u.id
            WHERE id_pengguna = ".$_SESSION["id"]."
            AND tgl_pembayaran_psp IS NOT NULL AND DATE(tgl_pembayaran_psp) BETWEEN STR_TO_DATE('$tgl_awal', '%Y-%m-%d') AND STR_TO_DATE('$tgl_akhir', '%Y-%m-%d')"));

            $pembuangan = DB::select(DB::raw("
            SELECT * FROM
            trans_byr_petugas t join
            users u
            on t.id_bank = u.id
            WHERE id_pengguna = ".$_SESSION["id"]."
            AND DATE(t.created_at) BETWEEN STR_TO_DATE('$tgl_awal', '%Y-%m-%d') AND STR_TO_DATE('$tgl_akhir', '%Y-%m-%d')"));
            return view ('pengguna_riwayat_transaksi', ['key' => 'pengguna_riwayat_transaksi', 'psp'=>$psp, 'pembuangan'=>$pembuangan, 'tgl_awal'=>$tgl_awal, 'tgl_akhir'=>$tgl_akhir]);
        }
        else
        {
            return redirect('pengguna_riwayat_transaksi')->with('alert', 'Tanggal awal harus lebih kecil atau sama dengan tanggal akhir!');
        }
    }

    // CETAK 1 RIWAYAT TRANSAKSI
    public function pengguna_riwayat_transaksi_cetak($id_trans_psp)
    {
        session_start();
        $psp = DB::select(DB::raw("
        SELECT
        id_trans_psp,
        id_pengguna,
        id_petugas,
        tgl_trans_psp,
        tgl_validasi_psp,
        bukti_pembayaran,
        date(tgl_pembayaran_psp) as tgl_pembayaran_psp,
        iuran,
        tgl_berlaku_psp,
        status_terima,
        u.id as id_petugas,
        u.nama as nama_petugas,
        u.email as email_petugas,
        u.alamat as alamat_petugas,
        u.telp as telp_petugas,
        us.id as id_pengguna,
        us.nama as nama_pengguna,
        us.email as email_pengguna,
        us.alamat as alamat_pengguna,
        us.telp as telp_pengguna
        FROM
        trans_pengajuan_sampah t left join
        users u
        on t.id_petugas = u.id left join
        users us
        on t.id_pengguna = us.id
        WHERE id_pengguna = ".$_SESSION["id"]."
        AND tgl_pembayaran_psp IS NOT NULL
        AND id_trans_psp =".$id_trans_psp))[0];
        $pdf = PDF::loadview('pengguna_riwayat_transaksi_detail',['key' => 'pengguna_riwayat_transaksi','psp'=>$psp]);
        return $pdf->download('Bukti-pembayaran-psp.pdf');
    }

    //CETAK SEMUA RIWAYAT TRANSAKSI
    public function pengguna_riwayat_transaksi_filter_cetak($tgl_awal="", $tgl_akhir="")
    {
        session_start();
        if($tgl_awal == "" && $tgl_akhir == "")
        {
            $psp = DB::select(DB::raw("
            SELECT * FROM
            trans_pengajuan_sampah t join
            users u
            on t.id_petugas = u.id
            WHERE id_pengguna = ".$_SESSION["id"]."
            AND tgl_pembayaran_psp IS NOT NULL"));

            $pembuangan = DB::select(DB::raw("
            SELECT * FROM
            trans_byr_petugas t join
            users u
            on t.id_bank = u.id
            WHERE id_pengguna = ".$_SESSION["id"].""));
        }
        else
        {
            $psp = DB::select(DB::raw("
            SELECT * FROM
            trans_pengajuan_sampah t join
            users u
            on t.id_petugas = u.id
            WHERE id_pengguna = ".$_SESSION["id"]."
            AND tgl_pembayaran_psp IS NOT NULL AND DATE(tgl_pembayaran_psp) BETWEEN STR_TO_DATE('$tgl_awal', '%Y-%m-%d') AND STR_TO_DATE('$tgl_akhir', '%Y-%m-%d')"));

            $pembuangan = DB::select(DB::raw("
            SELECT * FROM
            trans_byr_petugas t join
            users u
            on t.id_bank = u.id
            WHERE id_pengguna = ".$_SESSION["id"]."
            AND DATE(t.created_at) BETWEEN STR_TO_DATE('$tgl_awal', '%Y-%m-%d') AND STR_TO_DATE('$tgl_akhir', '%Y-%m-%d')"));
        }
        $pdf = PDF::loadview('pengguna_riwayat_transaksi_filter_cetak', ['key' => 'pengguna_riwayat_transaksi', 'psp'=>$psp, 'pembuangan'=>$pembuangan]);
        return $pdf->download('Riwayat_transaksi_petugas.pdf');
    }
}
