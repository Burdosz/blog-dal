<?php

/**
 * 共通ロジッククラス
 */
class Util {

    public static function createBeanFromData($beanClassName, $data) {
        if (empty($beanClassName) || empty($data)) {
            return null;
        } else if (!is_string($beanClassName) || !is_array($data)) {
            return null;
        }

        $bean = new $beanClassName();

        // データはスネークケースで入ってくるので
        // キャメルケースに直してメソッド名として利用する
        foreach ($data as $modelName => $params) {
            foreach ($params as $varName => $value) {
                $varNameUpper = Inflector::camelize($varName);
                $methodName = 'set' . $varNameUpper;
                $bean->$methodName($value);
            }
        }
        
        return $bean;
    }
    
    public static function getDate() {
        date_default_timezone_set('Asia/Tokyo');
        return getdate();
    }

}