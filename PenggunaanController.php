<?php 

namespace App\Http\Controllers;
use App\Penggunaan;
use Auth;
use Illuminate\Http\Request;

class PenggunaanController extends Controller
{
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Penggunaan::count();
        $penggunaan = array();

        foreach (Penggunaan::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_penggunaan"   => $p->id_penggunaan,
                "id_pelanggan"    => $p->id_pelanggan,
                "bulan"           => $p->bulan,
                "tahun"           => $p->tahun,
                "meter_awal"      => $p->meter_awal,
                "meter_akhir"     => $p->meter_akhir,
                "created_at"      => $p->created_at,
                "updated_at"      => $p->updated_at
            ];

            array_push($penggunaan, $item);
        }
        $data["penggunaan"]  = $penggunaan;
        $data["status"] = 1;
        return response($data);
    }
    public function store (Request $request){
        try {
            $data = new Penggunaan();
            $data->id_pelanggan   = $request->input('id_pelanggan');
            $data->bulan          = $request->input('bulan');
            $data->tahun          = $request->input('tahun');
            $data->save();
            return response()->json([
                'status'    =>'1',
                'message'   =>'Data Penggunaan Berhasil Ditambahkan'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data penggunaan Gagal Ditambahkan!'
            ]);
        }
    }
    public function update(Request $request, $id_penggunaan){
        try {
            $data = Penggunaan::where('id_penggunaan',$id_penggunaan)->first();
            $data->id_pelanggan        = $request->input('id_pelanggan');
            $data->bulan               = $request->input('bulan');
            $data->tahun               = $request->input('tahun');
            $data->save();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data penggunaan berhasil diubah'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data penggunaan gagal diubah'
            ]);
        }
    }
    public function destroy($id_penggunaan){
        try {
            $data = Penggunaan::where('id_penggunaan',$id_penggunaan)->first();
            $data->delete();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data penggunaan berhasil dihapus'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data penggunaan gagal dihapus'
            ]); 
        }
    }
}