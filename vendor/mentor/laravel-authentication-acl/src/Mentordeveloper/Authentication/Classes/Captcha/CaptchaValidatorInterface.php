<?php
namespace Mentordeveloper\Authentication\Classes\Captcha;

/**
 * Class CaptchaValidator
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
interface CaptchaValidatorInterface
{
    public function validateCaptcha($attribute, $value);

    public function getValue();

    /**
     * @return mixed
     */
    public function getErrorMessage();

    public function getImageSrcTag();
}