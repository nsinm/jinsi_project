<?php

class VoteimgAction extends WapAction
{
	public $token;
	public $action_id;
	public $voter;
	public $todaytime;
	public $now;
	public $action;
	public $vote_date;

	public function _initialize()
	{
		parent::_initialize();
		$this->token = $this->_request('token', 'trim');
		$this->action_id = $this->_request('id', 'intval');
		$this->todaytime = strtotime(date('Y-m-d 00:00:00', time()));
		$this->now = time();
		$this->voter = M('voteimg_users')->where(array('vote_id' => $this->action_id, 'token' => $this->token, 'wecha_id' => $this->wecha_id))->find();
		$this->action = M('voteimg')->where(array('id' => $this->action_id, 'token' => $this->token, 'display' => 1))->find();
		M('voteimg_menus')->where(array(
	'vote_id'   => $this->action_id,
	'token'     => $this->token,
	'type'      => 2,
	'menu_name' => array('like', '活动日期%至%')
	))->save(array('menu_name' => '活动日期'));

		if ($this->action['apply_end_time'] < time()) {
			$this->assign('disabled', 'disabled = \'disabled\'');
			$this->assign('allow_apply', 'over');
		}
		else if (time() < $this->action['apply_start_time']) {
			$this->assign('disabled', 'disabled = \'disabled\'');
			$this->assign('allow_apply', 'wait');
		}
		else {
			$this->assign('disabled', '');
			$this->assign('allow_apply', '');
		}

		if ($this->action['end_time'] < time()) {
			$this->vote_date = 'over';
			$this->assign('vote_date', $this->vote_date);
		}
		else if (time() < $this->action['start_time']) {
			$this->vote_date = 'wait';
			$this->assign('vote_date', $this->vote_date);
		}
		else {
			$this->vote_date = '';
			$this->assign('vote_date', $this->vote_date);
		}
	}

