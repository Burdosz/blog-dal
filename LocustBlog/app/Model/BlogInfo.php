<?php

/**
 * BlogInfoテーブル用モデルクラス
 */
class BlogInfo extends AppModel {

    /** テーブル名 */
    public $useTable = 'BlogInfo';
    
    /**
     * ユーザーアカウントからブログ情報を取り出す
     * 
     * @param type $account
     */
    public final function findBlogInfoByUserAccount($account) {
        
        if (empty($account)) {
            return null;
        }
        
        $sql = '';
        $sql .= 'SELECT ';
        $sql .= '  User.id, ';
        $sql .= '  User.account, ';
        $sql .= '  UserInfo.nickname, ';
        $sql .= '  BlogInfo.blog_title ';
        $sql .= 'FROM ';
        $sql .= '  BlogInfo ';
        $sql .= 'INNER JOIN ';
        $sql .= '  User ';
        $sql .= 'ON ';
        $sql .= '  User.id = BlogInfo.user_id ';
        $sql .= 'INNER JOIN ';
        $sql .= '  UserInfo ';
        $sql .= 'ON ';
        $sql .= '  User.id = UserInfo.user_id ';
        $sql .= 'WHERE ';
        $sql .= '  User.account = ? ';
        $sql .= 'AND ';
        $sql .= '  User.delete_flg = 0 ';
        $sql .= 'AND ';
        $sql .= '  BlogInfo.delete_flg = 0 ';
        $sql .= 'AND ';
        $sql .= '  UserInfo.delete_flg = 0 ';
        
        $result = $this->query($sql, array($account));
        
        if (empty($result)) {
            return null;
        }
        
        return $result[0];
    }
    
}