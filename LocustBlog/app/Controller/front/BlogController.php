<?php

App::uses('FrontBaseController', 'Controller');
App::uses('Blog', 'Lib/Controller');

/**
 * ブログ画面用コントローラー
 */
class BlogController extends FrontBaseController {

    public $paginate = array(
        'limit' => 3,
        'paramType' => 'querystring',
    );

    /**
     * ブログ情報を保持する
     * 
     * @var Blog
     */
    private $blog;

    public function beforeFilter() {
        parent::beforeFilter();

        $this->layout = 'blog';


        // ブログの情報を取得
        $this->loadModel('BlogInfo');
        $userName = $this->request->params['user'];
        $blogInfo = $this->BlogInfo->findBlogInfoByUserAccount($userName);

        $this->blog = new Blog($blogInfo);

        $this->set('blogTitle', $this->blog->getBlogTitle());
        $this->set('userAccount', $userName);
        /*
          // ブログの情報を持っていないとき。もしくは前みていたページと別なユーザーの
          // ブログに移動した場合のみ更新
          if (empty($this->blog) || $this->blog->getAccount() !== $userName) {
          $this->loadModel('BlogInfo');
          $this->blog = $this->BlogInfo->findBlogInfoByUserAccount($userName);

          if (empty($this->blog)) {
          // TODO: エラー処理
          }
          }
         */
    }

    public function index() {

        $this->loadModel('Post');

        // 全件検索
        $this->Post->setUserId($this->blog->getUserId());

        // カテゴリの指定がある場合はそれのみを一覧表示する
        if (isset($this->request->query['category'])
                && is_numeric($this->request->query['category'])) {
            
            
            $this->Post->setCategoryId(
                    intval($this->request->query['category'])
            );
            
            // PageNationは検索条件を引き継がないのでViewで強制的につけてやる
            $this->set('searchCategory', intval($this->request->query['category']));
            
        } else {
            $this->set('searchCategory', null);
        }

        $post = $this->paginate('Post');
        if ($post) {
            $this->set('post', $post);
            $this->render('home');
        } else {
            // エラー処理
        }
    }

    public function entry() {
        $this->autoRender = false;

        if (isset($this->request->params['post_id'])) {
            $postId = $this->request->params['post_id'];
            $this->loadModel('Post');
            // TODO:テストとして前後の物をとってきた物を使ってみる
//            $post = $this->Post->findPostByPostIdAndUserId(
//                    intval($postId), $this->blog->getUserId());

            $posts = $this->Post->findPostHasNeighbourByPostIdAndUserId(
                    intval($postId), $this->blog->getUserId());

            if ($posts) {

                $prev = null;
                $post = null;
                $next = null;

                switch (count($posts)) {
                    case 1:
                        $post = $posts[0];
                        break;
                    case 2:
                        if ($post[0]['Post']['id'] == intval($postId)) {
                            $next = $posts[1];
                            $post = $posts[0];
                        } else {
                            $prev = $posts[0];
                            $post = $posts[1];
                        }
                        break;
                    case 3:
                        $prev = $posts[0];
                        $post = $posts[1];
                        $next = $posts[2];
                        break;
                    default :
                        debug('It is impossible.');
                }

                $this->set('prev', $prev);
                $this->set('post', $post);
                $this->set('next', $next);

//                $this->set('post', $post);
                $this->render('post');
            } else {
                // エラー処理
                //throw new NotFoundException();
            }
        }
    }

}