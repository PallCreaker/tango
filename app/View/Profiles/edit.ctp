
<?php

echo $this->Form->create('Profile', array('action' => 'edit/'.$profile_array['Profile']['user_id']));
//echo $this->Form->input('user_id', array('type' => 'hidden', 'default' => $profile_array['Profile']['user_id']));
echo $this->Form->label('color_id', 'color_idを指定してください');
echo $this->Form->select('color_id',
        array(
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            '10' => 10,
            '11' => 11,
            '12' => 12 
            )
        );
echo $this->Form->input('message', array('label' => 'messageを入力してください'));
echo $this->Form->submit('Edit');
echo $this->Form->end();
?>

<?php echo $profile; ?>
<?php echo $error; ?>