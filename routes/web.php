<?php

use App\Http\Controllers\Kepegawaian\AbsensiController;
use App\Http\Controllers\Kepegawaian\CapaianSkpController;
use App\Http\Controllers\Kepegawaian\DashboardController;
use App\Http\Controllers\Kepegawaian\IntegritasController;
use App\Http\Controllers\Kepegawaian\JabatanController;
use App\Http\Controllers\Kepegawaian\PeriodeController;
use App\Http\Controllers\Kepegawaian\TendikController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'  => 'kepegawaian/'],function(){
    Route::get('/',[DashboardController::class, 'dashboard'])->name('kepegawaian.dashboard');
});

Route::group(['prefix' => 'kepegawaian/periode'], function () {
    Route::get('/',[PeriodeController::class, 'index'])->name('kepegawaian.periode');
    Route::post('/',[PeriodeController::class, 'post'])->name('kepegawaian.periode.add');
    Route::patch('/aktifkan_status/{id}',[PeriodeController::class, 'aktifkanStatus'])->name('kepegawaian.periode.aktifkan_status');
    Route::patch('/non_aktifkan_status/{id}',[PeriodeController::class, 'nonAktifkanStatus'])->name('kepegawaian.periode.non_aktifkan_status');
    Route::delete('/',[PeriodeController::class, 'delete'])->name('kepegawaian.periode.delete');
});

Route::group(['prefix'  => 'kepegawaian/manajemen_jabatan'],function(){
    Route::get('/',[JabatanController::class, 'index'])->name('kepegawaian.jabatan');
    Route::post('/',[JabatanController::class, 'post'])->name('kepegawaian.jabatan.post');
    Route::get('/{id}/edit',[JabatanController::class, 'edit'])->name('kepegawaian.jabatan.edit');
    Route::patch('/',[JabatanController::class, 'update'])->name('kepegawaian.jabatan.update');
    Route::delete('/',[JabatanController::class, 'delete'])->name('kepegawaian.jabatan.delete');
});

Route::group(['prefix'  => 'kepegawaian/manajemen_data_tendik'],function(){
    Route::get('/',[TendikController::class, 'index'])->name('kepegawaian.tendik');
    Route::post('/',[TendikController::class, 'post'])->name('kepegawaian.tendik.post');
    Route::get('/{id}/edit',[TendikController::class, 'edit'])->name('kepegawaian.tendik.edit');
    Route::patch('/',[TendikController::class, 'update'])->name('kepegawaian.tendik.update');
    Route::delete('/',[TendikController::class, 'delete'])->name('kepegawaian.tendik.delete');
    Route::post('/generate_password',[TendikController::class, 'generatePassword'])->name('kepegawaian.tendik.generate_password');
    Route::patch('/ubah_password',[TendikController::class, 'ubahPassword'])->name('kepegawaian.tendik.ubah_password');
});

Route::group(['prefix' => 'kepegawaian/manajemen_rubrik_absensi'], function () {
    Route::get('/{periode_id}',[AbsensiController::class, 'index'])->name('kepegawaian.r_absensi');
    Route::get('/generate_tendik/{periode_id}',[AbsensiController::class, 'generateTendik'])->name('kepegawaian.r_absensi.generate_tendik');
    Route::patch('/{id}/update_potongan/{periode_id}',[AbsensiController::class, 'updatePotongan'])->name('kepegawaian.r_absensi.update_potongan');
    Route::get('/potongan_bulan_1/{periode_id}',[AbsensiController::class, 'potonganBulanSatu'])->name('kepegawaian.r_absensi.potongan_bulan_1');
    Route::get('/generate_potongan_bulan_satu/{periode_id}',[AbsensiController::class, 'generatePotonganBulanSatu'])->name('kepegawaian.r_absensi.generate_potongan_bulan_satu');
    Route::get('/potongan_bulan_2/{periode_id}',[AbsensiController::class, 'potonganBulanDua'])->name('kepegawaian.r_absensi.potongan_bulan_2');
    Route::get('/generate_potongan_bulan_dua/{periode_id}',[AbsensiController::class, 'generatePotonganBulanDua'])->name('kepegawaian.r_absensi.generate_potongan_bulan_dua');
    Route::get('/potongan_bulan_3/{periode_id}',[AbsensiController::class, 'potonganBulanTiga'])->name('kepegawaian.r_absensi.potongan_bulan_3');
    Route::get('/generate_potongan_bulan_tiga/{periode_id}',[AbsensiController::class, 'generatePotonganBulanTiga'])->name('kepegawaian.r_absensi.generate_potongan_bulan_tiga');
    Route::get('/potongan_bulan_4/{periode_id}',[AbsensiController::class, 'potonganBulanEmpat'])->name('kepegawaian.r_absensi.potongan_bulan_4');
    Route::get('/generate_potongan_bulan_empat/{periode_id}',[AbsensiController::class, 'generatePotonganBulanEmpat'])->name('kepegawaian.r_absensi.generate_potongan_bulan_empat');
    Route::get('/potongan_bulan_5/{periode_id}',[AbsensiController::class, 'potonganBulanLima'])->name('kepegawaian.r_absensi.potongan_bulan_5');
    Route::get('/generate_potongan_bulan_lima/{periode_id}',[AbsensiController::class, 'generatePotonganBulanLima'])->name('kepegawaian.r_absensi.generate_potongan_bulan_lima');
    Route::get('/potongan_bulan_6/{periode_id}',[AbsensiController::class, 'potonganBulanEnam'])->name('kepegawaian.r_absensi.potongan_bulan_6');
    Route::get('/generate_potongan_bulan_enam/{periode_id}',[AbsensiController::class, 'generatePotonganBulanEnam'])->name('kepegawaian.r_absensi.generate_potongan_bulan_enam');
});

