<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">Candlestick Binance</div>
	</div>
	<div class="panel-body">
		<div class="demo-container" style="width: 100%">
			<div id="chart" style="width: 100%"></div>
		</div>		
	</div>
</div>			



<script>
var series_name="{$symbol_candle_chart}", $candle_chart;
	

{literal}	
$(function(){
    $candle_chart = $("#chart").dxChart({
        title: "Stock Price",
		
	
		
        dataSource: {}, //"http://aleney.com/crm/binance/index.php?c=iBinance&e=onTick",
        commonSeriesSettings: {
            argumentField: "date",
            type: "candlestick",
			point: {visible: false}			
        },
        legend: {
            itemTextPosition: 'left'
        },
        series: [
            { 
				name: series_name,
                openValueField: "o", 
                highValueField: "h", 
                lowValueField: "l", 
                closeValueField: "c", 
                reduction: {
                    color: "red"
                }
            },
			{
                axis: "volume",
                type: "spline",
                valueField: "trades",
                name: "Сделки",
                color: "#20ac15"
            }			
        ], 
        valueAxis: [{
            tickInterval: 1,
            title: { 
                text: "US dollars"
            },
            label: {
                format: {
                    type: "currency",
                    precision: 2
                }
            }
        },
		{
			name: "trades",
			position: "right",
			grid: {visible: true },
			title: {text: "Количество сделок"}
		}],		
        argumentAxis: {
            label: {
                format: "longTime",
				customizeText: function (data) {
					//console.info(data);
					var d = new Date (data.value);
					var hour = d.getHours(  );
					var min = d.getMinutes(  );
					var sec = d.getSeconds(  );
					if (hour == 0) hour = "00"; if (min == 0) min = "00"; if (sec == 0) sec = "00";
					
					return  hour + ':' + min + ':' + sec;
				}				
            }
        },
        "export": {
            enabled: true
        },
        tooltip: {
            enabled: true,
            location: "edge",
            customizeTooltip: function (arg) {
				if (arg.seriesName == "Сделки") hint_text = arg.originalValue + " сделок";
				else hint_text = "Open: $" + arg.openValue + "<br/>" + "Close: $" + arg.closeValue + "<br/>" + "High: $" + arg.highValue + "<br/>" + "Low: $" + arg.lowValue + "<br/>";
                
				return {text: hint_text};
            }
        }
    }).dxChart("instance");;
});	
</script>
{/literal}





<script src="{$smarty.const.ASSETS_PATH}/js/devexpress-web-14.1/js/globalize.min.js"></script>
<script src="{$smarty.const.ASSETS_PATH}/js/devexpress-web-14.1/js/dx.chartjs.js"></script>

			
<!--
			<div class="panel panel-default">
			
				<div class="panel-heading">
					<div class="panel-title">
						Basic Initialization
					</div>
				</div>
				
				<div class="panel-body">
					
					<form action="index.php" class="dropzone_wrapper" style="width: 100%;height: 400px;background-color: #efefef;"></form>
					
				</div>
				</div>
			







<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/js/dropzone/css/dropzone.css">
<script src="{$smarty.const.ASSETS_PATH}/js/dropzone/dropzone.min.js"></script>
{literal}
<script type="text/javascript">
jQuery(document).ready(function($) {
	//$example_dropzone_filetable = $("#example-dropzone-filetable"),
	$dropzone = $(".dropzone_wrapper").dropzone({
		url: 'data/upload-file.php',
		paramName: "dropzone_file", // The name that will be used to transfer the file
		maxFilesize: 20, // MB
		params: {a: 1, b: 2},
		addRemoveLinks: true,
		
		// maxFiles
		accept: function(file, done) {
			if (file.name == "justinbieber.jpg") {
				done("Naha, you don't.");
			} else { 
				done(); 
			}
		}
	});
});
</script>
{/literal}							
			-->					

