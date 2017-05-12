<<<<<<< HEAD
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FcmUser extends Model
{
    protected $fillable = ['user_id', 'user_role_id', 'fcm_reg_id'];

    protected $updatable = ['user_id' => "", 'fcm_reg_id' => "", 'user_role_id' => ""];
}
=======
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FcmUser extends Model
{
    protected $fillable = ['user_id', 'user_role_id', 'fcm_reg_id'];

    protected $updatable = ['user_id' => "", 'fcm_reg_id' => "", 'user_role_id' => ""];
	

}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2
