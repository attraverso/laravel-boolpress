<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $fillable = ['title', 'content', 'slug', 'category_id'];

  public function category() {
    /**$this always refers to the object on which the function was invoked */
    return $this->belongsTo('App\Category');
  }

  public function tags() {
    return $this->belongsToMany('App\Tag');
  }

  public function postTags() {
    return $this->belongsToMany('App\PostTag', 'post_id', 'id');
  }

  /** if you need to often combine the same object properties together (eg first/last name) you can create a function inside the appropriate model, and then call the function on your object from the view */
  public function compareTitleSlug() {
    return 'post-title: ' . $this->title . ' Slug: ' . $this->slug;
  }
}
