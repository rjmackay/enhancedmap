<?php defined('SYSPATH') or die('No direct script access.');
/**
 * View for the admin map
 * 
 * This file is adapted from the file Ushahidi_Web/themes/default/views/main.php
 * Originally written by the Ushahidi Team
 *
 *
 * @author     John Etherton <john@ethertontech.com>
 * @package    Enhanced Map, Ushahidi Plugin - https://github.com/jetherton/enhancedmap
 */
?>
<?php echo Kohana::lang('enhancedmap.header_info') ?>
</div> <!--class="bg"-->
</div> <!--content-->
</div> <!--holder-->

<div id="bar"></div>
		<!-- right column -->
		<div id="right">
		       <!-- status filters -->
			<div class="stat-filters clearingfix">
				<!-- keep track of what status we're looking at -->
				<form action="">
					<input type = "hidden" value="3" name="currentStatus" id="currentStatus">
					<input type = "hidden" value="2" name="colorCurrentStatus" id="colorCurrentStatus">
				</form>

				<?php if(ORM::factory('enhancedmap_settings')->where('key', 'show_unapproved_backend')->find()->value == 'true') {?>
				<strong><?php echo Kohana::lang('enhancedmap.status_filters') ?>:</strong>
				<ul id="status_switch" class="status-filters">
					<!-- This was commented out to keep things simple for our users. I hate to cut out functionality,
					       but we need to be aware of  overloading those who may not be tech savy-->
					<li>
						<a class="active" id="status_1" href="#">
							<div class="swatch" style="background-color:#000000"></div>
							<div class="status-title">Unapproved Reports</div>
						</a>
					</li>
					<li>
						<a class="active" id="status_2" href="#">
							<div class="swatch" style="background-color:#<?php echo $default_map_all;?>"></div>
							<div class="status-title">Approved Reports</div>
						</a>
					</li>
					<!-- /show approved reports-->
					<!--  show unapproved as black
					<li>
						<a class="active" id="color_status_1" href="#">
							<div class="swatch" style="background-color:#000000"></div>
							<div class="status-title"><?php echo Kohana::lang('enhancedmap.unapproved_reports') ?></div>
						</a>
					</li>
					 /show unapproved as black -->
					
				</ul>
				<?php } //end if show_unapproved_backend?>
			</div>		       
		       <!-- /status filters -->
		


		       <!-- logic filters -->
			<div class="stat-filters clearingfix">
				<strong><?php echo Kohana::lang('enhancedmap.logical_operators') ?>:</strong>
				<!-- keep track of what status we're looking at -->
				<form action="">
					<input type = "hidden" value="or" name="currentLogicalOperator" id="currentLogicalOperator">
				</form>
				<ul id="status_switch" class="status-filters">
					<li>
						<a class="active" id="logicalOperator_1" href="#">							
							<div class="status-title"><?php echo Kohana::lang('enhancedmap.or') ?> - <span style="text-transform:none; font-size:85%;"><?php echo Kohana::lang('enhancedmap.or_details') ?></span> </div>
						</a>
					</li>
					<li>
						<a  id="logicalOperator_2" href="#">
							<div class="status-title"><?php echo Kohana::lang('enhancedmap.and') ?> - <span style="text-transform:none; font-size:85%;"><?php echo Kohana::lang('enhancedmap.and_details') ?></span></div>
						</a>
					</li>
				</ul>
			</div>		       
		       <!-- /logic filters -->



			<!-- category filters -->
				<strong><?php echo strtoupper(Kohana::lang('ui_main.category_filter'));?>: </strong>
		
			<ul id="category_switch" class="category-filters">
				<li><a class="active" id="cat_0" href="#"><div class="swatch" style="background-color:#<?php echo $default_map_all;?>"></div><div class="category-title"><?php echo Kohana::lang('enhancedmap.show_all_reports') ?></div></a></li>
				<?php
					foreach ($categories as $category => $category_info)
					{
						$category_title = $category_info[0];
						$category_color = $category_info[1];
						$category_image = '';
						$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
						if($category_info[2] != NULL && file_exists(Kohana::config('upload.relative_directory').'/'.$category_info[2])) {
							$category_image = html::image(array(
								'src'=>Kohana::config('upload.relative_directory').'/'.$category_info[2],
								'style'=>'float:left;padding-right:5px;'
								));
							$color_css = '';
						}
						//check if this category has kids
						if(count($category_info[3]) > 0)
						{
							echo '<li>';
							echo '<a style="float:right; text-align:center; width:15px; padding:2px 0px 1px 0px; " href="#" id="drop_cat_'.$category.'">+</a>';
							echo '<a  href="#" id="cat_'. $category .'"><div '.$color_css.'>'.$category_image.'</div><div class="category-title">'.$category_title.'</div></a>';
							
						}
						else
						{
							echo '<li><a href="#" id="cat_'. $category .'"><div '.$color_css.'>'.$category_image.'</div><div class="category-title">'.$category_title.'</div></a>';
						}
						// Get Children
						echo '<div class="hide" id="child_'. $category .'"><ul>';
						foreach ($category_info[3] as $child => $child_info)
						{
							$child_title = $child_info[0];
							$child_color = $child_info[1];
							$child_image = '';
							$color_css = 'class="swatch" style="background-color:#'.$child_color.'"';
							if($child_info[2] != NULL && file_exists(Kohana::config('upload.relative_directory').'/'.$child_info[2])) {
								$child_image = html::image(array(
									'src'=>Kohana::config('upload.relative_directory').'/'.$child_info[2],
									'style'=>'float:left;padding-right:5px;'
									));
								$color_css = '';
							}
							echo '<li style="padding-left:20px;"><a href="#" id="cat_'. $child .'" cat_parent="'.$category.'" ><div '.$color_css.'>'.$child_image.'</div><div class="category-title">'.$child_title.'</div></a></li>';
						}
						echo '</ul></div></li>';
					}
				?>
			</ul>
			<!-- / category filters -->
			
			<?php
			if ($layers)
			{
				?>
				<!-- Layers (KML/KMZ) -->
				<div class="cat-filters clearingfix" style="margin-top:20px;">
					<strong><?php echo Kohana::lang('ui_main.layers_filter');?> <span>[<a href="javascript:toggleLayer('kml_switch_link', 'kml_switch')" id="kml_switch_link"><?php echo Kohana::lang('ui_main.show'); ?></a>]</span></strong>
				</div>
				<br/>
				&nbsp;
				<ul id="kml_switch" class="category-filters" style="display:hidden;">
					<?php
					foreach ($layers as $layer => $layer_info)
					{
						$layer_name = $layer_info[0];
						$layer_color = $layer_info[1];
						$layer_url = $layer_info[2];
						$layer_file = $layer_info[3];
						$layer_link = (!$layer_url) ?
							url::base().Kohana::config('upload.relative_directory').'/'.$layer_file :
							$layer_url;
						echo '<li><a href="#" id="layer_'. $layer .'"
						onclick="switchLayer(\''.$layer.'\',\''.$layer_link.'\',\''.$layer_color.'\'); return false;"><div class="swatch" style="background-color:#'.$layer_color.'"></div>
						<div>'.$layer_name.'</div></a></li>';
					}
					?>
				</ul>
				<!-- /Layers -->
				<?php
			}
			?>
			
			
			<?php
			if ($shares)
			{
				?>
				<!-- Layers (Other Ushahidi Layers) -->
				<div class="cat-filters clearingfix" style="margin-top:20px;">
					<strong><?php echo Kohana::lang('ui_main.other_ushahidi_instances');?> <span>[<a href="javascript:toggleLayer('sharing_switch_link', 'sharing_switch')" id="sharing_switch_link"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span></strong>
				</div>
				<ul id="sharing_switch" class="category-filters">
					<?php
					foreach ($shares as $share => $share_info)
					{
						$sharing_name = $share_info[0];
						$sharing_color = $share_info[1];
						echo '<li><a href="#" id="share_'. $share .'"><div class="swatch" style="background-color:#'.$sharing_color.'"></div>
						<div>'.$sharing_name.'</div></a></li>';
					}
					?>
				</ul>
				<!-- /Layers -->
				<?php
			}
			?>
			
			
			<br />
		
			
			<?php
			// Action::main_sidebar - Add Items to the Entry Page Sidebar
			Event::run('ushahidi_action.main_sidebar');
			?>
	
		</div>
		<!-- / right column -->
		</div>
		<!-- / right column -->
	
		<!-- content column -->
		<div id="mapcontent">
			<?php								
				// Map and Timeline Blocks
				echo $div_map;
				echo $div_timeline;
				?>
		</div>
		<!-- / content column -->



<div> <!--class="bg"-->
<div> <!--content-->
<div> <!--holder-->