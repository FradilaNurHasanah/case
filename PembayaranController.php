<?php 

namespace App\Http\Controllers;
use App\Pembayaran;
use Auth;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Pembayaran::count();
        $pembayaran = array();

        foreach (Pembayaran::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_pembayaran"         => $p->id_pembayaran,
                "id_tagihan"            => $p->id_tagihan,
                "tanggal_pembayaran"    => $p->tanggal_pembayaran,
                "bulan_bayar"           => $p->bulan_bayar,
                "biaya_admin"           => $p->biaya_admin,
                "total_bayar"           => $p->total_bayar,
                "status"                => $p->status,
                "bukti"                 => $p->bukti,
                "id_admin"              => $p->id_admin,
                "created_at"            => $p->created_at,
                "updated_at"            => $p->updated_at
            ];

            array_push($pembayaran, $item);
        }
        $data["pembayaran"]  = $pembayaran;
        $data["status"] = 1;
        return response($data);
    }
    public function store (Request $request){
        try {
            $data = new Penggunaan();
            $data->tanggal_pembayaran       = $request->input('tanggal_pembayaran');
            $data->bulan_bayar              = $request->input('bulan_bayar');
            $data->total_bayar              = $request->input('total_bayar');
            $data->save();
            return response()->json([
                'status'    =>'1',
                'message'   =>'Data Pembayaran Berhasil Ditambahkan'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data Pembayaran Gagal Ditambahkan!'
            ]);
        }
    }
    public function update(Request $request, $id_pembayaran){
        try {
            $data = Pembayaran::where('id_pembayaran',$id_pembayaran)->first();
            $data->tanggal_pembayaran       = $request->input('tanggal_pembayaran');
            $data->bulan_bayar              = $request->input('bulan_bayar');
            $data->total_bayar              = $request->input('total_bayar');
            $data->save();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data pembayaran berhasil diubah'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data pembayaran gagal diubah'
            ]);
        }
    }
    public function destroy($id_pembayaran){
        try {
            $data = Pembayaran::where('id_pembayaran',$id_pembayaran)->first();
            $data->delete();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data pembayaran berhasil dihapus'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data pembayaran  gagal dihapus'
            ]);
        }
    }
}