<?php    
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 JMAdmin Plugin
 *
 * #######################################
 * #     e107 website system plugin      #
 * #     by Jimako                    	 #
 * #     https://www.e107sk.com          #
 * #######################################
 */ 

require_once('../../class2.php');

if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}
e107::coreLan('prefs', true);
e107::lan('jmadmin',true);
 
class jmadmin_adminArea extends e_admin_dispatcher
{
	protected $modes = array(	

		'adminlook'	=> array(
			'controller' 	=> 'adminlook_ui',
			'path' 			=> "admin/preferences.php", 
			'ui' 			=>  'adminlook_prefs_form_ui',
			'uipath' 		=> "admin/preferences.php", 
		),

		'main'	=> array(
			'controller' 	=> 'adminlookx_ui',
			'path' 			=> null,
			'ui' 			=> null,
			'uipath' 		=> null
		),	
		'prefs'	=> array(
			'controller' 	=> 'dashboard_ui',
			'path' 			=> "admin/preferences.php",
			'ui' 			=> null,
			'uipath' 		=> null
		),		
	);	

	protected $adminMenu = array( 
		'adminlook/prefs'	=> array('caption'=>  PRFLAN_77,    'perm' => 'P'),
		'main/prefs' 		=> array('caption'=>  LAN_JM_ADMIN_LAN_03,    'perm' => 'P'),
		'prefs/prefs' 		=> array('caption'=>  LAN_JM_ADMIN_LAN_04,    'perm' => 'P')
	);   
	
	protected $adminMenuAliases = array();

	protected $menuTitle = LAN_JM_ADMIN_LAN_02; 
}
				
class adminlookx_ui extends e_admin_ui
{		
		protected $pluginTitle		= LAN_JM_ADMIN_LAN_01;
		protected $pluginName		= 'jmadmin';
		protected $listOrder		= ' DESC';	
		protected $fields 		= NULL;				
		protected $fieldpref = array();

	 	protected $preftabs        = array();
		protected $prefs = array (
  
			'adminlook_kadmin'		=> 
				array('title'  => LAN_JM_ADMIN_ADMINLOOK_LAN_03 ,
				'tab'		   => 0,
				'type'		   => 'boolean',
				'data'		   => 'str',
				'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_04,
			), 	
			'kadmin_lightmenu_bg'		=> 
				array('title'  => "Right Light Admin Menu (Light background with Dark text)" ,
				'tab'		   => 0,
				'type'		   => 'text',
				'data'		   => 'str',
				'help'		   => 'Recommended #DDD',
				'writeParms'   => array( 
					'default'  => '#DDDDDD',
					'pre'      => '<div class="col-md-2 ecp input-group colorpicker-component colorpicker-element">',
					'post'     => '<span class="input-group-addon"><i></i></span></div>' 
				),
			), 

			'kadmin_dark_text'		=> 
				array('title'  => "Defaul Body Text Color (Dark color on Light Background)" ,
				'tab'		   => 0,
				'type'		   => 'text',
				'data'		   => 'str',
				'help'		   => 'Recommended #222 ',
				'writeParms'   => array( 
					'default'  => '#222',
					'pre'      => '<div class="col-md-2 ecp input-group colorpicker-component colorpicker-element">',
					'post'     => '<span class="input-group-addon"><i></i></span></div>' 
				),
			), 	
	
			'kadmin_darkmenu_bg'		=> 
				array('title'  => "Left Dark Admin Menu (Dark background with light text)" ,
				'tab'		   => 0,
				'type'		   => 'text',
				'data'		   => 'str',
				'help'		   => 'Recommended #3C3C3C',
				'writeParms'   => array( 
					'default'  => '#3C3C3C',
					'pre'      => '<div class="col-md-2 ecp input-group colorpicker-component colorpicker-element">',
					'post'     => '<span class="input-group-addon"><i></i></span></div>' 
				),
			), 	
			'kadmin_light_text'		=> 
				array('title'  => "Menu Text Color (Light color on Dark Background)" ,
				'tab'		   => 0,
				'type'		   => 'text',
				'data'		   => 'str',
				'help'		   => 'Recommended #e5e5e5 ',
				'writeParms'   => array( 
					'default'  => '#e5e5e5 ',
 					'pre'      => '<div class="col-md-2 ecp input-group colorpicker-component colorpicker-element">',
					'post'     => '<span class="input-group-addon"><i></i></span></div>' 
				),
			), 
			'kadmin_primary_bg'		=> 
				array('title'  => LAN_JM_ADMIN_ADMINLOOK_LAN_05 ,
				'tab'		   => 0,
				'type'		   => 'text',
				'data'		   => 'str',
				'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_07,
				'writeParms'   => array( 
					'default'  => '#dc6767',
					'pre'  	   => '<div class="col-md-2 ecp input-group colorpicker-component colorpicker-element">',
					'post'     => '<span class="input-group-addon"><i></i></span></div>' ),
			),         
			'kadmin_primary_text'		=> 
				array('title'  => LAN_JM_ADMIN_ADMINLOOK_LAN_06 ,
				'tab'		   => 0,
				'type'		   => 'text',
				'data'		   => 'str',
				'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_08,
				'writeParms'   => array( 
                    'default'  => '#fefefe',
					'pre'      => '<div class="col-md-2 ecp input-group colorpicker-component colorpicker-element">',
					'post'     => '<span class="input-group-addon"><i></i></span></div>' ),
			),  
			'kadmin_primary_bg_hover'		=> 
				array('title'  => "Primary Background on Hover" ,
				'tab'		   => 1,
				'type'		   => 'text',
				'data'		   => 'str',
				'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_07,
				'writeParms'   => array( 
					'default'  => '#dc6767',
					'pre'  	   => '<div class="col-md-2 ecp input-group colorpicker-component colorpicker-element">',
					'post'     => '<span class="input-group-addon"><i></i></span></div>' ),
			),         
			'kadmin_primary_text_hover'		=> 
				array('title'  => "Text on Primary Background on Hover" ,  
				'tab'		   => 1,
				'type'		   => 'text',
				'data'		   => 'str',
				'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_08,
				'writeParms'   => array( 
					'default'  => '#eee',
					'pre'      => '<div class="col-md-2 ecp input-group colorpicker-component colorpicker-element">',
					'post'     => '<span class="input-group-addon"><i></i></span></div>' ),
			), 
			'kadmin_white_bg'		=> 
				array('title'  => "White Admin UI background" ,
				'tab'		   => 1,
				'type'		   => 'text',
				'data'		   => 'str',
				'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_07,
				'writeParms'   => array( 
					'default'  => '#fefefe',
					'pre'  	   => '<div class="col-md-2 ecp input-group colorpicker-component colorpicker-element">',
					'post'     => '<span class="input-group-addon"><i></i></span></div>' ),
			),  			
			
 	    
		); 

	
		public function init()
		{
			// Set drop-down values (if any). 
		}

