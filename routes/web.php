<?php

use App\Http\Controllers\Kepegawaian\AbsensiController;


use App\Http\Controllers\Administrator\AdministratorDashboardController;
use App\Http\Controllers\Administrator\AdministratorPeriodeController;
use App\Http\Controllers\Administrator\AdministratorPeriodeInsentifController;
use App\Http\Controllers\Administrator\AdministratorUserController;
use App\Http\Controllers\Administrator\AdministratorTendikController;

use App\Http\Controllers\Administrator\AdministratorUnitController;
use App\Http\Controllers\Administrator\AdministratorRubrikController;
use App\Http\Controllers\Administrator\AdministratorDetailIsianRubrikController;
use App\Http\Controllers\Administrator\AdministratorIsianRubrikController;
use App\Http\Controllers\Administrator\AdministratorJabatanController;
use App\Http\Controllers\Administrator\AdministratorPenggunaRubrikController;
use App\Http\Controllers\AuthTendik\LoginTendikController;
use App\Http\Controllers\Administrator\AdministratorRekapitulasiController;
use App\Http\Controllers\Administrator\AdministratorDataInsentifController;
use App\Http\Controllers\Kepegawaian\CapaianSkpController;
use App\Http\Controllers\Kepegawaian\DashboardController;
use App\Http\Controllers\Kepegawaian\IntegritasController;
use App\Http\Controllers\Kepegawaian\JabatanController;
use App\Http\Controllers\Kepegawaian\PeriodeController;
use App\Http\Controllers\Kepegawaian\RekapitulasiController;
use App\Http\Controllers\Kepegawaian\TendikController;
use App\Http\Controllers\Operator\DataInsentifController;
use App\Http\Controllers\Operator\DashboardOperatorController;
use App\Http\Controllers\Operator\DetailIsianController;
use App\Http\Controllers\Operator\DetailRubrikController;
use App\Http\Controllers\Operator\LaporanController;
use App\Http\Controllers\Tendik\TendikCapaianSkpController;
use App\Http\Controllers\Tendik\TendikDashboardController;
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
    if (Auth::check() && Auth::user()->role == "administrator") {
        return redirect()->route('administrator.dashboard');
    }elseif (Auth::check() && Auth::user()->role == "pimpinan") {
        return redirect()->route('pimpinan.dashboard');
    }elseif (Auth::check() && Auth::user()->role == "kepegawaian") {
        return redirect()->route('kepegawaian.dashboard');
    }
    elseif (Auth::check() && Auth::user()->role == "operator") {
        return redirect()->route('operator.dashboard');
    }
    else{
        return redirect()->route('login');
    }
});

Route::group(['prefix'  => ''],function(){
    Route::get('/tendik',function(){
        if (Auth::guard('tendik')->check()) {
            return redirect()->route('tendik.dashboard');
        }
        else{
            return redirect()->route('tendik.login');
        }
    });
    Route::get('/tendik/login',[LoginTendikController::class, 'showLoginForm'])->name('tendik.login');
    Route::post('/tendik/login',[LoginTendikController::class, 'login'])->name('tendik.login.submit');
    Route::get('/tendik/dashboard',[TendikDashboardController::class, 'index'])->name('tendik.dashboard');
    Route::patch('/tendik/ubah_data',[TendikDashboardController::class, 'ubahData'])->name('tendik.ubah_data');
    Route::patch('/tendik',[TendikDashboardController::class, 'ubahPassword'])->name('tendik.ubah_password');
    Route::get('/logout',[LoginTendikController::class, 'logoutTendik'])->name('tendik.logout');
});

