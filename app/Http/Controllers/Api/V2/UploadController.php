<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\UploadResource;
use App\Models\Upload;
use Auth;
use Illuminate\Http\Request;
use Image;
use Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {

        $request->validate([
            'file'  => 'required|mimes:png,jpg,pdf|max:2048',
            'kind' => 'required'
        ]);

        if ($request->hasFile('file') and !empty($request->file('file'))) {
            $upload = new Upload();
            $extension = strtolower($request->file('file')->getClientOriginalExtension());

            $upload->file_original_name = null;
            $arr = explode('.', $request->file('file')->getClientOriginalName());
            for ($i = 0; $i < count($arr) - 1; $i++) {
                if ($i == 0) {
                    $upload->file_original_name .= $arr[$i];
                } else {
                    $upload->file_original_name .= "." . $arr[$i];
                }
            }

            $path = $request->file('file')->store('uploads/all', 'local');
            $size = $request->file('file')->getSize();

            // Return MIME type ala mimetype extension
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            // Get the MIME type of the file
            $file_mime = finfo_file($finfo, base_path('public/') . $path);

            if (fileExtenstionType($extension) == 'image' && get_setting('disable_image_optimization') != 1) {
                try {
                    $img = Image::make($request->file('file')->getRealPath())->encode();
                    $height = $img->height();
                    $width = $img->width();
                    if ($width > $height && $width > 1500) {
                        $img->resize(1500, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif ($height > 1500) {
                        $img->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $img->save(base_path('public/') . $path);
                    clearstatcache();
                    $size = $img->filesize();
                } catch (\Exception $e) {
                    //dd($e);
                }
            }

            if (config('myevn.FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->put(
                    $path,
                    file_get_contents(base_path('public/') . $path),
                    [
                        'visibility' => 'public',
                        'ContentType' =>  $extension == 'svg' ? 'image/svg+xml' : $file_mime
                    ]
                );
                if ($arr[0] != 'updates') {
                    unlink(base_path('public/') . $path);
                }
            }

            $upload->extension = $extension;
            $upload->file_name = $path;
            $upload->user_id = Auth::user()->id;
            $upload->type = fileExtenstionType($upload->extension);
            $upload->file_size = $size;
            $upload->kind = $request->kind;
            $upload->save();
            $data = new UploadResource($upload);
            return $this->successResponse($data);
        } else {
            $msg = translate('Error while uploading image.');
            $this->errorResponse($msg);
        }
    }

    //Download project attachment
    public function file_info(Request $request)
    {
        $file = Upload::findOrFail($request['id']);

        return (auth()->user()->user_type == 'seller')
        ? view('seller.uploads.info', compact('file'))
        : view('backend.uploaded_files.info', compact('file'));
    }
}
