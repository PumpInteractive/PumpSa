<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Helper for working with DataTable class.
 *
 * @package DataTable Helper
 * @author Pump Interactie Inc.
 */
class DataTableHelper extends AppHelper {

	/* dataTable function creates a basic datatable widget with or without the configuration parameters.
	*
	*	Possible config variables
	*	TableTitle,WidgetDelete,WidgetColor,WidgetEdit,WidgetToggle,WidgetFillScreen,WidgetCustom,WidgetCollapse,WidgetSort, WidgetIcon,
	*
	*	@returns the data table name to be passed into the dataTableJavaScript method to initialize the table
	*/

	public function dataTable($data, $configArray = null) {
		if($configArray)
		{
			$widgetOptionsString = ' ';

			foreach($configArray as $key => $value)
			{
				switch ($key) {
				    case "WidgetDelete":
				    	if($value == false)
				    	{
				        	$widgetOptionsString .= "data-widget-deletebutton=\"false\" ";
				    	}
				        break;
				    case "WidgetColor":
				    	if($value == false)
				    	{
				        	$widgetOptionsString .= "data-widget-colorbutton=\"false\" ";
				    	}
				        break;
				    case "WidgetEdit":
				    	if($value == false)
				    	{
				        	$widgetOptionsString .= "data-widget-editbutton=\"false\" ";
				    	}
				        break;
				    case "WidgetToggle":
				    	if($value == false)
				    	{
				        	$widgetOptionsString .= "data-widget-togglebutton=\"false\" ";
				    	}
				        break;
				    case "WidgetFullScreen":
				    	if($value == false)
				    	{
				        	$widgetOptionsString .= "data-widget-fullscreenbutton=\"false\" ";
				    	}
				        break;
				    case "WidgetCustom":
				    	if($value == false)
				    	{
				        	$widgetOptionsString .= "data-widget-custombutton=\"false\" ";
				    	}
				        break;
				    case "WidgetCollapse":
				    	if($value == false)
				    	{
				        	$widgetOptionsString .= "data-widget-collapsed=\"false\" ";
				    	}
				        break;
				    case "WidgetSort":
				    	if($value == false)
				    	{
				        	$widgetOptionsString .= "data-widget-sortable=\"false\" ";
				    	}
				        break;
				}
			}
		}

		echo '<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-' . rand() . '"' . (isset($widgetOptionsString) ? $widgetOptionsString: '') . '>
				<header>
					<span class="widget-icon"> <i class="fa ' . (isset($configArray['WidgetIcon']) ? $configArray['WidgetIcon'] : '') . '"></i> </span>
					<h2>' . (isset($configArray['TableTitle']) ? $configArray['TableTitle'] : 'Default') . '</h2>				
				</header>

				<!-- widget div-->
				<div>
					
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
						<input class="form-control" type="text">	
					</div>
					<!-- end widget edit box -->
					
					<!-- widget content -->
					<div class="widget-body">
						<div class="">
							<table id="' . strtolower(str_replace(" ","_",(isset($configArray['TableTitle']) ? $configArray['TableTitle'] : 'Default'))) . '" class="table-bordered table-striped table-condensed table-hover" width="100%">
							<thead><tr>';

					foreach($data['Headings'] as $heading => $icon):
							echo '<th><i class="fa fa-fw ' . $icon . ' text-muted hidden-md hidden-sm hidden-xs"></i> '. $heading . '</th>';
					endforeach;


					echo '</tr></thead>
							<tbody>';

		$numColumns = count($data['Headings']);
		//Loop through data passed from variable
		foreach ($data['data'] as $row):
		echo '<tr>';
				for($i=0;$i<$numColumns;$i++)
				{
					echo '<td>' . $row[$i] . '</td>';
				}
			echo '</tr>';
		endforeach;
							
		echo "</tbody>
							</table>
						</div>
						<!-- this is what the user will see -->

					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->";

			return strtolower(str_replace(" ","_",(isset($configArray['TableTitle']) ? $configArray['TableTitle'] : 'Default')));

    }

    public function dataTableJavaScript($tableNamesArray)
    {
    echo '<script>
	pageSetUp();

	var pagefunction = function()  {';

		foreach($tableNamesArray as $tableName):


			echo 'var responsiveHelper_dt_basic = undefined;
			
			var breakpointDefinition = {
				tablet : 1250,
				phone : 750
			};

			$("#' . $tableName . '").dataTable({
				"sDom": "<\'dt-toolbar\'<\'col-xs-12 col-sm-6\'f><\'col-sm-6 col-xs-6 hidden-xs\'l T C>r>"+
				"t"+
				"<\'dt-toolbar-footer\'<\'col-sm-6 col-xs-12 hidden-xs\'i><\'col-sm-6 col-xs-12\'p>>",
				"oTableTools": {
					"aButtons": [
					"copy",
					"csv",
					"xls",
					{
						"sExtends": "pdf",
						"sTitle": "Lead By Source Report",
						"sPdfMessage": "Tracker Export",
						"sPdfSize": "letter"
					},
					{
						"sExtends": "print",
						"sMessage": "Generated Print<i>(press Esc to close)</i>"
					}
					],
					"sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
				},
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($("#' . $tableName . '"), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});';

			endforeach;

	echo '}

		loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
				});
			});
		});
	});
</script>';
    }
}