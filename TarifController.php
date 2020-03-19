<?php 

namespace App\Http\Controllers;
use App\Tarif;
use Auth;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Tarif::count();
        $tarif = array();

        foreach (Tarif::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_tarif"      => $p->id_tarif,
                "daya"          => $p->daya,
                "tarifperkwh"   => $p->tarifperkwh,
                "created_at"    => $p->created_at,
                "updated_at"    => $p->updated_at
            ];

            array_push($tarif, $item);
        }
        $data["tarif"]  = $tarif;
        $data["status"] = 1;
        return response($data);
    }
    public function store (Request $request){
        try {
            $data = new Tarif();
            $data->daya           = $request->input('daya');
            $data->tarifperkwh    = $request->input('tarifperkwh');
            $data->save();
            return response()->json([
                'status'    =>'1',
                'message'   =>'Data Tarif Berhasil Ditambahkan'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data Tarif Gagal Ditambahkan!'
            ]);
        }
    }
    public function update(Request $request, $id_tarif){
        try {
            $data = Tarif::where('id_tarif',$id_tarif)->first();
            $data->daya           = $request->input('daya');
            $data->tarifperkwh    = $request->input('tarifperkwh');
            $data->save();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data tarif berhasil diubah'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data tarif gagal diubah'
            ]);
        }
    }
    public function destroy($id_tarif){
        try {
            $data = Tarif::where('id_tarif',$id_tarif)->first();
            $data->delete();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data tarif berhasil dihapus'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data tarif gagal dihapus'
            ]); 
        }
    }
}