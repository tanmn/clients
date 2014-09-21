<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('CakeNumber', 'Utility');
App::uses('AppShell', 'Console/Command');

set_time_limit(0);
ini_set('memory_limit', -1);

class ReportShell extends AppShell
{
    public $uses = array('MasterLog');

    protected function _welcome()
    {
        $this->out();
        $this->out('VIBER REPORT by C3TEK (c3tek.biz)');
        $this->hr();
        $this->out('Now is ' . date('Y-m-d H:i:s') . ' - Agent number is ' . MY_NUM);

        if (!$this->testConnections('default')) {
            $this->mailErrors();
            $this->error('Cannot connect to application database.');
        }
    }

    public function main()
    {
        if (!empty($this->args[0]) && strtotime($this->args[0]) !== FALSE) {
            $this->process($this->args[0]);
        } else {
            $this->process('today');
        }
    }

    protected function process($target_date)
    {
        $this->startStats();

        $this->out();
        $target_date = date('Y-m-d', strtotime($target_date));
        $this->out('The target day is ' . $target_date);
        $this->hr();

        $logs = $this->MasterLog->fetchLogs(array(), $target_date);
        $new_users = $this->MasterLog->fetchNewUser($target_date);

        $filename = APP . 'Reports' . DS . 'REPORT ' . $target_date . ' - created ' . date('Ymd-His') . '.xlsx';

        $report_info = '';
        $report_info .= 'Including agent number in report: ' . (REPORT_INCLUDE_MY_NUM ? 'YES' : 'NO') . "\n";
        $report_info .= 'Including private inboxes in report: ' . (REPORT_INCLUDE_PRIVATE ? 'YES' : 'NO') . "\n";
        $report_info .= 'Prefer white-listed groups in report: ' . (REPORT_WHITELIST_ONLY ? 'YES' : 'NO') . "\n";
        $report_info .= 'Show only groups have activities: ' . (REPORT_EXCLUDE_INACTIVE_GROUPS ? 'YES' : 'NO') . "\n";
        $report_info .=  "\n";
        $report_info .= 'Total groups in the report: ' . count($logs['data']) . "\n";
        $report_info .= 'Total groups have new members: ' . count($new_users['data']) . "\n";
        $report_info .= 'Output report: ' . $filename;

        $this->out($report_info);

        App::import('Lib', 'Excel');
        $helper = new Excel();

        $helper->createWorksheet();
        $helper->setDefaultFont('Arial', 10);

        $helper->setActiveSheet(0);
        $helper->setSheetName('Summary');

        $helper->addTableHeader(array(
            array(
                'label' => 'Description',
                'wrap' => TRUE
            ),
            array(
                'label' => 'Info'
            )
        ));
        $helper->addTableRow(array(
            'Agent number',
            MY_NUM
        ));
        $helper->addTableRow(array(
            'Daily report on',
            $target_date
        ));
        $helper->addTableRow(array(
            'Total groups / private inboxes',
            count($logs['data'])
        ));
        $helper->addTableRow(array(
            'Total groups / private inboxes have new members',
            count($new_users['data'])
        ));
        $helper->mergeCells('A', 'B');
        $helper->addTableRow(array(
            'For more detailed information, please view another sheets in this file.'
        ));
        $helper->mergeCells('A', 'B');
        $helper->addTableRow(array(
            'This report is generated at ' . date('H:i:s') . ' on ' . date('Y-m-d') . '.'
        ));
        $helper->addTableFooter();

        $count = 1;

        foreach ($logs['data'] as $group_code => $group_info) {
            $sheetName = trim($group_info['is_private'] ? preg_replace('/[\.\?\*\+\[\]\$]+/', '', $group_code) : $group_info['group_name']);
            $sheetName = preg_replace('/^(.{0,30}).*$/', '$1', $sheetName);

            $helper->addSheet($sheetName);
            $helper->mergeCells('A', 'J');
            $helper->addData(array(
                'Summary on ' . $target_date
            ));
            $helper->addData(array());

            $helper->mergeCells('A', 'J');
            $helper->addData(array(
                'Group name: ' . ($group_info['is_private'] ? 'Private inbox' : $group_info['group_name'])
            ));
            $helper->mergeCells('A', 'J');
            $helper->addData(array(
                'Group code: ' . $group_code
            ));
            $helper->addData(array());

            $helper->addTableHeader($this->getGroupHeader(), array(
                'bold' => true
            ));

            $i = 1;

            foreach ($group_info['Logs'] as $number => $data) {
                $data['index'] = $i;
                $helper->addTableRow($this->getGroupRow($data));
                $i++;
                unset($number, $data);
            }

            $helper->addTableFooter();

            if (isset($new_users['data'][$group_code])) {
                $helper->addData(array());
                $helper->mergeCells('A', 'E');
                $helper->addData(array(
                    'New members joined on ' . $target_date
                ));
                $helper->addData(array());
                $helper->addTableHeader($this->getUserHeader(), array(
                    'bold' => true
                ));

                $i = 1;

                foreach ($new_users['data'][$group_code] as $number => $info) {
                    $info['index'] = $i;
                    $helper->addTableRow($this->getUserRow($info));
                    $i++;
                    unset($number, $info);
                }

                $helper->addTableFooter();
            }

            $helper->setRow(1);
            $count++;
            unset($group_code, $group_info, $sheetName, $i);
        }

        $helper->setActiveSheet(0);
        $helper->setRow(1);
        $helper->save($filename);
        $helper->freeMemory();

        $this->showStats();

        $this->mailReport($target_date, $report_info, $filename);

        unset($helper, $logs, $new_users, $report_info, $filename);
    }

