<?php
class ControllerExtensionModuleInstagram extends Controller
{
	private $error = array();
	

	public function index()
	{
		$file = DIR_CATALOG . 'view/javascript/instagram/css/mycustom.css';
		$version = "2.2";

		$this->load->language('extension/module/instagram');

		$this->document->setTitle($this->language->get('heading_title'));		

		$this->document->addScript('view/javascript/instagram/spectrum/spectrum.js');
		$this->document->addStyle('view/javascript/instagram/spectrum/spectrum.css');

		$this->document->addStyle('view/javascript/instagram/codemirror/theme/ambiance.css');
		$this->document->addStyle('view/javascript/instagram/codemirror/addons/show-hint.css');
		$this->document->addStyle('view/javascript/instagram/codemirror/lib/codemirror.css');

		$this->document->addScript('view/javascript/instagram/codemirror/lib/codemirror.js');
		$this->document->addScript('view/javascript/instagram/codemirror/addons/css-hint.js');
		$this->document->addScript('view/javascript/instagram/codemirror/addons/show-hint.js');
		$this->document->addScript('view/javascript/instagram/codemirror/css.js');

		$this->document->addStyle('view/javascript/instagram/settings.css');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$css = $this->request->post['instagram_style'];
			unset($this->request->post['instagram_style']);
			$this->model_setting_setting->editSetting('instagram', $this->request->post);

			$handle = fopen($file, 'w+');

			fwrite($handle, html_entity_decode($css));

			fclose($handle);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_plugin_edit'] = $this->language->get('text_plugin_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_success_clear'] = $this->language->get('text_success_clear');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_customize_layout'] = $this->language->get('text_customize_layout');
		$data['text_log_tab'] = $this->language->get('text_log_tab');
		$data['text_slick_options'] = $this->language->get('text_slick_options');
		$data['text_slick_advanced_options'] = $this->language->get('text_slick_advanced_options');
		$data['text_api_options'] = $this->language->get('text_api_options');
		$data['text_api_advanced_options'] = $this->language->get('text_api_advanced_options');

		$data['entry_access_token'] = $this->language->get('entry_access_token');
		$data['entry_photo_amount'] = $this->language->get('entry_photo_amount');
		$data['entry_photo_size'] = $this->language->get('entry_photo_size');
		$data['entry_photo_show'] = $this->language->get('entry_photo_show');
		$data['entry_module_name'] = $this->language->get('entry_module_name');
		$data['entry_auto_play'] = $this->language->get('entry_auto_play');
		$data['entry_auto_play_speed'] = $this->language->get('entry_auto_play_speed');
		$data['entry_slide_scroll'] = $this->language->get('entry_slide_scroll');
		$data['entry_slide_dots'] = $this->language->get('entry_slide_dots');
		$data['entry_slide_arrows'] = $this->language->get('entry_slide_arrows');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_arrow_color'] = $this->language->get('entry_arrow_color');
		$data['entry_text_align'] = $this->language->get('entry_text_align');
		$data['entry_text_hover_heart'] = $this->language->get('entry_text_hover_heart');
		$data['entry_css_name'] = $this->language->get('entry_css_name');
		$data['entry_text_generate_token'] = $this->language->get('entry_text_generate_token');
		$data['entry_show_comments'] = $this->language->get('entry_show_comments');
		$data['entry_photo_show_tablet'] = $this->language->get('entry_photo_show_tablet');
		$data['entry_photo_show_celphone'] = $this->language->get('entry_photo_show_celphone');
		$data['entry_slide_scroll_tablet'] = $this->language->get('entry_slide_scroll_tablet');
		$data['entry_slide_scroll_celphone'] = $this->language->get('entry_slide_scroll_celphone');
		$data['entry_center_mode'] = $this->language->get('entry_center_mode');
		$data['entry_use_slick'] = $this->language->get('entry_use_slick');
		$data['entry_heart_color'] = $this->language->get('entry_heart_color');
		$data['entry_heart_text_color'] = $this->language->get('entry_heart_text_color');

		$data['version'] = 'Instagram Feed OC ' . VERSION . ' Module Version: ' . $version;

		$data['text_support_me'] = $this->language->get('text_support_me');
		$data['text_log'] = $this->language->get('text_log');
		$data['text_customize_css'] = $this->language->get('text_customize_css');

