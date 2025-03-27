<?php

namespace App\Interfaces;

interface PegawaiServiceInterface
{
    public function index(array $query);
    public function checkPegawai(array $data);
    public function checkPegawaiById($id);
    public function createPegawai(array $data);
    public function updatePegawai(int $id,array $data);
    public function deletePegawai(int $id);
}