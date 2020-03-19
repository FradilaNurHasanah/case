<?php 

namespace App\Http\Controllers;
use App\Tagihan;
use Auth;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Tagihan::count();
        $tagihan = array();

        foreach (Tagihan::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_tagihan"      => $p->id_tagihan,
                "id_penggunaan"   => $p->id_penggunaan,
                "bulan"           => $p->bulan,
                "tahun"           => $p->tahun,
                "jumlah_meter"    => $p->jumlah_meter,
                "status"          => $p->status,
                "created_at"      => $p->created_at,
                "updated_at"      => $p->updated_at
            ];

            array_push($tagihan, $item);
        }
        $data["tagihan"]    = $tagihan;
        $data["status"]     = 1;
        return response($data);
    }
    public function store (Request $request){
        try {
            $data = new Tagihan();
            $data->id_penggunaan  = $request->input('id_penggunaan');
            $data->bulan          = $request->input('bulan');
            $data->tahun          = $request->input('tahun');
            // $data->jumlah_meter   = $request->input('jumlah_meter');
            $data->save();
            return response()->json([
                'status'    =>'1',
                'message'   =>'Data tagihan Berhasil Ditambahkan'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data tagihan Gagal Ditambahkan!'
            ]);
        }
    }
    public function update(Request $request, $id_tagihan){
        try {
            $data = Tagihan::where('id_tagihan',$id_tagihan)->first();
            $data->id_penggunaan       = $request->input('id_penggunaan');
            $data->bulan               = $request->input('bulan');
            $data->tahun               = $request->input('tahun');
            $data->save();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data tagihan berhasil diubah'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data tagihan gagal diubah'
            ]);
        }
    }
    public function destroy($id_tagihan){
        try {
            $data = Tagihan::where('id_tagihan',$id_tagihan)->first();
            $data->delete();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data tagihan berhasil dihapus'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data tagihan gagal dihapus'
            ]); 
        }
    }
}