<?php

App::uses('HtmlHelper', 'View/Helper');

/**
 * リンク機能を追加したHtmlHelper
 */
class LinkedHtmlHelper extends HtmlHelper {

    public function __construct(\View $View, $settings = array()) {
        parent::__construct($View, $settings);
    }
    
    /**
     * 
     * 指定されたcssを共通レイアウトで読み込む
     * 
     * @param type $path
     */
    public function loadCSS($path) {
        $this->css($path, null, array('inline' => false));
    }
    
    /**
     * 指定されたjavascriptを共通レイアウトで読み込む
     * 
     * @param type $path
     */
    public function loadJS($path) {
        $this->script($path, array('inline' => false));
    }

}