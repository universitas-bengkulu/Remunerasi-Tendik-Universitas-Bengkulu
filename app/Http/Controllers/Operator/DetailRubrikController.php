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
        $data['rubriks']=IsianRubrik::join('rubriks','rubriks.id','isian_rubriks.rubrik_id')
                                    ->join('pengguna_rubriks','pengguna_rubriks.rubrik_id','rubriks.id')
                                    ->join('periode_insentifs','periode_insentifs.id','isian_rubriks.periode_id')
                                    ->join('units','units.id','pengguna_rubriks.unit_id')
                                    ->select('rubriks.id','isian_rubriks.id as isian_id','nama_rubrik','nama_kolom_1','nama_kolom_2','nama_kolom_3','nama_kolom_4','nama_kolom_5',
                                                'nama_kolom_6','nama_kolom_7','masa_kinerja','nama_kolom_8','nama_kolom_9','nama_kolom_10',
                                                'nm_unit','file_upload','nomor_sk','status_validasi')
                                    ->where('rubriks.id',$id)
                                    ->groupBy('isian_rubriks.id')
                                    ->get();
        $data['data_rubriks']=Rubrik::where('id',$id)->get();
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
        $nm_rubrik = Str::slug($nama_rubrik->nama_rubrik);
        $garing = str_replace("/", "-", $request->no_sk);
        $periode = PeriodeInsentif::where('status','aktif')->first();
        if (!empty($periode)) {
            $model = $request->all();
            $slug = Str::slug($periode->masa_kinerja);
            $model['file_isian'] = null;

            if ($request->hasFile('file_isian')) {
                $model['file_isian'] = $garing.'-'.$request->id_rubrik.'-'.$slug.'.'.$request->file_isian->getClientOriginalExtension();
                $request->file_isian->move(public_path('/upload/file_isian/'.$nm_rubrik), $model['file_isian']);
            }
            $isian_kolom=array_combine($request->isian_angka,$request->nama_kolom);
            $isian_rubrik=array(
                'rubrik_id'       =>  $request->id_rubrik,
                'nomor_sk'       =>  $request->no_sk,
                'periode_id'       =>  $request->id_periode,
                'file_upload'       =>  $model['file_isian'],
                'status_validasi'       =>  "nonaktif",
            );
            $data=array_merge($isian_rubrik,$isian_kolom);
            IsianRubrik::create($data);
            return redirect()->route('operator.dataremun',[$request->id_rubrik])->with(['success' =>  'Data isian rubrik berhasil ditambahkan']);
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
