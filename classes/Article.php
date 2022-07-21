<?php 
namespace Article;
/**
 * [Description Article]
 */
class Article {
    /**
     * @var [type]
     */
    private $con;

    const ONE_WEEK_IN_SECONDS = 24 * 3600 * 7;
    const VOTE_SCORE = 400;
    const ARTICLES_PER_PAGE = 25;

    /**
     * @param mixed $con
     */
    public function __construct($user, $title, $link)
    {
        $this->user = $user;
        $this->title = $title;
        $this->link = $link;
    }
    private function init($con) {
        if(!$con->get('article')) {
            $con->set('article', 0);
        }

    }
    
    /**
     * @param mixed $user
     * @param mixed $title
     * @param mixed $link
     * 
     * @return [type]
     */
    public function save($con) {
        $this->init($con);
        $articleId = $con->incr('article:');
        $articleId = (string) $articleId;
        $voted = "voted:{$articleId}";
        $con->sadd($voted, $this->user);

        // after week clear vote info 
        $con->expire($voted, self::ONE_WEEK_IN_SECONDS);
        $now = (float) time();
        $article = "aritcle:{$articleId}";
        $con->hmset($article, [
            "title" => $this->title,
            "link" => $this->link,
            "poster" => $this->user,
            "time" => $now,
            "votes" => 1
        ]);

        $con->zadd("score:", $now + self::VOTE_SCORE, $article);
        $con->zadd("time:", $now, $article);
        return $articleId;
    }

    public function get($con, $article) {
        return $con->hvals($article);
    }

    public static function getArticles($con, $page, $order="score:") {
        $start = ($page - 1) * self::ARTICLES_PER_PAGE;
        $end = $start + self::ARTICLES_PER_PAGE -1;
        $ids = $con->zrevrange($order, $start, $end);
        $articles = [];
        foreach ($ids as $id) {
            $articleData = $con->hgetall($id);
            $articleData['id'] = $id;
            $articles[] = $articleData;
        }
        return $articles;
    }


}


