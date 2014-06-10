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
        <ul class="pc">
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

        <div class="mobie" style="display:none">
            <div class="logo">
            <?php echo $this->Html->link($this->Html->image('microsite/head_button.jpg'), '/', array('escape' => false)); ?>
            </div>

        <ul class="dropdown-menu1" style="display:none">
                   <li><img src="/img/mobie/menu_icon_4.png" /><?php echo $this->Html->link('Thể lệ tham dự', '/the-le',
                               array('class' => ($active == 'the-le' ? 'active' : '')))?></li>
                    <li><img src="/img/mobie/menu_icon_3.png" /><?php echo $this->Html->link('Sự kiện', '/su-kien',
                               array('class' => ($active == 'events' ? 'active' : ''))); ?></a></li>
                    <li><img src="/img/mobie/menu_icon_2.png" /><?php echo $this->Html->link('Nhãn dán', '/nhan-dan',
                               array('class' => ($active == 'stickers' ? 'active' : ''))); ?></li>

                    <li><img src="/img/mobie/menu_icon_1.png" /><?php echo $this->Html->link('Kết quả', '/ket-qua',
                               array('class' => ($active == 'results' ? 'active' : ''))); ?></li>
                </ul>
                <div class="dropdown-toggle1" data-toggle="dropdown"></div>
         </div>
         <div class="button-menu" style="position:relative;z-index:999">

                                 <input type="button" class="button-show"  />
                                 <div class="logo">
                                                                              <?php echo $this->Html->link($this->Html->image('microsite/head_button.jpg'), '/', array('escape' => false)); ?>
                                                                              </div>
                                 <div id="box" style="display:none">


                                         <ul class="dropdown-menu2">
                                                    <li><img src="/img/mobie/menu_icon_4.png" /><?php echo $this->Html->link('Thể lệ tham dự', '/the-le',
                                                                array('class' => ($active == 'the-le' ? 'active' : '')))?></li>
                                                     <li><img src="/img/mobie/menu_icon_3.png" /><?php echo $this->Html->link('Sự kiện', '/su-kien',
                                                                array('class' => ($active == 'events' ? 'active' : ''))); ?></a></li>
                                                     <li><img src="/img/mobie/menu_icon_2.png" /><?php echo $this->Html->link('Nhãn dán', '/nhan-dan',
                                                                array('class' => ($active == 'stickers' ? 'active' : ''))); ?></li>

                                                     <li><img src="/img/mobie/menu_icon_1.png" /><?php echo $this->Html->link('Kết quả', '/ket-qua',
                                                                array('class' => ($active == 'results' ? 'active' : ''))); ?></li>
                                                 </ul>
                                  <input type="button" class="button-hide" />
                                 </div>
                         </div>
    </div>
</div>