	public function index()
	{
		if (empty($this->action_id) || empty($this->token)) {
			$this->error('非法操作');
			exit();
		}

		$this->notice($this->action_id, $this->token);
		$action_info = M('voteimg')->where(array('id' => $this->action_id, 'token' => $this->token, 'display' => 1))->find();

		if (!empty($action_info)) {
			$this->assign('action_info', $action_info);
		}
		else {
			$this->error('活动不存在或未开启');
			exit();
		}

		$this->add_users();
		$type = trim($this->_request('type'));
		$where_index = 'token = \'' . $this->token . '\' AND vote_id = ' . $this->action_id . ' AND check_pass = 1';
		if (($type == 'new') || ($type == '')) {
			$order = 'baby_id desc';
		}
		else {
			$order = 'baby_id asc';
		}

		$key_word = trim($this->_request('key_word'));

		if (!empty($key_word)) {
			C('TOKEN_ON', false);

			if (is_numeric($key_word)) {
				$where_index .= ' AND baby_id = ' . (int) $key_word;
			}
			else {
				$where_index .= ' AND vote_title like \'%' . $key_word . '%\'';
			}

			$item = M('voteimg_item')->where($where_index)->select();

			if (count($item) == 1) {
				if ($item[0]['jump_url'] != '') {
					if ((strpos($item[0]['jump_url'], '{siteUrl}') !== false) || (strpos($item[0]['jump_url'], '{wechat_id}') !== false)) {
						$jump_url = str_replace(array('{siteUrl}', '{wechat_id}'), array($this->siteUrl, $this->wecha_id), $item[0]['jump_url']);
						$jump_url = htmlspecialchars_decode($jump_url);
					}
					else {
						$jump_url = $item[0]['jump_url'];
					}
				}
				else {
					$jump_url = U('Voteimg/popup_view', array('id' => $item[0]['vote_id'], 'token' => $item[0]['token'], 'item_id' => $item[0]['id'], 'key_word' => $key_word));
				}

				redirect($jump_url);
				exit();
			}
		}

		if ($this->action['page_type'] == 'waterfall') {
			$list = M('voteimg_item')->where($where_index)->order($order)->limit(0, 10)->select();
		}
		else {
			$total = M('voteimg_item')->where($where_index)->count();
			$Page = new Page($total, 10);
			$list = M('voteimg_item')->where($where_index)->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$Page->setConfig('prev', '<<');
			$Page->setConfig('next', '>>');
			$Page->setConfig('theme', '%upPage% %linkPage% %downPage%');
			$this->assign('page', $Page->show());
		}

		foreach ($list as $key => $val) {
			if (strpos($val['vote_img'], ';') !== false) {
				$vote_img = explode(';', $val['vote_img']);
				$list[$key]['vote_img'] = end($vote_img);
			}
			else {
				$list[$key]['vote_img'] = $val['vote_img'];
			}

			if ($val['jump_url'] != '') {
				if ((strpos($val['jump_url'], '{siteUrl}') !== false) || (strpos($val['jump_url'], '{wechat_id}') !== false)) {
					$list[$key]['jump_url'] = str_replace(array('{siteUrl}', '{wechat_id}'), array($this->siteUrl, $this->wecha_id), $val['jump_url']);
				}
				else {
					$list[$key]['jump_url'] = $val['jump_url'];
				}
			}
			else {
				$list[$key]['jump_url'] = U('Voteimg/popup_view', array('id' => $val['vote_id'], 'token' => $val['token'], 'item_id' => $val['id']));
			}
		}

		$where = array('token' => $this->token, 'vote_id' => $this->action_id);
		$banner = M('voteimg_banner')->where($where)->order('banner_rank asc')->field('img_url,external_links')->select();

		foreach ($banner as $key => $b) {
			if ($b['external_links'] != '') {
				if ((strpos($b['external_links'], '{siteUrl}') !== false) || (strpos($b['external_links'], '{wechat_id}') !== false)) {
					$external_links = str_replace(array('{siteUrl}', '{wechat_id}'), array($this->siteUrl, $this->wecha_id), $b['external_links']);
					$banner[$key]['external_links'] = htmlspecialchars_decode($external_links);
				}
				else {
					$banner[$key]['external_links'] = $b['external_links'];
				}
			}
		}

		$this->assign('banner', $banner);
		$stat = M('voteimg_stat')->where(array('token' => $this->token, 'vote_id' => $this->action_id))->find();

		if ($stat) {
			$name = explode(',', $stat['stat_name']);
			$this->assign('hide', $stat['hide']);
			$this->assign('name', $name);
		}

		$menu = M('voteimg_menus')->where(array('token' => $this->token, 'vote_id' => $this->action_id, 'type' => 2))->select();
		$custom_menu = M('voteimg_menus')->where(array('token' => $this->token, 'vote_id' => $this->action_id, 'hide' => 1, 'type' => 1))->select();

		foreach ($custom_menu as $key => $val) {
			if (!empty($val['menu_link'])) {
				$custom_menu[$key]['menu_link'] = str_replace(array('{siteUrl}', '{wechat_id}'), array(C('site_url'), $this->wecha_id), $val['menu_link']);
			}
		}

		$this->assign('menu', $menu);
		$this->assign('custom_menu', $custom_menu);
		$custom_bottom = M('voteimg_bottom')->where(array('token' => $this->token, 'vote_id' => $this->action_id, 'type' => 1, 'hide' => 1))->order('bottom_rank desc')->select();

		foreach ($custom_bottom as $key => $val) {
			if (!empty($val['bottom_link'])) {
				$custom_bottom[$key]['bottom_link'] = str_replace(array('{siteUrl}', '{wechat_id}'), array(C('site_url'), $this->wecha_id), $val['bottom_link']);
			}
		}

		$bottom = M('voteimg_bottom')->where(array('token' => $this->token, 'vote_id' => $this->action_id, 'type' => 2))->select();
		$bottom_hide = M('voteimg_bottom')->where(array('token' => $this->token, 'vote_id' => $this->action_id, 'type' => 2, 'hide' => 2))->count();
		$left_count = (4 - count($custom_bottom)) + $bottom_hide;

		if ($left_count == 3) {
			$bottom[3]['hide'] = 2;
		}
		else if ($left_count == 2) {
			$bottom[3]['hide'] = 2;
			$bottom[2]['hide'] = 2;
		}
		else if ($left_count == 1) {
			$bottom[3]['hide'] = 2;
			$bottom[2]['hide'] = 2;
			$bottom[1]['hide'] = 2;
		}

		$this->assign('bottom', $bottom);
		$this->assign('custom_bottom', $custom_bottom);
		$this->assign('alllist', $list);
		$this->assign('id', $this->action_id);
		$this->assign('token', $this->token);
		$this->assign('key_word', $key_word);
		$this->assign('type', $type);
		$this->assign('page_type', $this->action['page_type']);
		$this->assign('imgUrl', $action_info['reply_pic']);

		if ($this->action['page_type'] == 'waterfall') {
			$this->display();
		}
		else {
			C('TOKEN_ON', false);
			$this->display('index_page');
		}
	}

