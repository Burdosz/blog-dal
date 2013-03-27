<?php

App::uses('Bean', 'Lib/Bean');

/**
 * Categoryモデル用Beanクラス
 */
class CategoryBean extends Bean {

    /**
     * カテゴリ名
     * 
     * @var string 
     */
    private $categoryName;
    
    /**
     * カテゴリのID
     * 
     * @var int
     */
    private $id;
    
    /**
     * ユーザーID
     *
     * @var int
     */
    private $userId;
    
    /**
     * カテゴリ名を設定する
     * 
     * @param string $categoryName
     */
    public function setCategoryName($categoryName) {
       $this->categoryName = $categoryName; 
    }
    
    /**
     * カテゴリ名を取得する
     * 
     * @return string
     */
    public function getCategoryName() {
        return $this->categoryName;
    }
    
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
     * idを設定する
     * 
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }
            
    /**
     * idを取得する
     * 
     * @return int
     */
    public function getId() {
        return $this->id;
    }

}