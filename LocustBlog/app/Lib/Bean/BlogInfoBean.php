<?php

App::uses('Bean', 'Lib/Bean');

/**
 * BlogInfoモデルクラス用beanクラス
 */
class BlogInfoBean extends Bean {
    
    /**
     * id(ユーザーID)
     * 
     * @var type int
     */
    private $userId;
    
    /**
     * タイトル
     * 
     * @var type string
     */
    private $blogTitle;
    
    /**
     * ユーザーIDを設定する
     * 
     * @param int $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    
    /**
     * ユーザーIDを取得する
     * 
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }
    
    /**
     * ブログのタイトルを設定する
     * 
     * @param string $blogTitle
     */
    public function setBlogTitle($blogTitle) {
        $this->blogTitle = $blogTitle;
    }
    
    /**
     * ブログタイトルを取得する
     * 
     * @return string
     */
    public function getBlogTitle() {
        return $this->blogTitle;
    }
            
}