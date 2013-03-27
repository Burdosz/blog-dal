<div class="row" style="background-color: #222222;">
    <div class="span8">
    </div>
    <div class="span4 container">
        <div class="well" style="margin:20px 0px;">
            <?php
            echo $this->Html->link(
                    '新規登録', 
                    'index', 
                    array(
                        'class' => array('btn', 'btn-warning btn-block'),
                        'id'    => 'new-btn'
                    )
            );
            echo $this->Form->create(false, array('type' => 'post', 'action' => 'login',));
            echo $this->Form->input('User.account', array('type' => 'text', 'label' => 'アカウント'));
            echo $this->Form->input('User.password', array('type' => 'password', 'label' => 'パスワード'));
            ?>
            <div class="control-group error">
                <span class="help-inline">
                    <?php echo $this->Session->flash(); ?>                
                </span>
            </div>

            <?php
            echo $this->Form->end(array(
                'label' => 'ログイン',
                'class' => 'btn btn-info'
            ));
            ?>
        </div>
    </div>
</div>