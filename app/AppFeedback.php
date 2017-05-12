<<<<<<< HEAD
<?php
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AppFeedback extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','feedback'];

    protected $updatable = ['user_id' => "", 'feedback' => ""];
}
=======
<?php
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AppFeedback extends Model
{
	use SoftDeletes;

    protected $fillable = ['user_id','feedback'];

    protected $updatable = ['user_id' => "", 'feedback' => ""];
}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2
