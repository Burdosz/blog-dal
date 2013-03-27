<?php

/**
 * 管理者用ページ
 * 
 */
class AdminController extends AppController {
    
    public function admin_index() {
        
        $this->autoLayout = false;
        $this->autoRender = false;
        
        echo 'test';
    }
    
}