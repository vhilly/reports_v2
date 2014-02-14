<?php
  $hours=array();
  foreach(range(0,23) as $v){
    $hours[$v]=date('g:iA',strtotime($v.':00'));
  }
  $pax_per_hour=array();
  $series =array();
  foreach($result as $r){
    $pax_per_hour[$r['route']][$r['hr']]=(int) $r['avg_cnt'];
  }
  foreach($pax_per_hour as $k=>$p){
    $tmp=array();
    $tmp['name']=$k;
    foreach($hours as $i=>$hr){
      if(array_key_exists($i,$p))
        $tmp['data'][]=$p[$i];
      else
        $tmp['data'][]=0;
    }
    $series[]=$tmp;
  }
?>

<div class="row-fluid">
  <div class="span12 box">
    <div class="box-head">
      AVERAGE PASSENGER PER HOUR
    </div>


    <!-- PAX -->
    <!-- Rev -->
    <div class="row-fluid">
      <div class="span12">
      <?php
        $this->widget(
          'bootstrap.widgets.TbHighCharts',
          array(
            'options' => array(
              'chart'=>array('type'=>'bar','height'=>1000),
              'credits'=>false,
              'title'=>array('text'=>'Average Passenger Per Hour'),
              'plotOptions'=>array(
                'bar'=>array(
                    'dataLabels'=>array(
                        'enabled'=> true
                   )
                )
              ),
              'legend'=>array(
                'layout'=> 'vertical',
                'align'=> 'right',
                'verticalAlign'=> 'top',
                'x'=> -200,
                'y'=> 300,
                'floating'=> true,
                'borderWidth'=> 1,
                'backgroundColor'=> '#FFFFFF',
                'shadow'=> true
              ),
              'yAxis'=> array(
                'min' =>0,
                'title'=>array(
                  'text'=>'Year 2013'
                ),
                'labels'=>array('overflow'=>'justify	'),
              ),
              'xAxis'=>array(
               'categories'=>$hours
              ),
              'series' => $series
            )
          )
        );
      ?>
      </div>

    </div>
  </div>
</div>
