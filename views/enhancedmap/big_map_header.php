<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Header for the big map
 * 
 * This file is adapted from the file Ushahidi_Web/themes/default/views/header.php
 * Originally written by the Ushahidi Team
 *
 *
 * @author     John Etherton <john@ethertontech.com>
 * @package    Enhanced Map, Ushahidi Plugin - https://github.com/jetherton/enhancedmap
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title><?php echo $site_name; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $header_block; ?>
	<?php
	// Action::header_scripts - Additional Inline Scripts from Plugins
	Event::run('ushahidi_action.header_scripts');
	?>
</head>

<body id="page" class="page-bigmap">

			<!-- logo -->
			<?php if($banner == NULL){ ?>
			<div id="logo">
				<h1><a href="<?php echo url::site();?>"><?php echo $site_name; ?></a></h1>
				<span><?php echo $site_tagline; ?></span>
			</div>
			<?php }else{ ?>
			<a href="<?php echo url::site();?>"><img src="<?php echo $banner; ?>" alt="<?php echo $site_name; ?>" /></a>
			<?php } ?>
			<!-- / logo -->

			<!-- submit incident -->
			<?php //echo $submit_btn; ?>
			<!-- / submit incident -->
			
				<!-- languages -->
				<?php echo $languages;?>
				<!-- / languages -->
				
				<!-- mainmenu -->
				<div id="mainmenu" class="clearingfix">
					<ul>
						<?php nav::main_tabs($this_page, array('contact', 'reports_submit')); ?>
						<li><a  class="active submit-incident" href="<?php echo url::site('reports/submit') ?>"><?php echo Kohana::lang('ui_main.submit') ?></a></li>
						<li style="float: right;"><a href="<?php echo url::site('mobile') ?>"><?php echo Kohana::lang('mobile.switch_to_mobile_version') ?></a></li>
					</ul>
				</div>
				<!-- / mainmenu -->
