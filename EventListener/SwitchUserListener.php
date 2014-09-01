<?php

namespace EV\SecureSwitchUserBundle\EventListener;

use Symfony\Component\Security\Http\Event\SwitchUserEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use EV\SecureSwitchUserBundle\Handler\ControlHandler;

/**
 * Description of SwitchUserListener
 *
 * @author Micka
 */
class SwitchUserListener {
    
    private $controlHandler;
    private $securityContext;
    
    public function __construct(ControlHandler $controlHandler, SecurityContextInterface $securityContext) {
        $this->controlHandler = $controlHandler;
        $this->securityContext = $securityContext;
    } 
    
    public function onSecuritySwitchUser(SwitchUserEvent $event) {
        
        if ($event->getRequest()->get('_switch_user') !== '_exit') {

            $user = $this->securityContext->getToken()->getUser();
            $targetUser = $event->getTargetUser();

            if (!$this->controlHandler->isAllowedToSwitch($user, $targetUser)) {
                throw new AccessDeniedException();
            }
        }        
        
    }
    
}

?>
