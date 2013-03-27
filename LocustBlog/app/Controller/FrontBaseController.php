<?php

/**
 * フロントサイド共通コントローラー
 */
class FrontBaseController extends AppController {

    /**
     * Viewの拡張子をphpに変更する
     * 
     * @var type 
     */
    public $ext = '.php';

    /**
     * アクションを呼び出す前の共通処理
     */
    public function beforeFilter() {
        parent::beforeFilter();

        $this->autoLayout = true;
    }

    /**
     * アクションを実行した後の共通処理
     */
    public function afterFilter() {
        parent::afterFilter();
    }

}