<?php
/**
 * AppShell file
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 2.0
 */

App::uses('Shell', 'Console');

/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class AppShell extends Shell
{
    protected function formatNumber($number)
    {
        return preg_replace('/^0/', '+84', $number);
    }

    protected function formatGroupId($group_code)
    {
        return preg_replace('/^.*(\d{6,6})$/', '$1', MY_NUM) . '' . $group_code;
    }
}
