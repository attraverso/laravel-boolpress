<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
  protected $table = 'post_tag';

  public function tag() {
    $this->belongsTo('App\Tag');
  }

  public function post() {
    $this->belongsTo('App\Post');
  }
}
