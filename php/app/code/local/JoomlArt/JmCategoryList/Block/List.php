<?php
/*------------------------------------------------------------------------
# $JA#PRODUCT_NAME$ - Version $JA#VERSION$ - Licence Owner $JA#OWNER$
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites: http://www.joomlart.com - http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
-------------------------------------------------------------------------*/ 

class JoomlArt_JmCategoryList_Block_List extends Mage_Catalog_Block_Product_Abstract 
{
	var $_config = array();
	var $_count = 0;
	
	public function __construct($attributes = array()){
		$helper =  Mage::helper('joomlart_jmcategorylist/data');
		
		$this->_config['show'] = $helper->get('show', $attributes);
		if(!$this->_config['show']) return;
		
		parent::__construct();
		
		$this->_config['title'] = $helper->get('title', $attributes);				
			
		$this->_config['perrow'] = $helper->get('perrow', $attributes);
		$this->_config['perrow'] = $this->_config['perrow']>0?$this->_config['perrow']:3;	
		
		$this->_config['template'] = $helper->get('template', $attributes);
		
		$this->_config['catsid'] = $helper->get('catsid', $attributes);
		$this->_config['catsid'] = $this->_config['catsid'] >0?$this->_config['catsid']:4;
		
		$this->_config['showcat'] = $helper->get('showcat', $attributes);
		$this->_config['link_cat'] = $helper->get('link_cat', $attributes);
		$this->_config['leading_product'] = $helper->get('leading_product', $attributes);
		$this->_config['intro_product'] = $helper->get('intro_product', $attributes);
		
		$this->_config['maxchar'] = (int)$helper->get('maxchar', $attributes);
		$this->_config['maxchar'] = $this->_config['maxchar'] >0?$this->_config['maxchar']:1000;
		$this->_config['show_readmore'] = $helper->get('show_readmore', $attributes);
		$this->_config['show_desc'] = $helper->get('show_desc', $attributes);
		
		$this->_config['mode'] = $helper->get('mode', $attributes);
		
		$this->_count = 0;
		
		$this->_config['qty'] = (int)$this->_config['leading_product'] + (int)$this->_config['intro_product'];
			
		//$this->setProductCollection($this->getCategory());
	}
		
	function _toHtml() {		
		if(!$this->_config['show']) return;

		$listall = $this->getListProducts();
		
		$this->assign('listall', $listall);	
		$this->assign('config', $this->_config);
		$this->assign('total', $this->_count);
				
		if($listall){
			
			if(!$this->getTemplate()){
		        $this->setTemplate('joomlart/jmcategorylist/list.phtml');
		    }
		}

        return parent::_toHtml();	
	}			
	
	function getListProducts($perPage=NULL, $currentPage=1){
		if (!$this->_config['catsid']) return ;
		
		$list = array();
		if($perPage === NULL) $perPage	= (int) $this->_config['qty'];
		
		$layer = Mage::getSingleton('catalog/layer');
		
		$categories_id = explode(',', $this->_config['catsid']);
		
		$storeId = Mage::app()->getStore()->getStoreId();
        $this->setStoreId($storeId);
        
		$k = 0;
		foreach ($categories_id as $catid){
			$catid = (int)trim($catid);
			if($catid){
				$category = Mage::getModel('catalog/category')->load($catid);
				
		        if ($category->getId()) {
		        	$this->setCategoryId(current(array($category->getId())));		            
		            		           
		           
	            	switch ($this->_config['mode']){
						case 'latest':				
							$product_collection = $this->getListLatestProducts($category);				
							break;	
							
						case 'best_buy':
							$product_collection = $this->getListBestBuyProducts($category);
							break;
							
						case 'most_viewed':
							$product_collection = $this->getListMostViewedProducts($category);
							break;
							
						case 'most_reviewed':
							$product_collection = $this->getListReviewedProducts($category);
							break;
							
						case 'top_rated':
							$product_collection = $this->getListTopRatedProducts($category);
							break;	
							
						case 'attribute':			
							$product_collection = $this->getListFeaturedProduct($category);
							break;		
							
						default:
							$product_collection = $this->getListDefaultProducts($category);
							break;						
					}		           					
					if($product_collection){
						$product_collection->setPageSize($perPage)->setCurPage($currentPage);
						
						Mage::dispatchEvent('catalog_block_product_list_collection', array(
							'collection'=>$product_collection
						));
						
						Mage::getModel('review/review')->appendSummary($product_collection);
					
						$this->_count++;
						$list[$k]['items'] 		= $product_collection;
						$list[$k]['category']   = $category;
						$k++;	
					}
		        }
			}
		}
		
		return $list;
	}
	
