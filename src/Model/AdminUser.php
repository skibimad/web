<?php 
namespace App\Model;

use App\Core\Model;
use App\Core\Model\CollectionInterface;

class AdminUser extends Model
{
    const TABLE = 'admin_users';

    const COLUMN_ID = 'id';
    const COLUMN_USERNAME = 'email';
    const COLUMN_PASSWORD_HASH = 'password_hash';
    const COLUMN_ACTIVE = 'active';
    
    protected string $table = self::TABLE;


    public function loadByEmail(string $email): void
    {
        $collection = $this->getCollection()
            ->setItemMode(CollectionInterface::ITEM_MODE_OBJECT)
            ->addFilter([self::COLUMN_USERNAME => $email])
            ->addFilter([self::COLUMN_ACTIVE => 1])
            ->setPageSize(1);

        foreach ($collection as $item) {
            $this->setData($item->getData());
            return;
        }

        throw new \Exception('Admin user not found.');
    }

}