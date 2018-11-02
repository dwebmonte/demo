{literal}
<style>
	.pies-container {
    margin: auto;
    width: 800px;
}

.pies-container > div {
    width: 400px;
    float: left;
}
</style>
{/literal}

<div class="panel panel-default panel-border">
	<div class="panel-heading">Линейные</div>
	<div class="panel-body">
		<div class="demo-container">
			<div id="chart"></div>
		</div>
	</div>
</div>

<div class="panel panel-default panel-border">
	<div class="panel-heading">Гистограммы</div>
	<div class="panel-body">
		<div class="demo-container">
			<div id="chart2"></div>
		</div>
	</div>
</div>

<div class="panel panel-default panel-border">
	<div class="panel-heading">Диаграммы</div>
	<div class="panel-body">
		<div class="demo-container">
			<div class="pies-container">
				<div id="countries"></div>
				<div id="waterLandRatio"></div>
			</div>
		</div>	
	</div>
</div>


<div class="panel panel-default panel-border">
	<div class="panel-heading">Точечные</div>
	<div class="panel-body">
		 <div class="demo-container">
			<div id="chart1"></div>
		</div>

	
	
	
	</div>
</div>


{literal}
<script>
	
	
	
$(function(){
var dataSource = [{
    state: "Illinois",
    year1998: 423.721,
    year2001: 476.851,
    year2004: 528.904
}, {
    state: "Indiana",
    year1998: 178.719,
    year2001: 195.769,
    year2004: 227.271
}, {
    state: "Michigan",
    year1998: 308.845,
    year2001: 335.793,
    year2004: 372.576
}, {
    state: "Ohio",
    year1998: 348.555,
    year2001: 374.771,
    year2004: 418.258
}, {
    state: "Wisconsin",
    year1998: 160.274,
    year2001: 182.373,
    year2004: 211.727
}];	
	
    $("#chart").dxChart({
        dataSource: dataSource,
        commonSeriesSettings: {
            argumentField: "state",
            type: "spline",
            hoverMode: "includePoints",
            point: {
                hoverMode: "allArgumentPoints"
            }
        },
        series: [
            { valueField: "year2004", name: "2004" },
            { valueField: "year2001", name: "2001" },
            { valueField: "year1998", name: "1998" }
        ],
        title: {
            text: "Great Lakes Gross State Product"
        },
        "export": {
            enabled: true
        },
        legend: {
            verticalAlignment: "bottom",
            horizontalAlignment: "center",
            hoverMode: "excludePoints"
        }
    });
});
	
	
$(function(){
var dataSource = [{
    state: "Germany",
    young: 6.7,
    middle: 28.6,
    older: 5.1
}, {
    state: "Japan",
    young: 9.6,
    middle: 43.4,
    older: 9
}, {
    state: "Russia",
    young: 13.5,
    middle: 49,
    older: 5.8
}, {
    state: "USA",
    young: 30,
    middle: 90.3,
    older: 14.5
}];	
	
	
    $("#chart2").dxChart({
        dataSource: dataSource,
        commonSeriesSettings: {
            argumentField: "state",
            type: "stackedBar"
        },
        series: [
            { valueField: "young", name: "0-14" },
            { valueField: "middle", name: "15-64" },
            { valueField: "older", name: "65 and older" }
        ],
        legend: {
            verticalAlignment: "bottom",
            horizontalAlignment: "center",
            itemTextPosition: 'top'
        },
        valueAxis: {
            title: {
                text: "millions"
            },
            position: "right"
        },
        title: "Male Age Structure",
        "export": {
            enabled: true
        },
        tooltip: {
            enabled: true,
            location: "edge",
            customizeTooltip: function (arg) {
                return {
                    text: arg.seriesName + " years: " + arg.valueText
                };
            }
        }
    });
});	
	
	
	
	
	
	
	
	
	
	
	
	
$(function(){
	
	
	
	
var dataSource = [{
    total1: 9.5,
    total2: 168.8,
    total3: 127.2,
    older1: 2.4,
    older2: 8.8,
    older3: 40.1,
    perc1: 25.4,
    perc2: 5.3,
    perc3: 31.6,
    tag1: 'Sweden',
    tag2: 'Nigeria',
    tag3: 'Japan'
}, {
    total1: 82.8,
    total2: 91.7,
    total3: 90.8,
    older1: 21.9,
    older2: 4.6,
    older3: 8.0,
    perc1: 26.7,
    perc2: 5.4,
    perc3: 8.9,
    tag1: 'Germany',
    tag2: 'Ethiopia',
    tag3: 'Viet Nam'
}, {
    total1: 16.7,
    total2: 80.7,
    total3: 21.1,
    older1: 3.8,
    older2: 7.0,
    older3: 2.7,
    perc1: 22.8,
    perc2: 8.4,
    perc3: 12.9,
    tag1: 'Netherlands',
    tag2: 'Egypt',
    tag3: 'Sri Lanka'
}, {
    total1: 62.8,
    total2: 52.4,
    total3: 96.7,
    older1: 14.4,
    older2: 4.0,
    older3: 5.9,
    perc1: 23.0,
    perc2: 7.8,
    perc3: 6.1,
    tag1: 'United Kingdom',
    tag2: 'South Africa',
    tag3: 'Philippines'
}, {
    total1: 38.2,
    total2: 43.2,
    total3: 66.8,
    older1: 7.8,
    older2: 1.8,
    older3: 9.6,
    perc1: 20.4,
    perc2: 4.3,
    perc3: 13.7,
    tag1: 'Poland',
    tag2: 'Kenya',
    tag3: 'Thailand'
}, {
    total1: 45.5,
    total3: 154.7,
    total4: 34.8,
    older1: 9.5,
    older3: 10.3,
    older4: 7.2,
    perc1: 21.1,
    perc3: 6.8,
    perc4: 20.8,
    tag1: 'Ukraine',
    tag3: 'Bangladesh',
    tag4: 'Canada'
}, {
    total1: 143.2,
    total4: 120.8,
    older1: 26.5,
    older4: 11.0,
    perc1: 18.6,
    perc4: 9.5,
    tag1: 'Russian Federation',
    tag4: 'Mexico'
}];	
	
    $("#chart1").dxChart({
        dataSource: dataSource,
        commonSeriesSettings: {
            type: 'bubble'
        },
        title: 'Correlation between Total Population and\n Population with Age over 60',
        tooltip: {
            enabled: true,
            location: "edge",
            customizeTooltip: function (arg) {
                return {
                    text: arg.point.tag + '<br/>Total Population: ' + arg.argumentText + 'M <br/>Population with Age over 60: ' + arg.valueText + 'M (' + arg.size + '%)'
                };
            }
        },
        argumentAxis: {
            label: {
                customizeText: function () {
                    return this.value + 'M';
                }
            },
            title: 'Total Population'
        },
        valueAxis: {
            label: {
                customizeText: function () {
                    return this.value + 'M';
                }
            },
            title: 'Population with Age over 60'
        },
        legend: {
            position: 'inside',
            horizontalAlignment: 'left',
            border: {
                visible: true
            }
        },
        palette: ["#00ced1", "#008000", "#ffd700", "#ff7f50"],
        onSeriesClick: function(e) {
            var series = e.target;
            if (series.isVisible()) {
                series.hide();
            } else {
                series.show();
            }
        },
        "export": {
            enabled: true
        },
        series: [{
            name: 'Europe',
            argumentField: 'total1',
            valueField: 'older1',
            sizeField: 'perc1',
            tagField:'tag1'
        }, {
            name: 'Africa',
            argumentField: 'total2',
            valueField: 'older2',
            sizeField: 'perc2',
            tagField: 'tag2'
        }, {
            name: 'Asia',
            argumentField: 'total3',
            valueField: 'older3',
            sizeField: 'perc3',
            tagField: 'tag3'
        }, {
            name: 'North America',
            argumentField: 'total4',
            valueField: 'older4',
            sizeField: 'perc4',
            tagField: 'tag4'
        }]
    });
});	
	
	
	
	
	
	
	
	
	
	
	
