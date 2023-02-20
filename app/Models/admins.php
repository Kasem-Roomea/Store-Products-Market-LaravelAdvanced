<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use  App\Observers\adminObserve;

use App\Http\Controllers\Apis\Helper\helper ;

    class admins extends Authenticatable
{
    protected $table = 'admins';
    use Notifiable;
    public $timestamps=false,$guarded=[];
    
    
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
        parent::setAttribute($key, $value);
        }
    }

}
