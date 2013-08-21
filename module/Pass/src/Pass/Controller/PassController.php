<?php

/* Finally, weÕll update each action to use Doctrine 
and the Pass class instead of Zend_Db and the PassTable class.*/

namespace Pass\Controller;

use Zend\View\Model\ViewModel, 
    Pass\Form\PassForm,
    Doctrine\ORM\EntityManager,
    Pass\Entity\Pass;
use Zend\Mvc\Controller\AbstractActionController;



class PassController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    } 

    public function indexAction()
    {
        return new ViewModel(array(
            'passs' => $this->getEntityManager()->getRepository('Pass\Entity\Pass')->findAll() 
        ));
    }
    
    public function validateformAction(){
        
        //$this->_helper->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true);
        $request = $this->getRequest();
        $f =  new PassForm();
        $pass = new Pass();
        
        $f->setInputFilter($pass->getInputFilter());
        $f->setData($request->getPost());
        if (! $f->isValid()){
           $json = $f->getMessages();
           //var_dump($f->getMessages());
            header('Content-type: application/json');
            echo \Zend\Json\Json::encode($json);
        }
         
        
            exit;
        
            
    }

    public function addAction()
    {
        $form = new PassForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $pass = new Pass();
            
            $form->setInputFilter($pass->getInputFilter());
            $form->setData($request->getPost());
             if ($form->isValid()) { 
                //$form->setAttribute('dob', new \DateTime("now"));
                $pass->populate($form->getData()); 
                $this->getEntityManager()->persist($pass);
                $this->getEntityManager()->flush();

                // Redirect to list of passs
                return $this->redirect()->toRoute('pass-profile'); 
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('pass_id');
        if (!$id) {
            return $this->redirect()->toRoute('pass', array('action'=>'add'));
        } 
        $pass = $this->getEntityManager()->find('Pass\Entity\Pass', $id);

        $form = new PassForm();
        $form->setBindOnValidate(false);
        $form->bind($pass);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of passs
                return $this->redirect()->toRoute('pass');
            }
        }

        return array(
            'pass_id' => $pass_id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('pass_id');
        if (!$id) {
            return $this->redirect()->toRoute('pass');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                //$id = (int)$request->getPost()->get('id');
                $pass = $this->getEntityManager()->find('Pass\Entity\Pass', $id);
                
                if ($pass) {
                	
                    $this->getEntityManager()->remove($pass);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of passs
            //return $this->redirect()->toRoute('pass');
            
            return $this->redirect()->toRoute('pass', array(
                'controller' => 'pass',
                'action'     => 'index',
            ));
            
        }

        return array(
            'pass_id' => $pass_id,
            'pass' => $this->getEntityManager()->find('Pass\Entity\Pass', $pass_id)->getArrayCopy()
        );
    }
}