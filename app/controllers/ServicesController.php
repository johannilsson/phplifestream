<?php

require_once 'AbstractController.php';

class ServicesController extends AbstractController
{
    protected $_securedActions = array(
       'list', 'add', 'update', 'create', 'edit', 'destroy' 
    );
    protected $_serviceModel = null;

    public function indexAction()
    {
        $this->_redirect($this->_helper->url('list'));        
    }

    public function listAction() 
    {
        $model = $this->_getServiceModel();
        $this->view->services = $model->fetchEntries();
    }

    public function addAction() 
    {
        $form = $this->_getForm();
        $form->setAction($this->_helper->url->simple('create'));
        $this->view->form = $form;
    }

    public function createAction()
    {
        if (!$this->_request->isPost()) {
            $this->_redirect($this->_helper->url('list'));
        }

        $form = $this->_getForm();
        $form->setAction($this->_helper->url->simple('create'));
        $this->view->form = $form;

        if (!$form->isValid($this->_request->getPost())) {
            $this->view->messages = $form->getMessages();

            return $this->render('add');
        }

        $model = $this->_getServiceModel();
        $id = $model->add($form->getValues());

        $this->_redirect($this->_helper->url('edit', null, null, array('id' => $id)));        
    }

    public function editAction()
    {
        $model = $this->_getServiceModel();
        $service = $model->fetchEntry($this->getRequest()->getParam('id'));

        if (null === $service) {
            return $this->_forward('notfound', 'error');
        }

        $form = $this->_getForm();
        $form->setAction($this->_helper->url('update', null, null, array('id' => $service->id)));
        $form->populate($service->toArray());

        $subForm = $form->getSubForm('service_option');
        $subForm->populate($model->fetchOptions($service->id));

        $this->view->service       = $service;
        $this->view->serviceForm   = $form;
    }

    public function updateAction()
    {
        if (!$this->_request->isPost()) {
            $this->_redirect($this->_helper->url('list'));
        }

        $form = $this->_getForm();
        $form->setAction($this->_helper->url->simple('update'));
        $this->view->form = $form;

        if (!$form->isValid($this->_request->getPost())) {
            $this->view->messages = $form->getMessages();

            return $this->render('add');
        }

        $model = $this->_getServiceModel();
        $service = $model->fetchEntry($this->getRequest()->getParam('id'));

        if (null === $service) {
            return $this->_forward('notfound', 'error');
        }

        $id = $model->update($form->getValues(), $service->id);

        $this->_redirect($this->_helper->url('edit', null, null, array('id' => $id)));
    }

    public function destroyAction()
    {
        $model = $this->_getServiceModel();
        $service = $model->fetchEntry($this->getRequest()->getParam('id'));

        if (null === $service) {
            return $this->_forward('notfound', 'error');
        }

        $model->destroy($service);

        $this->_redirect($this->_helper->url('list'));
    }

    protected function _getServiceModel() 
    {
        if (null === $this->_serviceModel) { 
            require_once APPLICATION_PATH . '/models/ServiceModel.php'; 
            $this->_serviceModel = new ServiceModel(); 
        } 
        return $this->_serviceModel; 
    }

    protected function _getForm()
    {
        require_once APPLICATION_PATH . '/forms/ServiceForm.php';
        require_once APPLICATION_PATH . '/forms/FeedServiceOptionForm.php';
        $form = new ServiceForm();
        $optionForm = new FeedServiceOptionForm();
        $form->addSubForm($optionForm, 'service_option');

        return $form;
    }
    
} 
