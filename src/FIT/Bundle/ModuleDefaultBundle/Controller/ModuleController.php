<?php

namespace FIT\Bundle\ModuleDefaultBundle\Controller;

use FIT\NetopeerBundle\Controller\ModuleControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ModuleController extends \FIT\NetopeerBundle\Controller\ModuleController implements ModuleControllerInterface
{
	/**
	 * @inheritdoc
	 *
	 * @Route("/sections/{key}/", name="section")
	 * @Route("/sections/{key}/{module}/", name="module", requirements={"key" = "\d+"})
	 * @Route("/sections/{key}/{module}/{subsection}/", name="subsection")
	 * @Template("FITModuleDefaultBundle:Module:section.html.twig")
	 *
	 */
	public function moduleAction($key, $module = null, $subsection = null)
	{
		/**
		 * @var \FIT\NetopeerBundle\Models\Data $dataClass
		 */
		$dataClass = $this->get('DataModel');
		$res = $this->prepareDataForModuleAction("FITModuleDefaultBundle", $key, $module, $subsection);

		/* parent module did not prepares data, but returns redirect response,
		 * so we will follow this redirect
		 */
		if ($res instanceof RedirectResponse) {
			return $res;
		}

		// check if we have only root module
		$this->checkEmptyRootModule($key, $res);

		// we will load config part only if two column layout is enabled or we are in all section or datastore is not running (which has two column always)
		$tmp = $this->getConfigParams();
		if ($module === 'all') {
			$merge = false;
		} else {
			$merge = true;
		}
		if ($module == null || ($module != null && $tmp['source'] !== "running" && !$this->getAssignedValueForKey('isEmptyModule'))) {
			$this->loadConfigArr(false, $merge);
			$this->setOnlyConfigSection();
		} else if ( $module == null || $module == 'all' || ($module != null && $this->get('session')->get('singleColumnLayout') != "true") ) {
			$this->loadConfigArr(true, $merge);
			$this->assign('singleColumnLayout', false);
			if ($module == 'all') {
				$this->assign('hideColumnControl', true);
			}
		} else if ($this->get('session')->get('singleColumnLayout') != "true") {
			$this->loadConfigArr(false, $merge);
			$this->assign('singleColumnLayout', true);
			$this->setOnlyConfigSection();
		} else {
			$conn = $dataClass->getConnectionSessionForKey($key);
			if ($conn->getCurrentDatastore() !== "running") {
				$this->loadConfigArr(false, $merge);
				$this->setOnlyConfigSection();
			}
			$this->assign('singleColumnLayout', true);
		}

		return $this->getTwigArr();
	}

	/**
	 * @param int    $key
	 * @param string $xml    result of prepareDataForModuleAction()
	 */
	private function checkEmptyRootModule($key, $xml) {
		if ($xml instanceof \SimpleXMLIterator && $xml->count() == 0) {
			$isEmptyModule = true;
			if ($xml->getName() == 'root') {
				$this->setEmptyModuleForm($this->getRequest()->get('key'));
				$isEmptyModule = false;
				$this->assign('forceShowFormConfig', true);
			}
			$this->assign('isEmptyModule', $isEmptyModule);
			$this->assign('key', $this->getRequest()->get('key'));
			$this->assign('additionalTitle', 'Create empty root element');
			$this->assign('redirectUrl', $this->getRequest()->getRequestUri());
			$this->setEmptyModuleForm($key);
			$template = $this->get('twig')->loadTemplate('FITModuleDefaultBundle:Module:createEmptyModule.html.twig');
			$html = $template->renderBlock('singleContent', $this->getAssignedVariablesArr());

			$this->assign('additionalForm', $html);
		} else {
			$this->assign('showRootElem', true);
		}
	}

}