	function inArray($source, $target){
        for($j=0; $j<sizeof($source); $j++){
            if(in_array($source[$j], $target)){
                 return true;
            }
        }     
    }

	function getListLatestProducts($category, $product_ids=''){										
				
		$storeId    = Mage::app()->getStore()->getId();
    	$product    = Mage::getModel('catalog/product');
		$category	= Mage::getModel('catalog/category')->load($category->getId()); //category whos ID is 13

		$visibility = array(
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
        );

        $products   = $product	->setStoreId($storeId)
								->getCollection()
								->addAttributeToFilter('visibility', $visibility)
								->addCategoryFilter($category)
								//->addAttributeToSelect("*") 
								->setOrder('created_at', 'desc')
								;
		
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        $this->setProductCollection($products);	
		return $this->getProductCollection();			
	}
	
	function getListDefaultProducts($category, $product_ids=''){										
				
		$storeId    = Mage::app()->getStore()->getId();
    	$product    = Mage::getModel('catalog/product');
		$category	= Mage::getModel('catalog/category')->load($category->getId()); 

		$visibility = array(
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
        );

        $products   = $product	->setStoreId($storeId)
								->getCollection()
								->addAttributeToFilter('visibility', $visibility)
								->addCategoryFilter($category)
								//->addAttributeToSelect("*") 
								;
        $this->setProductCollection($products);	
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
		return $this->getProductCollection();		
	}
	
	function getListBestBuyProducts($cat, $fieldorder='ordered_qty', $order='desc', $product_ids=''){										
				
		$list = null;				
		/* 
			Always set de $perPage, by template or by config 
			if $perPage eq 0 (zero) not limit the list
		*/
		$category	= Mage::getModel('catalog/category')->load($cat->getId());
		if($perPage === NULL) $perPage	= (int) $this->_config['qty'];
		/*
			Show all the product list in the current store
			order by ordered_qty, showing the bestsellers first
		*/
		$categoryTableName = (string)Mage::getConfig()->getTablePrefix() . 'catalog_category_product_index';
		
		$visibility = array(
                      Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                      Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
                  );

		$storeId = Mage::app()->getStore()->getStoreId();
		$_productCollection = Mage::getResourceModel('reports/product_collection')
		                              //->addAttributeToSelect('*')
		                              ->addOrderedQty()
		                              ->addAttributeToFilter('visibility', $visibility)
		                              ->setOrder('ordered_qty', 'desc')
									  ->addCategoryFilter($category);
									  
		if ($product_ids) {
			$_productCollection->getSelect()->where("e.entity_id in ($product_ids)");					
		}
		
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($_productCollection);
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($_productCollection);
		
		$this->setProductCollection($_productCollection);
		
		return $this->getProductCollection();
	}
	
	function getListMostViewedProducts($cat){	
														
		$categoryTableName = (string)Mage::getConfig()->getTablePrefix() . 'catalog_category_product_index';
		
		$storeId = Mage::app()->getStore()->getStoreId();
        $this->setStoreId($storeId);
		$category	= Mage::getModel('catalog/category')->load($cat->getId());
       
        $_productCollection = Mage::getResourceModel('reports/product_collection');      

        $_productCollection	->setStoreId($storeId)
                        	->addStoreFilter($storeId)
                        	->addViewsCount()
							//->addAttributeToSelect('*')                           
							->addCategoryFilter($category);
							
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($_productCollection);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($_productCollection);
		
        $this->setProductCollection($_productCollection);   

        return $this->getProductCollection();
	}
	
