<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string|null $phone
 * @property int $access_level
 * @property bool $locked
 * @property string|null $reset_token
 * @property \Cake\I18n\FrozenTime|null $reset_time
 * @property string $language
 * @property string $country
 * @property \Cake\I18n\FrozenDate|null $last_login
 * @property string $email
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool $active
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'first_name' => true,
        'last_name' => true,
        'phone' => true,
        'access_level' => true,
        'locked' => true,
        'reset_token' => true,
        'reset_time' => true,
        'language' => true,
        'country' => true,
        'last_login' => true,
        'email' => true,
        'created' => true,
        'modified' => true,
        'active' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

}
