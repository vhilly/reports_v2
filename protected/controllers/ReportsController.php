<?php

  class ReportsController extends Controller{
    public function filters(){
      return array(
        'accessControl', // perform access control for CRUD operations
      );
    }
    public function accessRules(){
      return array(
        array('allow',  // allow all users to perform 'index' and 'view' actions
          'actions'=>array('index','view'),
          'users'=>array('*'),
        ),
        array('allow', // allow authenticated user to perform 'create' and 'update' actions
          'actions'=>array('voyage','accounting','advanceTicketSales','tellers','dynamicVoyages','markAsBilled','monthlyTraffic','weeklyTraffic','avgPassengerPerHour'),
          'users'=>array('@'),
        ),
        array('allow', // allow admin user to perform 'admin' and 'delete' actions
          'actions'=>array(''),
          'users'=>array('admin'),
        ),
        array('deny',  // deny all users
          'users'=>array('*'),
        ),
      );
    }
    public function actionMonthlyTraffic(){
      $this->layout='report';
      $sql="
        SELECT MONTH(departure_date) mid,MONTHNAME(departure_date) mname, 
        SUM(passenger_cnt) passenger_cnt, SUM(cargo_total) cargo_cnt, 
        SUM(business_rev+premium_rev+upgrade_rev) passenger_rev,SUM(cargo_rev) cargo_rev
        FROM voyage_report 
        WHERE YEAR(departure_date) = '2014'
        GROUP BY MONTH(departure_date)
      ";
      $result=Yii::app()->db->createCommand($sql)->queryAll();
      $this->render('monthly_traffic',compact('result'));
    }
    public function actionWeeklyTraffic(){
      $this->layout='report';
      $sql="
        SELECT WEEK(departure_date) wid,departure_date mname, 
        SUM(passenger_cnt) passenger_cnt, SUM(cargo_total) cargo_cnt, 
        SUM(business_rev+premium_rev+upgrade_rev) passenger_rev,SUM(cargo_rev) cargo_rev
        FROM voyage_report 
        WHERE YEAR(departure_date) = '2014'
        GROUP BY WEEK(departure_date)
      ";
      $result=Yii::app()->db->createCommand($sql)->queryAll();
      $this->render('weekly_traffic',compact('result'));
    }
    public function actionAvgPassengerPerHour(){
      $this->layout='report';
      $sql="
   SELECT rid,hr,route, avg(cnt) avg_cnt
        FROM(
          SELECT rid,route,count(*) cnt,HOUR(date_booked)  hr FROM booking_history WHERE status < 6 GROUP BY hr,rid,DATE(date_booked)
        )s group by hr,rid

      ";
      $result=Yii::app()->db->createCommand($sql)->queryAll();
      $this->render('avg_passenger_perhour',compact('result'));
    }
    public function actionVoyageSummary(){
      $this->layout='report';
      $sql="
        SELECT * FROM voyage_report ORDER BY departure_date DESC,departure_time DESC LIMIT 10 
      ";
      $result=Yii::app()->db->createCommand($sql)->queryAll();
      $this->render('voyage_summary',compact('result'));
    }
    public function actionVoyage($title='',$iframe=false){
      $limit=10;
      $dr=isset($_POST['date_range'])?$_POST['date_range']:date('Y-m-d').' - '.date('Y-m-d');
      $date=explode(' - ',$dr);
      $d1 = date('Y-m-d',strtotime($date[0]))." ".'00:00:00';
      $d2 = date('Y-m-d',strtotime($date[1]))." ".'23:59:59';
      $output =array();
      if($iframe)
        $this->layout='report';
      $sql="
        SELECT * FROM voyage_report WHERE departure_date BETWEEN '{$d1}' AND '{$d2}' ORDER BY departure_date DESC,departure_time DESC  LIMIT {$limit}
      ";
      $result=Yii::app()->db->createCommand($sql)->queryAll();
      $this->render('current_voyage',compact('result','title','dr','iframe'));
    }
    public function actionAccounting(){
      $routes =array(1=>'BATANGAS-CALAPAN',2=>'CALAPAN-BATANGAS');
      $route=isset($_POST['route'])?$_POST['route']:1;
      $dr=isset($_POST['date_range'])?$_POST['date_range']:date('Y-m-d').' - '.date('Y-m-d');
      $export=isset($_POST['export'])?1:0;
      $date=explode(' - ',$dr);
      $d1 = date('Y-m-d',strtotime($date[0]))." ".'00:00:00';
      $d2 = date('Y-m-d',strtotime($date[1]))." ".'23:59:59';
      $output =array();
      $temp =array();
      $sql="
      SELECT  s.code scode,p.code pcode,p.name
      FROM seating_class s
      CROSS JOIN passenger_type p
      ORDER BY s.id,p.id";
      $fields=Yii::app()->db->createCommand($sql)->queryAll();

      $sql="
      SELECT  id,name 
      FROM cargo_class 
      ";

      $fields2=Yii::app()->db->createCommand($sql)->queryAll();

      $sql="
        SELECT vid,vnumber,DATE(departure_date) dd, DATE_FORMAT(departure_date,'%H %i') departure_date, CONCAT(scode,ptcode) as sc,SUM(price_paid) amt,COUNT(id) cnt 
        FROM booking_history
        WHERE status <6 AND departure_date BETWEEN '{$d1}' AND '{$d2}' AND rid={$route}
        GROUP BY vid,sc
         ORDER BY id DESC
      ";
      $result=Yii::app()->db->createCommand($sql)->queryAll();
      $sql="
        SELECT vid,vnumber,DATE(departure_date) dd, departure_date, cargo_class as cc,SUM(price_paid) amt,COUNT(id) cnt 
        FROM cargo_history
        WHERE status <6 AND departure_date BETWEEN '{$d1}' AND '{$d2}' AND rid={$route}
        GROUP BY vid,cc
         ORDER BY id DESC
      ";
      $result2=Yii::app()->db->createCommand($sql)->queryAll();

      if($result){
        foreach($result as $r){
          //$temp[$r['pt']]=array($r['sc']=>array($r['departure_date']=>array($r['pt'],$r['sc'],$r['amt'],$r['cnt'])));
          $temp['pax']=array(
            $r['dd']=>array($r['vnumber'].' '.$r['departure_date']=>array($r['sc']=>array($r['cnt'],$r['amt']))),
           );
          $output=array_merge_recursive($temp,$output);
          $temp=array();
        }
      }
      if($result2){
        foreach($result2 as $r){
          //$temp[$r['pt']]=array($r['sc']=>array($r['departure_date']=>array($r['pt'],$r['sc'],$r['amt'],$r['cnt'])));
          $temp['cargo']=array(
            $r['dd']=>array($r['vnumber'].' '.$r['departure_date']=>array($r['cc']=>array($r['cnt'],$r['amt']))),
           );
          $output=array_merge_recursive($temp,$output);
          $temp=array();
        }
      }
      if($export)
        $this->renderPartial('accounting',compact('output','fields','fields2','dr','export','routes','route'));
      else
        $this->render('accounting',compact('output','fields','fields2','dr','export','routes','route'));

    }

    public function actionAdvanceTicketSales(){
      $model=new AdvanceTicket('search');
      $model->unsetAttributes();  // clear any default values
      $export=isset($_POST['export'])?1:0;
      $dr=isset($_POST['date_range'])?$_POST['date_range']:date('Y-m-d').' - '.date('Y-m-d');
      $date=explode(' - ',$dr);
      $d1 = date('Y-m-d',strtotime($date[0]))." ".'00:00:00';
      $d2 = date('Y-m-d',strtotime($date[1]))." ".'23:59:59';
      $c = " AND date_used BETWEEN '$d1' AND '$d2'";
      $c1 = " AND date BETWEEN '$d1' AND '$d2'";
      if(isset($_POST['date_range']))
        $model->date_range=$dr;

      if(isset($_GET['AdvanceTicket'])){
        $model->attributes=$_GET['AdvanceTicket'];
      }
      $collections=Collections::model()->findAll(array('condition'=>"1 $c1"));
      $at=AdvanceTicket::model()->findAll(array('condition'=>"status=2 $c"));
      $classes=SeatingClass::model()->findAll();
      if($export)
        $this->renderPartial('advTktSales',array('data'=>compact('at','classes','model','export','dr','collections')));
      else
        $this->render('advTktSales',array('data'=>compact('at','classes','model','export','dr','collections')));
    }
    public function actionMarkAsBilled($is_billed,$ids){
      AdvanceTicket::model()->updateAll(array('is_billed'=>$is_billed),"id IN ($ids)");
    }

  }
