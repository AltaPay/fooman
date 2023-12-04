<?php
/**
 * Fooman extension with Altapay integration
 *
 * Copyright © 2018 Altapay. All rights reserved.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Altapay\Fooman\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Altapay\Request\OrderLine;
use Fooman\Totals\Model\QuoteAddressTotalManagement;

class GetOrderLine implements ObserverInterface
{
    /**
     * @var QuoteAddressTotalManagement
     */
    protected $_quoteAddressTotalManagement;

    /**
     * @param QuoteAddressTotalManagement $quoteAddressTotalManagement
     */
    public function __construct(QuoteAddressTotalManagement $quoteAddressTotalManagement)
    {
        $this->_quoteAddressTotalManagement = $quoteAddressTotalManagement;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $orderLinesArray = [];
        // Retrieve the order lines array from the event data
        $orderLines = $observer->getEvent()->getData('order_lines');
        $quoteId = $observer->getEvent()->getData('quote_id');
        $quoteAddressTotalCollection = $this->_quoteAddressTotalManagement->getByQuoteId($quoteId);
        foreach ($quoteAddressTotalCollection as $quoteAddressTotal) {

            // Modify the array or add new elements
            $orderLine = new OrderLine(
                $quoteAddressTotal->getLabel(),
                $quoteAddressTotal->getTypeId(),
                1,
                $quoteAddressTotal->getAmount()
            );
            $orderLine->setGoodsType('handling');

            // Push the modified order line into the order lines array
            $orderLinesArray[] = $orderLine;
        }

        // Append the new array of order lines to the existing order lines
        $orderLines = array_merge($orderLines, $orderLinesArray);

        // Set the modified order lines array back to the original observer data
        $observer->getEvent()->setData('order_lines', $orderLines);
    }
}