	public function getList()
	{
		$num = $this->_get('num', 'intval');
		$id = $this->_get('id', 'intval');
		$token = $this->_get('token', 'trim');
		$key_word = $this->_get('key_word');
		$type = $this->_get('type', 'trim');
		$voteimg = M('voteimg')->where(array('id' => $id, 'token' => $token))->find();
		if (($voteimg['is_follow'] == 2) && ($this->isSubscribe() == false)) {
			$notice_content = 'no_follow';
		}
		else {
			if (($voteimg['is_register'] == 1) && empty($this->fans['tel'])) {
				$notice_content = 'no_register';
			}
			else {
				$notice_content = '';
			}
		}

		if (($type == 'new') || ($type == '')) {
			$order = 'baby_id desc';
		}
		else {
			$order = 'baby_id asc';
		}

		$where = 'vote_id = ' . $id . ' AND token = \'' . $token . '\' AND check_pass = 1';

		if (!empty($key_word)) {
			if (is_numeric($key_word)) {
				$where .= ' AND baby_id = ' . $key_word;
			}
			else {
				$where .= ' AND vote_title like \'%' . $key_word . '%\'';
			}
		}

		$item = M('voteimg_item')->where($where)->order($order)->limit(10 + ((int) $num * 4), 4)->select();

		foreach ($item as $key => $val) {
			if (strpos($val['vote_img'], ';') !== false) {
				$vote_img = explode(';', $val['vote_img']);
				$item[$key]['vote_img'] = end($vote_img);
			}
			else {
				$item[$key]['vote_img'] = $val['vote_img'];
			}

			if ($val['jump_url'] != '') {
				if ((strpos($val['jump_url'], '{siteUrl}') !== false) || (strpos($val['jump_url'], '{wechat_id}') !== false)) {
					$item[$key]['jump_url'] = str_replace(array('{siteUrl}', '{wechat_id}'), array($this->siteUrl, $this->wecha_id), $val['jump_url']);
				}
				else {
					$item[$key]['jump_url'] = $val['jump_url'];
				}
			}
			else {
				$item[$key]['jump_url'] = U('Voteimg/popup_view', array('id' => $val['vote_id'], 'token' => $val['token'], 'item_id' => $val['id']));
			}

			$item[$key]['notice_content'] = $notice_content;
			$item[$key]['vote_date'] = $this->vote_date;
		}

		if ($item) {
			exit(json_encode(array('status' => 'SUCCESS', 'data' => $item)));
		}
		else {
			exit(json_encode(array('status' => 'FAIL', 'data' => $item)));
		}
	}

	public function vote()
	{
		$vote_id = $this->_get('vote_id', 'intval');
		$token = $this->_get('token', 'trim');
		$id = $this->_get('id', 'intval');
		$voteimg = M('voteimg')->where(array('id' => $vote_id, 'token' => $token))->find();

		if (empty($this->wecha_id)) {
			echo json_encode(array('status' => 'fail', 'data' => '投票失败,参数错误'));
			exit();
		}

		M('voteimg_users')->where('vote_id = ' . $vote_id . ' and token = \'' . $token . '\' and wecha_id = \'' . $this->wecha_id . '\' and vote_time < ' . $this->todaytime)->save(array('votenum_day' => 0, 'vote_today' => '', 'vote_time' => $this->todaytime));
		$wecha_id = M('voteimg_item')->where(array('id' => $id, 'vote_id' => $vote_id, 'token' => $token, 'check_pass' => 1))->getField('wecha_id');
		if (!empty($wecha_id) && ($this->wecha_id == $wecha_id)) {
			echo json_encode(array('status' => 'fail', 'data' => '自己不能给自己投票'));
			exit();
		}

		$where = array('vote_id' => $vote_id, 'token' => $token, 'wecha_id' => $this->wecha_id);
		$vote_user = M('voteimg_users')->where($where)->find();

		if (0 < (int) $voteimg['limit_vote_item']) {
			$vote_today = explode(',', $vote_user['vote_today']);
			$today_count = array_count_values($vote_today);

			if ($voteimg['limit_vote_item'] <= $today_count[$id]) {
				echo json_encode(array('status' => 'fail', 'data' => '超过今日对该选项的投票数'));
				exit();
			}
		}

		if (0 < (int) $voteimg['limit_vote_day']) {
			if ($voteimg['limit_vote_day'] <= $vote_user['votenum_day']) {
				echo json_encode(array('status' => 'fail', 'data' => '超过今日投票数限制'));
				exit();
			}
		}

		if (0 < (int) $voteimg['limit_vote']) {
			if ($voteimg['limit_vote'] <= $vote_user['votenum']) {
				echo json_encode(array('status' => 'fail', 'data' => '超过总投票数限制'));
				exit();
			}
		}

		$u = array();
		$u['item_id'] = trim($vote_user['item_id'] . ',' . $id, ',');
		$u['votenum'] = array('exp', 'votenum+1');
		$u['votenum_day'] = array('exp', 'votenum_day+1');
		$u['vote_today'] = trim($vote_user['item_id'] . ',' . $id, ',');
		$update_user = M('voteimg_users')->where($where)->save($u);
		$d = array();
		$d['vote_count'] = array('exp', 'vote_count+1');
		$update_item = M('voteimg_item')->where(array('vote_id' => $vote_id, 'token' => $token, 'id' => $id))->save($d);
		if ($update_user && $update_item) {
			if ($voteimg['limit_vote_day'] == 0) {
				echo json_encode(array(
	'status' => 'done',
	'data'   => array('left_vote_day' => '')
	));
				exit();
			}
			else {
				echo json_encode(array(
	'status' => 'done',
	'data'   => array('left_vote_day' => $voteimg['limit_vote_day'] - $vote_user['votenum_day'] - 1)
	));
				exit();
			}
		}
		else {
			echo json_encode(array('status' => 'fail', 'data' => '投票失败'));
			exit();
		}
	}