		$data['help_access_token'] = $this->language->get('help_access_token');
		$data['help_instagram_arrow_color'] = $this->language->get('help_instagram_arrow_color');
		$data['help_instagram_heart_color'] = $this->language->get('help_instagram_heart_color');
		$data['help_auto_play_speed'] = $this->language->get('help_auto_play_speed');
		$data['help_instagram_reset'] = $this->language->get('help_instagram_reset');
		$data['help_instagram_text_heart_color'] = $this->language->get('help_instagram_text_heart_color');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_clear'] = $this->language->get('button_clear');
		$data['button_download'] = $this->language->get('button_download');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->session->data['success_instagram'])) {
			$data['text_success_clear'] = $this->session->data['success_instagram'];

			unset($this->session->data['success_instagram']);
		} else {
			$data['text_success_clear'] = '';
		}

		if (isset($this->session->data['error_instagram'])) {
			$data['error_warning'] = $this->session->data['error_instagram'];

			unset($this->session->data['error_instagram']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['instagram_access_token'])) {
			$data['error_access_token'] = $this->error['instagram_access_token'];
		} else {
			$data['error_access_token'] = '';
		}

		if (isset($this->error['instagram_photo_amount'])) {
			$data['error_photo_amount'] = $this->error['instagram_photo_amount'];
		} else {
			$data['error_photo_amount'] = '';
		}

		if (isset($this->error['instagram_photo_size'])) {
			$data['error_photo_size'] = $this->error['instagram_photo_size'];
		} else {
			$data['error_photo_size'] = '';
		}

		if (isset($this->error['instagram_plugin_slide_show'])) {
			$data['error_slide_show'] = $this->error['instagram_plugin_slide_show'];
		} else {
			$data['error_slide_show'] = '';
		}

		if (isset($this->error['instagram_plugin_slide_show_tablet'])) {
			$data['error_slide_show_tablet'] = $this->error['instagram_plugin_slide_show_tablet'];
		} else {
			$data['error_slide_show_tablet'] = '';
		}

		if (isset($this->error['instagram_plugin_slide_show_celphone'])) {
			$data['error_slide_show_celphone'] = $this->error['instagram_plugin_slide_show_celphone'];
		} else {
			$data['error_slide_show_celphone'] = '';
		}

		if (isset($this->error['instagram_plugin_slide_scroll'])) {
			$data['error_slide_scroll'] = $this->error['instagram_plugin_slide_scroll'];
		} else {
			$data['error_slide_scroll'] = '';
		}

		if (isset($this->error['instagram_plugin_slide_scroll_tablet'])) {
			$data['error_slide_scroll_tablet'] = $this->error['instagram_plugin_slide_scroll_tablet'];
		} else {
			$data['error_slide_scroll_tablet'] = '';
		}

		if (isset($this->error['instagram_plugin_slide_scroll_celphone'])) {
			$data['error_slide_scroll_celphone'] = $this->error['instagram_plugin_slide_scroll_celphone'];
		} else {
			$data['error_slide_scroll_celphone'] = '';
		}

		if (isset($this->error['instagram_plugin_auto_play_speed'])) {
			$data['error_auto_play_speed'] = $this->error['instagram_plugin_auto_play_speed'];
		} else {
			$data['error_auto_play_speed'] = '';
		}

		if (isset($this->error['instagram_arrow_color'])) {
			$data['error_color'] = $this->error['instagram_arrow_color'];
		} else {
			$data['error_color'] = '';
		}		

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/instagram', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/instagram', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);


		if (isset($this->request->post['instagram_access_token'])) {
			$data['instagram_access_token'] = $this->request->post['instagram_access_token'];
		} else {
			$data['instagram_access_token'] = $this->config->get('instagram_access_token');
		}

		if (isset($this->request->post['instagram_photo_amount'])) {
			$data['instagram_photo_amount'] = $this->request->post['instagram_photo_amount'];
		} elseif ($this->config->get('instagram_photo_amount')) {
			$data['instagram_photo_amount'] = $this->config->get('instagram_photo_amount');
		} else {
			$data['instagram_photo_amount'] = 50;
		}

		if (isset($this->request->post['instagram_plugin_slide_show'])) {
			$data['instagram_plugin_slide_show'] = $this->request->post['instagram_plugin_slide_show'];
		} elseif ($this->config->get('instagram_plugin_slide_show')) {
			$data['instagram_plugin_slide_show'] = $this->config->get('instagram_plugin_slide_show');
		} else {
			$data['instagram_plugin_slide_show'] = 4;
		}

		if (isset($this->request->post['instagram_plugin_slide_show_tablet'])) {
			$data['instagram_plugin_slide_show_tablet'] = $this->request->post['instagram_plugin_slide_show_tablet'];
		} elseif ($this->config->get('instagram_plugin_slide_show_tablet')) {
			$data['instagram_plugin_slide_show_tablet'] = $this->config->get('instagram_plugin_slide_show_tablet');
		} else {
			$data['instagram_plugin_slide_show_tablet'] = 3;
		}

		if (isset($this->request->post['instagram_plugin_slide_show_celphone'])) {
			$data['instagram_plugin_slide_show_celphone'] = $this->request->post['instagram_plugin_slide_show_celphone'];
		} elseif ($this->config->get('instagram_plugin_slide_show_celphone')) {
			$data['instagram_plugin_slide_show_celphone'] = $this->config->get('instagram_plugin_slide_show_celphone');
		} else {
			$data['instagram_plugin_slide_show_celphone'] = 1;
		}

		if (isset($this->request->post['instagram_module_name'])) {
			$data['instagram_module_name'] = $this->request->post['instagram_module_name'];
		} elseif ($this->config->get('instagram_module_name')) {
			$data['instagram_module_name'] = $this->config->get('instagram_module_name');
		} else {
			$data['instagram_module_name'] = 'Instagram Feed';
		}

		if (isset($this->request->post['instagram_plugin_auto_play'])) {
			$data['instagram_plugin_auto_play'] = $this->request->post['instagram_plugin_auto_play'];
		} else {
			$data['instagram_plugin_auto_play'] = $this->config->get('instagram_plugin_auto_play');
		}

		if (isset($this->request->post['instagram_show_comments'])) {
			$data['instagram_show_comments'] = $this->request->post['instagram_show_comments'];
		} else {
			$data['instagram_show_comments'] = $this->config->get('instagram_show_comments');
		}

		if (isset($this->request->post['instagram_plugin_auto_play_speed'])) {
			$data['instagram_plugin_auto_play_speed'] = $this->request->post['instagram_plugin_auto_play_speed'];
		} elseif ($this->config->get('instagram_plugin_auto_play_speed')) {
			$data['instagram_plugin_auto_play_speed'] = $this->config->get('instagram_plugin_auto_play_speed');
		} else {
			$data['instagram_plugin_auto_play_speed'] = 2000;
		}

		if (isset($this->request->post['instagram_plugin_slide_scroll'])) {
			$data['instagram_plugin_slide_scroll'] = $this->request->post['instagram_plugin_slide_scroll'];
		} elseif ($this->config->get('instagram_plugin_slide_scroll')) {
			$data['instagram_plugin_slide_scroll'] = $this->config->get('instagram_plugin_slide_scroll');
		} else {
			$data['instagram_plugin_slide_scroll'] = 2;
		}

		if (isset($this->request->post['instagram_plugin_slide_scroll_tablet'])) {
			$data['instagram_plugin_slide_scroll_tablet'] = $this->request->post['instagram_plugin_slide_scroll_tablet'];
		} elseif ($this->config->get('instagram_plugin_slide_scroll_tablet')) {
			$data['instagram_plugin_slide_scroll_tablet'] = $this->config->get('instagram_plugin_slide_scroll_tablet');
		} else {
			$data['instagram_plugin_slide_scroll_tablet'] = 3;
		}

		if (isset($this->request->post['instagram_plugin_slide_scroll_celphone'])) {
			$data['instagram_plugin_slide_scroll_celphone'] = $this->request->post['instagram_plugin_slide_scroll_celphone'];
		} elseif ($this->config->get('instagram_plugin_slide_scroll_celphone')) {
			$data['instagram_plugin_slide_scroll_celphone'] = $this->config->get('instagram_plugin_slide_scroll_celphone');
		} else {
			$data['instagram_plugin_slide_scroll_celphone'] = 1;
		}

		if (isset($this->request->post['instagram_plugin_arrows'])) {
			$data['instagram_plugin_arrows'] = $this->request->post['instagram_plugin_arrows'];
		} else {
			$data['instagram_plugin_arrows'] = $this->config->get('instagram_plugin_arrows');
		}

		if (isset($this->request->post['instagram_use_plugin'])) {
			$data['instagram_use_plugin'] = $this->request->post['instagram_use_plugin'];
		} else {
			$data['instagram_use_plugin'] = $this->config->get('instagram_use_plugin');
		}

		if (isset($this->request->post['instagram_plugin_dots'])) {
			$data['instagram_plugin_dots'] = $this->request->post['instagram_plugin_dots'];
		} else {
			$data['instagram_plugin_dots'] = $this->config->get('instagram_plugin_dots');
		}

		if (isset($this->request->post['instagram_center_mode'])) {
			$data['instagram_center_mode'] = $this->request->post['instagram_center_mode'];
		} else {
			$data['instagram_center_mode'] = $this->config->get('instagram_center_mode');
		}

		if (isset($this->request->post['instagram_arrow_color'])) {
			$data['instagram_arrow_color'] = $this->request->post['instagram_arrow_color'];
		} elseif ($this->config->get('instagram_arrow_color')) {
			$data['instagram_arrow_color'] = $this->config->get('instagram_arrow_color');
		} else {
			$data['instagram_arrow_color'] = '#2096C3';
		}

		if (isset($this->request->post['instagram_heart_color'])) {
			$data['instagram_heart_color'] = $this->request->post['instagram_heart_color'];
		} elseif ($this->config->get('instagram_heart_color')) {
			$data['instagram_heart_color'] = $this->config->get('instagram_heart_color');
		} else {
			$data['instagram_heart_color'] = 'rgba(255, 255, 255, 0.9)';
		}

		if (isset($this->request->post['instagram_text_heart_color'])) {
			$data['instagram_text_heart_color'] = $this->request->post['instagram_text_heart_color'];
		} elseif ($this->config->get('instagram_text_heart_color')) {
			$data['instagram_text_heart_color'] = $this->config->get('instagram_text_heart_color');
		} else {
			$data['instagram_text_heart_color'] = '#333333';
		}

		if (isset($this->request->post['instagram_hover_heart'])) {
			$data['instagram_hover_heart'] = $this->request->post['instagram_hover_heart'];
		} else {
			$data['instagram_hover_heart'] = $this->config->get('instagram_hover_heart');
		}

		if (isset($this->request->post['instagram_text_align'])) {
			$data['instagram_text_align'] = $this->request->post['instagram_text_align'];
		} elseif ($this->config->get('instagram_text_align')) {
			$data['instagram_text_align'] = $this->config->get('instagram_text_align');
		} else {
			$data['instagram_text_align'] = 'left';
		}

		if (isset($this->request->post['instagram_status'])) {
			$data['instagram_status'] = $this->request->post['instagram_status'];
		} else {
			$data['instagram_status'] = $this->config->get('instagram_status');
		}

		if (isset($this->request->post['instagram_css_name'])) {
			$data['instagram_css_name'] = $this->request->post['instagram_css_name'];
		} elseif ($this->config->get('instagram_css_name')) {
			$data['instagram_css_name'] = $this->config->get('instagram_css_name');
		} else {
			$data['instagram_css_name'] = 'mycustom.css';
		}

		if (isset($this->request->post['instagram_style'])) {
			$data['instagram_style'] = $this->request->post['instagram_style'];
		} elseif (file_exists($file)) {
			$data['instagram_style'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$data['instagram_style'] = file_get_contents(DIR_CATALOG . 'view/javascript/instagram/css/custom.css', FILE_USE_INCLUDE_PATH, null);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['download'] = $this->url->link('extension/module/instagram/download', 'token=' . $this->session->data['token'], true);
		$data['clear'] = $this->url->link('extension/module/instagram/clear', 'token=' . $this->session->data['token'], true);
		$data['reset'] = $this->url->link('extension/module/instagram/reset', 'token=' . $this->session->data['token'], true);

		$data['log'] = '';
		$data['log_instagram'] = '';

		$file = DIR_LOGS . 'instagram.log';

		if (file_exists($file)) {
			$size = filesize($file);

			if ($size >= 5242880) {
				$suffix = array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB',
					'EB',
					'ZB',
					'YB'
				);

				$i = 0;

				while (($size / 1024) > 1) {
					$size = $size / 1024;
					$i++;
				}

				$data['error_warning'] = sprintf($this->language->get('error_warning'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
			} else {
				$data['log_instagram'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			}
		}

		$this->response->setOutput($this->load->view('extension/module/instagram', $data));
	}

	public function download()
	{
		$this->load->language('extension/module/instagram');

		$file = DIR_LOGS . 'instagram.log';

		if (file_exists($file) && filesize($file) > 0) {
			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename="' . $this->config->get('config_name') . '_' . date('Y-m-d_H-i-s', time()) . '_error.log"');
			$this->response->addheader('Content-Transfer-Encoding: binary');

			$this->response->setOutput(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
		} else {
			$this->session->data['error_instagram'] = sprintf($this->language->get('error_warning'), basename($file), '0B');

			$this->response->redirect($this->url->link('extension/module/instagram', 'token=' . $this->session->data['token'], true));
		}
	}

	public function reset()
	{
		$this->load->language('extension/module/instagram');

		$file = DIR_CATALOG . 'view/javascript/instagram/css/mycustom.css';

		if (file_exists($file)) {
			if (unlink($file)) {
				$this->session->data['success_instagram'] = $this->language->get('text_confirm_reset');
			} else {
				$this->session->data['error_instagram'] = $this->language->get('erro_reset_file');
			}
		} else {
			$this->session->data['error_instagram'] = $this->language->get('erro_reset_blank');
		}
		$this->response->redirect($this->url->link('extension/module/instagram', 'token=' . $this->session->data['token'] . '&type=module', true));
	}

	public function clear()
	{
		$this->load->language('extension/module/instagram');

		if (!$this->user->hasPermission('modify', 'extension/module/instagram')) {
			$this->session->data['error_instagram'] = $this->language->get('error_permission');
		} else {
			$file = DIR_LOGS . 'instagram.log';

			$handle = fopen($file, 'w+');

			fclose($handle);

			$this->session->data['success_instagram'] = $this->language->get('text_success_clear');
		}

		$this->response->redirect($this->url->link('extension/module/instagram', 'token=' . $this->session->data['token'] . '&type=module', true));
	}

	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'extension/module/instagram')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['instagram_access_token']) {
			$this->error['instagram_access_token'] = $this->language->get('error_access_token');
		}

		if (!is_numeric($this->request->post['instagram_photo_amount'])) {
			$this->error['instagram_photo_amount'] = $this->language->get('error_photo_amount');
		}

		if (!is_numeric($this->request->post['instagram_plugin_slide_show'])) {
			$this->error['instagram_plugin_slide_show'] = $this->language->get('error_slide_show');
		}

		if (!is_numeric($this->request->post['instagram_plugin_slide_scroll'])) {
			$this->error['instagram_plugin_slide_scroll'] = $this->language->get('error_slide_scroll');
		}

		if (!is_numeric($this->request->post['instagram_plugin_slide_show_tablet'])) {
			$this->error['instagram_plugin_slide_show_tablet'] = $this->language->get('error_slide_show_tablet');
		}

		if (!is_numeric($this->request->post['instagram_plugin_slide_show_celphone'])) {
			$this->error['instagram_plugin_slide_show_celphone'] = $this->language->get('error_slide_show_celphone');
		}

		if (!is_numeric($this->request->post['instagram_plugin_slide_scroll_tablet'])) {
			$this->error['instagram_plugin_slide_scroll_tablet'] = $this->language->get('error_slide_scroll_tablet');
		}

		if (!is_numeric($this->request->post['instagram_plugin_slide_scroll_celphone'])) {
			$this->error['instagram_plugin_slide_scroll_celphone'] = $this->language->get('error_slide_scroll_celphone');
		}

		if (!is_numeric($this->request->post['instagram_plugin_auto_play_speed'])) {
			$this->error['instagram_plugin_auto_play_speed'] = $this->language->get('error_auto_play_speed');
		}

		if (!preg_match('/^#([A-Fa-f0-9]{6})$/', $this->request->post['instagram_arrow_color'])) {
			$this->error['instagram_arrow_color'] = $this->language->get('error_color');
		}

		return !$this->error;
	}
}