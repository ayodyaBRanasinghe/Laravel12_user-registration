<?php

namespace App\Repositories;
use App\Models\NewEmployee;

class NewEmployeeRepository {

    public function create(array $data){

        return NewEmployee::create($data);
    }

     public function find($id){

        //Employee::where('id','=',$id)->first();
        return NewEmployee::findOrFail($id);
    }

    public function all(){

        return NewEmployee::all();
    }


      public function delete($id){

        $employee = NewEmployee::findOrFail($id);
        return $employee->delete();
    }

    
     public function update($id, array $data)
    {
        $employee = NewEmployee::findOrFail($id);
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $employee->update($data);
        return $employee;
    }


}