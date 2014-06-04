<?php
$this->start('css');
echo $this->Html->css('results');
$this->end('css');
?>

<?php
$this->start('script');
echo $this->Html->script('results');
$this->end('script');
?>

<div id="Results" class="clearfix">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a href="#daily" data-toggle="tab">Hằng ngày</a></li>
        <li><a href="#week1" data-toggle="tab">Tuần 1</a></li>
        <li><a href="#week2" data-toggle="tab">Tuần 2</a></li>
        <li><a href="#week3" data-toggle="tab">Tuần 3</a></li>
        <li><a href="#week4" data-toggle="tab">Tuần 4</a></li>
        <li><a href="#all" data-toggle="tab">Đặc biệt</a></li>
    </ul>

    <div id="TabContents" class="clearfix">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="daily">Đang cập nhật</div>
            <div class="tab-pane" id="week1">Đang cập nhật</div>
            <div class="tab-pane" id="week2">Đang cập nhật</div>
            <div class="tab-pane" id="week3">Đang cập nhật</div>
            <div class="tab-pane" id="week4">Đang cập nhật</div>
            <div class="tab-pane" id="all">Đang cập nhật</div>
        </div>

        <div id="Figure" class="text-center" class="clearfix">
            <?php echo $this->Html->image('microsite/winners.png'); ?>
        </div>
    </div>
</div>