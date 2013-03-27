<?php

App::uses('CategoryBean', 'Lib/Bean');
App::uses('Util', 'Lib/Common');

/**
 * Categoryテーブル用モデルクラス
 */
class Category extends AppModel {

    /** テーブル名 */
    public $useTable = 'Category';

    /** バリデーション */
    public $validate = array(
        'user_id' => array(
            'notEmpty' => array(
                'rule'    => 'notEmpty',
                'message' => 'ユーザーIDが不正です'
            ),
            'naturalNumber' => array(
                'rule'    => array('naturalNumber', false),
                'message' => 'ユーザーIDが不正です'
            ),
        ),
        'category_name' => array(
            'notEmpty' => array(
                'rule'    => 'notEmpty',
                'message' => 'カテゴリ名が未入力です'
            ),
            'maxLength' => array(
                'rule'    => array('maxLength', 100),
                'message' => 'カテゴリ名は100文字以内にしてください'
            )
        )
    );

    /**
     * UserIdからカテゴリの一覧を取得する
     * 
     * @param type $userId
     */
    public function getCategoryList($userId) {

        $options = array(
            'conditions' => array(
                'Category.user_id' => $userId,
                'Category.delete_flg' => 0
            )
        );

        return $this->find('all', $options);
    }

    /**
     * カテゴリIDからカテゴリを検索する
     * セキュリティのためユーザーIDも検索条件に含める
     * 
     * @param type $categoryId カテゴリのID
     * @param type $userId ユーザーのID
     * @return 検索結果
     */
    public function findCategory($categoryId, $userId) {

        $options = array(
            'conditions' => array(
                'Category.id' => $categoryId,
                'Category.user_id' => $userId,
                'Category.delete_flg' => 0
            )
        );
        
        $result = $this->find('first', $options);
        
        if (empty($result)) {
            return null;
        }
        
        return Util::createBeanFromData('CategoryBean', $result);
    }

    /**
     * UserIdからカテゴリの一覧を取得する
     * 
     * @param int $userId
     */
    public function findCategoriesByUserId($userId) {

        $options = array(
            'conditions' => array(
                'Category.user_id' => $userId,
                'Category.delete_flg' => 0
            )
        );

        $result = $this->find('all', $options);

        if (empty($result)) {
            return null;
        }

        $categories = array();

        foreach ($result as $row) {
            $category = new CategoryBean();

            $category->setUserId($userId);
            $category->setId($row['Category']['id']);
            $category->setCategoryName($row['Category']['category_name']);

            $categories[] = $category;
        }

        return $categories;
    }

    /**
     * カテゴリを新規登録する
     * 
     * @param CategoryBean $category 新規登録用の情報を持ったインスタンス
     * @return bool 登録成功か否か
     */
    public function insertCategory(CategoryBean $category) {

        // 新規登録なので強制的にidをnullに設定する
        $db = $this->getDataSource();

        $category->setId(null);
        $category->setCreateDate($db->expression('NOW()'));
        $category->setUpdateDate(null);
        $category->setDeleteFlg(false);


        $newCategory = $this->createDataFromBean($category);

        $result = $this->save($newCategory);

        if (empty($result)) {
            return false;
        }

        return true;
    }
    
    /**
     * カテゴリを更新する
     * 
     * @param CategoryBean $category
     */
    public function updateCategory(CategoryBean $category) {
        $category->setUpdateDate(null);
        $categoryData = $this->createDataFromBean($category);
        $result = $this->save($categoryData);
        
        if (empty($result)) {
            return false;
        }
        
        return true;
    }

}