<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
</head>

<body>

<div class="header">
  <?php

    $this->widget(
      'bootstrap.widgets.TbNavbar',
      array(
        'brand' => '',
        'type'=>'inverse',
        'fixed' => true,
        'fluid'=>true,
        'collapse'=>true,
        'items' => array(
          array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => array(
              '...',
              array('label' => 'Dashboard', 'url' => array('/site/index')),
              '...',
              array('label' => 'Accounting Report', 'url' => array('/reports/accounting')),
              '...',
              array('label' => 'Recent Voyages', 'url' => array('/reports/voyage&title=RECENT%20VOYAGES')),
              '...',
              array('label' => 'Advance Ticket Sales', 'url' => array('/reports/advanceTicketSales')),
              '...',
            )

          ),
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                
                array('icon'=>'icon-off','label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                array('icon'=>'off','label'=>'Logout', 'url'=>array('/site/logout'),'visible'=>!Yii::app()->user->isGuest), 
            ),
        ),
        )
      )
    );

  ?>
</div>
<div class="container-fluid" id="page">

  <div class="row-fluid">
    <?php echo $content; ?>
  </div>

	<div class="clearfix"></div>
	<div class="footer">
		<p>&copy; <?php echo date('Y'); ?> Archipelago | Philippine Ferries Corporation.<p/>
		<p>Designed by A-Team.<p/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
