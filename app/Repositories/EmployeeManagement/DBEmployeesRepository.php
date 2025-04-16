<?php

namespace App\Repositories\EmployeeManagement;

use App\RepositoryInterface\EmployeeRepositoryInterface;
use App\Models\EmployeeManagement\Employee;
use Illuminate\Support\Facades\Hash;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Gate;

class DBEmployeesRepository implements EmployeeRepositoryInterface
{
    use ImageTrait;

    public function getAll()
    {
        return Employee::with(['employeeType', 'branch', 'employeeNationality', 'employeeReligion', 'employeeMaritalStatus', 'employeeIdentityType', 'employeeCardIssuer'])
            ->select(['id', 'code', 'name', 'phone', 'mobile', 'identity_num', 'active', 'branch_id', 'setting_job_id'])
            ->whereNotNull('salary')
            ->get();
    }

    public function create(array $request)
    {
        $request['active'] = 0;
        $request['password'] = Hash::make('123456789');
        if (isset($request['image'])) {
            $request['image'] = $this->verifyAndUpload($request, 'image', 'employees');
        }
        $employee = Employee::create($request);
        return $employee;
    }

    public function findById($id)
    {
        return Employee::with(['employeeType', 'branch', 'employeeNationality', 'employeeReligion', 'employeeMaritalStatus', 'employeeIdentityType', 'employeeCardIssuer'])
            ->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $employee = $this->findById($id);
        if (isset($request['image'])) {
            if ($employee->getRawOriginal('image') != null) {
                $this->deleteFile('employees/' . $employee->getRawOriginal('image'));
            }
            $request['image'] = $this->verifyAndUpload($request, 'image', 'employees');
        }
        return $employee->update($request);
    }

    public function delete(int $id)
    {
        $employee = $this->findById($id);
        if ($employee->getRawOriginal('image') != null) {
            $this->deleteFile('employees/' . $employee->getRawOriginal('image'));
        }
        return $employee->delete();
    }
}