<?php
echo $this->Form->create('Friend', array('action' => 'add'));
echo $this->Form->input('user_id1', array('label' => 'User1'));
echo $this->Form->input('user_id2', array('label' => 'User2'));
echo $this->Form->submit('Register');
echo $this->Form->end();
?>

<?php echo $friend;?>
<?php echo $error; ?>