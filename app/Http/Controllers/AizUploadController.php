<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Response;
use Auth;
use Storage;
use Image;

class AizUploadController extends Controller
{


    public function index(Request $request){

        $search = null;
        $sort_by = null;
        $folder_id = null;
        if (Auth::user()->hasRole(adminRolesList()) and Auth::user()->hasPermission('admin_uploads-read')) {
            $all_uploads = Upload::query()->roleType(Upload::ROLE_TYPE['admin']);
            if ($request->folder_id != null) {
                $all_uploads = $all_uploads->where('folder_id', $request->folder_id ?? 1);
            } else {
                $all_uploads = $all_uploads->where('folder_id', 1);
            }
        } else if (Auth::user()->hasRole(supplierRolesList()) and Auth::user()->hasPermission('supplier_uploads-read')) {
            $all_uploads = Upload::roleType(Upload::ROLE_TYPE['supplier']);

            $parentFolderId = $request->folder_id ?? Auth::user()->supplier->parent_folder_id;
            $all_uploads = $all_uploads->where('folder_id', $parentFolderId);
        }

        if ($request->search != null) {
            $search = $request->search;
            $all_uploads = $all_uploads->where('file_original_name', 'like', '%'.$request->search.'%');
        }

        $all_uploads = $all_uploads->orderBy('order')->orderBy('folder_name');
        $sort_by = $request->sort;
        switch ($request->sort) {
            case 'newest':
                $all_uploads->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $all_uploads->orderBy('created_at', 'asc');
                break;
            case 'smallest':
                $all_uploads->orderBy('file_size', 'asc');
                break;
            case 'largest':
                $all_uploads->orderBy('file_size', 'desc');
                break;
            default:
                $all_uploads->orderBy('created_at', 'desc');
                break;
        }

        $all_uploads = $all_uploads->paginate(60)->appends(request()->query());

        if (Auth::user()->hasRole(adminRolesList()) and Auth::user()->hasPermission('admin_uploads-read')) {
            return view('backend.uploaded_files.index', compact('all_uploads', 'search', 'sort_by', 'folder_id'));
        } elseif (Auth::user()->hasRole(supplierRolesList()) and Auth::user()->hasPermission('supplier_uploads-read')) {
            return view('supplier.uploads.index', compact('all_uploads', 'search', 'sort_by', 'folder_id'));
        } else {
            abort(403);
        }
    }

    public function create(){
        if (Auth::user()->hasRole(adminRolesList()) and Auth::user()->hasPermission('admin_uploads-create')) {
            return view('backend.uploaded_files.create');
        } else if (Auth::user()->hasRole(supplierRolesList()) and Auth::user()->hasPermission('supplier_uploads-create')) {
            return view('supplier.uploads.create');
        } else {
            abort(403);
        }
    }

    public function createFolder(Request $request)
    {
        $upload = new Upload();
        if (Auth::user()->hasRole(adminRolesList()) and Auth::user()->hasPermission('admin_uploads-create')) {
            $upload->folder_id = $request->folder_id ?? 1;
            $upload->role_type = Upload::ROLE_TYPE['admin'];
        } else if (Auth::user()->hasRole(supplierRolesList()) and Auth::user()->hasPermission('supplier_uploads-create')) {
            $upload->folder_id = $request->folder_id ?? Auth::user()->supplier->parent_folder_id;
            $upload->role_type = Upload::ROLE_TYPE['supplier'];
        } else {
            return response()->json([
                'result' => false,
                'message' => translate('You Could not upload file'),
            ], 401);
        }

        $upload->folder_name = $request->name;
        $upload->type = 'folder';
        $upload->save();

        return response()->json([
            'result' => true,
            'message' => translate('Folder Created'),
        ], 200);
    }

    public function show_uploader(Request $request){
        return view('uploader.aiz-uploader');
    }

