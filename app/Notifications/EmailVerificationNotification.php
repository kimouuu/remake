<?php

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;

class EmailVerificationNotification extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Generate a 6-digit random OTP code
        $otpCode = random_int(100000, 999999);

        // Hash the OTP code before storing it
        $hashedOtpCode = Hash::make($otpCode);

        // Save the hashed OTP code to the user record in the database
        $notifiable->update(['otp_code' => $hashedOtpCode, 'otp_type' => 'email']);

        // Build the mail message
        return (new MailMessage)
            ->subject(Lang::get('Verify Email Address'))
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(
                Lang::get('Verify Email Address'),
                url(route('verification.verify', ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]))
            )
            ->line(Lang::get('Your OTP code is: ' . $otpCode))
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }
}
