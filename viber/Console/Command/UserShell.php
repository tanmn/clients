<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz).  All Rights Reserved.

*/

App::uses('AppShell', 'Console/Command');
App::uses('ConnectionManager', 'Model');

set_time_limit(0);
ini_set('memory_limit', '256M');
Configure::write('debug', 0);

class UserShell extends AppShell
{

    public $uses = array('OriginNumberInfo', 'MasterUser');

    protected $errors = array();

    protected function _welcome()
    {
        $this->out();
        $this->out('USER PROCESS by C3TEK (c3tek.biz)');
        $this->hr();
    }

    public function main()
    {
        if (!$this->testConnections('viber'))
        {
            $this->mailErrors();
            return FALSE;
        }

        $this->out('Processing...');

        $time_start = microtime(true);

        $output = $this->process();

        $time_stop = microtime(true);
        $time = (($time_stop - $time_start) * 1);

        $this->hr();
        $this->out('Total users have been updated: ' . count($output) . '.');
        $this->out('Total process time: ' . $time . 's');
        $this->out();

        $this->mailErrors($output);
    }

    protected function testConnections($name)
    {
        try
        {
            $connected = ConnectionManager::getDataSource($name);
        }
        catch (Exception $connectionError)
        {
            $connected = false;
            $errorMsg = $connectionError->getMessage();

            if (method_exists($connectionError, 'getAttributes'))
            {
                $attributes = $connectionError->getAttributes();

                if (isset($errorMsg['message']))
                {
                    $errorMsg .= "\n -> " . $attributes['message'];
                }
            }

            $this->errors[] = $errorMsg;
            return false;
        }

        return true;
    }

    protected function process()
    {
        if (!$this->testConnections('viber'))
        {
            return FALSE;
        }

        if (!$this->testConnections('default'))
        {
            return FALSE;
        }

        $raw_users = $this->OriginNumberInfo->find('all');
        $users = array();

        foreach ($raw_users as $user)
        {
            $users[] = array(
                'number' => $this->formatNumber($user['OriginNumberInfo']['Number']),
                'name' => $user['OriginNumberInfo']['ClientName'],
                'avatar' => @file_get_contents($user['OriginNumberInfo']['AvatarPath'])
            );
        }

        if (empty($users))
            return $users;

        $dbo = $this->MasterUser->getDataSource();
        $dbo->begin();

        if ($this->MasterUser->saveMany($users))
        {
            $dbo->commit();
        }
        else
        {
            $dbo->rollback();
        }

        return $users;
    }

    protected function mailErrors($data = NULL)
    {
        if (empty($this->errors))
            return;

        $message = 'Dear administrators,';
        $message .= "\n\n";
        $message .= 'The app meets errors when trying collect data.';
        $message .= "\n\n";
        $message .= "-------ERROR DETAILS-------";
        $message .= "\n\n";
        $message .= implode("\n", $this->errors);
        $message .= "\n\n";
        $message .= "-------ERROR DETAILS--------";
        $message .= "\n\n";

        if (!empty($data))
        {
            $message .= "Proceeded data:\nPlease view attached file below this email.";
            $message .= "\n";
            $message .= "----------------------------";
            $message .= "\n";

            $attachment = APP . 'webroot' . DS . 'files' . DS . 'proceeded_data_' . date('Ymd.His') . '.log';
            @file_put_contents($attachment, serialize($data));
        }

        $message .= 'This message was sent automatically from client ' . MY_NUM . ' at ' . date('Y-m-d H:i:s') . '.';

        $this->out('Errors:');
        $this->out($message);

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('gmail');
        $Email->to(Configure::read('DEVELOPERS'));

        if (isset($attachment))
        {
            $Email->attachments($attachment);
        }

        $Email->subject('[VIBER APP] Error report from hotline ' . MY_NUM);

        try
        {
            $Email->send($message);
        }
        catch (Exception $e)
        {
            $this->out('Mail not sent: ' . $e->getMessage());
        }
    }
}
