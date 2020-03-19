<?php 

namespace App\Http\Controllers;
use App\Level;
use Auth;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Level::count();
        $tarif = array();

        foreach (Level::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_level"      => $p->id_level,
                "nama_level"    => $p->nama_level,
                "created_at"    => $p->created_at,
                "updated_at"    => $p->updated_at
            ];

            array_push($level, $item);
        }
        $data["level"]  = $level;
        $data["status"] = 1;
        return response($data);
    }
    public function store (Request $request){
        try {
            $data = new Level();
            $data->nama_level     = $request->input('nama_level');
            $data->save();
            return response()->json([
                'status'    =>'1',
                'message'   =>'Data Level Berhasil Ditambahkan'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data Level Gagal Ditambahkan!'
            ]);
        }
    }
    public function update(Request $request, $id_level){
        try {
            $data = Level::where('id_level',$id_level)->first();
            $data->nama_level     = $request->input('nama_level');
            $data->save();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data level berhasil diubah'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data level gagal diubah'
            ]);
        }
    }
    public function destroy($id_level){
        try {
            $data = Level::where('id_level',$id_level)->first();
            $data->delete();

            return response()->json([
                'status'    => '1',
                'message'   => 'Data level berhasil dihapus'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Data level gagal dihapus'
            ]); 
        }
    }
}