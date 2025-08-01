<?php

namespace App\Services;

use App\Repositories\NewEmployeeRepository;

class NewEmployeeService
{
    protected $newEmployeeRepository;

    public function __construct(NewEmployeeRepository $newEmployeeRepository){
        $this->newEmployeeRepository = $newEmployeeRepository;
    }


     public function create(array $data){
        return $this->newEmployeeRepository->create($data);
    }

    public function getById($id){
        return $this->newEmployeeRepository->find($id);
    }

      public function getAll(){
        return $this->newEmployeeRepository->all();
    }

    public function delete($id){
        return $this->newEmployeeRepository->delete($id);
    }

     public function update($id, array $data){
        return $this->newEmployeeRepository->update($id, $data);
    }

}