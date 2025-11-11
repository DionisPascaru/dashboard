<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Organization.
 *
 * @property int $id
 * @property string $name
 * @property int owner_id
 * @property string|null $description
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $logo
 */
class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'description',
        'email',
        'phone',
        'address',
        'logo',
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'owner_id');
    }

    /**
     * @return HasMany
     */
    public function venues(): HasMany
    {
        return $this->hasMany(Venue::class);
    }
}
