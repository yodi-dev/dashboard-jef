<?php

namespace App\Services;

use App\Mail\NewBookingNotification;
use App\Models\Booking;
use App\Models\PhotographerProfile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingNotificationService
{
    /**
     * Dispatch dual-channel notifications (Email + WhatsApp) for a new booking.
     * Targets are dynamically retrieved from the Photographer Public Profile.
     */
    public function notify(Booking $booking): void
    {
        $profile = PhotographerProfile::first();

        // 1. Target recipients directly from Public Profile (with fallback)
        $targetEmail = $profile?->email ?: config('mail.admin_address', 'admin@jef.com');
        $targetPhone = $profile?->phone ?: config('services.whatsapp.admin_phone');

        // Channel 1: Email Notification to Public Profile Email
        $this->sendEmailNotification($booking, $targetEmail);

        // Channel 2: WhatsApp / Telegram Notification to Public Profile Phone
        if (!empty($targetPhone)) {
            $this->sendWhatsAppNotification($booking, $targetPhone);
        }
    }

    /**
     * Send email notification to photographer's public profile email.
     * Supports Resend API, Brevo API (via HTTPS Port 443 to bypass Render SMTP port blocks), and standard Laravel Mail.
     */
    protected function sendEmailNotification(Booking $booking, string $targetEmail): void
    {
        // 1. Resend HTTP API (HTTPS Port 443 - Bypasses Render free-tier SMTP port blocks)
        $resendKey = config('services.resend.key');
        if (!empty($resendKey)) {
            try {
                $html = (new NewBookingNotification($booking))->render();
                $fromAddress = config('mail.from.address', 'onboarding@resend.dev');
                $fromName = config('mail.from.name', 'Jef Lee Studio');

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $resendKey,
                    'Content-Type'  => 'application/json',
                ])->timeout(8)->post('https://api.resend.com/emails', [
                    'from'    => "{$fromName} <{$fromAddress}>",
                    'to'      => [$targetEmail],
                    'subject' => '! New Booking Request: ' . $booking->package,
                    'html'    => $html,
                ]);

                if ($response->successful()) {
                    return;
                }

                Log::warning('BookingNotificationService: Resend API returned error: ' . $response->body());
            } catch (\Throwable $e) {
                Log::warning('BookingNotificationService: Resend API failed: ' . $e->getMessage());
            }
        }

        // 2. Brevo HTTP API (HTTPS Port 443 - Bypasses Render free-tier SMTP port blocks)
        $brevoKey = config('services.brevo.key');
        if (!empty($brevoKey)) {
            try {
                $html = (new NewBookingNotification($booking))->render();
                $fromAddress = config('mail.from.address', 'no-reply@dashboard.jef.com');
                $fromName = config('mail.from.name', 'Jef Lee Studio');

                $response = Http::withHeaders([
                    'api-key'      => $brevoKey,
                    'Content-Type' => 'application/json',
                ])->timeout(8)->post('https://api.brevo.com/v3/smtp/email', [
                    'sender'      => ['name' => $fromName, 'email' => $fromAddress],
                    'to'          => [['email' => $targetEmail]],
                    'subject'     => '! New Booking Request: ' . $booking->package,
                    'htmlContent' => $html,
                ]);

                if ($response->successful()) {
                    return;
                }

                Log::warning('BookingNotificationService: Brevo API returned error: ' . $response->body());
            } catch (\Throwable $e) {
                Log::warning('BookingNotificationService: Brevo API failed: ' . $e->getMessage());
            }
        }

        // 3. Fallback to Standard Laravel Mailer (SMTP / Log / Sendmail)
        try {
            Mail::to($targetEmail)->send(new NewBookingNotification($booking));
        } catch (\Throwable $e) {
            Log::warning('BookingNotificationService: Failed to send booking email notification: ' . $e->getMessage(), [
                'booking_id'   => $booking->id,
                'target_email' => $targetEmail,
            ]);
        }
    }

    /**
     * Send WhatsApp notification to photographer's public profile phone.
     * Supports Fonnte, CallMeBot, and Telegram fallback.
     */
    protected function sendWhatsAppNotification(Booking $booking, string $targetPhone): void
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $targetPhone);
        if (str_starts_with($cleanPhone, '08')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $clientCleanPhone = preg_replace('/[^0-9]/', '', $booking->phone);
        $clientWaLink = 'https://wa.me/' . $clientCleanPhone;
        $dashboardUrl = route('admin.bookings.edit', $booking->id);

        $message = "📸 *NEW BOOKING INQUIRY - Jef Lee Studio*\n"
            . "━━━━━━━━━━━━━━━━━━━━━━\n"
            . "👤 *Client:* {$booking->name}\n"
            . "📧 *Email:* {$booking->email}\n"
            . "📱 *Phone:* {$booking->phone}\n"
            . "📦 *Package:* {$booking->package}\n"
            . "📍 *Location:* {$booking->location}\n"
            . "📅 *Date:* " . $booking->booking_date->format('l, d F Y - H:i') . "\n\n"
            . "💬 *Client Notes:*\n\"" . ($booking->message ?: 'No additional notes.') . "\"\n"
            . "━━━━━━━━━━━━━━━━━━━━━━\n"
            . "👉 *Chat Client via WA:*\n{$clientWaLink}\n\n"
            . "👉 *Open Admin Dashboard:*\n{$dashboardUrl}";

        try {
            // Option A: Fonnte Gateway (Indonesian / Global WA Gateway)
            $fonnteToken = config('services.fonnte.token');
            if (!empty($fonnteToken)) {
                Http::withHeaders([
                    'Authorization' => $fonnteToken,
                ])->timeout(8)->post('https://api.fonnte.com/send', [
                    'target'  => $cleanPhone,
                    'message' => $message,
                ]);
                return;
            }

            // Option B: CallMeBot Personal WhatsApp API (Free)
            $callmebotApiKey = config('services.callmebot.api_key');
            if (!empty($callmebotApiKey)) {
                Http::timeout(8)->get('https://api.callmebot.com/whatsapp.php', [
                    'phone'  => '+' . $cleanPhone,
                    'text'   => $message,
                    'apikey' => $callmebotApiKey,
                ]);
                return;
            }

            // Option C: Telegram Bot Notification (Zero-budget fallback)
            $telegramToken = config('services.telegram.bot_token');
            $telegramChatId = config('services.telegram.chat_id');
            if (!empty($telegramToken) && !empty($telegramChatId)) {
                Http::timeout(8)->post("https://api.telegram.org/bot{$telegramToken}/sendMessage", [
                    'chat_id'    => $telegramChatId,
                    'text'       => $message,
                    'parse_mode' => 'Markdown',
                ]);
                return;
            }

            // Log notification when no provider token is set in environment
            Log::info("BookingNotificationService: WhatsApp notification generated for {$cleanPhone}", [
                'booking_id' => $booking->id,
                'preview'    => substr($message, 0, 100),
            ]);
        } catch (\Throwable $e) {
            Log::warning('BookingNotificationService: Failed to dispatch WhatsApp notification: ' . $e->getMessage(), [
                'booking_id'   => $booking->id,
                'target_phone' => $cleanPhone,
            ]);
        }
    }
}
