<?php

namespace FondOfOryx\Zed\OneTimePasswordEmailConnector\Business;

use Generated\Shared\Transfer\OneTimePasswordResponseTransfer;

interface OneTimePasswordEmailConnectorInterface
{
    /**
     * @param \Generated\Shared\Transfer\OneTimePasswordResponseTransfer $oneTimePasswordResponseTransfer
     *
     * @return void
     */
    public function sendOneTimePasswordMail(OneTimePasswordResponseTransfer $oneTimePasswordResponseTransfer): void;
}
