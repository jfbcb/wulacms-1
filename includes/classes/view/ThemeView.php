<?php

/**
 * 模板视图.
 * @author Guangfeng
 *
 */
class ThemeView extends View {
	/**
	 *
	 * @var Smarty Smarty
	 */
	private $__smarty;

	public function __construct($data = array(), $tpl = '', $headers = array('Content-Type' => 'text/html')) {
		if (!isset ($headers ['Content-Type'])) {
			$headers ['Content-Type'] = 'text/html';
		}
		parent::__construct($data, $tpl, $headers);
		$basedir = THEME_PATH;
		$tpl     = $basedir . $this->tpl;
		$devMod  = bcfg('develop_mode');
		if (is_file($tpl)) {
			$this->__smarty = new Smarty ();
			$this->__smarty->setTemplateDir($basedir);
			$tpl = str_replace(DS, '/', $this->tpl);
			$tpl = explode('/', $tpl);
			array_pop($tpl);
			$sub = implode(DS, $tpl);
			$this->__smarty->setCompileDir(TMP_PATH . 'themes_c' . DS . $sub);
			$this->__smarty->setCacheDir(TMP_PATH . 'themes_cache' . DS . $sub);
			$this->__smarty = apply_filter('init_smarty_engine', $this->__smarty);
			$this->__smarty = apply_filter('init_template_smarty_engine', $this->__smarty);
			if ($devMod) {
				$this->__smarty->compile_check   = true;
				$this->__smarty->caching         = false;
				$this->__smarty->debugging_ctrl  = 'URL';
				$this->__smarty->smarty_debug_id = '_debug_tpl';
				$this->__smarty->setDebugTemplate(SMARTY_DIR . 'debug.tpl');
			} else {
				$this->__smarty->compile_check = false;
			}
			$this->__smarty->_dir_perms      = 0755;
			$this->__smarty->error_reporting = KS_ERROR_REPORT_LEVEL;
		} else {
			if ($devMod) {
				die ('The view template ' . $tpl . ' is not found');
			}
			trigger_error('The view template ' . $tpl . ' is not found', E_USER_ERROR);
		}
	}

	/**
	 * 绘制.
	 */
	public function render() {
		$data = $this->data;
		$this->__smarty->assign($data);
		$this->__smarty->assign('_css_files', $this->sytles);
		$this->__smarty->assign('_js_files', $this->scripts);
		if (Request::$SESSION_STARTED) {
			$this->__smarty->assign('_SessionID', session_id());
			$this->__smarty->assign('_SessionName', get_session_name());
		}
		$this->__smarty->assign('_current_template_file', $this->tpl);
		ob_start();
		$this->__smarty->display($this->tpl);
		$content = ob_get_clean();
		if (!empty ($content)) {
			$pattern = '#(<!--placeholder:([a-z][\d\w_]*)-->)(?:(?!<!--?/placeholder*-->)[\s\S])*(<!--/placeholder:\2-->)#m';
			if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
				foreach ($matches as $key => $val) {
					$search  = $val [0];
					$keyword = $val [2];
					$replace = apply_filter('replace_placeholder_' . $keyword, false);
					if ($replace) {
						$content = str_replace($search, $replace, $content);
					} else {
						$content = str_replace(array($val [1], $val [3]), '', $content);
					}
				}
			}
		}

		return $content;
	}
}