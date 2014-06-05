<?php
$this->start('css');
echo $this->Html->css('results');
$this->end('css');
?>

<?php
$this->start('script');
echo $this->Html->script('nicescroll.min.js');
echo $this->Html->script('results');
$this->end('script');
?>

<div id="Results" class="clearfix">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-justified">
        <li><a href="#daily" data-toggle="tab">Hằng ngày</a></li>
        <li><a href="#week1" data-toggle="tab">Tuần 1</a></li>
        <li><a href="#week2" data-toggle="tab">Tuần 2</a></li>
        <li><a href="#week3" data-toggle="tab">Tuần 3</a></li>
        <li><a href="#week4" data-toggle="tab">Tuần 4</a></li>
        <li><a href="#all" data-toggle="tab">Đặc biệt</a></li>
    </ul>

    <div id="TabContents" class="clearfix">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane" id="daily">
                <p>Kết quả người chơi có số điểm cao ngày <?php echo date('Y-m-d'); ?>:</p>
                <?php echo $this->Element('result_table'); ?>
            </div>
            <div class="tab-pane" id="week1">
                <p>Kết quả người chơi có số điểm cao tuần 1:</p>
                <?php echo $this->Element('result_table'); ?>
            </div>
            <div class="tab-pane" id="week2">
                <p>Kết quả người chơi có số điểm cao tuần 2:</p>
                <?php echo $this->Element('result_table'); ?>
            </div>
            <div class="tab-pane" id="week3">
                <p>Kết quả người chơi có số điểm cao tuần 3:</p>
                <?php echo $this->Element('result_table'); ?>
            </div>
            <div class="tab-pane" id="week4">
                <p>Kết quả người chơi có số điểm cao tuần 4:</p>
                <?php echo $this->Element('result_table'); ?>
            </div>
            <div class="tab-pane" id="all">
                <p>Kết quả người thắng chung cuộc:</p>
                <?php echo $this->Element('result_table'); ?>
            </div>
        </div>

        <div id="Figure" class="text-center" class="clearfix">
            <?php echo $this->Html->image('microsite/STICKERS_dzooo3.png'); ?>
        </div>
    </div>
</div>