$(function () {
var waterLandRatio = [{
    name: 'Land',
    area: 0.29
}, {
    name: 'Water',
    area: 0.71
}];

var countries = [{
    name: "Russia",
    area: 0.12
}, {
    name: "Canada",
    area: 0.07
}, {
    name: "USA",
    area: 0.07
}, {
    name: "China",
    area: 0.07
}, {
    name: "Brazil",
    area: 0.06
}, {
    name: "Australia",
    area: 0.05
}, {
    name: "India",
    area: 0.02
}, {
    name: "Others",
    area: 0.55
}];	
	
    var legendSettings = {
        verticalAlignment: 'bottom',
        horizontalAlignment: 'center',
        itemTextPosition: 'right',
        rowCount: 2
    },
        seriesOptions = [{
            argumentField: "name",
            valueField: "area",
            label: {
                visible: true,
                format: "percent"
            }
    }],
        sizeGroupName = "piesGroup";

    $("#countries").dxPieChart({
        dataSource: countries,
        sizeGroup: sizeGroupName,
        palette: "Soft",
        title: "Area of Countries",
        legend: legendSettings,
        series: seriesOptions
    });

    $("#waterLandRatio").dxPieChart({
        sizeGroup: sizeGroupName,
        palette: "Soft Pastel",
        title: "Water/Land Ratio",
        legend: legendSettings,
        dataSource: waterLandRatio,
        series: seriesOptions
    });
});
</script>
{/literal}