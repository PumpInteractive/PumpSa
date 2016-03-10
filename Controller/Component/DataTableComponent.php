<?php
App::uses('Component', 'Controller');

/**
 * Component for working with DataTable class.
 *
 * @package PumpSa
 * @author Pump Interactive Inc.
 */
class DataTableComponent extends Component {

	public function dataTable($data, $configArray = null) {
		echo 'DataTable: ' . $data;

		if($configArray)
		{
			foreach($configArray as $configParam)
			{
				echo $configParam;
			}
		}
    }

}