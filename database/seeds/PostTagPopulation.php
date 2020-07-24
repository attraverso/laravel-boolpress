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
    $postTagColl = PostTag::all();
    $ptCombosStore = [];
      foreach ($postTagColl as $postTag) {
      $ptCombo = $postTag->post_id . '-' . $postTag->tag_id;
      array_push($ptCombosStore, $ptCombo);
    }
    // dd($pt_combos_store);

    $availablePosts = [];
    $posts = Post::all();
    foreach ($posts as $post) {
      if (!in_array($post->id, $availablePosts)) {
        array_push($availablePosts, $post->id);
      }
    }
    // dd($available_posts);

    $availableTags = [];
    $tags = Tag::all();
    foreach ($tags as $tag) {
      if (!in_array($tag->id, $availableTags)) {
        array_push($availableTags, $tag->id);
      }
    }
    // dd($available_tags);
    //FIXME: occhio che sta cosa rischia di scatenare un loop infinito se hai esaurito le possibili combinazioni, fai un contatore indipendente che dopo x tentativi a vuoto ti fa uscire a prescindere
    $initial_array_count = count($ptCombosStore);
    while (count($ptCombosStore) <= $initial_array_count + 10) { 
      $fakePostIndex = array_rand($availablePosts);
      $fakePost = $availablePosts[$fakePostIndex];
      // dd('post' . $fakePost);
      $fakeTagIndex = array_rand($availableTags);
      $fakeTag = $availableTags[$fakeTagIndex];
      // dd('tag' . $fakeTag);
      $newCombo = $fakePost . '-' . $fakeTag;
      // dd('combo' . $new_combo);
      if (!in_array($newCombo, $ptCombosStore)) {
        array_push($ptCombosStore, $newCombo);
        $post = Post::where('id', $fakePost)->first();
        $snafu = $post->tag;
        // dd($snafu);
        $post->tags()->attach($fakeTag);
      }
    /** otherwise, populate an array with all the available IDs and choose randomly between those */
    }
    dd($ptCombosStore);
  }
}
