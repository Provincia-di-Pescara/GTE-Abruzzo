<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RoadworkSeverity;
use App\Enums\RoadworkStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Roadwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_id',
        'title',
        'geometry',
        'valid_from',
        'valid_to',
        'severity',
        'status',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'valid_from' => 'date',
            'valid_to' => 'date',
            'severity' => RoadworkSeverity::class,
            'status' => RoadworkStatus::class,
        ];
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }
}
