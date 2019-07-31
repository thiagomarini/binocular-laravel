<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEvent extends Model
{
    /**
     * PK should not increment
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     **/
    protected $table = 'user_events';

    /**
     * @var string
     */
    protected $primaryKey = 'root_id';

    /**
     * @var array
     */
    protected $fillable = [
        'root_id',
        'serialised',
        'projection_snapshot',
        'created_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'root_id');
    }
}
