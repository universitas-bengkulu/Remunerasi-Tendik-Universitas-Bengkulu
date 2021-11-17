<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\DetailIsianRubrik;
use App\Models\IsianRubrik;
use App\Models\Rubrik;
use App\Models\Tendik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailIsianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isOperator']);
    }

    public function index($rubrik_id,$isian_id){
        $detail = DetailIsianRubrik::join('isian_rubriks','isian_rubriks.id','detail_isian_rubriks.isian_rubrik_id')
                                    ->join('rubriks','rubriks.id','isian_rubriks.rubrik_id')
                                    ->join('tendiks','tendiks.id','detail_isian_rubriks.tendik_id')
                                    ->where('isian_rubriks.id',$isian_id)
                                    ->select('detail_isian_rubriks.id as detail_isian_id','nip',
                                            'keterangan','rate_remun','nm_tendik')
                                    ->get();
        $panda = new HomeController();
        $fakultas = '
            {fakultas {
                fakKode
                fakNamaResmi
            }}
        ';
        $tendiks = Tendik::join('jabatans','jabatans.id','tendiks.jabatan_id')
                        ->select('tendiks.id','nm_jabatan','nm_lengkap')    
                        ->where('unit_id',Auth::user()->unit_id)->get();
        $fakultases = $panda->panda($fakultas);
        $isian =collect(IsianRubrik::findorfail($isian_id))->toArray();
        $isian_rubrik=IsianRubrik::findorfail($isian_id);
        $rubriks =collect($isian_rubrik->rubrik)->toArray();
        $fakultases = $fakultases;
        // $data['isian_rubrik']=IsianRubrik::findorfail($id);
        // $data['rubriks']=collect($data['isian_rubrik']->rubrik)->toArray();
        // $data['detail_rubriks']=DetailIsianRubrik::where('isian_rubrik_id',$id)->get();
        return view('operator/detail_isian.index',compact('detail','isian_id','rubrik_id','isian','rubriks','fakultases','tendiks'));
    }

    public function store(Request $request,$rubrik_id,$isian_id){
        $this->validate($request,[
            'rate_remun'   =>  'required',
            'tendik'   =>  'required',
            'keterangan'   =>  'required',
        ]);

        $tendik = Tendik::find($request->tendik);
        DetailIsianRubrik::create([
            'isian_rubrik_id'=> $isian_id,
            'tendik_id' => $request->tendik,
            'rate_remun'=> $request->rate_remun,
            'keterangan'=>nl2br($request->keterangan),
            'nm_tendik'    =>  $tendik->nm_lengkap,
            'prodi'         =>  $request->nama_prodi,
        ]); 
        
        return redirect()->route('operator.detail_isian',[$rubrik_id,$isian_id])->with(['success' =>  'Data Detail isian rubrik berhasil ditambahkan']);
    }

    public function destroy(Request $request, $rubrik_id,$isian_id){
        DetailIsianRubrik::destroy($request->detail_id);
        $notification = array(
            'message' => 'Berhasil, Detail isian rubrik berhasil dihapus!',
            'alert-type' => 'success'
        );
        return redirect()->route('operator.detail_isian',[$rubrik_id,$isian_id])->with($notification);
    }
}
