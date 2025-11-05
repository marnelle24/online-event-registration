<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Masmerise\Toaster\Toaster;

class ResetPasswordModal extends Component
{
    public $show = false;
    public $loading = false;
    public $user;
    public $password = '';
    public $password_confirmation = '';
    public $sendEmail = true;

    protected $listeners = [
        'callResetPasswordModal' => 'openModal',
    ];

    public function openModal($userId)
    {
        $this->loading = true;
        $this->show = true;
        
        try {
            $this->user = User::find($userId);
            
            if (!$this->user) {
                throw new \Exception('User not found');
            }
            
            $this->resetForm();
            $this->loading = false;
        } catch (\Exception $e) {
            $this->loading = false;
            $this->show = false;
            Toaster::error('Error loading user data: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->show = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->password = '';
        $this->password_confirmation = '';
        $this->sendEmail = true;
    }

    public function generatePassword()
    {
        // Generate a random password with 12 characters
        // Includes uppercase, lowercase, numbers, and special characters
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $special = '!@#$%^&*';
        
        $password = '';
        
        // Ensure at least one of each type
        $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
        $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
        $password .= $numbers[rand(0, strlen($numbers) - 1)];
        $password .= $special[rand(0, strlen($special) - 1)];
        
        // Fill the rest randomly
        $all = $uppercase . $lowercase . $numbers . $special;
        for ($i = strlen($password); $i < 12; $i++) {
            $password .= $all[rand(0, strlen($all) - 1)];
        }
        
        // Shuffle the password to randomize character positions
        $password = str_shuffle($password);
        
        $this->password = $password;
        $this->password_confirmation = $password;
    }

    public function resetPassword()
    {
        $validatedData = $this->validate([
            'password' => 'required|string|min:8|confirmed',
            'sendEmail' => 'boolean',
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        try {
            // Update user password
            $this->user->password = Hash::make($validatedData['password']);
            $this->user->save();

            // Send email if requested
            if ($this->sendEmail) {
                try {
                    Mail::to($this->user->email)->send(new PasswordResetMail($this->user, $validatedData['password']));
                    Toaster::success('Password reset and email sent successfully!');
                } catch (\Exception $e) {
                    \Log::error('Error sending password reset email: ' . $e->getMessage());
                    \Log::error('Email stack trace: ' . $e->getTraceAsString());
                    
                    // Provide more helpful error message
                    $errorMessage = $e->getMessage();
                    if (str_contains($errorMessage, '535') || str_contains($errorMessage, 'BadCredentials')) {
                        $errorMessage = 'Email authentication failed. Please check your Gmail App Password in .env file. Make sure you\'re using a 16-character App Password, not your regular Gmail password. See MAIL_CONFIGURATION.md for detailed instructions.';
                    } elseif (str_contains($errorMessage, 'Connection')) {
                        $errorMessage = 'Cannot connect to email server. Please check your MAIL_HOST and MAIL_PORT settings.';
                    }
                    
                    Toaster::warning('Password reset successfully, but email could not be sent. ' . $errorMessage);
                }
            } else {
                Toaster::success('Password reset successfully!');
            }

            \Log::info('Password reset for user ID: ' . $this->user->id . ' by admin ID: ' . auth()->id());

            $this->closeModal();
            $this->dispatch('passwordReset');
        } catch (\Exception $e) {
            \Log::error('Error resetting password: ' . $e->getMessage());
            Toaster::error('Error resetting password: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.user.reset-password-modal');
    }
}

