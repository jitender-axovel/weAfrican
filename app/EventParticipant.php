<<<<<<< HEAD
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    protected $fillable = ['user_id', 'event_id', ];

    public static $updatable = ['user_id' => "", 'event_id' => ""];
}
=======
<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    protected $fillable = ['user_id', 'event_id', ];

    public static $updatable = ['user_id' => "", 'event_id' => ""];

}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2
