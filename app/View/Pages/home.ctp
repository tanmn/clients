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
        '#pop',
        // $this->QrCode->base_url . urlencode(Router::url('/', true)) . $this->QrCode->_optionsString(array()),
        array(
            'escape' => false,
            'id' => 'btnQrCode',
            'class' => 'inline'
        )
    ); ?>

    <div  style="display:none" sclass="thumb" id="pop">
      <h3 style="color:#fff;text-align:center;">
                    Nhập số điện thoại:
                </h3>
        <?php
        echo $this->Form->create(
            false,
            array(
                'id' => 'QRForm',
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
        echo $this->Form->input('myphone', array('id' => 'txtQRMyPhone', 'value' => '', 'placeholder' => '01234567890'));
        echo $this->Form->submit('Nhận mã QR', array('class' => 'btn btn-block', 'div' => 'form-group', 'id' => 'btnQrGet'));
        echo '</div>';


        echo $this->Form->end();

        ?>
        <div id="abc"></div>
    </div>


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
            echo $this->Form->input('phone', array('id' => 'txtPhone', 'value' => '', 'placeholder' => '01234567890'));
            echo $this->Form->submit('Nhận mã tính điểm', array('class' => 'btn btn-block', 'div' => 'form-group', 'id' => 'btnGetHotline'));
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

<div id="Results">
    <div id="BackBox"></div>
    <div id="ResultHolder" class="row-fluid clearfix">
        <div class="col-xs-6">
            <h4>
                Cá nhân
                <small class="pull-right">Điểm</small>
            </h4>

            <ul id="TopUsers" class="result-list">
                <li>
                    <span class="position">1</span>
                    <span class="name">Cá nhân 1</span>
                    <span class="points">0</span>
                </li>
                <li>
                    <span class="position">2</span>
                    <span class="name">Cá nhân 2</span>
                    <span class="points">0</span>
                </li>
                <li>
                    <span class="position">3</span>
                    <span class="name">Cá nhân 3</span>
                    <span class="points">0</span>
                </li>
                <li>
                    <span class="position">4</span>
                    <span class="name">Cá nhân 4</span>
                    <span class="points">0</span>
                </li>
                <li>
                    <span class="position">5</span>
                    <span class="name">Cá nhân 5</span>
                    <span class="points">0</span>
                </li>
            </ul>
        </div>

        <div class="col-xs-6">
            <h4>
                Nhóm
                <small class="pull-right">Điểm</small>
            </h4>

            <ul id="TopGroups" class="result-list">
                <li>
                    <span class="name">Nhóm 1</span>
                    <span class="points">0</span>
                </li>
                <li>
                    <span class="name">Nhóm 2</span>
                    <span class="points">0</span>
                </li>
                <li>
                    <span class="name">Nhóm 3</span>
                    <span class="points">0</span>
                </li>
                <li>
                    <span class="name">Nhóm 4</span>
                    <span class="points">0</span>
                </li>
                <li>
                    <span class="name">Nhóm 5</span>
                    <span class="points">0</span>
                </li>
            </ul>
        </div>
    </div>

    <div id="ViewPoints" class="row-fluid clearfix">
        <div class="col-xs-6 col-xs-offset-3 text-center">
            <h3>Nhập số điện thoại:</h3>
            <h4>Nhập số điện thoại để biết số điểm hiện tại của bạn:</h4>

            <?php
            echo $this->Form->create(
                false,
                array(
                    'id' => 'ResultForm',
                    'class' => 'form',
                    'role' => 'form',
                    'inputDefaults' => array(
                        'div' => 'form-group',
                        'label' => false,
                        'class' => 'form-control'
                    )
                )
            );

            echo $this->Form->input('phone', array('id' => 'txtTargetPhone', 'value' => '', 'placeholder' => '01234567890'));
            echo $this->Form->submit('Hiện số điểm hiện tại của bạn', array('class' => 'btn btn-block', 'div' => false, 'id' => 'btnGetPoints'));
            echo $this->Form->input('point', array('id' => 'txtPoints', 'readonly' => true));


            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>