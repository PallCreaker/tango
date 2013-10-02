<?php
echo $this->Form->create('WordList', array('controller' => 'WordLists', 'action' => 'add_friend'));
echo $this->Form->input('list_id', array('label' => 'list_id', 'type' => 'text'));
echo $this->Form->input('user_id', array('label' => 'user_id', 'type' => 'text'));
echo $this->Form->submit('Add Friend');
echo $this->Form->end();
?>

<?php echo $added_friend; ?>
<?php echo $error; ?>