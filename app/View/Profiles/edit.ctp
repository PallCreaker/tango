
<?php
echo $this->Form->create('Profile', array('action' => 'edit'));
echo $this->Form->input('user_id', array('type' => 'hidden', 'default' => $profile['Profile']['user_id']));
echo $this->Form->input('color_id', array('label' => 'color_idを指定してください', 'type' => 'text'));
echo $this->Form->input('message', array('label' => 'messageを入力してください'));
echo $this->Form->submit('Edit');
echo $this->Form->end();
?>

<?php debug($profile);?>