<?php
echo $this->Form->create('Result', array('action' => 'register'));
echo $this->Form->input('user_id', array('type' => 'text'));
echo $this->Form->input('word_id', array('type' => 'text'));
echo $this->Form->input('status');
echo $this->Form->submit('register');
echo $this->Form->end();
?>

<?php echo $result;?>
<?php echo $error;?>