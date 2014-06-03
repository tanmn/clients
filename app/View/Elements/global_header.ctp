<?php
if(!isset($active)) $active = '';
?>

<div class="page-header">
    <div class="container">
        <div id="icon">
            <?php echo $this->Html->link(
                $this->Html->image('microsite/help_btn.png'),
                '/the-le',
                array('escape' => false)
            ); ?>
        </div>
        <ul>
            <li><?php echo $this->Html->link('Trang chủ', '/',
            array('class' => ($active == 'home' ? 'active' : ''))); ?></li>

            <li><?php echo $this->Html->link('Sự kiện', '/su-kien',
            array('class' => ($active == 'events' ? 'active' : ''))); ?></a></li>

            <li><?php echo $this->Html->link($this->Html->image('microsite/head_button.jpg'), '#', array('escape' => false)); ?></li>

            <li><?php echo $this->Html->link('Nhãn dán', '/nhan-dan',
            array('class' => ($active == 'stickers' ? 'active' : ''))); ?></li>

            <li><?php echo $this->Html->link('Kết quả', '/ket-qua',
            array('class' => ($active == 'results' ? 'active' : ''))); ?></li>
        </ul>
    </div>
</div>