		/**
		 * User defined before pref saving logic
		 * @param $new_data
		 * @param $old_data
		 */
		public function beforePrefsSave($new_data, $old_data)
		{
	 
			/* $menu_slug = preg_split ('/\n/', $new_data['adminlook_exclude']); 
			 $new_data['adminlook_exclude'] = $menu_slug;   */
			 return $new_data;			  
		}
 
 
     	public function renderHelp()
    	{
    		$tp = e107::getParser();
    		$hide_help= e107::getPlugConfig('simplepage')->getPref('hide_help'); 
    		if($hide_help) 
    		{
    			return '';
    		}
    		$text =
    		'
    			<ul class="list-unstyled text-center">
    				<li><b>Enhanced Admin Area</b></li>
    				<li>Way how to customize bootstrap3 dark skin and white label e107 dashboard</li>
    				<li style="border-bottom: solid 1px dimgrey" class="divider">&nbsp;</li>
    				<li>
    					<h5>' . e107::getParser()->toGlyph('fa-heart') . '&nbsp;Thank the Developer!</h5>
    				</li>
    				<li>
    					<p>
    						<small>If you think this plugin is useful, please consider supporting what I do.</small>
    					</p>
    				</li>
    				<li class="text-center">
    					<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FKG5N3F6QL99J" rel="nofollow">
    					<img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="Paypal" style="max-width:100%;"></a>
    				</li>
    				 
    			
    				<li class="text-center">
    					<p>
    						<small>Thank you</small>
    					 ' . e107::getParser()->toGlyph('fa-smile-o') .'</p>
    				</li>
    			</ul> ';                 
    		 
    		return array('caption' => "Admin plugin", 'text' => $text);
    	}
}

class dashboard_ui extends adminlookx_ui
{
	protected $preftabs        = array(LAN_JM_ADMIN_LAN_04 );

	protected $prefs = array (  			
		
		'dashboard_remove_stats'		=> 
			array('title'  => LAN_JM_ADMIN_ADMINLOOK_LAN_11 ,
			'tab'		   => 0,
			'type'		   => 'boolean',
			'data'		   => 'str',
			'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_12
		), 	
		'dashboard_remove_news'		=> 
			array('title'  => LAN_JM_ADMIN_ADMINLOOK_LAN_13 ,
			'tab'		   => 0,
			'type'		   => 'boolean',
			'data'		   => 'str',
			'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_14
		),
		'remove_e107links' => 
			array('title'  => LAN_JM_ADMIN_ADMINLOOK_LAN_15 ,
			'tab'		   => 0,
			'type'		   => 'boolean',
			'data'		   => 'str',
			'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_16
		), 	    
	); 
}

 
e107::js('jmadmin', 'admin/admin.js', 'jquery');

		
new jmadmin_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>