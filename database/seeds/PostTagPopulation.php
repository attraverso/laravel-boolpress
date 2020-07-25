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
    //create an array with all the post post-tag combinations already in the pivot table
    $postTagColl = PostTag::all();
    $ptCombosStore = [];
    foreach ($postTagColl as $postTag) {
      //format the output so that you can't mix up tags and posts (eg. 112: is it post 11 w/ tag 2 or post 1 w/ tag 12?)
      $ptCombo = $postTag->post_id . '-' . $postTag->tag_id;
      array_push($ptCombosStore, $ptCombo);
    }

    //create an array with all the post ids already present in the posts table
    $availablePosts = [];
    $posts = Post::all();
    foreach ($posts as $post) {
      if (!in_array($post->id, $availablePosts)) {
        array_push($availablePosts, $post->id);
      }
    }

    //create an array with all the tags ids already present in the tags table
    $availableTags = [];
    $tags = Tag::all();
    foreach ($tags as $tag) {
      if (!in_array($tag->id, $availableTags)) {
        array_push($availableTags, $tag->id);
      }
    }
    /** you could've just created and saved a new PostTag object, ya know?*/

    //learn how many combos are already in the post_tag pivot
    $initialArrayCount = count($ptCombosStore);
    //initialize a counter that won't let you fall into an infinite loop in case all the available combos are already taken
    $safetyCounter = 0;
    //while the total number of lines in post_tag is lower than the initial count + 10 (I want to add 10 items) AND the safety loop hasn't reached 50 unsuccessful iterations
    while (count($ptCombosStore) <= $initialArrayCount + 10 && $safetyCounter < 50) { 
      //get a random index from the available posts/tags array
      $fakePostIndex = array_rand($availablePosts);
      $fakeTagIndex = array_rand($availableTags);
      //get corresponding id
      $fakePost = $availablePosts[$fakePostIndex];
      $fakeTag = $availableTags[$fakeTagIndex];
      //format the results the same as in the ptCombosStore array
      $newCombo = $fakePost . '-' . $fakeTag;
      //if you don't already have that combination in ptCombosStore, add it and create new record in the pivot
      if (!in_array($newCombo, $ptCombosStore)) {
        array_push($ptCombosStore, $newCombo);
        $post = Post::where('id', $fakePost)->first();
        $post->tags()->attach($fakeTag);
      }

      $safetyCounter++;
    }
  }
}
