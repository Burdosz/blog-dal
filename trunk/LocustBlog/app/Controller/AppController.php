<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    /** Session用登録 token */

    const SESSION_PARAM_TOKEN = '__app_session_token';

    /** ヘルパーの読み込み */
    public $helpers = array(
        'Html' => array(
            'className' => 'LinkedHtml'
        )
    );
    // 共通のコンポーネント
    public $components = array(
//        'DebugKit.Toolbar' => array('history' => false)
        'Security'
    );

    /**
     * プロパティがdataにセットされているか調べる
     * 
     * @return true 全て設定されている false 設定されていない物がある
     */
    protected function isSetPropertiesInData($properties) {

        if (empty($this->data)) {
            return false;
        }

        foreach ($properties as $property) {
            if (!isset($this->data[$property])) {
                return false;
            }
        }

        return true;
    }

    /**
     * トークンを作成する
     */
    protected function createToken() {
        $uuid = String::uuid();
        $sessionId = $this->Session->id();
        $date = getdate();

        return Security::hash($uuid . $sessionId . $date[0], 'sha256');
    }

    /**
     * セッションにトークンを設定する
     */
    protected function setTokenIntoSession($token) {
        if ($this->Session) {
            $this->Session->write(
                    AppController::SESSION_PARAM_TOKEN, $token);
        }
    }

    /**
     * トークンをチェックする
     * 
     * @return boolean トークンが正しければtrue。それ以外は全てfalse
     */
    protected function checkToken($formToken) {

        if (empty($formToken)) {
            return false;
        }

        if (!$this->Session) {
            return false;
        }

        $sessoinToken = $this->Session
                ->read(AppController::SESSION_PARAM_TOKEN);

        // セッションとフォームのトークンを比較し
        // 整合性をチェック
        if ($formToken === $sessoinToken) {
            return true;
        } else {
            return false;
        }
    }

}