Route::group(['prefix' => 'tendik/manajemen_rubrik_capaian_skp'], function () {
    Route::get('/',[TendikCapaianSkpController::class, 'index'])->name('tendik.r_skp');
    Route::patch('input/{id}',[TendikCapaianSkpController::class, 'post'])->name('tendik.r_skp.post');
    Route::get('/{id}/edit',[TendikCapaianSkpController::class, 'edit'])->name('tendik.r_skp.edit');
    Route::patch('/',[TendikCapaianSkpController::class, 'update'])->name('tendik.r_skp.update');
    Route::delete('/',[TendikCapaianSkpController::class, 'delete'])->name('tendik.r_skp.delete');
    Route::get('/{id}/kirimkan_skp',[TendikCapaianSkpController::class, 'kirimkanSkp'])->name('tendik.r_skp.kirimkan');
    Route::get('/{id}/download_path',[TendikCapaianSkpController::class, 'downloadSkp'])->name('tendik.r_skp.download_skp');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix'  => 'administrator/'],function(){
    Route::get('/',[AdministratorDashboardController::class, 'dashboard'])->name('administrator.dashboard');
  
});

Route::group(['prefix' => 'administrator/periode'], function () {
    Route::get('/',[AdministratorPeriodeController::class, 'index'])->name('administrator.periode');
    Route::post('/',[AdministratorPeriodeController::class, 'post'])->name('administrator.periode.post');
    Route::get('/{id}/edit',[AdministratorPeriodeController::class, 'edit'])->name('administrator.periode.edit');
    Route::patch('/',[AdministratorPeriodeController::class, 'update'])->name('administrator.periode.update');
    Route::patch('/aktifkan_status/{id}',[AdministratorPeriodeController::class, 'aktifkanStatus'])->name('administrator.periode.aktifkan_status');
    Route::patch('/non_aktifkan_status/{id}',[AdministratorPeriodeController::class, 'nonAktifkanStatus'])->name('administrator.periode.non_aktifkan_status');
    Route::delete('/',[AdministratorPeriodeController::class, 'delete'])->name('administrator.periode.delete');
});

Route::group(['prefix' => 'administrator/periodeinsentif'], function () {
    Route::get('/',[AdministratorPeriodeInsentifController::class, 'index'])->name('administrator.periodeinsentif');
    Route::post('/',[AdministratorPeriodeInsentifController::class, 'post'])->name('administrator.periodeinsentif.post');
    Route::get('/{id}/edit',[AdministratorPeriodeInsentifController::class, 'edit'])->name('administrator.periodeinsentif.edit');
    Route::patch('/',[AdministratorPeriodeInsentifController::class, 'update'])->name('administrator.periodeinsentif.update');
    Route::patch('/aktifkan_status/{id}',[AdministratorPeriodeInsentifController::class, 'aktifkanStatus'])->name('administrator.periodeinsentif.aktifkan_status');
    Route::patch('/non_aktifkan_status/{id}',[AdministratorPeriodeInsentifController::class, 'nonAktifkanStatus'])->name('administrator.periodeinsentif.non_aktifkan_status');
    Route::delete('/',[AdministratorPeriodeInsentifController::class, 'delete'])->name('administrator.periodeinsentif.delete');
});
Route::group(['prefix' => 'administrator/user'], function () {
    Route::get('/',[AdministratorUserController::class, 'index'])->name('administrator.user');
    Route::post('/',[AdministratorUserController::class, 'post'])->name('administrator.user.post');
    Route::get('/{id}/edit',[AdministratorUserController::class, 'edit'])->name('administrator.user.edit');
    Route::patch('/',[AdministratorUserController::class, 'update'])->name('administrator.user.update');
    Route::delete('/',[AdministratorUserController::class, 'delete'])->name('administrator.user.delete');
    Route::patch('/aktifkan_status/{id}',[AdministratorUserController::class, 'aktifkanStatus'])->name('administrator.user.aktifkan_status');
    Route::patch('/non_aktifkan_status/{id}',[AdministratorUserController::class, 'nonAktifkanStatus'])->name('administrator.user.non_aktifkan_status');
    Route::post('/generate_password',[AdministratorUserController::class, 'generatePassword'])->name('administrator.user.generate_password');
    Route::patch('/ubah_password',[AdministratorUserController::class, 'ubahPassword'])->name('administrator.user.ubah_password');
});
Route::group(['prefix' => 'administrator/tendik'], function () {
    Route::get('/',[AdministratorTendikController::class, 'index'])->name('administrator.tendik');
    Route::post('/',[AdministratorTendikController::class, 'post'])->name('administrator.tendik.post');
    Route::get('/{id}/edit',[AdministratorTendikController::class, 'edit'])->name('administrator.tendik.edit');
    Route::patch('/',[AdministratorTendikController::class, 'update'])->name('administrator.tendik.update');
    Route::delete('/',[AdministratorTendikController::class, 'delete'])->name('administrator.tendik.delete');
    Route::post('/generate_password',[AdministratorTendikController::class, 'generatePassword'])->name('administrator.tendik.generate_password');
    Route::patch('/ubah_password',[AdministratorTendikController::class, 'ubahPassword'])->name('administrator.tendik.ubah_password');
});

