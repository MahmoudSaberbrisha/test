<?php

namespace Modules\AdminRoleAuthModule\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Modules\AdminRoleAuthModule\RepositoryInterface\SettingsRepositoryInterface;
use Modules\AdminRoleAuthModule\Models\Admin;
use App\Models\Teacher;
use App\Models\Student;

class FirebaseForgetPassword extends Component
{
    public $phone = null;
    public $otp = null;
    public $firebaseSettings = null;
    public bool $phoneSection = true;
    public bool $codeSection = false;
    public bool $resetSection = false;

    public function mount()
    {
        $settingsRepository = App::make(SettingsRepositoryInterface::class);
        $firebaseSettings = $settingsRepository->getSettingsByKey('firebase_settings');
        if ($firebaseSettings)
            $this->firebaseSettings = $firebaseSettings->getProcessedValue();
    }

    public function checkPhoneNumber()
    {
        if (empty($this->firebaseSettings) || count(array_filter($this->firebaseSettings)) != count($this->firebaseSettings)) 
            return $this->alertMessage(__('Firebase settings does not exist, please contact the admin.'), 'error', __('error'));
        if ($this->phone) {
            $user = (Admin::where('phone', $this->phone)->first() ?? Teacher::where('phone', $this->phone)->first()) ?? Student::where('phone', $this->phone)->first();
            if (!$user)
                return $this->alertMessage(__('This phone does not match any exists record.'), 'error', __('error'));
            $phone = '+2'.$this->phone;
            return $this->dispatch('sendOTP', $phone);
        }
        return $this->alertMessage(__('Phone number is required.'), 'error', __('error'));
    }

    #[On('alertMessage')]
    public function alertMessage($message, $type, $title)
    {
        $this->dispatch('alert', [
            'type' => $type, 
            'message' => $message,
            'title' => $title
        ]);
    }

    #[On('showCodeForm')]
    public function showCodeForm()
    {
        $this->phoneSection = false;
        $this->codeSection = true;
    }

    #[On('showResetForm')]
    public function showResetForm()
    {
        $this->codeSection = false;
        $this->resetSection = true;
    }

    public function checkOtpCode()
    {
        $this->dispatch('verifyOTP', $this->otp);
    }

	public function render(): View
	{
		return view('adminroleauthmodule::livewire.firebase-forget-password');
	}

}
