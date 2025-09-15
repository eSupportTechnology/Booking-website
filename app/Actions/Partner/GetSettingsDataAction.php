<?php

namespace App\Actions\Partner;

use App\Services\Partner\SettingsService;

class GetSettingsDataAction
{
    public function __construct(
        private SettingsService $settingsService
    ) {}

    public function execute(): array
    {
        return [
            'profile' => $this->settingsService->getProfile(),
            'notifications' => $this->settingsService->getNotificationSettings(),
            'security' => $this->settingsService->getSecuritySettings(),
            'payout' => $this->settingsService->getPayoutSettings()
        ];
    }
}