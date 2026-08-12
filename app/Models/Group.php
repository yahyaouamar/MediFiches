<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    protected $table = 'group';
    protected $primaryKey = 'name';
    protected $keyType = 'string';
    
    protected $fillable = [
        'name',
    ];

    public static function createGroup($data)
    {
        DB::table('group')->insert($data);
    }
    public static function deleteGroup($groupName)
    {
        $group = self::find($groupName);
        if ($group) {
            $group->delete();
            return true;
        }
        return false;
    }
    public static function editGroup($originalName, $newName)
    {
        $group = self::find($originalName);
        if ($group) {
            $group->name = $newName;
            $group->save();
            return true;
        }
        return false;
    }


    public static function allGroups()
    {
        return DB::table('group')->get();
    }

    public static function getGroup($groupname)
    {
        $group = self::find($groupname);
        if($group){
            return true;
        }else return false;
    }

}