	public function add_users()
	{
		if ($this->wecha_id) {
			$data = array('vote_id' => (int) $this->action_id, 'item_id' => '', 'wecha_id' => $this->wecha_id, 'nick_name' => !empty($this->fans['wechaname']) ? $this->fans['wechaname'] : 'anonymous', 'votenum' => 0, 'votenum_day' => 0, 'vote_time' => time(), 'token' => $this->token);

			if (empty($this->voter)) {
				$user_id = M('voteimg_users')->add($data);
				$_SESSION['user_id'] = $user_id;
			}
		}
	}

	public function apply()
	{
		if (IS_POST) {
			$img = (!empty($_POST['inputimg']) ? implode(';', $_POST['inputimg']) : '');
			if (empty($_POST['vote_id']) || empty($_POST['token'])) {
				$this->del_upload($img);
				$this->error('非法操作');
				exit();
			}

			if (!$this->notice($_POST['vote_id'], $_POST['token'])) {
				$this->del_upload($img);
				$this->error('请先关注、注册');
				exit();
			}

			$vote_img = M('voteimg')->where(array('id' => $_POST['vote_id'], 'token' => $_POST['token']))->find();

			if ($vote_img['apply_end_time'] < time()) {
				$this->del_upload($img);
				$this->error('报名已截止,谢谢您的参与');
				exit();
			}

			if (time() < $vote_img['apply_start_time']) {
				$this->del_upload($img);
				$this->error('报名还未开始,请耐心等待');
				exit();
			}

			if (empty($_POST['inputimg'])) {
				$this->del_upload($img);
				$this->error('请上传图片');
				exit();
			}

			if (5 < count($_POST['inputimg'])) {
				$this->del_upload($img);
				$this->error('最多上传5张');
				exit();
			}

			if (($vote_img['is_register'] == 0) && empty($_POST['contact'])) {
				$this->del_upload($img);
				$this->error('联系方式不能为空');
				exit();
			}

			$exist = M('voteimg_item')->where(array('vote_id' => $_POST['vote_id'], 'token' => $_POST['token'], 'wecha_id' => $this->wecha_id))->find();

			if ($exist) {
				$this->del_upload($img);
				$this->error('已经报过名了,请勿重复报名');
				exit();
			}

			$data = array();
			$data['vote_title'] = $this->_post('vote_title', 'trim');
			$data['introduction'] = $this->_post('introduction', 'trim');
			$data['manifesto'] = $this->_post('manifesto', 'trim');
			$data['contact'] = empty($_POST['contact']) ? $this->fans['tel'] : $this->_post('contact');
			$data['vote_count'] = 0;
			$data['upload_time'] = $this->now;
			$data['check_pass'] = 0;
			$data['upload_type'] = 0;
			$data['token'] = $_POST['token'];
			$data['vote_id'] = $_POST['vote_id'];
			$data['baby_id'] = 0;
			$data['vote_img'] = trim(implode(';', $_POST['inputimg']), ';');
			$data['wecha_id'] = $this->wecha_id;
			$insert = M('voteimg_item')->add($data);

			if ($insert) {
				$this->success('申请报名成功,等待审核', U('Voteimg/index', array('id' => $_POST['vote_id'], 'token' => $_POST['token'])));
				exit();
			}
			else {
				$this->error('申请报名失败');
				exit();
			}
		}

		$vote_id = $this->_get('id', 'intval');
		$token = $this->_get('token', 'trim');
		$action_info = M('voteimg')->where(array('id' => $vote_id, 'token' => $token))->find();

		if (!empty($action_info)) {
			$this->assign('action_info', $action_info);
		}

		$this->notice($vote_id, $token);
		$banner = M('voteimg_banner')->where(array('token' => $token, 'vote_id' => $vote_id))->order('banner_rank asc')->field('img_url,external_links')->select();

		foreach ($banner as $key => $b) {
			if ($b['external_links'] != '') {
				if ((strpos($b['external_links'], '{siteUrl}') !== false) || (strpos($b['external_links'], '{wechat_id}') !== false)) {
					$external_links = str_replace(array('{siteUrl}', '{wechat_id}'), array($this->siteUrl, $this->wecha_id), $b['external_links']);
					$banner[$key]['external_links'] = htmlspecialchars_decode($external_links);
				}
				else {
					$banner[$key]['external_links'] = $b['external_links'];
				}
			}
		}

		$this->assign('banner', $banner);
		$stat = M('voteimg_stat')->where(array('token' => $token, 'vote_id' => $vote_id))->find();

		if ($stat) {
			$name = explode(',', $stat['stat_name']);
			$this->assign('hide', $stat['hide']);
			$this->assign('name', $name);
		}

		$menu = M('voteimg_menus')->where(array('token' => $token, 'vote_id' => $vote_id, 'type' => 2))->select();
		$custom_menu = M('voteimg_menus')->where(array('token' => $token, 'vote_id' => $vote_id, 'hide' => 1, 'type' => 1))->select();

		foreach ($custom_menu as $key => $val) {
			if (!empty($val['menu_link'])) {
				$custom_menu[$key]['menu_link'] = str_replace(array('{siteUrl}', '{wechat_id}'), array(C('site_url'), $this->wecha_id), $val['menu_link']);
			}
		}

		$this->assign('menu', $menu);
		$this->assign('custom_menu', $custom_menu);
		$voteimg = M('voteimg')->where(array('id' => $this->action_id, 'token' => $this->token))->find();
		$this->assign('voteimg', $voteimg);
		$this->assign('vote_id', $this->action_id);
		$this->assign('token', $this->token);
		$voteimg_item = M('voteimg_item')->where(array('vote_id' => $this->action_id, 'token' => $this->token, 'wecha_id' => $this->wecha_id))->find();

		if (!empty($voteimg_item)) {
			$this->assign('disabled', 'disabled = \'disabled\'');
			$this->assign('allow_apply', 'exists');
		}

		$this->assign($this->action);
		$this->assign('imgUrl', $this->action['reply_pic']);
		$this->display();
	}

