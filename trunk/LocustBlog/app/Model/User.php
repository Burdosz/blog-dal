<?php

/**
 * Userテーブル用モデルクラス
 */
class User extends AppModel {
    
    /** テーブル名 */
    public $useTable = 'User';
    
    /**
     * テストユーザーを作成する
     */
    public function createTestUser() {
        
        $account = 'testuser';
        $password = AuthComponent::password('1234');
        
        $db = $this->getDataSource();
        
        $data = array(
            'User' => array(
                'account'     => $account,
                'password'    => $password,
                'create_date' => $db->expression('NOW()')
            )
        );
        
        $result = $this->save($data);
        
        debug($result);
    }
    
}