Route::group(['prefix' => 'administrator/unit'], function () {
    Route::get('/',[AdministratorUnitController::class, 'index'])->name('administrator.unit');
    Route::post('/',[AdministratorUnitController::class, 'post'])->name('administrator.unit.post');
    Route::get('/{id}/edit',[AdministratorUnitController::class, 'edit'])->name('administrator.unit.edit');
    Route::patch('/',[AdministratorUnitController::class, 'update'])->name('administrator.unit.update');
    Route::delete('/',[AdministratorUnitController::class, 'delete'])->name('administrator.unit.delete');
});

Route::group(['prefix' => 'administrator/rubrik'], function () {
    Route::get('/',[AdministratorRubrikController::class, 'index'])->name('administrator.rubrik');
    Route::post('/',[AdministratorRubrikController::class, 'post'])->name('administrator.rubrik.post');
    Route::get('/{id}/edit',[AdministratorRubrikController::class, 'edit'])->name('administrator.rubrik.edit');
    Route::patch('/',[AdministratorRubrikController::class, 'update'])->name('administrator.rubrik.update');
    Route::delete('/',[AdministratorRubrikController::class, 'delete'])->name('administrator.rubrik.delete');
});

Route::group(['prefix' => 'administrator/pengguna_rubrik'], function () {
    Route::get('/',[AdministratorPenggunaRubrikController::class, 'index'])->name('administrator.pengguna_rubrik');
    Route::post('/',[AdministratorPenggunaRubrikController::class, 'post'])->name('administrator.pengguna_rubrik.post');
    Route::get('/{id}/edit',[AdministratorPenggunaRubrikController::class, 'edit'])->name('administrator.pengguna_rubrik.edit');
    Route::patch('/',[AdministratorPenggunaRubrikController::class, 'update'])->name('administrator.pengguna_rubrik.update');
    Route::delete('/',[AdministratorPenggunaRubrikController::class, 'delete'])->name('administrator.pengguna_rubrik.delete');
});


Route::group(['prefix' => 'administrator/detailisianrubrik'], function () {
    Route::get('/',[AdministratorDetailIsianRubrikController::class, 'index'])->name('administrator.detailisianrubrik');
    Route::post('/',[AdministratorDetailIsianRubrikController::class, 'post'])->name('administrator.detailisianrubrik.add');
    Route::get('/ubah_detailisianrubrik/{id}', [AdministratorDetailIsianRubrikController::class, 'update'])->name('administrator.detailisianrubrik.update');
    Route::patch('/aktifkan_status/{id}',[AdministratorDetailIsianRubrikController::class, 'aktifkanStatus'])->name('administrator.detailisianrubrik.aktifkan_status');
    Route::patch('/non_aktifkan_status/{id}',[AdministratorDetailIsianRubrikController::class, 'nonAktifkanStatus'])->name('administrator.detailisianrubrik.non_aktifkan_status');
    Route::delete('/',[AdministratorDetailIsianRubrikController::class, 'delete'])->name('administrator.detailisianrubrik.delete');
});