	public function popup_view()
	{
		$key_word = $this->_get('key_word');
		$vote_id = $this->_get('id');
		$token = $this->_get('token');
		if (empty($vote_id) || empty($token)) {
			$this->error('非法操作');
			exit();
		}

		$this->notice($vote_id, $token);
		$action_info = M('voteimg')->where(array('id' => $vote_id, 'token' => $token))->find();

		if (!empty($action_info)) {
			$this->assign('action_info', $action_info);
		}
		else {
			$this->error('活动不存在');
			exit();
		}

		$where = 'vote_id = ' . $vote_id . ' AND token = \'' . $token . '\' AND check_pass = 1';

		if (!empty($key_word)) {
			C('TOKEN_ON', false);

			if (is_numeric($key_word)) {
				$where .= ' AND baby_id = ' . (int) $key_word;
			}
			else {
				$where .= ' AND vote_title like \'%' . $key_word . '%\'';
			}
		}
		else {
			$item_id = $this->_get('item_id', 'intval');

			if (!$item_id) {
				exit('加载失败');
			}

			$where = 'id = ' . $item_id;
		}

		$item = M('voteimg_item')->where($where)->find();
		$vote_img = explode(';', $item['vote_img']);
		$this->assign('imgUrl', end($vote_img));
		$this->assign('vote_img', $vote_img);
		$this->assign('item', $item);
		$banner = M('voteimg_banner')->where(array('token' => $token, 'vote_id' => $vote_id))->order('banner_rank asc')->field('img_url,external_links')->select();

		foreach ($banner as $key => $b) {
			if ($b['external_links'] != '') {
				if ((strpos($b['external_links'], '{siteUrl}') !== false) || (strpos($b['external_links'], '{wechat_id}') !== false)) {
					$external_links = str_replace(array('{siteUrl}', '{wechat_id}'), array($this->siteUrl, $this->wecha_id), $b['external_links']);
					$banner[$key]['external_links'] = htmlspecialchars_decode($external_links);
				}
				else {
					$banner[$key]['external_links'] = $b['external_links'];
				}
			}
		}

		$this->assign('banner', $banner);
		$stat = M('voteimg_stat')->where(array('token' => $token, 'vote_id' => $vote_id))->find();

		if ($stat) {
			$name = explode(',', $stat['stat_name']);
			$this->assign('hide', $stat['hide']);
			$this->assign('name', $name);
		}

		$menu = M('voteimg_menus')->where(array('token' => $token, 'vote_id' => $vote_id, 'type' => 2))->select();
		$custom_menu = M('voteimg_menus')->where(array('token' => $token, 'vote_id' => $vote_id, 'hide' => 1, 'type' => 1))->select();

		foreach ($custom_menu as $key => $val) {
			if (!empty($val['menu_link'])) {
				$custom_menu[$key]['menu_link'] = str_replace(array('{siteUrl}', '{wechat_id}'), array(C('site_url'), $this->wecha_id), $val['menu_link']);
			}
		}

		$this->assign('menu', $menu);
		$this->assign('custom_menu', $custom_menu);
		$custom_bottom = M('voteimg_bottom')->where(array('token' => $token, 'vote_id' => $vote_id, 'type' => 1, 'hide' => 1))->order('bottom_rank desc')->select();

		foreach ($custom_bottom as $key => $val) {
			if (!empty($val['bottom_link'])) {
				$custom_bottom[$key]['bottom_link'] = str_replace(array('{siteUrl}', '{wechat_id}'), array(C('site_url'), $this->wecha_id), $val['bottom_link']);
			}
		}

		$bottom = M('voteimg_bottom')->where(array('token' => $token, 'vote_id' => $vote_id, 'type' => 2))->select();
		$bottom_hide = M('voteimg_bottom')->where(array('token' => $token, 'vote_id' => $vote_id, 'type' => 2, 'hide' => 2))->count();
		$left_count = (4 - count($custom_bottom)) + $bottom_hide;

		if ($left_count == 3) {
			$bottom[3]['hide'] = 2;
		}
		else if ($left_count == 2) {
			$bottom[3]['hide'] = 2;
			$bottom[2]['hide'] = 2;
		}
		else if ($left_count == 1) {
			$bottom[3]['hide'] = 2;
			$bottom[2]['hide'] = 2;
			$bottom[1]['hide'] = 2;
		}

		$this->assign('bottom', $bottom);
		$this->assign('custom_bottom', $custom_bottom);
		$this->assign('item_id', $item['id']);
		$this->assign('token', $token);
		$this->assign('vote_id', $vote_id);
		$this->assign($this->action);
		$this->display();
	}