    protected function getGroupHeader()
    {
        return array(
            array(
                'label' => '#',
                'filter' => true,
                'width' => 5
            ),
            array(
                'label' => 'Viber Name',
                'filter' => true
            ),
            array(
                'label' => 'Phone Number',
                'filter' => true
            ),
            array(
                'label' => 'Is Viber?',
                'filter' => true
            ),
            array(
                'label' => 'Is Agent?',
                'filter' => true
            ),
            array(
                'label' => 'Text msg.'
            ),
            array(
                'label' => 'Stickers'
            ),
            array(
                'label' => 'Voice msg.'
            ),
            array(
                'label' => 'Media msg.'
            ),
            array(
                'label' => 'Total'
            )
        );
    }

    protected function getGroupRow($data)
    {
        $data['total'] = $data['message'] + $data['sticker'] + $data['media'] + $data['voice'];

        return Hash::merge(array(
            'index' => 0,
            'viber_name' => '',
            'number' => '',
            'is_viber' => '',
            'is_agent' => '',
            'message' => 0,
            'sticker' => 0,
            'media' => 0,
            'voice' => 0,
            'total' => 0
        ), $data);
    }

    protected function getUserHeader()
    {
        return array(
            array(
                'label' => '#',
                'filter' => true,
                'width' => 5
            ),
            array(
                'label' => 'Viber Name',
                'filter' => true
            ),
            array(
                'label' => 'Phone Number',
                'filter' => true
            ),
            array(
                'label' => 'Is Viber?',
                'filter' => true
            ),
            array(
                'label' => 'Is Agent?',
                'filter' => true
            )
        );
    }

    protected function getUserRow($data)
    {
        return Hash::merge(array(
            'index' => 0,
            'viber_name' => '',
            'number' => '',
            'is_viber' => '',
            'is_agent' => ''
        ), $data);
    }

    protected function mailReport($target_date, $info = '', $attachment = FALSE)
    {
        $receivers = Configure::read('RECEIVERS');
        if(empty($receivers)) return;

        $message = 'Dear staff,';
        $message .= "\n\n";
        $message .= 'I sent you a report for ' . $target_date . '.';
        $message .= "\n\n";
        $message .= $info;
        $message .= "\n\n";
        $message .= 'Please see the attachment below for more information.';
        $message .= "\n\n";

        $message .= ' ※ This message was sent automatically from the agent ' . MY_NUM . ' at ' . date('Y-m-d H:i:s') . '.';

        $this->out('Sending email...');

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('gmail');
        $Email->to($receivers);

        if (!empty($attachment)) {
            $Email->attachments($attachment);
        }

        $Email->subject('[VIBER APP] Daily report on ' . $target_date . ' from the agent ' . MY_NUM);

        try {
            $Email->send($message);
        }
        catch (Exception $e) {
            $this->out('Mail not sent: ' . $e->getMessage());
        }
    }
}