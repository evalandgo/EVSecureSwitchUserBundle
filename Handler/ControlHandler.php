<?php

namespace EV\SecureSwitchUserBundle\Handler;

/**
 * Description of ControlHandler
 *
 * @author Micka
 */
class ControlHandler {
    
    private $allowedToSwitchConfig;
    
    public function __construct($allowedToSwitchConfig) {
        $this->allowedToSwitchConfig = $allowedToSwitchConfig;
    }
    
    public function isAllowedToSwitch($user, $targetUser) {       
        $roles = $user->getRoles();
        
        foreach($roles as $role) {
            if ( isset($this->allowedToSwitchConfig['roles'][$role]) ) {
                $relationship = $this->allowedToSwitchConfig['roles'][$role]['relationship'];
                $getter = 'get'.ucfirst($relationship);
                $userParent = $targetUser->$getter();
                if ( $this->areSameUsers($user, $userParent) /*$user->isUser($userParent)*/ ) {
                    return true;
                }
            }
        }        
        
        return false;
    }
    
    private function areSameUsers($firstUser, $secondUser) {
        return null !== $firstUser && null !== $secondUser && $firstUser->getId() === $secondUser->getId();
    }
    
}

?>
