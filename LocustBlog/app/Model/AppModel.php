<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    
    /**
     * BeanクラスからModelのデータを作成する
     * 
     * @param Bean $bean
     * @return array Modelのデータ
     */
    protected function createDataFromBean($bean) {
        
        // privateな変数にアクセスするためarrayにキャストして
        // 値を抜き取る
        
        $vars = (array) $bean;

        $keys = array_keys($vars);
        $values = array_values($vars);

        foreach ($keys as &$key) {
            // 制御文字に挟まれた部分を削除  
            $key = preg_replace('/\000(.+)\000/', '', $key); 
        }
        // keyを置換した配列
        $newVars = array_combine($keys, $values); 
        $modelData = array();
        
        foreach ($newVars as $varName => $varValue) {
            $underscoredName = Inflector::underscore($varName);
            $modelData[$this->useTable][$underscoredName] = $varValue;
        }

        return $modelData;
    }
}
