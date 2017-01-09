<?php
namespace XLite\Module\Shofi\AdvanceRegistration\View;

class AccountDialog extends \XLite\View\AccountDialog implements \XLite\Base\IDecorator {

    /**
     * Get a list of JS files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/Shofi/AdvanceRegistration/js/googleAddressAPI.js';


        return $list;
    }

    protected function getDefaultTemplate()
    {
        return 'modules/Shofi/AdvanceRegistration/account/account.twig';
    }



}

?>


