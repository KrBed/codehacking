<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;


/**
 * App\Photo
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Photo query()
 * @mixin \Eloquent
 */
class Photo extends Model
{
    protected $fillable =['file'];

    protected $uploads = '/images/';
    protected $defaultImage = 'default.jpg';


    public function getPhotoUrl($photo = ""){

        if($photo === ""){
            $photo = $this->defaultImage;
        }

        return URL::to('/images/'. $photo);
    }
}

