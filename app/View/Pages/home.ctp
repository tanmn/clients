<?php $this->start('css'); ?>
<style type="text/css">
    #Main{
        padding-top: 310px;
    }

    #Main a:hover img{
        margin-top: -1px;
        margin-bottom: 1px
    }

    #Description{
        width: 200px;
        margin: auto;
    }

    #Slogan{
        position: absolute;
        top: 15px;
        right: 20px;
    }

    #Prize{
        position: absolute;
        top: 190px;
        right: 140px;
    }
</style>
<?php $this->end('css'); ?>

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
        '#',
        array(
            'escape' => false
        )
    ); ?>

    <div id="Description">
        Sự kiện diễn ra từ ngày 04/06 đến hết ngày 13/07/2014
    </div>
</div>