<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    //
    public function uploadImage(Request $request,ImageUploadHandler $imageUploadHandler)
    {
        if ($file = $request->file('file')) {
            try {
                $result = $imageUploadHandler->save($file, 'quotes', 1);

            } catch (\Exception $exception) {
                return ['error' => $exception->getMessage()];
            }
            $data['filename'] = $result['path'];
        } else {
            $data['error'] = 'Error while uploading file';
        }
        return $data;
    }
}