Route::group(['prefix' => 'administrator/isianrubrik'], function () {
    Route::get('/',[AdministratorIsianRubrikController::class, 'index'])->name('administrator.isianrubrik');
    Route::post('/',[AdministratorIsianRubrikController::class, 'post'])->name('administrator.isianrubrik.add');
    Route::get('/ubah_isianrubrik/{id}', [AdministratorIsianRubrikController::class, 'update'])->name('administrator.isianrubrik.update');
    Route::patch('/aktifkan_status/{id}',[AdministratorIsianRubrikController::class, 'aktifkanStatus'])->name('administrator.isianrubrik.aktifkan_status');
    Route::patch('/non_aktifkan_status/{id}',[AdministratorIsianRubrikController::class, 'nonAktifkanStatus'])->name('administrator.isianrubrik.non_aktifkan_status');
    Route::delete('/',[AdministratorIsianRubrikController::class, 'delete'])->name('administrator.isianrubrik.delete');
});


Route::group(['prefix' => 'administrator/penggunarubrik'], function () {
    Route::get('/',[AdministratorPenggunaRubrikController::class, 'index'])->name('administrator.penggunarubrik');
    Route::post('/',[AdministratorPenggunaRubrikController::class, 'post'])->name('administrator.penggunarubrik.post');
    Route::get('/{id}/edit',[AdministratorPenggunaRubrikController::class, 'edit'])->name('administrator.penggunarubrik.edit');
    Route::patch('/',[AdministratorPenggunaRubrikController::class, 'update'])->name('administrator.penggunarubrik.update');
    Route::delete('/',[AdministratorPenggunaRubrikController::class, 'delete'])->name('administrator.penggunarubrik.delete');
    Route::patch('/aktifkan_status/{id}',[AdministratorPenggunaRubrikController::class, 'aktifkanStatus'])->name('administrator.penggunarubrik.aktifkan_status');
    Route::patch('/non_aktifkan_status/{id}',[AdministratorPenggunaRubrikController::class, 'nonAktifkanStatus'])->name('administrator.penggunarubrik.non_aktifkan_status');
});

Route::group(['prefix' => 'administrator/jabatan'], function () {
    Route::get('/',[AdministratorJabatanController::class, 'index'])->name('administrator.jabatan');
    Route::post('/',[AdministratorJabatanController::class, 'post'])->name('administrator.jabatan.post');
    Route::get('/{id}/edit',[AdministratorJabatanController::class, 'edit'])->name('administrator.jabatan.edit');
    Route::patch('/',[AdministratorJabatanController::class, 'update'])->name('administrator.jabatan.update');
    Route::delete('/',[AdministratorJabatanController::class, 'delete'])->name('administrator.jabatan.delete');
});

Route::group(['prefix'  => 'administrator/rekapitulasi'],function(){
    Route::get('/p1_dan_p2',[AdministratorRekapitulasiController::class, 'index'])->name('administrator.rekap_p1');
    Route::get('/p3',[AdministratorRekapitulasiController::class, 'rekapP3'])->name('administrator.rekap_p3');
});