	public function share()
	{
		$item_id = $this->_get('item_id');
		$vote_id = $this->_get('id');
		$token = $this->_get('token');
		$this->notice($vote_id, $token);
		if (empty($item_id) || empty($vote_id) || empty($token)) {
			$this->error('非法操作');
			exit();
		}

		$this->add_users();
		$where = array('id' => $item_id, 'vote_id' => $vote_id, 'token' => $token);
		$item = M('voteimg_item')->where($where)->find();

		if (strpos($item['vote_img'], ';') !== false) {
			$vote_img = explode(';', $item['vote_img']);
			$item['vote_img'] = end($vote_img);
		}
		else {
			$item['vote_img'] = $item['vote_img'];
		}

		$this->assign('item', $item);
		$this->assign('token', $token);
		$this->assign('vote_id', $vote_id);
		$this->assign('item_id', $item_id);
		$this->display();
	}

	public function vote_record()
	{
		if (empty($this->action_id) || empty($this->token)) {
			$this->assign('vote_record', '');
		}

		$type = $this->_get('type', 'trim');

		if ($type == 'ranking') {
			$vote_id = $this->_get('id', 'intval');
			$token = $this->_get('token', 'trim');
			$action_info = M('voteimg')->where(array('id' => $vote_id, 'token' => $token))->find();

			if (!empty($action_info)) {
				$this->assign('action_info', $action_info);
			}

			$banner = M('voteimg_banner')->where(array('token' => $token, 'vote_id' => $vote_id))->order('banner_rank asc')->field('img_url,external_links')->select();

			foreach ($banner as $key => $b) {
				if ($b['external_links'] != '') {
					if ((strpos($b['external_links'], '{siteUrl}') !== false) || (strpos($b['external_links'], '{wechat_id}') !== false)) {
						$external_links = str_replace(array('{siteUrl}', '{wechat_id}'), array($this->siteUrl, $this->wecha_id), $b['external_links']);
						$banner[$key]['external_links'] = htmlspecialchars_decode($external_links);
					}
					else {
						$banner[$key]['external_links'] = $b['external_links'];
					}
				}
			}

			$this->assign('banner', $banner);
			$stat = M('voteimg_stat')->where(array('token' => $token, 'vote_id' => $vote_id))->find();

			if ($stat) {
				$name = explode(',', $stat['stat_name']);
				$this->assign('hide', $stat['hide']);
				$this->assign('name', $name);
			}

			$menu = M('voteimg_menus')->where(array('token' => $token, 'vote_id' => $vote_id, 'type' => 2))->select();
			$custom_menu = M('voteimg_menus')->where(array('token' => $token, 'vote_id' => $vote_id, 'hide' => 1, 'type' => 1))->select();

			foreach ($custom_menu as $key => $val) {
				if (!empty($val['menu_link'])) {
					$custom_menu[$key]['menu_link'] = str_replace(array('{siteUrl}', '{wechat_id}'), array(C('site_url'), $this->wecha_id), $val['menu_link']);
				}
			}

			$this->assign('menu', $menu);
			$this->assign('custom_menu', $custom_menu);
			$custom_bottom = M('voteimg_bottom')->where(array('token' => $this->token, 'vote_id' => $this->action_id, 'type' => 1, 'hide' => 1))->order('bottom_rank desc')->select();

			foreach ($custom_bottom as $key => $val) {
				if (!empty($val['bottom_link'])) {
					$custom_bottom[$key]['bottom_link'] = str_replace(array('{siteUrl}', '{wechat_id}'), array(C('site_url'), $this->wecha_id), $val['bottom_link']);
				}
			}

			$bottom = M('voteimg_bottom')->where(array('token' => $token, 'vote_id' => $vote_id, 'type' => 2))->select();
			$bottom_hide = M('voteimg_bottom')->where(array('token' => $token, 'vote_id' => $vote_id, 'type' => 2, 'hide' => 2))->count();
			$left_count = (4 - count($custom_bottom)) + $bottom_hide;

			if ($left_count == 3) {
				$bottom[3]['hide'] = 2;
			}
			else if ($left_count == 2) {
				$bottom[3]['hide'] = 2;
				$bottom[2]['hide'] = 2;
			}
			else if ($left_count == 1) {
				$bottom[3]['hide'] = 2;
				$bottom[2]['hide'] = 2;
				$bottom[1]['hide'] = 2;
			}

			$this->assign('bottom', $bottom);
			$this->assign('custom_bottom', $custom_bottom);
			$ranking = M('voteimg_item')->where(array('vote_id' => $this->action_id, 'token' => $this->token, 'check_pass' => 1))->order('vote_count desc')->select();

			if ($ranking) {
				$this->assign('vote_record', $ranking);
			}
			else {
				$this->assign('vote_record', '');
			}

			$this->assign('vote_id', $vote_id);
			$this->assign('token', $token);
			$this->assign($this->action);
			$this->assign('imgUrl', $this->action['reply_pic']);
			$this->display('vote_record_index');
		}
		else {
			$item_id = M('voteimg_users')->where(array('vote_id' => $this->action_id, 'token' => $this->token, 'wecha_id' => $this->wecha_id))->getField('item_id');

			if (!empty($item_id)) {
				$item_ids = explode(',', $item_id);
				$item_ids = array_unique($item_ids);
				$vote_record = array();

				foreach ($item_ids as $k => $id) {
					$record = M('voteimg_item')->where(array('id' => $id))->field('vote_title,vote_count')->find();
					$vote_record[$k]['vote_count'] = $record['vote_count'];
					$vote_record[$k]['vote_title'] = $record['vote_title'];
				}

				rsort($vote_record);
				$this->assign('vote_record', $vote_record);
			}
			else {
				$this->assign('vote_record', '');
			}

			$this->display();
		}
	}

