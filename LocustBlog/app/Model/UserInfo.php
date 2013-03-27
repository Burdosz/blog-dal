<?php

/**
 * UserInfoテーブル用モデルクラス
 */
class UserInfo extends AppModel {
    
    /** テーブル名 */
    public $useTable = 'UserInfo';

    /**
     * ユーザーIDからユーザー情報を取り出す
     * 
     * @param int $userId
     */
    public function findUserInfo($userId) {
        
    }
    
}