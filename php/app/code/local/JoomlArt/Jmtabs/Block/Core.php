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

class JoomlArt_Jmtabs_Block_Core extends Mage_Core_Block_Template
{
	var $_config = array();
	var $_setTitles = '';
	var $_setContents = '';
	
	public function __construct($attributes = array()){
		$helper =  Mage::helper('joomlart_jmtabs/data');
		
		$this->_config['show'] = $helper->get('show', $attributes);
		if(!$this->_config['show']) return;
		
		parent::__construct();
		
		$this->_config['title'] = $helper->get('title', $attributes);
		$this->_config['style'] = $helper->get('style', $attributes);		
		$this->_config['position'] = $helper->get('position', $attributes);
		
		//$duration = $helper->get('duration', $attributes);
		 
		/*if($helper->get('animation', $attributes)=='animMoveHor'){
			$this->_config['animation'] = 'animate({width: "toggle"}, '.$duration.')';
		}else if($helper->get('animation', $attributes)=='animMoveVer'){
			$this->_config['animation'] = 'animate({height: "toggle"}, '.$duration.')';	
		}else{
			$this->_config['animation'] = 'fadeIn("'.$duration.'")';
		}*/
        
        if($helper->get('duration', $attributes)){
            $this->_config['duration'] = $helper->get('duration', $attributes);
        }else{
            $this->_config['duration'] = '0';
        }
           
        $this->_config['animation'] = $helper->get('animation', $attributes);  
		
		if($helper->get('height', $attributes)){
			$this->_config['height'] = $helper->get('height', $attributes);
		}else{
			$this->_config['height'] = 'auto';
		}
		
		if($helper->get('width', $attributes)){
			$this->_config['width'] = $helper->get('width', $attributes);
		}else{
			$this->_config['width'] = 'auto';
		}

		$this->_config['event'] = $helper->get('event', $attributes);
		
		$this->_config['skipanim'] = $helper->get('skipanim', $attributes);

	}
	
	protected function _prepareLayout()
	{
		if ($this->_config['show']) {
			$headBlock = $this->getLayout()->getBlock('head');
			$headBlock->addCss('joomlart/jmtabs/themes/'.$this->_config['style'].'/style.css');
		}
		
		return parent::_prepareLayout();
	}
	
	function addTabs_staticblock($title='', $identifier=''){
		if (!$title || !$identifier ) {
            return false;
        }
		$this->_setTitles[] = $title;
		$model_cms = Mage::getModel('cms/block');	
		$Model = Mage::getModel('joomlart_jmtabs/listData');
		$block_id = $Model->_getBlockId($model_cms, $identifier );
		
		$this->_setContents[] = $this->get_Content_Static_Block($block_id);	
	}
	
	function addTabs_block($title='', $block='', $template='', $alias='')
    {    	
        if (!$title || !$block || !$template) {
            return false;
        }
        
      	if ($alias=='') {
    		$alias = 'tab-'.rand();
    	}	
		
        $this->setChild($alias,
            $this->getLayout()->createBlock($block, $alias)
                ->setTemplate($template)
         );  
         
         $this->_setTitles[] = $title;
         $this->_setContents[] = $this->getChildHtml($alias);         
    }          
    	
	function _toHtml() {
		//$this->objBlock_head = Mage::getBlockSingleton('page/html_head');		
		//$this->objBlock_head->addCss('joomlart/jmtabs/themes/'.$this->_config['style'].'/style.css');	



		if(!$this->_config['show']) return;
		
		//$this->_setTitles[] = 'title';
		//$this->_setContents[] = $this->get_Content_Static_Block(5);	
		
		$this->assign('config', $this->_config);
			
		$this->assign('titles', $this->_setTitles)
			->assign('contents', $this->_setContents)
			->assign('tabsid', 'myTabs-'.rand());
			
		$this->setTemplate('joomlart/jmtabs/tabs.phtml');
        return parent::_toHtml();		
	}
	
	function get_Content_Static_Block($block_id){
		
        $html = '';
        if ($block_id) {
            $block = Mage::getModel('cms/block')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($block_id);
               
            if (!$block->getIsActive()) {
                $html = '';
            } else {                
				$helper 	= Mage::helper('cms');
                $processor 	= $helper->getBlockTemplateProcessor();
                $content 	= $processor->filter($block->getContent());
				
                $processor 	= Mage::getModel('core/email_template_filter');
                $html		= $processor->filter($content);
            }
        }
        return $html;
	}
	
	public function set($show=1, $title='', $style='default', $height='auto', $width='100%', $position='top', $animation='animMoveHor', $event='click', $duration=1000, $skipanim=false){
		//if($this->_config['show']){
			if(!$show){
				$this->_config['show'] = 0;
				return;
			}
			
				if($title) $this->_config['title'] = $title;
				if($style) $this->_config['style'] = $style;
				if($height){
					$this->_config['height'] = $height;
				}else{
					$this->_config['height'] = 'auto';
				}	
				
				if($width){
					$this->_config['width'] = $width;
				}else{
					$this->_config['width'] = 'auto';
				}
	            
				/*if($animation=='animMoveHor'){
					$this->_config['animation'] = 'animate({width: "toggle"}, '.$duration.')';
				}else if($animation=='animMoveVer'){
					$this->_config['animation'] = 'animate({height: "toggle"}, '.$duration.')';	
				}else{
					$this->_config['animation'] = 'fadeIn("'.$duration.'")';
				}*/

                if($duration){
                    $this->_config['duration'] = $duration;
                }else{
                    $this->_config['duration'] = '0';
                }
                
                if($animation) $this->_config['animation'] = $animation;   
				
				if($position) $this->_config['position'] = $position;
				if($event) $this->_config['event'] = $event;
				if($skipanim) $this->_config['skipanim'] = $skipanim;
		/*	}
		}else{
			$this->_config['style'] = 'default';
		}*/

		/*$action = Mage::app()->getFrontController()->getAction();
		$headblock = $action ? $action->getLayout()->getBlock('head') : false;			
		$headblock->addCss ("joomlart/jmtabs/jmtabs.css");
		$headblock->addCss ("joomlart/jmtabs/themes/".$this->_config['style']."/style.css");*/	
		
	}
	
	/*public function addTabs_skin(){
		$objBlock_head = Mage::getBlockSingleton('page/html_head');		
		$objBlock_head->addCss('ja_tabs/ja_tabs.css');		
	}*/		
}