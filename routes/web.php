<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//GUEST
Route::get('/', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('/daftar', 'AuthController@daftar');
Route::post('/daftar/simpan', 'AuthController@simpan');
Route::post('/cekLogin', 'AuthController@cekLogin');


//PENGGUNA
    //HOME
    Route::get('/pengguna_home', 'PenggunaController@pengguna_home');

    //DATA DIRI
    Route::get('/pengguna_data_diri', 'PenggunaController@pengguna_data_diri');
    Route::get('/pengguna_ubah_data_diri', 'PenggunaController@pengguna_ubah_data_diri');
    Route::put('/pengguna_ubah_data_diri/update', 'PenggunaController@pengguna_ubah_data_diri_update');

    //PILIH PETUGAS
    Route::get('/pengguna_pilih_petugas', 'PenggunaController@pengguna_pilih_petugas');
    Route::get('/pengguna_pilih_petugas/insert/{id_petugas}', 'PenggunaController@pengguna_pilih_petugas_insert');

    //PILIH BANK
    Route::get('/pengguna_pilih_bank', 'PenggunaController@pengguna_pilih_bank');
    Route::get('/pengguna_pilih_bank/insert/{id_bank}', 'PenggunaController@pengguna_pilih_bank_insert');

    //TRANSAKSI
    Route::get('/pengguna/bayar', 'PenggunaController@pengguna_bayar');
    Route::get('/pengguna_riwayat_transaksi', 'PenggunaController@pengguna_riwayat_transaksi');
    Route::get('/pengguna_riwayat_transaksi/cetak/{id_trans_psp}', 'PenggunaController@pengguna_riwayat_transaksi_cetak');
    Route::get('/pengguna_riwayat_transaksi_filter_cetak/{tgl_awal?}/{tgl_akhir?}', 'PenggunaController@pengguna_riwayat_transaksi_filter_cetak');
    Route::put('/pengguna/bayar/{id_trans_psp}', 'PenggunaController@pengguna_bayar');


//PETUGAS
    //HOME
    Route::get('/petugas_home', 'PetugasController@petugas_home');
    Route::get('/petugas_home/terima_psp/{id_trans_psp}', 'PetugasController@petugas_home_terima_psp');
    Route::get('/petugas_home/pembayaran_psp/{id_trans_psp}', 'PetugasController@petugas_home_pembayaran_psp');
    Route::get('/petugas_home/tolak_psp/{id_trans_psp}', 'PetugasController@petugas_home_tolak_psp');

    //DATA DIRI
    Route::get('/petugas_data_diri', 'PetugasController@petugas_data_diri');
    Route::get('/petugas_ubah_data_diri', 'PetugasController@petugas_ubah_data_diri');
    Route::put('/petugas_ubah_data_diri/update', 'PetugasController@petugas_ubah_data_diri_update');

    //TITIK JEMPUT
    Route::get('/petugas_titik_jemput_langganan', 'PetugasController@petugas_titik_jemput_langganan');
    Route::get('/petugas_titik_jemput_tidak_langganan', 'PetugasController@petugas_titik_jemput_tidak_langganan');

    //DAFTAR BANK
    Route::get('/petugas_daftar_bank', 'PetugasController@petugas_daftar_bank');
    Route::get('/petugas_daftar_bank/insert/{id_bank}', 'PetugasController@petugas_daftar_bank_insert');

    //AJUKAN PENERIMAAN
    Route::get('/petugas_ajukan_penerimaan', 'PetugasController@petugas_ajukan_penerimaan');
    Route::get('/petugas_detail_ajukan_penerimaan/{id_bank}/{id_pggn}/{pengajuan?}', 'PetugasController@petugas_detail_ajukan_penerimaan');
    Route::get('/petugas_detail_ajukan_penerimaan_klaim/{id_bank}/{id_pggn}', 'PetugasController@petugas_detail_ajukan_penerimaan_klaim');

    //LUARAN
    Route::get('/petugas_luaran', 'PetugasController@petugas_luaran');


//BANK
    //HOME
    Route::get('/bank_home', 'BankController@bank_home');

    //DATA DIRI
    Route::get('/bank_data_diri', 'BankController@bank_data_diri');
    Route::get('/bank_ubah_data_diri', 'BankController@bank_ubah_data_diri');
    Route::put('/bank_ubah_data_diri/update/{id}', 'BankController@bank_ubah_data_diri_update');

    //VALIDASI PENGAJUAN PEMBUANGAN
    Route::get('/bank_validasi_pengajuan_pembuangan', 'BankController@bank_validasi_pengajuan_pembuangan');
    Route::get('/bank_validasi_pengajuan_pembuangan/terima_pbs/{id_trans_pbs}', 'BankController@bank_validasi_pengajuan_pembuangan_terima_pbs');
    Route::get('/bank_validasi_pengajuan_pembuangan/tolak_pbs/{id_trans_pbs}', 'BankController@bank_validasi_pengajuan_pembuangan_tolak_pbs');

    //VALIDASI PENGAJUAN PENERIMAAN
    Route::get('/bank_pengajuan_penerimaan', 'BankController@bank_pengajuan_penerimaan');
    Route::get('/bank_detail_pengajuan_penerimaan/{id_petugas}/{id_pengguna}', 'BankController@bank_detail_pengajuan_penerimaan');
    Route::get('/bank_detail_pengajuan_penerimaan/bayar/{id_petugas}/{id_pengguna}', 'BankController@bank_detail_pengajuan_penerimaan_bayar');

    //PROSES SAMPAH
    Route::get('/bank_proses_sampah', 'BankController@bank_proses_sampah');
    Route::post('/bank_proses_sampah/insert', 'BankController@bank_proses_sampah_insert');

    //LUARAN
    Route::get('/bank_luaran', 'BankController@bank_luaran');
