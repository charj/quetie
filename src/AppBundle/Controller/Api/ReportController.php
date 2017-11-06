<?php

namespace AppBundle\Controller\Api;

use Charj\QueueBundle\Entity\FakeUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reports")
 */
class ReportController extends AbstractApiController
{
    /**
     * @Route("/generate", name="generate_report")
     * @param Request $request
     *
     * @return Response
     */
    public function generateAction(Request $request)
    {
        $emailAddress = $request->request->get('emailAddress');

        if (! $emailAddress) {
            return $this->jsonException('Please provide an emailAddress.');
        }
        $broker = $this->get('charj_queue.broker');
        $broker->queueReport($emailAddress);
        $broker->queueEmail($emailAddress);

        return $this->jsonResponse(['success' => 'Thanks. Your report will be emailed to you.']);
    }
}
