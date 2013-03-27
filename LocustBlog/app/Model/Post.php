<?php

App::uses('PostBean', 'Lib/Bean');

/**
 * Postテーブル用モデルクラス
 */
class Post extends AppModel {

    /** テーブル名 */
    public $useTable = 'Post';

    /**
     * Pagination用ユーザID
     * 
     * @var int 
     */
    private $userId;

    /**
     * カテゴリで検索をしぼるときに利用する
     *
     * @var type 
     */
    private $categoryId;

    /**
     * バリデーション
     * 
     * @var array
     */
    public $validate = array(
        'user_id' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'ユーザーIDが不正です'
            ),
            'naturalNumber' => array(
                'rule' => array('naturalNumber', false),
                'message' => 'ユーザーIDが不正です'
            ),
        ),
        'category_id' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'カテゴリが未選択です'
            ),
            'naturalNumber' => array(
                'rule' => array('naturalNumber', false),
                'message' => 'カテゴリが不正です'
            ),
        ),
        'title' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'タイトルが未入力です'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 100),
                'message' => 'タイトルは100文字以内にしてください'
            )
        ),
        'content' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => '記事が未入力です'
            )
        )
    );

    /**
     * findPostのsqlの共通部分前半を作成する
     * 
     * @return string
     */
    private function createFindPostFrontSQL() {

        $sql = '';
        $sql .= 'SELECT ';
        $sql .= '  Post.*, ';
        $sql .= '  Category.category_name ';
        $sql .= 'FROM ';
        $sql .= '  (';
        $sql .= '    User ';
        $sql .= '  INNER JOIN ';
        $sql .= '    Post ';
        $sql .= '  ON ';
        $sql .= '    User.id = Post.user_id ';
        $sql .= '  ) ';
        $sql .= 'INNER JOIN ';
        $sql .= '  Category ';
        $sql .= 'ON ';
        $sql .= '  Category.id = Post.category_id ';
        $sql .= 'WHERE ';
        $sql .= '  User.id = ? ';
        $sql .= 'AND ';

        return $sql;
    }

    /**
     * findPostのsqlの共通部分後半を作成する
     * 
     * @return string
     */
    private function createFindPostBackSQL() {
        $sql = '';
        $sql .= 'AND ';
        $sql .= '  User.delete_flg = 0 ';
        $sql .= 'AND ';
        $sql .= '  Post.delete_flg = 0 ';
        $sql .= 'AND ';
        $sql .= '  Category.delete_flg = 0 ';

        return $sql;
    }

    /**
     * 記事を登録する
     * 
     * @param PostBean $post
     */
    public function insertPost($post) {
        $db = $this->getDataSource();
        $post->setCreateDate($db->expression('NOW()'));
        $post->setDeleteFlg(false);

        $newPost = $this->createDataFromBean($post);

        if (empty($newPost)) {
            return false;
        }

        return $this->save($newPost);
    }

    /**
     * 記事を更新する
     * 
     * @param PostBean $post
     */
    public function updatePost(PostBean $post) {
        $post->setUpdateDate(null);

        // createDataFromBeanはよけいなデータが入ってしまうので手動で配列作成
        $postData = array();
        $postData['Post']['id'] = $post->getId();
        $postData['Post']['title'] = $post->getTitle();
        $postData['Post']['content'] = $post->getContent();
        $postData['Post']['category_id'] = $post->getCategoryId();

        if (empty($postData)) {
            return false;
        }

        return $this->save($postData);
    }

    /**
     * 記事を削除する(論理削除)
     * 
     * @param int $postId
     */
    public function deletePost($postId) {
        $postData = array();
        $postData['Post']['id'] = $postId;
        $postData['Post']['delete_flg'] = true;
        
        return $this->save($postData);
    }

    /**
     * ユーザーの投稿記事を検索する
     * 
     * @param int $postId ポストID
     * @param int $userId ユーザーID
     */
    public function findPostByPostIdAndUserId($postId, $userId) {

        $options = array(
            'conditions' => array(
                'Post.id' => $postId,
                'Post.user_id' => $userId
            )
        );

        $result = $this->find('first', $options);

        if (empty($result)) {
            return null;
        }
        
        $post = new PostBean($result);

        return $post;
    }

    /**
     * ユーザーの投稿記事を検索する
     * 
     * @param int $postId ポストID
     * @param int $userId ユーザーID
     */
    public function findPostWithCategoryByPostIdAndUserId($postId, $userId) {

        $sql = '';
        $sql .= $this->createFindPostFrontSQL();
        $sql .= '  Post.id = ? ';
        $sql .= $this->createFindPostBackSQL();

        $result = $this->query($sql, array($userId, $postId));

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }

    public function findPostHasNeighbourByPostIdAndUserId($postId, $userId) {
        $sql = '';
        $sql .= $this->createFindPostFrontSQL();
        $sql .= '( ';
        $sql .= '  Post.id = ? ';
        $sql .= 'OR ';
        $sql .= '  Post.id = ( ';
        $sql .= '    SELECT ';
        $sql .= '      id ';
        $sql .= '    FROM ';
        $sql .= '      Post ';
        $sql .= '    WHERE ';
        $sql .= '      user_id = ? ';
        $sql .= '    AND id > ? ';
        $sql .= '    AND delete_flg = 0 ';
        $sql .= '    ORDER BY create_date ';
        $sql .= '    LIMIT 1 ';
        $sql .= '  ) ';
        $sql .= 'OR ';
        $sql .= '  Post.id = ( ';
        $sql .= '    SELECT ';
        $sql .= '      id ';
        $sql .= '    FROM ';
        $sql .= '      Post ';
        $sql .= '    WHERE ';
        $sql .= '      user_id = ? ';
        $sql .= '    AND id < ? ';
        $sql .= '    AND delete_flg = 0 ';
        $sql .= '    ORDER BY create_date DESC ';
        $sql .= '    LIMIT 1 ';
        $sql .= '  ) ';
        $sql .= ') ';
        $sql .= $this->createFindPostBackSQL();

        $result = $this->query(
                $sql, array(
            $userId, $postId,
            $userId, $postId,
            $userId, $postId)
        );

        if (empty($result)) {
            return null;
        }

        return $result;
    }

    /**
     * ユーザーの投稿記事を検索する
     * 
     * @param int $postId ポストID
     * @param int $userAccount ユーザーアカウント
     */
    public function findPostsByUserAccount($userAccount, $limit = 3) {

        // limitはPDOのバグでバインド時に文字列にされてしまうのでここで
        // 数値かどうかのチェックをし、sqlに直接組み込む
        if (!is_int($limit)) {
            return null;
        }

        $sql = $this->createPaginationSQL();
        $sql .= 'LIMIT ' . $limit;

        $result = $this->query($sql, array($userAccount));

        if (empty($result)) {
            return null;
        }

        return $result;
    }

    /**
     * Paginationで検索に使うユーザーIDを設定する
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * Paginationで検索に使うカテゴリIDを設定する
     * 
     * @param type $categoryId
     */
    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    /**
     * Paginationで利用するSQLを生成する
     * 
     * @param type $categoryId
     */
    private function createPaginationSQL($categoryId = null) {

        $sql = '';
        $sql .= 'SELECT ';
        $sql .= '  Post.*, ';
        $sql .= '  Category.id, ';
        $sql .= '  Category.category_name ';
        $sql .= 'FROM ';
        $sql .= '  ( ';
        $sql .= '    User ';
        $sql .= '  INNER JOIN ';
        $sql .= '    Post ';
        $sql .= '  ON ';
        $sql .= '    User.id = Post.user_id ';
        $sql .= '  )';
        $sql .= 'INNER JOIN ';
        $sql .= '  Category ';
        $sql .= 'ON ';
        $sql .= '  Category.id = Post.category_id ';
        $sql .= 'WHERE ';
        $sql .= '  User.id = ? ';

        if (!is_null($categoryId)) {
            $sql .= 'AND ';
            $sql .= '  Post.category_id = ? ';
        }

        $sql .= 'AND ';
        $sql .= '  User.delete_flg = 0 ';
        $sql .= 'AND ';
        $sql .= '  Post.delete_flg = 0 ';
        $sql .= 'AND ';
        $sql .= '  Category.delete_flg = 0 ';
        $sql .= 'ORDER BY ';
        $sql .= '  Post.create_date DESC ';

        return $sql;
    }

    /**
     * 
     * paginateのオーバーライド。ユーザーアカウントから
     * ブログ記事の検索をページングの機能を使って実行
     * 
     * @param type $conditions
     * @param type $fields
     * @param type $order
     * @param type $limit
     * @param type $page
     * @param type $recursive
     * @param type $extra
     */
    function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {

        // 不正な値は1にする
        if ($page == 0 || !is_int($page)) {
            $page = 1;
        }

        // 必要ないので関連のレベルを0にする。
        $recursive = 0;

        // limitの部分だけ毎回かわるかつPDOのバグでバインドが失敗するので
        // 直接埋め込み
        $sql = $this->createPaginationSQL($this->categoryId) . 'LIMIT '
                . (($page - 1) * $limit) . ', ' . $limit;

        $params = array($this->userId);

        if (!is_null($this->categoryId)) {
            $params[] = $this->categoryId;
        }

        return $this->query($sql, $params);
    }

    /**
     * paginateCountのオーバーライド。
     * 
     * @param type $conditions
     * @param type $recursive
     * @param type $extra
     */
    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        $this->recursive = $recursive;

        $params = array($this->userId);

        if (!is_null($this->categoryId)) {
            $params[] = $this->categoryId;
        }

        $results = $this->query(
                $this->createPaginationSQL($this->categoryId), $params);

        return count($results);
    }

    /**
     * 指定された年の月に書かれた記事を検索する
     * 
     * @param type $userId
     * @param type $year yyyyの形式
     * @param type $month mmの形式
     */
    public function findPostsByYearMonth($userId, $year, $month) {

        $startDate = $year . '-' . $month . '-01';

        $options = array(
            'conditions' => array(
                'Post.create_date BETWEEN ? AND ? + INTERVAL 1 MONTH'
                => array($startDate, $startDate),
                'Post.user_id' => $userId,
                'Post.delete_flg' => 0
            ),
            'order' => 'Post.create_date DESC'
        );

        $result = $this->find('all', $options);

        if (empty($result)) {
            return null;
        }

        $returnData = array();
        foreach ($result as $row) {
            $post = new PostBean($row);
            $returnData[] = $post;
        }

        return $returnData;
    }

}