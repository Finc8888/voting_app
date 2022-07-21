<?php 
require_once('config.php');
require_once('classes/User.php');
require_once('classes/Article.php');


use \User\User;
use \Article\Article;

$con = $redisClient->getClient();

// $testUser = new User("test_user");
// $testUserId = $testUser->save($con);
$testUser = User::get($con, 'user:1');

// $article1 = new Article('user:6', 'Проба пера', 'http://test.com/article/1');
// $article2 = new Article('user:6', 'Почему у зебр не бывает инфарктов?', 'http://test.com/article/2');
// $article3 = new Article('user:1', 'Исследование вулканов', 'http://test.com/article/3');

// $article1->save($con);
// $article2->save($con);
// $article3->save($con);
$articles = Article::getArticles($con, 1);

$test = $con->get('test');

if(!empty($con)) {
    echo "<h2>Test responses is : '$test[0]'.</h2><br>";
    echo "<h2>Data of Test user : '";
    var_export($testUser);
    echo "'.</h2><br>";
    echo "Articles for Test users:";
    var_export($articles);
}