<?php
/* SVN FILE: $Id: default.ctp 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 *
 * @filesource
 * @copyright     Copyright 2009-2010, doot doot d.o.o. (http://gitrbug.net)
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 */
?>
<!DOCTYPE
    html PUBLIC
    "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('Gitrbug'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->meta('icon');
		echo $html->css('960/reset');
		echo $html->css('960/text');
		echo $html->css('960/960');
		echo $html->css('gitrbug');
		echo $javascript->link('/js/jquery');
		echo $javascript->link('gitrbug');
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
<!--
		<div id="header">
            <div>
			    <h1><?php echo $html->link(__('Gitrbug: I can haz filez?', true), 'http://gitrbug.net'); ?></h1>
            </div>
		</div>
-->
		<div id="content" class="container_12 cli_box">

            <div id="cl_header" class="grid_12">cl_h</div>
            <div class="clear"></div>

            <div id="cl_bleft" class="grid_1"><div id="cl_bleft_spacer"></div></div>
            <div id="cl_buffer" class="grid_10">
                <?php echo $content_for_layout; ?>
            </div>
            <div id="cl_bright" class="grid_1"><div id="cl_bright_spacer"></div></div>
            <div class="clear"></div>

            <div id="cl_fleft" class="grid_1"></div>
            <div id="cl_flash" class="grid_6"><?php $session->flash(); ?></div>
            <div id="cl_fright" class="grid_5"></div>
            <div class="clear"></div>

            <div id="cl_ileft" class="grid_2"></div>
            <div id="cl_input" class="grid_8">
                <input id="cli" type="text" name="input" />
            </div>
            <div id="cl_iright" class="grid_2"></div>

		</div>
<!--
        <div class="clear"></div>
		<div id="footer" class="container_12">
            <div class="grid_12">
    			<?php echo $html->link(
					$html->image('cake.power.gif', array('alt'=> __("Powered by Cake!", true), 'border'=>"0")),
						'http://www.cakephp.org/',
						array('target'=>'_blank'), null, false
					);
	?>
-->
            </div>
		</div>
	</div>
	<?php echo $cakeDebug; ?>
</body>
</html>
