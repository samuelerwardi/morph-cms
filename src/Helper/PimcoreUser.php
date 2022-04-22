<?php
/**
 * Samuelerwardi samuelerwardi@gmail.com
 */

namespace AppBundle\Helper;
use Pimcore\Model\User;


/**
 * Class PimcoreUser
 * @package AppBundle\Helper
 */
class PimcoreUser
{
    /**
     * @return User
     */
    public static function get()
    {
        $session = \Pimcore\Tool\Session::getReadOnly();
        /** @var User $user */
        $user = $session->get('user');
        return $user;
    }
}
