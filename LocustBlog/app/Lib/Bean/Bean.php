<?php

/**
 * Beanの基本クラス
 */
class Bean {
    
    /**
     * 生成日時
     * 
     * @var Date
     */
    protected $createDate;
    
    /**
     * 更新日時
     * 
     * @var Date
     */
    protected $updateDate;
    
    /**
     * 削除フラグ
     * 
     * @var boolean 
     */
    protected $deleteFlg;
    
    /**
     * 作成日を設定する
     * 
     * @param $createDate
     */
    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }
    
    /**
     * 作成日を取得する
     */
    public function getCreateDate() {
       return $this->createDate; 
    }
    
    
    /**
     * 更新日を設定する
     * 
     * @param type $updateDate
     */
    public function setUpdateDate($updateDate) {
       $this->updateDate = $updateDate;
    }
    
    /**
     * 更新日を取得する
     * 
     * @return type
     */
    public function getUpdateDate() {
        return $this->updateDate;
    }
    
    /**
     * 削除フラグを設定する
     * 
     * @param boolean $deleteFlg
     */
    public function setDeleteFlg($deleteFlg) {
        $this->deleteFlg = $deleteFlg;
    }
    
    /**
     * 削除フラグを取得する
     * 
     * @return type
     */
    public function getDeleteFlg() {
        return $this->deleteFlg;
    }
    
    
}