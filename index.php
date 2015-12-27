<?php

require __DIR__ . "/include/Database.php";
require __DIR__ . "/include/Model.php";
require __DIR__ . "/include/Post.php";
require __DIR__ . "/include/User.php";

$user = new User;
$user = $user->find(1);


// one way [ where posts() works as relationship ]
foreach($user->posts()->get() as $post) {
  echo "{$post->id} : {$post->title} "; // column name as property
}

echo "<br /><br />";

// another way [ where posts works as property ]
foreach($user->posts as $post) {
  echo "{$post->id} : {$post->title} ";
}
