<?php
  $months=array();
  $monthly_pax_rev=array();
  $monthly_pax_cnt=array();
  $monthly_cargo_rev=array();
  $monthly_cargo_cnt=array();
  foreach($result as $r){
    $months[]=$r['mname'];
    $monthly_pax_rev[]=(int) $r['passenger_rev'];
    $monthly_pax_cnt[]=(int) $r['passenger_cnt'];
    $monthly_cargo_rev[]=(int) $r['cargo_rev'];
    $monthly_cargo_cnt[]=(int) $r['cargo_cnt'];
  }
?>

<div class="row-fluid">
  <div class="span12 box">
    <div class="box-head">
      MONTHLY
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
              'colors'=>array('#4572A7'),
              'credits'=>false,
              'title'=>array('text'=>'Revenue On Passenger'),
              'plotOptions'=>array(
                'column'=>array(
                    'dataLabels'=>array(
                        'enabled'=> true
                   )
                )
              ),
              'yAxis'=> array(
                'title'=>array(
                  'text'=>'Revenue'
                ),
              ),
              'xAxis'=>array(
               'categories'=>$months
              ),
              'series' => array(
                array( 
                  'name'=> 'Monthly',
                  'data' => $monthly_pax_rev
                ),
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
              'colors'=>array('#AA4643'),
              'title'=>array('text'=>'Total Passenger'),
              'plotOptions'=>array(
                'column'=>array(
                    'dataLabels'=>array(
                        'enabled'=> true
                   )
                )
              ),
              'yAxis'=> array(
                'title'=>array(
                  'text'=>'Revenue'
                ),
              ),
              'xAxis'=>array(
               'categories'=>$months
              ),
              'series' => array(
                array( 
                  'name'=> 'Monthly',
                  'data' => $monthly_pax_cnt
                ),
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
              'chart'=>array('type'=>'column'),
              'colors'=>array('#8bbc21'),
              'credits'=>false,
              'title'=>array('text'=>'Revenue On Cargo'),
              'plotOptions'=>array(
                'column'=>array(
                    'dataLabels'=>array(
                        'enabled'=> true
                   )
                )
              ),
              'yAxis'=> array(
                'title'=>array(
                  'text'=>'Revenue'
                ),
              ),
              'xAxis'=>array(
               'categories'=>$months
              ),
              'series' => array(
                array( 
                  'name'=> 'Monthly',
                  'data' => $monthly_cargo_rev
                ),
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
              'colors'=>array('#c42525'),
              'title'=>array('text'=>'Total Cargo'),
              'plotOptions'=>array(
                'column'=>array(
                    'dataLabels'=>array(
                        'enabled'=> true
                   )
                )
              ),
              'yAxis'=> array(
                'title'=>array(
                  'text'=>'Revenue'
                ),
              ),
              'xAxis'=>array(
               'categories'=>$months
              ),
              'series' => array(
                array( 
                  'name'=> 'Monthly',
                  'data' => $monthly_cargo_cnt
                ),
              )
            )
          )
        );
      ?>
      </div>

    </div>
  </div>
</div>
