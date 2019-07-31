<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActions extends Model
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
    protected $table = 'rm_user_actions';

    /**
     * @var string
     */
    protected $primaryKey = 'root_id';

    /**
     * @var array
     */
    protected $fillable = [
        'root_id',
        'payload'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'root_id');
    }
}
