<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

class CarRenter extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'car_renters';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'email',
        'password',
        'account_type',
        'company_name',
        'business_reg_no',
        'company_logo',
        'full_name',
        'nic_number',
        'phone',
        'country_code',
        'address',
    ];

    /**
     * Attributes hidden from arrays/json
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
   protected $casts = [
    'email' => 'string', 
 ];

    /**
     * Mutator for password hashing automatically
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /**
     * Helper to check if renter is a company
     */
    public function isCompany(): bool
    {
        return $this->account_type === 'company';
    }

    /**
     * Helper to check if renter is an individual
     */
    public function isIndividual(): bool
    {
        return $this->account_type === 'individual';
    }
}

