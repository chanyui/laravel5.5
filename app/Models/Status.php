<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //允许更新字段
    protected $fillable = ['content'];

    /**
     * 一条微博属于一个用户
     * +-----------------------------------------------------------
     * @functionName : user
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class );
    }
}
