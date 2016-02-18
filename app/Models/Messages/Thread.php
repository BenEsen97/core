<?php

namespace App\Models\Messages;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Messages\Thread
 *
 * @property integer $thread_id
 * @property string $subject
 * @property boolean $read_only
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mship\Account[] $participants
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Messages\Thread\Post[] $posts
 */
class Thread extends \App\Models\aModel
{

    protected $table      = 'messages_thread';
    protected $primaryKey = "thread_id";
    protected $fillable   = ["subject", "read_only"];
    public    $dates      = ['created_at', 'updated_at'];
    public    $timestamps = true;

    public function participants(){
        return $this->belongsToMany(\App\Models\Mship\Account::class, "messages_thread_participant", "thread_id", "account_id")->withPivot("display_as", "read_at", "status")->withTimestamps();
    }

    public function posts(){
        return $this->hasMany(\App\Models\Messages\Thread\Post::class, "thread_id", "thread_id");
    }

}