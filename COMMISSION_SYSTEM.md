# Commission System Documentation

## Overview

The commission system allows administrators to manage commission rates for partners in the booking platform. It supports both global and individual commission rates.

## Features

### Global Commission Rate
- Set a default commission rate that applies to all partners
- Managed through Admin Settings → Commission tab
- Default rate: 15% (0.15)

### Individual Partner Commission Rates
- Override the global rate for specific partners
- Managed through Admin Settings → Commission → Manage Partner Rates
- Individual rates take precedence over the global rate

## Database Structure

### AdminSettings Table
- `commission_rate` (decimal): Global commission rate

### PartnerSettings Table
- `commission_rate` (decimal, nullable): Individual partner commission rate

## Usage

### Admin Panel Access
1. Navigate to Admin Settings
2. Click on the "Commission" tab
3. Update global rate or click "Manage Partner Rates"

### Setting Individual Rates
1. Go to Commission Management page
2. Click "Set Individual" or "Edit" for a partner
3. Enter the commission rate as a decimal (e.g., 0.20 for 20%)
4. Save the changes

### Removing Individual Rates
1. Click "Remove" next to a partner with an individual rate
2. The partner will revert to using the global rate

## API Usage

### CommissionService Methods

```php
use App\Services\CommissionService;

$commissionService = new CommissionService();

// Calculate commission for a booking
$commission = $commissionService->calculateCommission($partner, $bookingAmount);

// Get effective commission rate for a partner
$rate = $commissionService->getCommissionRate($partner);

// Check if partner has individual rate
$hasIndividual = $commissionService->hasIndividualRate($partner);

// Set individual rate
$commissionService->setPartnerCommissionRate($partner, 0.20);

// Remove individual rate
$commissionService->removePartnerCommissionRate($partner);
```

### Partner Model Methods

```php
// Get effective commission rate (individual or global)
$rate = $partner->getEffectiveCommissionRate();
```

## Migration Commands

```bash
# Run the migration to add commission rate to partner settings
php artisan migrate

# Seed default global commission rate
php artisan db:seed --class=GlobalCommissionRateSeeder
```

## Testing

Run the commission system tests:

```bash
php artisan test --filter=CommissionServiceTest
```

## File Structure

- `app/Models/AdminSettings.php` - Global commission rate storage
- `app/Models/PartnerSettings.php` - Individual commission rate storage
- `app/Models/Partner.php` - Commission rate calculation methods
- `app/Services/CommissionService.php` - Commission business logic
- `app/Http/Controllers/Admin/PartnerCommissionController.php` - Admin panel controller
- `resources/views/admin/commission/index.blade.php` - Commission management UI
- `database/migrations/*_add_commission_rate_to_partner_settings_table.php` - Database migration
- `database/seeders/GlobalCommissionRateSeeder.php` - Default rate seeder