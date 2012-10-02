<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link type="text/css" rel="stylesheet" href="stylesheets/foundation.css">
<link type="text/css" rel="stylesheet" href="stylesheets/app.css">
<link type="text/css" rel="stylesheet" href="stylesheets/custom.css">
<link type="text/css" rel="stylesheet" href="stylesheets/jqueryui.css">
<link type="text/css" rel="stylesheet" href="stylesheets/jquery.dataTables.css">


<script type="text/javascript" src="http://code.anotherwayin.fr/js/foundation3/modernizr.foundation.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/foundation3/foundation.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/foundation3/app.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/jquery-ui-1.8.20.custom.min.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/graph.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/graph_export.js"></script>
<script type="text/javascript" src="<?php echo URL_SITE;?>javascripts/jquery.dataTables.min.js"></script>

    <script type="text/javascript">

(function($){ // encapsulate jQuery

$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: 'Stacked column chart'
            },
            xAxis: {
                categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total fruit consumption'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -100,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: 'John',
                data: [5, 3, 4, 7, 2]
            }, {
                name: 'Jane',
                data: [2, 2, 3, 2, 1]
            }, {
                name: 'Joe',
                data: [3, 4, 4, 2, 5]
            }]
        });
    });
    
});
})(jQuery);
</script>
</head>

		


 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Another way in - Votre espace client</title>
</head>
<body>
   <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
   <div>dis 
   quelquechose au moins</div>
      	
</body></html>