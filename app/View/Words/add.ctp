<?php
echo $this->Form->create('Word', array('action' => 'add'));
echo $this->Form->input('list_id', array('label' => 'list_id', 'type' => 'text'));
echo $this->Form->input('question', array('label' => 'questionを入力してください'));
echo $this->Form->input('answer', array('label' => 'answerを入力してください'));
echo $this->Form->submit('Add Word');
echo $this->Form->end();
?>

<?php echo $word; ?>
<?php echo $error; ?>