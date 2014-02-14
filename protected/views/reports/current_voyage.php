
 <style>
   .fixWidth {
     width:70px;
     font-size:10px;
   }
   .borderLess{
      border:0px;
    }
 </style>
<div class="row-fluid">
  <div class="span12 box">
  <?php if(!$iframe):?>
  <form method=post class='well form-inline'>
  DATE RANGE<br>
  <?php $this->widget(
    'bootstrap.widgets.TbDateRangePicker',
    array(
      'name' => 'date_range',
      'options'=>array('autoclose'=>true,'format' => 'YYYY-MM-DD'),
      'value'=>$dr,
      'htmlOptions'=>array('id'=>'delivery_date'),
    )
  );
   $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Generate Report'));
  ?>
  </form>   
  <br>
  <?php endif;?>
    <div class="box-head">
     <?=$title?>
    </div>
   
   <table class='table table-condensed table-bordered' style='font-size:11px'>
    <?php foreach($result as $r):?>
    <tr>
      <th class=fixWidth>VESSEL</th>
      <th class=fixWidth>VOYAGE#</th>
      <th class=fixWidth>ROUTE</th>
      <th class=fixWidth>DEPARTURE</th>
      <th class=fixWidth>RESERVED</th>
      <th class=fixWidth>CHECKED-IN</th>
      <th class=fixWidth>BOARDED</th>
      <th class=fixWidth>NO SHOW</th>
      <th class=fixWidth>REFUNDED</th>
      <th class=fixWidth>CANCELED</th>
      <th class=fixWidth>BC</th>
      <th class=fixWidth>PC</th>
      <th class=fixWidth>TOTAL PAX</th>
      <th class=fixWidth>TOTAL CARGO</th>
      <th class=fixWidth>REVENUE (BC)</th>
      <th class=fixWidth>REVENUE (PC)</th>
      <th class=fixWidth>REVENUE (Cargo)</th>
      <th class=fixWidth>REVENUE (Upgrade)</th>
      <th class=fixWidth>TOTAL REVENUE</th>
    </tr>
    <tr>
      <td><?=$r['vessel']?></td> 
      <td><?=$r['voyage']?></td> 
      <td><?=$r['route']?></td> 
      <td><?=$r['departure_date'].' '.$r['departure_time']?></td> 
      <td><?=$r['reserved']?></td> 
      <td><?=$r['checked_in']?></td> 
      <td><?=$r['boarded']?></td> 
      <td><?=$r['no_show']?></td> 
      <td><?=$r['refunded']?></td> 
      <td><?=$r['canceled']?></td> 
      <td><?=$r['business_cnt']?></td> 
      <td><?=$r['premium_cnt']?></td> 
      <td><?=$r['passenger_cnt']?></td> 
      <td><?=$r['cargo_total']?></td> 
      <td><?=$r['business_rev']?></td> 
      <td><?=$r['premium_rev']?></td> 
      <td><?=$r['cargo_rev']?></td> 
      <td><?=$r['upgrade_rev']?></td> 
      <td><?=$r['total_rev']?></td> 
    </tr>
    <tr class=boarderLess>
      <td colspan=9>
        <?php
        $this->widget(
          'bootstrap.widgets.TbHighCharts',                                         
          array(
            'options' => array(
              'credits'=>false,
              'title'=>array('text'=>$r['vessel']),                       
              'legend'=> array(
                'align'=> 'right',
                'width'=> 150,
                'x'=> 0,
                'verticalAlign'=> 'top',
                'y'=> 30,
                'floating'=> true,
                'borderColor'=> '#CCC',
                'backgroundColor'=> 'white',
                'borderWidth'=> 1,
                'shadow' =>false
               ),
              'plotOptions'=>array(                                                 
                'pie'=>array(
                  'allowPointSelect'=>true,                                          
                  'cursor'=>'pointer',
                  'dataLabels'=>array(
                    'enabled'=>true,
                    'format'=>'</b>{point.name}</b>:{point.percentage:.1f}'
                  ),
                  'showInLegend'=>true,
                )                                          
              ),
              'series' => array(
               array('name' => 'count',
                 'type'=>'pie','data' => array(
                  array('Reserved',(int) $r['reserved']),
                  array('Checked-In',(int) $r['checked_in']),
                  array('Boarded',(int) $r['boarded']),
                  array('Seats Available',(int) 264-$r['passenger_cnt']),
                 )
               ),
              ),                                                                    
            )                                                                       
          )                                                                         
        );                                                                          
      ?>
      </td>
      <td colspan=10>
        <?php
        $this->widget(
          'bootstrap.widgets.TbHighCharts',                                         
          array(
            'options' => array(
              'credits'=>false,
              'chart'=>array('type'=>'column'),
              'title'=>array('text'=>''),                       
              'plotOptions'=>array(                                                 
                'column'=>array(
                  'stacking'=>'nomal',                                          
                  'dataLabels'=>array(
                  ),
                )                                          
              ),
              'xAxis'=>array('categories'=>array($r['vessel'])),
              'yAxis'=>array('title'=>array('text'=>'Total Revenue')),
              'legend'=> array(
                'align'=> 'right',
                'width'=> 150,
                'x'=> 0,
                'verticalAlign'=> 'top',
                'y'=> 30,
                'floating'=> true,
                'borderColor'=> '#CCC',
                'backgroundColor'=> 'white',
                'borderWidth'=> 1,
                'shadow' =>false
               ),
              'series' => array(
               array('name' => 'Cargo',
                     'data' => array((int) $r['cargo_rev'])
               ),
               array('name' => 'Business Class',
                     'data' => array((int) $r['business_rev'])
               ),
               array('name' => 'Premium Economy',
                     'data' => array((int) $r['premium_rev'])
               ),
              ),                                                                    
            )                                                                       
          )                                                                         
        );                                                                          
      ?>
     </td>
     <tr>
    <?php endforeach;?>
    </table>

    </div>
  </div>
</div>
