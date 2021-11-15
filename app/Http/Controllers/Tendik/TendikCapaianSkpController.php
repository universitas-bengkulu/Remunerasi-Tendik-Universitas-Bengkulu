<?php

namespace App\Http\Controllers\Tendik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RCapaianSkp;
use App\Models\Periode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class TendikCapaianSkpController extends Controller
{
    public function __construct(){
        $this->middleware('auth:tendik');
    }

    public function index(){
        $periode = Periode::select('id','jumlah_bulan','slug')->where('status','aktif')->first();
        if (!empty($periode)) {
            $skps = RCapaianSkp::join('periodes','periodes.id','r_capaian_skps.periode_id')
                                ->join('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                                ->select('r_capaian_skps.id','nip','nm_lengkap','r_capaian_skps.status','nilai_skp','path','nm_periode')
                                ->where('tendiks.nip',Auth::guard('tendik')->user()->nip)
                                ->where('periodes.id',$periode->id)
                                ->where('path','!=', NULL)
                                ->where('path','!=',"")
                                ->get();
            $sekarang = RCapaianSkp::where('tendik_id',Auth::guard('tendik')
                                    ->user()->id)
                                    ->where('periode_id',$periode->id)
                                    ->where('path','!=', NULL)
                                    ->where('path','!=',"")
                                    ->first();
        }else{
            return redirect()->back();
        }
        $status = RCapaianSkp::select('id')
                                ->where('tendik_id',Auth::guard('tendik')->user()->id)
                                ->first();
        return view('tendik/skp.index', compact('skps','status','periode','sekarang'));
    }

    public function post(Request $request,$id){
        $messages = [
            'required' => ':attribute harus diisi',
            'mimes' => 'The :attribute harus berupa file: :values.',
            'max' => [
                'file' => ':attribute tidak boleh lebih dari :max kilobytes.',
            ],
        ];
        $attributes = [
            'nilai_skp'   =>  'Nilai SKP',
            'path'   =>  'File SKP',
        ];
        $this->validate($request, [
            'nilai_skp'    =>  'required|min:30',
            'path'    =>  'required|mimes:doc,pdf,docx,jpg|max:2000',
        ],$messages,$attributes);
        $periode = Periode::where('status','aktif')->first();
        $tendik = RCapaianSkp::where('id',$id)->firstOrFail();
        if ($request->hasFile('path')){
            $model['path'] = $tendik->path;
            if (!$tendik->path == NULL){
                unlink(public_path($tendik->path));
            }
            $model['path'] = Str::slug(Auth::guard('tendik')->user()->nm_lengkap.'-'.Auth::guard('tendik')->user()->nip).'.'.$request->path->getClientOriginalExtension();
            $request->path->move(public_path('/upload/file_skp/'.$periode->slug.'/'), $model['path']);

            RCapaianSkp::where('tendik_id',$id)->update([
                'path'  =>  $model['path'],
                'nilai_skp' =>  $request->nilai_skp,
                'status'    =>  'menunggu',
            ]);
        }
        return redirect()->route('tendik.r_skp')->with(['success'   =>  'Nilai dan file skp periode saat ini berhasil ditambahkan !!']);
    }

    public function kirimkanSkp($id){
        RCapaianSkp::where('id',$id)->update([
            'status'    =>  'terkirim',
        ]); 

        return redirect()->route('tendik.r_skp')->with(['success'   =>  'File SKP Berhasil Dikirimkan !!']);
    }

    public function delete(Request $request){
        $periode = Periode::where('status','aktif')->first();
        $file = RCapaianSkp::find($request->id);
        if (!$file->path == NULL){
            $files = public_path('/upload/file_skp/'.$periode->slug.'/'.$file->path);
            File::delete($files);
        }
        RCapaianSkp::where('id',$request->id)->update([
            'path'  =>  NULL,
            'nilai_skp' =>  0,
            'status'    =>  NULL,
        ]); 
        return redirect()->route('tendik.r_skp')->with(['success'   =>  'Nilai dan file skp periode yang dipilih berhasil dihapus !!']);
    }
}
