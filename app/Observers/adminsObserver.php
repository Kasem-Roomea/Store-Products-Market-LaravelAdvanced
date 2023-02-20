<?php
namespace App\Observers;

use App\Models\admins;

class adminsObserver
{
    public $afterCommit = true;
    public function created(admins $admins)
    {
        //
    }
    public function updating(admins $admin)
    {
        if(!$admin->password){
            unset($admin->password);
        }else{
            $admin->password= bcrypt($admin->password);
        }
    }
    public function updated(admins $admins)
    {
        // dd('updated');
    }
    
    
}
