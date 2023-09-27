<?php
namespace Opencart\Catalog\Controller\Extension\Opencart\Module;
/**
 * Class Topic
 *
 * @package
 */
class Topic extends \Opencart\System\Engine\Controller {
	/**
	 * @return string
	 */
	public function index(): string {
		$this->load->language('extension/opencart/module/topic');

		if (isset($this->request->get['topic_id'])) {
			$data['topic_id'] = (int)$this->request->get['topic_id'];
		} else {
			$data['topic_id'] = 0;
		}

		$data['topics'] = [];

		$this->load->model('cms/topic');
		$this->load->model('cms/article');

		$topics = $this->model_cms_topic->getTopics();

		foreach ($topics as $topic) {
			$data['topics'][] = [
				'topic_id' => $topic['topic_id'],
				'name'     => $topic['name'] . ($this->config->get('config_article_count') ? ' (' . $this->model_cms_article->getTotalArticles(['filter_topic_id' => $data['topic_id']]) . ')' : ''),
				'href'     => $this->url->link('cms/blog', 'language=' . $this->config->get('config_language') . '&topic_id=' . $topic['topic_id'])
			];
		}

		return $this->load->view('extension/opencart/module/topic', $data);
	}
}