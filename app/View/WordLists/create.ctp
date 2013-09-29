<?php
echo $this->Form->create('WordList', array('action' => 'create'));
echo $this->Form->input('owner_id', array('label' => 'owner_id', 'type' => 'text'));
echo $this->Form->input('title', array('label' => 'titleを入力してください'));
echo $this->Form->input('description', array('label' => 'descriptionを入力してください'));
echo $this->Form->submit('Create');
echo $this->Form->end();
?>

<?php echo $word_list; ?>
<?php echo $error; ?>