	public function stat_info()
	{
		if (empty($this->action_id) || empty($this->token)) {
			$return_json = json_encode(array('item_count' => 0, 'voted_count' => 0, 'visit_count' => 0));
		}

		$item_count = M('voteimg_item')->where(array('vote_id' => $this->action_id, 'token' => $this->token, 'check_pass' => 1))->count();
		$voted_count = M('voteimg_item')->where(array('vote_id' => $this->action_id, 'token' => $this->token))->sum('vote_count');
		$visit_count = M('voteimg_users')->where(array('vote_id' => $this->action_id, 'token' => $this->token))->count();
		$return_json = json_encode(array('item_count' => $item_count, 'voted_count' => $voted_count, 'visit_count' => $visit_count));
		exit($return_json);
	}

	public function localupload($token = '')
	{
		$upload = new UploadFile();
		$upload->allowExts = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
		$upload->autoSub = 1;
		$firstLetter = substr($token, 0, 1);
		$upload->savePath = './uploads/' . $firstLetter . '/' . $token . '/';
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads') || !is_dir($_SERVER['DOCUMENT_ROOT'] . '/uploads')) {
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads', 511);
		}

		$firstLetterDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $firstLetter;
		if (!file_exists($firstLetterDir) || !is_dir($firstLetterDir)) {
			mkdir($firstLetterDir, 511);
		}

