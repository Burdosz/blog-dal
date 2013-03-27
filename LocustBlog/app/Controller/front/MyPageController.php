<?php

App::uses('FrontBaseController', 'Controller');
App::uses('PostBean', 'Lib/Bean');
App::uses('CategoryBean', 'Lib/Bean');
App::uses('Util', 'Lib/Common');

/**
 * マイページ用Controller
 */
class MyPageController extends FrontBaseController {

    /**
     * ページネイションの設定
     */
    public $paginate = array(
        'limit' => 10,
        'paramType' => 'querystring',
        'order' => array(
            'update_date' => 'DESC'
        )
    );

    /**
     * コンポーネント
     * 
     * @var type 
     */
    public $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'signin',
                'action' => 'login'
            ),
            'logoutRedirect' => array(
                'controller' => 'signin',
                'action' => 'login'
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'account',
                        'password' => 'password'
                    ),
                    'userModel' => 'User'
                )
            )
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();

        $this->layout = 'mypage';
    }

    /**
     * ログイン用アクション
     * 
     * @return type
     */
    public function login() {

        if (!$this->request->is('post')) {
            return;
        }

        if ($this->Auth->login()) {
            $this->redirect('index');
        } else {
            $this->Session->setFlash('アカウントかパスワードが違います。');
        }
    }

    /**
     * ログアウト
     */
    public function logout() {
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }

    /**
     * デフォルトアクション
     */
    public function index() {
        $this->setAction('newpost');
    }

    /**
     * 
     */
    public function newPost() {

        $user = $this->Auth->user();

        if (!$user) {
            // リダイレクトするとexitが呼ばれるが処理のきり分けを明確に
            // するためreturnする
            $this->redirect('login');
            return;
        }


        $this->loadModel('Category');
        $categories = $this->Category->getCategoryList($user['id']);

        if (!$categories) {
            // TODO: カテゴリを作らせる
        }
        $this->set('categories', $categories);

        // Tokenを作成して登録処理の重複監視を行う
        $token = $this->createToken();
        $this->setTokenIntoSession($token);
        $this->set('token', $token);
    }

    /**
     * 投稿内容確認画面用アクション
     */
    public function confirm() {

        if (empty($this->data)) {
            // TODO : エラー処理
        }

        // トークンによる重複チェック
        if (!isset($this->data['token'])) {
            $this->redirect('index');
            return;
        }

        $formToken = $this->data['token'];
        if (!$this->checkToken($formToken)) {
            $this->redirect('index');
            return;
        }

        $properties = array('title', 'category', 'content');

        if (!$this->isSetPropertiesInData($properties)) {
            // TODO : エラー処理
        }

        $user = $this->Auth->user();

        $this->loadModel('Category');
        $category = $this->Category->findCategory($this->data['category'], $user['id']);

        if (!$category) {
            // TODO: エラー処理
        }

        // 不正防止の為にセッションにデータを入れる

        $this->Session->write('category_id', $category->getId());
        $this->Session->write('title', $this->data['title']);
        $this->Session->write('content', $this->data['content']);

        $this->set('category', $category);
        $this->set('title', $this->data['title']);
        $this->set('content', $this->data['content']);

        // Tokenを作成して登録処理の重複監視を行う
        $token = $this->createToken();
        $this->setTokenIntoSession($token);
        $this->set('token', $token);
    }

    /**
     * ブログ記事保存
     */
    public function publish() {

        // トークンによる重複チェック
        if (!isset($this->data['token'])) {
            $this->redirect('index');
            return;
        }
        $formToken = $this->data['token'];
        if (!$this->checkToken($formToken)) {
            $this->redirect('index');
            return;
        }

        $categoryId = $this->Session->read('category_id');
        $title = $this->Session->read('title');
        $content = $this->Session->read('content');

        if (empty($categoryId) || empty($title) || empty($content)) {
            // TODO: エラー処理
        }

        $user = $this->Auth->user();

        $post = new PostBean();
        $post->setUserId($user['id']);
        $post->setTitle($title);
        $post->setCategoryId($categoryId);
        $post->setContent($content);

        // 記事の保存
        $this->loadModel('Post');
        $result = $this->Post->insertPost($post);

        if (!$result) {
            // エラー処理
        }

        $account = $user['account'];
        $urlOfPost = 'http://' . HOST . '/blog/'
                . $account . '/entry/' . $result['Post']['id'];

        $this->set('url', $urlOfPost);

        // トークンのリセット
        $this->setTokenIntoSession(null);
    }

    /**
     * カテゴリの編集ページ用アクション
     */
    public function categoryList() {

        // カテゴリの一覧を取得して編集用に表示させる
        $user = $this->Auth->user();
        $this->loadModel('Category');
        $categories = $this->paginate('Category', array('user_id' => $user['id']));
        //$this->Category->findCategoriesByUserId($user['id']);
        // TODO : 共通メソッドでマッピング処理を行うように変更する
        $categoryList = array();

        foreach ($categories as $row) {
            $category = new CategoryBean();

            $category->setUserId($user['id']);
            $category->setId($row['Category']['id']);
            $category->setCategoryName($row['Category']['category_name']);
            $category->setCreateDate($row['Category']['create_date']);
            $category->setUpdateDate($row['Category']['update_date']);
            $category->setDeleteFlg($row['Category']['delete_flg']);

            $categoryList[] = $category;
        }


        $this->set('categories', $categoryList);

        // Tokenを作成してカテゴリの新規登録処理の重複監視を行う
        $token = $this->createToken();
        $this->setTokenIntoSession($token);
        $this->set('token', $token);
    }

    /**
     * カテゴリを追加するアクション
     */
    public function addCategory() {

        // TODO: ここは共通メソッドかコンポーネントを作成してモジュール化する
        // トークンによる重複チェック
        if (!isset($this->data['token'])) {
            $this->redirect('index');
            return;
        }

        $formToken = $this->data['token'];

        if (!$this->checkToken($formToken)) {
            $this->redirect('index');
            return;
        }

        $user = $this->Auth->user();

        $newCategory = new CategoryBean();
        $newCategory->setCategoryName($this->data['new_category']);
        $newCategory->setUserId($user['id']);
        $this->loadModel('Category');

        $result = $this->Category->insertCategory($newCategory);

//        if (!$result) {
//            
//        }

        $this->redirect('editCategory');
    }

    /**
     * カテゴリ編集画面用＠アクション
     */
    public function editCategory() {

        if (!isset($this->request->query['category'])) {
            $this->redirect('categoryList');
            return;
        }

        $user = $this->Auth->user();

        $this->loadModel('Category');
        $category = $this->Category->findCategory(
                $this->request->query['category'], $user['id']
        );

        if (empty($category)) {
            throw new NotFoundException();
        }

        $this->set('category', $category);

        // 不正防止の為カテゴリ情報をセッションに保持する
        $this->Session->write('category2', $category);

        // Tokenを作成して登録処理の重複監視を行う
        $token = $this->createToken();
        $this->setTokenIntoSession($token);
        $this->set('token', $token);
    }

    /**
     * カテゴリ更新処理用アクション
     */
    public function updateCategory() {
        $this->autoLayout = false;
        $this->autoRender = false;

        // IDを保たなくてはいけないのでポスト以外ははじく
        if (!$this->request->is('post')) {
            $this->redirect('index');
            debug('here');
            return;
        }

        if (!isset($this->data['category_name'])) {
            $this->redirect('index');
            debug('here2');
            return;
        }

        // TODO: ここは共通メソッドかコンポーネントを作成してモジュール化する
        // トークンによる重複チェック
        if (!isset($this->data['token'])) {
            $this->redirect('index');
            debug('here3');
            return;
        }

        $formToken = $this->data['token'];

        if (!$this->checkToken($formToken)) {
            $this->redirect('index');
            debug('here4');
            return;
        }

        $category = $this->Session->read('category2');

        if (empty($category)) {
            $this->redirect('index');
            debug('here5');
            return;
        }

        $category->setCategoryName($this->data['category_name']);
        $this->loadModel('Category');
        $result = $this->Category->updateCategory($category);

        if (!$result) {
            // TODO : エラー処理
        }

        // トークンのリセット
        $this->setTokenIntoSession(null);

        $this->redirect('categoryList');
    }

    /**
     * 記事一覧表示
     */
    public function postList() {

        $this->loadModel('Post');
        $year = null;
        $month = null;

        if (isset($this->request->query['year']) &&
                isset($this->request->query['month']) &&
                is_numeric($this->request->query['year']) &&
                is_numeric($this->request->query['month'])) {

            // クエリがあればその月と年で検索
            $year = $this->request->query['year'];
            $month = $this->request->query['month'];
        } else {
            // クエリがなければ現在の日付から判定する
            $date = Util::getDate();
            $year = $date['year'];
            $month = $date['mon'];
        }

        $user = $this->Auth->user();
        $posts = $this->Post->findPostsByYearMonth(
                $user['id'], $year, $month);

        // 年の正当性をチェックする
        // 次の年
        $this->set('posts', $posts);
        $this->set('year', $year);
        $this->set('month', $month);

        // CSRF対策にトークンを登録
        $token = $this->createToken();
        $this->setTokenIntoSession($token);
        $this->set('token', $token);
    }

    /**
     * 記事を編集する
     */
    public function editPost() {

        if (!isset($this->request->query['id'])) {
            throw new NotFoundException();
        }

        $user = $this->Auth->user();
        $userId = $user['id'];
        $postId = $this->request->query['id'];

        $this->loadModel('Post');
        $post = $this->Post->findPostByPostIdAndUserId($postId, $userId);

        if (empty($post)) {
            throw new NotFoundException();
        }

        $this->loadModel('Category');
        $categories = $this->Category->findCategoriesByUserId($userId);

        $this->set('post', $post);
        $this->set('categories', $categories);

        // 不正防止の為に投稿IDをセッションに登録
        $this->Session->write('id', $postId);
    }

    /**
     * 記事を更新する
     */
    public function updatePost() {

        if (!$this->request->is('post')) {
            throw new BadRequestException();
        }

        $postId = $this->Session->read('id');

        if (empty($postId)) {
            throw new BadRequestException();
        }

        $user = $this->Auth->user();

        $title = $this->data['title'];
        $content = $this->data['content'];
        $category = $this->data['category'];

        // カテゴリの整合性をチェックする(セキュリティ対策)
        $this->loadModel('Category');

        if ($this->Category->findCategory($category, $user['id']) == null) {
            throw new BadRequestException();
        }

        $this->loadModel('Post');

        $post = new PostBean();
        $post->setId($postId);
        $post->setContent($content);
        $post->setTitle($title);
        $post->setCategoryId($category);

        $result = $this->Post->updatePost($post);

        if (!$result) {
            // エラー処理
        }

        // TODO 更新ページ作成する
        $this->redirect('index');
    }

    /**
     * 記事を削除する
     */
    public function deletePost() {

        if (!isset($this->request->query['id'])) {
            throw new NotFoundException();
        }

        if (!isset($this->request->query['token'])) {
            throw new InternalErrorException();
        }

        $viewToken = $this->request->query['token'];

        if (!$this->checkToken($viewToken)) {
            throw new BadRequestException();
        }

        $postId = $this->request->query['id'];
        $this->loadModel('Post');
        $result = $this->Post->deletePost($postId);

        if (!$result) {
            throw new InternalErrorException();
        }

        $this->setTokenIntoSession(null);
    }

}