<?php
echo $this->Form->create('Favorite', array('action' => 'register'));
echo $this->Form->input('user_id', array('type' => 'text'));
echo $this->Form->input('word_id', array('type' => 'text'));
echo $this->Form->submit('favorite!');
echo $this->Form->end();
?>

<?php echo $favorite;?>
<?php echo $error;?>