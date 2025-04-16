<?php

namespace Modules\AdminRoleAuthModule\Repositories;
use Modules\AdminRoleAuthModule\RepositoryInterface\AdminRepositoryInterface;
use Modules\AdminRoleAuthModule\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Gate;

class DBAdminsRepository implements AdminRepositoryInterface
{
    use ImageTrait;

    public function getAll()
    {
        return Admin::with(['roles', 'branch', 'job'])
            ->select(['id', 'code', 'name', 'user_name', 'phone', 'active'])
            ->get();
    }

    public function create(array $request)
    {
        if ( !Gate::allows('create-admin', $request['role']) ) {
            toastr()->error(__('Not authorized for you to use this role.'));
            return false;
        }
        if (isset($request['image'])) 
            $request['image'] = $this->verifyAndUpload($request, 'image', 'admins');
        $request['password'] = Hash::make($request['password']);
        $admin = Admin::create($request);
        $admin->syncRoles($request['role']);
        return $admin;
    }

    public function findById($id)
    {
        return Admin::with(['roles', 'branch', 'job'])->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        if ( !Gate::allows('create-admin', $request['role']) ) {
            toastr()->error(__('Not authorized for you to use this role.'));
            return false;
        }
        $admin = $this->findById($id);
        if(isset($request['image'])) {
            if ($admin->getRawOriginal('image') != null)
                $this->deleteFile('admins/'.$admin->getRawOriginal('image'));
            $request['image'] = $this->verifyAndUpload($request, 'image', 'admins');
        }
        $request['password'] = $request['password']
            ? Hash::make($request['password'])
            : $admin->password;
        $admin->syncRoles($request['role']);
        return $admin->update($request);
    }

    public function delete(int $id)
    {
        if (auth()->guard('admin')->id() == $id)
            return false;
        $admin = $this->findById($id);
        if ($admin->getRawOriginal('image') != null) 
            $this->deleteFile('admins/'.$admin->getRawOriginal('image'));
        return $admin->delete();
    }

    public function active(int $id, string $value)
    {
        if (auth()->guard('admin')->id() == $id)
            return response()->json( array('type' => 'error', 'text' => __('You cannot deactivate your own account.')) );
        $admin = $this->findById($id);
        if (!$admin)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $admin->active = ($value == 'true') ? 1 : 0;
        $admin->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function updateAccount(array $request)
    {
        $admin = auth()->guard('admin')->user();
        if(isset($request['image'])) {
            if ($admin->getRawOriginal('image') != null)
                $this->deleteFile('admins/'.$admin->getRawOriginal('image'));
            $request['image'] = $this->verifyAndUpload($request, 'image', 'admins');
        }
        return $admin->update($request);
    }

    public function updatePassword(array $request)
    {
        $admin = auth()->guard('admin')->user();
        $hashedPassword = $admin->password;
        if (Hash::check($request['oldpassword'] , $hashedPassword )) {
            if (! Hash::check($request['password'] , $hashedPassword)) {
                $admin->password = Hash::make($request['password']);
                return $admin->save();
            } else{
                toastr()->error(__('New password can not be the old password!'));
                return false;
            }
    
        } else{
            toastr()->error(__('Old password does not matched.'));
            return false;
        }
    }
}
