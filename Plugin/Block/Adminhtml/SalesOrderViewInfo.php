<?php

namespace Magelearn\OrderNote\Plugin\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magelearn\OrderNote\Model\Data\OrderNote;
use Magento\Sales\Block\Adminhtml\Order\View\Info as ViewInfo;
use Magelearn\OrderNote\Model\OrderNoteConfig;

class SalesOrderViewInfo {
	
	/**
     * @var OrderNoteConfig
     */
    protected $orderNoteConfig;
	
	public function __construct(
		Context $context,
		OrderNoteConfig $orderNoteConfig
	) {
		$this ->_urlBuilder = $context->getUrlBuilder();
		$this->orderNoteConfig = $orderNoteConfig;
	}

	/**
	 * @param ViewInfo $subject
	 * @param string $result
	 * @return string
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function afterToHtml(ViewInfo $subject, $result) {
		$noteBlock = $subject->getLayout()->getBlock('ml_order_notes');
		$orderId = $subject->getOrder()->getData('entity_id');
		if ($noteBlock !== false) {
			$editUrl = $this->getOrderAttributeEditUrl($orderId);
			$isAllowedToAddNote = $this->getItemInternalOrderNote($subject->getOrder());
			$noteBlock-> setOrderNote($subject->getOrder()->getData(OrderNote::FIELD_NAME));
			$noteBlock->setOrderId($subject->getOrder()->getData('entity_id'));
			$noteBlock->setNoteUrl($editUrl);
			$noteBlock->setIsAllowedToAddNote($isAllowedToAddNote);
			// $result = $result . $noteBlock->toHtml();
		}

		return $result;
	}

	/**
	 * @return string
	 */
	protected function getOrderAttributeEditUrl($orderId) {
		return $this->getUrl('ordernote/note/edit', ['order_id' => $orderId]);
	}

	/**
	 * Generate url by route and parameters
	 *
	 * @param string $route
	 * @param array $params
	 * @return  string
	 */
	public function getUrl($route = '', $params = []) {
		return $this->_urlBuilder->getUrl($route, $params);
	}

	public function getItemInternalOrderNote($order) {
		$showOrderNote = false;
		if(!$this->isEnabled()) {
			return $showOrderNote;
		} else {
			return $showOrderNote = true;
		}
		
		return $showOrderNote;
	}
	
	/**
     * Check if extension is enabled or not
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->orderNoteConfig->isEnabled();
    }
}
