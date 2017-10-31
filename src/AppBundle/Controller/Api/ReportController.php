<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reports")
 */
class ReportController extends AbstractApiController
{
    /**
     * @Route("/*")
     */
    public function listAction()
    {
        // TODO Return a nice list of reports.
    }

    /**
     * @Route("/generate", name="generate_report")
     */
    public function generateAction()
    {
        //TODO massive generation of a report

        //Eating all your RAMs like google Chrome yo.

        //TODO avoid this response.

        return $this->jsonException('Ran out of memory. Damn you Chrome.');
    }
}
