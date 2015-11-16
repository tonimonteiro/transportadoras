<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Site\Form\Contact;
use Zend\Mail\Message;
use Zend\Mime\Part;
use Zend\Mime\Mime;

class ContactController extends AbstractActionController
{
    /**
     * @var string
     */
    private $pageName;

    /**
     * @return string
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * @param $pageName
     * @return $this
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
        return $this;
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
	public function indexAction()
    {
        // getting request.
        // getting request.
        $request = $this->getRequest();
        $path = $request->getUri()->getPath();
        $pathSearch = str_replace("/", "", str_replace("-", "", $path));

        // getting entities.
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $page = $entityManager->getRepository('SimNavigation\Entity\Navigation')->findOneByUri($path);
        $content = $entityManager->getRepository('SimCms\Entity\Cms')->findOneByNavigationName($pathSearch);

        // breadcrumb
        $path = $this->Path($page);
        $nameGroup = $page->getNameGroup();

        $this->setPageName($page->getLabel());

        if (($request->getQuery('send') == '1')) {
            // setting view
            $view = new ViewModel(array(
                'pageName' => $this->getPageName(),
                'form' => '',
                'breadcrumb' => $path['breadcrumb'],
                'nameGroup' => $nameGroup
            ));

            return $view;
        }

        // getting form.
        $form = new Contact($entityManager);

        // form validation/save.
        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $form->getData();

                /**
                 * Prepare message.
                 */
                $view = new ViewModel(array('data' => $data));
                $view->setTemplate('site/contact/contact.phtml');

                $viewRender = $this->getServiceLocator()->get('ViewRenderer');
                $html = $viewRender->render($view);

                $bodyPart = new \Zend\Mime\Message();

                $bodyMessage = new Part($html);
                $bodyMessage->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
                $bodyMessage->type = 'text/html';
                $bodyMessage->charset = 'UTF-8';

                $bodyPart->setParts(array($bodyMessage));

                /**
                 * Prepare send.
                 */
                $config = $this->getServiceLocator()->get('config');
                $configFrom = $config['configuration']['contact']['from'];
                $configTo = $config['configuration']['contact']['to'];

                $mail = new Message();
                $mail->addReplyTo($data['Email'], $data['Nome']);
                $mail->setFrom($configFrom, 'Sim Tecnologia');
                $mail->addTo($configTo);
                $mail->setSubject('Fale Conosco' . ($data['Assunto'] ? ': ' . $data['Assunto'] : ''));
                $mail->setEncoding('UTF-8');
                $mail->setBody($bodyPart);

                /**
                 * Send message.
                 */
                $transport = $this->getServiceLocator()->get('Site\Mail\Transport');
                $transport->send($mail);

                return $this->redirect()->toUrl('/contato?send=1');
            }
        }

        // setting view
        $view = new ViewModel(array(
            'pageName' => $this->getPageName(),
            'form' => $form,
            'breadcrumb' => $path['breadcrumb'],
            'nameGroup' => $nameGroup,
            'content' => $content
        ));

        return $view;

    }

}