		if (!file_exists($firstLetterDir . '/' . $token) || !is_dir($firstLetterDir . '/' . $token)) {
			mkdir($firstLetterDir . '/' . $token, 511);
		}

		if (!file_exists($upload->savePath) || !is_dir($upload->savePath)) {
			mkdir($upload->savePath, 511);
		}

		$upload->hashLevel = 2;

		if ($upload->upload()) {
			$info = $upload->getUploadFileInfo();
			$this->siteUrl = $this->siteUrl ? $this->siteUrl : C('site_url');
			$msg = $this->siteUrl . substr($upload->savePath, 1) . $info[0]['savename'];
			return array('status' => 'SUCCESS', 'img_url' => $msg);
		}
		else {
			$msg = $upload->getErrorMsg();
			return array('status' => 'FAIL', 'error_msg' => $msg);
		}
	}

	private function notice($action_id, $token)
	{
		$voteimg = M('voteimg')->where(array('id' => $action_id, 'token' => $token))->find();

		if (empty($voteimg)) {
			$this->error('非法操作');
			return false;
		}

		if (($voteimg['is_follow'] == 2) && ($this->isSubscribe() == false)) {
			$this->assign('notice_content', 'no_follow');
			$this->memberNotice('', 1);
			return false;
		}
		else {
			if (($voteimg['is_register'] == 1) && empty($this->fans['tel'])) {
				$this->assign('notice_content', 'no_register');
				$this->memberNotice('您没有填写手机号,请点击这里登陆/完善');
				return false;
			}
		}

		$this->assign('notice_content', '');
		return true;
	}

	public function ajaxImgUpload()
	{
		$filename = trim($_POST['filename']);
		$img = $_POST[$filename];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$imgdata = base64_decode($img);
		$getupload_dir = '/uploads/voteimg/' . date('Ymd');
		$upload_dir = '.' . $getupload_dir;

		if (!is_dir($upload_dir)) {
			mkdir($upload_dir, 511, true);
		}

		$newfilename = 'voteimg_' . date('YmdHis') . '.jpg';
		$save = file_put_contents($upload_dir . '/' . $newfilename, $imgdata);

		if ($save) {
			$this->dexit(array(
	'error' => 0,
	'data'  => array('code' => 1, 'url' => $this->siteUrl . $getupload_dir . '/' . $newfilename, 'msg' => '')
	));
		}
		else {
			$this->dexit(array(
	'error' => 1,
	'data'  => array('code' => 0, 'url' => '', 'msg' => '保存失败！')
	));
		}
	}

	private function dexit($data = '')
	{
		if (is_array($data)) {
			echo json_encode($data);
		}
		else {
			echo $data;
		}

		exit();
	}

	private function del_upload($img_url = '')
	{
		if (empty($img_url)) {
			return false;
		}

		if (strpos($img_url, ';')) {
			$img_array = explode(';', $img_url);

			foreach ((array) $img_array as $img) {
				$filename = str_replace(array('http://', $_SERVER['HTTP_HOST']), '', $img);
				$filename = getcwd() . $filename;
				if (!empty($filename) && @file_exists($filename)) {
					unlink($filename);
				}
			}
		}
		else {
			$filename = str_replace(array('http://', $_SERVER['HTTP_HOST']), '', $img_url);
			$filename = getcwd() . $filename;
			if (!empty($filename) && @file_exists($filename)) {
				unlink($filename);
			}
		}

		return true;
	}
}

?>
