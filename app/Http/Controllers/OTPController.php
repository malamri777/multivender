<?php

namespace App\Http\Controllers;

use App\Models\OtpConfiguration;
use Illuminate\Http\Request;
use Artisan;

class OTPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function configure_index()
    {
        return view('otp_systems.configurations.activation');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function credentials_index()
    {
        return view('otp_systems.configurations.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateActivationSettings(Request $request)
    {
        $business_settings = OtpConfiguration::where('type', $request->type)->first();
        if($business_settings!=null) {
            $business_settings->value = $request->value;
            $business_settings->save();
        } else {
            $business_settings = new OtpConfiguration;
            $business_settings->type = $request->type;
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        return '1';
    }

    /**
     * Update the specified resource in .env
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_credentials(Request $request)
    {
        foreach ($request->types as $key => $type) {
            if (!isset($request[$type])) {
                $this->overWriteEnvFile($type, "off");
            } else {
                $this->overWriteEnvFile($type, $request[$type]);
            }
        }

        flash("Settings updated successfully")->success();
        flash("If the value has not change, wait and refresh the page.")->warning();
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        sleep(3);
        return redirect()->route('admin.otp_credentials.index');
    }

    /**
    *.env file overwrite
    */
    public function overWriteEnvFile($type, $val)
    {
        $isInt = false;
        $path = base_path('.env');
        if (file_exists($path)) {
            if (intval($val)) {
                $val = $val;
                $isInt = true;
            } else {
                $val = '"' . trim($val) . '"';
            }

            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                if($isInt) {
                    file_put_contents($path, str_replace(
                        $type . '=' . config("myenv." . $type),
                        $type . '=' . $val,
                        file_get_contents($path)
                    ));
                } else {
                    file_put_contents($path, str_replace(
                        $type . '="' . config("myenv." . $type) . '"',
                        $type . '=' . $val,
                        file_get_contents($path)
                    ));
                }

            } else {
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
    }
}
