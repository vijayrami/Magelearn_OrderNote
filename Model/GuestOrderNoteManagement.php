<?php

namespace Magelearn\OrderNote\Model;

use Magelearn\OrderNote\Api\Data\OrderNoteInterface;
use Magelearn\OrderNote\Api\GuestOrderNoteManagementInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magelearn\OrderNote\Api\OrderNoteManagementInterface;

class GuestOrderNoteManagement implements GuestOrderNoteManagementInterface
{

    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @var OrderNoteManagementInterface
     */
    protected $orderNoteManagement;

    /**
     * GuestOrderNoteManagement constructor.
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param OrderNoteManagementInterface $orderNoteManagement
     */
    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        OrderNoteManagementInterface $orderNoteManagement
    )
    {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->orderNoteManagement = $orderNoteManagement;
    }

    /**
     * @param string $cartId
     * @param OrderNoteInterface $orderNote
     * @return mixed
     */
    public function saveOrderNote($cartId, OrderNoteInterface $orderNote)
    {
        $quoteIdMask = $this->quoteIdMaskFactory->create()
            ->load($cartId, 'masked_id');

        return $this->orderNoteManagement->saveOrderNote(
            $quoteIdMask->getQuoteId(),
            $orderNote
        );
    }
}
