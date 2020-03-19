<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{

	//fungsi untuk login
	public function login(Request $request){
		$credentials = $request->only('email', 'password');

		try {
			if(!$token = JWTAuth::attempt($credentials)){
				return response()->json([
						'logged' 	=>  false,
						'message' 	=> 'Invalid email or password'
					]);
			}
		} catch(JWTException $e){
			return response()->json([
						'logged' 	=> false,
						'message' 	=> 'Generate Token Failed'
					]);
		}

		return response()->json([
					"logged"    => true,
                    "token"     => $token,
                    "message" 	=> 'Login berhasil'
		]);
	}

    //fungsi untuk register
	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama_admin'=> 'required|string|max:255',
			'role'		=> 'required',
			'email'     => 'required|string|email|max:255|unique:users',
			'password'  => 'required|string|min:6',
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> 0,
				'message'	=> $validator->errors()->toJson()
			]);
		}

		$user = new User();
		$user->nama_admin	= $request->nama_admin;
		$user->role			= $request->role;
		$user->email 		= $request->email;
		$user->password 	= Hash::make($request->password);
		$user->save();
		$token          	= JWTAuth::fromUser($user);
 
		return response()->json([
			'status'	=> '1',
			'message'	=> 'User Berhasil Terregistrasi',
		], 201);
    }
    
    //fungsi untuk index
	public function index($limit = 10, $offset = 0)
    {
        $data["count"] = User::count();
        $user = array();

        foreach (User::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_admin"          => $p->id_admin,
                "nama_admin"        => $p->nama_admin,
				"email"    	  		=> $p->email,
				"role"				=> $p->role,
                "created_at"  		=> $p->created_at,
                "updated_at"  		=> $p->updated_at
            ];

            array_push($user, $item);
        }
        $data["user"]  = $user;
        $data["status"] = 1;
        return response($data);
    }

    //fungsi untuk menambahkan petugas 
    public function store (Request $request){
        $user 				= new User();
		$user->nama_admin 	= $request->nama_admin;
		$user->role 		= $request->role;
		$user->email 		= $request->email;
		$user->password 	= Hash::make($request->password);
		$user->save();
		$token          = JWTAuth::fromUser($user);

		return response()->json([
			'status'	=> '1',
			'message'	=> 'Petugas Berhasil Ditambahkan',
		], 201);
    }

    //fungsi untuk hapus
    public function destroy($id){
        try {
            $data = User::where('id_admin', $id_admin)->first();
            $data->delete();

            return response()->json([
                'status'    => '1',
                'message'   => 'Hapus data petugas berhasil'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Hapus data petugas gagal'
            ]);
        }
    }

    //fungsi untuk update
	public function update(Request $request, $id){
        try {
            $data 				= User::where('id_admin',$id_admin)->first();
            $data->nama_admin 	= $request->input('nama_admin');
            $data->email    	= $request->input('email');
			$data->password 	= $request->input('password');
			$data->role 		= $request->input('role');
            $data->save();

            return response()->json([
                'status'    => '1',
                'message'   => 'Ubah data petugas berhasil'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => 'Ubah data petugas gagal'
            ]);
        }
    }
	
	public function getAuthenticatedUser(){
		try {
			if(!$user = JWTAuth::parseToken()->authenticate()){
				return response()->json([
						'auth' 		=> false,
						'message'	=> 'Invalid token'
					]);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
			return response()->json([
						'auth' 		=> false,
						'message'	=> 'Token expired'
					], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
			return response()->json([
						'auth' 		=> false,
						'message'	=> 'Invalid token'
					], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e){
			return response()->json([
						'auth' 		=> false,
						'message'	=> 'Token absent'
					], $e->getStatusCode());
		}

		 return response()->json([
		 		"auth"      => true,
                "user"    => $user
		 ], 201);
    }
}
