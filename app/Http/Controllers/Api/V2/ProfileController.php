<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\City;
use App\Models\Country;
use App\Http\Resources\V2\AddressCollection;
use App\Models\Address;
use App\Http\Resources\V2\CitiesCollection;
use App\Http\Resources\V2\CountriesCollection;
use App\Http\Resources\V2\UploadResource;
use App\Models\Order;
use App\Models\Upload;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\Cart;
use Auth;
use Hash;
use Illuminate\Support\Facades\File;
use Image;
use Storage;

class ProfileController extends Controller
{
    public function counters()
    {
        return response()->json([
            'cart_item_count' => Cart::where('user_id', auth()->user()->id)->count(),
            'wishlist_item_count' => Wishlist::where('user_id', auth()->user()->id)->count(),
            'order_count' => Order::where('user_id', auth()->user()->id)->count(),
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if(!$user){
            return response()->json([
                'result' => false,
                'message' => translate("User not found.")
            ]);
        }
        $user->name = $request->name;

        if ($request->password != "") {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'result' => true,
            'message' => translate("Profile information updated")
        ]);
    }

    public function update_device_token(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if(!$user){
            return response()->json([
                'result' => false,
                'message' => translate("User not found.")
            ]);
        }

        $user->device_token = $request->device_token;


        $user->save();

        return response()->json([
            'result' => true,
            'message' => translate("device token updated")
        ]);
    }

    public function updateImage(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if(!$user){
            return response()->json([
                'result' => false,
                'message' => translate("User not found."),
                'path' => ""
            ]);
        }

        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
        );

        try {
            $image = $request->image;
            $request->filename;
            $realImage = base64_decode($image);

            $dir = public_path('uploads/all');
            $full_path = "$dir/$request->filename";

            $file_put = file_put_contents($full_path, $realImage); // int or false

            if ($file_put == false) {
                return response()->json([
                    'result' => false,
                    'message' => "File uploading error",
                    'path' => ""
                ]);
            }


            $upload = new Upload;
            $extension = strtolower(File::extension($full_path));
            $size = File::size($full_path);

            if (!isset($type[$extension])) {
                unlink($full_path);
                return response()->json([
                    'result' => false,
                    'message' => "Only image can be uploaded",
                    'path' => ""
                ]);
            }


            $upload->file_original_name = null;
            $arr = explode('.', File::name($full_path));
            for ($i = 0; $i < count($arr) - 1; $i++) {
                if ($i == 0) {
                    $upload->file_original_name .= $arr[$i];
                } else {
                    $upload->file_original_name .= "." . $arr[$i];
                }
            }

            //unlink and upload again with new name
            unlink($full_path);
            $newFileName = rand(10000000000, 9999999999) . date("YmdHis") . "." . $extension;
            $newFullPath = "$dir/$newFileName";

            $file_put = file_put_contents($newFullPath, $realImage);

            if ($file_put == false) {
                return response()->json([
                    'result' => false,
                    'message' => "Uploading error",
                    'path' => ""
                ]);
            }

            $newPath = "uploads/all/$newFileName";

            if (config('myenv.FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->put($newPath, file_get_contents(base_path('public/') . $newPath));
                unlink(base_path('public/') . $newPath);
            }

            $upload->extension = $extension;
            $upload->file_name = $newPath;
            $upload->user_id = $user->id;
            $upload->type = $type[$upload->extension];
            $upload->file_size = $size;
            $upload->save();

            $user->avatar_original = $upload->id;
            $user->save();



            return response()->json([
                'result' => true,
                'message' => translate("Image updated"),
                'path' => uploaded_asset($upload->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'path' => ""
            ]);
        }
    }

    // not user profile image but any other base 64 image through uploader
    public function imageUpload(Request $request)
    {
        $request->validate([
            'image'  => 'required|mimes:png,jpg,pdf|max:2048'
        ]);

        $user = User::find(Auth::id());
        if(!$user){
            return response()->json([
                'result' => false,
                'message' => translate("User not found."),
                'path' => "",
                'upload_id' => 0
            ]);
        }

        if ($request->hasFile('image') and !empty($request->file('image'))) {
            $upload = new Upload();
            $extension = strtolower($request->file('image')->getClientOriginalExtension());

            $upload->file_original_name = null;
            $arr = explode('.', $request->file('image')->getClientOriginalName());
            for ($i = 0; $i < count($arr) - 1; $i++) {
                if ($i == 0) {
                    $upload->file_original_name .= $arr[$i];
                } else {
                    $upload->file_original_name .= "." . $arr[$i];
                }
            }

            $path = $request->file('image')->store('uploads/all/profile', 'local');

            $size = $request->file('image')->getSize();

            // Return MIME type ala mimetype extension
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            // Get the MIME type of the file
            $file_mime = finfo_file($finfo, base_path('public/') . $path);

            if (fileExtenstionType($extension) == 'image' && get_setting('disable_image_optimization') != 1) {
                try {
                    $img = Image::make($request->file('image')->getRealPath())->encode();
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
            $upload->save();
            $user->avatar = $upload->id;
            $user->save();
            $data = new UploadResource($upload);
            return $this->successResponse($data);
        } else {
            $msg = translate('Error while uploading image.');
            $this->errorResponse($msg);
        }
    }

    public function checkIfPhoneAndEmailAvailable()
    {


        $phone_available = false;
        $email_available = false;
        $phone_available_message = translate("User phone number not found");
        $email_available_message = translate("User email  not found");

        $user = User::find(auth()->user()->id);

        if ($user->phone != null || $user->phone != "") {
            $phone_available = true;
            $phone_available_message = translate("User phone number found");
        }

        if ($user->email != null || $user->email != "") {
            $email_available = true;
            $email_available_message = translate("User email found");
        }
        return response()->json(
            [
                'phone_available' => $phone_available,
                'email_available' => $email_available,
                'phone_available_message' => $phone_available_message,
                'email_available_message' => $email_available_message,
            ]
        );
    }
}
