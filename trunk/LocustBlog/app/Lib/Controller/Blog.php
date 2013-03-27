<?php

/**
 * Controllerでブログの情報を管理するクラス
 * 
 */
class Blog {

    /**
     * ブログのユーザーのアカウント名
     * 
     * @var string 
     */
    private $account;

    /**
     * ブログのユーザーのID
     * 
     * @var int 
     */
    private $userId;

    /**
     * ブログのユーザーのニックネーム
     * 
     * @var string 
     */
    private $nickname;

    /**
     * ブログのタイトル
     *
     * @var string
     */
    private $blogTitle;

    /**
     * 必要な情報が入っている配列で初期化したインスタンスを生成する
     * 
     * @param type $data
     */
    public function __construct($data) {
        if (empty($data)) {
            return;
        }

        if (isset($data['User'])) {

            if (isset($data['User']['id'])) {
                $this->userId = $data['User']['id'];
            }

            if (isset($data['User']['account'])) {
                $this->account = $data['User']['account'];
            }
        }

        if (isset($data['UserInfo'])) {
            if (isset($data['UserInfo']['nickname'])) {
                $this->nickname = $data['UserInfo']['nickname'];
            }
        }

        if (isset($data['BlogInfo'])) {
            if (isset($data['BlogInfo']['blog_title'])) {
                $this->blogTitle = $data['BlogInfo']['blog_title'];
            }
        }
    }

    /**
     * ユーザーIDを取得する
     * 
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * アカウントを取得する
     * 
     * @return string
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * ニックネームを取得する
     * 
     * @return string
     */
    public function getNickname() {
        return $this->nickname;
    }

    /**
     * ブログタイトルを取得する
     * 
     * @return string
     */
    public function getBlogTitle() {
        return $this->blogTitle;
    }

}