    public function upload(Request $request){
        $type = array(
            "jpg"=>"image",
            "jpeg"=>"image",
            "png"=>"image",
            "svg"=>"image",
            "webp"=>"image",
            "gif"=>"image",
            "mp4"=>"video",
            "mpg"=>"video",
            "mpeg"=>"video",
            "webm"=>"video",
            "ogg"=>"video",
            "avi"=>"video",
            "mov"=>"video",
            "flv"=>"video",
            "swf"=>"video",
            "mkv"=>"video",
            "wmv"=>"video",
            "wma"=>"audio",
            "aac"=>"audio",
            "wav"=>"audio",
            "mp3"=>"audio",
            "zip"=>"archive",
            "rar"=>"archive",
            "7z"=>"archive",
            "doc"=>"document",
            "txt"=>"document",
            "docx"=>"document",
            "pdf"=>"document",
            "csv"=>"document",
            "xml"=>"document",
            "ods"=>"document",
            "xlr"=>"document",
            "xls"=>"document",
            "xlsx"=>"document"
        );


        if($request->hasFile('aiz_file')){
            $upload = new Upload;
            $extension = strtolower($request->file('aiz_file')->getClientOriginalExtension());

            if(isset($type[$extension])){
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('aiz_file')->getClientOriginalName());
                for($i=0; $i < count($arr)-1; $i++){
                    if($i == 0){
                        $upload->file_original_name .= $arr[$i];
                    }
                    else{
                        $upload->file_original_name .= ".".$arr[$i];
                    }
                }

                if($request->folder_id) {
                    $folder = Upload::find($request->folder_id);
                    $folderPath = $folder->folder_name;
                    $folderTemp = $folder;
                    while($folderTemp->parent) {
                        $folderPath = $folderTemp->parent->folder_name . "/" . $folderPath;
                        $folderTemp = $folderTemp->parent;
                    }
                    $path = $request->file('aiz_file')->store('uploads/all/' . $folderPath, 'local');
                } else {
                    $path = $request->file('aiz_file')->store('uploads/all', 'local');
                }

                $size = $request->file('aiz_file')->getSize();

                // Return MIME type ala mimetype extension
                $finfo = finfo_open(FILEINFO_MIME_TYPE);

                // Get the MIME type of the file
                $file_mime = finfo_file($finfo, base_path('public/').$path);

                if($type[$extension] == 'image' && get_setting('disable_image_optimization') != 1){
                    try {
                        $img = Image::make($request->file('aiz_file')->getRealPath())->encode();
                        $height = $img->height();
                        $width = $img->width();
                        if($width > $height && $width > 1500){
                            $img->resize(1500, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        } elseif ($height > 1500) {
                            $img->resize(null, 800, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                        $img->save(base_path('public/').$path);
                        clearstatcache();
                        $size = $img->filesize();

                    } catch (\Exception $e) {
                        //dd($e);
                    }
                }

                if (env('FILESYSTEM_DRIVER') == 's3') {
                    Storage::disk('s3-public')->put(
                        $path,
                        file_get_contents(base_path('public/').$path),
                        [
                            'ContentType' =>  $extension == 'svg' ? 'image/svg+xml' : $file_mime
                        ]
                    );
                    if($arr[0] != 'updates') {
                        unlink(base_path('public/').$path);
                    }
                }

                if (Auth::user()->hasRole(adminRolesList()) and Auth::user()->hasPermission('admin_uploads-create')) {
                    $upload->folder_id = $request->folder_id ?? 1;
                    $upload->role_type = Upload::ROLE_TYPE['admin'];
                } else if (Auth::user()->hasRole(supplierRolesList()) and Auth::user()->hasPermission('supplier_uploads-create')) {
                    $upload->folder_id = $request->folder_id ?? Auth::user()->supplier->parent_folder_id;
                    $upload->role_type = Upload::ROLE_TYPE['supplier'];
                } else {
                    return response()->json([
                        'result' => false,
                        'message' => translate('You Could not upload file'),
                    ], 401);
                }

                $upload->extension = $extension;
                $upload->file_name = $path;
                $upload->user_id = Auth::user()->id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                $upload->save();
            }
            return '{}';
        }
    }

    public function get_uploaded_files(Request $request)
    {
        $parentFolderId = null;
        if (Auth::user()->hasRole(adminRolesList())) {
            $uploads = Upload::query();
        } else if (Auth::user()->hasRole(supplierRolesList())) {
            $uploads = Upload::where('user_id', auth()->user()->id);
        }

        $uploads = $uploads->with(['parent:id']);

        if ($request->folder_id != null) {
            $parentFolderId = Upload::with('parent')->find($request->folder_id)->parent?->id;
            $uploads = $uploads->where('folder_id', $request->folder_id);
        } else {
            $uploads = $uploads->where('folder_id', 1);
        }

        if ($request->search != null) {
            $uploads = $uploads->where('file_original_name', 'like', '%'.$request->search.'%');
        }

        $uploads = $uploads->orderBy('order')->orderBy('folder_name');
        if ($request->sort != null) {
            switch ($request->sort) {
                case 'newest':
                    $uploads->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $uploads->orderBy('created_at', 'asc');
                    break;
                case 'smallest':
                    $uploads->orderBy('file_size', 'asc');
                    break;
                case 'largest':
                    $uploads->orderBy('file_size', 'desc');
                    break;
                default:
                    $uploads->orderBy('created_at', 'desc');
                    break;
            }
        }
        return [
            'uploads' => $uploads->paginate(60)->appends(request()->query()),
            'parentId' => $parentFolderId
        ];
    }

    public function destroy(Request $request,$id)
    {
        $upload = Upload::findOrFail($id);

        if(Auth::check() and Auth::user()->hasPermission('supplier_uploads-delete') && $upload->user_id != Auth::user()->id){
            flash(translate("You don't have permission for deleting this!"))->error();
            return back();
        }

        try {
            if(env('FILESYSTEM_DRIVER') == 's3'){
                Storage::disk('s3')->delete($upload->file_name);
                if (file_exists(public_path().'/'.$upload->file_name)) {
                    unlink(public_path().'/'.$upload->file_name);
                }
            } else {
                unlink(public_path().'/'.$upload->file_name);
            }
            $upload->delete();
            flash(translate('File deleted successfully'))->success();
        } catch(\Exception $e) {
            $upload->delete();
            flash(translate('File deleted successfully'))->success();
        }
        return back();
    }

    public function get_preview_files(Request $request){
        $ids = explode(',', $request->ids);
        $files = Upload::whereIn('id', $ids)->get();
        $new_file_array = [];
        foreach($files as $file){
            $file['file_name'] = my_asset($file->file_name);
            if($file->external_link) {
                $file['file_name'] = $file->external_link;
            }
            $new_file_array[] = $file;
        }
        // dd($new_file_array);
        return $new_file_array;
        // return $files;
    }

    //Download project attachment
    public function attachment_download($id)
    {
        $project_attachment = Upload::find($id);
        try {
           $file_path = public_path($project_attachment->file_name);
            return Response::download($file_path);
        } catch(\Exception $e) {
            flash(translate('File does not exist!'))->error();
            return back();
        }

    }

    //Download project attachment
    public function file_info(Request $request)
    {
        $file = Upload::findOrFail($request['id']);

        if(Auth::check() and Auth::user()->hasRole(adminRolesList())) {
            return view('backend.uploaded_files.info',compact('file'));
        } else if (Auth::check() and Auth::user()->hasRole(adminRolesList())) {
            return view('supplier.uploads.info', compact('file'));
        } else {
            abort(404);
        }
    }

}
