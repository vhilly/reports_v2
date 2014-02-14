
  <div class="row-fluid">
      <div class="span12 box">
        <div class="row-fluid">
          <div class=span12><iframe src=<?=Yii::app()->createUrl('reports/voyage&title=CURRENT%20VOYAGE&iframe=true')?> width=100% height=500></iframe></div>
        </div>
      </div>
  </div>


  <div class="row-fluid">
      <div class="span12 box">
        <div class="row-fluid">
          <div class=span12><iframe src=<?=Yii::app()->createUrl('reports/monthlyTraffic')?> width=100% height=1000></iframe></div>
        </div>
      </div>
  </div>

  <div class="row-fluid">
    <div class="span12 box">
      <div class="row-fluid">
        <div class=span12><iframe src=<?=Yii::app()->createUrl('reports/weeklyTraffic')?> width=100% height=1000></iframe></div>
      </div>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12 box">
      <div class="row-fluid">
        <div class=span12><iframe src=<?=Yii::app()->createUrl('reports/avgPassengerPerHour')?> width=100% height=1200></iframe></div>
      </div>
    </div>
  </div>
