<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Resources\PegawaiResource;
use App\Interfaces\PegawaiServiceInterface;
use Illuminate\Support\Facades\Hash;
use Throwable;

class PegawaiController extends Controller
{
    private PegawaiServiceInterface $pegawaiService;
    
    public function __construct(PegawaiServiceInterface $pegawaiService)
    {
        $this->pegawaiService = $pegawaiService;
    }

    public function index()
    {
        return response()->json(['message' => 'Menampilkan semua user']);
    }

    public function allPegawai(int $take, Request $request) {
        try{
            $query = [
                'take' => $take,
                'page' => $request->input('page')
            ];

            $data       = $this->pegawaiService->index($query);
            $meta       = $data['meta'];
            $status_code= 200;

            return ApiResponseClass::sendResponse(PegawaiResource::collection($data['items']),$meta,$status_code);
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function createPegawai(Request $request){
        try{
            $data = [
                'email'         => $request->input('email'),
                'name'          => $request->input('name'),
                'password'      => Hash::make($request->input('password'))
            ];
            $create = $this->pegawaiService->createPegawai($data);
            $result = $this->pegawaiService->checkPegawaiById($create['id']);

            $meta=[];
            $status_code=201;
            
            return ApiResponseClass::sendResponse(PegawaiResource::make($result),$meta,$status_code);
        } catch(Exception $e) {
            ApiResponseClass::throw($e, 'My custom error message',400);
        }
    }

    public function updatePegawai(Request $request){
        try{
            $data = [
                'email'         => $request->input('email'),
                'name'          => $request->input('name'),
                'password'      => Hash::make($request->input('password'))
            ];
            
            //Note :: result this query is 1 or undefined, i will make search again data by id
            $result     = $this->userRepositoryInterface->checPegawaiById($id);
            $updated    = $this->userRepositoryInterface->updatePegawai($id,$data);

            $meta=[];
            $status_code=200;


            $meta=[];
            $status_code=201;
            
            return ApiResponseClass::sendResponse(PegawaiResource::make($result),$meta,$status_code);
        } catch(Exception $e) {
            ApiResponseClass::throw($e, 'My custom error message',400);
        }
    }

    public function deletePegawai(Int $id){
        try{
            $check  = $this->pegawaService->checkPegawaiById($id);
            $result = $this->pegawaService->deletePegawai($id);
    
            $meta=[];
            $status_code=204;
    
            return ApiResponseClass::sendResponse(UserResource::make($result),$meta,$status_code);
            return '';
        } catch(Exception $e) {
            ApiResponseClass::throw($e, 'My custom error message',400);
        }
    }
}
