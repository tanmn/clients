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

    protected function testConnections($name)
    {
        App::uses('ConnectionManager', 'Model');

        try {
            $connected = ConnectionManager::getDataSource($name);
        }
        catch (Exception $connectionError) {
            $connected = false;
            $errorMsg = $connectionError->getMessage();

            if (method_exists($connectionError, 'getAttributes')) {
                $attributes = $connectionError->getAttributes();

                if (isset($errorMsg['message'])) {
                    $errorMsg .= "\n → " . $attributes['message'];
                }
            }

            $this->errors[] = $errorMsg;
            return false;
        }

        return true;
    }

    protected function sql($source = 'default'){
        $db = ConnectionManager::getDataSource($source);
        $logs = $db->getLog();

        $this->out();
        $this->out('SQL logs');
        $this->out();
        $this->hr();

        if(!empty($logs['log'])){
            foreach($logs['log'] as $i => $log){
                $this->out("{$i}. ---- Took {$log['took']}ms");
                $this->out($log['query']);
                $this->out();
            }
        }

        $this->out();
    }

    protected $errors = array();

    protected function mailErrors($data = NULL)
    {
        if (empty($this->errors))
            return;

        $message = 'Dear administrators,';
        $message .= "\n\n";
        $message .= 'The app meets errors when trying collect data.';
        $message .= "\n\n";
        $message .= " → " . implode("\n → ", $this->errors);
        $message .= "\n\n";

        if (!empty($data)) {
            $message .= "Proceeded data:\nPlease view attached file below this email.";
            $message .= "\n";

            $attachment = APP . 'webroot' . DS . 'files' . DS . 'proceeded_data_' . date('Ymd.His') . '.bak';
            @file_put_contents($attachment, serialize($data));
        }

        $message .= ' ※ This message was sent automatically from the agent ' . MY_NUM . ' at ' . date('Y-m-d H:i:s') . '.';

        $this->out('ERROR!!! Sending email to developers...');

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('gmail');
        $Email->to(Configure::read('DEVELOPERS'));

        if (isset($attachment)) {
            $Email->attachments($attachment);
        }

        $Email->subject('[VIBER APP] Error report from the agent ' . MY_NUM);

        try {
            $Email->send($message);
        }
        catch (Exception $e) {
            $this->out('Mail not sent: ' . $e->getMessage());
        }
    }

    public function mailOverloaded($time)
    {
        $message = 'Dear administrators,';
        $message .= "\n\n";
        $message .= 'It seems process has been taking to long to respond. Time detected: ' . $time . 's.';
        $message .= ' ※ This message was sent automatically from the agent ' . MY_NUM . ' at ' . date('Y-m-d H:i:s') . '.';

        $this->out('ERROR!!! Sending email to developers...');

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('gmail');
        $Email->to(Configure::read('DEVELOPERS'));

        $Email->subject('[VIBER APP] Timeout warning from the agent ' . MY_NUM);

        try {
            $Email->send($message);
        }
        catch (Exception $e) {
            $this->out('Mail not sent: ' . $e->getMessage());
        }
    }
}
