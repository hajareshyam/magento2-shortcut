<?php

use \Magento\Framework\App\Bootstrap;
include('app/bootstrap.php');
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$url = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $url->get('\Magento\Store\Model\StoreManagerInterface');
$mediaurl= $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');

// Customer Factory to Create Customer
$customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory');
$websiteId = $storeManager->getWebsite()->getWebsiteId();

/// Get Store ID
$store = $storeManager->getStore();
$storeId = $store->getStoreId();

$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');

$collection = $productCollection->create()
->addAttributeToSelect('*')
->addAttributeToFilter('status', '1')
->addAttributeToFilter('visibility', ['in' => [2, 3, 4]])
->load();



foreach ($collection as $key => $value) {
	if ($value->getVisibility() == 4) {
		
		$pId = $value->getId();
		echo $value->getName();
		echo "\n";
		
		$productObj = $objectManager->create('Magento\Catalog\Model\Product')->load($pId);
		$categoryLinkManagement = $objectManager->create('Magento\Catalog\Api\CategoryLinkManagementInterface');

		$newCategoryIds = array(2,651,665);
		$categoryIds = array_values(array_merge($newCategoryIds, $oldCategoryIds));
		$categoryLinkManagement->assignProductToCategories($productObj->getSku(),$categoryIds);
	}

}


