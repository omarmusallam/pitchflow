<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workspace extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'brand_name',
        'logo_path',
        'primary_color',
        'accent_color',
        'company_email',
        'company_phone',
        'company_website',
        'company_address',
        'company_city',
        'company_country',
        'email_signature',
        'proposal_footer',
        'default_validity_days',
        'show_branding_on_public_pages',
        'show_branding_on_pdf',
    ];

    protected $casts = [
        'show_branding_on_public_pages' => 'boolean',
        'show_branding_on_pdf' => 'boolean',
        'default_validity_days' => 'integer',
    ];
    
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
