<?php
  $yr=date('Y');
  $yr='2013';
  $weeks=array();
  $weekly_pax_rev=array();
  $weekly_pax_cnt=array();
  $weekly_cargo_rev=array();
  $weekly_cargo_cnt=array();
  foreach($result as $r){
    $weeks[]=$r['wid'];
    $weekly_pax_rev[]=(int) $r['passenger_rev'];
    $weekly_pax_cnt[]=(int) $r['passenger_cnt'];
    $weekly_cargo_rev[]=(int) $r['cargo_rev'];
    $weekly_cargo_cnt[]=(int) $r['cargo_cnt'];
  }
?>

<div class="row-fluid">
  <div class="span12 box">
    <div class="box-head">
      WEEKLY
    </div>


    <!-- PAX -->
    <!-- Rev -->
    <div class="row-fluid">
      <div class="span6">
      <?php
        $this->widget(
          'bootstrap.widgets.TbHighCharts',
          array(
            'options' => array(
              'chart'=>array('type'=>'column'),
              'colors'=>array(['#4572A7']),
              'credits'=>false,
              'title'=>array('text'=>'Revenue On Passenger'),
              'plotOptions'=>array(
                'column'=>array(
                    'dataLabels'=>array(
                        'enabled'=> true
                   )
                )
              ),
              'subtitle'=>array(
                'text'=>'Year: '.$yr
              ),
              'yAxis'=> array(
                'title'=>array(
                  'text'=>'Revenue'
                ),
              ),
              'xAxis'=>array(
               'categories'=>$weeks
              ),
              'series' => array(
                [ 
                  'name'=> 'Revenue',
                  'data' => $weekly_pax_rev
                ],
              ),
            )
          )
        );
      ?>
      </div>
    <!-- Cnt -->
      <div class="span6">
      <?php
        $this->widget(
          'bootstrap.widgets.TbHighCharts',
          array(
            'options' => array(
              'credits'=>false,
              'chart'=>array('type'=>'column'),
              'colors'=>array(['#AA4643']),
              'title'=>array('text'=>'Total Passenger'),
              'plotOptions'=>array(
                'column'=>array(
                    'dataLabels'=>array(
                        'enabled'=> true
                   )
                )
              ),
              'subtitle'=>array(
                'text'=>'Year: '.$yr
              ),
              'yAxis'=> array(
                'title'=>array(
                  'text'=>'Revenue'
                ),
              ),
              'xAxis'=>array(
               'categories'=>$weeks
              ),
              'series' => array(
                [ 
                  'name'=> 'Passenger',
                  'data' => $weekly_pax_cnt
                ],
              )
            )
          )
        );
      ?>
      </div>

    <!-- CARGO -->
    <!-- Rev -->
    <div class="row-fluid">
      <div class="span6">
      <?php
        $this->widget(
          'bootstrap.widgets.TbHighCharts',
          array(
            'options' => array(
              'colors'=>array(['#8bbc21']),
              'chart'=>array('type'=>'column'),
              'credits'=>false,
              'title'=>array('text'=>'Revenue On Cargo'),
              'plotOptions'=>array(
                'column'=>array(
                    'dataLabels'=>array(
                        'enabled'=> true
                   )
                )
              ),
              'subtitle'=>array(
                'text'=>'Year: '.$yr
              ),
              'yAxis'=> array(
                'title'=>array(
                  'text'=>'Passenger'
                ),
              ),
              'xAxis'=>array(
               'categories'=>$weeks
              ),
              'series' => array(
                [ 
                  'name'=> 'Revenue',
                  'data' => $weekly_cargo_rev
                ],
              ),
            )
          )
        );
      ?>
      </div>
    <!-- Cnt -->
      <div class="span6">
      <?php
        $this->widget(
          'bootstrap.widgets.TbHighCharts',
          array(
            'options' => array(
              'colors'=>array(['#c42525']),
              'credits'=>false,
              'chart'=>array('type'=>'column'),
              'title'=>array('text'=>'Total Cargo'),
              'plotOptions'=>array(
                'column'=>array(
                    'dataLabels'=>array(
                        'enabled'=> true
                   )
                )
              ),
              'subtitle'=>array(
                'text'=>'Year: '.$yr
              ),
              'yAxis'=> array(
                'title'=>array(
                  'text'=>'Revenue'
                ),
              ),
              'xAxis'=>array(
               'categories'=>$weeks
              ),
              'series' => array(
                [ 
                  'name'=> 'Cargo',
                  'data' => $weekly_cargo_cnt
                ],
              )
            )
          )
        );
      ?>
      </div>

    </div>
  </div>
</div>
