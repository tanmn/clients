<?php $download_link = 'http://viber.com/'; ?>

<div class="container text-center">
    <?php echo $this->Html->link(
        $this->Html->image('microsite/call_btn.png'),
        $download_link,
        array(
            'escape' => false,
            'target' => '_blank'
        )
    ); ?>

    <?php echo $this->Html->link(
        'Click để tải viber',
        $download_link ,
        array(
            'id' => 'download_viber',
            'target' => '_blank'
        )
    ); ?>
</div>