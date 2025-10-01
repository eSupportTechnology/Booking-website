<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Partner;
use App\Models\User;
use App\Models\AdminSettings;
use App\Services\CommissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommissionServiceTest extends TestCase
{
    use RefreshDatabase;

    private CommissionService $commissionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commissionService = new CommissionService();
    }

    public function test_calculates_commission_with_global_rate()
    {
        // Create admin settings with global rate
        AdminSettings::create([
            'admin_id' => 1,
            'commission_rate' => 0.15
        ]);

        // Create partner without individual rate
        $user = User::factory()->create();
        $partner = Partner::create([
            'user_id' => $user->id,
            'first_name' => 'Test',
            'last_name' => 'Partner'
        ]);

        $bookingAmount = 1000.00;
        $commission = $this->commissionService->calculateCommission($partner, $bookingAmount);

        $this->assertEquals(150.00, $commission); // 15% of 1000
    }

    public function test_calculates_commission_with_individual_rate()
    {
        // Create admin settings with global rate
        AdminSettings::create([
            'admin_id' => 1,
            'commission_rate' => 0.15
        ]);

        // Create partner with individual rate
        $user = User::factory()->create();
        $partner = Partner::create([
            'user_id' => $user->id,
            'first_name' => 'Test',
            'last_name' => 'Partner'
        ]);

        // Set individual commission rate
        $this->commissionService->setPartnerCommissionRate($partner, 0.20);

        $bookingAmount = 1000.00;
        $commission = $this->commissionService->calculateCommission($partner, $bookingAmount);

        $this->assertEquals(200.00, $commission); // 20% of 1000
    }

    public function test_has_individual_rate_detection()
    {
        $user = User::factory()->create();
        $partner = Partner::create([
            'user_id' => $user->id,
            'first_name' => 'Test',
            'last_name' => 'Partner'
        ]);

        // Initially no individual rate
        $this->assertFalse($this->commissionService->hasIndividualRate($partner));

        // Set individual rate
        $this->commissionService->setPartnerCommissionRate($partner, 0.25);
        
        // Refresh partner to get updated settings
        $partner->refresh();
        $this->assertTrue($this->commissionService->hasIndividualRate($partner));
    }
}