Route::group(['prefix'  => 'administrator/data_insentif'],function(){
    Route::get('/',[AdministratorDataInsentifController::class, 'index'])->name('administrator.data_insentif');
});

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
    Route::get('/{periode_id}',[CapaianSkpController::class, 'index'])->name('kepegawaian.r_skp');
    Route::get('/generate_tendik/{periode_id}',[CapaianSkpController::class, 'generateTendik'])->name('kepegawaian.r_skp.generate_tendik');
    Route::patch('/{id}/update_nilai/{periode_id}',[CapaianSkpController::class, 'updateNilai'])->name('kepegawaian.r_skp.update_nilai');
    Route::patch('/verifikasi/{periode_id}',[CapaianSkpController::class, 'verifikasi'])->name('kepegawaian.r_skp.verifikasi');
    Route::get('/{id}/download_path',[CapaianSkpController::class, 'downloadSkp'])->name('kepegawaian.r_skp.download_skp');
    Route::get('/generate_potongan/{periode_id}',[CapaianSkpController::class, 'generate'])->name('kepegawaian.r_skp.generate');
    Route::get('/{periode_id}/generate_submit',[CapaianSkpController::class, 'generateSubmit'])->name('kepegawaian.r_skp.generate_submit');
    Route::get('/generate_nominal/{periode_id}',[CapaianSkpController::class, 'generateNominal'])->name('kepegawaian.r_skp.generate_nominal');
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
    Route::patch('/{id}/{periode_id}/update_data_lhkpn_lhkasn',[IntegritasController::class, 'updateDataLhkpnLhkasn'])->name('kepegawaian.r_integritas.update_data_lhkpn_lhkasn');
    Route::get('/{periode_id}/generate_lhkpn_lhkasn',[IntegritasController::class, 'generateLhkpnLhkasn'])->name('kepegawaian.r_integritas.generate_lhkpn_lhkasn');
    Route::get('/{periode_id}/sanksi_disiplin',[IntegritasController::class, 'sanksiDisiplin'])->name('kepegawaian.r_integritas.sanksi_disiplin');
    Route::patch('/{id}/{periode_id}/update_data_sanksi_disiplin',[IntegritasController::class, 'updateDataSanksiDisiplin'])->name('kepegawaian.r_integritas.update_data_sanksi_disiplin');
    Route::get('/{periode_id}/generate_sanksi_disiplin',[IntegritasController::class, 'generateSanksiDisiplin'])->name('kepegawaian.r_integritas.generate_sanksi_disiplin');
    Route::get('/{periode_id}/integritas_satu_bulan',[IntegritasController::class, 'integritasSatuBulan'])->name('kepegawaian.r_integritas.integritas_satu_bulan');
    Route::get('/{periode_id}/generate_integritas_satu_bulan',[IntegritasController::class, 'generateIntegritasSatuBulan'])->name('kepegawaian.r_integritas.generate_integritas_satu_bulan');
    Route::get('/{periode_id}/total_integritas',[IntegritasController::class, 'totalIntegritas'])->name('kepegawaian.r_integritas.total_integritas');
    Route::get('/{periode_id}/generate_total_integritas',[IntegritasController::class, 'generateTotalIntegritas'])->name('kepegawaian.r_integritas.generate_total_integritas');
});


Route::group(['prefix' => 'kepegawaian/rekapitulasi'], function () {
    Route::get('/{periode_id}',[RekapitulasiController::class, 'index'])->name('kepegawaian.rekapitulasi');
    Route::get('/{periode_id}/generate_table',[RekapitulasiController::class, 'generateTable'])->name('kepegawaian.rekapitulasi.generate_table');
    Route::get('/{periode_id}/data_tendik',[RekapitulasiController::class, 'dataTendik'])->name('kepegawaian.rekapitulasi.data_tendik');
    Route::get('/{periode_id}/generate_data_tendik',[RekapitulasiController::class, 'generateDataTendik'])->name('kepegawaian.rekapitulasi.generate_data_tendik');
    Route::get('/{periode_id}/total_remun',[RekapitulasiController::class, 'totalRemun'])->name('kepegawaian.rekapitulasi.total_remun');
    Route::get('/{periode_id}/generate_total_remun',[RekapitulasiController::class, 'generateTotalRemun'])->name('kepegawaian.rekapitulasi.generate_total_remun');
    Route::get('/{periode_id}/integritas',[RekapitulasiController::class, 'integritas'])->name('kepegawaian.rekapitulasi.integritas');
    Route::get('/{periode_id}/generate_integritas',[RekapitulasiController::class, 'generateIntegritas'])->name('kepegawaian.rekapitulasi.generate_integritas');
    Route::get('/{periode_id}/skp',[RekapitulasiController::class, 'skp'])->name('kepegawaian.rekapitulasi.skp');
    Route::get('/{periode_id}/generate_skp',[RekapitulasiController::class, 'generateSkp'])->name('kepegawaian.rekapitulasi.generate_skp');
    Route::get('/{periode_id}/persentase_absen',[RekapitulasiController::class, 'persentaseAbsen'])->name('kepegawaian.rekapitulasi.persentase_absen');
    Route::get('/{periode_id}/generate_absensi',[RekapitulasiController::class, 'generateAbsensi'])->name('kepegawaian.rekapitulasi.generate_absensi');
    Route::get('/{periode_id}/total_akhir',[RekapitulasiController::class, 'totalAkhir'])->name('kepegawaian.rekapitulasi.total_akhir_remun');
    Route::get('/{periode_id}/generate_total_akhir',[RekapitulasiController::class, 'generateTotalAkhir'])->name('kepegawaian.rekapitulasi.generate_total_akhir');
    
});


