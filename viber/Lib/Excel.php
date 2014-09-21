<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel'.DS.'PHPExcel.php'));

class Excel
{
    protected $_xls;

    protected $_row = 1;

    protected $_activeSheet;

    protected $_tableParams;

    protected $_maxRow = 0;

    public function createWorksheet()
    {
        $this->_xls = new PHPExcel();
        $this->_row = 1;

        return $this;
    }

    public function loadWorksheet($file)
    {
        $this->_xls = PHPExcel_IOFactory::load($file);
        $this->setActiveSheet(0);
        $this->_row = 1;

        return $this;
    }

    public function addSheet($name)
    {
        $index = $this->_xls->getSheetCount();
        $this->_xls->createSheet($index)->setTitle($name);

        $this->setActiveSheet($index);

        return $this;
    }

    public function setActiveSheet($sheet)
    {
        $this->_activeSheet = $this->_xls->setActiveSheetIndex($sheet);
        $this->_maxRow = $this->_activeSheet->getHighestRow();
        $this->_row = 1;

        return $this;
    }

    public function setSheetName($name)
    {
        $this->_xls->getActiveSheet()->setTitle($name);

        return $this;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array(array(
            $this->_xls,
            $name
        ), $arguments);
    }

    public function setDefaultFont($name, $size)
    {
        $this->_xls->getDefaultStyle()->getFont()->setName($name);
        $this->_xls->getDefaultStyle()->getFont()->setSize($size);

        return $this;
    }

    public function mergeCells($from, $to){
        $range = $from.$this->_row . ':' . $to.$this->_row;
        $this->_activeSheet->mergeCells($range);

        return $this;
    }

    public function setRow($row)
    {
        $this->_row = (int) $row;

        return $this;
    }

    public function addTableHeader($data, $params = array())
    {
        $offset = 0;
        if (isset($params['offset']))
            $offset = is_numeric($params['offset']) ? (int) $params['offset'] : PHPExcel_Cell::columnIndexFromString($params['offset']);

        if (isset($params['font']))
            $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setName($params['font']);

        if (isset($params['size']))
            $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setSize($params['size']);

        if (isset($params['bold']))
            $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setBold($params['bold']);

        if (isset($params['italic']))
            $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setItalic($params['italic']);

        $this->_tableParams = array(
            'header_row' => $this->_row,
            'offset' => $offset,
            'row_count' => 0,
            'auto_width' => array(),
            'filter' => array(),
            'wrap' => array()
        );

        foreach ($data as $d) {
            $this->_xls->getActiveSheet()->setCellValueByColumnAndRow($offset, $this->_row, $d['label']);

            if (isset($d['width']) && is_numeric($d['width']))
                $this->_xls->getActiveSheet()->getColumnDimensionByColumn($offset)->setWidth((float) $d['width']);
            else
                $this->_tableParams['auto_width'][] = $offset;

            if (isset($d['filter']) && $d['filter'])
                $this->_tableParams['filter'][] = $offset;

            if (isset($d['wrap']) && $d['wrap'])
                $this->_tableParams['wrap'][] = $offset;

            $offset++;
        }
        $this->_row++;

        return $this;
    }

    public function addTableRow($data)
    {
        $offset = $this->_tableParams['offset'];

        foreach ($data as $d)
            $this->_xls->getActiveSheet()->setCellValueByColumnAndRow($offset++, $this->_row, $d);

        $this->_row++;
        $this->_tableParams['row_count']++;

        return $this;
    }

    public function addTableFooter()
    {
        if (count($this->_tableParams['filter']))
            $this->_xls->getActiveSheet()->setAutoFilter(PHPExcel_Cell::stringFromColumnIndex($this->_tableParams['filter'][0]) . ($this->_tableParams['header_row']) . ':' . PHPExcel_Cell::stringFromColumnIndex($this->_tableParams['filter'][count($this->_tableParams['filter']) - 1]) . ($this->_tableParams['header_row'] + $this->_tableParams['row_count']));

        foreach ($this->_tableParams['wrap'] as $col)
            $this->_xls->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col) . ($this->_tableParams['header_row'] + 1) . ':' . PHPExcel_Cell::stringFromColumnIndex($col) . ($this->_tableParams['header_row'] + $this->_tableParams['row_count']))->getAlignment()->setWrapText(true);

        foreach ($this->_tableParams['auto_width'] as $col)
            $this->_xls->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);

        return $this;
    }

    public function addData($data, $offset = 0)
    {
        if (!is_numeric($offset))
            $offset = PHPExcel_Cell::columnIndexFromString($offset);

        foreach ($data as $d)
            $this->_xls->getActiveSheet()->setCellValueByColumnAndRow($offset++, $this->_row, $d);

        $this->_row++;

        return $this;
    }

    public function getTableData($max = 100)
    {
        if ($this->_row > $this->_maxRow)
            return false;

        $data = array();

        for ($col = 0; $col < $max; $col++)
            $data[] = $this->_xls->getActiveSheet()->getCellByColumnAndRow($col, $this->_row)->getValue();

        $this->_row++;

        return $data;
    }

    public function getWriter($writer)
    {
        return PHPExcel_IOFactory::createWriter($this->_xls, $writer);
    }

    public function save($file, $writer = 'Excel2007')
    {
        $objWriter = $this->getWriter($writer);
        return $objWriter->save($file);
    }

    public function output($filename = 'export.xlsx', $writer = 'Excel2007')
    {
        ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $objWriter = $this->getWriter($writer);
        $objWriter->save('php://output');

        exit;
    }

    public function freeMemory()
    {
        $this->_xls->disconnectWorksheets();
        unset($this->_activeSheet, $this->_xls);
    }
}