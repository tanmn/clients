<?php
if(empty($results)){
    if(isset($results)){
        echo '<div class="alert alert-danger">No data found.</div>';
    }

    echo $this->Form->create();
    echo $this->Form->input('phone', array('class' => 'form-control'));
    echo $this->Form->end();
}else{
    pr($results);
}

?>