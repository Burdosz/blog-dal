<?php

App::uses('Bean', 'Lib/Bean');

/**
 * UserInfo用Beanクラス
 */
class UserInfoBean extends Bean {
    
    /**
     * ユーザーID
     * 
     * @var int
     */
    public $userId;
    
    /**
     * 表示名
     * 
     * @var string
     */
    public $nickName;
    
    /**
     * 性別s
     * 
     * @var int
     */
    public $sex;
    
    /**
     * メールアドレス
     * 
     * @var string
     */
    public $email;
    
    /**
     * 誕生日 年
     * 
     * @var int
     */
    public $birthY;
    
    /**
     * 誕生日 月
     * 
     * @var int
     */
    public $birthM;
    
    /**
     * 誕生日 日
     * 
     * @var int
     */
    public $birthD;
    
    
}