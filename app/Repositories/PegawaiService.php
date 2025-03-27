<?php

namespace App\Repositories;

use App\Models\Pegawai;
use App\Interfaces\PegawaiServiceInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Classes\ApiResponseClass;
use Throwable;

class PegawaiService implements PegawaiServiceInterface
{
    public function index(array $query) {
        try {
            $take   = $query['take'];
            $page   = $query['page'] ?? 1;
            $user   = Pegawai::orderby('pegawai.name','asc')
                            ->paginate($take);
            $total  = Pegawai::all()->count();

            if(count($user) < 1) abort(404, "Pegawai data is null or not found !");

            $meta   = [
                'current_page'  => $page,
                'take'          => $take,
                'total_pages'   => ceil($total/$take),
                'item_per_page' => count($user),
                'total_items'   => $total
            ];
            $data   = [
                'items' => $user,
                'meta'  => $meta,
            ];
            return $data;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function checkPegawai(array $data) {
        try{
            $username       = $data['user'] ?? '';
            $inputPassword  = $data['password'] ?? '';
            $checkUser      = Pegawai::whereRaw('email = ?',[$username])
                                    ->first();
            
            
            if($checkUser){
                Hash::check($inputPassword, $checkUser->password) ? $result = $checkUser : abort(404,'Password not valid !');
            } else {
                abort(404,'Email not found !');
            }
            return $result;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
     }
 
     public function checkPegawaiById($id){
        try{
            $checkUser = Pegawai::whereRaw('pegawais.id = ?',$id)
                                ->first();
            if(!$checkUser) abort(404, "User data is null or not found !");
            return $checkUser;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
     }

     public function createPegawai(array $data) {
        try{
            $create_data = Pegawai::create([
                'name'              => $data['name'], 
                'email'             => $data['email'],
                'password'          => $data['password'],
            ]);
            return $create_data;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
     }

     public function updatePegawai(int $id, array $data) {
        try{
            $update_data = Pegawai::whereRaw('id = ?',$id)->update([
                'name'          => $data['name'], 
                'motto'         => $data['motto'],
                'age'           => $data['age'],
                'password'      => $data['password'],
                'division_id'   => $data['division_id'],
            ]);
            
            return $update_data;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
     }

     public function deletePegawai(int $id) {
        try {
            $delete_data = Pegawai::whereRaw('id = ?',$id)->delete();
            return $delete_data;
        } catch(Throwable $e){
            ApiResponseClass::throw($e);
        }
     }
}