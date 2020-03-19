<?php 

namespace App\Http\Controllers;
use App\Pelanggan;
use Auth;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Pelanggan::count();
        $pelanggan = array();

        foreach (Pelanggan::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_pelanggan"    => $p->id_pelanggan,
                "nomor_kwh"       => $p->nomor_kwh,
                "nama_pelanggan"  => $p->nama_pelanggan,
                "alamat"		  => $p->alamat,
                "id_tarif"        => $p->id_tarif,
                "created_at"      => $p->created_at,
                "updated_at"      => $p->updated_at
            ];

            array_push($pelanggan, $item);
        }
        $data["pelanggan"]  = $pelanggan;
        $data["status"] = 1;
        return response($data);
    }
    public function store (Request $request){
        try {
            $data = new Pelanggan();
            $data->nomor_kwh      = $request->input('nomor_kwh');
            $data->nama_pelanggan = $request->input('nama_pelanggan');
            $data->alamat         = $request->input('alamat');
            $data->save();
            return response()->json([
                'status'    =>'1',
                'message'   =>'Data Pelanggan Berhasil Ditambahkan'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data Pelanggan Gagal Ditambahkan!'
            ]);
        }
    }
    public function update(Request $request, $id_pelanggan){
        try {
            $data = Pelanggan::where('id_pelanggan',$id_pelanggan)->first();
            $data->nomor_kwh        = $request->input('nomor_kwh');
            $data->nama_pelanggan   = $request->input('nama_pelanggan');
            $data->alamat           = $request->input('alamat');
            $data->save();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data pelanggan berhasil diubah'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data pelanggan gagal diubah'
            ]);
        }
    }
    public function destroy($id_pelanggan){
        try {
            $data = Pelanggan::where('id_pelanggan',$id_pelanggan)->first();
            $data->delete();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data pelanggan berhasil dihapus'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data pelanggan gagal dihapus'
            ]); 
        }
    }
}