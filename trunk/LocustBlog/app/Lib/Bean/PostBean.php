<?php

App::uses('Bean', 'Lib/Bean');

/**
 * Postモデルクラス用beanクラス
 */
class PostBean extends Bean {
    
    /**
     * id
     * 
     * @var type int
     */
    private $id;
    
    /**
     * ユーザーID
     *
     * @var type int
     */
    private $userId;
    
    /**
     * カテゴリーID
     * 
     * @var type int
     */
    private $categoryId;
    
    /**
     * タイトル
     * 
     * @var type string
     */
    private $title;
    
    /**
     * 記事内容
     *
     * @var type string
     */
    private $content;
    
    
    /**
     * Model用の配列があればそれから値を設定したインスタンスを生成する
     * 
     * @param type $data Model用の配列。
     */
    public function __construct($data = null) {
        if (!empty($data)) {
            if (isset($data['Post']['id'])) $this->id = $data['Post']['id'];
            if (isset($data['Post']['user_id'])) $this->userId = $data['Post']['user_id'];
            if (isset($data['Post']['category_id'])) $this->categoryId = $data['Post']['category_id'];
            if (isset($data['Post']['title'])) $this->title = $data['Post']['title'];
            if (isset($data['Post']['content'])) $this->content = $data['Post']['content'];
            if (isset($data['Post']['create_date'])) $this->createDate = $data['Post']['create_date'];
            if (isset($data['Post']['update_date'])) $this->updateDate = $data['Post']['update_date'];
            if (isset($data['Post']['delete_flg'])) $this->deleteFlg = $data['Post']['delete_flg'];
        }
    }
    
    /**
     * idを設定する
     * 
     * @param type $id
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * IDを取得する
     * 
     * @return type
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * ユーザーIDを設定する
     * 
     * @param type $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    
    /**
     * ユーザーIDを取得する
     * 
     * @return type
     */
    public function getUserId() {
        return $this->userId;
    }
    
    /**
     * カテゴリIDを設定する
     * 
     * @param type $categoryId
     */
    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }
    
    /**
     * カテゴリIDを取得する
     * 
     * @return type
     */
    public function getCategoryId() {
        return $this->categoryId;
    }
    
    /**
     * タイトルを設定する
     * 
     * @param type $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }
    
    /**
     * タイトルを取得する
     * 
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }
    
    /**
     * 記事を設定する
     * 
     * @param string $content
     */
    public function setContent($content) {
        $this->content = $content;
    }
    
    /**
     * 記事内容を取得する
     * 
     * @return string
     */
    public function getContent() {
        return $this->content;
    }
}