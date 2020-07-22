<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\Post;
use App\PostTag;

class PostTagPopulation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /** I need to be sure that the at least the ids are all different, otherwise I might make the same connection multiple times?*/
      $post_tag_coll = PostTag::all();
      $pt_combos_store = [];
        foreach ($post_tag_coll as $post_tag) {
        $pt_combo = $post_tag->post_id . '-' . $post_tag->tag_id;
        array_push($pt_combos_store, $pt_combo);
      }
      dd($pt_combos_store);

      $available_posts = [];
      $posts = Post::all();
      foreach ($posts as $post) {
        if (!in_array($post->id, $available_posts)) {
          array_push($available_posts, $post->id);
        }
      }
      dd($available_posts);

      $available_tags = [];
      $tags = Tag::all();
      foreach ($tags as $tag) {
        if (!in_array($tag->id, $available_tags)) {
          array_push($available_tags, $tag->id);
        }
      }
      dd($available_tags);

      $final_array = [];
      while (count($final_array) <= 10) { 
        $fake_post = array_rand($available_posts);
        $fake_tag = array_rand($available_tags);
        $new_combo = $fake_post . '-' . $fake_tag;
        if (!in_array($new_combo, $final_array)) {
          array_push($final_array, $new_combo);
          $tag = Tag::find($fake_tag);
          $tag->post()->attach($fake_post);
        }
      /** otherwise, populate an array with all the available IDs and choose randomly between those */
      }
    }
}