Route::group(['prefix' => 'kepegawaian/manajemen_rubrik_capaian_skp'], function () {
    Route::get('/',[CapaianSkpController::class, 'index'])->name('kepegawaian.r_skp');
    Route::patch('/verifikasi',[CapaianSkpController::class, 'verifikasi'])->name('kepegawaian.r_skp.verifikasi');
    Route::get('/{id}/download_file_skp',[CapaianSkpController::class, 'downloadSkp'])->name('kepegawaian.r_skp.download_skp');
    Route::get('/generate_potongan',[CapaianSkpController::class, 'generate'])->name('kepegawaian.r_skp.generate');
    Route::get('/{periode_id}/generate_submit',[CapaianSkpController::class, 'generateSubmit'])->name('kepegawaian.r_skp.generate_submit');
    Route::get('/generate_nominal',[CapaianSkpController::class, 'generateNominal'])->name('kepegawaian.r_skp.generate_nominal');
    Route::get('/{periode_id}/generate_nominal_submit',[CapaianSkpController::class, 'generateNominalSubmit'])->name('kepegawaian.r_skp.generate_nominal_submit');
});

Route::group(['prefix' => 'kepegawaian/manajemen_rubrik_integritas'], function () {
    Route::get('/data_tendik/{periode_id}',[IntegritasController::class, 'index'])->name('kepegawaian.r_integritas');
    Route::get('/generate_tendik/{periode_id}',[IntegritasController::class, 'generateTendik'])->name('kepegawaian.r_integritas.generate_tendik');
    Route::get('/{periode_id}/remun_30',[IntegritasController::class, 'remunTigaPuluh'])->name('kepegawaian.r_integritas.remun_30');
    Route::get('/{periode_id}/generate_remun_30',[IntegritasController::class, 'generateRemunTigaPuluh'])->name('kepegawaian.r_integritas.generate_remun_30');
    Route::get('/{periode_id}/remun_70',[IntegritasController::class, 'remunTujuhPuluh'])->name('kepegawaian.r_integritas.remun_70');
    Route::get('/{periode_id}/generate_remun_70',[IntegritasController::class, 'generateRemunTujuhPuluh'])->name('kepegawaian.r_integritas.generate_remun_70');
    Route::get('/{periode_id}/total_remun',[IntegritasController::class, 'totalRemun'])->name('kepegawaian.r_integritas.total_remun');
    Route::get('/{periode_id}/generate_total_remun',[IntegritasController::class, 'generateTotalRemun'])->name('kepegawaian.r_integritas.generate_total_remun');
    Route::get('/{periode_id}/pajak_pph',[IntegritasController::class, 'pajakPph'])->name('kepegawaian.r_integritas.pajak_pph');
    Route::get('/{periode_id}/generate_pph',[IntegritasController::class, 'generatePph'])->name('kepegawaian.r_integritas.generate_pph');
    Route::get('/{periode_id}/lhkpn_lhkasn',[IntegritasController::class, 'lhkpnLhkasn'])->name('kepegawaian.r_integritas.lhkpn_lhkasn');
    Route::patch('/{id}/update_data_lhkpn_lhkasn',[IntegritasController::class, 'updateDataLhkpnLhkasn'])->name('kepegawaian.r_integritas.update_data_lhkpn_lhkasn');
    Route::get('/{periode_id}/generate_lhkpn_lhkasn',[IntegritasController::class, 'generateLhkpnLhkasn'])->name('kepegawaian.r_integritas.generate_lhkpn_lhkasn');
    Route::get('/{periode_id}/sanksi_disiplin',[IntegritasController::class, 'sanksiDisiplin'])->name('kepegawaian.r_integritas.sanksi_disiplin');
    Route::patch('/{id}/update_data_sanksi_disiplin',[IntegritasController::class, 'updateDataSanksiDisiplin'])->name('kepegawaian.r_integritas.update_data_sanksi_disiplin');
    Route::get('/{periode_id}/generate_sanksi_disiplin',[IntegritasController::class, 'generateSanksiDisiplin'])->name('kepegawaian.r_integritas.generate_sanksi_disiplin');
    Route::get('/{periode_id}/integritas_satu_bulan',[IntegritasController::class, 'integritasSatuBulan'])->name('kepegawaian.r_integritas.integritas_satu_bulan');
    Route::get('/{periode_id}/generate_integritas_satu_bulan',[IntegritasController::class, 'generateIntegritasSatuBulan'])->name('kepegawaian.r_integritas.generate_integritas_satu_bulan');
    Route::get('/{periode_id}/total_integritas',[IntegritasController::class, 'totalIntegritas'])->name('kepegawaian.r_integritas.total_integritas');
    Route::get('/{periode_id}/generate_total_integritas',[IntegritasController::class, 'generateTotalIntegritas'])->name('kepegawaian.r_integritas.generate_total_integritas');
});


