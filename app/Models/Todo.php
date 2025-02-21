<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Todo extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable=['title' , 'user_id','completed'];
    protected $dates = ['deleted_at'];

    //relationship with user table one:many
    public function user():BelongsTo
    {
        return $this->belongs(User::class,'user_id' , 'id');
    }
}
