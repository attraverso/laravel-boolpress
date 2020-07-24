<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
  protected $table = 'post_tag';

  public function tag() {
    $this->belongsToMany('App\Tag');
  }

  public function post() {
    $this->belongsToMany('App\Post');
  }
}
