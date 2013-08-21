<?php

/* Finally, weÕll update each action to use Doctrine 
and the Resident class instead of Zend_Db and the ResidentTable class.*/

namespace Resident\Controller;

use Zend\View\Model\ViewModel, 
    Resident\Form\ResidentForm,
    Doctrine\ORM\EntityManager,
    Resident\Entity\Resident;
use Zend\Mvc\Controller\AbstractActionController;



class ResidentController extends AbstractActionController
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
            'residents' => $this->getEntityManager()->getRepository('Resident\Entity\Resident')->findAll() 
        ));
    }
    
    public function validateformAction(){
        
        //$this->_helper->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true);
        $request = $this->getRequest();
        $f =  new ResidentForm();
        $resident = new Resident();
        
        $f->setInputFilter($resident->getInputFilter());
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
        $form = new ResidentForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $resident = new Resident();
            
            $form->setInputFilter($resident->getInputFilter());
            $form->setData($request->getPost());
             if ($form->isValid()) { 
                //$form->setAttribute('dob', new \DateTime("now"));
                $resident->populate($form->getData()); 
                $this->getEntityManager()->persist($resident);
                $this->getEntityManager()->flush();

                // Redirect to list of residents
                return $this->redirect()->toRoute('resident-profile'); 
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('resident_id');
        if (!$id) {
            return $this->redirect()->toRoute('resident', array('action'=>'add'));
        } 
        $resident = $this->getEntityManager()->find('Resident\Entity\Resident', $id);

        $form = new ResidentForm();
        $form->setBindOnValidate(false);
        $form->bind($resident);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of residents
                return $this->redirect()->toRoute('resident');
            }
        }

        return array(
            'resident_id' => $resident_id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('resident_id');
        if (!$id) {
            return $this->redirect()->toRoute('resident');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                //$id = (int)$request->getPost()->get('id');
                $resident = $this->getEntityManager()->find('Resident\Entity\Resident', $id);
                
                if ($resident) {
                	
                    $this->getEntityManager()->remove($resident);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of residents
            //return $this->redirect()->toRoute('resident');
            
            return $this->redirect()->toRoute('resident', array(
                'controller' => 'resident',
                'action'     => 'index',
            ));
            
        }

        return array(
            'resident_id' => $resident_id,
            'resident' => $this->getEntityManager()->find('Resident\Entity\Resident', $resident_id)->getArrayCopy()
        );
    }
}