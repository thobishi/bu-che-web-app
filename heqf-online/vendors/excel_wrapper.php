<?php
require_once 'PHPExcel/PHPExcel/IOFactory.php';

class ExcelWrapper {

	private $__fileName;

	private $__curRow = 0;

	private $__ExcelFile, $__Worksheet, $__Rows, $__header;

	public function __construct($filename) {
		$this->__fileName = $filename;
		$this->__ExcelFile = PHPExcel_IOFactory::load($this->__fileName);
		$this->__Worksheet = $this->__ExcelFile->setActiveSheetIndex(0);
		$this->__Rows = $this->__Worksheet->getRowIterator();

		return true;
	}

	public function readHead() {
		$dataHead = array();
		$this->__Rows->rewind();
		$Row = $this->__Rows->current();
		$Cells = $Row->getCellIterator();

		foreach ($Cells as $index => $Cell) {
			$column = $Cell->getColumn();
			$dataHead[$column]['name'] = trim($Cell->getCalculatedValue());
			$dataHead[$column]['slug'] = Inflector::slug((strtolower(preg_replace(array("/(.*)[\n\r]*.*/"), array('\\1'), $dataHead[$column]['name']))));
		}

		$this->__header = $dataHead;

		return count($dataHead) > 0 ? $dataHead : false;
	}

	public function readNextRow() {
		if (!$this->__Rows->valid()) {
			return false;
		}

		$this->__Rows->next();
		$Row = $this->__Rows->current();
		$Cells = $Row->getCellIterator();

		$dataRow = array();

		foreach ($Cells as $index => $Cell) {
			$column = $Cell->getColumn();
			if (isset($this->__header[$column])) {
				$dataRow[$this->__header[$column]['slug']] = trim($Cell->getCalculatedValue());
			}
		}

		$dataRow = array_filter($dataRow, 'strlen');

		if (empty($dataRow)) {
			return false;
		}

		foreach ($this->__header as $header) {
			if (!isset($dataRow[$header['slug']])) {
				$dataRow[$header['slug']] = '';
			}
		}
		return count($dataRow) > 0 ? $dataRow : false;
	}

	public function getHighestColumn() {
		return $this->__Worksheet->getHighestColumn();
	}

	public function getHighestRow() {
		return $this->__Worksheet->getHighestRow();
	}

	public function changeSheet($sheet) {
		$this->__Worksheet = $this->__ExcelFile->setActiveSheetIndex($sheet);
		$this->__Rows = $this->__Worksheet->getRowIterator();
	}

	public function numSheets() {
		return count($this->__ExcelFile->getAllSheets());
	}

	public function sheetTitle() {
		return $this->__ExcelFile->getActiveSheet()->getTitle();
	}

	public function setHead($newHead) {
		$this->__header = $newHead;
	}
}