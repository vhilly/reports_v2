
<style>
  .accnt th{
    text-align:center;
    border-bottom: 1px solid;
  }
  .accnt2 th{
    text-align:left;
    border-bottom: 1px solid;
  }
  .accnt td{
    border-left: 1px solid;
    border-bottom: 1px solid;
    text-align:center;
  }
  .accnt2 td{
    border-left: 1px solid;
    border-bottom: 1px solid;
    text-align:left;
  }
 .churba  th {
    background:#92d050;
    border-left: 1px solid;
    border-top: 1px solid;
 }
  table {width:300px;}
  table td,th{border-collapse:collapse;padding:0px;}
</style>

<div class="row-fluid">
  <div class="span12 well">
<?php if(!$export):?>
<form method=post>
ROUTE<br>
<?php  echo CHtml::dropdownList('route','',$routes,array('options'=>array($route=>array('selected'=>'selected'))));?><br>
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
 echo '<br>';
 $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Generate Report'));
 $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'success','icon'=>'share','htmlOptions'=>array('name'=>'export'),
  'label'=>'Export to Excel'));
?>
</form>   
<?php endif;?>
<?php ob_start()?>
<?php if(count($output)):?>
    <div style="overflow-x: scroll">
      <?php if(isset($output['pax'])):?>
      <table class=churba>
         <tr>
           <td valign=top>
             <table class=accnt2>
               <tr><th>DATE</th></tr>
               <tr><td>Trip No. Voyage</td></tr>
               <tr><td>No. of Trips</td></tr>
               <tr><td bgcolor=yellow>Total Revenue</td></tr>
               <tr><td>Average Revenue Per Trip</td></tr>
               <tr><td>No Of Passengers Loaded</td></tr>
               <?php foreach($fields as $f):?>
               <tr><td><?=$f['scode'].'-'.$f['name']?></td></tr>
               <?php endforeach;?>
               <tr><td>Total Passengers</td></tr>
               <tr><td>Revenue on Passengers</td></tr>
               <tr><td>Ave. Passengers Fare</td></tr>
               <tr><td>&nbsp;</td></tr>
               <tr><td>Legend: Vessel Status</td></tr>
               <tr><td>BC (Business Class)</td></tr>
               <tr><td>P/E (Premium Economy)</td></tr>
               <tr><th>DATE</th></tr>
               <tr><td>CAPACITY</td></tr>
               <tr><td>BC</td></tr>
               <tr><td>PE</td></tr>
               <tr><td>TOTAL</td></tr>
               <tr><td>Actual Pax Loaded</th></tr>
               <tr><td>BC</td></tr>
               <tr><td>PE</td></tr>
               <tr><td>Load Factor</td></tr>
               <tr><td>BC</td></tr>
               <tr><td>PE</td></tr>
               <tr><td>Total Load Factor</td></tr>
             </table>
           </td>
          <?php foreach($output['pax'] as $date=>$perdate):?>
            <td>

              <table>
                <thead>
                  <tr>
                    <th colspan=<?=count($perdate)+1?>><center><?=date('l, F j,Y',strtotime($date))?></center></th>
                  </tr>
                </thead>
                <tr>
                  <?php
                     $totalPerDate=array();
                     $paxPerSC=array();
                     $paxTotaPerDate=array();
                  ?>
                  <?php foreach($perdate as $trip=>$val):?>
                  <?php 
                    $totalPaxRev=0;
                    $totalPaxCnt=0;
                    foreach($val as $k=>$v){
                      $totalPaxRev+=$v[1];
                      $totalPaxCnt+=$v[0];
                    }
                  ?>
                  <td>

                    <table class=accnt>
                      <tr>
                        <td><?=$trip?></td>
                      </tr>
                      <tr>
                        <td>1</td>
                      </tr>
                      <tr>
                        <td bgcolor=yellow><?=number_format($totalPaxRev,2)?></td>
                      </tr>
                      <tr>
                        <td><?=number_format($totalPaxRev,2)?></td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <?php $totalPerDate[0]=count($perdate);?>
                      <?php $totalPerDate[1]=(isset($totalPerDate[1])? $totalPerDate[1]:0) + $totalPaxRev;?>
                      <?php $totalPerDate[2]=$totalPerDate[1];?>
                      <?php $totalPerDate[3]='&nbsp;';?>
                      <?php $index=4;?>
                      <?php foreach($fields as $f):?>
                        <tr>
                          <td><?=$cnt=isset($val[$f['scode'].$f['pcode']])?$val[$f['scode'].$f['pcode']][0]:0;?></td>
                        </tr>
                         <?php @$paxPerSC[$trip][$f['scode']] += $cnt?>
                         <?php @$paxPerSC['total'][$f['scode']] += $cnt?>
                         <?php $totalPerDate[$index]=(isset($totalPerDate[$index])? $totalPerDate[$index]:0) + $cnt;?>
                         <?php $index++?>
                      <?php endforeach;?>
                      <?php $totalPerDate['totalPaxCnt']=(isset($totalPerDate['totalPaxCnt'])? $totalPerDate['totalPaxCnt']:0) + $totalPaxCnt;?>
                      <?php $totalPerDate[$index+5]=$totalPerDate[1]?>
                      <?php $totalPerDate[$index+6]=number_format($totalPerDate[1]/$totalPerDate['totalPaxCnt']);?>

                      <tr>
                        <td><?=$totalPaxCnt?></td>
                      </tr>
                      <tr>
                        <td><?=number_format($totalPaxRev,2)?></td>
                      </tr>
                      <tr>
                        <td><?=number_format($totalPaxRev/$totalPaxCnt)?></td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td>&nbsp;</td></tr>
                    </table>

                  </td>
                  <?php endforeach;?>
                  <td valign=top>
                    <table class=accnt>
                       <tr><td>Total</td></tr>
                       <?php foreach($totalPerDate as $k=> $pd):?>

                       <tr><td <?=$k==1?'bgcolor=yellow':''?>><?=is_numeric($pd)?number_format($pd):$pd?></td></tr>
                       <?php endforeach;?>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td>&nbsp;</td></tr>
                    </table>
                  </td>
                </tr>

                <tr>
                  <th colspan=<?=count($perdate)+1?>><center><?=$date?></center></th>
                </tr>
                <tr>
                  <?php foreach($perdate as $trip=>$val):?>
                  <td>

                    <table class=accnt>
                      <tr>
                        <td>159</td>
                      </tr>
                      <tr>
                        <td>105</td>
                      </tr>
                      <tr>
                        <td>264</td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td><?= implode('</td></tr><tr><td>',$paxPerSC[$trip])?></td></tr>
                      <tr><td><?= array_sum($paxPerSC[$trip])?></td></tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td><?=number_format($paxPerSC[$trip]['BC']/159*100)?>%</td></tr>
                      <tr><td><?=number_format($paxPerSC[$trip]['PE']/105*100)?>%</td></tr>
                      <tr><td><?=number_format(array_sum($paxPerSC[$trip])/264*100)?>%</td></tr>
                    </table>

                  </td>
                  <?php endforeach;?>
                  <td valign=top>
                    <table class=accnt>
                      <tr><td>159</td></tr>
                      <tr><td>105</td></tr>
                      <tr><td>264</td></tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td><?=number_format($paxPerSC['total']['BC']/count($perdate))?></td></tr>
                      <tr><td><?=number_format($paxPerSC['total']['PE']/count($perdate))?></td></tr>
                      <tr><td><?=number_format($totalPerDate['totalPaxCnt']/count($perdate));?></td></tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr><td><?=number_format($paxPerSC['total']['BC']/count($perdate)/159*100)?>%</td></tr>
                      <tr><td><?=number_format($paxPerSC['total']['PE']/count($perdate)/105*100)?>%</td></tr>
                      <tr><td><?=number_format($totalPerDate['totalPaxCnt']/count($perdate)/105*100)?>%</td></tr>
                    </table>
                  </td>
                </tr>

            </table>

          </td>
          <?php endforeach;?>
        </tr>
      </table>
      <?php endif;?>

      <?php if(isset($output['pax'])):?>
       <br>
       VEHICLES FREIGHT:<br>
      <table class=churba>
         <tr>
           <td valign=top>
             <table class=accnt2>
               <tr><th>DATE</th></tr>
               <tr><td>Trip No. Voyage</td></tr>
               <tr><td>No. of Trips</td></tr>
               <tr><td bgcolor=yellow>Total Revenue</td></tr>
               <tr><td>Average Revenue Per Trip</td></tr>
               <tr><td>No Of Cargos Loaded</td></tr>
               <?php foreach($fields2 as $f):?>
               <tr><td><?=$f['name']?></td></tr>
               <?php endforeach;?>
               <tr><td>Total Cargos</td></tr>
               <tr><td>Revenue on Cargos</td></tr>
               <tr><td>Ave. Cargos Fare</td></tr>
             </table>
           </td>
          <?php foreach($output['cargo'] as $date=>$perdate):?>
            <td>

              <table>
                <thead>
                  <tr>
                    <th colspan=<?=count($perdate)+1?>><center><?=$date?></center></th>
                  </tr>
                </thead>
                <tr>
                   <?$totalPerDate=array();?>
                  <?php foreach($perdate as $trip=>$val):?>
                  <?php 
                    $totalCarRev=0;
                    $totalCarCnt=0;
                    foreach($val as $k=>$v){
                      $totalCarRev+=$v[1];
                      $totalCarCnt+=$v[0];
                    }
                  ?>
                  <td>

                    <table class=accnt>
                      <tr>
                        <td><?=$trip?></td>
                      </tr>
                      <tr>
                        <td>1</td>
                      </tr>
                      <tr>
                        <td bgcolor=yellow><?=number_format($totalCarRev,2)?></td>
                      </tr>
                      <tr>
                        <td><?=number_format($totalCarRev,2)?></td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <?php $totalPerDate[0]=count($perdate);?>
                      <?php $totalPerDate[1]=(isset($totalPerDate[1])? $totalPerDate[1]:0) + $totalCarRev;?>
                      <?php $totalPerDate[2]=$totalPerDate[1];?>
                      <?php $totalPerDate[3]='&nbsp;';?>
                      <?php $index=4;?>
                      <?php foreach($fields2 as $f):?>
                        <tr>
                          <td><?=$cnt=isset($val[$f['id']])?$val[$f['id']][0]:0;?></td>
                        </tr>
                         <?php $totalPerDate[$index]=(isset($totalPerDate[$index])? $totalPerDate[$index]:0) + $cnt;?>
                         <?php $index++?>
                      <?php endforeach;?>
                      <?php $totalPerDate[$index+4]=(isset($totalPerDate[$index+4])? $totalPerDate[$index+4]:0) + $totalCarCnt;?>
                      <?php $totalPerDate[$index+5]=$totalPerDate[1]?>
                      <?php $totalPerDate[$index+6]=number_format($totalPerDate[1]/$totalPerDate[$index+4]);?>
                      <tr>
                        <td><?=$totalCarCnt?></td>
                      </tr>
                      <tr>
                        <td><?=number_format($totalCarRev,2)?></td>
                      </tr>
                      <tr>
                        <td><?=number_format($totalCarRev/$totalCarCnt)?></td>
                      </tr>
                    </table>

                  </td>
                  <?php endforeach;?>
                  <td valign=top>
                    <table class=accnt>
                       <tr><td>Total</td></tr>
                       <?php foreach($totalPerDate as $k=> $pd):?>

                       <tr><td <?=$k==1?'bgcolor=yellow':''?>><?=is_numeric($pd)?number_format($pd):$pd?></td></tr>
                       <?php endforeach;?>
                    </table>
                  </td>
                </tr>
            </table>

          </td>
          <?php endforeach;?>
        </tr>
      </table>
      <?php endif;?>


    <div>
    <?php endif;?>
  </div>
<div>
<?php $output = ob_get_clean()?>
<?php
 if($export){
     $file ='ACCOUNTING_REPORT.xls';
      header('Pragma: public');
      header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
      header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
      header('Cache-Control: no-store, no-cache, must-revalidate');
      header('Cache-Control: pre-check=0, post-check=0, max-age=0');
      header("Pragma: no-cache");
      header("Expires: 0");
      header('Content-Transfer-Encoding: none');
      header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=$file");
 }
     echo $output;
?>

