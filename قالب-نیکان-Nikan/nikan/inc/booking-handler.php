<?php
/**
 * Nikan Clinic Appointment Booking Handler
 *
 * @package Nikan
 */

if (!defined('ABSPATH')) {
    exit;
}

class Nikan_Booking_Handler {

    public static function init() {
        add_action('wp_ajax_nikan_submit_booking', [__CLASS__, 'handle_booking']);
        add_action('wp_ajax_nopriv_nikan_submit_booking', [__CLASS__, 'handle_booking']);
    }

    public static function handle_booking() {
        check_ajax_referer('nikan_booking_nonce', 'security');

        $name       = isset($_POST['patient_name']) ? sanitize_text_field($_POST['patient_name']) : '';
        $phone      = isset($_POST['patient_phone']) ? sanitize_text_field($_POST['patient_phone']) : '';
        $doctor     = isset($_POST['doctor_id']) ? sanitize_text_field($_POST['doctor_id']) : '';
        $date       = isset($_POST['booking_date']) ? sanitize_text_field($_POST['booking_date']) : '';
        $time_slot  = isset($_POST['time_slot']) ? sanitize_text_field($_POST['time_slot']) : '';
        $notes      = isset($_POST['patient_notes']) ? sanitize_textarea_field($_POST['patient_notes']) : '';

        if (empty($name) || empty($phone) || empty($date) || empty($time_slot)) {
            wp_send_json_error(['message' => 'لطفاً تمامی فیلدهای الزامی را تکمیل نمایید.']);
        }

        // Validate Iranian Mobile Number
        if (!preg_match('/^09[0-9]{9}$/', $phone)) {
            wp_send_json_error(['message' => 'شماره موبایل وارد شده معتبر نمی‌باشد (مثال: 09123456789).']);
        }

        $tracking_code = 'NK-' . rand(100000, 999999);

        // Store appointment in WordPress post type or options
        $booking_data = [
            'tracking_code' => $tracking_code,
            'name'          => $name,
            'phone'         => $phone,
            'doctor'        => $doctor,
            'date'          => $date,
            'time'          => $time_slot,
            'notes'         => $notes,
            'created_at'    => current_time('mysql'),
            'status'        => 'confirmed'
        ];

        $all_bookings = get_option('nikan_all_bookings', []);
        $all_bookings[] = $booking_data;
        update_option('nikan_all_bookings', $all_bookings);

        // Trigger SMS Hook if enabled
        do_action('nikan_after_appointment_booked', $booking_data);

        wp_send_json_success([
            'message'       => 'نوبت شما با موفقیت ثبت شد!',
            'tracking_code' => $tracking_code,
            'doctor'        => $doctor,
            'date'          => $date,
            'time'          => $time_slot
        ]);
    }
}

Nikan_Booking_Handler::init();
