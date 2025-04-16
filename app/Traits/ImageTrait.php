<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Storage;

trait ImageTrait {

    public function verifyAndUpload($request, $fieldName = 'image', $directory = 'images' ) {

        if( $request[$fieldName]->isFile() ) {
            if (!$request[$fieldName]->isValid()) {
                toastr()->error(__('Invalid image!'));
                return redirect()->back();
            }
            return $request[$fieldName]->store($directory, 'public');
        }
        return null;
    }

    public function deleteFile($fileName = 'image')
    {
        try {
            if ($fileName) {
                Storage::disk('public')->delete($fileName);
            }
            return true;
        } catch (\Throwable $th) {
            /*report($th);
            return $th->getMessage();*/
            toastr()->error(__('Invalid image path!'));
            return redirect()->back();
        }
    }

}