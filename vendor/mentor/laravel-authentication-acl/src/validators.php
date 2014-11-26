<?php
// mail validator
Validator::extend('mail_signup', 'Mentordeveloper\Authentication\Validators\UserSignupEmailValidator@validateEmailUnique');
// captcha validator
use Mentordeveloper\Authentication\Classes\Captcha\GregWarCaptchaValidator;
$captcha_validator = App::make('captcha_validator');
Validator::extend('captcha', 'Mentordeveloper\Authentication\Classes\Captcha\GregWarCaptchaValidator@validateCaptcha', $captcha_validator->getErrorMessage() );