<?php

namespace App\Controller\Admin\Landing;

use App\Controller\AdminController;
use App\Model\LandingPageContent;

class Update extends AdminController
{
    public function handle(): void
    {
        if ($this->getRequest()->isPost()) {
            $this->updateContent();
            $this->redirect('/admin/landing');
        }

        // Redirect to landing page if accessed via GET
        $this->redirect('/admin/landing');
    }

    protected function updateContent(): void
    {
        $landingData = $this->getRequest()->post('landing');
        
        if (!is_array($landingData)) {
            return;
        }

        $sectionsConfig = LandingPageContent::getSectionsConfig();

        foreach ($landingData as $section => $fields) {
            if (!isset($sectionsConfig[$section])) {
                continue;
            }

            foreach ($fields as $fieldKey => $value) {
                if (!isset($sectionsConfig[$section]['fields'][$fieldKey])) {
                    continue;
                }

                $fieldType = $sectionsConfig[$section]['fields'][$fieldKey]['type'];
                LandingPageContent::setValue($section, $fieldKey, $value, $fieldType);
            }
        }
    }
}
