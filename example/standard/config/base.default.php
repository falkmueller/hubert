<?php
//https://framework.zend.com/learn

return array(
    "factories" => array(
        /**
         * https://docs.zendframework.com/zend-diactoros/
         */
        "request" => array(hubert\factory\zend::class, 'getRequest'),
        /**
         * https://docs.zendframework.com/zend-eventmanager/
         */
        "eventManager" => array(hubert\factory\zend::class, 'getEventManager'),
        /**
         * https://docs.zendframework.com/zend-session/
         */
        "session" => array(hubert\factory\zend::class, 'getSession')
    ),
    
    "config" => array(
        "session" => array(
            'remember_me_seconds' => 1800,
            'name'                => 'zf2',
        ),
        "bootstrap" => app\bootstrap::class
    )
);


/*
 * 
 *
$events->attach('do', function ($e) {
    $event = $e->getName();
    $params = $e->getParams();
    $params["aaa"] = "vvv";
    printf(
        'Handled event "%s", with parameters %s',
        $event,
        json_encode($params)
    );
    
    return "ffffffffffffffffffff";
});

$params = ['foo' => 'bar', 'baz' => 'bat'];
$a = $events->trigger('do', null, $params);
print_r($a->last());
 * 
 */