Route::group(['prefix' => 'kepegawaian/generate_remunerasi'], function () {
    Route::get('/','kepegawaian\GenerateRemunerasiController@index')->name('kepegawaian.remunerasi');
    Route::get('/{periode_id}/generate_data_tendik','kepegawaian\GenerateRemunerasiController@generateDataTendik')->name('kepegawaian.remunerasi.generate_data_tendik');
    Route::get('/{periode_id}/total_remun','kepegawaian\GenerateRemunerasiController@totalRemun')->name('kepegawaian.remunerasi.total_remun');
    Route::get('/{periode_id}/generate_total_remun','kepegawaian\GenerateRemunerasiController@generateTotalRemun')->name('kepegawaian.remunerasi.generate_total_remun');
    Route::get('/{periode_id}/integritas','kepegawaian\GenerateRemunerasiController@integritas')->name('kepegawaian.remunerasi.integritas');
    Route::get('/{periode_id}/generate_integritas','kepegawaian\GenerateRemunerasiController@generateIntegritas')->name('kepegawaian.remunerasi.generate_integritas');
    Route::get('/{periode_id}/skp','kepegawaian\GenerateRemunerasiController@skp')->name('kepegawaian.remunerasi.skp');
    Route::get('/{periode_id}/generate_skp','kepegawaian\GenerateRemunerasiController@generateSkp')->name('kepegawaian.remunerasi.generate_skp');
    Route::get('/{periode_id}/persentase_absen','kepegawaian\GenerateRemunerasiController@persentaseAbsen')->name('kepegawaian.remunerasi.persentase_absen');
    Route::get('/{periode_id}/generate_persentase_absen','kepegawaian\GenerateRemunerasiController@generatePersentaseAbsen')->name('kepegawaian.remunerasi.generate_persentase_absen');
    
});

Route::group(['prefix'  => 'kepegawaian/manajemen_data_kepegawaianistrator'],function(){
    Route::get('/','kepegawaian\kepegawaianController@index')->name('kepegawaian.kepegawaian');
    Route::post('/','kepegawaian\kepegawaianController@post')->name('kepegawaian.kepegawaian.add');
    Route::patch('/ubah_password','kepegawaian\kepegawaianController@ubahPassword')->name('kepegawaian.kepegawaian.ubah_password');
    Route::patch('/aktifkan_status/{id}','kepegawaian\kepegawaianController@aktifkanStatus')->name('kepegawaian.kepegawaian.aktifkan_status');
    Route::patch('/non_aktifkan_status/{id}','kepegawaian\kepegawaianController@nonAktifkanStatus')->name('kepegawaian.kepegawaian.non_aktifkan_status');
    Route::get('/{id}/edit','kepegawaian\kepegawaianController@edit')->name('kepegawaian.kepegawaian.edit');
    Route::patch('/','kepegawaian\kepegawaianController@update')->name('kepegawaian.kepegawaian.update');
    Route::delete('/','kepegawaian\kepegawaianController@delete')->name('kepegawaian.kepegawaian.delete');
});