	function getListReviewedProducts($cat){
		$category	= Mage::getModel('catalog/category')->load($cat->getId());
		
		$storeId = Mage::app()->getStore()->getId();

        $entityCondition = '_reviewed_order_table.entity_id = e.entity_id';
            
		$products = Mage::getResourceModel('catalog/product_collection')
					->setStoreId($storeId)
					//->addAttributeToSelect('*')
					->addStoreFilter($storeId)
					->addCategoryFilter($category);          
					
		$products->getSelect()->joinLeft(
			                array('_reviewed_order_table'=>$products->getTable('review_entity_summary')),
			                		"_reviewed_order_table.store_id=$storeId AND _reviewed_order_table.entity_pk_value=e.entity_id",
			                array()
			            );
			
		$products->getSelect()->order("_reviewed_order_table.reviews_count DESC");	
        $products->getSelect()->group('e.entity_id');
		
		Mage::getSingleton ( 'catalog/product_visibility' )->addVisibleInCatalogFilterToCollection ( $products );
		Mage::getSingleton ( 'catalog/product_status' )->addVisibleFilterToCollection ( $products );
		
		$this->setProductCollection($products);	
		return $this->getProductCollection();	
	}
	
	function getListTopRatedProducts($cat){
		
		$category	= Mage::getModel('catalog/category')->load($cat->getId());
		
		$storeId = Mage::app()->getStore()->getId();

        $entityCondition = '_reviewed_order_table.entity_id = e.entity_id';
            
		$products = Mage::getResourceModel('catalog/product_collection')
						->setStoreId($storeId)
						//->addAttributeToSelect('*')
						->addStoreFilter($storeId)
						->addCategoryFilter($category);          
					
		$products->getSelect()->joinLeft(
			                array('_reviewed_order_table'=>$products->getTable('review_entity_summary')),
			                		"_reviewed_order_table.store_id=$storeId AND _reviewed_order_table.entity_pk_value=e.entity_id",
			                array()
			            );
			
		$products->getSelect()->order("_reviewed_order_table.rating_summary DESC");	
        $products->getSelect()->group('e.entity_id');	
		
		Mage::getSingleton ( 'catalog/product_visibility' )->addVisibleInCatalogFilterToCollection ( $products );
		Mage::getSingleton ( 'catalog/product_status' )->addVisibleFilterToCollection ( $products );
		
		$this->setProductCollection($products);	
		return $this->getProductCollection();			
	}		
	
	function getListFeaturedProduct($category){

		$storeId    = Mage::app()->getStore()->getId();
    	$product    = Mage::getModel('catalog/product');
		$category	= Mage::getModel('catalog/category')->load($category->getId()); 

		$visibility = array(
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
        );
		
		$attributes = 	Mage::getSingleton('catalog/config')
						->getProductAttributes();
		if(in_array('featured', $attributes)){
			$products   = $product	->addAttributeToSelect($attributes)
									->setStoreId($storeId)
									->getCollection()
									->addAttributeToFilter('visibility', $visibility)
									->addCategoryFilter($category)
									->addAttributeToFilter('featured', 1)
									;
			Mage::getSingleton ( 'catalog/product_visibility' )->addVisibleInCatalogFilterToCollection ( $products );
			Mage::getSingleton ( 'catalog/product_status' )->addVisibleFilterToCollection ( $products );
		
			$this->setProductCollection($products);	
			return $this->getProductCollection();		
		}else {
			return false;
		}
	}	
	
	
	function set($show=1, $title='', $mode='', $showcat='', $link_cat='', $catsid='', $perrow=3, $leading_product=1, $intro_product=3, $maxchar=0, $template=''){
		if(!$show){
			return ;
		}		
		
		if($title) $this->_config['title'] = $title;
		if($template!='') 	$this->_config['template'] = $template;
		if($perrow)		$this->_config['perrow'] = $perrow;		
		if($catsid)		$this->_config['catsid'] = $catsid;
		if($leading_product)		$this->_config['leading_product'] = $leading_product;
		if($intro_product)		$this->_config['intro_product'] = $intro_product;		
		if($maxchar)		$this->_config['maxchar'] = (int)$maxchar;		
	}
}