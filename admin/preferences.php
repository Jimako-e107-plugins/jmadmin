<?php  

if (!defined('e107_INIT'))
{
	 exit;
}

e107::coreLan('prefs', true);

e107::getConfig()->clearPrefCache();

class adminlook_ui extends e_admin_ui
{		
		protected $pluginTitle		= LAN_JM_ADMIN_LAN_01;
		protected $pluginName		= 'jmadmin';
		protected $fields 		= NULL;				
		protected $fieldpref = array();

	 	protected $preftabs        = NULL;
		protected $prefs = array (
 
			'jm_admin_helptip'	=> 
				array('title'  => PRFLAN_285 ,
				'tab'		   => 1,
				'type'		   => 'method',
				'data'		   => NULL,
				'help'		   => '',
			), 	

	 		'jm_admin_helptext'		=> 
				array('title'  => LAN_JM_ADMIN_ADMINLOOK_LAN_01 ,
				'tab'		   => 0,
				'type'		   => 'method',
				'data'		   => 'str',
				'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_02
			), 
 
			'jm_admin_navbar_labels'		=> 
				array('title'  => PRFLAN_283 ,
				'tab'		   => 1,
				'type'		   => 'method',
				'data'		   => NULL,
				'help'		   => LAN_JM_ADMIN_ADMINLOOK_LAN_10,
			), 	
		); 

	
		public function init()
		{
 
		}

		/**
		 * User defined before pref saving logic
		 * @param $new_data
		 * @param $old_data
		 */
		public function beforePrefsSave($new_data, $old_data)
		{
			$core_pref = e107::getConfig()->getPref();
			$core_pref['admin_helptip'] 	= $new_data['jm_admin_helptip'];
			$core_pref['admin_navbar_labels'] = $new_data['jm_admin_navbar_labels'];

			e107::getConfig()->setPref($core_pref)->save(true, true);
	 
		 	e107::getConfig()->clearPrefCache();
			e107::getCache()->clearAll('system');

			/* $menu_slug = preg_split ('/\n/', $new_data['adminlook_exclude']); 
			 $new_data['adminlook_exclude'] = $menu_slug;   */
			 return $new_data;			  
		}
 
  
}

class adminlook_prefs_form_ui extends e_admin_form_ui
{
   	function jm_admin_navbar_labels($curVal,$mode) {

		if($mode == 'write') {
		$frm = e107::getForm();
		$pref = e107::pref('core');    
		$text = $frm->radio_switch('jm_admin_navbar_labels', varset($pref['admin_navbar_labels']));
		return $text;
		}
	}

	function jm_admin_helptext($curVal,$mode) {

		if($mode == 'write') {
		$frm = e107::getForm();
		$pref = e107::pref('core');    
		$text = "<div id='jm_admin_helptext'>". $frm->radio_switch('jm_admin_helptext', varset($curVal))."</div>";
		return $text;
		}
	}

	function jm_admin_helptip($curVal,$mode) {
		if($mode == 'write') {
		$frm = e107::getForm();
		$pref = e107::pref('core');    
		$text =  $frm->radio_switch('jm_admin_helptip', varset($pref['admin_helptip'])) ;
		return $text;
		}
	}	
}	

 