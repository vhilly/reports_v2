<?php print_r($result);?>
<?php if(count($result)):?>
<div class="row-fluid">
  <div class="span12 box">
    <div class="box-head">
      LAST 10 VOYAGES
    </div>
    <?php foreach($result as $res):?>
    <div class="row-fluid">
      <div class="span6">
      <?php
        $this->widget(
          'bootstrap.widgets.TbHighCharts',
          array(
            'options' => array(
              'chart'=>array('type'=>'pie','height'=>300,'width'=>300),
              'credits'=>false,
              'title'=>array('text'=>'Revenue On Passenger'),
              'tooltip' =>array(
    	        'pointFormat'=>'<b>{point.percentage}%</b>'
              ),
              'plotOptions'=>array(
                'pie' =>array(
                   'allowPointSelect' =>true,
                   'cursor'=>'pointer',
                   'dataLabels' => array(
                     'enabled'=> false,
                   ),
                   'showInLegend'=> true
                 ),
               ),
              'series' => array(
                [ 
                  'name' => 'Browser share',
                  'type' => 'pie',
                  'data' => array(
                    ['Reserved', (int) $res['reserved']],['Checked-In', (int) $res['checked_in']],
                    ['Boarded', (int) $res['boarded']],
                    ['No Show', (int) $res['no_show']],['Refunded',(int) $res['refunded']],
                    ['Canceled', (int) $res['canceled']],
                  )
                ],
              ),
            )
          )
        );
      ?>
      </div>
      <div class="span6">
      <?php
        $this->widget(
          'bootstrap.widgets.TbHighCharts',
          array(
            'options' => array(
              'chart'=>array('type'=>'pie','height'=>300,'width'=>300),
              'credits'=>false,
              'title'=>array('text'=>'Revenue On Passenger'),
              'tooltip' =>array(
    	        'pointFormat'=>'<b>{point.percentage}%</b>'
              ),
              'plotOptions'=>array(
                'pie' =>array(
                   'allowPointSelect' =>true,
                   'cursor'=>'pointer',
                   'dataLabels' => array(
                     'enabled'=> false,
                   ),
                   'showInLegend'=> true
                 ),
               ),
              'series' => array(
                [ 
                  'name' => 'Browser share',
                  'type' => 'pie',
                  'data' => array(['43434',3434],['53w5',2323])
                ],
              ),
            )
          )
        );
      ?>
    </div>
    <?php endforeach;?>
  </div>
</div>
<?php endif;?>