Route::group(['prefix'  => 'kepegawaian/manajemen_data_kepegawaian'],function(){
    Route::get('/','kepegawaian\kepegawaianController@index')->name('kepegawaian.kepegawaian');
    Route::post('/','kepegawaian\kepegawaianController@post')->name('kepegawaian.kepegawaian.add');
    Route::patch('/ubah_password','kepegawaian\kepegawaianController@ubahPassword')->name('kepegawaian.kepegawaian.ubah_password');
    Route::patch('/aktifkan_status/{id}','kepegawaian\kepegawaianController@aktifkanStatus')->name('kepegawaian.kepegawaian.aktifkan_status');
    Route::patch('/non_aktifkan_status/{id}','kepegawaian\kepegawaianController@nonAktifkanStatus')->name('kepegawaian.kepegawaian.non_aktifkan_status');
    Route::get('/{id}/edit','kepegawaian\kepegawaianController@edit')->name('kepegawaian.kepegawaian.edit');
    Route::patch('/','kepegawaian\kepegawaianController@update')->name('kepegawaian.kepegawaian.update');
    Route::delete('/','kepegawaian\kepegawaianController@delete')->name('kepegawaian.kepegawaian.delete');
});

//Route Operator
Route::group(['prefix'  => 'operator'], function () {
    Route::get('/dashboard', [DashboardOperatorController::class, 'dashboard'])->name('operator.dashboard');
    Route::group(['prefix'=>'data_insentif'],function(){
        route::get('/',[DataInsentifController::class, 'index'])->name('operator.datainsentif');
    });

    Route::group(['prefix'=>'detail_rubrik'],function(){
        route::get('/{id}',[DetailRubrikController::class, 'index'])->name('operator.dataremun');
        route::get('/{id}/kolum_rubrik',[DetailRubrikController::class, 'kolom_rubrik'])->name('operator.dataremun.kolom_rubrik');
        route::post('/store',[DetailRubrikController::class, 'store'])->name('operator.dataremun.store');
        route::get('/{fileid}/download',[DetailRubrikController::class, 'download'])->name('operator.dataremun.download');
        route::get('/{id}/edit',[DetailRubrikController::class, 'edit'])->name('operator.dataremun.edit');
        route::put('/{id}}/update',[DetailRubrikController::class, 'update'])->name('operator.dataremun.update');
        route::put('/tambah_isian/{id}',[DetailRubrikController::class, 'tambah_isian'])->name('operator.dataremun.tambah_isian');
        route::delete('/{id}/delete',[DetailRubrikController::class, 'destroy'])->name('operator.dataremun.destroy');

        Route::group(['prefix'=>'detail_isian'],function(){
            route::get('{rubrik_id}/{isian_id}',[DetailIsianController::class, 'index'])->name('operator.detail_isian');
            route::post('/prodi',[DetailIsianController::class, 'prodi'])->name('operator.detail_isian.prodi');
            route::post('/dosen',[DetailIsianController::class, 'dosen'])->name('operator.detail_isian.dosen');
            route::post('/{rubrik_id}/store/{isian_id}',[DetailIsianController::class, 'store'])->name('operator.detail_isian.store');
            route::delete('/{detail_id}/destroy/{isian_id}',[DetailIsianController::class, 'destroy'])->name('operator.detail_isian.destroy');
            route::put('/{id}/update',[DetailIsianController::class, 'update'])->name('operator.detail_isian.update ');
        });
    });

    Route::group(['prefix'=>'laporan'],function(){
        route::get('/',[LaporanController::class, 'index'])->name('operator.laporan');
    });
});