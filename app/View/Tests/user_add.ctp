<?php
echo $this->Form->create('User', array('action' => 'add'));
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->input('screen_name');
echo $this->Form->submit('submit');
echo $this->Form->end();
?>