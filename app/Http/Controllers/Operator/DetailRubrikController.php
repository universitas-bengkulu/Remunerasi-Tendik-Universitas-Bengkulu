<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\IsianRubrik;
use App\Models\PeriodeInsentif;
use App\Models\Rubrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DetailRubrikController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isOperator']);
    }

    public function index($id){
        $data['data_rubriks']=Rubrik::where('id',$id)->get();
        $data['rubriks']=Rubrik::has('isianrubrik')->get();
        $data['periodes']=PeriodeInsentif::where('status','aktif')->first();
        return view('operator.data_remun.dataremun',$data);

    }

    public function kolom_rubrik($id){
        $data=Rubrik::where('id',$id)->first();
        return response()->json($data, 200);
    }

    public function store(Request $request){
        
        $this->validate($request,[
            'id_rubrik'   =>  'required',
            'no_sk'   =>  'required',
            'id_periode'   =>  'required',
            'file_isian'    =>  'required'
        ],[
            'required' => 'Data tidak boleh kosong'
        ]);
        $nama_rubrik = Rubrik::where('id',$request->id_rubrik)->select('nama_rubrik')->firstOrFail();
        $garing = str_replace("/", "-", $request->no_sk);
        $periode = PeriodeInsentif::where('status','aktif')->first();
        return $periode;
        if (!empty($periode)) {
            $model = $request->all();
            $slug = Str::slug(Session::get('nm_dosen'));
            $model['file_isian'] = null;

            if ($request->hasFile('file_isian')) {
                $model['file_isian'] = $nama_rubrik.'-'.$request->id_rubrik.'-'.$garing.'-'.$request->tahun_usulan.uniqid().'.'.$request->file_isian->getClientOriginalExtension();
                $request->file_isian->move(public_path('/upload/file_isian/'.$slug.'-'.Session::get('nip')), $model['file_isian']);
            }
            $isian_kolom=array_combine($request->isian_angka,$request->nama_kolom);
            $isian_rubrik=array(
                'rubrik_id'       =>  $request->id_rubrik,
                'nomor_sk'       =>  $request->no_sk,
                'periode_id'       =>  $request->id_periode,
                'file_upload'       =>  $request->id_file,
                'status_validasi'       =>  "nonaktif",
            );
            $data=array_merge($isian_rubrik,$isian_kolom);
            IsianRubrik::create($data);
            return redirect()->route('operator.dataremun')->with(['success' =>  'Data isian rubrik berhasil ditambahkan']);
        }
        else{
            $notification = array(
                'message' => 'Gagal, Harap Aktifkan Periode Remunerasi Insentif Terlebih Dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('operator.dataremun',[$request->id_rubrik])->with($notification);
        }
        
    }

    public function destroy($id){
        $data=IsianRubrik::findorfail($id);
        Storage::cloud()->delete($data->file_upload);
        $data->delete();
        return redirect()->route('operator.dataremun')->with(['success' =>  'Data berhasil dihapus']);
    }

    public function download($fileid){
        $file = collect(Storage::cloud()->listContents('', false))
                ->where('type', '=', 'file')
                ->where('path', '=', pathinfo($fileid, PATHINFO_FILENAME))
                ->last();
        $response=Storage::cloud()->download($fileid,$file['name']);
        $response->send();
    }

    public function edit($id){
        $data['data_rubriks']=Rubrik::all();
        $data['isian_rubrik']=IsianRubrik::findorfail($id);
        $data['rubriks']=collect($data['isian_rubrik']->rubrik)->toArray();
        $data['periodes']=Periode::where('status','aktif')->get();
        $data['data']=collect(IsianRubrik::findorfail($id))->toArray();
        return view('operator.data_remun.edit_dataremun',$data);
    }

    public function update($id,Request $request){
        $isian_kolom=array();
        // dd($request->nama_kolom_lama);
        $isian_kolom=array_combine($request->isian_angka_lama,$request->nama_kolom_lama);
        $isian_rubrik=array(
            'rubrik_id'       =>  $request->id_lama,
            'nomor_sk'       =>  $request->no_sk,
            'periode_id'       =>  $request->id_periode,
            'status_validasi'       =>  "nonaktif",
        );
        $data=array_merge($isian_rubrik,$isian_kolom);
        IsianRubrik::where('id',$id)->update($data);
        return redirect()->route('operator.dataremun')->with(['success' =>  'Data isian rubrik berhasil diubah']);
    }
}
