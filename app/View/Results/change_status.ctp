<?php
echo $this->Form->create('Result', array('action' => 'change_status/'.$result_array['Result']['word_id'].'/'.$result_array['Result']['user_id'].'/'));
echo $this->Form->input('word_id', array('label' => 'word_id', 'type' => 'text', 'default' => $result_array['Result']['word_id']));
echo $this->Form->input('user_id', array('label' => 'user_id', 'type' => 'text', 'default' => $result_array['Result']['user_id']));
echo $this->Form->input('status', array('label' => 'status', 'default' => $result_array['Result']['status']));
echo $this->Form->submit('register');
echo $this->Form->end();
?>

<?php echo $result;?>
<?php echo $error;?>