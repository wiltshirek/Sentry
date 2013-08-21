<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->view->form = new Form_Registration();

        if ($this->getRequest()->isPost()
                && $this->view->form->isValid($this->_getAllParams()))
        {
            
        }
        var_dump($this->_getAllParams());
    }

}

