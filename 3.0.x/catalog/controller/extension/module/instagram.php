<?php
class ControllerExtensionModuleInstagram extends Controller {
	public function index() {

		ini_set('xdebug.var_display_max_depth', 5);
		ini_set('xdebug.var_display_max_children', 256);
		ini_set('xdebug.var_display_max_data', 1024);

		$file = DIR_APPLICATION . 'view/javascript/instagram/css/mycustom.css';
		$filename = 'instagram.log';

		$this->load->language('extension/module/instagram');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$this->document->addStyle('catalog/view/javascript/instagram/settings.css');

		$this->document->addStyle('catalog/view/javascript/instagram/slick/slick.css');
		$this->document->addStyle('catalog/view/javascript/instagram/slick/slick-theme.css');

		if( file_exists($file) ){
			$this->document->addStyle('catalog/view/javascript/instagram/css/mycustom.css');
		}else{			
			$this->document->addStyle('catalog/view/javascript/instagram/css/custom.css');
		}

		$this->document->addScript('catalog/view/javascript/instagram/slick/slick.min.js');
		
		$json_link="https://api.instagram.com/v1/users/self/media/recent/?";

		if ($this->request->server['HTTPS']) {
			$json_link.="access_token=".str_replace('http', 'https', $this->config->get('module_instagram_access_token'))."&count={$this->config->get('module_instagram_photo_amount')}";	
		} else {
			$json_link.="access_token=".$this->config->get('module_instagram_access_token')."&count={$this->config->get('module_instagram_photo_amount')}";		
		}

		$data['log'] = '';
		$data['error_warning'] = '';		

		$cUrl = curl_init();

		curl_setopt($cUrl, CURLOPT_URL, $json_link);
		curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, true);

		$returnCurl = curl_exec($cUrl);

		if($returnCurl){
			$json = $returnCurl;
			$instagram = json_decode($json, true);
			$index = 0;			

			foreach ($instagram['data'] as $instagram ) {				
				$data['instagrams'][] = array(
					'href'  => $instagram['link'],
					'likes' => $instagram['likes']['count'],				
					'img' 	=> str_replace('http://', 'https://', $instagram['images']['standard_resolution']['url']),
					'text'	=> $instagram['caption']['text']						
				);
			}

			$data['entry_instagram'] 	= $this->config->get('module_instagram_module_name');

			$data['slidesToShow'] 		= $this->config->get('module_instagram_plugin_slide_show');		
			$data['slidesToScroll'] 	= $this->config->get('module_instagram_plugin_slide_scroll');
			$data['autoplay'] 			= ($this->config->get('module_instagram_plugin_auto_play')) ? 'true': 'false';
			$data['autoplaySpeed'] 		= $this->config->get('module_instagram_plugin_auto_play_speed');
			$data['dots'] 				= ($this->config->get('module_instagram_plugin_dots')) ? 'true': 'false';
			$data['arrows'] 			= ($this->config->get('module_instagram_plugin_arrows')) ? 'true': 'false';

			$data['heart_color'] 		= $this->config->get('module_instagram_heart_color');
			$data['heart_text_color'] 	= $this->config->get('module_instagram_text_heart_color');

			$data['slidesToShowTablet'] 	= $this->config->get('module_instagram_plugin_slide_show_tablet');
			$data['slidesToScrollTablet'] 	= $this->config->get('module_instagram_plugin_slide_scroll_tablet');
			$data['slidesToShowCelphone'] 	= $this->config->get('module_instagram_plugin_slide_show_celphone');
			$data['slidesToScrollCelphone'] = $this->config->get('module_instagram_plugin_slide_scroll_celphone');
			$data['center_mode']			= ($this->config->get('module_instagram_center_mode'))? 'centerMode: true,': false;

			$data['color'] = $this->config->get('module_instagram_arrow_color');
			$data['text_align'] = $this->config->get('module_instagram_text_align');
			$data['hover_effect'] = ($this->config->get('module_instagram_hover_heart')) ? 'hover-on' : '' ;

			return $this->load->view('extension/module/instagram', $data);
		} else {
			$this->log = new log($filename);
			$this->log->write(file_get_contents($json_link));
		}
	}
}