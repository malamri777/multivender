<?php

namespace Database\Seeders;

use App\Models\OtpConfiguration;
use App\Models\SmsTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OTPTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SmsTemplate::insert([
            [
                'identifier' => 'phone_number_verification',
                'sms_body' => '[[code]] is your verification code for [[site_name]].',
                'status' => 1,
            ],
            [
                'identifier' => 'password_reset',
                'sms_body' => 'Your password reset code is [[code]].',
                'status' => 1,
            ],
            [
                'identifier' => 'order_placement',
                'sms_body' => 'Your order has been placed and Order Code is [[order_code]]',
                'status' => 1,
            ],
            [
                'identifier' => 'delivery_status_change',
                'sms_body' => 'Your delivery status has been updated to [[delivery_status]]  for Order code : [[order_code]]',
                'status' => 1,
            ],
            [
                'identifier' => 'payment_status_change',
                'sms_body' => 'Your payment status has been updated to [[payment_status]] for Order code : [[order_code]]',
                'status' => 1,
            ],
            [
                'identifier' => 'assign_delivery_boy',
                'sms_body' => 'You are assigned to deliver an order. Order code : [[order_code]]',
                'status' => 1,
            ],
        ]);

        OtpConfiguration::insert([
            [
                'type' => 'UNIFONIC',
                'value' => 1,
            ],
            [
                'type' => 'otp_for_order',
                'value' => 1,
            ],
            [
                'type' => 'otp_for_delivery_status',
                'value' => 1,
            ],
            [
                'type' => 'otp_for_paid_status',
                'value' => 1,
            ],
        ]);
    }
}
