<?php

App::uses('FrontBaseController', 'Controller');

/**
 * 登録ページ用Controller
 */
class SignInController extends FrontBaseController {
    
    public $layout = 'signin';

    /**
     * コンポーネント
     * 
     * @var type 
     */
    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'mypage',
                'action' => 'index'
            ),
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
        
        $this->Auth->allow('login');
        $this->Auth->allow('index');
    }

    /**
     * メール登録アクション
     */
    public function index() {
        
    }

    /**
     * ログイン
     */
    public function login() {

        if (!$this->request->is('post')) {
            return;
        }

        if ($this->Auth->login()) {
            $this->redirect($this->Auth->redirect());
        } else {
            $this->Session->setFlash('アカウントかパスワードが違います。');
        }
    }

    /**
     * 認証用のメールを送信する
     */
    public function sendEmail() {

        $this->autoRender = false;
    }

}