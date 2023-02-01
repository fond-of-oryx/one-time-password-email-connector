<?php

namespace FondOfOryx\Zed\OneTimePasswordEmailConnector\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailjetTemplateTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface;

/**
 * @method \FondOfOryx\Zed\OneTimePasswordEmailConnector\OneTimePasswordEmailConnectorConfig getConfig()
 */
class LoginLinkMailjetMailTypeBuilderPlugin extends AbstractPlugin implements MailTypeBuilderPluginInterface
{
    /**
     * @var string
     */
    public const CUSTOMER = 'customer';

    /**
     * @var string
     */
    public const FIRST_NAME = 'firstName';

    /**
     * @var string
     */
    public const LAST_NAME = 'lastName';

    /**
     * @var string
     */
    public const ONE_TIME_PASSWORD_LOGIN_LINK = 'oneTimePasswordLoginLink';

    /**
     * @uses OneTimePasswordEmailConnectorLoginLinkMailTypeBuilderPlugin::MAIL_TYPE
     *
     * @var string
     */
    public const MAIL_TYPE = 'one time password login link mail';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_MAIL_SUBJECT = 'mail.customer.one-time-password.login-link.subject';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::MAIL_TYPE;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\NullValueException
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function build(MailTransfer $mailTransfer): MailTransfer
    {
        $mailjetTemplateTransfer = (new MailjetTemplateTransfer())
            ->setSubject(static::GLOSSARY_KEY_MAIL_SUBJECT)
            ->setTemplateId($this->getTemplateId($mailTransfer));

        return $mailTransfer->setMailjetTemplate(
            $this->setVariables($mailTransfer, $mailjetTemplateTransfer),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\MailjetTemplateTransfer $mailjetTemplateTransfer
     *
     * @return \Generated\Shared\Transfer\MailjetTemplateTransfer
     */
    protected function setVariables(
        MailTransfer $mailTransfer,
        MailjetTemplateTransfer $mailjetTemplateTransfer
    ): MailjetTemplateTransfer {
        return $mailjetTemplateTransfer->setVariables([
            static::ONE_TIME_PASSWORD_LOGIN_LINK => $mailTransfer->getOneTimePasswordLoginLink(),
            static::CUSTOMER => [
                static::FIRST_NAME => $mailTransfer->getCustomerOrFail()->getFirstName(),
                static::LAST_NAME => $mailTransfer->getCustomerOrFail()->getLastName(),
            ],
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return int
     */
    protected function getTemplateId(MailTransfer $mailTransfer): int
    {
        $locale = $mailTransfer->getLocale()->getLocaleName();

        return $this->getConfig()->getOneTimePasswordLoginLinkMailTemplateIdByLocale($locale);
    }
}