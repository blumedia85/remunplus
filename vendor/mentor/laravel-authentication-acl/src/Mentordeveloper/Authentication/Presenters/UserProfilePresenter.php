<?php  namespace Mentordeveloper\Authentication\Presenters;

use Mentordeveloper\Library\Presenters\AbstractPresenter;
use Config;

/**
 * Class UserProfilePresenter
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
class UserProfilePresenter extends AbstractPresenter
{
    protected $default_avatar;
    protected $default_gravatar;

    function __construct($resource)
    {
        $this->default_avatar = Config::get('laravel-authentication-acl::config.default_avatar_path');
        return parent::__construct($resource);
    }

    public function custom_avatar()
    {
        if(! $this->resource->avatar) return $this->default_avatar;

        return $this->getBase64ImageSrcHeader() .$this->resource->avatar;
    }

    /**
     * @return string
     */
    protected function getBase64ImageSrcHeader()
    {
        return "data:image/png;base64,";
    }

    public function gravatar($size = 30)
    {
        return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->resource->user()->first()->email ) ) ) .  "?s=" . $size;

    }

    public function avatar($size = 30)
    {
        $use_gravatar = Config::get('laravel-authentication-acl::config.use_gravatar');

        return $use_gravatar ? $this->gravatar($size) : $this->custom_avatar();
    }



} 