<?php
$this->start('css');
echo $this->Html->css('fancybox/jquery.fancybox');
echo $this->Html->css('index');
$this->end('css');
?>

<?php
$this->start('script');
echo $this->Html->script('vendor/jquery.fancybox.pack');
echo $this->Html->script('vendor/jquery.fancybox-media');
echo $this->Html->script('index');
$this->end('script');
?>

<div id="Slogan">
    <?php echo $this->Html->image(
        'microsite/slogan.png',
        array(
            'alt' => 'Nhắn Viber, đi Brazil'
        )
    ); ?>
</div>

<div id="Prize">
    <?php echo $this->Html->image(
        'microsite/prize.png',
        array(
            'alt' => 'Giải đặc biệt: 2 vé tới Brazil'
        )
    ); ?>
</div>

<div id="Main" class="text-center clearfix">
    <?php echo $this->Html->link(
        $this->Html->image('microsite/qr_button.png'),
        $this->QrCode->base_url . urlencode(Router::url('/', true)) . $this->QrCode->_optionsString(array()),
        array(
            'escape' => false,
            'id' => 'btnQrCode',
            'class' => 'fancybox fancybox.image'
        )
    ); ?>

    <div id="Description">
        Sự kiện diễn ra từ ngày 04/06 đến hết ngày 13/07/2014
    </div>
</div>

<div id="Columns" class="clearfix">
    <div id="Column1" class="col-xs-4">
        <h3 class="title">
            Nhập số điện thoại:
        </h3>
        <div class="thumb">
            <?php
            echo $this->Form->create(
                false,
                array(
                    'id' => 'PhoneForm',
                    'class' => 'form',
                    'role' => 'form',
                    'inputDefaults' => array(
                        'div' => 'form-group',
                        'label' => false,
                        'class' => 'form-control'
                    )
                )
            );

            echo '<div class="form-inputs">';
            echo $this->Form->input('phone', array('id' => 'txtPhone', 'value' => '+84'));
            echo $this->Form->submit('Nhận mã theo dõi', array('class' => 'btn btn-block', 'div' => 'form-group', 'id' => 'btnGetHotline'));
            echo '</div>';

            echo $this->Form->input('hotline', array('disabled' => true, 'value' => '', 'id' => 'txtHotline'));

            echo $this->Form->end();
            ?>
        </div>
    </div>

    <div id="Column2" class="col-xs-4">
        <h3 class="title boxed">
            Cách thức tham gia
        </h3>
        <div class="thumb">
            <?php echo $this->Html->image(
                'microsite/youtube.jpg',
                array(
                    'class' => 'thumb-image'
                )
            ); ?>
            <a id="openYoutube" href="http://youtu.be/8M43XnCaDQE" target="_blank" class="thumb-link">
                <span class="play"></span>
            </a>
        </div>
    </div>

    <div id="Column3" class="col-xs-4">
        <h3 class="title boxed">
            Tra cứu điểm số
        </h3>
        <div class="thumb">
            <?php echo $this->Html->image(
                'microsite/results.jpg',
                array(
                    'class' => 'thumb-image'
                )
            ); ?>
            <a id="openResults" href="#" class="thumb-link">

            </a>
        </div>
    </div>
</div>