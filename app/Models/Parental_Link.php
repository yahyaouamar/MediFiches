<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parental_Link extends Model
{
    protected $fillable = [
        'national_number',
        'parent_1',
        'parent_2',
        'relation_1',
        'relation_2',
        'group',
    ];
    protected $primaryKey = 'national_number';
    protected $table = 'parental_link';

    public static function createChild($data)
    {
        return self::create($data);
    }

    public static function updatechild($id, $data)
    {
        $child = self::find($id);
        if ($child) {
            $child->update($data);
            return $child;
        }
        return null;
    }

    public static function updateGroupName($originalName, $newName)
    {
        self::where('group', $originalName)->update(['group' => $newName]);
    }

    public static function updateGroupNameChild($originalName, $newName,$national_number)
    {
        self::where('group', $originalName)->where('national_number',$national_number)->update(['group' => $newName]);
    }

    public static function deletechild($id)
    {
        $child = self::find($id);
        if ($child) {
            $child->delete();
            return true;
        }
        return false;
    }

    public static function getAllChildren()
    {
        return self::all();
    }

    public static function getChildById($id)
    {
        return self::find($id);
    }
}