<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProposalItem;
use App\Models\ProposalActivity;

class Proposal extends Model
{
    protected $fillable = [
        'workspace_id',
        'client_id',
        'title',
        'status',
        'intro_message',
        'valid_until',
        'subtotal',
        'discount',
        'total',
        'notes',
        'public_token',
        'sent_at',
        'follow_up_note',
        'followed_up_at',
        'follow_up_remind_at',
    ];

    protected function casts(): array
    {
        return [
            'valid_until' => 'date',
            'sent_at' => 'datetime',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'followed_up_at' => 'datetime',
            'follow_up_remind_at' => 'datetime',
            'valid_until' => 'datetime',
            'sent_at' => 'datetime',
        ];
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(ProposalSection::class)->orderBy('sort_order');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProposalItem::class)->orderBy('sort_order');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ProposalActivity::class)->latest();
    }
}
