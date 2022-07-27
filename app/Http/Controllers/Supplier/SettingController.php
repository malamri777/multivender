<?php

namespace App\Http\Controllers\Supplier;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Auth;

class SettingController extends Controller
{
    public function index()
    {
        $supplier = Supplier::find(Auth::user()->provider_id);
        return view('supplier.setting', compact('supplier'));
    }

    public function update(Request $request)
    {
        $supplier = Supplier::find($request->shop_id);

        if ($request->has('name') && $request->has('address')) {
            if ($request->has('shipping_cost')) {
                $supplier->shipping_cost = $request->shipping_cost;
            }

            $supplier->name             = $request->name;
            $supplier->address          = $request->address;
            $supplier->phone            = $request->phone;
            $supplier->slug             = preg_replace('/\s+/', '-', $request->name) . '-' . $supplier->id;
            $supplier->meta_title       = $request->meta_title;
            $supplier->meta_description = $request->meta_description;
            $supplier->logo             = $request->logo;
        }

        if ($request->has('delivery_pickup_longitude') && $request->has('delivery_pickup_latitude')) {

            $supplier->delivery_pickup_longitude    = $request->delivery_pickup_longitude;
            $supplier->delivery_pickup_latitude     = $request->delivery_pickup_latitude;
        } elseif (
            $request->has('facebook') ||
            $request->has('google') ||
            $request->has('twitter') ||
            $request->has('youtube') ||
            $request->has('instagram')
        ) {
            $supplier->facebook = $request->facebook;
            $supplier->instagram = $request->instagram;
            $supplier->google = $request->google;
            $supplier->twitter = $request->twitter;
            $supplier->youtube = $request->youtube;
        } else {
            $supplier->sliders = $request->sliders;
        }

        if ($supplier->save()) {
            flash(translate('Your Shop has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function verify_form ()
    {
        if (Auth::user()->supplier->verification_info == null) {
            $supplier = Auth::user()->supplier;
            return view('supplier.verify_form', compact('supplier'));
        } else {
            flash(translate('Sorry! You have sent verification request already.'))->error();
            return back();
        }
    }

    public function verify_form_store(Request $request)
    {
        $data = array();
        $i = 0;
        foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
            $item = array();
            if ($element->type == 'text') {
                $item['type'] = 'text';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'select' || $element->type == 'radio') {
                $item['type'] = 'select';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'multi_select') {
                $item['type'] = 'multi_select';
                $item['label'] = $element->label;
                $item['value'] = json_encode($request['element_' . $i]);
            } elseif ($element->type == 'file') {
                $item['type'] = 'file';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i]->store('uploads/verification_form');
            }
            array_push($data, $item);
            $i++;
        }
        $supplier = Auth::user()->supplier;
        $supplier->verification_info = json_encode($data);
        if ($supplier->save()) {
            flash(translate('Your supplier verification request has been submitted successfully!'))->success();
            return redirect()->route('supplier.dashboard');
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function show()
    {
    }
}
