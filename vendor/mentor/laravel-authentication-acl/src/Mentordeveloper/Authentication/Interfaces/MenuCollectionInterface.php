<?php  namespace Mentordeveloper\Authentication\Interfaces;
/**
 * Interface MenuCollectionInterface
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
interface MenuCollectionInterface
{
    /**
     * Obtain all the menu items
     * @return \Mentordeveloper\Authentication\Classes\MenuItem
     */
    public function getItemList();

    /**
     * Obtain the menu items that the current user can access
     * @return mixed
     */
    public function getItemListAvailable();

} 